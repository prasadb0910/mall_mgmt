<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Accounts extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('accounts_model','accounting_model');
    }


    public function index()
    {
        $this->checkstatus('All');
    }

    public function checkstatus($status='', $property_id='', $contact_id=''){
        
               echo $this->accounting_model->getPendingBankEntry($status, $property_id, $contact_id);
          
            load_view('accounting/accounting', $data);

        
    }
}