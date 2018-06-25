<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Contact_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
}

function get_all(){
    $query=$this->db->query("select * from contact_master");
    $result=$query->result_array();
    return $result;
}

function getContactDetails($roleid){
	$query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND (r_view = 1 or r_insert = 1 or r_edit = 1 or r_delete = 1 or r_approvals = 1)");
    $result=$query->result();

    $data['access']=$result;

    if(count($result)>0) {
        $gid=$this->session->userdata('groupid');

        // $query=$this->db->query("SELECT * FROM contact_master LEFT JOIN group_master ON contact_master.c_gid=group_master.g_id  WHERE contact_master.c_gid = '$gid' and contact_master.c_status='Approved' ORDER BY contact_master.c_modifieddate DESC");
        $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid' ORDER BY c_modifieddate DESC");
        $result=$query->result();
        $data['contacts']=$result;

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='$gid' and c_status!='Inactive'");
        $result=$query->result();
        $data['all']=$result;

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='In Process' AND c_gid='$gid'");
        $result=$query->result();
        $data['inprocess']=$result;

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Approved' AND c_gid='$gid'");
        $result=$query->result();
        $data['approved']=$result;

        $query=$this->db->query("SELECT * FROM contact_master WHERE (c_status='Pending' or c_status='Delete') AND c_gid='$gid'");
        $result=$query->result();
        $data['pending']=$result;

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Rejected' AND c_gid='$gid'");
        $result=$query->result();
        $data['rejected']=$result;

        $data['maker_checker'] = $this->session->userdata('maker_checker');
    }

    return $data;
}

function check_availablity($gid, $c_id, $c_name, $c_last_name, $email_id1, $mobile_no1){
    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$c_id'");
    $result=$query->result();
    if(count($result)>0){
        $c_fkid=$result[0]->c_fkid;
    } else {
        $c_fkid='';
    }

    $this->db->select('*');
    $this->db->where('c_id != ', $c_id);
    $this->db->where('c_id != ', $c_fkid);
    $this->db->where("(c_fkid != '$c_id' OR c_fkid Is Null)");
    $this->db->where('c_gid', $gid);
    $this->db->where('c_name', $c_name);
    $this->db->where('c_last_name', $c_last_name);
    $this->db->where('c_emailid1', $email_id1);
    $this->db->where('c_mobile1', $mobile_no1);
    $this->db->from('contact_master');
    $query = $this->db->get();
    if( $query->num_rows() != 0 ){
        return 1;
    }else{
        return 0;
    }
}

function check_contact_availablity($gid, $c_name, $c_last_name, $email_id1, $mobile_no1, $c_id){
    $this->db->select('*');
    $this->db->where('c_gid', $gid);
    $this->db->where('c_name', $c_name);
    $this->db->where('c_last_name', $c_last_name);
    $this->db->where('c_emailid1', $email_id1);
    $this->db->where('c_mobile1', $mobile_no1);

    if(isset($c_id)){
        if($c_id!=''){
            $this->db->where('c_id != ', $c_id);
        }
    }

    $this->db->from('contact_master');
    $query = $this->db->get();
    if( $query->num_rows() != 0 ){
        return 1;
    }else{
        return 0;
    }
}

function get_m_status($doc_name, $doc_type){
    $this->db->select('*');
    $this->db->where('d_documentname', $doc_name);
    // $this->db->where('d_type', $doc_type);
    $this->db->like('d_type', $doc_type);
    $this->db->where('d_cat_individual', 'Yes');
    $this->db->from('document_master');
    $query = $this->db->get();

    if( $query->num_rows() == 0 ){
        return 'Yes';
    }else{
        $result = $query->result();
        if ($result[0]->d_m_status=="Yes"){
            return 'Yes';
        } else {
            return 'No';
        }
    }
}

}
?>