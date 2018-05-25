<?php
/* 
 * File Name: client_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class client_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all client_details records
    function get_client_details_list()
    {
        $sql= 'select c.id, ifnull(d.group_name,"") as group_name, c.broker_name, c.status, c.first_name, c.middle_name, ' .
              'c.last_name, c.gender, DATE_FORMAT(c.date_of_birth,"%d-%b-%Y") as date_of_birth, c.address, c.state, ' .
              'c.city, c.pincode, c.email_id, c.mobile_no, c.tel_res, c.pan_no, c.organisation, c.category, c.occupation, ' .
              'c.guardian, c.relation, c.photo_file, c.pan_file, c.address_file from ' .
              '(select a.id, fk_group_id, ifnull(b.broker_name,"") as broker_name, a.status, a.first_name, a.middle_name, ' .
              'a.last_name, a.gender, DATE_FORMAT(a.date_of_birth,"%d-%b-%Y") as date_of_birth, a.address, a.state, a.city, ' .
              'a.pincode, a.email_id, a.mobile_no, a.tel_res, a.pan_no, a.organisation, a.category, a.occupation, a.guardian, ' .
              'a.relation, a.photo_file, a.pan_file, a.address_file from ' .
              '(select id, fk_group_id, fk_broker_id, status, first_name, middle_name, last_name, gender, date_of_birth, ' .
              'address, state, city, pincode, email_id, mobile_no, tel_res, pan_no, organisation, category, occupation, ' .
              'guardian, relation, photo_file, pan_file, address_file from client_details) a ' .
              'Left Join ' .
              '(select id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as broker_name from broker_details) b on a.fk_broker_id = b.id) c ' .
              'Left Join ' .
              '(select id, group_name from group_details) d on c.fk_group_id = d.id';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch all broker_details records
    function get_active_clients()
    {
        $this->db->select('id as client_id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as client_name');
        $this->db->where('status', 'Active');
        $this->db->from('client_details');
        $query = $this->db->get();
        return $query->result();
    }
    
    //fetch client_details record by id
    function get_client_details($id)
    {
        $this->db->where('id', $id);
        $this->db->from('client_details');
        $query = $this->db->get();
        return $query;
    }
    
    function validate_client_details($id, $email_id, $mobile_no)
    {
        $sql = "select * from client_details where id <> '". $id ."' and (email_id = '" . $email_id . "' or mobile_no = '" . $mobile_no . "')" ;
//        $this->db->where("(email_id='Tove' OR mobile_no='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
//        $this->db->from('client_details');
//        $query = $this->db->get();
        $query = $this->db->query($sql);
        return $query;
    }
    
    function insert_client($data)
    {
        //insert the form data into database
        $this->db->insert('client_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_client($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('client_details',$data);

        //insert the log data into database
        $this->set_log($id);
    }
    
    function enable_client($id, $session_id)
    {
        //enable client record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('client_details',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function disable_client($id, $session_id)
    {
        //disable client record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('client_details',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_client_details($id)->result();
        $this->db->insert('client_details_log', $data[0]);
    }
}
?>