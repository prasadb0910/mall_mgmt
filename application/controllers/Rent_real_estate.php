<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent_real_estate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("rent_model");
        $this->load->model('document_model');
    }

    public function index() {

       $this->load->view('Rent_real_estate/rent_real_estate_list');
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
            
            load_view('Rent_real_estate/rent_real_estate_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
        //$this->load->view('Rent_real_estate/rent_real_estate_details');
    }
    public function view() {
       $this->load->view('Rent_real_estate/rent_real_estate_view');
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
            $this->rent_model->insertEscalationDetails($rid);
            $this->rent_model->insertPDCDetails($rid);
            $this->rent_model->insertUtilityDetails($rid);
            $this->rent_model->insertNotificationDetails($rid);

            $this->rent_model->insertOtherAmtDetails($rid);

            $this->document_model->insert_doc($rid, 'Property_Rent');

            $this->rent_model->setSchedule($rid, $txn_status);

            $this->rent_model->setOtherSchedule($rid, $txn_status);

            $this->rent_model->send_rent_intimation($rid);
            if($this->input->post('revenue_due_day')!="")    
                $this->rent_model->revenueSchedule($rid,$this->input->post('property'));

            redirect(base_url().'index.php/Rent_real_estate');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


    public function revenue_sharing(){
        $currentdate = date("Y-m-d");

        $sql = "Select * from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.net_amount from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E Where tenant_id is not null and property_id is not null  GROUP BY txn_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        $this->db->last_query();
        if(count($result)>0){

            for($i=0; $i<count($result); $i++)
            {
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                $termination_date = $result[$i]->termination_date;
                $invoice_month =  date("F", strtotime($termination_date));
                 $termination_date1_40 =  date('Y-m-d',strtotime('-40 days',strtotime($termination_date)));
                 $termination_date1_30 =  date('Y-m-d',strtotime('-30 days',strtotime($termination_date)));
                 $termination_date1_10 =  date('Y-m-d',strtotime('-10 days',strtotime($termination_date)));

                $event_date = $result[$i]->event_date;
                $property_id = $result[$i]->property_id;
                if($property_id!=""){
                    $result_prop = $this->db->select("p_property_name")->where("txn_id=$property_id")->get("purchase_txn")->result();
                    if($result_prop>0)
                      $property_name=   $result_prop[0]->p_property_name;
                }
                $tenant_id = $result[$i]->tenant_id;
                $net_amount = $result[$i]->net_amount;
                 $owners = $this->purchase_model->get_property_owners($property_id);
                if(count($owners)>0){
                      $owner_name = $owners[0]->owner_name;
                      $owner_email = $owners[0]->c_emailid1;
                }

                $tenent = $this->get_contact_personname($tenant_id);
                if(count($tenent)>0){
                     $tenent_name = $tenent[0]->owner_name;
                     $tenent_email = $tenent[0]->c_emailid1;
                } 

                if($termination_date1_40==$currentdate || $termination_date1_30==$currentdate || $termination_date1_10==$currentdate)
                {   

                 $message= '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>Please note lease term of <b>'.$property_name.'</b> property is expiring on <b>'.date('d-m-Y',strtotime($termination_date)).'</b></p>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>'; 
                    $subject = "Lease expiring for  ".$property_name." property on  ".date('d-m-Y',strtotime($termination_date));
                    send_email($from_email='',"Pecan Reams", $owner_email, $subject, $message);
                    send_email($from_email='',$owner_name, $tenent_email, $subject, $message);
                }
                /*$tenant_id = 571;
                $tenent = $this->get_contact_personname($tenant_id);
                if(count($tenent)>0){
                     $tenent_name = $tenent[0]->owner_name;
                     $tenent_email = $tenent[0]->c_emailid1;
                }*/
            }
        }
    }

    //$status='',$property_type_id=''
    public function checkstatus($status='', $property_id='', $contact_id=''){
        $result=$this->rent_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['rent']=$this->rent_model->rentData($status, $property_id, '', $contact_id);

            $count_data=$this->rent_model->getAllCountData($contact_id);
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
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

            $data['contact_id']=$contact_id;
            
            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['checkstatus'] = $status;
            $data['propertynorent']=$this->rent_model->getPropertyNotOnRent();

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('rent/tenant_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

       

}
?>