<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Payment_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}

function getAccess(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Payments' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
    $result=$query->result();
    return $result;
}

function getData($payment_status=''){
    $cond="";

    if($payment_status==''){
        $cond="";
    } else if($payment_status=='payments_done'){
        $cond=" and payment_status='paid'";
    } else if($payment_status=='payments_pending'){
        $cond=" and payment_status='pending'";
    }

    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    $query=$this->db->query("select * from user_payment_details where status = 'approved'" . $cond);
    $result=$query->result();
    return $result;
}

}
?>