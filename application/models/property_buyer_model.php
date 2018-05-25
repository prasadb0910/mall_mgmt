<?php
/* 
 * File Name: property_buyer_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class property_buyer_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_property_buyer_list()
    {
        $sql= 'select c.id, c.client_name, d.property, c.status, c.buyer_name, c.buyer_address, c.buyer_pan, c.buyer_contact_no, ' .
              'c.buyer_email_id, c.sales_consideration, c.stamp_duty, c.registration, c.brokerage, c.loan_release, c.profit_or_loss, c.derived_profit_or_loss from ' . 
              '(select a.id, ifnull(b.client_name,"") as client_name, a.fk_property_id, a.status, a.buyer_name, a.buyer_address, a.buyer_pan, ' .
              'a.buyer_contact_no, a.buyer_email_id, a.sales_consideration, a.stamp_duty, a.registration, a.brokerage, a.loan_release, a.profit_or_loss, a.derived_profit_or_loss from ' .
              '(select id, fk_client_id, fk_property_id, status, buyer_name, buyer_address, buyer_pan, buyer_contact_no, ' .
              'buyer_email_id, sales_consideration, stamp_duty, registration, brokerage, loan_release, profit_or_loss, derived_profit_or_loss from property_buyer) a ' .
              'Left Join ' .
              '(select id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as client_name from client_details) b on a.fk_client_id = b.id) c ' .
              'Left Join ' .
              '(select id, display_name as property from property_details) d on c.fk_property_id = d.id';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch property_buyer_details record by id
    function get_property_buyer($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_buyer');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_buyer($data)
    {
        //insert the form data into database
        $this->db->insert('property_buyer', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_buyer($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_buyer',$data);

        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_property_buyer($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_buyer',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_property_buyer($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_buyer',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_buyer($id)->result();
        $this->db->insert('property_buyer_log', $data[0]);
    }
    
}
?>