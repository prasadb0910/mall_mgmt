<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Purchase_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

/*function purchaseData($status='', $property_id=''){
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
        $cond2=" and A.txn_id='" . $property_id . "'";
    } else {
        $cond2="";
    }

    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

    if (count($result)>0) {
        $sql = "select * from 
                (select C.*, D.purchase_id, D.pr_client_id, D.c_name, D.c_last_name, D.c_emailid1, D.owner_name from 
                (select A.*, B.purchase_price from 
                (select C.*, case when C.property_status='Vacant' then case when D.property_id is null then 'Vacant' else 'Occupied' end 
                            else C.property_status end as prop_status, D.termination_date from 
                (select A.*, case when B.property_id is null then 'Vacant' else 'Sold' end as property_status, B.date_of_sale from 
                (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) where A.gp_id='$gid'" . $cond2 . ") A 
                left join 
                (select property_id, max(date_of_sale) as date_of_sale from sales_txn 
                    where txn_status='Approved' and gp_id='$gid' group by property_id) B 
                on (A.txn_id=B.property_id)) C 
                left join 
                (select property_id, max(termination_date) as termination_date from rent_txn 
                    where txn_status='Approved' and gp_id='$gid' and DATE(NOW()) <= DATE(termination_date) group by property_id) D 
                on (C.txn_id=D.property_id)) A 
                left join 
                (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
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
                where E.owner_name is not null and E.owner_name<>'' " . $cond;
    } else {
        $sql = "select * from 
                (select C.*, D.purchase_id, D.pr_client_id, D.c_name, D.c_last_name, D.c_emailid1, D.owner_name from 
                (select A.*, B.purchase_price from 
                (select C.*, case when C.property_status='Vacant' then case when D.property_id is null then 'Vacant' else 'Occupied' end 
                            else C.property_status end as prop_status, D.termination_date from 
                (select A.*, case when B.property_id is null then 'Vacant' else 'Sold' end as property_status, B.date_of_sale from 
                (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) where A.gp_id='$gid'" . $cond2 . ") A 
                left join 
                (select distinct property_id, max(date_of_sale) as date_of_sale from sales_txn 
                    where txn_status='Approved' and gp_id='$gid' group by property_id) B 
                on (A.txn_id=B.property_id)) C 
                left join 
                (select property_id, max(termination_date) as termination_date from rent_txn 
                    where txn_status='Approved' and gp_id='$gid' and DATE(NOW()) <= DATE(termination_date) group by property_id) D 
                on (C.txn_id=D.property_id)) A 
                left join 
                (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
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
                on C.txn_id=D.purchase_id) E " . $cond3;
    }

    $query=$this->db->query($sql);
    return $query->result();
}
*/
function purchaseData($status='', $property_id='',$property_type_id=''){
    if($status=='All'){
        $cond="";
        $cond3="";
    } else if($status=='InProcess'){
        $status='In Process';
        $cond="and E.txn_status='In Process'";
        $cond3="and E.txn_status='In Process'";
    } else if($status=='Pending'){
        $cond="and (E.txn_status='Pending' or E.txn_status='Delete')";
        $cond3="and (E.txn_status='Pending' or E.txn_status='Delete')";
    } else {
        $cond="and E.txn_status='$status'";
        $cond3="and  E.txn_status='$status'";
    }

    if($property_id!=""){
        $cond2=" and E.property_txn_id='" . $property_id . "'";
    } else {
        $cond2="";
    }

    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

    if (count($result)>0) {
       $sql = "Select E.property_txn_id,E.property_typ_id,E.gp_id,E.unit_name,E.unit_type,ut.unit_type as np_unit_type,E.unit_type_id,E.unit_no,E.floor,E.area,E.area_unit,E.allocated_cost,E.allocated_maintenance,E.txn_status,rt.property_id,max(termination_date) as termination_date ,
        case when rt.property_id is not null then 'Occupied' When st.property_id is null then 'Vacant'  else 'Sold' end as property_status ,max(date_of_sale) as date_of_sale,prt.property_type,E.p_image,E.location , E.updated_on,E.updated_by,E.added_by,E.added_on
         from property_txn E 
        left JOIN purchase_ownership_details pd on E.property_txn_id=pd.purchase_id
        left join contact_master A on pd.pr_client_id=A.c_id
        left join contact_master B on (A.c_contact_id=B.c_id)
        left join property_type prt on E.property_typ_id=prt.property_type_id
        left join rent_txn rt on E.property_txn_id=rt.property_id
        left join sales_txn st on E.property_txn_id=st.property_id
        left join nrp_unit_type_master ut on E.unit_type_id=ut.id
        Where E.property_typ_id='$property_type_id'  and E.txn_status <> 'Inactive'
        ".$cond.$cond2."
        GROUP BY  
        E.property_txn_id,property_typ_id,gp_id,unit_name,unit_type,unit_type_id,unit_no,floor,area,area_unit,allocated_cost,allocated_maintenance,txn_status,owner_name,rt.property_id,prt.property_type,E.p_image,E.location";
    } else {
        $sql = "Select E.property_txn_id,E.property_typ_id,E.gp_id,E.unit_name,E.unit_type,ut.unit_type as np_unit_type,E.unit_type_id,E.unit_no,E.floor,E.area,E.area_unit,E.allocated_cost,E.allocated_maintenance,E.txn_status,rt.property_id,max(termination_date) as termination_date ,
        if(st.property_id is not null ,'Sold', case when  rt.property_id is not null then 'Occupied' else 'Vacant' end) as property_status,max(date_of_sale) as date_of_sale,prt.property_type,E.p_image,E.location , E.updated_on,E.updated_by,E.added_by,E.added_on
         from property_txn E 
        left JOIN purchase_ownership_details pd on E.property_txn_id=pd.purchase_id
        left join property_type prt on E.property_typ_id=prt.property_type_id
        left join rent_txn rt on E.property_txn_id=rt.property_id
        left join sales_txn st on E.property_txn_id=st.property_id
		left join nrp_unit_type_master ut on E.unit_type_id=ut.id
        Where E.property_typ_id='$property_type_id'  and E.txn_status <> 'Inactive'
        ".$cond.$cond2."
        GROUP BY  
        E.property_txn_id,property_typ_id,gp_id,unit_name,unit_type,unit_type_id,unit_no,floor,area,area_unit,allocated_cost,allocated_maintenance,txn_status,rt.property_id,prt.property_type,E.p_image,E.location";
    }

    
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_ownername($property_txn_id)
{
    return $this->db->select("unit_name,property_txn_id")->get('')->result();
}

function getAllCountData($property_type_id=''){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
 
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();


      if (count($result)>0) {
       $sql = "Select E.property_txn_id,E.property_typ_id,E.gp_id,E.unit_name,E.unit_type,ut.unit_type as np_unit_type,E.unit_type_id,E.unit_no,E.floor,E.area,E.area_unit,E.allocated_cost,E.allocated_maintenance,E.txn_status,rt.property_id,max(termination_date) as termination_date ,
        case when st.property_id is null then 'Vacant' else 'Sold' end as property_status ,max(date_of_sale) as date_of_sale,prt.property_type,E.p_image,E.location
         from property_txn E 
        left JOIN purchase_ownership_details pd on E.property_txn_id=pd.purchase_id
        left join contact_master A on pd.pr_client_id=A.c_id
        left join contact_master B on (A.c_contact_id=B.c_id)
        left join property_type prt on E.property_typ_id=prt.property_type_id
        left join rent_txn rt on E.property_txn_id=rt.property_id
        left join sales_txn st on E.property_txn_id=st.property_id
		left join nrp_unit_type_master ut on E.unit_type_id=ut.id
        Where E.property_typ_id='$property_type_id' and E.txn_status <> 'Inactive'
      
        GROUP BY  
        E.property_txn_id,property_typ_id,gp_id,unit_name,unit_type,unit_type_id,unit_no,floor,area,area_unit,allocated_cost,allocated_maintenance,txn_status,owner_name,rt.property_id,prt.property_type,E.p_image,E.location";
    } else {
        $sql = "Select E.property_txn_id,E.property_typ_id,E.gp_id,E.unit_name,E.unit_type,E.unit_type_id,E.unit_no,E.floor,E.area,E.area_unit,E.allocated_cost,E.allocated_maintenance,E.txn_status,rt.property_id,max(termination_date) as termination_date ,
        case when st.property_id is null then 'Vacant' else 'Sold' end as property_status ,max(date_of_sale) as date_of_sale,prt.property_type,E.p_image,E.location
         from property_txn E 
        left JOIN purchase_ownership_details pd on E.property_txn_id=pd.purchase_id
        left join property_type prt on E.property_typ_id=prt.property_type_id
        left join rent_txn rt on E.property_txn_id=rt.property_id
        left join sales_txn st on E.property_txn_id=st.property_id
		left join nrp_unit_type_master ut on E.unit_type_id=ut.id
        Where E.property_typ_id='$property_type_id'  and E.txn_status <> 'Inactive'
     
        GROUP BY  
        E.property_txn_id,property_typ_id,gp_id,unit_name,unit_type,unit_type_id,unit_no,floor,area,area_unit,allocated_cost,allocated_maintenance,txn_status,rt.property_id,prt.property_type,E.p_image,E.location";
    }

	

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}


function getAllTaxes($txn_type){
	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
	$this->db->where('status = "1" and tax_action="1"');
    if($txn_type !=''){
        $this->db->where('txn_type like "%'.$txn_type.'%" ');
    }
    else{
        $this->db->where('txn_type like "%purchase%" ');
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
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
    $result=$query->result();
    return $result;
}

function insertRecord($txn_status){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');

    $data = array('gp_id' => $gid,
                  'property_typ_id'=>($this->input->post('type_id')?$this->input->post('type_id'):''),
                  'unit_name'=> ($this->input->post('unit')?$this->input->post('unit'):''),
                  'unit_type'=> ($this->input->post('unit_type')?$this->input->post('unit_type'):''),
                  'unit_type_id'=> ($this->input->post('unit_type_id')?$this->input->post('unit_type_id'):''),
                  'unit_no'=> ($this->input->post('unit_no')?$this->input->post('unit_no'):''),
                  'floor'=> ($this->input->post('floor')?$this->input->post('floor'):''),
                  'area'=> ($this->input->post('area')?$this->input->post('area'):''),
                  'area_unit'=> ($this->input->post('area_unit')?$this->input->post('area_unit'):''),
                  'allocated_cost'=>($this->input->post('allocated_cost')?$this->input->post('allocated_cost'):''),
                  'allocated_maintenance'=>($this->input->post('allocated_maintenance')?$this->input->post('allocated_maintenance'):''),
                  'txn_status'=>$txn_status,
                  'location'=>($this->input->post('loaction')?$this->input->post('location'):''),
                  'added_on' =>date('Y-m-d'),
                  'added_by' => $curusr,
                  'updated_on'=>date('Y-m-d')
                  );
   
    $this->db->insert('property_txn', $data);
  
    $pid=$this->db->insert_id();
    //$this->send_purchase_intimation($pid);

    $logarray['table_id']=$pid;
    $logarray['module_name']='Purchase';
    $logarray['cnt_name']='Purchase';
    $logarray['action']='Purchase Record Inserted';
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
                $this->db->where('property_txn_id', $pid);
                $this->db->update('property_txn',$data);

                // echo "Uploaded <br>";

            } else {
                // echo "Failed<br>";
                // echo $this->upload->data();
            }
        }
    }
}

function insertSchedule($pid, $txn_status){
    //echo "hi";
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
	$sch_type=$this->input->post('sch_type');
	$sch_event=$this->input->post('sch_event');
    $sch_date=$this->input->post('sch_date');
    $sch_basiccost=$this->input->post('sch_basiccost');
    // $sch_pay_type=$this->input->post('sch_pay_type');
    // $sch_agree_value=$this->input->post('sch_agree_value');   
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
        $sch_basiccost[$i]=format_number($sch_basiccost[$i],2);
        //   print_r($sch_tax); echo "<br>".($i+1)."<br>";
        if(count($sch_tax) > 0){
            $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);

            $data = array(
                'purchase_id' => $pid ,
                'event_type'=>$sch_type[$i],
                'event_name' => $sch_event[$i],
                // 'sch_pay_type'=>$sch_pay_type[$i],
                // 'sch_agree_value'=>$sch_agree_value[$i+1],
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
                'purchase_id' => $pid ,
                'event_type'=>$sch_type[$i],
                // 'sch_pay_type'=>$sch_pay_type[$i],
                // 'sch_agree_value'=>$sch_agree_value[$i+1],
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
        $this->db->insert('purchase_schedule', $data);
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
                'pur_id' => $pid,
                'status'=>$sch_status
                 );
                $this->db->insert('purchase_schedule_taxation', $data);  
                $j++;
            }
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

function insertOwnershipDetails($pid){
    $clientname=$this->input->post('clientname[]');

    for($i=0;$i<count($clientname);$i++) {

        $data = array(
                    'purchase_id' => $pid , 
                    'pr_client_id' => $clientname[$i],
                );
        $this->db->insert('purchase_ownership_details', $data);
        // $this->db->last_query();
    }
}

function insertRPDetails($pid){
    $rpname=$this->input->post('rpname[]');
    $remarks=$this->input->post('remarks[]');

    for($i=0;$i<count($rpname);$i++) {
        $data = array(
                    'purchase_id' => $pid , 
                    'rp_contact_id' => $rpname[$i],
                    'rp_remarks' =>$remarks[$i]
                );
        $this->db->insert('purchase_rp_details', $data);
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

function insertPendingActivity($pid){
    $pending_activity=$this->input->post('pending_activity[]');
    for ($i=0; $i < count($pending_activity); $i++) {
        if($pending_activity[$i]!="") {
            $data = array(
                'type' => 'purchase',
                'ref_id' => $pid,
                'pending_activity' => $pending_activity[$i]
                );
            $this->db->insert('pending_activity', $data);
        }
    }
}

function getDistinctTaxDetail($pid, $txn_status){
	//echo $pid;
	$this->db->select('tax_type');
	$this->db->where('pur_id = "'.$pid.'" and status = "'.$txn_status.'" ');
	$this->db->from('purchase_schedule_taxation');
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
		$this->db->from('purchase_schedule');
		$this->db->where('sch_id in ('.$sch_id.') and status = "1" ');
		$result=$this->db->get();
		if($result->num_rows() > 0){//status=2 for update
			$update_array=array(
				"sch_status" => "2",
				"status" => "2",
				"modified_by"=>$this->session->userdata('session_id'));
			$this->db->where('sch_id in ('.$sch_id.')');
			$this->db->update('purchase_schedule',$update_array);

			$txn_update=array(
				"status"=>"2",
				"updated_by" =>$this->session->userdata('session_id'));
			$this->db->where('sch_id in ('.$sch_id.')');
			$this->db->update('purchase_schedule_taxation',$txn_update);

		}

    }
}

function insertAmenityDetails($pid){
    $amenity=$this->input->post('amenity[]');

    for($i=0;$i<count($amenity);$i++) {
        $data = array(
                    'purchase_id' => $pid , 
                    'amenity_id' => $amenity[$i]
                );
        $this->db->insert('purchase_amenity_details', $data);
    }
}

function check_availablity($gid, $p_id, $p_name){
    $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id='$p_id'");
    $result=$query->result();
    if(count($result)>0){
        $p_fkid=$result[0]->txn_fkid;
    } else {
        $p_fkid='';
    }

    $this->db->select('*');
    $this->db->where('txn_id != ', $p_id);
    $this->db->where('txn_id != ', $p_fkid);
    $this->db->where("(txn_fkid != '$p_id' OR txn_fkid Is Null)");
    $this->db->where('gp_id', $gid);
    $this->db->where('p_property_name', $p_name);
    $this->db->from('purchase_txn');
    $query = $this->db->get();
    // echo $this->db->last_query();
    if( $query->num_rows() != 0 ){
        return 1;
    }else{
        return 0;
    }
}

public function send_purchase_intimation($property_id){
    $gid=$this->session->userdata('groupid');

    $group_owners=$this->get_group_owners($gid);
    $property_owners=$this->get_property_owners($property_id);
    $prop_owners="";

    $table=$this->get_purchase_list_table($property_id);

    if(count($property_owners)>0){
        for($i=0;$i<count($property_owners);$i++){
            $owner_name=$property_owners[$i]->owner_name;
            $to_email=$property_owners[$i]->ow_contact_email_id;

            $prop_owners=$prop_owners.$owner_name.', ';

            $this->send_purchase_intimation_to_owner($table, $owner_name, $to_email);
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

            $this->send_purchase_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
        }
    }
}

public function get_group_owners($gid) {
    $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='$gid' and c_createdby='0' and c_status != 'Inactive'");
    return $query->result();
}

public function get_property_owners($property_id) {
    // $query=$this->db->query("SELECT A.*, B.c_emailid1 as ow_contact_email_id from 
    //                         (SELECT A.pr_client_id, 
    //                         case when B.ow_type = '0' then 
    //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master where c_id = B.ow_ind_id) 
    //                         when B.ow_type = '1' then B.ow_huf_name 
    //                         when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
    //                         when B.ow_type = '3' then B.ow_ltd_comapny_name 
    //                         when B.ow_type = '4' then B.ow_llp_comapny_name 
    //                         when B.ow_type = '5' then B.ow_prt_comapny_name 
    //                         when B.ow_type = '6' then B.ow_aop_comapny_name 
    //                         when B.ow_type = '7' then B.ow_trs_comapny_name 
    //                         else B.ow_proprietorship_comapny_name end as owner_name, 
    //                         case when B.ow_type = '0' then B.ow_ind_id 
    //                         when B.ow_type = '1' then B.ow_huf_karta_id 
    //                         when B.ow_type = '2' then B.ow_pvtltd_contact 
    //                         when B.ow_type = '3' then B.ow_ltd_contact 
    //                         when B.ow_type = '4' then B.ow_llp_contact 
    //                         when B.ow_type = '5' then B.ow_prt_contact 
    //                         when B.ow_type = '6' then B.ow_aop_contact 
    //                         when B.ow_type = '7' then B.ow_trs_contact 
    //                         else B.ow_proprietorship_contact end as ow_contact_id, 
    //                         A.pr_ownership_percent, A.pr_ownership_allocatedcost 
    //                         FROM purchase_ownership_details A, owner_master B 
    //                         WHERE A.purchase_id = '$property_id' and A.pr_client_id=B.ow_id) A 
    //                         left join 
    //                         (select * from contact_master) B 
    //                         on (A.ow_contact_id=B.c_id)");
    // return $query->result();

    $sql = "select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name, B.c_emailid1 as ow_contact_email_id from 
            (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                where A.purchase_id = '$property_id' and A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
            left join 
            (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                case when A.c_owner_type='individual' 
                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
            where A.c_status='Approved') B 
            on (A.pr_client_id=B.c_id)";
    $query=$this->db->query($sql);
    return $query->result();
}

public function get_purchase_list_table($property_id) {
    $property = $this->purchaseData("All", $property_id);
    $table='';

    if(count($property)>0) {
        $table='<div>
                <table style="border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Owner Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Property Type</th>
                            <th style="padding:5px; border: 1px solid black;" width="110">Purchased Price (In &#x20B9;)</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Purchased Date</th>
                            <th style="padding:5px; border: 1px solid black;" width="50">Status</th>
                        </tr>
                    </thead>
                    <tbody>';

        for($i=0;$i<count($property); $i++ ) {
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$property[$i]->unit_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$property[$i]->owner_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$property[$i]->p_type.'</td>
                            <td style="padding:5px; text-align:right; border: 1px solid black;">'.format_money($property[$i]->purchase_price,2).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.(($property[$i]->p_purchase_date!=null && $property[$i]->p_purchase_date!="")?date("d/m/Y",strtotime($property[$i]->p_purchase_date)):"").'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$property[$i]->txn_status.'</td>
                        </tr>';
        }

        $table=$table.'</tbody></table></div>';

        // echo $table;
        return $table;
    }
}

public function send_purchase_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
    $from_email = 'info@pecanreams.com';
    $from_email_sender = 'Pecan REAMS';
    $subject = 'Purchase Intimation';

    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                We would like to bring to your notice that a New Purchase Entry has been created for '.$prop_owners.'. 
                The Property details are as follows.<br /><br />' . $table . '<br /><br />
                If the above Property is not yours please reject the same immediately.<br /><br />Thanks</body></html>';
    $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

    // echo $owner_name . ' ';
}

public function send_purchase_intimation_to_owner($table, $owner_name, $to_email) {
    $from_email = 'info@pecanreams.com';
    $from_email_sender = 'Pecan REAMS';
    $subject = 'Purchase Intimation';
    
    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                We would like to bring to your notice that a New Purchase Entry has been mapped to you. 
                The Property details are as follows.<br /><br />' . $table . '<br /><br />
                If the above Property is not yours please reject the same immediately.<br /><br />Thanks</body></html>';
    $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

    // echo $owner_name . ' ';
}

function get_sub_properties($status='', $property_id='', $sub_property_id=''){
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

    if($sub_property_id!=""){
        $cond2=" and txn_id='" . $sub_property_id . "'";
    }

    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

    if (count($result)>0) {
        $sql="select * from 
            (select C.*, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1 from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
            (select *, txn_id as sub_property_id from sub_property_allocation where gp_id = '$gid' and 
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
            on C.property_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>'' " . $cond;
    } else {
        $sql="select * from 
            (select C.*, D.owner_name, D.c_name, D.c_last_name, D.c_emailid1 from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
            (select *, txn_id as sub_property_id from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') A 
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
            on C.property_id=D.purchase_id) E " . $cond3;
    }

    $query=$this->db->query($sql);
    // echo $this->db->last_query();
    return $query->result();
}
}
?>