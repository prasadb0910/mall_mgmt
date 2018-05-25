<?php
/* 
 * File Name: mst_area_unit_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class mst_area_unit_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_area_unit_list()
    {
        $sql= 'select * from mst_area_unit';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch all mst_area_unit records
    function get_active_area_units()
    {
        $this->db->select('id as area_unit_id, unit as area_unit');
        $this->db->where('status', 'Active');
        $this->db->from('mst_area_unit');
        $query = $this->db->get();
        return $query->result();
    }
    
    //fetch mst_area_unit record by id
    function get_area_unit($id)
    {
        $this->db->where('id', $id);
        $this->db->from('mst_area_unit');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_area_unit($data)
    {
        //insert the form data into database
        $this->db->insert('mst_area_unit', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_area_unit($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('mst_area_unit',$data);

        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_area_unit($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('mst_area_unit',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_area_unit($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('mst_area_unit',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_area_unit($id)->result();
        $this->db->insert('mst_area_unit_log', $data[0]);
    }
    
}
?>