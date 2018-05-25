<?php
/* 
 * File Name: group_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Group_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_group_list()
    {
        $sql= 'select * from group_details';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch all group_details records
    function get_active_groups()
    {
        $this->db->select('id as group_id, group_name');
        $this->db->where('status', 'Active');
        $this->db->from('group_details');
        $query = $this->db->get();
        return $query->result();
    }
    
    //fetch group_details record by id
    function get_group($id)
    {
        $this->db->where('id', $id);
        $this->db->from('group_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_group($data)
    {
        //insert the form data into database
        $this->db->insert('group_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_group($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('group_details',$data);

        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_group($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('group_details',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_group($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('group_details',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_group($id)->result();
        $this->db->insert('group_log', $data[0]);
    }
    
    function check_contact_availablity($gid, $groupuserid, $groupusername, $groupuserlastname, $groupemail, $groupmobile){
        $this->db->select('*');
        $this->db->where('c_id != ', $groupuserid);
        $this->db->where('c_gid', $gid);
        $this->db->where('c_name', $groupusername);
        $this->db->where('c_last_name', $groupuserlastname);
        $this->db->where('c_emailid1', $groupemail);
        $this->db->where('c_mobile1', $groupmobile);
        $this->db->from('contact_master');
        $query = $this->db->get();
        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function check_email_availablity($gid, $groupemail){
        // $query = $this->db->query("select * from group_users where gu_email='$groupemail' and gu_gid!='$gid' and assigned_role='1' and assigned_status!='Inactive'");
        $query = $this->db->query("select * from contact_master where c_emailid1='$groupemail' and c_gid!='$gid' and c_gid!='0' and c_createdby='0' and c_status='Approved'");
        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function check_group_user_availablity($gid, $guid, $c_emailid1){
        $query = $this->db->query("select * from group_users where gu_email='$c_emailid1' and gu_gid='$gid' and gu_cid!='$guid' and assigned_status!='Inactive'");

        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function check_user_availablity($gid, $guid, $c_emailid1){
        $query = $this->db->query("select * from group_users where gu_email='$c_emailid1' and gu_gid='$gid' and gu_id!='$guid' and assigned_status!='Inactive'");

        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function check_group_availablity($g_id, $group_name){
        $this->db->select('*');
        $this->db->where('g_id != ', $g_id);
        $this->db->where('group_name', $group_name);
        $this->db->from('group_master');
        $query = $this->db->get();
        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }


    public function send_password($g_name, $to_email, $password) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Group - ' . $g_name . ' assigned';
        $message = '<html><head></head><body>Dear Customer<br /><br />
                    We welcome you at PecanReams.com where Rapidly Innovating Technology is interspersed with elements 
                    of Human Touch. We appreciate your decision to take control of your Real Estate investments. 
                    Your <b>Group Owner ID</b> has been created for the <b>group - '.$g_name.'</b> and you have been assigned 
                    all the respective Group Owner Rights which entail Creation, Administration and Management 
                    of a Group. As an Owner of a Group, you would receive timely intimation of any changes/additions 
                    being made in the group by any Assigned User. <br /><br />
                    Please note your login details: <br /><br />
                    Login ID: '.$to_email.'<br />
                    Password: '.$password.'<br /><br />
                    Should there be any requirement clarification, Kindly feel free to mail us at 
                    email ID (usually contact@ or care@) or contact us <br /><br />
                    In reference to your agreement, subscribing to our services, kindly find below the terms and 
                    conditions, which would guide our framework of services.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    }

    public function send_assign_group_email($g_name, $to_email, $password, $assigned_role) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Group - ' . $g_name . ' assigned';
        $message = '<html><head></head><body>Dear Customer<br /><br />
                    We welcome you at PecanReams.com where Rapidly Innovating Technology is interspersed with elements 
                    of Human Touch. We appreciate your decision to take control of your Real Estate investments. 
                    Your <b>User ID</b> has been created for the <b>group - '.$g_name.'</b> and have been assigned 
                    the <b>Role of - '.$assigned_role.'</b>. <br /><br />
                    Please note your login details: <br /><br />
                    Login ID: '.$to_email.'<br />
                    Password: '.$password.'<br /><br />
                    Should there be any requirement clarification, Kindly feel free to mail us at 
                    email ID (usually contact@ or care@) or contact us <br /><br />
                    In reference to your agreement, subscribing to our services, kindly find below the terms and 
                    conditions, which would guide our framework of services.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    }
    
}
?>