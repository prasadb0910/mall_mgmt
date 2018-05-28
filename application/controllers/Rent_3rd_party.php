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
        $this->load->model('purchase_model');
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
            $data['property']=$this->db->query("SELECT unit_name,property_txn_id,property_txn_id from sales_txn st left join property_txn pt on st.property_id=pt.property_txn_id")->result(); 
            //$this->rent_model->getPropertyDetails();
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
    
     public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');

            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $deposit_paid_date=$this->input->post('deposit_paid_date');
            if(validateDate($deposit_paid_date)) {
                $deposit_paid_date=FormatDate($deposit_paid_date);
            } else {
                $deposit_paid_date=null;
            }

            $possession_date=$this->input->post('possession_date');
            if(validateDate($possession_date)) {
                $possession_date=FormatDate($possession_date);
            } else {
                $possession_date=null;
            }

            $termination_date=$this->input->post('termination_date');
            if(validateDate($termination_date)) {
                $termination_date=FormatDate($termination_date);
            } else {
                $termination_date=null;
            }

            $invoice_date=$this->input->post('invoice_date');
            if(validateDate($invoice_date)) {
                $invoice_date=FormatDate($invoice_date);
            } else {
                $invoice_date=null;
            }

            $sub_property_id = $this->input->post('sub_property');
            if($sub_property_id==''){
                $sub_property_id = null;
            }

            $data = array(
                'gp_id' => $gid,
                'property_id' => $this->input->post('property'),
                'sub_property_id' => $sub_property_id,
                'tenant_id' => $this->input->post('owners'),
                'attorney_id'=>$this->input->post('attorney'),
                'rent_amount' => format_number($this->input->post('rent_amount'),2),
                'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                'deposit_paid_date' => $deposit_paid_date,
                'possession_date' => $possession_date,
                'lease_period' => format_number($this->input->post('lease_period'),2),
                'locking_period'=> format_number($this->input->post('locking_period'),2),
                'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                'termination_date' => $termination_date,
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'maker_remark' => $this->input->post('maker_remark'),
                'maintenance_by' => $this->input->post('maintenance_by'),
                'property_tax_by' => $this->input->post('property_tax_by'),
                'notice_period' => $this->input->post('notice_period'),
                'category' => $this->input->post('category'),
                'schedule' => $this->input->post('schedule'),
                'invoice_date' => $invoice_date,
                'gst' => ($this->input->post('gst')=='yes'?'1':'0'),
                'gst_rate' => format_number($this->input->post('gst_rate'),2),
                'tds' => ($this->input->post('tds')=='yes'?'1':'0'),
                'tds_rate' => format_number($this->input->post('tds_rate'),2),
                'pdc' => ($this->input->post('pdc')=='yes'?'1':'0'),
                'deposit_category' => $this->input->post('deposit_category'),
                'rent_type' => $this->input->post('rent_type'),
                'rent_module_type' => $this->input->post('rent_module_type'),
                'revenue_percentage' => ($this->input->post('revenue_percentage')!=""?$this->input->post('revenue_percentage'):''),
                'revenue_due_day' => ($this->input->post('revenue_due_day')!=""?$this->input->post('revenue_due_day'):NULL),
                'advance_rent' => ($this->input->post('advance_rent')=='yes'?'1':'0'),
                'advance_rent_amount' => ($this->input->post('advance_rent_amount')!=""?format_number($this->input->post('advance_rent_amount'),2):'')
                 );
            $this->db->insert('rent_txn', $data);
            $rid=$this->db->insert_id();    
            //$this->db->last_query();        
            $logarray['table_id']=$rid;
            $logarray['module_name']='Rent';
            $logarray['cnt_name']='Rent';
            $logarray['action']='Rent Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            // $response_purchase_consideration=$this->rent_model->insertSchedule($rid, $txn_status);

            $this->rent_model->insertTenantDetails($rid);
            $this->rent_model->setSchedule($rid, $txn_status);

            redirect(base_url().'index.php/Rent_real_estate');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    

}
?>