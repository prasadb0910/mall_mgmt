<?php
/* 
 * File Name: property_tenant_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class property_tenant_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_property_tenant_list()
    {
        $sql= 'select c.id, c.client_name, d.property, c.status, c.first_name, c.middle_name, c.last_name, c.address, ' .
              'c.email_id, c.mobile_no, c.tel_res, c.category, c.occupation from ' . 
              '(select a.id, ifnull(b.client_name,"") as client_name, a.fk_property_id, a.status, a.first_name, a.middle_name, a.last_name, ' .
              'a.address, a.email_id, a.mobile_no, a.tel_res, a.category, a.occupation from ' .
              '(select id, fk_client_id, fk_property_id, status, first_name, middle_name, last_name, address, ' .
              'email_id, mobile_no, tel_res, category, occupation from property_tenant) a ' .
              'Left Join ' .
              '(select id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as client_name from client_details) b on a.fk_client_id = b.id) c ' .
              'Left Join ' .
              '(select id, display_name as property from property_details) d on c.fk_property_id = d.id';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch property_tenant_details record by id
    function get_property_tenant($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_tenant');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_tenant($data)
    {
        //insert the form data into database
        $this->db->insert('property_tenant', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_tenant($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_tenant',$data);

        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_property_tenant($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_tenant',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_property_tenant($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_tenant',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_tenant($id)->result();
        $this->db->insert('property_tenant_log', $data[0]);
    }
    
}
?>