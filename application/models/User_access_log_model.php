<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class User_access_log_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}


function insertAccessLog($logArray){
	$insert_array=array(
		'user_id'=>$this->session->userdata('session_id'),
		'module_name'=>$logArray['module_name'],
		'controller_name'=>$logArray['cnt_name'],
		'action'=>$logArray['action'],
		'table_id'=>$logArray['table_id'],
		'date'=>date('Y-m-d H:i:s'),
		'gp_id'=>$logArray['gp_id']);
	$this->db->insert('user_access_log',$insert_array);
	

}


}