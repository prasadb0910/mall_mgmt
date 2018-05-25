<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Expense_category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->database();
    }

    //index function
    public function index(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM expense_category_master where g_id='$gid' order by id desc");
                $result=$query->result();
                $data['expense_category']=$result;

                load_view('expense/expense_category_master', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
    
    public function saveRecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_insert = 1");
            $result=$query->result();
            if(count($result)>0) {
                $curusr=$this->session->userdata('session_id');
                $now=date('Y-m-d');
                $data = array(
                    'expense_category' => $this->input->post('expense_category'),
                    'g_id' => $gid,
                    'created_by' => $curusr,
                    'created_date' => $now
                );

                $this->db->insert('expense_category_master',$data);
                $logarray['table_id']=$this->db->insert_id();
                $logarray['module_name']='Expense Category';
                $logarray['cnt_name']='Expense_category';
                $logarray['action']='Expense Category Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Expense_category');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function deleteRecord($expense_category_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_delete = 1");
            $result=$query->result();
            if(count($result)>0) {
                $this->db->where('id',$expense_category_id);
                $this->db->delete('expense_category_master');
                $logarray['table_id']=$expense_category_id;
                $logarray['module_name']='Expense Category';
                $logarray['cnt_name']='Expense_category';
                $logarray['action']='Expense Category Record Deleted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Expense_category/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editRecord($expense_category_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM expense_category_master WHERE id='$expense_category_id'");
                $result=$query->result();
                $data['edit_expense_category']=$result;

                $query=$this->db->query("SELECT * FROM expense_category_master where g_id='$gid' order by id desc");
                $result=$query->result();
                $data['expense_category']=$result;

                $data['expense_category_id']=$expense_category_id;
                load_view('expense/expense_category_master', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function updateRecord($expense_category_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $curusr=$this->session->userdata('session_id');
                $now=date('Y-m-d');
                $data = array(
                    'expense_category' => $this->input->post('expense_category'),
                    'g_id' => $gid,
                    'modified_by' => $curusr,
                    'modified_date' => $now
                );
                
                $this->db->where('id',$expense_category_id);
                $this->db->update('expense_category_master',$data);
                $logarray['table_id']=$expense_category_id;
                $logarray['module_name']='Expense Category';
                $logarray['cnt_name']='Expense_category';
                $logarray['action']='Expense Category Record Modified';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Expense_category/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function checkExpenseCategoryAvailability() {
        $id = html_escape($this->input->post('expense_category_id'));
        $expense_category = html_escape($this->input->post('expense_category'));

        $query = $this->db->query("SELECT * FROM expense_category_master WHERE id != '$id' AND g_id='$gid' AND expense_category = '$expense_category'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }
    
}
?>