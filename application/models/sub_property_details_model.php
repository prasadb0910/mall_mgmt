<?php
/* 
 * File Name: sub_property_details_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class sub_property_details_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_sub_property_details_list()
    {
        $sql= 'select * from sub_property_details';
        $query = $this->db->query($sql);
        return $query;
//        return $query->result();
    }
    
    //fetch sub_property_details_details record by id
    function get_sub_property_details($id)
    {
        $this->db->where('id', $id);
        $this->db->from('sub_property_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_sub_property_details($data)
    {
        //insert the form data into database
        $this->db->insert('sub_property_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return TRUE;
//        return $data['id'];
    }
    
    function update_sub_property_details($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('sub_property_details',$data);
        
        return TRUE;
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function delete_sub_property_details($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->delete('sub_property_details');
        
        return TRUE;
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_sub_property_details($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('sub_property_details',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_sub_property_details($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('sub_property_details',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_sub_property_details($id)->result();
        $this->db->insert('sub_property_details_log', $data[0]);
    }
    
}
?>