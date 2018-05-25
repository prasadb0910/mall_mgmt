<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class City_master_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
	$this->load->model('user_access_log_model');
}
function getCityDetails($city_id=false){
	$this->db->select('a.id city_id,a.city_name,b.state_name,a.state_id');
	if($city_id !=''){
		$this->db->where('a.id = '.$city_id.' ');
	}
	$this->db->where('a.status = "1" and b.id = a.state_id ');
	$this->db->from('city_master a, state_master b');
	$result=$this->db->get();
	//echo $this->db->last_query();
	return $result->result();
}

function getStateList(){
	$this->db->select('id,state_name');
	$this->db->from('state_master');
	$this->db->where('status = 1');
	$result=$this->db->get();
	return $result->result();
}
function insertUpdateRecord(){
	$city_name=$this->input->post('city_name');
	$state_id=$this->input->post('state_name');
	$city_id=$this->input->post('city_id');
	$gid=$this->session->userdata('groupid');
	$i=0;

	
		if($city_id !='' ){
			$update_array=array(
				"city_name" => $city_name,
				"state_id"=> $state_id,
				"modified_by"=>$this->session->userdata('session_id'),
				"modified_on"=>date('Y-m-d h:i:s'),
				"status"=>'1',
				"g_id"=>$gid
			);
			$this->db->where('id = '.$city_id.' and status="1" ');
			$this->db->update('city_master',$update_array);

			$logarray['table_id']=$city_id;
	        $logarray['module_name']='City';
	        $logarray['cnt_name']='City';
	        $logarray['action']='City Record Updated';
	        $logarray['gp_id']=$gid;
	        $this->user_access_log_model->insertAccessLog($logarray);
			//exit;
		} else {
			$insert_array=array(
				"city_name" => $city_name,
				"state_id"=> $state_id,
				"created_by"=>$this->session->userdata('session_id'),
				"created_on"=>date('Y-m-d h:i:s'),
				"modified_by"=>$this->session->userdata('session_id'),
				"modified_on"=>date('Y-m-d h:i:s'),
				"status"=>'1',
				"g_id"=>$gid
			);
			$this->db->insert('city_master',$insert_array);
			$logarray['table_id']=$this->db->insert_id();
	        $logarray['module_name']='City';
	        $logarray['cnt_name']='City';
	        $logarray['action']='City Record Inserted';
	        $logarray['gp_id']=$gid;
	        $this->user_access_log_model->insertAccessLog($logarray);
		}
		
	//return true;
}

function delete_record(){
	$gid=$this->session->userdata('groupid');
	$city_id=$this->uri->segment(3);
	$this->db->select('id');
	$this->db->from('city_master');
	$this->db->where('id = '.$city_id.' and status = 1 ');
	$result=$this->db->get();

	if($result->num_rows() > 0){
		$update_sql="update city_master set status = 3, g_id='$gid' where id =".$city_id;
		$this->db->query($update_sql);

		$logarray['table_id']=$city_id;
        $logarray['module_name']='City';
        $logarray['cnt_name']='City';
        $logarray['action']='City Record Deleted';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
	}
	else{
		echo "<script>alert('No record Found')</script>";
	}
}

public function get_city()
{
    $city = $this->db->select("id,city_name")->get("city_master")->result_array();
    return $city;
}

}
?>