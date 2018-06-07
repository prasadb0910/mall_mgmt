<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Accounting extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
        $this->load->model('rent_model');
        $this->load->model('sales_model');
        $this->load->model('loan_model');
        $this->load->model('expense_model');
        $this->load->model('maintenance_model');
        $this->load->model('accounting_model');
    }

    public function index()
    {
        $this->checkstatus('All');
    }

    public function acc(){
       $this->checkstatus('All');
    }

    public function by_daterange(){   
        $this->checkstatus($status='', $property_id='', $contact_id='');
    }

    function getOwners(){
        $sql = "select * from ";
    }

    function getBankEntryUrl(){
        $txn_status = html_escape($this->input->post('txn_status'));
        $payer_id = html_escape($this->input->post('payer_id'));
        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('prop_name'));
        $sub_property_id = html_escape($this->input->post('sub_property'));
        $type = html_escape($this->input->post('type'));
        $method = html_escape($this->input->post('method'));
        $pagetype = html_escape($this->input->post('pagetype'));
        if($txn_status=='' || $txn_status==null){
            $txn_status = 'Approved';
        }
        if($payer_id=='' || $payer_id==null){
            $payer_id = '0';
        }
        if($status=='' || $status==null){
            $status = '0';
        }
        if($property_id=='' || $property_id==null){
            $property_id = '0';
        }
        if($sub_property_id=='' || $sub_property_id==null){
            $sub_property_id = '0';
        } else {
            $sql = "select * from sub_property_allocation where property_id='$property_id' and txn_id='$sub_property_id' and txn_status='Approved'";
            $query=$this->db->query($sql);
            $result=$query->result();
            if(count($result)==0){
                $sub_property_id = '0';
            }
        }

        // $url = base_url()."index.php/accounting/".$method."/".$type."/".$txn_status."/".$payer_id."/".$status."/".$property_id."/".$sub_property_id;
        $url = base_url()."index.php/accounting/edit/".$type."/".$txn_status."/".$payer_id."/".$status."/".$property_id."/".$sub_property_id;
         echo $url;  
    }

    function getBankEntryDetails($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                $data['access']=$result;

                $data['property_details']=$this->accounting_model->getBankEntryDetails($type, $status, $contact_id, $transaction, $property_id, $sub_property_id, $accounting_id);

                $property_id=$data['property_details']['property_id'];

                $data['sub_property']=array();

                // if(isset($transaction)){
                //     if($transaction=='purchase'){
                //         $data['property']=$this->purchase_model->purchaseData("Approved");
                //     }
                // }
                // if(isset($transaction)){
                //     if($transaction=='sale'){
                //         $data['property']=$this->sales_model->salesData("Approved");
                //         $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                //     }
                // }
                // if(isset($transaction)){
                //     if($transaction=='rent'){
                //         $data['property']=$this->rent_model->rentData("Approved");
                //         $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                //     }
                // }
                // if(isset($transaction)){
                //     if($transaction=='loan'){
                //         $query=$this->db->query("select * from loan_txn");
                //         $data['loan_txn']=$query->result();
                //     }
                // }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else (ifnull(A.c_company_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
                $result=$query->result();
                if (count($result)>0) {
                    $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
                                                where b_status='Approved' and b_gid='$gid' and 
                                                b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                    $result=$query->result();
                    $data['banks']=$result;

                    $sql = "select * from property_txn where txn_status = 'approved' and gp_id='$gid' and property_txn_id in (select distinct purchase_id from purchase_ownership_details)";
                    $query=$this->db->query($sql);
                    $data['property']=$query->result();
                } else {
                    $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                    $result=$query->result();
                    $data['banks']=$result;

                    $sql = "select * from property_txn where txn_status = 'approved' and gp_id='$gid'";
                    $query=$this->db->query($sql);
                    $data['property']=$query->result();
                }

                if($property_id!=''){
                    $sql="select * from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();
                }
                
                $sql="select * from expense_category_master where g_id='$gid'";
                $query=$this->db->query($sql);
                $data['expense_category']=$query->result();

                return $data;

                // load_view('accounting/accounting_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getOtherScheduleDetail($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                $data['access']=$result;

                $data['property_details']=$this->accounting_model->getOtherScheduleDetail($type, $status, $contact_id, $transaction, $property_id, $sub_property_id, $accounting_id);

                $property_id=$data['property_details']['property_id'];

                $data['sub_property']=array();

                // if(isset($transaction)){
                //     if($transaction=='purchase'){
                //         $data['property']=$this->purchase_model->purchaseData("Approved");
                //     }
                // }
                // if(isset($transaction)){
                //     if($transaction=='sale'){
                //         $data['property']=$this->sales_model->salesData("Approved");
                //         $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                //     }
                // }
                // if(isset($transaction)){
                //     if($transaction=='rent'){
                //         $data['property']=$this->rent_model->rentData("Approved");
                //         $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                //     }
                // }
                // if(isset($transaction)){
                //     if($transaction=='loan'){
                //         $query=$this->db->query("select * from loan_txn");
                //         $data['loan_txn']=$query->result();
                //     }
                // }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
                $result=$query->result();
                if (count($result)>0) {
                    $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
                                                where b_status='Approved' and b_gid='$gid' and 
                                                b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                    $result=$query->result();
                    $data['banks']=$result;

                    $sql = "select * from purchase_txn where txn_status = 'approved' and gp_id='$gid' and txn_id in (select distinct purchase_id from purchase_ownership_details 
                            where pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))";
                    $query=$this->db->query($sql);
                    $data['property']=$query->result();
                } else {
                    $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                    $result=$query->result();
                    $data['banks']=$result;

                    $sql = "select * from purchase_txn where txn_status = 'approved' and gp_id='$gid'";
                    $query=$this->db->query($sql);
                    $data['property']=$query->result();
                }

                if($property_id!=''){
                    $sql="select * from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();
                }
                
                $sql="select * from expense_category_master where g_id='$gid'";
                $query=$this->db->query($sql);
                $data['expense_category']=$query->result();

                return $data;

                // load_view('accounting/accounting_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function addnew($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $type=$this->uri->segment(3);
        $status=$this->uri->segment(4);
        
        $dataarray = array();

        $dataarray['other_schedule']='false';
        $dataarray['type']=$type;

        $dataarray['payer_id']=$contact_id;
        $dataarray['transaction']=$transaction;
        $dataarray['property_id']=$property_id;
        $dataarray['sub_property_id']=$sub_property_id;
        $dataarray['accounting_id']=$accounting_id;

        if($type=="payment"  && $transaction!="adhoc" ){
            $dataarray['payment']='selected';
            $dataarray['receipt']='';
            $dataarray['transaction']='Pay';
        }else if($type=="payment" && $transaction=="adhoc" )
        {
            $dataarray['payment']='selected';
            $dataarray['receipt']='';
            $dataarray['transaction']='adhoc';
        }else if($type=="receipt" && $transaction=="adhoc" ){
            $dataarray['payment']='';
            $dataarray['receipt']='selected';
            $dataarray['transaction']='adhoc';
        }else if($type=="receipt" && $transaction!="adhoc" ){
            $dataarray['payment']='';
            $dataarray['receipt']='selected';
            $dataarray['transaction']='Receive';
        }
        else if($type=="expense"){
            $dataarray['payment']='selected';
            $dataarray['receipt']='';
            $dataarray['transaction']='Expense';
            $dataarray['other']='selected';
            $dataarray['txn_type']='other';
            $dataarray['other_schedule']='true';
        } else if($type=="income"){
            $dataarray['payment']='';
            $dataarray['receipt']='selected';
            $dataarray['transaction']='Income';
            $dataarray['other']='selected';
            $dataarray['txn_type']='other';
            $dataarray['other_schedule']='true';
        }

        if($status=="purchase"){
            $dataarray['purchase']='selected';
            $dataarray['txn_type']='purchase';
        } else if($status=="loan"){
            $dataarray['loan']='selected';
            $dataarray['txn_type']='loan';
        } else if($status=="sale"){
            $dataarray['sale']='selected';
            $dataarray['txn_type']='sales';
        } else if($status=="rent"){
            $dataarray['rent']='selected';
            $dataarray['txn_type']='rent';
        } else if($status=="expense"){
            $dataarray['expense']='selected';
            $dataarray['txn_type']='expense';
        } else if($status=="maintenance"){
            $dataarray['maintenance']='selected';
            $dataarray['txn_type']='maintenance';
        } else if($status=="other"){
            $dataarray['other']='selected';
            $dataarray['txn_type']='other';
        } else {
            $dataarray['txn_type']='';
        }

        if($type=="Select"){
            if($status=="purchase"){
                $dataarray['payment']='selected';
            } else if($status=="loan"){
                $dataarray['payment']='selected';
            } else if($status=="sale"){
                $dataarray['receipt']='selected';
            } else if($status=="rent"){
                $dataarray['receipt']='selected';
            } else if($status=="expense"){
                $dataarray['payment']='selected';
            } else if($status=="maintenance"){
                $dataarray['payment']='selected';
            }
        }

        $result=$this->accounting_model->getAccess();
        if(count($result)>0) {

            $data['property_details']= $dataarray;

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
            $result=$query->result();
            if (count($result)>0) {
                $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
                                                where b_status='Approved' and b_gid='$gid' and 
                                                b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                $result=$query->result();
                $data['banks']=$result;

                $sql = "select * from property_txn where txn_status = 'approved' and gp_id='$gid' and property_txn_id in (select distinct purchase_id from purchase_ownership_details)";
                $query=$this->db->query($sql);
                $data['property']=$query->result();
            } else {
                $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                $result=$query->result();
                $data['banks']=$result;

                $sql = "select * from property_txn where txn_status = 'approved' and gp_id='$gid'";
                $query=$this->db->query($sql);
                $data['property']=$query->result();
            }

            $sql="select * from expense_category_master where g_id='$gid'";
            $query=$this->db->query($sql);
            $data['expense_category']=$query->result();

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $data['method'] = 'addnew';

            // echo json_encode($data['expense_category']);

            // echo json_encode($data); 

            load_view('accounting/accounting_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){

                $data = $this->getBankEntryDetails($type, $status, $contact_id, $transaction, $property_id, $sub_property_id, $accounting_id);

                $data['method'] = 'edit';
                load_view('accounting/accounting_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                $data = $this->getBankEntryDetails($type, $status, $contact_id, $transaction, $property_id, $sub_property_id, $accounting_id);

                load_view('accounting/accounting_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editOtherSchedule($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                
                $data = $this->getOtherScheduleDetail($type, $status, $contact_id, $transaction, $property_id, $sub_property_id, $accounting_id);

                // echo json_encode($data['property_details']);

                load_view('accounting/accounting_details',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function viewOtherSchedule($type='', $status='', $contact_id='', $transaction='', $property_id='', $sub_property_id='', $accounting_id=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                $data = $this->getOtherScheduleDetail($type, $status, $contact_id, $transaction, $property_id, $sub_property_id, $accounting_id);

                // echo json_encode($data['property_details']);

                load_view('accounting/accounting_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getBankEntry(){
        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('property_id'));
        $sub_property_id = html_escape($this->input->post('sub_property_id'));

        // $status = 'expense';
        // $property_id = '19';
        // $sub_property_id = '28';

        if($sub_property_id=="" || $sub_property_id==null) {
            $sub_property_id=0;
        }

        $txn_id="";
        $sch_id="";
        if ($status=="purchase") {
            $txn_id=$property_id;

            $query=$this->db->query("select * from purchase_schedule where purchase_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="p_" . $txn_id;
            $sch_id="p_" . $sch_id;
        } else if ($status=="loan") {
            if($sub_property_id==0){
                $cond="(loan_subproperty_id is null or loan_subproperty_id='' or loan_subproperty_id='0')";
            } else {
                $cond="loan_subproperty_id='$sub_property_id'";
            }

            $query=$this->db->query("select * from loan_txn where loan_property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from loan_schedule where loan_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="l_" . $txn_id;
            $sch_id="l_" . $sch_id;
        } else if ($status=="rent") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }

            $query=$this->db->query("select * from rent_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from rent_schedule where rent_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="r_" . $txn_id;
            $sch_id="r_" . $sch_id;
        } else if ($status=="sale") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }
            
            $query=$this->db->query("select * from sales_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from sales_schedule where sale_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="s_" . $txn_id;
            $sch_id="s_" . $sch_id;
        } else if ($status=="expense") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }
            
            $query=$this->db->query("select * from expense_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from expense_schedule where expense_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="e_" . $txn_id;
            $sch_id="e_" . $sch_id;
        } else if ($status=="maintenance") {
            if($sub_property_id==0){
                $cond="(sub_property_id is null or sub_property_id='' or sub_property_id='0')";
            } else {
                $cond="sub_property_id='$sub_property_id'";
            }
            
            $query=$this->db->query("select * from maintenance_txn where property_id = '$property_id' and ".$cond." and txn_status = 'Approved'");
            $result=$query->result();
            if (count($result)>0) {
                $txn_id=$result[0]->txn_id;
            }

            $query=$this->db->query("select * from maintenance_schedule where m_id = '$txn_id' and status = '1'");
            $result=$query->result();
            if (count($result)>0) {
                $sch_id=$result[0]->sch_id;
            }

            $txn_id="m_" . $txn_id;
            $sch_id="m_" . $sch_id;
        } else {
            $txn_id="";
            $sch_id="";
        }

        // echo $sch_id . " " . $txn_id;

        // $this->bankEntry($sch_id, $txn_id);

        $data['sch_id']=$sch_id;
        $data['txn_id']=$txn_id;

        echo json_encode($data);

        // echo "<script>window.open(\"" . base_url() . "/index.php/accounting/bankEntry/" . $sch_id . "/" . $txn_id . "\",\"_parent\",\"true\")</script>";
        // redirect('accounting/bankEntry/' . $sch_id . '/' . $txn_id);
    }
    
    function bankEntryView(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['bankEntryBy']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_view==1 or $result[0]->r_insert==1 or $result[0]->r_edit==1 or $result[0]->r_delete==1 or $result[0]->r_approvals==1){
                $data['access']=$result;

                $fk_txn_id=$this->uri->segment(3);
                $accounting_id=$this->uri->segment(4);
                $entry_type=$this->uri->segment(5);

                $fk_txn_id=explode("_",$fk_txn_id);
                if($fk_txn_id[0]=='o'){
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->accounting_model->getOtherExpenseDetail($fk_txn_id, $accounting_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['property']=$this->purchase_model->purchaseData("Approved");

                    $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();

                    $sql="select * from expense_category_master where g_id='$gid'";
                    $query=$this->db->query($sql);
                    $data['expense_category']=$query->result();

                    $data['property_details']['other_schedule']='false';
                } else if($fk_txn_id[0]=='t'){
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->accounting_model->getOtherScheduleDetail($fk_txn_id, $accounting_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['property']=$this->purchase_model->purchaseData("Approved");

                    $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
                    $query=$this->db->query($sql);
                    $data['sub_property']=$query->result();

                    $data['property_details']['other_schedule']='true';
                } else {
                    $fk_txn_id=implode('_',$fk_txn_id);
                    $data['property_details']=$this->accounting_model->getAllPropertyDetail($fk_txn_id, $accounting_id, $entry_type);

                    $property_id=$data['property_details']['property_id'];
                    $data['sub_property']=array();

                    if(isset($data['property_details']['purchase'])){
                        if($data['property_details']['purchase']=='selected'){
                            $data['property']=$this->purchase_model->purchaseData("Approved");
                        }
                    }
                    if(isset($data['property_details']['sale'])){
                        if($data['property_details']['sale']=='selected'){
                            $data['property']=$this->sales_model->salesData("Approved");
                            $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['rent'])){
                        if($data['property_details']['rent']=='selected') {
                            $data['property']=$this->rent_model->rentData("Approved");
                            $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['loan'])){
                        if($data['property_details']['loan']=='selected') {
                            $query=$this->db->query("select * from loan_txn");
                            $data['loan_txn']=$query->result();
                        }
                    } 
                    if(isset($data['property_details']['expense'])){
                        if($data['property_details']['expense']=='selected'){
                            $data['property']=$this->expense_model->expenseData("Approved");
                            $data['sub_property']=$this->expense_model->expenseData("Approved", $property_id);
                        }
                    } 
                    if(isset($data['property_details']['maintenance'])){
                        if($data['property_details']['maintenance']=='selected'){
                            $data['property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
                            $data['sub_property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved", $property_id);
                        }
                    }
                }

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
                $result=$query->result();
                if (count($result)>0) {
                    $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
                                                where b_status='Approved' and b_gid='$gid' and 
                                                b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                    $result=$query->result();
                    $data['banks']=$result;
                } else {
                    $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                    $result=$query->result();
                    $data['banks']=$result;
                }

                $sql="select * from expense_category_master where g_id='$gid'";
                $query=$this->db->query($sql);
                $data['expense_category']=$query->result();

                load_view('accounting/accounting_view',$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getTds(){
        $result=$this->accounting_model->getAccess();
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        if(count($result)>0) {
            $data['access']=$result;
            $data['bankentry']=$this->accounting_model->tdsData('Approved','','','tds');

             $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
            $result=$query->result();
            if (count($result)>0) {
                $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
                                                where b_status='Approved' and b_gid='$gid' and 
                                                b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                $result=$query->result();
                $data['banks']=$result;

                $sql = "select * from purchase_txn where txn_status = 'approved' and gp_id='$gid' and txn_id in (select distinct purchase_id from purchase_ownership_details 
                        where pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))";
                $query=$this->db->query($sql);
                $data['property']=$query->result();
            } else {
                $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                $result=$query->result();
                $data['banks']=$result;

                $sql = "select * from purchase_txn where txn_status = 'approved' and gp_id='$gid'";
                $query=$this->db->query($sql);
                $data['property']=$query->result();
            }

            // $count_data=$this->accounting_model->bankentryData('All');
            // $approved=0;
            // $pending=0;
            // $rejected=0;
            // $inprocess=0;

            // if (count($result)>0){
            //     for($i=0;$i<count($count_data);$i++){
            //         if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
            //             $approved=$approved+1;
            //         else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
            //             $pending=$pending+1;
            //         else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
            //             $rejected=$rejected+1;
            //         else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
            //             $inprocess=$inprocess+1;
            //     }
            // }

            // $data['approved']=$approved;
            // $data['pending']=$pending;
            // $data['rejected']=$rejected;
            // $data['inprocess']=$inprocess;
            // $data['all']=count($count_data);

            // $data['pendingbankentry']=$this->accounting_model->getPendingBankEntry($status);

            // $data['checkstatus'] = $status;

            // $data['maker_checker'] = $this->session->userdata('maker_checker');''
            $data['startdate'] = trim($this->input->post('start'));
            $data['enddate'] = trim($this->input->post('end'));
            load_view('accounting/tds_details', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getGst(){
        $result=$this->accounting_model->getAccess();
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        if(count($result)>0) {
            $data['access']=$result;
            $data['bankentry']=$this->accounting_model->tdsData('Approved','','','gst');
            $data['startdate'] = trim($this->input->post('start'));
            $data['enddate'] = trim($this->input->post('end'));
            load_view('accounting/gst_details', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateTds(){
        $result=$this->accounting_model->getAccess();

        if(count($result)>0) {
            $form_data=$this->input->post(null,true);
            $this->accounting_model->saveTdsDetails($form_data);
            
            redirect(base_url().'index.php/accounting/getTds');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    // function edit(){
    //     $gid=$this->session->userdata('groupid');
    //     $roleid=$this->session->userdata('role_id');
    //     $session_id=$this->session->userdata('session_id');
    //     $data['bankEntryBy']=$this->session->userdata('session_id');
    //     $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
    //     $result=$query->result();
    //     if(count($result)>0) {
    //         if($result[0]->r_edit==1){
    //             $data['access']=$result;

    //             $fk_txn_id=$this->uri->segment(3);
    //             $accounting_id=$this->uri->segment(4);
    //             $entry_type=$this->uri->segment(5);

    //             $fk_txn_id=explode("_",$fk_txn_id);
    //             if($fk_txn_id[0]=='o'){
    //                 $fk_txn_id=implode('_',$fk_txn_id);
    //                 $data['property_details']=$this->accounting_model->getOtherExpenseDetail($fk_txn_id, $accounting_id, $entry_type);

    //                 $property_id=$data['property_details']['property_id'];
    //                 $data['property']=$this->purchase_model->purchaseData("Approved");

    //                 $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
    //                 $query=$this->db->query($sql);
    //                 $data['sub_property']=$query->result();

    //                 $sql="select * from expense_category_master where g_id='$gid'";
    //                 $query=$this->db->query($sql);
    //                 $data['expense_category']=$query->result();

    //                 $data['property_details']['other_schedule']='false';
    //             } else if($fk_txn_id[0]=='t'){
    //                 $fk_txn_id=implode('_',$fk_txn_id);
    //                 $data['property_details']=$this->accounting_model->getOtherScheduleDetail($fk_txn_id, $accounting_id, $entry_type);

    //                 $property_id=$data['property_details']['property_id'];
    //                 $data['property']=$this->purchase_model->purchaseData("Approved");

    //                 $sql="select txn_id as sub_property_id, sp_name from sub_property_allocation where property_id='$property_id' and txn_status='Approved'";
    //                 $query=$this->db->query($sql);
    //                 $data['sub_property']=$query->result();

    //                 $data['property_details']['other_schedule']='true';
    //             } else {
    //                 $fk_txn_id=implode('_',$fk_txn_id);
    //                 $data['property_details']=$this->accounting_model->getAllPropertyDetail($fk_txn_id, $accounting_id, $entry_type);
    //                 $property_id=$data['property_details']['property_id'];
    //                 $data['sub_property']=array();

    //                 if(isset($data['property_details']['purchase'])){
    //                     if($data['property_details']['purchase']=='selected'){
    //                         $data['property']=$this->purchase_model->purchaseData("Approved");
    //                     }
    //                 }
    //                 if(isset($data['property_details']['sale'])){
    //                     if($data['property_details']['sale']=='selected'){
    //                         $data['property']=$this->sales_model->salesData("Approved");
    //                         $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
    //                     }
    //                 } 
    //                 if(isset($data['property_details']['rent'])){
    //                     if($data['property_details']['rent']=='selected') {
    //                         $data['property']=$this->rent_model->rentData("Approved");
    //                         $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
    //                     }
    //                 } 
    //                 if(isset($data['property_details']['expense'])){
    //                     if($data['property_details']['expense']=='selected'){
    //                         $data['property']=$this->expense_model->expenseData("Approved");
    //                         $data['sub_property']=$this->expense_model->expenseData("Approved", $property_id);
    //                     }
    //                 } 
    //                 if(isset($data['property_details']['maintenance'])){
    //                     if($data['property_details']['maintenance']=='selected'){
    //                         $data['property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
    //                         $data['sub_property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved", $property_id);
    //                     }
    //                 }

    //                 $data['property_details']['other_schedule']='false';
    //             }
                
    //             $data['maker_checker'] = $this->session->userdata('maker_checker');

    //             $sql = "select * from 
    //                     (select A.c_id, case when A.c_owner_type='individual' 
    //                         then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
    //                         else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
    //                     from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
    //                     where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
    //             $query=$this->db->query($sql);
    //             $result=$query->result();
    //             $data['contact']=$result;

    //             $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    //             $result=$query->result();
    //             if (count($result)>0) {
    //                 $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
    //                                         (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
    //                                             where b_status='Approved' and b_gid='$gid' and 
    //                                             b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
    //                                         left join 
    //                                         (select A.c_id, case when A.c_owner_type='individual' 
    //                                             then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
    //                                             else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
    //                                         from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
    //                                         where A.c_status='Approved' and A.c_gid='$gid') B 
    //                                         on (A.b_ownerid=B.c_id)
    //                                         order by bank_detail");
    //                 $result=$query->result();
    //                 $data['banks']=$result;
    //             } else {
    //                 $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
    //                                         (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
    //                                         left join 
    //                                         (select A.c_id, case when A.c_owner_type='individual' 
    //                                             then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
    //                                             else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
    //                                         from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
    //                                         where A.c_status='Approved' and A.c_gid='$gid') B 
    //                                         on (A.b_ownerid=B.c_id)
    //                                         order by bank_detail");
    //                 $result=$query->result();
    //                 $data['banks']=$result;
    //             }

    //             $sql="select * from expense_category_master where g_id='$gid'";
    //             $query=$this->db->query($sql);
    //             $data['expense_category']=$query->result();

    //             // echo json_encode($data);

    //             load_view('accounting/accounting_details',$data);
    //         } else {
    //             echo "Unauthorized access";
    //         }
    //     } else {
    //         echo '<script>alert("You donot have access to this page.");</script>';
    //         $this->load->view('login/main_page');
    //     }
    // }

    function bankEntry(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        
        $result=$this->accounting_model->getAccess();

        if(count($result)>0) {
            $fk_txn_id=$this->uri->segment(3);

            $data['property_details']=$this->accounting_model->getAllPropertyDetail($fk_txn_id);
            $property_id=$data['property_details']['property_id'];
            $data['sub_property']=array();

            $data['property_details']['other_schedule'] = 'false';

            if(isset($data['property_details']['sale'])){
                if($data['property_details']['sale']=='selected'){
                    $data['sub_property']=$this->sales_model->salesData("Approved", $property_id);
                }
            } 
            if(isset($data['property_details']['rent'])){
                if($data['property_details']['rent']=='selected') {
                    $data['sub_property']=$this->rent_model->rentData("Approved", $property_id);
                }
            } 
            if(isset($data['property_details']['expense'])){
                if($data['property_details']['expense']=='selected'){
                    $data['sub_property']=$this->expense_model->expenseData("Approved", $property_id);
                }
            } 
            if(isset($data['property_details']['maintenance'])){
                if($data['property_details']['maintenance']=='selected'){
                    $data['sub_property']=$this->maintenance_model->maintenanceDataForBankEntry("Approved", $property_id);
                }
            }
            if(isset($data['property_details']['other'])){
                if($data['property_details']['other']=='selected'){
                    $data['property_details']['other_schedule'] = 'true';
                }
            }
            
            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else  (ifnull(A.c_company_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
            $result=$query->result();
            if (count($result)>0) {
                $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master 
                                                where b_status='Approved' and b_gid='$gid' and 
                                                b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                $result=$query->result();
                $data['banks']=$result;

                $sql = "select * from purchase_txn where txn_status = 'approved' and txn_id in (select distinct purchase_id from purchase_ownership_details 
                        where pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))";
                $query=$this->db->query($sql);
                $data['property']=$query->result();
            } else {
                $query=$this->db->query("select A.b_id, concat(B.contact_name, ' - ', A.b_name, ' - ', A.b_accountnumber) as bank_detail from 
                                            (select b_id, b_ownerid, b_name, b_accountnumber from bank_master where b_status='Approved' and b_gid='$gid') A 
                                            left join 
                                            (select A.c_id, case when A.c_owner_type='individual' 
                                                then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                                else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                                            from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                            where A.c_status='Approved' and A.c_gid='$gid') B 
                                            on (A.b_ownerid=B.c_id)
                                            order by bank_detail");
                $result=$query->result();
                $data['banks']=$result;

                $sql = "select * from purchase_txn where txn_status = 'approved'";
                $query=$this->db->query($sql);
                $data['property']=$query->result();

                $sql="select * from expense_category_master where g_id='$gid'";
                $query=$this->db->query($sql);
                $data['expense_category']=$query->result();
            }

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('accounting/accounting_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveActualBankEntry(){
        $result=$this->accounting_model->getAccess();

        if(count($result)>0) {
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $form_data=$this->input->post(null,true);
            $this->accounting_model->saveActualBankEntry($form_data, $txn_status);
            
            redirect(base_url().'index.php/accounting');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveOtherExpenseBankEntry(){
        $result=$this->accounting_model->getAccess();

        if(count($result)>0) {
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $form_data=$this->input->post(null,true);
            $this->accounting_model->saveOtherExpenseBankEntry($form_data, $txn_status);
            
            redirect(base_url().'index.php/accounting');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function saveOtherScheduleBankEntry(){
        $result=$this->accounting_model->getAccess();

        if(count($result)>0) {
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $form_data=$this->input->post(null,true);
            $this->accounting_model->saveOtherScheduleBankEntry($form_data, $txn_status);
            
            redirect(base_url().'index.php/accounting');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($accounting_id, $entry_type) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($accounting_id, $entry_type);
        } else  {
            $this->updaterecord($accounting_id, $entry_type);
        }
    }

    public function updaterecord($accounting_id, $entry_type){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section='BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            if($entry_type=='tax') {
                $table_name = "actual_schedule_taxes";
            } else {
                $table_name = "actual_schedule";
            }

            $query=$this->db->query("SELECT * FROM ".$table_name." WHERE id = '$accounting_id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
                $table_type = $res[0]->table_type;
                $fk_txn_id = $res[0]->fk_txn_id;
                $fk_created_on = $res[0]->fk_created_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $created_by = '';
                $created_on = '';
                $table_type = '';
                $fk_txn_id = '';
                $fk_created_on = null;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update actual_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $this->db->query("update actual_schedule_taxes set status='1', txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Bank Entry';
                            $logarray['cnt_name']=$table_type;
                            $logarray['action']='Bank Entry Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM ".$table_name." WHERE fk_created_on='$created_on' and 
                                                    table_type='$table_type' and fk_txn_id='$fk_txn_id'");
                            $result=$query->result();
                            if (count($result)>0) {
                                $rec_status = $result[0]->txn_status;
                                $txn_fkid = $result[0]->txn_fkid;
                                $created_by = $result[0]->created_by;
                                $created_on = $result[0]->created_on;
                                $table_type = $result[0]->table_type;
                                $fk_txn_id = $result[0]->fk_txn_id;
                                $fk_created_on = $result[0]->fk_created_on;

                                $this->db->query("Update actual_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                                $this->db->query("Update actual_schedule_taxes set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $logarray['table_id']=$created_on;
                                $logarray['module_name']='Bank Entry';
                                $logarray['cnt_name']=$table_type;
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into actual_schedule (table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, remarks, rejected_by, rejected_date, maker_remark, 
                                                 fk_created_on, gp_id, payer_id, tds_amount_received, tds_amount_received_by, tds_amount_received_date, 
                                                 transaction, property_id, sub_property_id) 
                                                 Select table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, '$txnremarks', rejected_by, rejected_date, 
                                                 maker_remark, created_on, gp_id, payer_id, tds_amount_received, tds_amount_received_by, 
                                                 tds_amount_received_date, transaction, property_id, sub_property_id FROM actual_schedule 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $logarray['table_id']=$created_on;
                                $logarray['module_name']='Bank Entry';
                                $logarray['cnt_name']=$table_type;
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into actual_schedule_taxes (table_type, fk_txn_id, tax_applied, net_amount, 
                                                 cur_net_amount, tax_amount, cur_tax_amount, amount_paid, total_amount_paid, 
                                                 balance, payment_mode, account_number, payment_date, cheque_no, micr_no, status, 
                                                 txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, rejected_by, rejected_date, remarks, maker_remark, fk_created_on, gp_id) 
                                                 Select table_type, fk_txn_id, tax_applied, net_amount, 
                                                 cur_net_amount, tax_amount, cur_tax_amount, amount_paid, total_amount_paid, 
                                                 balance, payment_mode, account_number, payment_date, cheque_no, micr_no, '3', 
                                                 '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, rejected_by, rejected_date, '$txnremarks', 
                                                 maker_remark, created_on, gp_id FROM actual_schedule_taxes 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                            }
                        }
                    } else {
                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule');

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule_taxes');
                    }

                    redirect(base_url().'index.php/accounting');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $form_data=$this->input->post(null,true);
                        $this->accounting_model->saveActualBankEntry($form_data, $txn_status, $created_on);

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule');

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule_taxes');

                        $form_data=$this->input->post(null,true);
                        $this->accounting_model->saveActualBankEntry($form_data, $txn_status, $fk_created_on);
                    }

                    redirect(base_url().'index.php/accounting');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($accounting_id, $entry_type) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid = $this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                if($entry_type=='tax') {
                    $table_name = "actual_schedule_taxes";
                } else {
                    $table_name = "actual_schedule";
                }

                $query=$this->db->query("SELECT * FROM ".$table_name." WHERE id = '$accounting_id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $created_on = $res[0]->created_on;
                    $table_type = $res[0]->table_type;
                    $fk_txn_id = $res[0]->fk_txn_id;
                    $fk_created_on = $res[0]->fk_created_on;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $created_on = '';
                    $table_type = '';
                    $fk_txn_id = '';
                    $fk_created_on = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update actual_schedule set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    $this->db->query("update actual_schedule_taxes set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                } else {
                    if ($fk_created_on=='' || $fk_created_on==null) {
                        $this->db->query("update actual_schedule set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                        $this->db->query("update actual_schedule_taxes set status='1', txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                            $status='2';
                        } else {
                            $status='1';
                        }

                        $this->db->query("delete from actual_schedule WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("delete from actual_schedule_taxes WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("update actual_schedule set txn_status='$txn_status', approved_by='$curusr', 
                                         approved_date='$modnow', remarks='$remarks', txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");

                        $this->db->query("update actual_schedule_taxes set status='$status', txn_status='$txn_status', 
                                         approved_by='$curusr', approved_date='$modnow', remarks='$remarks', 
                                         txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");
                    }
                }

                $logarray['table_id']=$created_on;
                $logarray['module_name']='Bank Entry';
                $logarray['cnt_name']=$table_type;
                $logarray['action']='Bank Entry Record ' . $txn_status;
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                redirect(base_url().'index.php/accounting');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo "You donot have access to this page";
        }
    }

    public function updateOther($accounting_id, $entry_type) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approveOtherSchedule($accounting_id, $entry_type);
        } else  {
            $this->updateOtherSchedule($accounting_id, $entry_type);
        }
    }

    public function updateOtherSchedule($accounting_id, $entry_type){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section='BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            if($entry_type=='tax') {
                $table_name = "actual_schedule_taxes";
            } else {
                $table_name = "actual_schedule";
            }

            $query=$this->db->query("SELECT * FROM actual_other_schedule WHERE id = '$accounting_id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
                $table_type = $res[0]->table_type;
                $fk_txn_id = $res[0]->fk_txn_id;
                $fk_created_on = $res[0]->fk_created_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $created_by = '';
                $created_on = '';
                $table_type = '';
                $fk_txn_id = '';
                $fk_created_on = null;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update actual_other_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $this->db->query("update actual_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $this->db->query("update actual_schedule_taxes set status='1', txn_status='$txn_status', remarks='$txnremarks', 
                                             modified_by='$curusr', modified_date='$modnow' 
                                             WHERE created_on='$created_on' and table_type='$table_type' and 
                                             fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Bank Entry';
                            $logarray['cnt_name']=$table_type;
                            $logarray['action']='Bank Entry Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM actual_other_schedule WHERE fk_created_on='$created_on' and 
                                                    table_type='$table_type' and fk_txn_id='$fk_txn_id'");
                            $result=$query->result();
                            if (count($result)>0) {
                                $rec_status = $result[0]->txn_status;
                                $txn_fkid = $result[0]->txn_fkid;
                                $created_by = $result[0]->created_by;
                                $created_on = $result[0]->created_on;
                                $table_type = $result[0]->table_type;
                                $fk_txn_id = $result[0]->fk_txn_id;
                                $fk_created_on = $result[0]->fk_created_on;

                                $this->db->query("Update actual_other_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                                $this->db->query("Update actual_schedule set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");

                                $this->db->query("Update actual_schedule_taxes set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $logarray['table_id']=$created_on;
                                $logarray['module_name']='Bank Entry';
                                $logarray['cnt_name']=$table_type;
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {

                                $this->db->query("Insert into actual_other_schedule (table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, remarks, rejected_by, rejected_date, maker_remark, 
                                                 fk_created_on, gp_id, payer_id, type, property_id, sub_property_id, 
                                                 category, gst_rate, basic_cost, invoice_no, invoice_date, pay_now) 
                                                 Select table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, '$txnremarks', rejected_by, rejected_date, 
                                                 maker_remark, created_on, gp_id, payer_id, type, property_id, sub_property_id, 
                                                 category, gst_rate, basic_cost, invoice_no, invoice_date, pay_now FROM actual_other_schedule 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $logarray['table_id']=$created_on;
                                $logarray['module_name']='Bank Entry';
                                $logarray['cnt_name']=$table_type;
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into actual_schedule (table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, remarks, rejected_by, rejected_date, maker_remark, 
                                                 fk_created_on, gp_id, payer_id) 
                                                 Select table_type, event_type, event_name, event_date, 
                                                 fk_txn_id, tax_applied, tax_amount, paid_tax_amount, tax_ded_amt, tax_ded_amt_paid, 
                                                 net_amount, paid_amount, tds_amount, balance, total_amount_paid, payment_mode, 
                                                 account_number, payment_date, cheque_no, int_type, int_rate, interest, principal, 
                                                 tot_outstanding, '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, '$txnremarks', rejected_by, rejected_date, 
                                                 maker_remark, created_on, gp_id, payer_id FROM actual_schedule 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                                
                                $this->db->query("Insert into actual_schedule_taxes (table_type, fk_txn_id, tax_applied, net_amount, 
                                                 cur_net_amount, tax_amount, cur_tax_amount, amount_paid, total_amount_paid, 
                                                 balance, payment_mode, account_number, payment_date, cheque_no, micr_no, status, 
                                                 txn_status, txn_fkid, created_by, created_on, modified_by, modified_date, 
                                                 approved_by, approved_date, rejected_by, rejected_date, remarks, maker_remark, fk_created_on, gp_id) 
                                                 Select table_type, fk_txn_id, tax_applied, net_amount, 
                                                 cur_net_amount, tax_amount, cur_tax_amount, amount_paid, total_amount_paid, 
                                                 balance, payment_mode, account_number, payment_date, cheque_no, micr_no, '3', 
                                                 '$txn_status', id, '$created_by', '$now', '$curusr', '$modnow', 
                                                 approved_by, approved_date, rejected_by, rejected_date, '$txnremarks', 
                                                 maker_remark, created_on, gp_id FROM actual_schedule_taxes 
                                                 WHERE created_on='$created_on' and table_type='$table_type' and 
                                                 fk_txn_id='$fk_txn_id' and txn_status='$rec_status'");
                            }
                        }
                    } else {
                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_other_schedule');

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule');

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule_taxes');
                    }

                    redirect(base_url().'index.php/accounting');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $form_data=$this->input->post(null,true);
                        $this->accounting_model->saveOtherScheduleBankEntry($form_data, $txn_status, $created_on);

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_other_schedule');

                        $logarray['table_id']=$created_on;
                        $logarray['module_name']='Bank Entry';
                        $logarray['cnt_name']=$table_type;
                        $logarray['action']='Bank Entry Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule');

                        $this->db->where('created_on', $created_on);
                        $this->db->where('table_type', $table_type);
                        $this->db->where('fk_txn_id', $fk_txn_id);
                        $this->db->where('txn_status', $rec_status);
                        $this->db->delete('actual_schedule_taxes');

                        $form_data=$this->input->post(null,true);
                        $this->accounting_model->saveOtherScheduleBankEntry($form_data, $txn_status, $fk_created_on);
                    }

                    redirect(base_url().'index.php/accounting');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveOtherSchedule($accounting_id, $entry_type) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid = $this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                if($entry_type=='tax') {
                    $table_name = "actual_schedule_taxes";
                } else {
                    $table_name = "actual_schedule";
                }

                $query=$this->db->query("SELECT * FROM actual_other_schedule WHERE id = '$accounting_id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $created_on = $res[0]->created_on;
                    $table_type = $res[0]->table_type;
                    $fk_txn_id = $res[0]->fk_txn_id;
                    $fk_created_on = $res[0]->fk_created_on;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $created_on = '';
                    $table_type = '';
                    $fk_txn_id = '';
                    $fk_created_on = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update actual_other_schedule set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    $this->db->query("update actual_schedule set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    $this->db->query("update actual_schedule_taxes set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                } else {
                    if ($fk_created_on=='' || $fk_created_on==null) {
                        $this->db->query("update actual_other_schedule set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                        $this->db->query("update actual_schedule set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                        $this->db->query("update actual_schedule_taxes set status='1', txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE created_on = '$created_on' and table_type = '$table_type' and fk_txn_id = '$fk_txn_id'");
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                            $status='2';
                        } else {
                            $status='1';
                        }

                        $this->db->query("delete from actual_other_schedule WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("delete from actual_schedule WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("delete from actual_schedule_taxes WHERE created_on = '$fk_created_on' and 
                                          table_type = '$table_type' and fk_txn_id = '$fk_txn_id' and 
                                          (fk_created_on = '' or fk_created_on is null)");

                        $this->db->query("update actual_other_schedule set txn_status='$txn_status', approved_by='$curusr', 
                                         approved_date='$modnow', remarks='$remarks', txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");

                        $this->db->query("update actual_schedule set txn_status='$txn_status', approved_by='$curusr', 
                                         approved_date='$modnow', remarks='$remarks', txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");

                        $this->db->query("update actual_schedule_taxes set status='$status', txn_status='$txn_status', 
                                         approved_by='$curusr', approved_date='$modnow', remarks='$remarks', 
                                         txn_fkid=null, fk_created_on=null 
                                         WHERE created_on = '$created_on' and table_type = '$table_type' and 
                                         fk_txn_id = '$fk_txn_id' and fk_created_on = '$fk_created_on'");
                    }
                }

                $logarray['table_id']=$created_on;
                $logarray['module_name']='Bank Entry';
                $logarray['cnt_name']=$table_type;
                $logarray['action']='Bank Entry Record ' . $txn_status;
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                redirect(base_url().'index.php/accounting');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo "You donot have access to this page";
        }
    }

    public function updateOtherExpense($accounting_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $query=$this->db->query("SELECT * FROM actual_other_expense WHERE id = '$accounting_id'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gid = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $created_on = $res[0]->created_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = null;
                $gid = $gid;
                $created_by = $curusr;
                $created_on = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update actual_other_expense set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE id = '$accounting_id'");
                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Bank Entry Expense';
                            $logarray['cnt_name']='Expense';
                            $logarray['action']='Bank Entry Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM actual_other_expense WHERE txn_fkid = '$accounting_id'");
                            $result=$query->result();
                            if (count($result)>0){
                                $accounting_id = $result[0]->id;
                                $txn_fkid = $result[0]->txn_fkid;

                                $this->db->query("Update actual_other_expense set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE id = '$accounting_id'");

                                $logarray['table_id']=$accounting_id;
                                $logarray['module_name']='Bank Entry Expense';
                                $logarray['cnt_name']='Expense';
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into actual_other_expense (expense_category, property_id, sub_property_id, 
                                                 expense_description, expense_date, expense_amount, payment_mode, account_number, 
                                                 payment_date, cheque_no, gp_id, txn_status, created_by, created_on, modified_by, 
                                                 modified_date, approved_by, approved_date, remarks, txn_fkid, rejected_by, 
                                                 rejected_date, maker_remark) 
                                                 Select expense_category, property_id, sub_property_id, 
                                                 expense_description, expense_date, expense_amount, payment_mode, account_number, 
                                                 payment_date, cheque_no, '$gid', '$txn_status', '$created_by', '$created_on', 
                                                 '$curusr', '$modnow', approved_by, approved_date, '$txnremarks', '$accounting_id', 
                                                 rejected_by, rejected_date, maker_remark 
                                                 FROM actual_other_expense WHERE id = '$accounting_id'");

                                $logarray['table_id']=$accounting_id;
                                $logarray['module_name']='Bank Entry Expense';
                                $logarray['cnt_name']='Expense';
                                $logarray['action']='Bank Entry Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('id', $accounting_id);
                        $this->db->delete('actual_other_expense');

                        $logarray['table_id']=$accounting_id;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/accounting');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $form_data=$this->input->post(null,true);
                        $this->accounting_model->saveOtherExpenseBankEntry($form_data, $txn_status, $accounting_id);

                        $logarray['table_id']=$accounting_id;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $this->db->where('id', $accounting_id);
                        $this->db->delete('actual_other_expense');

                        $form_data=$this->input->post(null,true);
                        $this->accounting_model->saveOtherExpenseBankEntry($form_data, $txn_status, $txn_fkid);

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/accounting');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approveOtherExpense($accounting_id, $entry_type) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM actual_other_expense WHERE id = '$accounting_id'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gid = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = null;
                    $gid = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update actual_other_expense set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE id = '$accounting_id'");

                    $logarray['table_id']=$accounting_id;
                    $logarray['module_name']='Bank Entry Expense';
                    $logarray['cnt_name']='Expense';
                    $logarray['action']='Bank Entry Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update actual_other_expense set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE id = '$accounting_id'");

                        $logarray['table_id']=$accounting_id;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update actual_other_expense A, actual_other_expense B set 
                                         A.expense_category=B.expense_category, A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.expense_description=B.expense_description, 
                                         A.expense_date=B.expense_date, A.expense_amount=B.expense_amount, 
                                         A.payment_mode=B.payment_mode, A.account_number=B.account_number, 
                                         A.payment_date=B.payment_date, A.cheque_no=B.cheque_no, 
                                         A.gp_id=B.gp_id, A.txn_status='$txn_status', A.created_by=B.created_by, 
                                         A.created_on=B.created_on, A.modified_by=B.modified_by, 
                                         A.modified_date=B.modified_date, A.approved_by='$curusr', 
                                         A.approved_date='$modnow', A.remarks='$remarks', 
                                         A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, 
                                         A.maker_remark=B.maker_remark 
                                         WHERE B.id = '$accounting_id' and A.id=B.txn_fkid");

                        $this->db->query("delete from actual_other_expense WHERE id = '$accounting_id'");

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Bank Entry Expense';
                        $logarray['cnt_name']='Expense';
                        $logarray['action']='Bank Entry Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/accounting');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getServiceTax(){
        $event_type=$this->input->post("event_type");
        $event_name=$this->input->post("event_name");
        $event_date=$this->input->post("event_date");
        $actual_amount=$this->input->post("actual_amount");
        $fk_txn_id=$this->input->post("fk_txn_id");
        $response=$this->accounting_model->getServiceTax($event_type,$event_name,$event_date,$actual_amount,$fk_txn_id);
        echo json_encode($response);
    }

    function getPaidDetails(){
        $event_type=$this->input->post("event_type");
        $event_name=$this->input->post("event_name");
        $event_date=$this->input->post("event_date");
        $fk_txn_id=$this->input->post("fk_txn_id");

        $response=$this->accounting_model->getPaidDetails($event_type,$event_name,$event_date,$fk_txn_id);
        echo json_encode($response);
    }

    function getTaxPaidDetails(){
        $tax_applied=$this->input->post("tax_applied");
        $fk_txn_id=$this->input->post("fk_txn_id");

        $response=$this->accounting_model->getTaxPaidDetails($tax_applied,$fk_txn_id);
        echo json_encode($response);
    }

    function getOtherSchedule(){
        $fk_txn_id=$this->input->post("fk_txn_id");

        $response=$this->accounting_model->getOtherSchedule($fk_txn_id);
        echo json_encode($response);
    }

    function getTaxDetailsView(){
        $form_data=$this->input->post(null,true);
        $response=$this->accounting_model->getTaxDetailsView($form_data);
        echo json_encode($response);
    }

    function getTaxDetails(){
        $form_data=$this->input->post(null,true);
        $response=$this->accounting_model->getTaxDetails($form_data);
        echo json_encode($response);
    }

    function saveOtherSchDetails(){
        $form_data=$this->input->post(null,true);
        $response=$this->accounting_model->saveOtherSchDetails($form_data);
        echo json_encode($response);
    }

    public function loadpropertydet($pid) {
        $query=$this->db->query("select sum(net_amount) as cost_of_purchase from purchase_schedule where purchase_id = '$pid' and status = '1'");
        $result=$query->result();

        echo $result[0]->cost_of_purchase;
    }

    public function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function get_loan_txn(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $txn_id = html_escape($this->input->post('txn_id'));

        $loan_list = "";
    
        $result=$this->loan_model->loanData("Approved");
        $schedule_table="loan_schedule";
        $sch_type_id='loan_id';

        if (count($result)>0) {
            
            $loan_list = '<option value="0">Select Loan Reference</option>';

            foreach ($result as $row) {
                if($schedule_table!=""){
                    $loan_id=$row->txn_id;
                    $query=$this->db->query("select * from ".$schedule_table." where ".$sch_type_id." = '$loan_id' and status = '1'");
                    $result2=$query->result();

                    if (count($result2)>0) {
                        $loan_txn_id = $row->txn_id;
                        $loan_ref_name = $row->ref_name;

                        if ($txn_id == $loan_txn_id) {
                            $loan_list = $loan_list . '<option value="' . $loan_txn_id . '" selected>' . $loan_ref_name . '</option>';
                        } else {
                            $loan_list = $loan_list . '<option value="' . $loan_txn_id . '">' . $loan_ref_name . '</option>';
                        }
                    }
                }
            }
        }

        echo $loan_list;
    }

    public function get_expense_category() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $expense_category_id = html_escape($this->input->post('expense_category_id'));

        $expense_category_list = "";
        
        $query=$this->db->query("SELECT * FROM expense_category_master WHERE g_id = '$gid'");
        $result=$query->result();

        if (count($result)>0) {
            $expense_category_list = '<option value="">Select Category</option>';

            foreach ($result as $row) {
                $expense_cat_id=$row->id;
                $expense_cat=$row->expense_category;

                if ($expense_category_id == $expense_cat_id) {
                    $expense_category_list = $expense_category_list . '<option value="' . $expense_cat_id . '" selected>' . $expense_cat . '</option>';
                } else {
                    $expense_category_list = $expense_category_list . '<option value="' . $expense_cat_id . '">' . $expense_cat . '</option>';
                }
            }
        }

        echo $expense_category_list;
    }

    public function get_property() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('property_id'));

        $property_list = "";

        if ($status=="purchase" || $status=="other") {
            $result=$this->purchase_model->purchaseData("Approved");
            $schedule_table="purchase_schedule";
            $sch_type_id='purchase_id';
        } else if ($status=="loan") {
            $result=array();
            $schedule_table="";
            $sch_type_id='';
        } else if ($status=="rent") {
            $result=$this->rent_model->rentData("Approved");
            $schedule_table="rent_schedule";
            $sch_type_id='rent_id';
        } else if ($status=="sale") {
            $result=$this->sales_model->salesData("Approved");
            $schedule_table="sales_schedule";
            $sch_type_id='sale_id';
        } else if ($status=="expense") {
            $result=$this->expense_model->expenseData("Approved");
            $schedule_table="expense_schedule";
            $sch_type_id='expense_id';
        } else if ($status=="maintenance") {
            $result=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
            $schedule_table="maintenance_schedule";
            $sch_type_id='m_id';
        } else {
            $result=array();
        }

        if (count($result)>0) {
            
            $property_list = '<option value="">Select Property</option>';

            foreach ($result as $row) {
                if($schedule_table!=""){
                    $txn_id=$row->txn_id;
                    $query=$this->db->query("select * from ".$schedule_table." where ".$sch_type_id." = '$txn_id' and status = '1'");
                    $result2=$query->result();

                    if (count($result2)>0) {
                        if ($status=="purchase" || $status=="other") {
                            $prop_id = $row->txn_id;
                            $prop_name = $row->p_property_name;
                        } else {
                            $prop_id = $row->property_id;
                            $prop_name = $row->p_property_name;
                        }

                        if ($property_id == $prop_id) {
                            $property_list = $property_list . '<option value="' . $prop_id . '" selected>' . $prop_name . '</option>';
                        } else {
                            $property_list = $property_list . '<option value="' . $prop_id . '">' . $prop_name . '</option>';
                        }
                    }
                }
            }
        }

        echo $property_list;
    }

    public function get_sub_property() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $status = html_escape($this->input->post('status'));
        $property_id = html_escape($this->input->post('property_id'));
        $sub_property_id = html_escape($this->input->post('sub_property_id'));

        // $property_id = 138;
        // $sub_property_id = '';
        // $status = "other";

        // $status = "sale";
        // $property_id = "45";
        // $sub_property_id = "0";

        $sub_property_list="";

        if ($status=="purchase") {
            $result=array();
        } else if ($status=="loan") {
            $result=array();
        } else if ($status=="rent") {
            $result=$this->rent_model->rentData("Approved");
        } else if ($status=="sale") {
            $result=$this->sales_model->salesData("Approved");
        } else if ($status=="expense") {
            $result=$this->expense_model->expenseData("Approved");
        } else if ($status=="maintenance") {
            $result=$this->maintenance_model->maintenanceDataForBankEntry("Approved");
        } else if ($status=="other") {
            $result=$this->purchase_model->get_sub_properties("Approved");
        } else {
            $result=array();
        }

        if (count($result)>0) {
            $sub_property_list = '<option value="">Select Sub Property</option>';

            foreach ($result as $row) {
                if ($property_id == $row->property_id) {
                    if($row->sub_property_id!="0" && $row->sub_property_id!="" && $row->sub_property_id!=null){
                        if ($sub_property_id == $row->sub_property_id) {
                            $sub_property_list = $sub_property_list . '<option value="' . $row->sub_property_id . '" selected>' . $row->sp_name . '</option>';
                        } else {
                            $sub_property_list = $sub_property_list . '<option value="' . $row->sub_property_id . '">' . $row->sp_name . '</option>';
                        }
                    }
                }
            }
        }


        // $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id='$property_id' AND txn_status='Approved'");
        // $result=$query->result();
        // if (count($result)>0) {
        //     $sub_property_list = '<option value="0">Select Sub Property</option>';

        //     foreach ($result as $row) {
        //         if ($property_id == $row->property_id) {
        //             if($row->txn_id!="0" && $row->txn_id!="" && $row->txn_id!=null){
        //                 if ($sub_property_id == $row->sp_id) {
        //                     $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '" selected>' . $row->sp_name . '</option>';
        //                 } else {
        //                     $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '">' . $row->sp_name . '</option>';
        //                 }
        //             }
        //         }
        //     }
        // }

        if($sub_property_list == '<option value="">Select Sub Property</option>'){
            $sub_property_list="";
        }

        echo $sub_property_list;
    }

    public function getConAcc($status='', $contact_id=''){
        $this->checkstatus($status, '', $contact_id);
    }

    public function checkstatus_receipt($status='', $property_id='', $contact_id=''){
        $result=$this->accounting_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;

            $data['bankentry']=array();
            $data['pendingbankentry']=array();
            $data['pendingotherentry']=array();

            if(strtolower($status)!='unpaid'){
                $data['bankentry']=$this->accounting_model->bankentryData($status, $property_id, $contact_id);
            }

            if(strtolower($status)=='all' || strtolower($status)=='unpaid'){
                $data['pendingbankentry']=$this->accounting_model->getPendingBankEntry($status, $property_id, $contact_id);
            }
            if(strtolower($status)=='all' || strtolower($status)=='unpaid'){
                $data['pendingotherentry']=$this->accounting_model->getPendingOtherEntry('Approved', $property_id, $contact_id);
            } else {
                $data['pendingotherentry']=$this->accounting_model->getPendingOtherEntry($status, $property_id, $contact_id);
            }
            

            $data['pendingbankentry']=array_merge($data['pendingbankentry'],$data['pendingotherentry']);
            
            // $count_data=$this->accounting_model->getAllCountData();

            $count_data=$this->accounting_model->bankentryData('All', $property_id, $contact_id);
            $all=0;
            $unpaid=0;
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $count_data=$this->accounting_model->getPendingBankEntry('All', $property_id, $contact_id);
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    $unpaid=$unpaid+1;
                }
            }

            $count_data=$this->accounting_model->getPendingOtherEntry('All', $property_id, $contact_id);
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['unpaid']=$unpaid;
            $data['all']=$all;


            $data['checkstatus'] = $status;
            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $bankentry = $data['bankentry'];
            $pendingbankentry=$data['pendingbankentry'];
            $accounting_data = array();

            $j=0; 
            for ($i=0; $i < count($bankentry) ; $i++) 
            { 
                if($bankentry[$i]['particulars']=='Rent' || $bankentry[$i]['particulars']=='Sale' || $bankentry[$i]['particulars']=='Income' || $bankentry[$i]['particulars']=='Adhoc' && $bankentry[$i]['table_type']=='receipt') {
                        $duedate =  ($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('Y-m-d 00:00:00',strtotime($bankentry[$i]['due_date'])):'';

                        $row = array(
                                '<span class="btn btn-success paid" >Paid</span>',
                                '<input type="hidden" id="type_'.$j.'" value="View" />
                                 <input type="hidden" id="status_'.$j.'" value="paid" />
                                 <input type="hidden" id="prop_id_'.$j.'" value="'.$bankentry[$i]['prop_id'].'" />
                                 <input type="hidden" id="particular_'.$j.'" value="'.$bankentry[$i]['particulars'].'" />
                                 <input type="hidden" id="bal_amount_'.$j.'" value="'.format_money($bankentry[$i]['bal_amount'],2).'" />
                                 <input type="hidden" id="net_amount_'.$j.'" value="'.format_money($bankentry[$i]['net_amount'],2).'" />
                                 <input type="hidden" id="due_date_'.$j.'" value="'.($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!=''?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):'').'">
                                 <input type="hidden" id="link_'.$j.'" value="'.base_url().'index.php/Accounting/view/receipt/'.$bankentry[$i]['txn_status'].'/'.$bankentry[$i]['contact_id'].'/'.$bankentry[$i]['transaction'].'/'.($bankentry[$i]['property_id']==''?'0':$bankentry[$i]['property_id']).'/'.($bankentry[$i]['sub_property_id']==''?'0':$bankentry[$i]['sub_property_id']).'/'.($bankentry[$i]['accounting_id']==''?'0':$bankentry[$i]['accounting_id']).'" />
                                 <input type="hidden" id="property_name_'.$j.'" value="'.(isset($bankentry[$i]['property'])?$bankentry[$i]['property']:'').'" />
                                 <input type="hidden" id="sub_property_name_'.$j.'" value="'.(isset($bankentry[$i]['sub_property'])?$bankentry[$i]['sub_property']:'').'" />
                                 <input type="hidden" id="owner_name_'.$j.'" value='.(isset($bankentry[$i]['owner_name'])?$bankentry[$i]['owner_name']:'').'" />
                                 <input type="hidden" id="payer_name_'.$j.'" value="'.(isset($bankentry[$i]['payer_name'])?$bankentry[$i]['payer_name']:'').'" />
                                 <input type="hidden" id="address_'.$j.'" value="'.(isset($bankentry[$i]['p_address'])?$bankentry[$i]['p_address']:'').'" />
                                 <a  style="color: #41a541!important;cursor: pointer!important;"  id="details_'.$j.'" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details </a>',
                                 ''.($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):''.'',
                                 ''.$bankentry[$i]['particulars'].'',
                                 ''.(isset($bankentry[$i]['payer_name'])?$bankentry[$i]['payer_name']:'').'',
                                 ''. $bankentry[$i]['property'].'',
                                 ''. $bankentry[$i]['sub_property'].'',
                                 ''.format_money($bankentry[$i]['net_amount'],2).'',
                                 ''.format_money($bankentry[$i]['paid_amount'],2).'',
                                 ''.isset($bankentry[$i]['bal_amount'])?format_money($bankentry[$i]['bal_amount'],2):''.'',
                                 ''.$duedate.'',
                            );
                        $accounting_data[] = $row;
                        $j++;
                }
            }

          
            for ($i=0; $i < count($pendingbankentry) ; $i++) 
            { 
               if($pendingbankentry[$i]['particulars']=='Rent' || $pendingbankentry[$i]['particulars']=='Sale' || $pendingbankentry[$i]['particulars']=='Income' || $pendingbankentry[$i]['particulars']=='Adhoc' && $pendingbankentry[$i]['table_type']=='receipt')
                {
                    $duedate =  ($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!='')?date('Y-m-d 00:00:00',strtotime($pendingbankentry[$i]['due_date'])):''; 

                       if($pendingbankentry[$i]['transaction']=='adhoc'){
                         $input = ' <input type="hidden" id="link_'.$j.'" value="'.base_url().'index.php/Accounting/edit/receipt/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']=='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:'').'" />';

                        }else{
                            $input = ' <input type="hidden" id="link_'.$j.'" value="'.base_url().'index.php/Accounting/edit/receipt/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:'').'" />';
                        }
                     $row = array(
                        '<span class="btn btn-danger unpaid" >Unpaid</span>',
                        '<input type="hidden" id="type_'.$j.'" value="Receive" />
                        <input type="hidden" id="type_2_'.$j.'" value="View" />
                        <input type="hidden" id="status_'. $j.'" value="unpaid" />
                        <input type="hidden" id="txn_status_'. $j.'" value="'.$pendingbankentry[$i]['txn_status'].'"
                        <input type="hidden" id="prop_id_'.$j.'" value="'.$pendingbankentry[$i]['prop_id'].'" />
                        <input type="hidden" id="particular_'.$j.'" value="'.$pendingbankentry[$i]['particulars'].'" />
                        <input type="hidden" id="bal_amount_'.$j.'" value="'.format_money($pendingbankentry[$i]['bal_amount'],2).'" />
                        <input type="hidden" id="net_amount_'.$j.'" value="'.format_money($pendingbankentry[$i]['net_amount'],2).'" />
                        <input type="hidden" id="due_date_'.$j.'" value="'.($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!=''?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):'').'" />
                        '.$input.'
                        <input type="hidden" id="link_2_'.$j.'" value="'.base_url().'index.php/Accounting/viewOtherSchedule/receipt/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:'').'" />
                        <input type="hidden" id="owner_name_'.$j.'" value="'.(isset($pendingbankentry[$i]['owner_name'])?$pendingbankentry[$i]['owner_name']:'').'"/>
                        <input type="hidden" id="payer_name_'.$j.'" value="'.(isset($pendingbankentry[$i]['payer_name'])?$pendingbankentry[$i]['payer_name']:'').'"/>
                        <input type="hidden" id="property_name_'.$j.'" value="'.(isset($pendingbankentry[$i]['property'])?$pendingbankentry[$i]['property']:'').'"/>
                        <input type="hidden" id="sub_property_name_'.$j.'"  value="'.(isset($pendingbankentry[$i]['sub_property'])?$pendingbankentry[$i]['sub_property']:'').'" />
                        <input type="hidden" id="address_'.$j.'" value="" />
                        <a style="color: #41a541!important; cursor: pointer!important;" id="details_'.$j.'" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details</a>',
                        ''.($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!=''?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):'').'',
                        ''. $pendingbankentry[$i]['particulars'].'',
                        ''.(isset($pendingbankentry[$i]['payer_name'])?$pendingbankentry[$i]['payer_name']:'').'',
                        ''.$pendingbankentry[$i]['property'].'',
                        ''.$pendingbankentry[$i]['sub_property'].'',
                        ''.format_money($pendingbankentry[$i]['net_amount'],2).'',
                        ''.format_money($pendingbankentry[$i]['paid_amount'],2).'',
                        ''.isset($pendingbankentry[$i]['bal_amount'])?format_money($pendingbankentry[$i]['bal_amount'],2):''.'',
                        ''.$duedate.'',
                    );
                    $j++;
                    $accounting_data[] = $row;
                }

            }

            $total_accounting_data = count($accounting_data);

           foreach ($accounting_data as $key => $row) {
                 $duedates[$key]= $row['10'];
            }

            if(count($accounting_data)>0)
            array_multisort($duedates, SORT_ASC, $accounting_data);
            $params = $_REQUEST;

            $accounting_data = array_slice($accounting_data,$params['start'],$params['length']);
             $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval($total_accounting_data),  
                "recordsFiltered" => intval($total_accounting_data),
                "data"            => $accounting_data
                );

            echo json_encode($json_data);
            //load_view('accounting/accounting', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus_payment($status='', $property_id='', $contact_id=''){
        $result=$this->accounting_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;

            $data['bankentry']=array();
            $data['pendingbankentry']=array();
            $data['pendingotherentry']=array();

            if(strtolower($status)!='unpaid'){
                $data['bankentry']=$this->accounting_model->bankentryData($status, $property_id, $contact_id);
            }

            if(strtolower($status)=='all' || strtolower($status)=='unpaid'){
                $data['pendingbankentry']=$this->accounting_model->getPendingBankEntry($status, $property_id, $contact_id);
            }
            if(strtolower($status)=='all' || strtolower($status)=='unpaid'){
                $data['pendingotherentry']=$this->accounting_model->getPendingOtherEntry('Approved', $property_id, $contact_id);
            } else {
                $data['pendingotherentry']=$this->accounting_model->getPendingOtherEntry($status, $property_id, $contact_id);
            }
            

            $data['pendingbankentry']=array_merge($data['pendingbankentry'],$data['pendingotherentry']);
            
            // $count_data=$this->accounting_model->getAllCountData();

            $count_data=$this->accounting_model->bankentryData('All', $property_id, $contact_id);
            $all=0;
            $unpaid=0;
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $count_data=$this->accounting_model->getPendingBankEntry('All', $property_id, $contact_id);
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    $unpaid=$unpaid+1;
                }
            }

            $count_data=$this->accounting_model->getPendingOtherEntry('All', $property_id, $contact_id);
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['unpaid']=$unpaid;
            $data['all']=$all;


            $data['checkstatus'] = $status;
            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $bankentry = $data['bankentry'];
            $pendingbankentry=$data['pendingbankentry'];
            $accounting_data = array();

            $j=0; 
           for ($i=0; $i < count($bankentry) ; $i++) 
            { 
               if($bankentry[$i]['particulars']=='Purchase' || $bankentry[$i]['particulars']=='Loan' || $bankentry[$i]['particulars']=='Expense' || $bankentry[$i]['particulars']=='Maintenance' ||  $bankentry[$i]['particulars']=='Adhoc' && $bankentry[$i]['table_type']=='payment') {

                    $duedate =  ($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('Y-m-d 00:00:00',strtotime($bankentry[$i]['due_date'])):'';

                        $row = array(
                                '<span class="btn btn-success paid" >Paid</span>',
                                '<input type="hidden" id="type_0'.$j.'" value="View" />
                                 <input type="hidden" id="status_0'.$j.'" value="paid" />
                                 <input type="hidden" id="prop_id_0'.$j.'" value="'.$bankentry[$i]['prop_id'].'" />
                                 <input type="hidden" id="particular_0'.$j.'" value="'.$bankentry[$i]['particulars'].'" />
                                 <input type="hidden" id="bal_amount_0'.$j.'" value="'.format_money($bankentry[$i]['bal_amount'],2).'" />
                                 <input type="hidden" id="net_amount_0'.$j.'" value="'.format_money($bankentry[$i]['net_amount'],2).'" />
                                 <input type="hidden" id="due_date_0'.$j.'" value="'.($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!=''?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):'').'">
                                 <input type="hidden" id="link_0'.$j.'" value='.base_url().'index.php/Accounting/view/payment/'.$bankentry[$i]['txn_status'].'/'.$bankentry[$i]['contact_id'].'/'.$bankentry[$i]['transaction'].'/'.($bankentry[$i]['property_id']==''?'0':$bankentry[$i]['property_id']).'/'.($bankentry[$i]['sub_property_id']==''?'0':$bankentry[$i]['sub_property_id']).'/'.($bankentry[$i]['accounting_id']==''?'0':$bankentry[$i]['accounting_id']).'" />
                                 <input type="hidden" id="link_0'.$j.'" value="'.base_url().'index.php/Accounting/view/payment/'.$bankentry[$i]['txn_status'].'/'.$bankentry[$i]['contact_id'].'/'.$bankentry[$i]['transaction'].'/'.($bankentry[$i]['property_id']==''?'0':$bankentry[$i]['property_id']).'/'.($bankentry[$i]['sub_property_id']==''?'0':$bankentry[$i]['sub_property_id']).'/'.($bankentry[$i]['accounting_id']==''?'0':$bankentry[$i]['accounting_id']).'" />
                                 <input type="hidden" id="property_name_0'.$j.'" value="'.(isset($bankentry[$i]['property'])?$bankentry[$i]['property']:'').'" />
                                 <input type="hidden" id="sub_property_name_0'.$j.'" value="'.(isset($bankentry[$i]['sub_property'])?$bankentry[$i]['sub_property']:'').'" />
                                 <input type="hidden" id="owner_name_0'.$j.'" value="'.(isset($bankentry[$i]['owner_name'])?$bankentry[$i]['owner_name']:'').'" />
                                 <input type="hidden" id="payer_name_0'.$j.'" value="'.(isset($bankentry[$i]['payer_name'])?$bankentry[$i]['payer_name']:'').'" />
                                 <input type="hidden" id="address_0'.$j.'" value="'.(isset($bankentry[$i]['p_address'])?$bankentry[$i]['p_address']:'').'" />
                                 <a  style="color: #41a541!important;cursor: pointer!important;"  id="details_0'.$j.'" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details </a>',
                                 ''.($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!='')?date('d/m/Y',strtotime($bankentry[$i]['due_date'])):''.'',
                                 ''.$bankentry[$i]['particulars'].'',
                                 ''.(isset($bankentry[$i]['payer_name'])?$bankentry[$i]['payer_name']:'').'',
                                 ''. $bankentry[$i]['property'].'',
                                 ''. $bankentry[$i]['sub_property'].'',
                                 ''.format_money($bankentry[$i]['net_amount'],2).'',
                                 ''.format_money($bankentry[$i]['paid_amount'],2).'',
                                 ''.isset($bankentry[$i]['bal_amount'])?format_money($bankentry[$i]['bal_amount'],2):''.'',
                                 ''.$duedate.'',
                            );
                        $accounting_data[] = $row;
                        $j++;
                }
            }

            for ($i=0; $i < count($pendingbankentry) ; $i++) 
            { 
               if($pendingbankentry[$i]['particulars']=='Purchase' || $pendingbankentry[$i]['particulars']=='Loan' || $pendingbankentry[$i]['particulars']=='Expense' || $pendingbankentry[$i]['particulars']=='Maintenance' || $pendingbankentry[$i]['particulars']=='Adhoc' && $pendingbankentry[$i]['table_type']=='payment') 
                {
                    $duedate =  ($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!='')?date('Y-m-d 00:00:00',strtotime($pendingbankentry[$i]['due_date'])):''; 

                     $row = array(
                        '<span class="btn btn-danger unpaid" >Unpaid</span>',
                        '<input type="hidden" id="type_0'.$j.'" value="Receive" />
                        <input type="hidden" id="type_2_0'.$j.'" value="View" />
                        <input type="hidden" id="status_0'. $j.'" value="unpaid" />
                        <input type="hidden" id="txn_status_0'. $j.'" value="'.$pendingbankentry[$i]['txn_status'].'"
                        <input type="hidden" id="prop_id_0'.$j.'" value="'.$pendingbankentry[$i]['prop_id'].'" />
                        <input type="hidden" id="particular_0'.$j.'" value="'.$pendingbankentry[$i]['particulars'].'" />
                        <input type="hidden" id="bal_amount_0'.$j.'" value="'.format_money($pendingbankentry[$i]['bal_amount'],2).'" />
                        <input type="hidden" id="net_amount_0'.$j.'" value="'.format_money($pendingbankentry[$i]['net_amount'],2).'" />
                        <input type="hidden" id="due_date_0'.$j.'" value="'.($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!=''?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):'').'" />
                        <input type="hidden" id="link_0'.$j.'" value="'.base_url().'index.php/Accounting/edit/payment/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:'').'" />
                        <input type="hidden" id="link_2_0'.$j.'" value="'.base_url().'index.php/Accounting/viewOtherSchedule/payment/'.$pendingbankentry[$i]['txn_status'].'/'.$pendingbankentry[$i]['contact_id'].'/'.$pendingbankentry[$i]['transaction'].'/'.($pendingbankentry[$i]['property_id']==''?'0':$pendingbankentry[$i]['property_id']).'/'.($pendingbankentry[$i]['sub_property_id']==''?'0':$pendingbankentry[$i]['sub_property_id']).($pendingbankentry[$i]['txn_status']!='Approved'?'/'.$pendingbankentry[$i]['accounting_id']:'').'" />
                        <input type="hidden" id="owner_name_0'.$j.'" value="'.(isset($pendingbankentry[$i]['owner_name'])?$pendingbankentry[$i]['owner_name']:'').'"/>
                        <input type="hidden" id="payer_name_0'.$j.'" value="'.(isset($pendingbankentry[$i]['payer_name'])?$pendingbankentry[$i]['payer_name']:'').'"/>
                        <input type="hidden" id="property_name_0'.$j.'" value="'.(isset($pendingbankentry[$i]['property'])?$pendingbankentry[$i]['property']:'').'"/>
                        <input type="hidden" id="sub_property_name_0'.$j.'"  value="'.(isset($pendingbankentry[$i]['sub_property'])?$pendingbankentry[$i]['sub_property']:'').'" />
                        <input type="hidden" id="address_0'.$j.'" value="" />
                        <a style="color: #41a541!important; cursor: pointer!important;" id="details_0'.$j.'" onclick="get_details(this);" data-target="#modalSlideLeft" data-toggle="modal">Details</a>',
                        ''.($pendingbankentry[$i]['due_date']!=null && $pendingbankentry[$i]['due_date']!=''?date('d/m/Y',strtotime($pendingbankentry[$i]['due_date'])):'').'',
                        ''. $pendingbankentry[$i]['particulars'].'',
                        ''.(isset($pendingbankentry[$i]['payer_name'])?$pendingbankentry[$i]['payer_name']:'').'',
                        ''.$pendingbankentry[$i]['property'].'',
                        ''.$pendingbankentry[$i]['sub_property'].'',
                        ''.format_money($pendingbankentry[$i]['net_amount'],2).'',
                        ''.format_money($pendingbankentry[$i]['paid_amount'],2).'',
                        ''.isset($pendingbankentry[$i]['bal_amount'])?format_money($pendingbankentry[$i]['bal_amount'],2):''.'',
                        ''.$duedate.'',
                    );
                    $j++;
                    $accounting_data[] = $row;
                }

            }

            $total_accounting_data = count($accounting_data);
            
           foreach ($accounting_data as $key => $row) {
                 $duedates[$key]= $row['10'];
            }

            if(count($accounting_data)>0)
            array_multisort($duedates, SORT_ASC, $accounting_data);
            $params = $_REQUEST;

            $accounting_data = array_slice($accounting_data,$params['start'],$params['length']);
             $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval($total_accounting_data),  
                "recordsFiltered" => intval($total_accounting_data),
                "data"            => $accounting_data
                );

            echo json_encode($json_data);
            //load_view('accounting/accounting', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status='', $property_id='', $contact_id=''){
        $result=$this->accounting_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;

            $data['bankentry']=array();
            $data['pendingbankentry']=array();
            $data['pendingotherentry']=array();

            if(strtolower($status)!='unpaid'){
                $data['bankentry']=$this->accounting_model->bankentryData($status, $property_id, $contact_id);
            }

            if(strtolower($status)=='all' || strtolower($status)=='unpaid'){
                $data['pendingbankentry']=$this->accounting_model->getPendingBankEntry($status, $property_id, $contact_id);
            }
            if(strtolower($status)=='all' || strtolower($status)=='unpaid'){
                $data['pendingotherentry']=$this->accounting_model->getPendingOtherEntry('Approved', $property_id, $contact_id);
            } else {
                $data['pendingotherentry']=$this->accounting_model->getPendingOtherEntry($status, $property_id, $contact_id);
            }
            

            $data['pendingbankentry']=array_merge($data['pendingbankentry'],$data['pendingotherentry']);
            
            // $count_data=$this->accounting_model->getAllCountData();

            $count_data=$this->accounting_model->bankentryData('All', $property_id, $contact_id);
            $all=0;
            $unpaid=0;
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $count_data=$this->accounting_model->getPendingBankEntry('All', $property_id, $contact_id);
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    $unpaid=$unpaid+1;
                }
            }

            $count_data=$this->accounting_model->getPendingOtherEntry('All', $property_id, $contact_id);
            if (count($result)>0){
                for($i=0;$i<count($count_data);$i++){
                    $all=$all+1;
                    if (strtoupper(trim($count_data[$i]['txn_status']))=="APPROVED")
                        $approved=$approved+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="PENDING" || strtoupper(trim($count_data[$i]['txn_status']))=="DELETE")
                        $pending=$pending+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="REJECTED")
                        $rejected=$rejected+1;
                    else if (strtoupper(trim($count_data[$i]['txn_status']))=="IN PROCESS")
                        $inprocess=$inprocess+1;
                }
            }

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['unpaid']=$unpaid;
            $data['all']=$all;


            $data['checkstatus'] = $status;
            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $data['startdate'] = trim($this->input->post('startdate'));
            $data['enddate'] = trim($this->input->post('enddate'));

            load_view('accounting/accounting', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function calculateFiscalYearForDate($inputDate){
        if($inputDate==''){
            $inputDate = date('Y-m-d');
        }
        $year=substr($inputDate, 0, strpos($inputDate, "-"));
        $month=substr($inputDate, strpos($inputDate, "-")+1, strrpos($inputDate, "-")-1);

        $year=intval($year);
        $month=intval($month);

        if($month<4){
            $fyStart=$year-1;
            $fyEnd=$year;
        } else {
            $fyStart=$year;
            $fyEnd=$year+1;
        }

        $fyStart=substr(strval($fyStart),2);
        $fyEnd=substr(strval($fyEnd),2);

        $financial_year=$fyStart.'-'.$fyEnd;

        return $financial_year;
    }

    public function generate_invoice_no($invoice_issuer='', $event_date=''){
        $invoice_no='';

        $sql = "select * from contact_master where c_id = '$invoice_issuer'";
        $query = $this->db->query($sql);
        echo $this->db->last_query();
        $result = $query->result();
        dump($result);
        if(count($result)>0){
            $format = '';
            $series = 1;

            if(isset($result[0]->c_invoice_format)){
                if($result[0]->c_invoice_format!=''){
                    $format = $result[0]->c_invoice_format;
                }
            }

            if(isset($result[0]->c_invoice_no)){
                if($result[0]->c_invoice_no!=''){
                    $series = intval($result[0]->c_invoice_no);
                }
            }

            if($format==''){
                if (isset($event_date)){
                    if($event_date==''){
                        $financial_year="";
                    } else {
                        $financial_year=$this->calculateFiscalYearForDate($event_date).'/';
                    }
                } else {
                    $financial_year="";
                }

                $format = $financial_year;
            }
            
            $invoice_no = $format.strval($series);

            $series = $series + 1;

            $sql="update contact_master set c_invoice_format = '$format', c_invoice_no = '$series' where c_id = '$invoice_issuer'";
            $this->db->query($sql);
        }

        return $invoice_no;
    }

    public function get_contact_personname($c_id){
        $sql = "Select * from (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
            case when A.c_owner_type='individual' 
            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
            else concat(ifnull(A.c_company_name,'')) end as owner_name 
        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
        where A.c_status='Approved') as E Where c_id='$c_id'";
        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    public function invoice_postdate(){
        $currentdate = date("Y-m-d");

        $sql = "Select E.* from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.total_amount , B.tax_amount from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E  Where tenant_id is not null and property_id is not null and invoice_date is not null and invoice_date='$currentdate' GROUP BY txn_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        $this->db->last_query();
        if(count($result)>0){

            for($i=0; $i<count($result); $i++)
            {
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                $invoice_date = $result[$i]->invoice_date;
                $invoice_month =  date("F", strtotime($invoice_date));
                if($invoice_date!="")
                    $invoice_date_5 =  date('Y-m-d',strtotime('-5 days',strtotime($invoice_date)));
                $event_date = $result[$i]->event_date;
                $property_id = $result[$i]->property_id;
                if($property_id!=""){
                    $result_prop = $this->db->select("p_property_name")->where("txn_id=$property_id")->get("purchase_txn")->result();
                    if($result_prop>0)
                      $propert_name=   $result_prop[0]->p_property_name;
                }
                $tenant_id = $result[$i]->tenant_id;
                $net_amount = $result[$i]->total_amount;
                $basic_cost = $result[$i]->basic_cost;
                $gst_rate = $result[$i]->gst_rate;
                $tax_amount = $result[$i]->tax_amount;
                $sch_id = $result[$i]->sch_id;
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

                $link = base_url("index.php/accounting/get_invoice/Rent/").'/'.$sch_id;
                 $message = '<html>
                                  <head>
                                  </head>
                                  <body>
                                    Hi, <br>
                                    <p>Please find below link for rent invoice of <b>'.$propert_name.'</b> property for the month of <b>'.$invoice_month.'</b>.</p>
                                    <p>Link: <a href="'.$link.'">Get Invoice</a></p>
                                    <h4>Invoice Details:</h4>
                                    <table border="1" cellpadding="10">
                                        <th>Particulars</th>
                                        <th>Amount</th>
                                        <tbody>
                                            <tr><td>Rent Amount: </td><td>'.$basic_cost.'</td></tr>
                                            <tr><td>GST@ '.$gst_rate.'%</td><td>'.$tax_amount.'</td></tr>
                                            <tr><td>Total Amount: </td><td>'.$net_amount.'</td></tr>
                                        </tbody>
                                    </table>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>';                  
                $subject = "Rent Invoice for the month of  - ".$invoice_month."for".$propert_name;
                send_email($from_email='',$owner_email, $tenent_email, $subject, $message );
            }
                /*$owner_name = "Sangeeta";
                $table = "";
                
                $subject = "Rent Invoice for the month of".$property;
                $owner_email = "prasad.bhisale@pecanreams.com";
                $to_email = "yadavsangeeta521@gmail.com";

                if(send_email($from_email='',$owner_email, $owner_email, $subject, $message))
                    echo "senddata";
                else
                    echo "fail";*/
        }
    }

    public function invoice_due(){
        $currentdate = date("Y-m-d");
        $sql = "Select * from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.net_amount  , B.tax_amount  from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E Where tenant_id is not null and property_id is not null and event_date='$currentdate'  GROUP BY txn_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        $this->db->last_query();
        if(count($result)>0){

            for($i=0; $i<count($result); $i++)
            {
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                $invoice_date = $result[$i]->invoice_date;
                $event_date = $result[$i]->event_date;
                $invoice_month =  date("F", strtotime($event_date));
                $invoice_date =  date("d", strtotime($event_date));
                $invoice_day = date("D", strtotime($event_date));
                $net_amount = $result[$i]->net_amount;
                $basic_cost = $result[$i]->basic_cost;
                $gst_rate = $result[$i]->gst_rate;
                $tax_amount = $result[$i]->tax_amount;
                if($event_date!="")
                    $event_date_5 =  date('Y-m-d',strtotime('-5 days',strtotime($event_date)));
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
                //$tenant_id = 571;
                $tenent = $this->get_contact_personname($tenant_id);
                if(count($tenent)>0){
                     $tenent_name = $tenent[0]->owner_name;
                     $tenent_email = $tenent[0]->c_emailid1;
                } 
            }
            $link = base_url("index.php/accounting/get_invoice/Rent/").'/'.$sch_id;
            $message = '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>Please note invoice of <b>'.$property_name.'</b> property is due for the month of <b>'.$invoice_month.'</b> from  <b>'.$tenent_name.'</b></p>
                                     <p>Please find below link for rent invoice :</p>
                                    <p>Link: <a href="'.$link.'">Get Invoice</a></p>
                                    <h4>Invoice Details:</h4>
                                    <table border="1" cellpadding="10">
                                        <th>Particulars</th>
                                        <th>Amount</th>
                                        <tbody>
                                            <tr><td>Rent Amount: </td><td>'.$basic_cost.'</td></tr>
                                            <tr><td>GST@ '.$gst_rate.'%</td><td>'.$tax_amount.'</td></tr>
                                            <tr><td>Total Amount: </td><td>'.$net_amount.'</td></tr>
                                        </tbody>
                                    </table>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>';                  
                 $subject = "Rent  Invoice due for the month of   - ".$invoice_month." for ".$property_name;
                 send_email($from_email='',"Pecan Reams", $owner_email, $subject, $message);


                $message_tenant = '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>Please note invoice of <b>'.$property_name.'</b> property is due for the month of <b>'.$invoice_month.'</b> to  <b>'.$owner_name.'</b></p>
                                    <p>Please find below link for rent invoice :</p>
                                    <p>Link: <a href="'.$link.'">Get Invoice</a></p>
                                    <h4>Invoice Details:</h4>
                                    <table border="1" cellpadding="10">
                                        <th>Particulars</th>
                                        <th>Amount</th>
                                        <tbody>
                                            <tr><td>Rent Amount: </td><td>'.$basic_cost.'</td></tr>
                                            <tr><td>GST@ '.$gst_rate.'%</td><td>'.$tax_amount.'</td></tr>
                                            <tr><td>Total Amount: </td><td>'.$net_amount.'</td></tr>
                                        </tbody>
                                    </table>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>';                  
                 $subject = "Rent  Invoice due for the month of   - ".$invoice_month." for ".$property_name;
                send_email($from_email='',$owner_name, $tenent_email, $subject, $message);
        }
    }

    public function invoice_overdue(){
        $currentdate = date("Y-m-d");

        $sql = "Select * from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.net_amount  , B.tax_amount  from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E Where tenant_id is not null and property_id is not null and event_date > '$currentdate'  GROUP BY txn_id";
        $query = $this->db->query($sql);
        $result = $query->result();
         $this->db->last_query();
        
        if(count($result)>0){

            for($i=0; $i<count($result); $i++)
            {
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                $invoice_date = $result[$i]->invoice_date;
                $event_date = $result[$i]->event_date;
                $invoice_month =  date("F", strtotime($event_date));
                $invoice_date =  date("d", strtotime($event_date));
                $invoice_day = date("D", strtotime($event_date));
                $net_amount = $result[$i]->net_amount;
                $basic_cost = $result[$i]->basic_cost;
                $gst_rate = $result[$i]->gst_rate;
                $tax_amount = $result[$i]->tax_amount;
                if($event_date!="")
                    $event_date_5 =  date('Y-m-d',strtotime('-5 days',strtotime($event_date)));
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
                //$tenant_id = 571;
                $tenent = $this->get_contact_personname($tenant_id);
                if(count($tenent)>0){
                     $tenent_name = $tenent[0]->owner_name;
                     $tenent_email = $tenent[0]->c_emailid1;
                } 
            }
            $link = base_url("index.php/accounting/get_invoice/Rent/").'/'.$sch_id;
             $message = '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>Please note invoice of <b>'.$property_name.'</b> property is overdue  for the month of <b>'.$invoice_month.'</b> from  <b>'.$tenent_name.'</b>.</p>
                                     <p>Please find below link for rent invoice :</p>
                                    <p>Link: <a href="'.$link.'">Get Invoice</a></p>
                                    <h4>Invoice Details:</h4>
                                    <table border="1" cellpadding="10">
                                        <th>Particulars</th>
                                        <th>Amount</th>
                                        <tbody>
                                            <tr><td>Rent Amount: </td><td>'.$basic_cost.'</td></tr>
                                            <tr><td>GST@ '.$gst_rate.'%</td><td>'.$tax_amount.'</td></tr>
                                            <tr><td>Total Amount: </td><td>'.$net_amount.'</td></tr>
                                        </tbody>
                                    </table>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>';                  
                 $subject = "Rent Invoice overdue for the month of    - ".$invoice_month." for ".$property_name;
                send_email($from_email='',"Pecan Reams", $owner_email, $subject, $message);

                $message_tenant = '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>Please note invoice of <b>'.$property_name.'</b> property is overdue  for the month of <b>'.$invoice_month.'</b> to  <b>'.$owner_name.'</b>. </p>
                                    <p>Please find below link for rent invoice :</p>
                                    <p>Link: <a href="'.$link.'">Get Invoice</a></p>
                                    <h4>Invoice Details:</h4>
                                    <table border="1" cellpadding="10">
                                        <th>Particulars</th>
                                        <th>Amount</th>
                                        <tbody>
                                            <tr><td>Rent Amount: </td><td>'.$basic_cost.'</td></tr>
                                            <tr><td>GST@ '.$gst_rate.'%</td><td>'.$tax_amount.'</td></tr>
                                            <tr><td>Total Amount: </td><td>'.$net_amount.'</td></tr>
                                        </tbody>
                                    </table>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>';                  
                 $subject = "Rent Invoice overdue for the month of  ".$invoice_month." for ".$property_name;
                send_email($from_email='',$owner_name, $tenent_email, $subject, $message);
        }
    }

    public function lease_expiry(){
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

    public function lease_expired(){
       $currentdate = date("Y-m-d");

        $sql = "Select * from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.net_amount from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E Where tenant_id is not null and property_id is not null and termination_date >='$currentdate' GROUP BY txn_id";
        $query = $this->db->query($sql);
        $result = $query->result();
         $this->db->last_query();
        if(count($result)>0){

            for($i=0; $i<count($result); $i++)
            {
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                echo "<br>".$termination_date = $result[$i]->termination_date;
                $invoice_month =  date("F", strtotime($termination_date));
           
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

                if($termination_date==$currentdate)
                {   

                 $message = '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>This is to inform you that lease term of  <b>'.$property_name.'</b> property has expired today i.e <b>'.date('d-m-Y',strtotime($termination_date)).'</b></p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>'; 
                    $subject = "Expiry of lease of ".$property_name;
                    $owner_email;
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
  
    public function set_invoice(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d');

       echo $sql = "select E.* ,F.pr_client_id from(select C.* ,D.property_txn_id from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.total_amount from 
                (select * from rent_txn where txn_status = 'Approved' and gp_id = '$gid') A 
                left join 
                (select * from rent_schedule where status = '1' and (invoice_no is null or invoice_no='') and 
                    event_type!='Deposit' and date(now())>=date(event_date)) B 
                on (A.txn_id = B.rent_id))C
				left join
				(select * from property_txn)D
				  on (D.property_txn_id = C.property_id))E
				  left join
				(select * from purchase_ownership_details)F
				  on (E.property_txn_id = F.purchase_id)
                where E.sch_id is not null";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
              echo  $invoice_issuer = $result[$i]->pr_client_id;
                $invoice_date = $result[$i]->invoice_date;
                $event_date = $result[$i]->event_date;

                $invoice_no = $this->generate_invoice_no($invoice_issuer, $event_date);

                $day = date('d', strtotime($invoice_date));
                $month = date('m', strtotime($event_date));
                $year = date('Y', strtotime($event_date));
                
                $event_date = $year.'-'.$month.'-'.$day;

                if($month==2){
                    if($day>28){
                        if($year%4==0){
                            $event_date = $year.'-'.$month.'-29';
                        } else {
                            $event_date = $year.'-'.$month.'-28';
                        }
                    }
                } else if($month==4 || $month==6 || $month==9 || $month==11){
                    if($day>30){
                        $event_date = $year.'-'.$month.'-30';
                    }
                }

                echo $invoice_no;
                echo '<br/>';

                $sql = "update rent_schedule set invoice_no = '$invoice_no', invoice_date = '$event_date' where sch_id = '$sch_id'";
                $this->db->query($sql);
            }
        }

        $sql = "select * from actual_other_schedule where txn_status = 'Approved' and gp_id = '$gid' and 
                (invoice_no is null or invoice_no='') and date(now())>=date(event_date)";
        $query = $this->db->query($sql);
        $result = $query->result();
        if(count($result)>0){
            for($i=0; $i<count($result); $i++){
                $property_id = $result[$i]->property_id;
                $sch_id = $result[$i]->id;
                $event_date = $result[$i]->event_date;

                $owners = $this->purchase_model->get_property_owners($property_id);
                if(count($owners)>0){
                    $invoice_issuer = $owners[0]->pr_client_id;
                } else {
                    $invoice_issuer = $result[$i]->approved_by;
                }

                $invoice_no = $this->generate_invoice_no($invoice_issuer, $event_date);

                echo $invoice_no;
                echo '<br/>';

                $sql = "update actual_other_schedule set invoice_no = '$invoice_no', invoice_date = '$event_date' where id = '$sch_id'";
                $this->db->query($sql);
            }
        }

        // $schedule = array();
        // $sch_cnt = 0;

        // $sql = "select * from rent_txn  where txn_status = 'Approved' and gp_id = '$gid'";
        // $query = $this->db->query($sql);
        // $result = $query->result();
        // if(count($result)>0){
        //     for($i=0; $i<count($result); $i++){
        //         $rent_id = $result[$i]->txn_id;

        //         if(is_numeric($result[$i]->rent_amount)){
        //             $rent_amount = floatval($result[$i]->rent_amount);
        //         } else {
        //             $rent_amount = 0;
        //         }

        //         if(is_numeric($result[$i]->deposit_amount)){
        //             $deposit_amount = floatval($result[$i]->deposit_amount);
        //         } else {
        //             $deposit_amount = 0;
        //         }

        //         $invoice_issuer = $result[$i]->invoice_issuer;
        //         $possession_date = $result[$i]->possession_date;
        //         $termination_date = $result[$i]->termination_date;

        //         $data = array(
        //                 'rent_id' => $rent_id,
        //                 'event_type' => 'Deposit',
        //                 'event_name' => 'Deposit',
        //                 'event_date' => $possession_date,
        //                 'basic_cost' => $deposit_amount,
        //                 'net_amount' => $deposit_amount,
        //                 'create_date' => $now,
        //                 'create_by' => $curusr,
        //                 'sch_status' => '1',
        //                 'status' => '1'
        //             );
        //         $this->db->insert('rent_schedule', $data);

        //         $rent_due_day = $result[$i]->rent_due_day;
        //         $invoice_date = $result[$i]->invoice_date;
        //         $schedule = $result[$i]->schedule;
        //         $gst = $result[$i]->gst;
        //         $gst_rate = 0;
        //         $tax_name = '';
        //         if($gst=='1'){
        //             $tax_id = $result[$i]->gst_rate;

        //             if($gst_rate_id!='' && $gst_rate_id!=null){
        //                 $sql = "select * from tax_master where tax_id = '$tax_id'";
        //                 $query = $this->db->query($sql);
        //                 $result2 = $query->result();
        //                 if(count($result2)>0){
        //                     if(is_numeric($result2[0]->tax_percent)){
        //                         $gst_rate = floatval($result2[0]->tax_percent);
        //                         $tax_name = $result2[0]->tax_name;
        //                     }
        //                 }
        //             }
        //         }
        //         if($gst_rate=='' || $gst_rate==null){
        //             $gst_rate=0;
        //         }
        //         $lease = $result[$i]->lease_period;
        //         if(is_numeric($result[$i]->rent_amount)){
        //             $rent = floatval($result[$i]->rent_amount);
        //         } else {
        //             $rent = 0;
        //         }

        //         if($possession_date!="" && $possession_date!=null){
        //             $stdt = DateTime::createFromFormat('Y-m-d', $possession_date);
        //         } else {
        //             $stdt = null;
        //         }
        //         if($termination_date!="" && $termination_date!=null){
        //             $endt = DateTime::createFromFormat('Y-m-d', $termination_date);
        //         } else {
        //             $endt = null;
        //         }

        //         if(is_numeric($result[$i]->rent_due_day)){
        //             $duedy = intval($result[$i]->rent_due_day);
        //         } else {
        //             $duedy = 0;
        //         }
        //         if ($duedy==0) $duedy=1;

        //         $amt2 = round($rent);
        //         $rows='';
        //         $tax='';

        //         $tmpdt = $stdt;
        //         $yy=null;
        //         $mm=null;
        //         if($possession_date!="" && $possession_date!=null){
        //             $mm = $stdt->format("m");
        //             $yy = $stdt->format("Y");
        //         }

        //         if(!isNaN($mm)){
        //             $mm = $mm + 1;
        //         }

        //         $increment = 1;
        //         if($schedule=='Monthly'){
        //             $increment = 1;
        //         } else if($schedule=='Quarterly'){
        //             $increment = 3;
        //             $lease = ceil($lease / 3);
        //             $amt2 = $amt2 * 3;
        //         } else if($schedule=='Yearly'){
        //             $increment = 12;
        //             $lease = ceil($lease / 12);
        //             $amt2 = $amt2 * 12;
        //         }

        //         $i=0; $schedule_id=1;

        //         for ($i = 0; $i < $lease; $i++) {
        //             if($mm==13){
        //                 $mm=1;
        //                 $yy++;
        //             } else if($mm==14){
        //                 $mm=2;
        //                 $yy++;
        //             } else if($mm==15){
        //                 $mm=3;
        //                 $yy++;
        //             } else if($mm==16){
        //                 $mm=4;
        //                 $yy++;
        //             } else if($mm==17){
        //                 $mm=5;
        //                 $yy++;
        //             } else if($mm==18){
        //                 $mm=6;
        //                 $yy++;
        //             } else if($mm==19){
        //                 $mm=7;
        //                 $yy++;
        //             } else if($mm==20){
        //                 $mm=8;
        //                 $yy++;
        //             } else if($mm==21){
        //                 $mm=9;
        //                 $yy++;
        //             } else if($mm==22){
        //                 $mm=10;
        //                 $yy++;
        //             } else if($mm==23){
        //                 $mm=11;
        //                 $yy++;
        //             } else if($mm==24){
        //                 $mm=12;
        //                 $yy++;
        //             }

        //             $abc = $yy.'-'.$mm.'-'.$duedy;
        //             $mm = $mm + $increment;

        //             $check_date = DateTime::createFromFormat('Y-m-d', $abc);
        //             $cur_date = DateTime::createFromFormat('Y-m-d', $now);

        //             $bl_insert = true;
        //             $sql = "select max(event_date) as last_event_date from rent_schedule where rent_id = '$rent_id' and status = '1'";
        //             $query = $this->db->query($sql);
        //             $result2 = $query->result();
        //             if(count($result2)>0){
        //                 $last_event_date = $result2[0]->last_event_date;

        //                 if(isset($last_event_date)){
        //                     if($last_event_date!=''){
        //                         $last_event_date = DateTime::createFromFormat('Y-m-d', $last_event_date);
        //                     }
        //                 }

                        
        //             }

        //             $event_type = 'Rent';
        //             $event_name = 'Rent';
        //             $event_date = $abc;
        //             $basic_cost = $amt2;

        //             $tax_amount = $basic_cost*$gst_rate/100;
        //             $net_amount = $basic_cost + $tax_amount;

        //             $invoice_no = $this->generate_invoice_no($invoice_issuer, $event_date);

        //             $day = date('d', strtotime($invoice_date));
        //             $month = date('m', strtotime($event_date));
        //             $year = date('Y', strtotime($event_date));
        //             $event_date = $year.'-'.$month.'-'.$day;

        //             echo $invoice_no;
        //         }
        //     }
        // }
    }

    public function generate_invoice2(){
       $this->get_invoice('Rent', "70");
    }

    public function get_invoice($type, $id){
        if($type=='Rent'){
            $sql = "select A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.total_amount, C.property_id,
                        avg(B.tax_percent) as gst_rate, sum(B.tax_amount) as tax_amount, 'schedule' as entry_type, A.invoice_no, A.invoice_date 
                    from rent_schedule A left join rent_schedule_taxation B on (A.rent_id=B.rent_id and A.sch_id=B.sch_id) left join rent_txn C on(A.rent_id=C.txn_id )
                    where A.status = '1' and (B.status = '1' or B.status is null) and A.sch_id = '$id' 
                    group by A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, 
                    A.total_amount, A.invoice_no, A.invoice_date ";
            $query = $this->db->query($sql);
            $result = $query->result();
            $invoice = $result;
            if(count($result)>0){
                $rent_id = $result[0]->rent_id;
                $property_id = $result[0]->property_id;
            } else {
                $rent_id = '';
            }

          $sql = "select C.*, D.pr_client_id from (select A.*, B.property_txn_id from(select * from rent_txn where txn_id = '$rent_id' and property_id='$property_id' )A left join (select * from property_txn ) B on (A.property_id=B.property_txn_id))C  left join
				(select * from purchase_ownership_details)D
				  on (C.property_txn_id = D.purchase_id)";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $issuer_id = $result[0]->pr_client_id;
            } else {
                $issuer_id = '';
            }
            
             $sql = "select * from rent_tenant_details where rent_id = '$rent_id' and 
                    id = (select min(id) from rent_tenant_details where rent_id = '$rent_id')";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $tenant_id = $result[0]->contact_id;
            } else {
                $tenant_id = '';
            }
        } else {
            $sql = "select * from actual_other_schedule where id = '$id'";
            $query = $this->db->query($sql);
            $result = $query->result();
            $invoice = $result;
            if(count($result)>0){
                $property_id = $result[0]->property_id;
                $tenant_id = $result[0]->payer_id;
            } else {
                $property_id = '';
                $tenant_id = '';
            }

             $sql = "select * from purchase_ownership_details where purchase_id = '$property_id' and 
                    ow_id = (select min(ow_id) from purchase_ownership_details where purchase_id = '$property_id')";
            $query = $this->db->query($sql);
            $result = $query->result();
            if(count($result)>0){
                $issuer_id = $result[0]->pr_client_id;
            } else {
                $issuer_id = '';
            }
        }

        if(count($invoice)>0){
            $sql = "select * from contact_master where c_id = '$issuer_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $data['issuer_name'] = $result[0]->c_name . ' ' . $result[0]->c_last_name;
                $data['issuer_address'] = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, '', '');
                $state = $result[0]->c_state;
                $data['issuer_gst'] = $result[0]->c_gst_no;
            } else {
                $data['issuer_name'] = '';
                $data['issuer_address'] = '';
                $state = '';
                $data['issuer_gst'] = '';
            }

            $data['issuer_state'] = $state;

            $sql = "select * from state_master where state_name = '$state'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $data['issuer_state_code'] = $result[0]->state_code;
            } else {
                $data['issuer_state_code'] = '';
            }

            $sql = "select * from contact_master where c_id = '$tenant_id'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $data['tenant_name'] = $result[0]->c_name . ' ' . $result[0]->c_last_name;
                $data['tenant_address'] = get_address($result[0]->c_address, $result[0]->c_landmark, $result[0]->c_city, $result[0]->c_pincode, '', '');
                $state = $result[0]->c_state;
            } else {
                $data['tenant_name'] = '';
                $data['tenant_address'] = '';
                $state = '';
            }

            $data['tenant_state'] = $state;

            $sql = "select * from state_master where state_name = '$state'";
            $result = $this->db->query($sql)->result();
            if(count($result)>0){
                $data['tenant_state_code'] = $result[0]->state_code;
            } else {
                $data['tenant_state_code'] = '';
            }

            if(is_numeric($invoice[0]->basic_cost)){
                $basic_cost = floatval($invoice[0]->basic_cost);
            } else {
                $basic_cost = 0;
            }
            if(is_numeric($invoice[0]->total_amount)){
                $net_amount = floatval($invoice[0]->total_amount);
            } else {
                $net_amount = 0;
            }
            if(is_numeric($invoice[0]->gst_rate)){
                $gst_rate = floatval($invoice[0]->gst_rate);
            } else {
                $gst_rate = 0;
            }
            if(is_numeric($invoice[0]->tax_amount)){
                $gst = floatval($invoice[0]->tax_amount);
            } else {
                $gst = 0;
            }

            $cgst_rate = 0;
            $sgst_rate = 0;
            $igst_rate = 0;
            $cgst = 0;
            $sgst = 0;
            $igst = 0;

            if($gst_rate!=0){
                if($data['issuer_state_code']==$data['tenant_state_code']){
                    $cgst_rate = $gst_rate/2;
                    $sgst_rate = $gst_rate/2;

                    $cgst = $gst/2;
                    $sgst = $gst/2;
                } else {
                    $igst_rate = $gst_rate;
                    $igst = $gst;
                }
            }
            
            $total_amount = $basic_cost + $gst;
            $round_off_amount = $net_amount - $total_amount;

            $data['invoice_no'] = $invoice[0]->invoice_no;
            $data['invoice_date'] = $invoice[0]->invoice_date;
            $data['plan_name'] = '';

            $data['value'] = $this->format_money($net_amount,2);
            $data['amount'] = $this->format_money($basic_cost,2);
            $data['discount'] = 0;
            $data['price'] = $this->format_money($basic_cost,2);
            $data['cgst_rate'] = $cgst_rate;
            $data['sgst_rate'] = $sgst_rate;
            $data['igst_rate'] = $igst_rate;
            $data['cgst'] = $this->format_money($cgst,2);
            $data['sgst'] = $this->format_money($sgst,2);
            $data['igst'] = $this->format_money($igst,2);
            $data['gst'] = $this->format_money($gst,2);
            $data['total_amount'] = $this->format_money($net_amount,2);
            $data['round_off_amount'] = $round_off_amount;

            $data['total_amount_in_words']=$this->convert_number_to_words($net_amount) . ' Only';

            $invoice_data['data'] = $data;

            load_view('accounting/invoice',$invoice_data);
        } else {
            echo '<script>alert("No Data Found.");</script>';
            $this->load->view('login/main_page');

        }
    }

    function convert_number_to_words($number) {
        $no = floor($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => ' ', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
        '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
        '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_1) {
         $divider = ($i == 2) ? 10 : 100;
         $number = floor($no % $divider);
         $no = floor($no / $divider);
         $i += ($divider == 10) ? 1 : 2;
         if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                . $digits[$counter] . $plural . " " . $hundred;
         } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        $points = ($point) ? (" and " . $words[$point / 10] . " " .  $words[$point = $point % 10]) : '';

        if($points==""){
            $result = $result . "Rupees ";
        } else {
            $result = $result . "Rupees " . $points . " Paise";
        }
        return $result;
    }

    function format_money($number, $decimal=2){
        if(!isset($number)) $number=0;

        $negative=false;
        if(strpos($number, '-')!==false){
            $negative=true;
            $number = str_replace('-', '', $number);
        }

        $number = floatval(str_replace(',', '', $number));
        $number = round($number, $decimal);

        $decimal="";
        
        if(strpos($number, '.')!==false){
            $decimal = substr($number, strpos($number, '.'));
            $number = substr($number, 0, strpos($number, '.'));
        }
        
        // echo $decimal . '<br/>';
        // echo $number . '<br/>';

        $len = strlen($number);
        $m = '';
        $number = strrev($number);
        for($i=0;$i<$len;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
                $m .=',';
            }
            $m .=$number[$i];
        }

        $number = strrev($m);
        $number = $number . $decimal;

        if($negative==true){
            $number = '-' . $number;
        }

        return $number;
    }

}
?>