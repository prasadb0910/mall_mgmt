<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Nrp_Unit_Type extends CI_Controller
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
                $query=$this->db->query("SELECT * FROM nrp_unit_type_master where g_id='$gid' order by id desc");
                $result=$query->result();
                $data['unit_type']=$result;

                load_view('Non_real_estate_unit_type/unit_type', $data);
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
                    'unit_type' => $this->input->post('unit_type'),
                    'g_id' => $gid,
                    'created_by' => $curusr,
                    'created_date' => $now
                );

                if($this->input->post('unit_type')!="")
                $this->db->insert('nrp_unit_type_master',$data);
                $logarray['table_id']=$this->db->insert_id();
                $logarray['module_name']='Expense Category';
                $logarray['cnt_name']='Expense_category';
                $logarray['action']='Expense Category Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
              redirect(base_url().'index.php/Nrp_unit_type/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function deleteRecord($unit_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_delete = 1");
            $result=$query->result();
            if(count($result)>0) {
                $this->db->where('id',$unit_type_id);
                $this->db->delete('nrp_unit_type_master');
                $logarray['table_id']=$unit_type_id;
                $logarray['module_name']='Expense Category';
                $logarray['cnt_name']='Expense_category';
                $logarray['action']='Expense Category Record Deleted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
                redirect(base_url().'index.php/Nrp_unit_type/index');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editRecord($unit_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM nrp_unit_type_master WHERE id='$unit_type_id'");
                $result=$query->result();
                $data['edit_unit_type']=$result;

                $query=$this->db->query("SELECT * FROM nrp_unit_type_master where g_id='$gid' order by id desc");
                $result=$query->result();
                $data['unit_type']=$result;

                $data['unit_type_id']=$unit_type_id;
              load_view('Non_real_estate_unit_type/unit_type', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

     public function updateRecord($unit_type_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND r_edit = 1");
            $result=$query->result();
            if(count($result)>0) {
                $curusr=$this->session->userdata('session_id');
                $now=date('Y-m-d');
                $data = array(
                    'unit_type' => $this->input->post('unit_type'),
                    'g_id' => $gid,
                    'modified_by' => $curusr,
                    'modified_date' => $now
                );
                
                $this->db->where('id',$unit_type_id);
                $this->db->update('nrp_unit_type_master',$data);
                $logarray['table_id']=$unit_type_id;
                $logarray['module_name']='Expense Category';
                $logarray['cnt_name']='Expense_category';
                $logarray['action']='Expense Category Record Modified';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);
               redirect(base_url().'index.php/Nrp_unit_type/index');
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
        $id = html_escape($this->input->post('unit_type_id'));
        $unit_type = html_escape($this->input->post('unit_type'));

        $query = $this->db->query("SELECT * FROM nrp_unit_type_master WHERE id != '$id' AND g_id='$gid' AND unit_type = '$unit_type'");
        if($query->num_rows()!=0){
            echo 1;
        } else {
            echo 0;
        }
    }
    
}
?>