<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Bank extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->model('purchase_model');
        $this->load->database();
    }

    public function index(){
        $this->checkstatus("All");
    }

    public function loadbanks() {
        $term = "t";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $abc=array();

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $query=$this->db->query("select * from 
                                    (select b_id, concat(b_name, ' - ', b_accountnumber) as bank_detail from bank_master 
                                        where b_status='Approved' and b_gid='$gid' and 
                                        b_ownerid in(select distinct owner_id from user_role_owners where user_id = '$session_id')) A 
                                    where A.bank_detail like '%" . $term . "%' 
                                    order by case when A.bank_detail = '" . $term . "' then 1 
                                    when A.bank_detail like '%" . $term . "%' then 2 end;");
            $result=$query->result();
            
            foreach($result as $row) {
                $abc[] = array('value' => $row->b_id, 'label' => $row->bank_detail);
            }
        } else {
            $query=$this->db->query("select * from 
                                    (select b_id, concat(b_name, ' - ', b_accountnumber) as bank_detail from bank_master 
                                        where b_status='Approved' and b_gid='$gid') A 
                                    where A.bank_detail like '%" . $term . "%' 
                                    order by case when A.bank_detail = '" . $term . "' then 1 
                                    when A.bank_detail like '%" . $term . "%' then 2 end;");
            $result=$query->result();
            
            foreach($result as $row) {
                $abc[] = array('value' => $row->b_id, 'label' => $row->bank_detail);
            }
        }
        
        // echo $query;
        echo json_encode($abc);
    }

    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Owners') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('bank/bank_details', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function savebank(){
        $gid=$this->session->userdata('groupid');
        $curusr=$this->session->userdata('session_id');
        $roleid=$this->session->userdata('role_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now = date('Y-m-d H:i:s');
            if($this->input->post('submit')=='Submit For Approval') {
                $b_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $b_status='Approved';
            } else  {
                $b_status='In Process';
            }

            $b_bal_ref_date=FormatDate($this->input->post('b_bal_ref_date'));

            $data = array(
                'b_name' => $this->input->post('bank_name') ,
                'b_ownerid' => $this->input->post('owner_name'),
                'registered_address' => $this->input->post('registered_address'),
                'registered_phone' => $this->input->post('registered_phone'),
                'registered_email' => $this->input->post('registered_email'),
                'b_branch' => $this->input->post('bank_branch'),
                'b_address' => $this->input->post('bank_address'),
                'b_landmark' => $this->input->post('bank_landmark'),
                'b_city' => $this->input->post('bank_city'),
                'b_pincode' => $this->input->post('bank_pincode'),
                'b_state' => $this->input->post('bank_state'),
                'b_country' => $this->input->post('bank_country'),
                'b_accounttype' => $this->input->post('account_type'),
                'b_accountnumber' => $this->input->post('account_no'),
                'b_customerid' => $this->input->post('customer_id'),
                'b_ifsc' => $this->input->post('ifsc'),
                'b_micr' => $this->input->post('micr'),
                'b_relationshipmanager' => $this->input->post('relation_manager'),
                'b_phone_number' => $this->input->post('phone_no'),
                'b_openingbalance' => format_number($this->input->post('opening_balance')),
                'b_bal_ref_date' => $b_bal_ref_date,
                'b_status' => $b_status,
                'b_gid' => $gid,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'maker_remark' => $this->input->post('maker_remark')
                );
            $this->db->insert('bank_master', $data);
            $bid=$this->db->insert_id();

            $athcont=$this->input->post('auth_name[]');
            $athpurpose=$this->input->post('auth_purpose[]');
            $athtype=$this->input->post('auth_type[]');
            for ($i=0; $i < count($athcont); $i++) { 
                $data = array(
                    'ath_bnk_id' => $bid ,
                    'ath_contactid' =>  $athcont[$i],
                    'ath_purpose' => $athpurpose[$i],
                    'ath_type' => $athtype[$i]
                    );
                $this->db->insert('bank_authorizedsignatory', $data);
            }

            $logarray['table_id']=$bid;
            $logarray['module_name']='Bank';
            $logarray['cnt_name']='Bank';
            $logarray['action']='Bank Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $this->send_bank_intimation($bid);

            redirect(base_url().'index.php/Bank');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function viewbank($bid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
		$data['bankby']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 or $result[0]->r_view == 1) {
                $data['access']=$result;

                $data['contactby']=$this->session->userdata('session_id');

                $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Owners') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("select * from bank_master where b_id = '$bid'");
                $result=$query->result();
                $data['bankdetail']=$result;
                if(count($result)>0){
                    $b_openingbalance=floatval($result[0]->b_openingbalance);
                    $b_bal_ref_date=$result[0]->b_bal_ref_date;
                } else {
                    $b_openingbalance=0;
                    $b_bal_ref_date=date('Y-m-d');
                }

                $query=$this->db->query("select * FROM bank_authorizedsignatory A WHERE A.ath_bnk_id = '$bid'");
                $result=$query->result();
                $data['bank_sign']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contacts']=$result;

                $b_closingbalance=$b_openingbalance;

                $sql="select sum(tot_amount_paid) as tot_amount_paid from 
                    (select sum(paid_amount) as tot_amount_paid from actual_schedule where txn_status = 'Approved' and 
                        account_number = '$bid' and table_type in ('purchase','maintenance','expense','loan') and 
                        payment_date > '$b_bal_ref_date' 
                    union all 
                    select sum(amount_paid) as tot_amount_paid from actual_schedule_taxes where txn_status = 'Approved' and 
                        account_number = '$bid' and payment_date > '$b_bal_ref_date' 
                    union all 
                    select sum(expense_amount) as tot_amount_paid from actual_other_expense where txn_status = 'Approved' and 
                        account_number = '$bid' and payment_date > '$b_bal_ref_date' 
                    union all 
                    select sum(paid_amount) as tot_amount_paid from actual_other_schedule where txn_status = 'Approved' and 
                        account_number = '$bid' and payment_date > '$b_bal_ref_date' and type = 'payment' 
                    union all 
                    select sum(disbursement_amount) as tot_amount_paid from loan_disbursement where txn_status = 'Approved' and 
                        issuer_bank = '$bid' and disbursement_date > '$b_bal_ref_date') A";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    if(isset($result[0]->tot_amount_paid))
                    $b_closingbalance=$b_closingbalance-floatval($result[0]->tot_amount_paid);
                }

                $sql="select sum(tot_amount_received) as tot_amount_received from 
                    (select sum(paid_amount) as tot_amount_received from actual_schedule where txn_status = 'Approved' and 
                        account_number = '$bid' and table_type in ('sales','rent') and payment_date > '$b_bal_ref_date' 
                    union all 
                    select sum(paid_amount) as tot_amount_received from actual_other_schedule where txn_status = 'Approved' and 
                        account_number = '$bid' and payment_date > '$b_bal_ref_date' and type = 'receipt' 
                    union all 
                    select sum(disbursement_amount) as tot_amount_received from loan_disbursement where txn_status = 'Approved' and 
                        receiver_bank = '$bid' and disbursement_date > '$b_bal_ref_date') A";
                $query=$this->db->query($sql);
                $result=$query->result();
                if(count($result)>0){
                    if(isset($result[0]->tot_amount_paid))
                    $b_closingbalance=$b_closingbalance+floatval($result[0]->tot_amount_received);
                }

                $data['b_closingbalance']=$b_closingbalance;
                $data['b_id']=$bid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('bank/bank_view', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editbank($bid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $data['bankby']=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 or $result[0]->r_view == 1) {
                $data['access']=$result;

                $data['contactby']=$this->session->userdata('session_id');

                $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Owners') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $query=$this->db->query("select * from bank_master where b_id = '$bid'");
                $result=$query->result();
                $data['bankdetail']=$result;
                if(count($result)>0){
                    $b_openingbalance=floatval($result[0]->b_openingbalance);
                    $b_bal_ref_date=$result[0]->b_bal_ref_date;
                } else {
                    $b_openingbalance=0;
                    $b_bal_ref_date=date('Y-m-d');
                }

                $query=$this->db->query("select * FROM bank_authorizedsignatory A WHERE A.ath_bnk_id = '$bid'");
                $result=$query->result();
                $data['bank_sign']=$result;

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid'");
                $result=$query->result();
                $data['contacts']=$result;

                $data['b_id']=$bid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('bank/bank_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($bid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approverecord($bid);
        } else  {
            $this->updatebank($bid);
        }
    }
    
    public function updatebank($bid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {

            if($this->input->post('submit')=='Delete') {
                $b_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $b_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $b_status='Approved';
            } else  {
                $b_status='In Process';
            }

            if($b_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    $query=$this->db->query("SELECT * FROM bank_master WHERE b_id = '$bid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->b_status;
                        $b_fkid = $res[0]->b_fkid;
                        $b_gid = $res[0]->b_gid;
                    } else {
                        $rec_status = '';
                        $b_fkid = '';
                        $b_gid = null;
                    }

                    if ($rec_status=="Approved") {
                        $txn_remarks = $this->input->post('status_remarks');
                        
                        if($maker_checker!='yes'){
                            $b_status = 'Inactive';

                            $this->db->query("update bank_master set b_status='$b_status', txn_remarks='$txn_remarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE b_id = '$bid'");
                            $logarray['table_id']=$bid;
                            $logarray['module_name']='Bank';
                            $logarray['cnt_name']='Bank';
                            $logarray['action']='Bank Record ' . $b_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM bank_master WHERE b_fkid = '$bid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $bid = $result[0]->b_id;

                                $this->db->query("Update bank_master set b_status='$b_status', txn_remarks='$txn_remarks', 
                                                 modified_date='$modnow', modified_by='$curusr'
                                                 WHERE b_id = '$bid'");
                                $logarray['table_id']=$bid;
                                $logarray['module_name']='Bank';
                                $logarray['cnt_name']='Bank';
                                $logarray['action']='Bank Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into bank_master (b_ownerid, registered_address, registered_phone, registered_email, 
                                                 b_name, b_branch, b_address, b_landmark, b_city, b_pincode, b_state, b_country, b_accounttype, b_accountnumber, 
                                                 b_customerid, b_ifsc, b_micr, b_relationshipmanager, b_phone_number, b_openingbalance, 
                                                 b_closingbalance, b_bal_ref_date, b_status, txn_remarks, create_date, created_by, modified_date, modified_by, 
                                                 approved_date, approved_by, b_gid, b_fkid, rejected_by, rejected_date, maker_remark)  
                                                 Select b_ownerid, registered_address, registered_phone, registered_email, b_name, b_branch, 
                                                 b_address, b_landmark, b_city, b_pincode, b_state, b_country, b_accounttype, b_accountnumber, 
                                                 b_customerid, b_ifsc, b_micr, b_relationshipmanager, b_phone_number, b_openingbalance, 
                                                 b_closingbalance, b_bal_ref_date, '$b_status', '$txn_remarks', create_date, created_by, '$modnow', '$curusr', 
                                                 approved_date, approved_by, b_gid, '$bid', rejected_by, rejected_date, maker_remark 
                                                 FROM bank_master WHERE b_id = '$bid'");
                                $new_bid=$this->db->insert_id();

                                $this->db->query("Insert into bank_authorizedsignatory (ath_bnk_id, ath_contactid, ath_purpose, ath_type)  
                                                 Select '$new_bid', ath_contactid, ath_purpose, ath_type 
                                                 FROM bank_authorizedsignatory WHERE ath_bnk_id = '$bid'");

                                $logarray['table_id']=$bid;
                                $logarray['module_name']='Bank';
                                $logarray['cnt_name']='Bank';
                                $logarray['action']='Bank Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('b_id', $bid);
                        $this->db->delete('bank_master');

                        $this->db->where('ath_bnk_id', $bid);
                        $this->db->delete('bank_authorizedsignatory');
                        $logarray['table_id']=$bid;
                        $logarray['module_name']='Bank';
                        $logarray['cnt_name']='Bank';
                        $logarray['action']='Delete Bank Record';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Bank');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    $now = date('Y-m-d H:i:s');
                    $query=$this->db->query("SELECT * FROM bank_master WHERE b_id = '$bid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->b_status;
                        $b_fkid = $res[0]->b_fkid;
                        $b_gid = $res[0]->b_gid;
                        $created_by = $res[0]->created_by;
                        $create_date = $res[0]->create_date;
                    } else {
                        $rec_status = '';
                        $b_fkid = '';
                        $b_gid = $gid;
                        $created_by = $curusr;
                        $create_date = $now;
                    }

                    $b_bal_ref_date=FormatDate($this->input->post('b_bal_ref_date'));
                    
                    $data = array(
                        'b_name' => $this->input->post('bank_name') ,
                        'b_ownerid' => $this->input->post('owner_name'),
                        'registered_address' => $this->input->post('registered_address'),
                        'registered_phone' => $this->input->post('registered_phone'),
                        'registered_email' => $this->input->post('registered_email'),
                        'b_branch' => $this->input->post('bank_branch'),
                        'b_address' => $this->input->post('bank_address'),
                        'b_landmark' => $this->input->post('bank_landmark'),
                        'b_city' => $this->input->post('bank_city'),
                        'b_pincode' => $this->input->post('bank_pincode'),
                        'b_state' => $this->input->post('bank_state'),
                        'b_country' => $this->input->post('bank_country'),
                        'b_accounttype' => $this->input->post('account_type'),
                        'b_accountnumber' => $this->input->post('account_no'),
                        'b_customerid' => $this->input->post('customer_id'),
                        'b_ifsc' => $this->input->post('ifsc'),
                        'b_micr' => $this->input->post('micr'),
                        'b_relationshipmanager' => $this->input->post('relation_manager'),
                        'b_phone_number' => $this->input->post('phone_no'),
                        'b_openingbalance' => format_number($this->input->post('opening_balance')),
                        'b_bal_ref_date' => $b_bal_ref_date,
                        'b_status' => $b_status,
                        'b_gid' => $b_gid,
                        'maker_remark' => $this->input->post('maker_remark')
                    );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $b_fkid = $bid;
                        $data['b_fkid'] = $b_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('bank_master',$data);
                        $bid=$this->db->insert_id();

                        $logarray['table_id']=$b_fkid;
                        $logarray['module_name']='Bank';
                        $logarray['cnt_name']='Bank';
                        $logarray['action']='Bank Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('b_id', $bid);
                        $this->db->update('bank_master',$data);
                        $logarray['table_id']=$bid;
                        $logarray['module_name']='Bank';
                        $logarray['cnt_name']='Bank';
                        $logarray['action']='Bank Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('ath_bnk_id', $bid);
                        $this->db->delete('bank_authorizedsignatory');
                    }

                    $athcont=$this->input->post('auth_name[]');
                    $athpurpose=$this->input->post('auth_purpose[]');
                    $athtype=$this->input->post('auth_type[]');
                    for ($i=0; $i < count($athcont); $i++) { 
                        $data = array(
                            'ath_bnk_id' => $bid ,
                            'ath_contactid' =>  $athcont[$i],
                            'ath_purpose' => $athpurpose[$i],
                            'ath_type' => $athtype[$i]
                        );
                     
                        $this->db->insert('bank_authorizedsignatory', $data);
                    }
                    redirect(base_url().'index.php/Bank');
                }  else {
                    echo "Unauthorized access.";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approverecord($bid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM bank_master WHERE b_id = '$bid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->b_status;
                    $b_fkid = $res[0]->b_fkid;
                    $b_gid = $res[0]->b_gid;
                } else {
                    $rec_status = '';
                    $b_fkid = '';
                    $b_gid = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $b_status='Approved';
                } else  {
                    $b_status='Rejected';
                }
                $txn_remarks = $this->input->post('status_remarks');

                if ($b_status=='Rejected') {
                    $this->db->query("update bank_master set b_status='Rejected', txn_remarks='$txn_remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE b_id = '$bid'");
                    
                    $logarray['table_id']=$bid;
                    $logarray['module_name']='Bank';
                    $logarray['cnt_name']='Bank';
                    $logarray['action']='Bank Record ' . $b_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($b_fkid=='' || $b_fkid==null) {
                        $this->db->query("update bank_master set b_status='Approved', approved_by='$curusr', approved_date='$modnow' WHERE b_id = '$bid'");

                        $logarray['table_id']=$bid;
                        $logarray['module_name']='Bank';
                        $logarray['cnt_name']='Bank';
                        $logarray['action']='Bank Record ' . $b_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $b_status='Inactive';
                        }
                        $this->db->query("update bank_master A, bank_master B set A.b_ownerid=B.b_ownerid,
                                         A.registered_address=B.registered_address,A.registered_phone=B.registered_phone,
                                         A.registered_email=B.registered_email,A.b_name=B.b_name,A.b_branch=B.b_branch,
                                         A.b_address=B.b_address,A.b_landmark=B.b_landmark,A.b_city=B.b_city,A.b_pincode=B.b_pincode,
                                         A.b_state=B.b_state,A.b_country=B.b_country,A.b_accounttype=B.b_accounttype,
                                         A.b_accountnumber=B.b_accountnumber,A.b_customerid=B.b_customerid,A.b_ifsc=B.b_ifsc,A.b_micr=B.b_micr,
                                         A.b_relationshipmanager=B.b_relationshipmanager,A.b_phone_number=B.b_phone_number,
                                         A.b_openingbalance=B.b_openingbalance,A.b_closingbalance=B.b_closingbalance,
                                         A.b_bal_ref_date=B.b_bal_ref_date,
                                         A.b_status='$b_status',A.txn_remarks='$txn_remarks',A.create_date=B.create_date,
                                         A.created_by=B.created_by,A.modified_date=B.modified_date,A.modified_by=B.modified_by,
                                         A.approved_date='$modnow',A.approved_by='$curusr',A.b_gid=B.b_gid,
                                         A.rejected_by=B.rejected_by,A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark 
                                         WHERE B.b_id = '$bid' and A.b_id=B.b_fkid");

                        $this->db->where('ath_bnk_id', $b_fkid);
                        $this->db->delete('bank_authorizedsignatory');

                        $this->db->query("update bank_authorizedsignatory set ath_bnk_id = '$b_fkid' WHERE ath_bnk_id = '$bid'");

                        $this->db->query("delete from bank_master WHERE b_id = '$bid'");

                        $logarray['table_id']=$b_fkid;
                        $logarray['module_name']='Bank';
                        $logarray['cnt_name']='Bank';
                        $logarray['action']='Bank Record ' . $b_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }
            }
        }

       redirect(base_url().'index.php/Bank');
    }
	
	public function checkstatus($status=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Bank' AND role_id='$roleid' AND r_view = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data = $this->getBankData($status);

            $data['access']=$result;
            
            $query=$this->db->query("SELECT * FROM bank_master WHERE b_gid = '$gid' AND b_status!='Inactive'");
            $result=$query->result();
            $data['all']=$result;

            $query=$this->db->query("SELECT * FROM bank_master WHERE b_gid = '$gid' AND b_status='In Process'");
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM bank_master WHERE b_gid = '$gid' AND b_status='Approved'");
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM bank_master WHERE b_gid='$gid' AND  (b_status='Pending' or b_status='Delete')");
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM bank_master WHERE b_gid='$gid' AND b_status='Rejected'");
            $result=$query->result();
            $data['rejected']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');
             $data['checkstatus'] = $status;

            load_view('bank/bank_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function getBankData($status='', $bid=''){
        $gid=$this->session->userdata('groupid');
        if($status=='All'){
            $cond="";
        } else if($status=='InProcess'){
            $status='In Process';
            $cond=" and b_status='In Process'";
        } else if($status=='Pending'){
            $cond=" and (b_status='Pending' or b_status='Delete')";
        } else {
            $cond=" and b_status='$status'";
        }

        if($bid!=""){
            $cond=" and b_id = '$bid'";
        }

        $query=$this->db->query("SELECT * FROM bank_master WHERE b_gid='$gid' " . $cond . " ORDER BY modified_date desc");
        $result=$query->result();
        $data['banks']=$result;

        $data['bankowner']=NULL;
        for ($i=0; $i < count($result) ; $i++) { 
            $owid=$result[$i]->b_ownerid;
            $quer=$this->db->query("select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                                        case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                            else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                                        case when A.c_owner_type='individual' 
                                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$owid'");
            $result1=$quer->result();
            
            if(count($result1)>0){
                $data['bankowner'][$i]['name']=$result1[0]->c_full_name;
                $data['bankowner'][$i]['email']=$result1[0]->c_emailid1;
            } else {
                $data['bankowner'][$i]['name']='';
                $data['bankowner'][$i]['email']='';
            }

            $rmid=$result[$i]->b_relationshipmanager;
            $quer=$this->db->query("select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                                        case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                            else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
                                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                                        case when A.c_owner_type='individual' 
                                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_id='$rmid'");
            $result2=$quer->result();
            if(count($result2)>0){
                $data['relationshipmanager'][$i]=$result2[0]->c_full_name;
            } else {
                $data['relationshipmanager'][$i]='';
            }
        }
        
        return $data;   
    }

    public function send_bank_intimation($bid){
        $gid=$this->session->userdata('groupid');
        
        $group_owners=$this->purchase_model->get_group_owners($gid);
        $prop_owners="";

        $table=$this->get_bank_list_table($bid);
        $data=$this->getBankData("All", $bid);

        $owner_name=$data['bankowner'][0]['name'];
        $to_email=$data['bankowner'][0]['email'];
        $prop_owners=$prop_owners.$owner_name.', ';
        if(strpos($prop_owners, ', ')>0){
            $prop_owners=substr($prop_owners,0,strripos($prop_owners, ', '));
        }
        $this->send_bank_intimation_to_owner($table, $owner_name, $to_email);

        if(count($group_owners)>0){
            for($i=0;$i<count($group_owners);$i++){
                $owner_name="";
                if(isset($group_owners[$i]->c_name)){
                    $owner_name=$group_owners[$i]->c_name;
                }
                if(isset($group_owners[$i]->c_last_name)){
                    $owner_name=$owner_name.' '.$group_owners[$i]->c_last_name;
                }
                $to_email=$group_owners[$i]->c_emailid1;

                $this->send_bank_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
            }
        }
    }

    public function get_bank_list_table($bid) {
        $data = $this->getBankData("All", $bid);
        $table='';

        if(count($data)>0) {
            $table='<div>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Bank Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Owner</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Status</th>
                                <th style="padding:5px; border: 1px solid black;" width="110">Branch</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Account Type</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Account Number</th>
                                <th style="padding:5px; border: 1px solid black;" width="50">IFSC Code</th>
                                <th style="padding:5px; border: 1px solid black;" width="50">Relationship Manager</th>
                            </tr>
                        </thead>
                        <tbody>';

            for($i=0;$i<count($data['banks']); $i++ ) {
                $table=$table.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['banks'][$i]->b_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['bankowner'][$i]['name'].'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['banks'][$i]->b_status.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['banks'][$i]->b_branch.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['banks'][$i]->b_accounttype.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['banks'][$i]->b_accountnumber.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['banks'][$i]->b_ifsc.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$data['relationshipmanager'][$i].'</td>
                            </tr>';
            }

            $table=$table.'</tbody></table></div>';

            // echo $table;
            return $table;
        }
    }

    public function send_bank_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Bank Account Creation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Bank Entry has been created for '.$prop_owners.'. 
                    The Bank details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above account details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

    public function send_bank_intimation_to_owner($table, $owner_name, $to_email) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Bank Account Creation';
        
        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Bank Entry has been mapped to you.  
                    The Bank details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above account is not yours please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }
}
?>