<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Loan_disbursement_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
        $this->load->model('loan_model');
    }

    function loanData($status='', $property_id='', $lid='', $loan_id=''){
        if($status=='All' || $status==''){
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

        // if($property_id!=""){
        //     $cond2=" and loan_property_id='" . $property_id . "'";
        // } else {
        //     $cond2="";
        // }

        if($lid!=""){
            $cond2=" and txn_id='" . $lid . "'";
        } else {
            $cond2="";
        }

        if($loan_id!=""){
            $cond2 = $cond2 . " and loan_id='" . $loan_id . "'";
        } else {
            $cond2="";
        }

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $blOwnerExist = true;
            $sql = "select * from 
                    (select C.*, D.b_name as issuer_bank_name from 
                    (select A.*, B.ref_id as loan_ref_id, B.ref_name as loan_ref_name, B.loan_amount, 
                        B.loan_startdate, B.loan_due_day, B.loan_term, B.loan_interest_rate, B.interest_type as loan_interest_type,
                        B.repayment, B.purpose, B.financial_institution, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name, 
                        B.property_id, B.sub_property_id, B.property, B.p_property_name, B.p_display_name, B.p_type, B.sp_name, B.p_status, 
                        B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                        B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                    (select * from loan_disbursement where gp_id='$gid' ".$cond2.") A 
                    left join 
                    (select F.*, G.property_id, G.sub_property_id, G.property, G.p_property_name, G.p_display_name, G.p_type, G.sp_name, G.p_status, 
                            G.p_image, G.pr_agreement_area, G.pr_agreement_unit, G.purchase_price, G.p_apartment, G.p_flatno, G.p_floor, 
                            G.p_wing, G.p_address, G.p_landmark, G.p_state, G.p_city, G.p_pincode, G.p_country, G.p_googlemaplink from 
                    (select * from 
                    (select C.*, D.loan_id, D.brower_id, D.c_name, D.c_last_name, D.c_emailid1, D.owner_name from 
                    (select * from loan_txn where gp_id='$gid') C 
                    left join 
                    (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                    (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id and 
                        brower_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
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
                    on (A.brower_id=B.c_id)) D 
                    on C.txn_id=D.loan_id) E 
                    where E.owner_name is not null and E.owner_name<>'') F
                    left join 
                    (select C.*, D.sp_name from 
                    (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                            B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                            B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                    (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                    left join 
                    (select A.*, B.purchase_price from 
                    (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                        from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) 
                        where A.gp_id='$gid') A 
                    left join 
                    (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                    on A.txn_id = B.purchase_id) B 
                    on A.property_id = B.txn_id) C 
                    left join 
                    (select * from sub_property_allocation where gp_id='$gid') D 
                    on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                    on F.txn_id = G.loan_id) B 
                    on (A.loan_id = B.txn_id)) C 
                    left join 
                    (select * from bank_master where b_status = 'Approved') D 
                    on (C.issuer_bank=D.b_id)) E " . $cond3;
        } else {
            $sql = "select * from 
                    (select C.*, D.b_name as issuer_bank_name from 
                    (select A.*, B.ref_id as loan_ref_id, B.ref_name as loan_ref_name, B.loan_amount, 
                        B.loan_startdate, B.loan_due_day, B.loan_term, B.loan_interest_rate, B.interest_type as loan_interest_type,
                        B.repayment, B.purpose, B.financial_institution, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name, 
                        B.property_id, B.sub_property_id, B.property, B.p_property_name, B.p_display_name, B.p_type, B.sp_name, B.p_status, 
                        B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                        B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                    (select * from loan_disbursement where gp_id='$gid' ".$cond2.") A 
                    left join 
                    (select F.*, G.property_id, G.sub_property_id, G.property, G.p_property_name, G.p_display_name, G.p_type, G.sp_name, G.p_status, 
                            G.p_image, G.pr_agreement_area, G.pr_agreement_unit, G.purchase_price, G.p_apartment, G.p_flatno, G.p_floor, 
                            G.p_wing, G.p_address, G.p_landmark, G.p_state, G.p_city, G.p_pincode, G.p_country, G.p_googlemaplink from 
                    (select * from 
                    (select C.*, D.loan_id, D.brower_id, D.c_name, D.c_last_name, D.c_emailid1, D.owner_name from 
                    (select * from loan_txn where gp_id='$gid') C 
                    left join 
                    (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                    (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id)) A 
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
                    on (A.brower_id=B.c_id)) D 
                    on C.txn_id=D.loan_id) E) F
                    left join 
                    (select C.*, D.sp_name from 
                    (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                            B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                            B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                    (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                    left join 
                    (select A.*, B.purchase_price from 
                    (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                        from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) 
                        where A.gp_id='$gid') A 
                    left join 
                    (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                    on A.txn_id = B.purchase_id) B 
                    on A.property_id = B.txn_id) C 
                    left join 
                    (select * from sub_property_allocation where gp_id='$gid') D 
                    on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                    on F.txn_id = G.loan_id) B 
                    on (A.loan_id = B.txn_id)) C 
                    left join 
                    (select * from bank_master where b_status = 'Approved') D 
                    on (C.issuer_bank=D.b_id)) E " . $cond3;
        }

        // echo $sql;

        $query=$this->db->query($sql);
        return $query->result();
    }

    function getAllTaxes(){
    	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
    	$this->db->where('status = "1" and txn_type like "%Loan%"  and tax_action="1"');
    	$this->db->from('tax_master');
    	$result=$this->db->get();
    	return $result->result();
    }

    function getAccess(){
    	$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
        $result=$query->result();
        return $result;
    }

    function insertSchedule($loan_id, $lid, $txn_status){
        //echo "hi";
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
    	$sch_type=$this->input->post('sch_type');
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
                    'loan_id' => $loan_id ,
                    'loan_disbursement_id' => $lid ,
                    'event_type'=>$sch_type[$i],
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
                    'loan_id' => $loan_id ,
                    'loan_disbursement_id' => $lid ,
                    'event_type'=>$sch_type[$i],
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
            $this->db->insert('loan_schedule', $data);
            $scid=$this->db->insert_id();
            if(count($sch_tax) > 0){
                $j=0;
                foreach($tax_detail['tax_detail'] as $row){
                    // print_r($tax_detail['tax_detail'][$j]);

                    //$tax_array=explode(',',$sch_tax[$j]);

                    $data = array(
                        'sch_id' => $scid,
                        'event_type' => $sch_type[$i],
                        'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                        'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                        'tax_percent' => $tax_detail['tax_detail'][$j]['tax_percent'],
                        'tax_amount' => $tax_detail['tax_detail'][$j]['tax_amount'],
                        'loan_id' => $loan_id ,
                        'loan_disbursement_id' => $lid ,
                        'status'=>$sch_status
                    );
                    $this->db->insert('loan_schedule_taxation', $data);  
                    $j++;
                }
            }
        }
    }

    function insertImage($lid){
        $file_nm='image';
        if(isset($_FILES[$file_nm])) {
            $filePath='uploads/property_loan_disbursement/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $filePath='uploads/property_loan_disbursement/property_loan_disbursement_'.$lid.'/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $confi['upload_path']=$upload_path;
            $confi['allowed_types']='*';
            $this->load->library('upload', $confi);
            $this->upload->initialize($confi);
            $extension="";

            if(!empty($_FILES[$file_nm]['name'])) {
                if($this->upload->do_upload($file_nm)) {
                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];
                        
                    $data = array(
                        'image' => $filePath.$fileName,
                        'image_name' => $fileName
                    );
                    $this->db->where('txn_id', $lid);
                    $this->db->update('loan_disbursement',$data);

                    // echo "Uploaded <br>";

                } else {
                    // echo "Failed<br>";
                    // echo $this->upload->data();
                }
            }
        }
    }

    function getTaxDetailsCalculation($tax_id,$sch_basiccost){
        //  print_r($tax_id);
        $tax_id=implode(',',$tax_id);
    	$this->db->select('tax_id,tax_name,tax_percent,tax_action');
    	$this->db->from('tax_master');
    	$this->db->where('tax_id in ('.$tax_id.') and status = "1" and tax_action="1"');
    	$result=$this->db->get();
    	// echo $this->db->last_query();
    	$netamount=$sch_basiccost;
    	foreach ($result->result() as $row){
    		$tax_amount=round(($sch_basiccost * $row->tax_percent)/100);
    		if($row->tax_action==1){
    			$netamount=$netamount+$tax_amount;
    		} else if($row->tax_action==0){
    			$netamount=$netamount-$tax_amount;
    		}
    		$tax_detail[]=array("tax_id"=>$row->tax_id,"tax_type"=>$row->tax_name,"tax_percent"=>$row->tax_percent,"tax_amount"=>$tax_amount);
    	}
    	//print_r($tax_detail);
    	$dataarray=array("netamount"=>$netamount,"tax_detail"=>$tax_detail);
        return $dataarray;
    }

	function getDistinctTaxDetail($lid, $txn_status){
		//echo $lid;
		$this->db->select('tax_type');
		$this->db->where('loan_disbursement_id = "'.$lid.'" and status = "'.$txn_status.'" ');
		$this->db->from('loan_schedule_taxation');
		$this->db->group_by('tax_type');
        $this->db->order_by('tax_type','Asc');
		$result=$this->db->get();
		//echo $this->db->last_query();
		return $result->result();
	}

    function check_availablity($gid, $l_id, $l_ref_id){
        $this->db->select('*');
        $this->db->where('txn_id != ', $l_id);
        $this->db->where("(txn_fkid != '$l_id' OR txn_fkid Is Null)");
        $this->db->where('gp_id', $gid);
        $this->db->where('ref_id', $l_ref_id);
        $this->db->from('loan_disbursement');
        $query = $this->db->get();
        // echo $this->db->last_query();
        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    public function send_loan_disbursement_intimation($lid, $loan_id, $disbursement_amount){
        $gid=$this->session->userdata('groupid');
        
        $group_owners=$this->purchase_model->get_group_owners($gid);
        $property_owners=$this->loan_model->get_loan_owners($loan_id);
        $prop_owners="";

        $table=$this->get_loan_disbursement_list_table($lid);

        if(count($property_owners)>0){
            for($i=0;$i<count($property_owners);$i++){
                $owner_name=$property_owners[$i]->owner_name;
                $to_email=$property_owners[$i]->ow_contact_email_id;

                $prop_owners=$prop_owners.$owner_name.', ';

                $this->send_loan_disbursement_intimation_to_owner($table, $owner_name, $to_email, $disbursement_amount);
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

                $this->send_loan_disbursement_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners, $disbursement_amount);
            }
        }
    }

    public function get_loan_disbursement_list_table($lid) {
        $loan = $this->loanData("All", "", $lid);
        $table='';

        if(count($loan)>0) {
            $table='<div>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Ref Id</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Loan Ref Id</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Issuer Bank</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Loan Amount (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="110">Loan Disbursement Amount (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Loan Disbursement Date</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Loan EMI (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="50">Status</th>
                            </tr>
                        </thead>
                        <tbody>';

            for($i=0;$i<count($loan); $i++ ) {
                $table=$table.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->ref_id.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->loan_ref_id.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->issuer_bank_name.'</td>
                                <td style="padding:5px; text-align:right; border: 1px solid black;">'.format_money($loan[$i]->loan_amount,2).'</td>
                                <td style="padding:5px; text-align:right; border: 1px solid black;">'.format_money($loan[$i]->disbursement_amount,2).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.(($loan[$i]->disbursement_date!=null && $loan[$i]->disbursement_date!='')?date('d/m/Y',strtotime($loan[$i]->disbursement_date)):'').'</td>
                                <td style="padding:5px; text-align:right; border: 1px solid black;">'.format_money($loan[$i]->emi,2).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->txn_status.'</td>
                            </tr>';
            }

            $table=$table.'</tbody></table></div>';

            // echo $table;
            return $table;
        }
    }

    public function send_loan_disbursement_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners, $disbursement_amount) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Loan Disbursement Intimation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that Rs. '.format_money($disbursement_amount,2).' has been disbursed to '.$prop_owners.'. 
                    The Loan Disbursement details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above entry is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

    public function send_loan_disbursement_intimation_to_owner($table, $owner_name, $to_email, $disbursement_amount) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Loan Disbursement Intimation';
        
        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that Rs. '.format_money($disbursement_amount,2).' has been disbursed to you. 
                    The Loan Disbursement details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above entry is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }
}
?>