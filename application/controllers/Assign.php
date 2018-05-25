<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Assign extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->model('group_model');
        $this->load->database();
    }

    public function index(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM user_role_options");
                $result=$query->result();
                if(count($result)>0) {
                    $result[0]->r_export=1;
                    $data['access']=$result;
                }
                
                $sql = "SELECT D.*, concat_ws(' ',E.c_name,E.c_last_name) as created_by From 
                        (SELECT A.gu_id, A.gu_cid, concat_ws(' ',C.c_name,C.c_last_name) as gu_name, 
                                B.role_name, A.assigned_status, A.created_by 
                        FROM group_users A, user_role_master B, contact_master C 
                        WHERE A.gu_gid='" . $gid . "' and A.assigned_role=B.rl_id and A.gu_cid=C.c_id and 
                        A.assigned_status is not NULL ORDER BY A.updated_at desc) D 
                        LEFT JOIN 
                        ((SELECT '0' as c_id, 'Software' as c_name, 'Developer' as c_last_name FROM contact_master limit 1) 
                         union all 
                         (SELECT c_id, c_name, c_last_name FROM contact_master)) E 
                        on D.created_by = E.c_id";

                $query=$this->db->query($sql);
                $result=$query->result();
                $data['user']=$result;

                // $query=$this->db->query("SELECT * FROM group_users WHERE txn_status ='Approved'");
                // $result=$query->result();
                // $data['approved']=$result;

                // $query=$this->db->query("SELECT * FROM group_users WHERE txn_status ='Pending'");
                // $result=$query->result();
                // $data['pending']=$result;

                // $query=$this->db->query("SELECT * FROM group_users WHERE txn_status ='Rejected'");
                // $result=$query->result();
                // $data['rejected']=$result;

                // $query=$this->db->query("SELECT * FROM group_users WHERE txn_status ='In Process'");
                // $result=$query->result();
                // $data['inprocess']=$result;

                load_view('management/user_assign_list', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function adminuser(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM user_role_options");
                $result=$query->result();
                if(count($result)>0) {
                    $result[0]->r_export=1;
                    $data['access']=$result;
                }
                
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid='" . $gid . "' ORDER BY c_modifieddate desc");
                $result=$query->result();
                $data['user']=$result;

                load_view('management/admin_user_assign_list', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function addadminuser(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                load_view_without_data('management/admin_user_assign_details');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkUserEmailAvailability(){
        $gid=$this->session->userdata('groupid');
        $gu_cid=$this->input->post('gu_cid');
        $gu_email=$this->input->post('gu_email');

        // $gu_cid="";
        // $gu_email="info@pecanreams.com";

        $query=$this->db->query("SELECT * FROM group_users WHERE gu_cid!='".$gu_cid."' and gu_gid='".$gid."' and gu_email='".$gu_email."'");
        $result=$query->result();

        if (count($result)>0){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function checkAdminEmailAvailability(){
        $gid=$this->session->userdata('groupid');
        $gu_cid=$this->input->post('gu_cid');
        $gu_email=$this->input->post('gu_email');

        // $gu_cid="";
        // $gu_email="info@pecanreams.com";

        $query=$this->db->query("SELECT * FROM group_users WHERE gu_cid!='".$gu_cid."' and (gu_gid='".$gid."' || assigned_role='1') and gu_email='".$gu_email."'");
        $result=$query->result();

        if (count($result)>0){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function saveadminuser(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $now=date('Y-m-d H:i:s');
                $curusr=$this->session->userdata('session_id');
                
                $data = array(
                    'c_name' => $this->input->post('con_first_name'),
                    'c_middle_name' => $this->input->post('con_middle_name'),
                    'c_last_name' =>  $this->input->post('con_last_name'),
                    'c_emailid1' => $this->input->post('con_email_id1'),
                    'c_mobile1' => $this->input->post('con_mobile_no1'),
                    'c_status' => 'Approved',
                    'c_gid' => $gid,
                    'c_createdby' => $curusr,
                    'c_createdate' => $now,
                    'c_modifiedby' => $curusr,
                    'c_modifieddate' => $now,
                );

                $this->db->insert('contact_master',$data);
                $cid=$this->db->insert_id();

                $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                $email=$this->input->post('con_email_id1');

                $query = $this->db->query("select * from group_users where gu_email = '" . $email . "' and gu_gid = '" . $gid . "'");
                if ($query->num_rows()==0) {
                    $data = array(
                        // 'gu_name' => $this->input->post('con_first_name'),
                        'gu_email' => $this->input->post('con_email_id1'),
                        // 'gu_mobile' => $this->input->post('con_mobile_no1'),
                        'gu_role' => 'User',
                        'gu_cid' => $cid,
                        'gu_gid' => $gid,
                        'assigned_status' => 'Active',
                        'gu_password' => $password,
                        'add_date' => $now,
                        'created_by' => $curusr,
                        'created_at' => $now,
                        'updated_by' => $curusr,
                        'updated_at' => $now,
                        'name' => $this->input->post('con_first_name'),
                    );  

                    $this->db->insert('group_users', $data);

                    $logarray['table_id']=$cid;
                    $logarray['module_name']='Users';
                    $logarray['cnt_name']='Users';
                    $logarray['action']='Software Developer User Created';
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                    
                    // $this->send_password();
                }

                redirect(base_url().'index.php/Assign/adminuser');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function send_password() {
        $f_name = $this->input->post('con_first_name');
        $to_email = $this->input->post('con_email_id1');
        $password = 'Pass@123';

        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Login credentials for property management';
        $message = '<html><head></head><body>Hi '. $f_name .',<br /><br /> Login credentials are as follows<br /><br />' .
                    'User Name: ' . $to_email . '<br />' .
                    'Password: ' . $password .
                    '<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    }

    public function viewadminuser($cid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='" . $cid . "'");
                $result=$query->result();
                $data['user']=$result;
                
                load_view('management/admin_user_view', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editadminuser($cid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='" . $cid . "'");
                $result=$query->result();
                $data['user']=$result;
                
                load_view('management/admin_user_assign_details', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateadminuser($cid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $now=date('Y-m-d H:i:s');
                $curusr=$this->session->userdata('session_id');
                
                $data = array(
                    'c_name' => $this->input->post('con_first_name'),
                    'c_middle_name' => $this->input->post('con_middle_name'),
                    'c_last_name' =>  $this->input->post('con_last_name'),
                    'c_emailid1' => $this->input->post('con_email_id1'),
                    'c_mobile1' => $this->input->post('con_mobile_no1'),
                    'c_status' => $this->input->post('con_status'),
                    'txn_remarks' => $this->input->post('con_txn_remarks'),
                    'c_modifiedby' => $curusr,
                    'c_modifieddate' => $now,
                );

                $this->db->where('c_id',$cid);
                $this->db->update('contact_master',$data);

                if ($this->input->post('con_status')=="Approved") {
                    $assigned_status = 'Active';
                } else {
                    $assigned_status = 'Inactive';
                }

                $data = array(
                    // 'gu_name' => $this->input->post('con_first_name'),
                    'gu_email' => $this->input->post('con_email_id1'),
                    // 'gu_mobile' => $this->input->post('con_mobile_no1'),
                    'assigned_status' => $assigned_status,
                    'gu_cid' => $cid,
                    'updated_by' => $curusr,
                    'updated_at' => $now,
                    'name' => $this->input->post('con_first_name'),
                );  

                $this->db->where('gu_cid',$cid);
                $this->db->where('gu_gid',$gid);
                $this->db->update('group_users', $data);

                $logarray['table_id']=$cid;
                $logarray['module_name']='Users';
                $logarray['cnt_name']='Users';
                $logarray['action']='Software Developer User Modified';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                
                redirect(base_url().'index.php/Assign/adminuser');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function loadcontacts() {
        // $term = "s";
                
        if (isset($_GET['term'])){
            $term = html_escape($_GET['term']);
        }
        
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM contact_master where (c_status='Approved' or c_status='In Process') and c_gid='$gid' and concat(ifnull(c_name,''),' ',ifnull(c_last_name,''),' - ',ifnull(c_emailid1,''),' - ',ifnull(c_mobile1,'')) like '%" . $term . "%' and c_emailid1 not in (select distinct gu_email from group_users where (gu_gid = '$gid' and assigned_role = '1') and gu_email IS NOT NULL);");
        // $query=$this->db->query("SELECT * FROM contact_master where (c_status='Approved' or c_status='In Process') and c_gid='$gid' and concat(c_name,' ',c_last_name,' - ',c_emailid1,' - ',c_mobile1) like '%" . $term . "%';");
        $result=$query->result();
        
        $abc=array();
        foreach($result as $row) {
            $abc[] = array('value' => $row->c_id , 'label' => $row->c_name . ' ' . $row->c_last_name . ' - ' . $row->c_emailid1 . ' - ' . $row->c_mobile1 , 'gender' => $row->c_gender , 'designation' => $row->c_designation, 'email1' => $row->c_emailid1, 'email2' => $row->c_emailid2, 'mobile1' => $row->c_mobile1, 'mobile2' => $row->c_mobile2 );
        }
        
        // echo $this->db->last_query();
        echo json_encode($abc);
    }
    
    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM user_role_master WHERE g_id='$gid' OR g_id='0'");
                $result=$query->result();
                $data['roles']=$result;

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid='$gid'");
                $result=$query->result();
                $data['owner']=NULL;

                for ($i=0; $i < count($result) ; $i++) { 
                   if($result[$i]->ow_type==0) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $cid=$result[$i]->ow_ind_id;
                        $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                        $res1=$quer->result();
                        $data['owner'][$i]['name']=$res1[0]->c_name;
                    } else if($result[$i]->ow_type==1) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_huf_name;
                    } else if($result[$i]->ow_type==2) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_pvtltd_comapny_name;
                    } else if($result[$i]->ow_type==3) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_ltd_comapny_name;
                    } else if($result[$i]->ow_type==4) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_llp_comapny_name;
                    } else if($result[$i]->ow_type==5) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_prt_comapny_name;
                    } else if($result[$i]->ow_type==6) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_aop_comapny_name;
                    } else if($result[$i]->ow_type==7) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_trs_comapny_name;
                    } else if($result[$i]->ow_type==8) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_proprietorship_comapny_name;
                    }
                }

                $query=$this->db->query("SELECT * FROM group_master WHERE g_id = '$gid'");
                $result=$query->result();
                $data['group_details']=$result;
                
                load_view('management/user_assign_details', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $g_name=$this->session->userdata('groupname');
                $modnow=date('Y-m-d H:i:s');
                $curusr=$this->session->userdata('session_id');
                $cid=$this->input->post('contact');
                $assigned_status=$this->input->post('assigned_status');
                $txn_remarks=$this->input->post('txn_remarks');
                $assure=$this->input->post('assure');
                $rlid= $this->input->post('role');

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='" . $cid . "'");
                $result=$query->result();
                if(count($result)>0) {
                    $c_name=$result[0]->c_name;
                    $c_designation=$result[0]->c_designation;
                    $c_emailid1=$result[0]->c_emailid1;
                    $c_mobile1=$result[0]->c_mobile1;
                } else {
                    $c_name='';
                    $c_designation='';
                    $c_emailid1='';
                    $c_mobile1='';
                }

                $query=$this->db->query("SELECT * FROM user_role_master WHERE rl_id='" . $rlid . "'");
                $result=$query->result();
                if(count($result)>0) {
                    $role_name=$result[0]->role_name;
                } else {
                    $role_name='';
                }
                $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                // $password=md5('Pass@123');

                $data = array(
                    'gu_gid' => $gid,
                    'gu_cid' => $cid,
                    // 'gu_name' => $c_name,
                    // 'gu_designation' => $c_designation,
                    'gu_email' => $c_emailid1,
                    // 'gu_mobile' => $c_mobile1,
                    'assigned_status' => $assigned_status,
                    'txn_remarks' => $txn_remarks,
                    'gu_role' => $role_name,
                    'assigned_role' => $rlid,
                    'created_by' => $curusr,
                    'created_at' => $modnow,
                    'updated_by' => $curusr,
                    'updated_at' => $modnow,
                    'gu_password' => $password,
                    'maker_remark'=>$this->input->post('maker_remark'),
                    'name' => $c_name,
                    'assure'=>$this->input->post('assure')
                );
                
                $this->db->insert('group_users', $data);
                $uid=$this->db->insert_id();

                // if($c_emailid1!='' && $assure=='1'){
                //     $sql = "select * from group_users where gu_email = '$c_emailid1'";
                //     $this->db2 = $this->load->database('assure', true);
                //     $query = $this->db2->query($sql);
                //     $data = $query->result();
                //     if(count($data)==0){
                //         $sql = "insert into group_users(name,gu_email,gu_mobile,gu_password,assigned_role,isVerified) 
                //                 values ('".$c_name."','".$c_emailid1."','".$c_mobile1."','".$password."','2','0') ";
                //         $this->db2->query($sql);

                //         $sql = "insert into users(name,email,mobile,password,isVerified) 
                //                 values ('".$c_name."','".$c_emailid1."','".$c_mobile1."','".$password."','0') ";
                //         $this->db2->query($sql);
                //     }
                // }
                

                $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                $this->group_model->send_assign_group_email($g_name, $c_emailid1, $password, $role_name);

                $this->db->where('user_id', $uid);
                $this->db->delete('user_role_owners');

                $own=$this->input->post('owners[]');

                for ($i=0; $i < count($own); $i++) {
                    $data = array(
                                'user_id' => $uid,
                                'role_id' => $rlid,
                                'owner_id' => $own[$i],
                            );
                    $this->db->insert('user_role_owners', $data);
                }
                $logarray['table_id']=$cid;
                $logarray['module_name']='Users';
                $logarray['cnt_name']='Users';
                $logarray['action']='User Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                
                redirect(base_url().'index.php/Assign');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editrecord($uid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $modnow=date('Y-m-d H:i:s');
                $curusr=$this->session->userdata('session_id');
                $cid=$this->input->post('contact');
                $assigned_status=$this->input->post('assigned_status');
                $txn_remarks=$this->input->post('txn_remarks');
                $rlid= $this->input->post('role');
                $assure=$this->input->post('assure');

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='" . $cid . "'");
                $result=$query->result();
                if(count($result)>0) {
                    $c_name=$result[0]->c_name;
                    $c_designation=$result[0]->c_designation;
                    $c_emailid1=$result[0]->c_emailid1;
                    $c_mobile1=$result[0]->c_mobile1;
                } else {
                    $c_name='';
                    $c_designation='';
                    $c_emailid1='';
                    $c_mobile1='';
                }

                $query=$this->db->query("SELECT * FROM user_role_master WHERE rl_id='" . $rlid . "'");
                $result=$query->result();
                if(count($result)>0) {
                    $role_name=$result[0]->role_name;
                } else {
                    $role_name='';
                }

                $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));
                $data = array(
                    'gu_cid' => $cid,
                    // 'gu_name' => $c_name,
                    // 'gu_designation' => $c_designation,
                    'gu_email' => $c_emailid1,
                    // 'gu_mobile' => $c_mobile1,
                    'assigned_status' => $assigned_status,
                    'txn_remarks' => $txn_remarks,
                    'gu_role' => $role_name,
                    'assigned_role' => $rlid,
                    'updated_by' => $curusr,
                    'updated_at' => $modnow,
                    'gu_password' => $password,
                    'maker_remark' => $this->input->post('maker_remark'),
                    'name' => $c_name,
                    'assure'=>$this->input->post('assure')
                );
                
                $this->db->where('gu_id', $uid);
                $this->db->update('group_users', $data);

                $this->db->where('user_id', $uid);
                $this->db->delete('user_role_owners');

                $own=$this->input->post('owners[]');

                for ($i=0; $i < count($own); $i++) {
                    $data = array(
                                'user_id' => $uid,
                                'role_id' => $rlid,
                                'owner_id' => $own[$i],
                            );
                    $this->db->insert('user_role_owners', $data);
                }

                // if($c_emailid1!='' && $assure=='1'){
                //     $sql = "select * from group_users where gu_email = '$c_emailid1'";
                //     $this->db2 = $this->load->database('assure', true);
                //     $query = $this->db2->query($sql);
                //     $data = $query->result();
                //     if(count($data)==0){
                //         $sql = "insert into group_users(name,gu_email,gu_mobile,gu_password,assigned_role,isVerified) 
                //                 values ('".$c_name."','".$c_emailid1."','".$c_mobile1."','".$password."','2','0') ";
                //         $this->db2->query($sql);

                //         $sql = "insert into users(name,email,mobile,password,isVerified) 
                //                 values ('".$c_name."','".$c_emailid1."','".$c_mobile1."','".$password."','0') ";
                //         $this->db2->query($sql);
                //     }
                // }
                
                $logarray['table_id']=$cid;
                $logarray['module_name']='Users';
                $logarray['cnt_name']='Users';
                $logarray['action']='User Updated';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Assign');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updatepassword($uid){
        $gid=$this->session->userdata('groupid');
        $modnow=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');

        $password=password_hash('Pass@123', PASSWORD_BCRYPT, array('cost' => 10));

        $data = array(
            'assigned_status' => 'Active',
            'gu_password' => $password,
            'updated_by' => $curusr,
            'updated_at' => $modnow
        );
        $this->db->where('gu_id', $uid);
        $this->db->update('group_users', $data);

        $query=$this->db->query("SELECT A.*, concat_ws(' ',B.c_name,B.c_last_name) as gu_name FROM group_users A, contact_master B WHERE A.gu_id='$uid' and A.gu_cid=B.c_id");
        $result=$query->result();
        if (count($result)>0) {
            $cid = $result[0]->gu_cid;
            $f_name = $result[0]->gu_name;
            $to_email = $result[0]->gu_email;
            $password = 'Pass@123';

            $from_email = 'info@pecanreams.com';
            $from_email_sender = 'Pecan REAMS';
            $subject = 'Password changed for property management';
            $message = '<html><head></head><body>Hi '. $f_name .',<br /><br /> Password changed. New login credentials are as follows, <br /><br />' .
                        'User Name: ' . $to_email . '<br />' .
                        'Password: ' . $password .
                        '<br /><br />Thanks</body></html>';
            $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
            $logarray['table_id']=$cid;
            $logarray['module_name']='Users';
            $logarray['cnt_name']='Users';
            $logarray['action']='User Password Resetted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);
        }
        
        echo 1;
    }

    public function view($uid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT A.gu_id, A.gu_cid, concat_ws(' ',C.c_name,C.c_last_name) as gu_name , A.gu_email, A.assigned_status, 
                                        A.assigned_role, B.role_name, A.txn_remarks,A.maker_remark, A.assure FROM group_users A ,user_role_master B, contact_master C 
                                        where A.gu_id='" . $uid . "' and A.assigned_role=B.rl_id and A.gu_cid=C.c_id");
                $result=$query->result();
                $data['assignusr']=$result;

                $query=$this->db->query("SELECT A.owner_id, case when B.ow_type = '0' 
                                                then (select concat(ifnull(c_name,''), '') as c_name from contact_master where c_id = B.ow_ind_id) 
                                                when B.ow_type = '1' then B.ow_huf_name when B.ow_type = '2' 
                                                then B.ow_pvtltd_comapny_name when B.ow_type = '3' 
                                                then B.ow_ltd_comapny_name when B.ow_type = '4' then B.ow_llp_comapny_name 
                                                when B.ow_type = '5' then B.ow_prt_comapny_name when B.ow_type = '6' 
                                                then B.ow_aop_comapny_name  when B.ow_type = '7' 
                                                then B.ow_trs_comapny_name else B.ow_proprietorship_comapny_name end as owner_name 
                                        FROM user_role_owners A, owner_master B where A.user_id = '" . $uid . "' and A.owner_id=B.ow_id");
                $result=$query->result();

                $result2=null;
                $data['owner_name']="";

                for($i=0; $i<count($result);$i++) {
                    $result2[$i] = $result[$i]->owner_id;
                    $data['owner_name']=$data['owner_name'] . $result[$i]->owner_name . ",";
                }

                $data['user_role_owners']=$result2;
                
                $query=$this->db->query("SELECT * FROM user_role_master");
                $result=$query->result();
                $data['roles']=$result;

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid='$gid'");
                $result=$query->result();
                $data['owner']=NULL;
                for ($i=0; $i < count($result) ; $i++) { 
                   if($result[$i]->ow_type==0) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $cid=$result[$i]->ow_ind_id;
                        $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                        $res1=$quer->result();
                        $data['owner'][$i]['name']=$res1[0]->c_name;
                    } else if($result[$i]->ow_type==1) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_huf_name;
                    } else if($result[$i]->ow_type==2) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_pvtltd_comapny_name;
                    } else if($result[$i]->ow_type==3) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_ltd_comapny_name;
                    } else if($result[$i]->ow_type==4) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_llp_comapny_name;
                    } else if($result[$i]->ow_type==5) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_prt_comapny_name;
                    } else if($result[$i]->ow_type==6) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_aop_comapny_name;
                    } else if($result[$i]->ow_type==7) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_trs_comapny_name;
                    } else if($result[$i]->ow_type==8) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_proprietorship_comapny_name;
                    }
                }
                
                $query=$this->db->query("SELECT * FROM group_master WHERE g_id = '$gid'");
                $result=$query->result();
                $data['group_details']=$result;
                
                load_view('management/user_assign_view', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($uid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'User' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $gid=$this->session->userdata('groupid');
                $query=$this->db->query("SELECT A.gu_id, A.gu_cid, concat_ws(' ',C.c_name,C.c_last_name) as gu_name , A.gu_email, A.assigned_status, 
                                        A.assigned_role, B.role_name, A.txn_remarks, A.maker_remark, A.assure FROM group_users A ,user_role_master B, contact_master C 
                                        where A.gu_id='" . $uid . "' and A.assigned_role=B.rl_id and A.gu_cid=C.c_id");
                $result=$query->result();
                $data['assignusr']=$result;

                $query=$this->db->query("SELECT owner_id FROM user_role_owners where user_id = '" . $uid . "'");
                $result=$query->result();

                $result2=null;

                for($i=0; $i<count($result);$i++) {
                    $result2[$i] = $result[$i]->owner_id;
                }

                $data['user_role_owners']=$result2;

                $query=$this->db->query("SELECT * FROM user_role_master WHERE g_id='$gid' OR g_id='0'");
                $result=$query->result();
                $data['roles']=$result;

                $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid='$gid'");
                $result=$query->result();
                $data['owner']=NULL;
                for ($i=0; $i < count($result) ; $i++) { 
                   if($result[$i]->ow_type==0) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $cid=$result[$i]->ow_ind_id;
                        $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                        $res1=$quer->result();
                        $data['owner'][$i]['name']=$res1[0]->c_name;
                    } else if($result[$i]->ow_type==1) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_huf_name;
                    } else if($result[$i]->ow_type==2) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_pvtltd_comapny_name;
                    } else if($result[$i]->ow_type==3) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_ltd_comapny_name;
                    } else if($result[$i]->ow_type==4) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_llp_comapny_name;
                    } else if($result[$i]->ow_type==5) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_prt_comapny_name;
                    } else if($result[$i]->ow_type==6) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_aop_comapny_name;
                    } else if($result[$i]->ow_type==7) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_trs_comapny_name;
                    } else if($result[$i]->ow_type==8) {
                        $data['owner'][$i]['id']=$result[$i]->ow_id;
                        $data['owner'][$i]['name']=$result[$i]->ow_proprietorship_comapny_name;
                    }
                }

                $query=$this->db->query("SELECT * FROM group_master WHERE g_id = '$gid'");
                $result=$query->result();
                $data['group_details']=$result;
                
                load_view('management/user_assign_details', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
}
?>