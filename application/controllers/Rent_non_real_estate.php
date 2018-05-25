<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent_non_real_estate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
        $this->load->model("rent_model");
        $this->load->model('document_model');
    }

    public function index() {
         $this->load->view('Rent_non_real_estate/rent_non_real_estate_list');
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

            $docs=$this->document_model->add_new_doc('', 'rent');
            $data=array_merge($data, $docs);

            load_view('Rent_non_real_estate/rent_non_real_estate_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
        //$this->load->view('Rent_real_estate/rent_real_estate_details');
    }

	public function view() {
       $this->load->view('Rent_non_real_estate/rent_non_real_estate_view');
    }


    public function checkstatus($status=''){
            $result=$this->purchase_model->getAccess();
            $data['access']=$result;
                $data['property']=$this->purchase_model->purchaseData($status,'','2');

                $count_data=$this->purchase_model->getAllCountData();
                $approved=0;
                $pending=0;
                $rejected=0;
                $inprocess=0;

                if (count($count_data)>0){
                    for($i=0;$i<count($count_data);$i++){
                        if (strtoupper(trim($count_data[$i]->txn_status))=="APPROVED")
                            $approved=$approved+1;
                        else if (strtoupper(trim($count_data[$i]->txn_status))=="PENDING" || strtoupper(trim($count_data[$i]->txn_status))=="DELETE")
                            $pending=$pending+1;
                        else if (strtoupper(trim($count_data[$i]->txn_status))=="REJECTED")
                            $rejected=$rejected+1;
                        else if (strtoupper(trim($count_data[$i]->txn_status))=="IN PROCESS")
                            $inprocess=$inprocess+1;
                    }
                }

                $data['approved']=$approved;
                $data['pending']=$pending;
                $data['rejected']=$rejected;
                $data['inprocess']=$inprocess;
                $data['all']=count($count_data);

                $data['checkstatus'] = $status;
                $data['maker_checker'] = $this->session->userdata('maker_checker');

               // load_view('Rent_non_real_estate/rent_non_real_estate_list', $data);


                /*if(count($result)>0) {
                } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
                }*/
    }

    



}
?>