<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent_3rd_party extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("rent_model");
        $this->load->model('transaction_model');
        $this->load->model('document_model');

    }

    public function index() {
       $this->load->view('Rent_3rd_party/rent_3rd_party_list');
    }

    public function add() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%rent%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;
            $data['property']= $this->rent_model->getPropertyDetails();
            $gid=$this->session->userdata('groupid');
            $result = $this->db->query("call sp_getcontact('Approved','$gid','Tenants')")->result();
            mysqli_next_result( $this->db->conn_id );
            $data['contact']=$result; 
            $data['tax_details']=$this->rent_model->getAllTaxes('rent');

            $query=$this->db->query("select * from notification_master");
            $result=$query->result();
            $data['notification']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('Rent_3rd_party/rent_3rd_party_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
        //$this->load->view('Rent_real_estate/rent_real_estate_details');
    }
    



}
?>