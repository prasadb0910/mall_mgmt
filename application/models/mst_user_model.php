<?php
/* 
 * File Name: mst_user_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class mst_user_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    //fetch mst_user record by id
    function get_mst_user_record($id)
    {
        $this->db->where('id', $id);
        $this->db->from('mst_user');
        $query = $this->db->get();
        return $query;
    }
    
    //fetch mst_user record by mst_user no
    function get_mst_user_record_by_mst_user_id($id)
    {
        $this->db->where('user_id', $id);
        $this->db->from('mst_user');
        $query = $this->db->get();
        return $query;
    }

    //get department table to populate the department name dropdown
    function get_department()     
    { 
        $this->db->select('department_id');
        $this->db->select('department_name');
        $this->db->from('tbl_department');
        $query = $this->db->get();
        $result = $query->result();

        //array to store department id & department name
        $dept_id = array('-SELECT-');
        $dept_name = array('-SELECT-');

        for ($i = 0; $i < count($result); $i++)
        {
            array_push($dept_id, $result[$i]->department_id);
            array_push($dept_name, $result[$i]->department_name);
        }
        return $department_result = array_combine($dept_id, $dept_name);
    }

    //get designation table to populate the designation dropdown
    function get_designation()     
    { 
        $this->db->select('designation_id');
        $this->db->select('designation_name');
        $this->db->from('tbl_designation');
        $query = $this->db->get();
        $result = $query->result();

        $designation_id = array('-SELECT-');
        $designation_name = array('-SELECT-');

        for ($i = 0; $i < count($result); $i++)
        {
            array_push($designation_id, $result[$i]->designation_id);
            array_push($designation_name, $result[$i]->designation_name);
        }
        return $designation_result = array_combine($designation_id, $designation_name);
    }
	
    //fetch all mst_user records
    function get_mst_user_list()
    {
        $this->db->from('mst_user');
        $query = $this->db->get();
        return $query->result();
    }
    
    function insert_user($data)
    {
        //insert the form data into database
        $this->db->insert('mst_user', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        $this->set_log($data['id']);
    }
    
    function update_user($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('mst_user',$data);

        //insert the log data into database
        $this->set_log($id);
    }
    
    function enable_user($id)
    {
        //disable user record
        $data=array('is_disable'=>'0',
                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('mst_user',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function disable_user($id)
    {
        //disable user record
        $data=array('is_disable'=>'1',
                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('mst_user',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_mst_user_record($id)->result();
        $this->db->insert('mst_user_log', $data[0]);
    }
}
?>