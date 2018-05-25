<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Rent_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
    }

    public function get_rentdata($value='')
    {
        $sql = "Select rt.*,pt.*, case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from rent_txn rt
                left join property_txn pt on rt.txn_id=pt.property_txn_id
                left join rent_tenant_details  rd on rt.txn_id=rd.rent_id
                left join contact_master A on (rd.contact_id=A.c_id)
                left join contact_master B on (A.c_contact_id=B.c_id)";
        $query=$this->db->query();        
    }

    /*function rentData($status='',$property_id='',$r_id='',$contact_id='',$property_type_id=''){
        if($status=='All'){
            $cond="";
            $cond3="";
        } else if($status=='InProcess'){
            $status='In Process';
            $cond="and E.txn_status='In Process'";
            $cond3="where E.txn_status='In Process'";
        } else if($status=='Pending'){
            $cond="and (E.txn_status='Pending' or E.txn_status='Delete')";
            $cond3="where (E.txn_status='Pending' or E.txn_status='Delete')";
        } else {
            $cond="and E.txn_status='$status'";
            $cond3="where E.txn_status='$status'";
        }

        if($contact_id!=""){
            if($cond==""){
                $cond = " and E.contact_id='$contact_id'";
            } else {
                $cond = $cond . " and E.contact_id='$contact_id'";
            }

            if($cond3==""){
                $cond3 = " where E.contact_id='$contact_id'";
            } else {
                $cond3 = $cond3 . " and E.contact_id='$contact_id'";
            }
        }

        if($property_id!=""){
            $cond2=" and property_id='" . $property_id . "'";
        } else {
            $cond2="";
        }

        if($r_id!=""){
            $cond2=" and txn_id='" . $r_id . "'";
        }

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $sql="select * from 
                (select C.*, D.contact_id, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1 from 
                (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                    B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                    B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                (select A.*, B.sp_name from 
                (select * from rent_txn where gp_id = '$gid' and 
                    property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id'))" . $cond2 . ") A
                left join 
                (select A.*, B.purchase_price from 
                (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                    from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) 
                    where A.gp_id='$gid') A 
                left join 
                (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                on A.txn_id = B.purchase_id) B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select * FROM rent_tenant_details A where A.contact_id in (select min(contact_id) from rent_tenant_details 
                    where rent_id = A.rent_id and contact_id in (select distinct owner_id from user_role_owners 
                    where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.contact_id=B.c_id)) D 
                on C.txn_id=D.rent_id) E 
                where E.owner_name is not null and E.owner_name<>'' " . $cond;
        } else {
            $sql="select * from 
                (select C.*, D.contact_id, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1 from 
                (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                    B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                    B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                (select A.*, B.sp_name from 
                (select * from rent_txn where gp_id = '$gid' " . $cond2 . ") A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) A 
                left join 
                (select A.*, B.purchase_price from 
                (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                    from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) 
                    where A.gp_id='$gid') A 
                left join 
                (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                on A.txn_id = B.purchase_id) B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select * FROM rent_tenant_details A where A.contact_id in (select min(contact_id) from rent_tenant_details 
                    where rent_id = A.rent_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.contact_id=B.c_id)) D 
                on C.txn_id=D.rent_id) E " . $cond3;
        }

        $query=$this->db->query($sql);
        // echo $this->db->last_query();
        return $query->result();
    }*/

    function getAllCountData($contact_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $cond = "";
        if($contact_id!=""){
            $cond = " where E.contact_id='$contact_id'";
        }

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $sql="select * from 
                (select C.txn_id, D.contact_id, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1, C.c_name, C.property_id, C.gp_id, C.rent_amount, 
                C.possession_date, C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
                (select A.txn_id, A.property_id, A.tenant_id, A.gp_id, A.rent_amount, A.possession_date, 
                    A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from rent_txn where gp_id = '$gid' and 
                    property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id'))) A 
                left join 
                (select * from purchase_txn where gp_id = '$gid') B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select * from rent_tenant_details A where A.contact_id in (select min(contact_id) from rent_tenant_details 
                    where rent_id = A.rent_id and contact_id in (select distinct owner_id from user_role_owners 
                    where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.contact_id=B.c_id)) D 
                on C.txn_id=D.rent_id) E" . $cond;
        } else {
            $sql="select * from 
                (select C.txn_id, D.contact_id, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1, C.property_id, C.gp_id, C.rent_amount, 
                C.possession_date, C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
                (select A.txn_id, A.property_id, A.tenant_id, A.gp_id, A.rent_amount, A.possession_date, 
                    A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from rent_txn where gp_id = '$gid') A 
                left join 
                (select * from purchase_txn where gp_id = '$gid') B 
                on A.property_id=B.txn_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select * from rent_tenant_details A where A.contact_id in (select min(contact_id) from rent_tenant_details 
                    where rent_id = A.rent_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.contact_id=B.c_id)) D 
                on C.txn_id=D.rent_id) E" . $cond;
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    // function getAllTaxes(){
    // 	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
    // 	$this->db->where('status = "1" and txn_type = "Rent"  and tax_action="1"');
    // 	$this->db->from('tax_master');
    // 	$result=$this->db->get();
    // 	return $result->result();
    // }

    function getAllTaxes($txn_type){
        $this->db->select('tax_id,tax_name,tax_percent,txn_type');
        $this->db->where('status = "1" and tax_action="1"');
        if($txn_type !=''){
            $this->db->where('txn_type like "%'.$txn_type.'%" ');
        }
        else{
            $this->db->where('txn_type like "%Rent%" ');
        }
        $this->db->from('tax_master');
        $result=$this->db->get();
        //echo $this->db->last_query();
        return $result->result();
    }

    function getAccess(){
    	$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
        $result=$query->result();
        return $result;
    }

    function insert_schedule($rent_id, $event_type, $event_name, $event_date, $basic_cost, $net_amount, $txn_status, $tax_amount, $tds_amount){
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d');

        if($txn_status=='Approved'){
            $sch_status = '1';
        } else {
            $sch_status = '3';
        }

        $data = array(
                'rent_id' => $rent_id,
                'event_type' => $event_type,
                'event_name' => $event_name,
                'event_date' => $event_date,
                'basic_cost' => $basic_cost,
                'net_amount' => $net_amount,
                'create_date' => $now,
                'create_by' => $curusr,
                'sch_status' => $sch_status,
                'status' => $sch_status,
                'tax_amount' => $tax_amount,
                'tds_amount' => $tds_amount
            );

        // echo json_encode($data);
        // echo '<br/>';
        // return 1;

        $this->db->insert('rent_schedule', $data);
        return $this->db->insert_id();
    }

    function insert_schedule_tax($scid, $rent_id, $event_type, $tax_id, $tax_name, $gst_rate, $tax_amount, $txn_status){

        if($txn_status=='Approved'){
            $sch_status = '1';
        } else {
            $sch_status = '3';
        }

        $data = array(
                    'sch_id' => $scid,
                    'event_type' => $event_type,
                    'tax_master_id'=> $tax_id,
                    'tax_type' => $tax_name,
                    'tax_percent' => $gst_rate,
                    'tax_amount' => $tax_amount,
                    'rent_id' => $rent_id,
                    'status' => $sch_status
                );

        // echo json_encode($data);
        // echo '<br/>';

        $this->db->insert('rent_schedule_taxation', $data);
    }

    function setSchedule($rent_id, $txn_status){
        $sql = "select * from rent_txn  where txn_id = '$rent_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $rent_id = $result[0]->txn_id;

            if(is_numeric($result[0]->deposit_amount)){
                $deposit_amount = floatval($result[0]->deposit_amount);
            } else {
                $deposit_amount = 0;
            }

            $invoice_issuer = $result[0]->invoice_issuer;
            $possession_date = $result[0]->possession_date;
            $termination_date = $result[0]->termination_date;

            if($deposit_amount!=0)    
                $this->insert_schedule($rent_id, 'Deposit', 'Deposit', $possession_date, $deposit_amount, $deposit_amount, $txn_status, 0, 0);

            $invoice_date = $result[0]->invoice_date;
            $schedule = $result[0]->schedule;
            $gst = $result[0]->gst;

            $gst_rate = 0;
            $tax_name = '';
            if($gst=='1'){
                $tax_id = $result[0]->gst_rate;

                if($tax_id!='' && $tax_id!=null){
                    $sql = "select * from tax_master where tax_id = '$tax_id'";
                    $query = $this->db->query($sql);
                    $result2 = $query->result();
                    if(count($result2)>0){
                        if(is_numeric($result2[0]->tax_percent)){
                            $gst_rate = floatval($result2[0]->tax_percent);
                            $tax_name = $result2[0]->tax_name;
                        }
                    }
                }
            }
            if($gst_rate=='' || $gst_rate==null){
                $gst_rate=0;
            }

            $tds = $result[0]->tds;
            $tds_rate = 0;
            if($tds=='1'){
                if(is_numeric($result[0]->tds_rate)){
                    $tds_rate = floatval($result[0]->tds_rate);
                }
            }
            if($tds_rate=='' || $tds_rate==null){
                $tds_rate=0;
            }

            $lease = $result[0]->locking_period;
            if(is_numeric($result[0]->rent_amount)){
                $rent = floatval($result[0]->rent_amount);
            } else {
                $rent = 0;
            }

            if($possession_date!="" && $possession_date!=null){
                $stdt = DateTime::createFromFormat('Y-m-d', $possession_date);
            } else {
                $stdt = null;
            }
            if($termination_date!="" && $termination_date!=null){
                $endt = DateTime::createFromFormat('Y-m-d', $termination_date);
            } else {
                $endt = null;
            }

            if(is_numeric($result[0]->rent_due_day)){
                $duedy = intval($result[0]->rent_due_day);
            } else {
                $duedy = 0;
            }
            if ($duedy==0) $duedy=1;

            $amt2 = round($rent);

            $tmpdt = $stdt;
            $yy=null;
            $mm=null;
            if($possession_date!="" && $possession_date!=null){
                $mm = $stdt->format("m");
                $yy = $stdt->format("Y");
            }

            $increment = 1;
            if($schedule=='Monthly'){
                $increment = 1;
            } else if($schedule=='Quarterly'){
                $increment = 3;
                $lease = ceil($lease / 3);
                $amt2 = $amt2 * 3;
            } else if($schedule=='Yearly'){
                $increment = 12;
                $lease = ceil($lease / 12);
                $amt2 = $amt2 * 12;
            }

            $i=0;
            $schedule_id=1;

            // $sql = "update rent_schedule set sch_status='2', status='2' where rent_id = '$rent_id' and event_type = 'Rent' and status = '1' and 
            //         (invoice_no is null or invoice_no='')";
            // $this->db->query($sql);

            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rent_id'");
            $result2=$query->result();
            if (count($result2)>0){
                $txn_fkid = $result2[0]->txn_fkid;
            }

            if($txn_fkid!=''){
                $check_id=$txn_fkid;
            } else {
                $check_id=$rent_id;
            }

            $last_event_date = '';
            $sql = "select max(event_date) as last_event_date from rent_schedule where rent_id = '$check_id' and event_type = 'Rent' and 
                    status = '1' and (invoice_no is not null and invoice_no<>'')";
            $query = $this->db->query($sql);
            $result2 = $query->result();
            if(count($result2)>0){
                $last_event_date = $result2[0]->last_event_date;

                if(isset($last_event_date)){
                    if($last_event_date!=''){
                        $last_event_date = DateTime::createFromFormat('Y-m-d', $last_event_date);
                    }
                }
            }

            $escalation = array();
            $sql = "select esc_date, escalation from rent_escalation_details where rent_id = '$rent_id' order by esc_date";
            $query = $this->db->query($sql);
            $result2 = $query->result();
            if(count($result2)>0){
                for($i=0; $i<count($result2); $i++){
                    $escalation[$i]['esc_date'] = $result2[$i]->esc_date;
                    $escalation[$i]['escalation'] = $result2[$i]->escalation;
                    $escalation[$i]['esc_done'] = false;
                }
            }

            for ($i = 0; $i < $lease; $i++) {
                if($mm==13){
                    $mm=1;
                    $yy++;
                } else if($mm==14){
                    $mm=2;
                    $yy++;
                } else if($mm==15){
                    $mm=3;
                    $yy++;
                } else if($mm==16){
                    $mm=4;
                    $yy++;
                } else if($mm==17){
                    $mm=5;
                    $yy++;
                } else if($mm==18){
                    $mm=6;
                    $yy++;
                } else if($mm==19){
                    $mm=7;
                    $yy++;
                } else if($mm==20){
                    $mm=8;
                    $yy++;
                } else if($mm==21){
                    $mm=9;
                    $yy++;
                } else if($mm==22){
                    $mm=10;
                    $yy++;
                } else if($mm==23){
                    $mm=11;
                    $yy++;
                } else if($mm==24){
                    $mm=12;
                    $yy++;
                }

                $abc = $yy.'-'.$mm.'-'.$duedy;

                if($mm==2){
                    if($duedy>28){
                        if($yy%4==0){
                            $abc = $yy.'-'.$mm.'-29';
                        } else {
                            $abc = $yy.'-'.$mm.'-28';
                        }
                    }
                } else if($mm==4 || $mm==6 || $mm==9 || $mm==11){
                    if($duedy>30){
                        $abc = $yy.'-'.$mm.'-30';
                    }
                }

                $mm = $mm + $increment;

                $check_date = DateTime::createFromFormat('Y-m-d', $abc);

                $bl_insert = true;
                if($last_event_date!=''){
                    if($check_date<=$last_event_date){
                        $bl_insert = false;
                    }
                }
                
                if($bl_insert==true){
                    for($j=0; $j<count($escalation); $j++){
                        if($escalation[$j]['esc_done']==false){
                            $esc_date = $escalation[$j]['esc_date'];
                            $esc_per = $escalation[$j]['escalation'];

                            if($esc_per==null || $esc_per==''){
                                $esc_per = 0;
                            }

                            if(isset($esc_date)){
                                if($esc_date!=''){
                                    $esc_date = DateTime::createFromFormat('Y-m-d', $esc_date);

                                    if($esc_date<$check_date){
                                        $amt2 = $amt2 + ($amt2*$esc_per/100);
                                        $amt2 = ceil($amt2);

                                        $escalation[$j]['esc_done'] = true;
                                    }
                                }
                            }
                        }
                    }

                    $event_type = 'Rent';
                    $event_name = 'Rent';
                    $basic_cost = $amt2;

                    $day = date('d', strtotime($abc));
                    $month = date('m', strtotime($abc));
                    $year = date('Y', strtotime($abc));
                    $event_date = $year.'-'.$month.'-'.$day;

                    // $tax_amount = round($basic_cost*$gst_rate/100,2);
                    // $net_amount = round($basic_cost + $tax_amount);

                    $basic_cost = round($basic_cost/(1+($gst_rate/100)));
                    $tax_amount = round($amt2-$basic_cost);
                    $net_amount = round($amt2);
                    $tds_amount = round($basic_cost*$tds_rate/100);

                    $scid = $this->insert_schedule($rent_id, $event_type, $event_name, $event_date, $basic_cost, $net_amount, $txn_status, $tax_amount, $tds_amount);

                    if($tax_amount>0){
                        $this->insert_schedule_tax($scid, $rent_id, $event_type, $tax_id, $tax_name, $gst_rate, $tax_amount, $txn_status);
                    }
                }
            }
        }
    }

    function setOtherSchedule($rent_id, $txn_status){
        $sql = "select * from rent_txn  where txn_id = '$rent_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $rent_id = $result[0]->txn_id;

            $possession_date = $result[0]->possession_date;
            $termination_date = $result[0]->termination_date;
            $lease = $result[0]->locking_period;

            $sql = "select * from rent_other_amt_details where rent_id = '$rent_id' order by id";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                for($x=0; $x<count($result); $x++){
                    $invoice_issuer = $result[$x]->invoice_issuer;

                    $invoice_date = $result[$x]->invoice_date;
                    $schedule = $result[$x]->schedule;
                    $gst = $result[$x]->gst;
                    $event_name = $result[$x]->event_name;

                    $gst_rate = 0;
                    $tax_name = '';
                    if($gst=='1'){
                        $tax_id = $result[$x]->gst_rate;

                        if($tax_id!='' && $tax_id!=null){
                            $sql = "select * from tax_master where tax_id = '$tax_id'";
                            $query = $this->db->query($sql);
                            $result2 = $query->result();
                            if(count($result2)>0){
                                if(is_numeric($result2[0]->tax_percent)){
                                    $gst_rate = floatval($result2[0]->tax_percent);
                                    $tax_name = $result2[0]->tax_name;
                                }
                            }
                        }
                    }
                    if($gst_rate=='' || $gst_rate==null){
                        $gst_rate=0;
                    }

                    $tds = $result[$x]->tds;
                    $tds_rate = 0;
                    if($tds=='1'){
                        if(is_numeric($result[$x]->tds_rate)){
                            $tds_rate = floatval($result[$x]->tds_rate);
                        }
                    }
                    if($tds_rate=='' || $tds_rate==null){
                        $tds_rate=0;
                    }
                    
                    if(is_numeric($result[$x]->amount)){
                        $rent = floatval($result[$x]->amount);
                    } else {
                        $rent = 0;
                    }

                    if($possession_date!="" && $possession_date!=null){
                        $stdt = DateTime::createFromFormat('Y-m-d', $possession_date);
                    } else {
                        $stdt = null;
                    }
                    if($termination_date!="" && $termination_date!=null){
                        $endt = DateTime::createFromFormat('Y-m-d', $termination_date);
                    } else {
                        $endt = null;
                    }

                    if(is_numeric($result[$x]->due_day)){
                        $duedy = intval($result[$x]->due_day);
                    } else {
                        $duedy = 0;
                    }
                    if ($duedy==0) $duedy=1;

                    $amt2 = round($rent);

                    $tmpdt = $stdt;
                    $yy=null;
                    $mm=null;
                    if($possession_date!="" && $possession_date!=null){
                        $mm = $stdt->format("m");
                        $yy = $stdt->format("Y");
                    }

                    $increment = 1;
                    if($schedule=='Monthly'){
                        $increment = 1;
                    } else if($schedule=='Quarterly'){
                        $increment = 3;
                        $lease = ceil($lease / 3);
                        $amt2 = $amt2 * 3;
                    } else if($schedule=='Yearly'){
                        $increment = 12;
                        $lease = ceil($lease / 12);
                        $amt2 = $amt2 * 12;
                    }

                    $i=0;
                    $schedule_id=1;

                    // $sql = "update rent_schedule set sch_status='2', status='2' where rent_id = '$rent_id' and event_name = '$event_name' and status = '1' and 
                    //         (invoice_no is null or invoice_no='')";
                    // $this->db->query($sql);

                    $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rent_id'");
                    $result2=$query->result();
                    if (count($result2)>0){
                        $txn_fkid = $result2[0]->txn_fkid;
                    }

                    if($txn_fkid!=''){
                        $check_id=$txn_fkid;
                    } else {
                        $check_id=$rent_id;
                    }

                    $last_event_date = '';
                    $sql = "select max(event_date) as last_event_date from rent_schedule where rent_id = '$check_id' and event_name = '$event_name' and 
                            status = '1' and (invoice_no is not null and invoice_no<>'')";
                    $query = $this->db->query($sql);
                    $result2 = $query->result();
                    if(count($result2)>0){
                        $last_event_date = $result2[0]->last_event_date;

                        if(isset($last_event_date)){
                            if($last_event_date!=''){
                                $last_event_date = DateTime::createFromFormat('Y-m-d', $last_event_date);
                            }
                        }
                    }

                    $escalation = array();
                    $sql = "select esc_date, escalation from rent_escalation_details where rent_id = '$rent_id' order by esc_date";
                    $query = $this->db->query($sql);
                    $result2 = $query->result();
                    if(count($result2)>0){
                        for($i=0; $i<count($result2); $i++){
                            $escalation[$i]['esc_date'] = $result2[$i]->esc_date;
                            $escalation[$i]['escalation'] = $result2[$i]->escalation;
                            $escalation[$i]['esc_done'] = false;
                        }
                    }

                    for ($i = 0; $i < $lease; $i++) {
                        if($mm==13){
                            $mm=1;
                            $yy++;
                        } else if($mm==14){
                            $mm=2;
                            $yy++;
                        } else if($mm==15){
                            $mm=3;
                            $yy++;
                        } else if($mm==16){
                            $mm=4;
                            $yy++;
                        } else if($mm==17){
                            $mm=5;
                            $yy++;
                        } else if($mm==18){
                            $mm=6;
                            $yy++;
                        } else if($mm==19){
                            $mm=7;
                            $yy++;
                        } else if($mm==20){
                            $mm=8;
                            $yy++;
                        } else if($mm==21){
                            $mm=9;
                            $yy++;
                        } else if($mm==22){
                            $mm=10;
                            $yy++;
                        } else if($mm==23){
                            $mm=11;
                            $yy++;
                        } else if($mm==24){
                            $mm=12;
                            $yy++;
                        }

                        $abc = $yy.'-'.$mm.'-'.$duedy;

                        if($mm==2){
                            if($duedy>28){
                                if($yy%4==0){
                                    $abc = $yy.'-'.$mm.'-29';
                                } else {
                                    $abc = $yy.'-'.$mm.'-28';
                                }
                            }
                        } else if($mm==4 || $mm==6 || $mm==9 || $mm==11){
                            if($duedy>30){
                                $abc = $yy.'-'.$mm.'-30';
                            }
                        }

                        $mm = $mm + $increment;

                        $check_date = DateTime::createFromFormat('Y-m-d', $abc);

                        $bl_insert = true;
                        if($last_event_date!=''){
                            if($check_date<=$last_event_date){
                                $bl_insert = false;
                            }
                        }
                        
                        if($bl_insert==true){
                            for($j=0; $j<count($escalation); $j++){
                                if($escalation[$j]['esc_done']==false){
                                    $esc_date = $escalation[$j]['esc_date'];
                                    $esc_per = $escalation[$j]['escalation'];

                                    if($esc_per==null || $esc_per==''){
                                        $esc_per = 0;
                                    }

                                    if(isset($esc_date)){
                                        if($esc_date!=''){
                                            $esc_date = DateTime::createFromFormat('Y-m-d', $esc_date);

                                            if($esc_date<$check_date){
                                                $amt2 = $amt2 + ($amt2*$esc_per/100);
                                                $amt2 = ceil($amt2);

                                                $escalation[$j]['esc_done'] = true;
                                            }
                                        }
                                    }
                                }
                            }

                            $event_type = 'Other';
                            $event_name = $event_name;
                            $basic_cost = $amt2;

                            $day = date('d', strtotime($abc));
                            $month = date('m', strtotime($abc));
                            $year = date('Y', strtotime($abc));
                            $event_date = $year.'-'.$month.'-'.$day;

                            $tax_amount = round($basic_cost*$gst_rate/100,2);
                            $net_amount = round($basic_cost + $tax_amount);

                            $basic_cost = round($basic_cost/(1+($gst_rate/100)));
                            $tax_amount = round($amt2-$basic_cost);
                            $net_amount = round($amt2);
                            $tds_amount = round($basic_cost*$tds_rate/100);

                            $scid = $this->insert_schedule($rent_id, $event_type, $event_name, $event_date, $basic_cost, $net_amount, $txn_status, $tax_amount, $tds_amount);

                            if($tax_amount>0){
                                $this->insert_schedule_tax($scid, $rent_id, $event_type, $tax_id, $tax_name, $gst_rate, $tax_amount, $txn_status);
                            }
                        }
                    }
                }
            }
        }
    }

    function insertSchedule($pid, $txn_status){
        //echo "hi";
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
    	// $sch_type=$this->input->post('sch_type');
    	$sch_event=$this->input->post('sch_event');
        $sch_date=$this->input->post('sch_date');
        $sch_basiccost=$this->input->post('sch_basiccost');
        // print_r($sch_event);

        if($txn_status=='Approved'){
            $sch_status = '1';
        } else {
            $sch_status = '3';
        }

        for ($i=0; $i < count($sch_event) ; $i++) {
            //echo "date".$sch_date[$i];

            if($sch_date[$i]==NULL){
                $scdt=NULL;
            } else {
                //echo $sch_date[$i];
                $scdt=formatdate($sch_date[$i]);
                //exit;
            }

            $sch_tax='';
            $sch_tax=$this->input->post('sch_tax_'.($i+1));
            //   print_r($sch_tax); echo "<br>".($i+1)."<br>";
            $sch_basiccost[$i]=format_number($sch_basiccost[$i],2);
            if(count($sch_tax) > 0){
                $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);

                $data = array(
                    'rent_id' => $pid ,
                    // 'event_type'=>$sch_type[$i],
                    'event_type'=>$sch_event[$i],
                    'event_name' => $sch_event[$i],
                    'event_date' => $scdt ,
                    'basic_cost' => $sch_basiccost[$i] ,
                    'net_amount' => $tax_detail["netamount"],
                    'create_date' => date('Y-m-d'),
                    'create_by' => $curusr,
                    'sch_status'=>$sch_status,
                    'status'=>$sch_status
                );
            }
            else{
                $data = array(
                    'rent_id' => $pid ,
                    // 'event_type'=>$sch_type[$i],
                    'event_type'=>$sch_event[$i],
                    'event_name' => $sch_event[$i],
                    'event_date' => $scdt ,
                    'basic_cost' => $sch_basiccost[$i],
                    'net_amount' => $sch_basiccost[$i],
                    'create_date' => date('Y-m-d'),
                    'create_by' => $curusr,
                    'sch_status'=>$sch_status,
                    'status'=>$sch_status
                );
            }
            $this->db->insert('rent_schedule', $data);
            $scid=$this->db->insert_id();
            if(count($sch_tax) > 0){
                $j=0;
                foreach($tax_detail['tax_detail'] as $row){
                    $data = array(
                    'sch_id' => $scid,
                    'event_type' => $sch_event[$i],
                    'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                    'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                    'tax_percent' => $tax_detail['tax_detail'][$j]['tax_percent'],
                    'tax_amount' => $tax_detail['tax_detail'][$j]['tax_amount'],
                    'rent_id' => $pid,
                    'status'=>$sch_status
                     );
                    $this->db->insert('rent_schedule_taxation', $data);  
                    $j++;
                }
            }
        }
    }

    function revenueSchedule($rent_id,$property_id)
    {
        $sql = "select * from rent_txn  where txn_id = '$rent_id'";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            $rent_id = $result[0]->txn_id;

            $possession_date = $result[0]->possession_date;
            $termination_date = $result[0]->termination_date;
            $lease = $result[0]->locking_period;
            $schedule = $result[0]->schedule;
            $rent_due_by = $result[0]->revenue_due_day;
            $increment = 1;
            if($schedule=='Monthly'){
                $increment = 1;
            } else if($schedule=='Quarterly'){
                $increment = 3;
                $lease = ceil($lease / 3);
                $amt2 = $amt2 * 3;
            } else if($schedule=='Yearly'){
                $increment = 12;
                $lease = ceil($lease / 12);
                $amt2 = $amt2 * 12;
            }

                    $i=0;
                    $schedule_id=1;

            if($possession_date!="" && $possession_date!=null){
                $stdt = DateTime::createFromFormat('Y-m-d', $possession_date);
            } else {
                $stdt = null;
            }
            if($termination_date!="" && $termination_date!=null){
                $endt = DateTime::createFromFormat('Y-m-d', $termination_date);
            } else {
                $endt = null;
            }        

            $yy=null;
            $mm=null;

            if($possession_date!="" && $possession_date!=null){
                $mm = $stdt->format("m");
                $yy = $stdt->format("Y");
            }
            $increment = 1;

            for ($i = 0; $i < $lease; $i++) {
                    if($mm==13){
                        $mm=1;
                        $yy++;
                    } else if($mm==14){
                        $mm=2;
                        $yy++;
                    } else if($mm==15){
                        $mm=3;
                        $yy++;
                    } else if($mm==16){
                        $mm=4;
                        $yy++;
                    } else if($mm==17){
                        $mm=5;
                        $yy++;
                    } else if($mm==18){
                        $mm=6;
                        $yy++;
                    } else if($mm==19){
                        $mm=7;
                        $yy++;
                    } else if($mm==20){
                        $mm=8;
                        $yy++;
                    } else if($mm==21){
                        $mm=9;
                        $yy++;
                    } else if($mm==22){
                        $mm=10;
                        $yy++;
                    } else if($mm==23){
                        $mm=11;
                        $yy++;
                    } else if($mm==24){
                        $mm=12;
                        $yy++;
                    }

                    echo $abc = $yy.'-'.$mm.'-'.$rent_due_by;

                    if($mm==2){
                        if($rent_due_by>28){
                            if($yy%4==0){
                                $abc = $yy.'-'.$mm.'-29';
                            } else {
                                $abc = $yy.'-'.$mm.'-28';
                            }
                        }
                    } else if($mm==4 || $mm==6 || $mm==9 || $mm==11){
                        if($rent_due_by>30){
                            $abc = $yy.'-'.$mm.'-30';
                        }
                    }

                    $day = date('d', strtotime($abc));
                    $month = date('m', strtotime($abc));
                    $year = date('Y', strtotime($abc));
                    $event_date = $year.'-'.$month.'-'.$rent_due_by;

                     $data = array(
                        'rent_id' => $rent_id ,
                        'event_date' => $event_date,
                        'property_id'=>$property_id
                     );
           
                $this->db->insert('revenue_schedule', $data);
                 $this->db->last_query();
                    $mm = $mm + $increment;
                        
            }
        }
    }

    function getTaxDetailsCalculation($tax_id,$sch_basiccost){
        //  print_r($tax_id);
        $tax_id=implode(',',$tax_id);
    	$this->db->select('tax_id,tax_name,tax_percent,tax_action');
    	$this->db->from('tax_master');
    	$this->db->where('tax_id in ('.$tax_id.') and status = "1" ');
    	$result=$this->db->get();
    	// echo $this->db->last_query();
    	$netamount=$sch_basiccost;
    	foreach ($result->result() as $row){
    		$tax_amount=round(($sch_basiccost * $row->tax_percent)/100);
    		if($row->tax_action==1){
    			$netamount=$netamount+$tax_amount;
    		}
    		else if($row->tax_action==0){
    			$netamount=$netamount-$tax_amount;
    		}
    		$tax_detail[]=array("tax_id"=>$row->tax_id,"tax_type"=>$row->tax_name,"tax_percent"=>$row->tax_percent,"tax_amount"=>$tax_amount);
    	}
    	//print_r($tax_detail);
    	$dataarray=array("netamount"=>$netamount,"tax_detail"=>$tax_detail);
        return $dataarray;
    }

	function getDistinctTaxDetail($pid, $txn_status){
		//echo $pid;
		$this->db->select('tax_type');
		$this->db->where('rent_id = "'.$pid.'" and status = "'.$txn_status.'" ');
		$this->db->from('rent_schedule_taxation');
		$this->db->group_by('tax_type');
        $this->db->order_by('tax_type','Asc');
		$result=$this->db->get();
		//echo $this->db->last_query();
		return $result->result();
	}

    function getPropertyDetails($txn_id='0') {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        if ($txn_id!='0') {
            $cond = "and property_txn_id<>'$txn_id' and (txn_fkid<>'$txn_id' || txn_fkid is null)";
         
        } else {
            $cond = "";
        }

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        /*if (count($result)>0) {*/
            $sql = "Select property_txn_id,unit_name from property_txn Where txn_status='Approved' ".$cond;
            $query=$this->db->query($sql);
            $result=$query->result();
            return $result;
     /* }*/
    }

    function getSubPropertyDetails($txn_id='0', $property_id='0') {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        if ($txn_id!='0') {
            $cond = " and txn_id<>'$txn_id'";
        } else {
            $cond = "";
        }

        if ($property_id!='0') {
            $cond2 = " and property_id='$property_id'";
        } else {
            $cond2 = "";
        }

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sql="select distinct sp_id, sp_name from 
                (select G.txn_id, G.p_property_name, G.p_display_name, G.p_purchase_date, G.sp_id, G.sp_name, 
                    G.owner_name, G.sales_id, H.txn_id as rent_id from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                    where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id and 
                    pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)) D 
                on C.txn_id = D.purchase_id where D.owner_name is not null and D.owner_name <> '') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from rent_txn where gp_id = '$gid' and txn_status <> 'Inactive' and DATE(NOW()) <= DATE(termination_date)" . $cond . ") H 
                on G.txn_id = H.property_id and G.sp_id = H.sub_property_id) I 
                where sales_id is null and rent_id is null and sp_id<>0";
        } else {
            $sql="select distinct sp_id, sp_name from 
                (select G.txn_id, G.p_property_name, G.p_display_name, G.p_purchase_date, G.sp_id, G.sp_name, 
                    G.owner_name, G.sales_id, H.txn_id as rent_id from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)) D 
                on C.txn_id = D.purchase_id) E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from rent_txn where gp_id = '$gid' and txn_status <> 'Inactive' and DATE(NOW()) <= DATE(termination_date)" . $cond . ") H 
                on G.txn_id = H.property_id and G.sp_id = H.sub_property_id) I 
                where sales_id is null and rent_id is null and sp_id<>0";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getPropertyOwners($property_id='0') {
        $gid=$this->session->userdata('groupid');

        $sql = "select A.*, B.c_id, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A where A.purchase_id = '$property_id') A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)";
        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getPropertyUtilities($txn_id='0', $property_id='0') {
        $gid=$this->session->userdata('groupid');

        $sql = "select C.*, D.rent_id, D.landlord, D.tenant, D.na from 
                (select A.*, B.amenity_id from amenity_master A 
                left join purchase_amenity_details B on (A.id = B.amenity_id) 
                where B.purchase_id='$property_id' order by A.amenity) C 
                left join 
                (select * from rent_utility_details where rent_id='$txn_id') D 
                on (C.amenity_id = D.utility_id)";
        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getPropertyNotOnRent() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sql="select * from 
                    (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.p_type, C.p_status, 
                            C.txn_status, C.purchase_price, D.purchase_id, D.pr_client_id, D.owner_name from 
                    (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                        A.txn_status, B.purchase_price from 
                    (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
                    from purchase_txn where gp_id='$gid' and txn_id not in (select distinct property_id from sales_txn 
                            where property_id is not null and txn_status <> 'Inactive' 
                            union all select distinct property_id from rent_txn where property_id is not null and txn_status <> 'Inactive')) A 
                    left join 
                    (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' group by purchase_id) B 
                    on A.txn_id = B.purchase_id) C 
                    left join 
                    (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                    (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                        where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id and 
                        pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
                    left join 
                    (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                        case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') B 
                    on (A.pr_client_id=B.c_id)) D 
                    on C.txn_id=D.purchase_id) E 
                    where E.owner_name is not null and E.owner_name<>'' and E.txn_status='Approved'";

            } else {
                $sql="select * from 
                    (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.p_type, C.p_status, 
                            C.txn_status, C.purchase_price, D.purchase_id, D.pr_client_id, D.owner_name from 
                    (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                        A.txn_status, B.purchase_price from 
                    (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
                    from purchase_txn where gp_id='$gid' and txn_id not in (select distinct property_id from sales_txn 
                            where property_id is not null and txn_status <> 'Inactive' 
                            union all select distinct property_id from rent_txn where property_id is not null and txn_status <> 'Inactive')) A 
                    left join 
                    (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' group by purchase_id) B 
                    on A.txn_id = B.purchase_id) C 
                    left join 
                    (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                    (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                    where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
                    left join 
                    (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                        case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') B 
                    on (A.pr_client_id=B.c_id)) D 
                    on C.txn_id=D.purchase_id) E 
                    where E.owner_name is not null and E.owner_name<>'' and E.txn_status='Approved'";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function insertTenantDetails($txn_id){
        $tenant=$this->input->post('tenant[]');

        for($i=0;$i<count($tenant);$i++) {
            if($tenant[$i]!="" && $tenant[$i]!=null) {
                $data = array(
                            'rent_id' => $txn_id,
                            'contact_id' => $tenant[$i]
                        );
                $this->db->insert('rent_tenant_details', $data);
            }
        }
    }

    function insertEscalationDetails($txn_id){
        $esc_date=$this->input->post('esc_date[]');
        $escalation=$this->input->post('escalation[]');

        for($i=0;$i<count($esc_date);$i++) {
            if($esc_date[$i]!="" && $esc_date[$i]!=null) {
                $esc_date_date=$esc_date[$i];
                if(validateDate($esc_date_date)) {
                    $esc_date_date=FormatDate($esc_date_date);
                } else {
                    $esc_date_date=null;
                }

                $data = array(
                            'rent_id' => $txn_id,
                            'esc_date' => $esc_date_date,
                            'escalation' => format_number($escalation[$i],2)
                        );
                $this->db->insert('rent_escalation_details', $data);
            }
        }
    }

    function insertOtherAmtDetails($txn_id){
        $other_amount=$this->input->post('other_amount[]');
        $other_schedule=$this->input->post('other_schedule[]');
        $other_invoice_issuer=$this->input->post('other_invoice_issuer[]');
        $other_due_day=$this->input->post('other_due_day[]');
        $other_invoice_date=$this->input->post('other_invoice_date[]');
        $other_gst_rate=$this->input->post('other_gst_rate[]');
        $other_gst=$this->input->post('other_gst[]');
        $other_tds_rate=$this->input->post('other_tds_rate[]');
        $other_tds=$this->input->post('other_tds[]');

        for($i=0;$i<count($other_amount);$i++) {
            if($other_amount[$i]!="" && $other_amount[$i]!=null) {
                $other_invoice_date_date=$other_invoice_date[$i];
                if(validateDate($other_invoice_date_date)) {
                    $other_invoice_date_date=FormatDate($other_invoice_date_date);
                } else {
                    $other_invoice_date_date=null;
                }
                if($other_gst[$i]=='1'){
                    $other_gst_rate_rate=($other_gst_rate[$i]==''?null:$other_gst_rate[$i]);
                } else {
                    $other_gst_rate_rate=null;
                }
                if($other_tds[$i]=='1'){
                    $other_tds_rate_rate=$other_tds_rate[$i];
                } else {
                    $other_tds_rate_rate=null;
                }

                $data = array(
                            'rent_id' => $txn_id,
                            'amount' => format_number($other_amount[$i],2),
                            'schedule' => $other_schedule[$i],
                            'invoice_issuer' => $other_invoice_issuer[$i],
                            'due_day' => $other_due_day[$i],
                            'invoice_date' => $other_invoice_date_date,
                            'gst_rate' => $other_gst_rate_rate,
                            'gst' => ($other_gst[$i]==''?0:$other_gst[$i]),
                            'tds_rate' => $other_tds_rate_rate,
                            'tds' => ($other_tds[$i]==''?0:$other_tds[$i]),
                            'event_name' => 'Other'.strval($i+1)
                        );
                $this->db->insert('rent_other_amt_details', $data);
            }
        }
    }

    function insertPDCDetails($txn_id){
        $pdc = $this->input->post('pdc');

        if($pdc=='yes'){
            $pdc_date=$this->input->post('pdc_date[]');
            $pdc_particular=$this->input->post('pdc_particular[]');
            $pdc_amt=$this->input->post('pdc_amt[]');
            $pdc_gst=$this->input->post('pdc_gst[]');
            $pdc_tds=$this->input->post('pdc_tds[]');
            $pdc_net_amt=$this->input->post('pdc_net_amt[]');
            $pdc_chq_no=$this->input->post('pdc_chq_no[]');
            $pdc_bank=$this->input->post('pdc_bank[]');

            for($i=0;$i<count($pdc_date);$i++) {
                if($pdc_date[$i]!="" && $pdc_date[$i]!=null) {
                    $pdc_date_date=$pdc_date[$i];
                    if(validateDate($pdc_date_date)) {
                        $pdc_date_date=FormatDate($pdc_date_date);
                    } else {
                        $pdc_date_date=null;
                    }

                    $data = array(
                                'rent_id' => $txn_id,
                                'pdc_date' => $pdc_date_date,
                                'pdc_particular' => $pdc_particular[$i],
                                'pdc_amt' => format_number($pdc_amt[$i],2),
                                'pdc_gst' => format_number($pdc_gst[$i],2),
                                'pdc_tds' => format_number($pdc_tds[$i],2),
                                'pdc_net_amt' => format_number($pdc_net_amt[$i],2),
                                'pdc_chq_no' => $pdc_chq_no[$i],
                                'pdc_bank' => $pdc_bank[$i]
                            );
                    $this->db->insert('rent_pdc_details', $data);
                }
            }
        }
    }

    function insertUtilityDetails($txn_id){
        $utility=$this->input->post('utility[]');
        $landlord=$this->input->post('landlord[]');
        $tenant=$this->input->post('u_tenant[]');
        $na=$this->input->post('na[]');

        for($i=0;$i<count($utility);$i++) {
            if($utility[$i]!="" && $utility[$i]!=null) {
                $landlord_val = 0;
                $tenant_val = 0;
                $na_val = 0;

                for($j=0;$j<count($landlord);$j++) {
                    if($utility[$i]==$landlord[$j]){
                        $landlord_val = 1;
                    }
                }

                for($j=0;$j<count($tenant);$j++) {
                    if($utility[$i]==$tenant[$j]){
                        $tenant_val = 1;
                    }
                }

                for($j=0;$j<count($na);$j++) {
                    if($utility[$i]==$na[$j]){
                        $na_val = 1;
                    }
                }

                $data = array(
                            'rent_id' => $txn_id,
                            'utility_id' => $utility[$i],
                            'landlord' => $landlord_val,
                            'tenant' => $tenant_val,
                            'na' => $na_val
                        );
                $this->db->insert('rent_utility_details', $data);
            }
        }
    }

    function insertNotificationDetails($txn_id){
        $notification=$this->input->post('notification[]');
        $owner=$this->input->post('owner[]');
        $tenant=$this->input->post('n_tenant[]');

        for($i=0;$i<count($notification);$i++) {
            if($notification[$i]!="" && $notification[$i]!=null) {
                $owner_val = 0;
                $tenant_val = 0;
                $na_val = 0;
                
                for($j=0;$j<count($owner);$j++) {
                    if($notification[$i]==$owner[$j]){
                        $owner_val = 1;
                    }
                }

                for($j=0;$j<count($tenant);$j++) {
                    if($notification[$i]==$tenant[$j]){
                        $tenant_val = 1;
                    }
                }

                $data = array(
                            'rent_id' => $txn_id,
                            'notification_id' => $notification[$i],
                            'owner' => $owner_val,
                            'tenant' => $tenant_val
                        );
                $this->db->insert('rent_notification_details', $data);
            }
        }
    }

    function send_rent_intimation($r_id){
        $gid=$this->session->userdata('groupid');

        $sql = "select * from rent_txn where txn_id = '$r_id'";
        $query = $this->db->query($sql);
        $result = $query->result();

        if(count($result)){
            $property_id=$result[0]->property_id;
            $sub_property_id=$result[0]->sub_property_id;
        } else {
            $property_id='';
            $sub_property_id='';
        }

        $group_owners=$this->purchase_model->get_group_owners($gid);
        $property_owners=$this->purchase_model->get_property_owners($property_id);
        $prop_owners="";

        $table=$this->get_rent_list_table($r_id);

        if(count($property_owners)>0){
            for($i=0;$i<count($property_owners);$i++){
                $owner_name=$property_owners[$i]->owner_name;
                $to_email=$property_owners[$i]->ow_contact_email_id;

                $prop_owners=$prop_owners.$owner_name.', ';

                $this->send_rent_intimation_to_owner($table, $owner_name, $to_email);
            }

            if(strpos($prop_owners, ', ')>0){
                $prop_owners=substr($prop_owners,0,strripos($prop_owners, ', '));
            }

            // echo $prop_owners;
        }

        if(count($group_owners)>0){
            for($i=0;$i<count($group_owners);$i++){
                $owner_name="";
                if(isset($group_owners[$i]->c_name)){
                    $owner_name=$group_owners[$i]->c_name;
                }
                if(isset($group_owners[$i]->c_last_name)){
                    $owner_name=$owner_name.' '.$group_owners[$i]->c_last_name;
                }
                $to_email=$group_owners[$i]->c_emailid1;

                $this->send_rent_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
            }
        }
    }

    function get_rent_list_table($r_id) {
        $rent = $this->rentData("All", '', $r_id);
        $table='';

        if(count($rent)>0) {
            $table='<div>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Sub Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Tenant Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="110">Rent Per Month</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Possession Date</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Termation Date</th>
                                <th style="padding:5px; border: 1px solid black;" width="50">Status</th>
                            </tr>
                        </thead>
                        <tbody>';

            for($i=0;$i<count($rent); $i++ ) {
                $table=$table.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->p_property_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->sp_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->c_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.format_money($rent[$i]->rent_amount,2).'</td>
                                <td style="padding:5px; text-align:right; border: 1px solid black;">'.(($rent[$i]->possession_date!=null && $rent[$i]->possession_date!='')?date('d/m/Y',strtotime($rent[$i]->possession_date)):'').'</td>
                                <td style="padding:5px; border: 1px solid black;">'.(($rent[$i]->termination_date!=null && $rent[$i]->termination_date!='')?date('d/m/Y',strtotime($rent[$i]->termination_date)):'').'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$rent[$i]->txn_status.'</td>
                            </tr>';
            }

            $table=$table.'</tbody></table></div>';

            // echo $table;
            return $table;
        }
    }

    function revenue_intimation_to_owner(){
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Rent Revenue Sharing Intimation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Rent Entry has been created for '.$prop_owners.'. 
                    The Rent details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Rent details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    }

    function send_rent_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Rent Intimation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Rent Entry has been created for '.$prop_owners.'. 
                    The Rent details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Rent details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

    function send_rent_intimation_to_owner($table, $owner_name, $to_email) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Rent Intimation';
        
        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Rent Entry has been mapped to you. 
                    The Rent details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Property has not been put up for rent please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }
}
?>