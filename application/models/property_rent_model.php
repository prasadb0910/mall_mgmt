<?php
/* 
 * File Name: property_rent_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class property_rent_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_property_rent_list()
    {
        $sql= 'select c.id, c.client_name, d.property, c.status, c.rent_amount, c.deposit_amount, c.deposit_paid_date, c.possission_date, ' .
              'c.lease_period, c.rent_due_date, c.termination_date from ' . 
              '(select a.id, ifnull(b.client_name,"") as client_name, a.fk_property_id, a.status, a.rent_amount, a.deposit_amount, a.deposit_paid_date, ' .
              'a.possission_date, a.lease_period, a.rent_due_date, a.termination_date from ' .
              '(select id, fk_client_id, fk_property_id, status, rent_amount, deposit_amount, deposit_paid_date, possission_date, ' .
              'lease_period, rent_due_date, termination_date from property_rent) a ' .
              'Left Join ' .
              '(select id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as client_name from client_details) b on a.fk_client_id = b.id) c ' .
              'Left Join ' .
              '(select id, display_name as property from property_details) d on c.fk_property_id = d.id';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch property_rent_details record by id
    function get_property_rent($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_rent');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_rent($data)
    {
        //insert the form data into database
        $this->db->insert('property_rent', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_rent($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_rent',$data);

        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_property_rent($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_rent',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_property_rent($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_rent',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_rent($id)->result();
        $this->db->insert('property_rent_log', $data[0]);
    }
    
}
?>