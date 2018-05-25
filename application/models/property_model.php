<?php
/* 
 * File Name: property_details_model.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class property_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    //fetch all property_details records
    function get_property_details_list()
    {
        $sql= 'select a.id, ifnull(b.client_name,"") as client_name, a.status, a.property_mode, a.property_type, a.property_name, ' .
              'a.display_name, a.address, a.state, a.city, a.pincode, a.property_description, a.carpet_area, a.builtup_area from ' .
              '(select id, fk_client_id, status, property_mode, property_type, property_name, display_name, ' .
              'address, state, city, pincode, property_description, carpet_area, builtup_area from property_details) a ' .
              'Left Join ' .
              '(select id, concat(ifnull(first_name,''), " ", ifnull(last_name,'')) as client_name from client_details) b on a.fk_client_id = b.id';
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    //fetch all broker_details records
    function get_active_properties()
    {
        $this->db->select('id as property_id, display_name as property_name');
        $this->db->where('status', 'Active');
        $this->db->from('property_details');
        $query = $this->db->get();
        return $query->result();
    }
    
    //fetch property_details record by id
    function get_property_details($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_details');
        $query = $this->db->get();
        return $query;
    }
    
    function validate_property_details($id, $email_id, $mobile_no)
    {
        $sql = "select * from property_details where id <> '". $id ."' and (email_id = '" . $email_id . "' or mobile_no = '" . $mobile_no . "')" ;
        $query = $this->db->query($sql);
        return $query;
    }
    
    function insert_property($data)
    {
        //insert the form data into database
        $this->db->insert('property_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        $this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_details',$data);

        //insert the log data into database
        $this->set_log($id);
    }
    
    function enable_property($id, $session_id)
    {
        //enable property record
        $data=array('status'=>'Active',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_details',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function disable_property($id, $session_id)
    {
        //disable property record
        $data=array('status'=>'InActive',
//                    'modified_by'=>$this->session->userdata('session_id'),
                    'modified_by'=>$session_id,
                    'modified_date'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update('property_details',$data);
        
        //insert the log data into database
        $this->set_log($id);
    }
    
    function set_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_details($id)->result();
        $this->db->insert('property_details_log', $data[0]);
    }
    
    
    
    //fetch property_area_details record by property id
    function get_property_details_by_property_area_id($id)
    {
        $sql = "select a.id, b.id as property_id, b.fk_client_id as client_id from property_area_details a, property_details b " .
               "where a.id = '". $id ."' and a.fk_property_id = b.id" ;
        $query = $this->db->query($sql);
        return $query;
    }
    function get_property_area_details_by_property_id($id)
    {
        $this->db->where('fk_property_id', $id);
        $this->db->from('property_area_details');
        $query = $this->db->get();
        return $query;
    }
    function get_property_area_details_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_area_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_area($data)
    {
        //insert the form data into database
        $this->db->insert('property_area_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        //$this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_area($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_area_details',$data);

        //insert the log data into database
        //$this->set_log($id);
    }
    
    function set_property_area_details_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_area_details_by_id($id)->result();
        $this->db->insert('property_area_details_log', $data[0]);
    }
    
    
    
    //fetch property_purchase_details record by property id
    function get_property_purchase_details_by_property_id($id)
    {
        $this->db->where('fk_property_id', $id);
        $this->db->from('property_purchase_details');
        $query = $this->db->get();
        return $query;
    }
    function get_property_purchase_details_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_purchase_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_purchase_details($data)
    {
        //insert the form data into database
        $this->db->insert('property_purchase_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        //$this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_purchase_details($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_purchase_details',$data);

        //insert the log data into database
        //$this->set_log($id);
    }
    
    function set_property_purchase_details_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_purchase_details_by_id($id)->result();
        $this->db->insert('property_purchase_details_log', $data[0]);
    }
    
    
    //fetch property_document_details record by property id
    function get_property_details_by_property_document_id($id)
    {
        $sql = "select a.id, b.id as property_id, b.fk_client_id as client_id from property_document_details a, property_details b " .
               "where a.id = '". $id ."' and a.fk_property_id = b.id" ;
        $query = $this->db->query($sql);
        return $query;
    }
    function get_property_document_details_by_property_id($id)
    {
        $this->db->where('fk_property_id', $id);
        $this->db->from('property_document_details');
        $query = $this->db->get();
        return $query;
    }
    function get_property_document_details_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_document_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_document_details($data)
    {
        //insert the form data into database
        $this->db->insert('property_document_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        //$this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_document_details($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_document_details',$data);

        //insert the log data into database
        //$this->set_log($id);
    }
    
    function set_property_document_details_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_document_details_by_id($id)->result();
        $this->db->insert('property_document_details_log', $data[0]);
    }
    
    
    
    //fetch property_loan_details record by property id
    function get_property_loan_details_by_property_id($id)
    {
        $this->db->where('fk_property_id', $id);
        $this->db->from('property_loan_details');
        $query = $this->db->get();
        return $query;
    }
    function get_property_loan_details_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_loan_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_loan_details($data)
    {
        //insert the form data into database
        $this->db->insert('property_loan_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        //$this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_loan_details($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_loan_details',$data);

        //insert the log data into database
        //$this->set_log($id);
    }
    
    function set_property_loan_details_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_loan_details_by_id($id)->result();
        $this->db->insert('property_loan_details_log', $data[0]);
    }
    
    
    
    //fetch property_maintenance_details record by property id
    function get_property_maintenance_details_by_property_id($id)
    {
        $this->db->where('fk_property_id', $id);
        $this->db->from('property_maintenance_details');
        $query = $this->db->get();
        return $query;
    }
    function get_property_maintenance_details_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->from('property_maintenance_details');
        $query = $this->db->get();
        return $query;
    }
    
    function insert_property_maintenance_details($data)
    {
        //insert the form data into database
        $this->db->insert('property_maintenance_details', $data);
        $data['id'] = $this->db->insert_id();

        //insert the log data into database
        //$this->set_log($data['id']);
        
        return $data['id'];
    }
    
    function update_property_maintenance_details($data)
    {
        //update the form data into database
        $id = $data['id'];
        $this->db->where('id',$id);
        $this->db->update('property_maintenance_details',$data);

        //insert the log data into database
        //$this->set_log($id);
    }
    
    function set_property_maintenance_details_log($id)
    {
        //insert the log data into database
        $data=$this->get_property_maintenance_details_by_id($id)->result();
        $this->db->insert('property_maintenance_details_log', $data[0]);
    }
}
?>