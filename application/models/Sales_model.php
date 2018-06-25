<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Sales_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('purchase_model');
}

function getAllTaxes(){
	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
	$this->db->where('status = "1" and txn_type like "%sale%" and tax_action="1"');
	$this->db->from('tax_master');
	$result=$this->db->get();
	return $result->result();
}

function getAccess(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sale' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
    $result=$query->result();
    return $result;
}

function salesData($status='' ,$property_id='', $s_id=''){
     
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

        if($property_id!=""){
            $cond2=" and property_id='" . $property_id . "'";
        } else {
            $cond2="";
        }

        if($s_id!=""){
            $cond2=" and txn_id='" . $s_id . "'";
        }


    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

	    $sql="
            select E.* from 
            (
            Select * from (
            Select C.*, D.sale_price from 
            (Select s.*,p.unit_name,p.property_txn_id,p.floor,p.area,p.area_unit from sales_txn s left join property_txn p on s.property_id=p.property_txn_id   Where s.gp_id='$gid' 
            and s.txn_id IN (select distinct sale_id from sales_buyer_details) )C
            left join 
            (Select sale_id, sum(net_amount) as sale_price from sales_schedule where status='1' or status='3' group by sale_id) D 
            on C.txn_id = D.sale_id ) C 
            Left join
            (SELECT A.*, B.* FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id) ) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.buyer_id=B.c_id) )D on C.txn_id=D.sale_id )E
            where E.owner_name is not null and E.owner_name<>'' " . $cond;
	
    $query=$this->db->query($sql);
    return $query->result();
}





function getAllCountData(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

   
	$sql="select E.* from 
            (
            Select * from (
            Select C.*, D.sale_price from 
            (Select s.*,p.unit_name,p.property_txn_id,p.floor,p.area,p.area_unit from sales_txn s left join property_txn p on s.property_id=p.property_txn_id   Where s.gp_id='$gid' 
            and s.txn_id IN (select distinct sale_id from sales_buyer_details) )C
            left join 
            (Select sale_id, sum(net_amount) as sale_price from sales_schedule where status='1' or status='3' group by sale_id) D 
            on C.txn_id = D.sale_id ) C 
            Left join
            (SELECT A.*, B.* FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id) ) A 
            LEFT JOIN 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved' and A.c_gid='$gid') B 
            ON (A.buyer_id=B.c_id) )D on C.txn_id=D.sale_id )E
            where E.owner_name is not null and E.owner_name<>'' ";
	
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function ownerDetails($gid){
    // $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid = '$gid'");
    $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid' and c_type='Owners'");
    $result=$query->result();
    return $result;
}
  function getPropertyDetails($txn_id='0') {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $cond ="";
        if ($txn_id!='0') {
            $cond = " and property_txn_id<>'$txn_id' and (txn_fkid<>'$txn_id' || txn_fkid is null)";
         
        } else {
            $cond = "";
        }

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        /*if (count($result)>0) {*/
            $sql = "Select property_txn_id,unit_name  from property_txn Where property_txn_id NOT IN((Select property_id from sales_txn where txn_status='Approved')) and txn_status='Approved' and property_typ_id=1".$cond;

            if($cond)
            {
                $sql = "Select property_txn_id,unit_name  from property_txn Where  txn_status='Approved' and property_typ_id=1".$cond;     
            }
            else{
                $sql = "Select property_txn_id,unit_name  from property_txn Where property_txn_id NOT IN((Select property_id from sales_txn where txn_status='Approved')) and txn_status='Approved' and property_typ_id=1".$cond;
            }    
            $query=$this->db->query($sql);
            $result=$query->result();
            return $result;
        /* }*/
    }
/*function getSubPropertyDetails($txn_id='0', $property_id='0') {
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
                from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null and sp_id is not null and sp_id<>0";
    } else {
        $sql="select distinct sp_id, sp_name from 
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
                from sales_txn where gp_id = '$gid' and txn_status = 'Approved'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null and sp_id is not null and sp_id<>0";
    }

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}
*/
function insertRecord($sldt, $txn_status){
	$gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');

    $sub_property_id = $this->input->post('sub_property');
    if($sub_property_id==''){
        $sub_property_id = null;
    }
    $data = array(
                'gp_id' => $gid,
                'property_id' => $this->input->post('property'),
                'sub_property_id' => $sub_property_id,
                'date_of_sale' => $sldt,
                // 'sale_price' => format_number($this->input->post('saleamount'),2),
                // 'registeration_amt' => format_number($this->input->post('registeration'),2),
                // 'stamp_duty' => format_number($this->input->post('stampduty'),2),
                'sales_consideration' => format_number($this->input->post('sales_consideration'),2),
                'cost_of_purchase' => format_number($this->input->post('cost_purchase'),2),
                'cost_of_acquisition' => format_number($this->input->post('cost_of_acquisition'),2),
                'profit_loss' => format_number($this->input->post('profit_loss'),2),
                'txn_status' => $txn_status,
                'maker_remark' => $this->input->post('maker_remark'),
                'create_date' =>date('Y-m-d'),
                'created_by' => $curusr
            );

    $this->db->insert('sales_txn', $data);
    $pid=$this->db->insert_id();

    //$this->send_sales_intimation($pid);

    $logarray['table_id']=$pid;
    $logarray['module_name']='Sale';
    $logarray['cnt_name']='Sale';
    $logarray['action']='Sale Record Inserted';
    $logarray['gp_id']=$gid;
    $this->user_access_log_model->insertAccessLog($logarray);
    return $pid;
}


function insertImage($pid){
    $file_nm='image';
    if(isset($_FILES[$file_nm])) {
        $filePath='uploads/property_purchase/';
        $upload_path = './' . $filePath;
        if(!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }

        $filePath='uploads/property_purchase/property_purchase_'.$pid.'/';
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
                    'p_image' => $filePath.$fileName,
                    'p_image_name' => $fileName
                );
                $this->db->where('txn_id', $pid);
                $this->db->update('sales_txn',$data);

                // echo "Uploaded <br>";

            } else {
                // echo "Failed<br>";
                // echo $this->upload->data();
            }
        }
    }
}

function insertSchedule($pid, $txn_status){
	$gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
	$sch_type=$this->input->post('sch_type');
	$sch_event=$this->input->post('sch_event');
    $sch_date=$this->input->post('sch_date');
    $sch_basiccost=$this->input->post('sch_basiccost');
    //  $sch_pay_type=$this->input->post('sch_pay_type');
    // $sch_agree_value=$this->input->post('sch_agree_value');
    // print_r($sch_event);

    if($txn_status=='Approved'){
        $sch_status = '1';
    } else {
        $sch_status = '3';
    }

    for ($i=0; $i < count($sch_event) ; $i++) {
    	//echo "date".$sch_date[$i];
        // echo "hi";
        if($sch_date[$i]==NULL){
            $scdt=NULL;
        } else {
        	//echo $sch_date[$i];
             $scdt=formatdate($sch_date[$i]);
            //exit;
        }
        $sch_tax='';
        $sch_tax=$this->input->post('sch_tax_'.($i+1));
        $sch_basiccost[$i]=format_number($sch_basiccost[$i],2);
        if(count($sch_tax) > 0){
            $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);

            $data = array(
                        'sale_id' => $pid ,
                        'event_type'=>$sch_type[$i],
                        'event_name' => $sch_event[$i],
                        // 'sch_pay_type'=>$sch_pay_type[$i],
                        // 'sch_agree_value'=>$sch_agree_value[$i+1],
                        'event_date' => $scdt ,
                        'basic_cost' => $sch_basiccost[$i] ,
                        'net_amount' => $tax_detail["netamount"],
                        'create_date' => date('Y-m-d'),
                        'created_by' => $curusr,
                        'sch_status'=>$sch_status,
                        'status'=>$sch_status
                    );
        }
        else{
            $data = array(
                'sale_id' => $pid ,
                'event_type'=>$sch_type[$i],
                'event_name' => $sch_event[$i],
                // 'sch_pay_type'=>$sch_pay_type[$i],
                // 'sch_agree_value'=>$sch_agree_value[$i+1],
                'event_date' => $scdt ,
                'basic_cost' => $sch_basiccost[$i] ,
                'net_amount' => $sch_basiccost[$i],
                'create_date' => date('Y-m-d'),
                'created_by' => $curusr,
                'sch_status'=>$sch_status,
                'status'=>$sch_status
            );
        }

        $this->db->insert('sales_schedule', $data);
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
                    'sale_id' => $pid,
                    'create_date' => date('Y-m-d'),
                	'created_by' => $curusr,
                	'status'=>$sch_status
                );
                $this->db->insert('sales_schedule_taxation', $data);  
                $j++;
            }
        }
    }
}

function getTaxDetailsCalculation($tax_id,$sch_basiccost){
    // print_r($tax_id);
    $sch_basiccost=intval(str_replace(',','',$sch_basiccost));
    $netamount=$sch_basiccost;

    if(count($tax_id) > 0){
        $tax_id=implode(',',$tax_id);
        $this->db->select('tax_id,tax_name,tax_percent,tax_action');
        $this->db->from('tax_master');
        $this->db->where('tax_id in ('.$tax_id.') and status = "1" ');
        $result=$this->db->get();
        // echo $this->db->last_query();
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
    }
	//print_r($tax_detail);
	$dataarray=array("netamount"=>$netamount,"tax_detail"=>$tax_detail);
    return $dataarray;
}

function insertOwnershipDetails($pid){
    $clientname=$this->input->post('clientname[]');
    $ownership=$this->input->post('ownership[]');
    $allocatedcost=$this->input->post('allocatedcost[]');

    for($i=0;$i<count($clientname);$i++) {
        $oper=format_number($ownership[$i],2);
        if($oper==''){
            $oper=0;
        }
        $oallo=format_number($allocatedcost[$i],2);
        if($oallo==''){
            $oallo=0;
        }
        $data = array(
                    'purchase_id' => $pid , 
                    'pr_client_id' => $clientname[$i],
                    'pr_ownership_percent' =>$oper ,
                    'pr_ownership_allocatedcost' => $oallo,
                );
        $this->db->insert('purchase_ownership_details', $data);
    }
}

function insertBuyerDetails($pid){
    $buyername=$this->input->post('buyername[]');
    $percentshare=$this->input->post('sharepercent[]');
    
    for($i=0;$i<count($buyername);$i++) {
        $oper=format_number($percentshare[$i],2);
        if($oper==''){
            $oper=0;
        }
        $data = array(
                    'sale_id' => $pid , 
                    'buyer_id' => $buyername[$i],
                    'share_percent' =>$oper ,
                );
        $this->db->insert('sales_buyer_details', $data);
    }
}

function propertyDescription($pid){
	$data = array(
                'purchase_id' => $pid , 
                'pr_description' => $this->input->post('pr_description'),
                'pr_agreement_area' => format_number($this->input->post('agreement_area'),2),
                'pr_agreement_unit' => $this->input->post('agreement_unit'),
                'pr_land_area' => format_number($this->input->post('land_area'),2),
                'pr_land_unit' => $this->input->post('land_unit'),
                'pr_carpet_area' => format_number($this->input->post('carpet_area'),2),
                'pr_carpet_unit' => $this->input->post('carpet_unit'),
                'pr_builtup_area' => format_number($this->input->post('built_area'),2),
                'pr_builtup_unit' => $this->input->post('built_unit'),
                'pr_sellable_area' => format_number($this->input->post('sell_area'),2),
                'pr_sellable_unit' => $this->input->post('sell_unit'),
                'pr_bunglow_area' => format_number($this->input->post('bunglow_area'),2),
                'pr_bunglow_unit' => $this->input->post('bunglow_unit'),
                'pr_open_parking' => format_number($this->input->post('open_parking'),2),
                'pr_covered_parking' => format_number($this->input->post('covered_parking'),2),
                'pr_no_of_floors' => format_number($this->input->post('no_of_floors'),2),
                'pr_no_of_flats' => format_number($this->input->post('no_of_flats'),2),
                'pr_no_of_shops' => format_number($this->input->post('no_of_shops'),2),
            );
            $this->db->insert('purchase_property_description', $data);
}

function getDistinctTaxDetail($pid, $txn_status){
	//echo $pid;
	$this->db->select('tax_type');
	$this->db->where('sale_id = "'.$pid.'" and status = "'.$txn_status.'" ');
	$this->db->from('sales_schedule_taxation');
	$this->db->group_by('tax_type');
    $this->db->order_by('tax_type','Asc');
	$result=$this->db->get();
	//echo $this->db->last_query();
	return $result->result();
}

function updateSchedule($pid){
	$sch_id=$this->input->post('sch_id');
	//print_r($sch_id);
    if(count($sch_id) > 0){ 
	$sch_id=implode(',',$sch_id);
	$i=0;
	
		$this->db->select('sch_id');
		$this->db->from('sales_schedule');
		$this->db->where('sch_id in ('.$sch_id.') and status = "1" ');
		$result=$this->db->get();
		if($result->num_rows() > 0){//status=2 for update
			$update_array=array(
				"sch_status" => "2",
				"status" => "2",
				"modified_by"=>$this->session->userdata('session_id'));
			$this->db->where('sch_id in ('.$sch_id.')');
			$this->db->update('sales_schedule',$update_array);

			$txn_update=array(
				"status"=>"2",
				"updated_by" =>$this->session->userdata('session_id'));
			$this->db->where('sch_id in ('.$sch_id.')');
			$this->db->update('sales_schedule_taxation',$txn_update);

		}

    }
}

function insertTempSchedule(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $sch_type=$this->input->post('sch_type');
    $sch_event=$this->input->post('sch_event');
    $sch_date=$this->input->post('sch_date');
    $sch_basiccost=$this->input->post('sch_basiccost');
    // $sch_pay_type=$this->input->post('sch_pay_type');
    // $sch_agree_value=$this->input->post('sch_agree_value');   

    // $sch_type='Tet';
    // $sch_event='Tet';
    // $sch_date='15/12/2017';
    // $sch_basiccost='1,00,00,000';

    $pid=uniqid(4);         
    // print_r($sch_type);
    for ($i=0; $i < count($sch_event) ; $i++) {
        //echo "date".$sch_date[$i];
        //echo "hi";
        if($sch_date[$i]==NULL){
            $scdt=NULL;
        } else {
            //echo $sch_date[$i];
             $scdt=formatdate($sch_date[$i]);
            //exit;
        }

        $sch_tax='';
        $sch_tax=$this->input->post('sch_tax_'.($i+1));
        // $sch_tax=array('1');
        //  echo count($sch_tax);

        $sch_basiccost[$i]=format_number($sch_basiccost[$i],2);
        if(count($sch_tax) > 0) {
            $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);

            $data = array(   
                    'txn_type'=>$pid,                
                    'event_type'=>$sch_type[$i],
                    'event_name' => $sch_event[$i],
                    'event_date' => $scdt ,
                    'basic_cost' => format_number($sch_basiccost[$i],2) ,
                    'net_amount' => format_number($tax_detail["netamount"],2),
                    // 'sch_pay_type'=>$sch_pay_type[$i],
                    // 'sch_agree_value'=>$sch_agree_value[$i+1],
                    'create_date' => date('Y-m-d'),
                    'created_by' => $curusr,
                    'sch_status'=>'1',
                    'status'=>'1'
                    );
        } else {
            $data = array(   
                    'txn_type'=>$pid,                
                    'event_type'=>$sch_type[$i],
                    'event_name' => $sch_event[$i],
                    'event_date' => $scdt ,
                    // 'sch_pay_type'=>$sch_pay_type[$i],
                    // 'sch_agree_value'=>$sch_agree_value[$i+1],                   
                    'basic_cost' => format_number($sch_basiccost[$i],2),
                    'net_amount' => format_number($sch_basiccost[$i],2),
                    'create_date' => date('Y-m-d'),
                    'created_by' => $curusr,
                    'sch_status'=>'1',
                    'status'=>'1'
                    );
        }

        $this->db->insert('temp_schedule', $data);
        $scid=$this->db->insert_id();
        $scid_array[]=$scid;
        if(count($sch_tax) > 0){
            $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);
            $j=0;
            foreach($tax_detail['tax_detail'] as $row){
                // print_r($tax_detail['tax_detail'][$j]);

                //$tax_array=explode(',',$sch_tax[$j]);

                $data = array(
                        'sch_id' => $scid,
                        'event_type' => $sch_type[$i],
                        'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                        'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                        'tax_percent' => format_number($tax_detail['tax_detail'][$j]['tax_percent'],2),
                        'tax_amount' => format_number($tax_detail['tax_detail'][$j]['tax_amount'],2),                            
                        'create_date' => date('Y-m-d'),
                        'created_by' => $curusr,
                        'pur_id'=>$pid,
                        'status'=>'1'
                         );
                $this->db->insert('temp_schedule_taxation', $data);  
                $j++;
            }
        }
    }

    //code for display
    $this->db->select('tax_type');
    $this->db->where('pur_id = "'.$pid.'" and status = "1" ');
    $this->db->from('temp_schedule_taxation');
    $this->db->group_by('tax_type');
    $this->db->order_by('tax_type','Asc');
    $result_dist=$this->db->get();
    // echo $this->db->last_query();
    $distict_tax=$result_dist->result();
    $data['tax_name']=$distict_tax;
    $event_type='';
    $event_name='';
    $basic_amount=0;
    $net_amount=0;
    $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM temp_schedule 
            WHERE txn_type = '".$pid."' and status = '1' GROUP BY event_type";
    // $sql="SELECT sch_pay_type,sch_agree_value,event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM temp_schedule  WHERE txn_type = '".$pid."' and status = '1' GROUP BY event_type";
    //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$pid."' and status = '1' ");
    $query=$this->db->query($sql);
    $result=$query->result();
    $data['p_schedule']=array();
    //echo $pid;           
    $k=0;
    $total_net_amount=0;
    if(count($result)>0) {
        foreach($result as $row){
            $data['p_schedule'][$k]['event_type']=$row->event_type;
            $data['p_schedule'][$k]['event_name']=$event_name;
            // $data['p_schedule'][$k]['sch_pay_type']=$row->sch_pay_type;
            // $data['p_schedule'][$k]['sch_agree_value']=$row->sch_agree_value;
            $data['p_schedule'][$k]['basic_cost']=format_money($row->basic_cost,2);
            $data['p_schedule'][$k]['net_amount']=format_money($row->net_amount,2);
                //distint tax name
            // $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM temp_schedule_taxation WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '1' group by tax_type order by tax_master_id asc ");
            $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM temp_schedule_taxation 
                                    WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '1' 
                                    group by tax_type order by tax_type asc ");
            $result_tax=$query->result();
            $j=0;
            if(count($result_tax) > 0){
                foreach($result_tax as $taxrow){
                    $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                    $data['p_schedule'][$k]['tax_amount'][$j]=format_money($taxrow->tax_amount,2);
                    //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                    $j++;
                }
            }


            $total_net_amount=$total_net_amount+$row->net_amount;

            //$data['p_schtxn']=$result;
            $k++;
        }
    }
        
    $query=$this->db->query("SELECT tax_type,sum(tax_amount) as total_tax_amount FROM temp_schedule_taxation 
                            WHERE pur_id = '".$pid."' and status = '1' group by tax_type order by tax_type asc");
    $result_tax=$query->result();
    //echo $this->db->last_query();
    $k=0;
    foreach($result_tax as $row){
        $data['total_tax_amount'][$k]=format_money($row->total_tax_amount,2);
        $k++;
    }
    $data['total_net_amount']=format_money($total_net_amount,2);
    // print_r($scid_array);
    return $data;
}
}

?>