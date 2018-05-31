<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Dashboard extends CI_Controller
{
    public function __construct(){
        parent::__construct();
      
        $this->load->helper('common_functions');
        $this->load->model('dashboard_model');
        $this->load->model('bank_entry_model');
        $this->load->model('task_model');
    }

    public function group(){
        $cid=$this->session->userdata('session_id');
        $gu_id=$this->session->userdata('gu_id');
        // $result=$this->bank_entry_model->getAccess();
        // if(count($result)>0) {
        //     $data['schedule_detail']=$this->dashboard_model->getAllSchedule('Pending');
        // }
        
        $view = '';
        $query=$this->db->query("SELECT A.gu_gid, B.group_name, B.verified, B.maker_checker, B.maker_checker_verified FROM group_users A, group_master B 
                                WHERE A.gu_id = '$gu_id' and A.gu_gid = B.g_id and B.group_status='Active'");
        $result=$query->result();
        $data['user_details']=$result;
        if(count($result)>0){
            $view = 'dashboard/verify';
        }

        $query=$this->db->query("SELECT * FROM contact_master A WHERE A.c_id = '$cid'");
        $result=$query->result();
        $data['contact_details']=$result;

        load_view($view, $data);
    }

    public function home(){
        $cid=$this->session->userdata('session_id');
        $gu_id=$this->session->userdata('gu_id');
        // $result=$this->bank_entry_model->getAccess();
        // if(count($result)>0) {
        //     $data['schedule_detail']=$this->dashboard_model->getAllSchedule('Pending');
        // }
        
        $view = '';
        $query=$this->db->query("SELECT A.gu_gid, B.group_name, B.verified, B.maker_checker, B.maker_checker_verified FROM group_users A, group_master B 
                                WHERE A.gu_id = '$gu_id' and A.gu_gid = B.g_id and B.group_status='Active'");
        $result=$query->result();
        $data['user_details']=$result;
        if(count($result)>0){
            //$view = 'dashboard/home';
            $view = 'dashboard/dashboard';
        }

        $query=$this->db->query("SELECT * FROM contact_master A WHERE A.c_id = '$cid'");
        $result=$query->result();
        $data['contact_details']=$result;

        load_view($view, $data);
    }

    public function index(){
        $cid=$this->session->userdata('session_id');
        $gu_id=$this->session->userdata('gu_id');
        $gid=$this->session->userdata('groupid');

        // $result=$this->bank_entry_model->getAccess();
        // if(count($result)>0) {
        //     $data['schedule_detail']=$this->dashboard_model->getAllSchedule('Pending');
        // }
        
        $view = '';
        $query=$this->db->query("SELECT A.gu_gid, B.group_name, B.verified, B.maker_checker, B.maker_checker_verified FROM group_users A, group_master B 
                                WHERE A.gu_id = '$gu_id' and A.gu_gid = B.g_id and B.group_status='Active'");
        $result=$query->result();
        $data['user_details']=$result;
        if(count($result)>0){
            if($result[0]->verified=='yes'){
                if($result[0]->maker_checker=='yes'){
                    if($result[0]->maker_checker_verified=='yes'){
                        $view = 'dashboard/dashboard';
                    } else {
                        $view = 'dashboard/maker_checker';
                    }
                } else {
                    $view = 'dashboard/dashboard';
                }
            } else {
                $view = 'dashboard/verify';
            }
        }

        $query=$this->db->query("SELECT A.gu_gid, B.group_name FROM group_users A, group_master B 
                                WHERE A.gu_cid = '$cid' and A.gu_gid = B.g_id and B.group_status='Active'");
        $result=$query->result();
        $data['groups']=$result;

        $query=$this->db->query("SELECT * FROM contact_master A WHERE A.c_id = '$cid'");
        $result=$query->result();
        $data['contact_details']=$result;

        $progress = 0;
        $data['property']=array();
        $data['tenant']=array();
        $data['rent']=array();
        $data['website']=array();

        $sql="select * from property_txn where gp_id = '$gid' and txn_status = 'Approved'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $data['property']=$result;
            $progress = $progress + 25;
        }
        
        $sql="select * from contact_master where c_gid = '$gid' and c_status = 'Approved' and c_type = 'Tenants'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $data['tenant']=$result;
            $progress = $progress + 25;
        }
        
        $sql="select * from rent_txn where gp_id = '$gid' and txn_status = 'Approved'";
        $query=$this->db->query($sql);
        $result=$query->result();
        if(count($result)>0){
            $data['rent']=$result;
            $progress = $progress + 25;
        }

        $data['progress']=$progress;

        $sql = "select (H.total_cnt-H.sale_cnt-H.rent_cnt) as vacant_cnt, total_cnt, sale_cnt, rent_cnt from 
                (select count(txn_id) as total_cnt, count(sale_id) as sale_cnt, count(rent_id) as rent_cnt from 
                (select E.*, F.txn_id as sale_id from 
                (select C.*, D.txn_id as rent_id from 
                (select A.*, 0 as sp_id from 
                (select txn_id from property_txn where gp_id='$gid' and txn_status = 'Approved') A 
                union all
                select A.txn_id, B.txn_id as sp_id from 
                (select txn_id from property_txn where gp_id='$gid' and txn_status = 'Approved') A ) B 
                on (A.txn_id=B.property_txn_id) where B.txn_id is not null) C 
                left join 
                (select txn_id, '' as sub_property_id 
                    from rent_txn where gp_id='$gid' and txn_status = 'Approved') D 
                on (C.txn_id = D.property_txn_id and C.sp_id = D.sub_property_id)) E 
                left join 
                (select txn_id, property_id,'' as sub_property_id 
                    from sales_txn where gp_id='$gid' and txn_status = 'Approved') F 
                on (E.txn_id = F.property_id )) G) H";
        $query=$this->db->query($sql);
        $result=$query->result();
        $data['property_cnt']=$result;

        $sql = "select sum(E.paid_amount) as paid_invoices, sum(E.net_amount-E.paid_amount) as open_invoices from 
                (select C.txn_id, C.event_type, C.event_name, C.event_date, ifnull(C.net_amount,0) as net_amount, 
                    sum(ifnull(D.paid_amount,0)+ifnull(D.tds_amount,0)) as paid_amount from 
                (select A.txn_id, B.event_type, B.event_name, B.event_date, B.net_amount from 
                (select * from rent_txn where gp_id='$gid' and txn_status = 'Approved') A 
                left join 
                (select * from rent_schedule where status = '1' and (invoice_no is not null or invoice_no<>'')) B 
                on (A.txn_id = B.rent_id) 
                union all 
                select fk_txn_id, event_type, event_name, event_date, net_amount 
                from actual_other_schedule where gp_id='$gid' and txn_status = 'Approved' and (invoice_no is not null or invoice_no<>'')) C 
                left join 
                (select * from actual_schedule where gp_id='$gid' and txn_status = 'Approved') D 
                on (C.txn_id = D.fk_txn_id and C.event_type = D.event_type and C.event_name = D.event_name and C.event_date = D.event_date) 
                group by C.txn_id, C.event_type, C.event_name, C.event_date, C.net_amount) E ";
        $query=$this->db->query($sql);
        $result=$query->result();
        $data['invoice_cnt']=$result;

        $sql = "select sum(E.net_amount-E.paid_amount) as total_outstanding from 
                (select C.txn_id, C.event_type, C.event_name, C.event_date, ifnull(C.net_amount,0) as net_amount, 
                    sum(ifnull(D.paid_amount,0)+ifnull(D.tds_amount,0)) as paid_amount from 
                (select A.txn_id, B.event_type, B.event_name, B.event_date, B.net_amount from 
                (select * from rent_txn where gp_id='$gid' and txn_status = 'Approved') A 
                left join 
                (select * from rent_schedule where status = '1' and (invoice_no is not null or invoice_no<>'') and date(event_date)<=date(now())) B 
                on (A.txn_id = B.rent_id) 
                union all 
                select fk_txn_id, event_type, event_name, event_date, net_amount 
                from actual_other_schedule where gp_id='$gid' and txn_status = 'Approved' and (invoice_no is not null or invoice_no<>'') and date(event_date)<=date(now())) C 
                left join 
                (select * from actual_schedule where gp_id='$gid' and txn_status = 'Approved') D 
                on (C.txn_id = D.fk_txn_id and C.event_type = D.event_type and C.event_name = D.event_name and C.event_date = D.event_date) 
                group by C.txn_id, C.event_type, C.event_name, C.event_date, C.net_amount) E ";
        $query=$this->db->query($sql);
        $result=$query->result();
        $data['total_outstanding']=$result[0]->total_outstanding;

        load_view($view, $data);
    }

    public function changegroup(){
        $g_id=$this->input->post('g_id');
        $u_id=$this->session->userdata('username');
        //    $cid=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT A.gu_gid, B.group_name, A.assigned_role, A.gu_role FROM group_users A, group_master B WHERE B.g_id = '$g_id' and A.gu_gid = B.g_id and A.gu_email='$u_id'");
        $result=$query->result();
        //if(count($result)>0){
            $data['groups']=$result;

            $sessiondata['groupid'] = $result[0]->gu_gid;
            $sessiondata['groupname'] = $result[0]->group_name;
            $sessiondata['role_id'] = $result[0]->assigned_role;
            $sessiondata['usrrole'] = $result[0]->gu_role;
                        
            $this->session->set_userdata($sessiondata);
        //}

        //load_view('dashboard/dashboard', $data);
        echo 1;
    }    
    
    public function checkstatus($status='') {
        $cid=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT A.gu_gid, B.group_name FROM group_users A, group_master B WHERE A.gu_cid = '$cid' and A.gu_gid = B.g_id");
        $result=$query->result();
        $data['groups']=$result;
        
        // $data['task_detail']=$this->task_model->getTaskList($cid,$status);
        $dataarray=array();
        $i=0;
        $result=$this->task_model->getTaskList($cid,$status);
        if(count($result) > 0){
            foreach($result as $row){
                $dataarray[$i]['subject_detail']=$row->subject_detail;
                $dataarray[$i]['property']=$row->p_property_name . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['owner_name']=$row->owner_name;
                $dataarray[$i]['assigned_by']=$row->created_by_name;
                $dataarray[$i]['assigned_to']=$row->name;
                $dataarray[$i]['due_date']=$row->due_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->task_status;
                $dataarray[$i]['remarks']=$row->message_detail;
                $dataarray[$i]['id']=$row->id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $i++;
            }
        }
        $data['task_detail']=$dataarray;

        $result=$this->bank_entry_model->getAccess();
        if(count($result)>0) {
            
            $data['schedule_detail']=$this->dashboard_model->getAllSchedule($status);

        } else {
            // echo 'You donot have access to this page.';
        }

        load_view('dashboard/dashboard', $data);
    }

    public function confirm_details() {
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1) {
                $now=date('Y-m-d H:i:s');
                $modnow=date('Y-m-d H:i:s');
                $curusr=$this->session->userdata('session_id');
                $gid=$this->session->userdata('groupid');
                $gu_id=$this->session->userdata('gu_id');

                $first_name = $this->input->post('first_name');
                $last_name = $this->input->post('last_name');
                $email_id = $this->input->post('email_id');
                $contact_number = $this->input->post('contact_number');
                $group_name = $this->input->post('group_name');
                $maker_checker = $this->input->post('maker_checker');

                $data = array(
                            'group_name' => $group_name,
                            'maker_checker' => $maker_checker,
                            'verified' => 'yes',
                            'modified_date' => $modnow,
                            'modified_by' => $curusr
                        );
                $this->db->where('g_id',$gid);
                $this->db->update('group_master', $data);
                
                $data = array(
                            'c_name' => $first_name,
                            'c_last_name' => $last_name,
                            'c_emailid1' => $email_id,
                            'c_mobile1' => $contact_number,
                            'c_modifiedby' => $curusr,
                            'c_modifieddate' => $modnow
                        );
                $this->db->where('c_id',$curusr);
                $this->db->update('contact_master', $data);

                $data = array(
                            'name' => $first_name,
                            'gu_email' => $email_id,
                            'gu_mobile' => $contact_number,
                            'updated_by' => $curusr,
                            'updated_at' => $modnow
                        );
                $this->db->where('gu_id',$gu_id);
                $this->db->update('group_users', $data);

                $data = array(
                            'name' => $first_name,
                            'email' => $email_id,
                            'mobile' => $contact_number
                        );
                $this->db->where('id',$gu_id);
                $this->db->update('users', $data);

                $this->session->set_userdata('groupname', $group_name);
                $this->session->set_userdata('maker_checker', $maker_checker);

                redirect(base_url().'index.php/Dashboard');
                
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo 'You donot have access to this page.';
        }
    }

    public function save_maker_checker() {
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1) {
                $now=date('Y-m-d H:i:s');
                $modnow=date('Y-m-d H:i:s');
                $curusr=$this->session->userdata('session_id');
                $group_id=$this->session->userdata('groupid');
                $gu_id=$this->session->userdata('gu_id');

                $maker_first_name=$this->input->post('maker_first_name[]');
                $maker_last_name=$this->input->post('maker_last_name[]');
                $maker_email_id=$this->input->post('maker_email_id[]');
                $maker_contact_number=$this->input->post('maker_contact_number[]');

                $checker_first_name=$this->input->post('checker_first_name[]');
                $checker_last_name=$this->input->post('checker_last_name[]');
                $checker_email_id=$this->input->post('checker_email_id[]');
                $checker_contact_number=$this->input->post('checker_contact_number[]');

                $admin_first_name=$this->input->post('admin_first_name[]');
                $admin_last_name=$this->input->post('admin_last_name[]');
                $admin_email_id=$this->input->post('admin_email_id[]');
                $admin_contact_number=$this->input->post('admin_contact_number[]');

                $password=password_hash('pass@123', PASSWORD_BCRYPT, array('cost' => 10));

                for ($i=0; $i < count($maker_first_name) ; $i++) {
                    if($maker_first_name[$i]!=''){
                        $first_name=$maker_first_name[$i];
                        $last_name=$maker_last_name[$i];
                        $email_id=$maker_email_id[$i];
                        $contact_number=$maker_contact_number[$i];

                        $data = array(
                                    'c_name' => $first_name,
                                    'c_last_name' =>  $last_name,
                                    'c_emailid1' => $email_id,
                                    'c_mobile1' => $contact_number,
                                    'c_status' => 'Approved',
                                    'c_gid' => $group_id,
                                    'c_createdate' => $now,
                                    'c_createdby' => '0',
                                    'c_modifieddate' => $now,
                                    'c_modifiedby' => '0'
                                );
                        $this->db->insert('contact_master',$data);
                        $contact_id=$this->db->insert_id();

                        $data = array(
                                    'gu_gid' => $group_id,
                                    'name' => $first_name,
                                    'gu_email' => $email_id,
                                    'gu_mobile' => $contact_number,
                                    'gu_password' => $password,
                                    'gu_role' => 'Maker',
                                    'add_date' => $now,
                                    'gu_cid' => $contact_id,
                                    'assigned_status' => 'Approved',
                                    'assigned_role' => '3',
                                    'created_at' => $now,
                                    'created_by' => '0',
                                    'updated_at' => $now,
                                    'updated_by' => '0',
                                    'user_type' => 'user',
                                    'isVerified' => '0'
                                );
                        $this->db->insert('group_users',$data);

                        $data = array(
                                    'name' => $first_name,
                                    'email' => $email_id,
                                    'mobile' => $contact_number,
                                    'password' => $password,
                                    'isVerified' => '0'
                                );
                        $this->db->insert('users',$data);
                    }
                }
                
                for ($i=0; $i < count($checker_first_name) ; $i++) {
                    if($checker_first_name[$i]!=''){
                        $first_name=$maker_first_name[$i];
                        $last_name=$checker_last_name[$i];
                        $email_id=$checker_email_id[$i];
                        $contact_number=$checker_contact_number[$i];

                        $data = array(
                                    'c_name' => $first_name,
                                    'c_last_name' =>  $last_name,
                                    'c_emailid1' => $email_id,
                                    'c_mobile1' => $contact_number,
                                    'c_status' => 'Approved',
                                    'c_gid' => $group_id,
                                    'c_createdate' => $now,
                                    'c_createdby' => '0',
                                    'c_modifieddate' => $now,
                                    'c_modifiedby' => '0'
                                );
                        $this->db->insert('contact_master',$data);
                        $contact_id=$this->db->insert_id();

                        $data = array(
                                    'gu_gid' => $group_id,
                                    'name' => $first_name,
                                    'gu_email' => $email_id,
                                    'gu_mobile' => $contact_number,
                                    'gu_password' => $password,
                                    'gu_role' => 'Checker',
                                    'add_date' => $now,
                                    'gu_cid' => $contact_id,
                                    'assigned_status' => 'Approved',
                                    'assigned_role' => '4',
                                    'created_at' => $now,
                                    'created_by' => '0',
                                    'updated_at' => $now,
                                    'updated_by' => '0',
                                    'user_type' => 'user',
                                    'isVerified' => '0'
                                );
                        $this->db->insert('group_users',$data);

                        $data = array(
                                    'name' => $first_name,
                                    'email' => $email_id,
                                    'mobile' => $contact_number,
                                    'password' => $password,
                                    'isVerified' => '0'
                                );
                        $this->db->insert('users',$data);
                    }
                }
                
                for ($i=0; $i < count($admin_first_name) ; $i++) {
                    if($admin_first_name[$i]!=''){
                        $first_name=$admin_first_name[$i];
                        $last_name=$admin_last_name[$i];
                        $email_id=$admin_email_id[$i];
                        $contact_number=$admin_contact_number[$i];

                        $data = array(
                                    'c_name' => $first_name,
                                    'c_last_name' =>  $last_name,
                                    'c_emailid1' => $email_id,
                                    'c_mobile1' => $contact_number,
                                    'c_status' => 'Approved',
                                    'c_gid' => $group_id,
                                    'c_createdate' => $now,
                                    'c_createdby' => '0',
                                    'c_modifieddate' => $now,
                                    'c_modifiedby' => '0'
                                );
                        $this->db->insert('contact_master',$data);
                        $contact_id=$this->db->insert_id();

                        $data = array(
                                    'gu_gid' => $group_id,
                                    'name' => $first_name,
                                    'gu_email' => $email_id,
                                    'gu_mobile' => $contact_number,
                                    'gu_password' => $password,
                                    'gu_role' => 'Admin',
                                    'add_date' => $now,
                                    'gu_cid' => $contact_id,
                                    'assigned_status' => 'Approved',
                                    'assigned_role' => '1',
                                    'created_at' => $now,
                                    'created_by' => '0',
                                    'updated_at' => $now,
                                    'updated_by' => '0',
                                    'user_type' => 'Owner',
                                    'isVerified' => '0'
                                );
                        $this->db->insert('group_users',$data);

                        $data = array(
                                    'name' => $first_name,
                                    'email' => $email_id,
                                    'mobile' => $contact_number,
                                    'password' => $password,
                                    'isVerified' => '0'
                                );
                        $this->db->insert('users',$data);
                    }
                }

                $data = array(
                            'maker_checker_verified' => 'yes',
                            'modified_date' => $modnow,
                            'modified_by' => $curusr
                        );
                $this->db->where('g_id',$group_id);
                $this->db->update('group_master', $data);
                
                // redirect(base_url().'index.php/Dashboard');
                redirect(base_url().'index.php/dashboard/home');
                
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo 'You donot have access to this page.';
        }
    }
}
?>