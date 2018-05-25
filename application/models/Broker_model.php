<?php
/* 
 * File Name: broker_details_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Broker_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all broker_details records
    function get_broker_details_list()
    {
        $this->db->from('broker_details');
        $query = $this->db->get();
        return $query->result();
    }
    
    //fetch broker_details record by id
    function get_broker_details($id)
    {
        $this->db->where('id', $id);
        $this->db->from('broker_details');
        $query = $this->db->get();
        return $query;
    }
    
    //fetch all broker_details records
    function get_active_brokers()
    {
        $this->db->select('id as broker_id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as broker_name');
        $this->db->where('status', 'Active');
        $this->db->from('broker_details');
        $query = $this->db->get();
        return $query->result();
    }
    
    function validate_broker_details($id, $email_id, $mobile_no)
    {
        $sql = "select * from broker_details where id <> '". $id ."' and (email_id = '" . $email_id . "' or mobile_no = '" . $mobile_no . "')" ;
//        $this->db->where("(email_id='Tove' OR mobile_no='Ola' OR Gender='M' OR Country='India')", NULL, FALSE);
//        $this->db->from('broker_details');
//        $query = $this->db->get();
        $query = $this->db->query($sql);
        return $query;
    }
    
    function insert_broker($data)
    {
        //insert the form data into database
        $this->db->insert('broker_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        $this->set_log($data['id']);
    }
    
    function update_broker($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('broker_details',$data);

        //insert the log data into database
        $this->set_log($id);
    }
    
    function enable_broker($id, $session_id)
    {
        //enable broker record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('broker_details',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function disable_broker($id, $session_id)
    {
        //disable broker record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('broker_details',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_broker_details($id)->result();
        $this->db->insert('broker_details_log', $data[0]);
    }
}
?>