<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Property extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');

    }

    public function index() {

       $this->checkstatus('All');
    }

    public function real_estate() {

       $this->checkstatus('All','1');
    }

    public function non_real_estate() {

        $this->checkstatus('All','2');
    }


	public function add() {
        $gid=$this->session->userdata('groupid');
        $result = $this->db->query("call sp_getcontact('Approved','$gid','Owners')")->result();
        mysqli_next_result( $this->db->conn_id );
        $data['owner']=$result;
        
        $sresult = $this->db->query("call sp_getcontact('Approved','$gid','')")->result();
        mysqli_next_result( $this->db->conn_id );
        $data['contact']=$sresult;
        $data['maker_checker'] = $this->session->userdata('maker_checker');
    
        load_view('Real_estate_property/real_estate_property_details',$data);
    }

    public function saverecord()
    {
        if($this->input->post('submit')=='Submit For Approval') {
            $txn_status='Pending';
        } else if($this->input->post('submit')=='Submit') {
            $txn_status='Approved';
        } else {
            $txn_status='In Process';
        }

        $pid=$this->purchase_model->insertRecord($txn_status);
        $this->purchase_model->insertImage($pid);
        $this->purchase_model->insertOwnershipDetails($pid);
        redirect(base_url().'index.php/real_estate_property');
    }

    


	public function View() {
       $this->load->view('Real_estate_property/real_estate_property_view');
    }

    public function checkstatus($status='',$property_type_id=''){
            $result=$this->purchase_model->getAccess();
            $data['access']=$result;
                $data['property']=$this->purchase_model->purchaseData($status,'',$property_type_id);

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
                $data['property_type_id']=$property_type_id;

                load_view('Real_estate_property/real_estate_property_list', $data);


                /*if(count($result)>0) {
                } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
                }*/
    }

}
?>