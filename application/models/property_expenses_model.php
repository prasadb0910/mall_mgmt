<?php
/* 
 * File Name: property_expenses_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class property_expenses_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_property_expenses_list()
    {
        $sql= 'select c.id, c.client_name, d.property, c.status, c.vendor_name, c.description, c.amount, c.expense_date, ' .
              'c.payment_mode, c.cheque_no, c.cheque_date, c.bank_name, c.cheque_amount, c.micr_code, c.category from ' . 
              '(select a.id, ifnull(b.client_name,"") as client_name, a.fk_property_id, a.status, a.vendor_name, a.description, a.amount, ' .
              'a.expense_date, a.payment_mode, a.cheque_no, a.cheque_date, a.bank_name, a.cheque_amount, a.micr_code, a.category from ' .
              '(select id, fk_client_id, fk_property_id, status, vendor_name, description, amount, expense_date, ' .
              'payment_mode, cheque_no, cheque_date, bank_name, cheque_amount, micr_code, category from property_expenses) a ' .
              'Left Join ' .
              '(select id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as client_name from client_details) b on a.fk_client_id = b.id) c ' .
              'Left Join ' .
              '(select id, display_name as property from property_details) d on c.fk_property_id = d.id';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch property_expenses_details record by id
    function get_property_expenses($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_expenses');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_expenses($data)
    {
        //insert the form data into database
        $this->db->insert('property_expenses', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
//        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_expenses($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_expenses',$data);

        //insert the log data into database
//        $this->set_log($id);
    }
    
    function enable_property_expenses($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_expenses',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function disable_property_expenses($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_expenses',$data);
        
        //insert the log data into database
//        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_expenses($id)->result();
        $this->db->insert('property_expenses_log', $data[0]);
    }
    
}
?>