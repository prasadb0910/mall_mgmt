<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Reports extends CI_Controller
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
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $query=$this->db->query("SELECT * FROM report_master order by modified_date desc");
                $result=$query->result();
                $data['reports']=$result;

                $query=$this->db->query("SELECT * FROM group_master where group_status = 'Active'");
                $result=$query->result();
                $data['groups']=$result;

                load_view('reports/reports', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function view_reports() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $rlid=$this->session->userdata('role_id');

                // echo '<script>alert("' . $rlid . '");</script>';

                $query=$this->db->query("SELECT * FROM report_roles where role_id = '$rlid'");
                $result=$query->result();

                if (count($result)>0) {
                    for($i=0; $i<count($result); $i++) {
                        $data['rep_' . $result[$i]->rep_id] = $result[$i]->rep_view;
                    }
                }

                $gid=$this->session->userdata('groupid');
                // $query=$this->db->query("SELECT * FROM report_groups where rep_grp_id = '$gid'");
                $query=$this->db->query("SELECT * FROM report_groups where rep_grp_id = '41'");
                $result=$query->result();

                if (count($result)>0) {
                    for($i=0; $i<count($result); $i++) {
                        $data['rep_' . $result[$i]->rep_id . '_view'] = $result[$i]->rep_view;
                    }
                }

                // echo json_encode($data);

                $data['rep_grp_1']=0;
                $data['rep_grp_2']=0;
                $data['rep_grp_3']=0;
                // $data['rep_grp_4']=0;
                // $data['rep_grp_5']=0;
                // $data['rep_grp_6']=0;

                if (isset($data['rep_1'])) {if ($data['rep_1']==1) {if (isset($data['rep_1_view'])) {if ($data['rep_1_view']==1) $data['rep_grp_1']=1;}}}
                if (isset($data['rep_2'])) {if ($data['rep_2']==1) {if (isset($data['rep_2_view'])) {if ($data['rep_2_view']==1) $data['rep_grp_1']=1;}}}
                if (isset($data['rep_3'])) {if ($data['rep_3']==1) {if (isset($data['rep_3_view'])) {if ($data['rep_3_view']==1) $data['rep_grp_1']=1;}}}
                if (isset($data['rep_4'])) {if ($data['rep_4']==1) {if (isset($data['rep_4_view'])) {if ($data['rep_4_view']==1) $data['rep_grp_1']=1;}}}
                if (isset($data['rep_5'])) {if ($data['rep_5']==1) {if (isset($data['rep_5_view'])) {if ($data['rep_5_view']==1) $data['rep_grp_1']=1;}}}
                if (isset($data['rep_6'])) {if ($data['rep_6']==1) {if (isset($data['rep_6_view'])) {if ($data['rep_6_view']==1) $data['rep_grp_1']=1;}}}
                if (isset($data['rep_19'])) {if ($data['rep_19']==1) {if (isset($data['rep_19_view'])) {if ($data['rep_19_view']==1) $data['rep_grp_1']=1;}}}

                if (isset($data['rep_7'])) {if ($data['rep_7']==1) {if (isset($data['rep_7_view'])) {if ($data['rep_7_view']==1) $data['rep_grp_2']=1;}}}
                if (isset($data['rep_8'])) {if ($data['rep_8']==1) {if (isset($data['rep_8_view'])) {if ($data['rep_8_view']==1) $data['rep_grp_2']=1;}}}
                if (isset($data['rep_9'])) {if ($data['rep_9']==1) {if (isset($data['rep_9_view'])) {if ($data['rep_9_view']==1) $data['rep_grp_2']=1;}}}
                if (isset($data['rep_10'])) {if ($data['rep_10']==1) {if (isset($data['rep_10_view'])) {if ($data['rep_10_view']==1) $data['rep_grp_2']=1;}}}
                if (isset($data['rep_20'])) {if ($data['rep_20']==1) {if (isset($data['rep_20_view'])) {if ($data['rep_20_view']==1) $data['rep_grp_2']=1;}}}

                if (isset($data['rep_11'])) {if ($data['rep_11']==1) {if (isset($data['rep_11_view'])) {if ($data['rep_11_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_12'])) {if ($data['rep_12']==1) {if (isset($data['rep_12_view'])) {if ($data['rep_12_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_13'])) {if ($data['rep_13']==1) {if (isset($data['rep_13_view'])) {if ($data['rep_13_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_14'])) {if ($data['rep_14']==1) {if (isset($data['rep_14_view'])) {if ($data['rep_14_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_15'])) {if ($data['rep_15']==1) {if (isset($data['rep_15_view'])) {if ($data['rep_15_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_16'])) {if ($data['rep_16']==1) {if (isset($data['rep_16_view'])) {if ($data['rep_16_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_17'])) {if ($data['rep_17']==1) {if (isset($data['rep_17_view'])) {if ($data['rep_17_view']==1) $data['rep_grp_3']=1;}}}
                if (isset($data['rep_18'])) {if ($data['rep_18']==1) {if (isset($data['rep_18_view'])) {if ($data['rep_18_view']==1) $data['rep_grp_3']=1;}}}

                // if (isset($data['rep_17'])) {if ($data['rep_17']==1) {if (isset($data['rep_17_view'])) {if ($data['rep_17_view']==1) $data['rep_grp_4']=1;}}}
                // if (isset($data['rep_18'])) {if ($data['rep_18']==1) {if (isset($data['rep_18_view'])) {if ($data['rep_18_view']==1) $data['rep_grp_4']=1;}}}
                // if (isset($data['rep_19'])) {if ($data['rep_19']==1) {if (isset($data['rep_19_view'])) {if ($data['rep_19_view']==1) $data['rep_grp_4']=1;}}}
                // if (isset($data['rep_20'])) {if ($data['rep_20']==1) {if (isset($data['rep_20_view'])) {if ($data['rep_20_view']==1) $data['rep_grp_4']=1;}}}

                // if (isset($data['rep_21'])) {if ($data['rep_21']==1) {if (isset($data['rep_21_view'])) {if ($data['rep_21_view']==1) $data['rep_grp_5']=1;}}}
                // if (isset($data['rep_22'])) {if ($data['rep_22']==1) {if (isset($data['rep_22_view'])) {if ($data['rep_22_view']==1) $data['rep_grp_5']=1;}}}
                // if (isset($data['rep_23'])) {if ($data['rep_23']==1) {if (isset($data['rep_23_view'])) {if ($data['rep_23_view']==1) $data['rep_grp_5']=1;}}}
                // if (isset($data['rep_24'])) {if ($data['rep_24']==1) {if (isset($data['rep_24_view'])) {if ($data['rep_24_view']==1) $data['rep_grp_5']=1;}}}
                // if (isset($data['rep_25'])) {if ($data['rep_25']==1) {if (isset($data['rep_25_view'])) {if ($data['rep_25_view']==1) $data['rep_grp_5']=1;}}}

                // if (isset($data['rep_26'])) {if ($data['rep_26']==1) {if (isset($data['rep_26_view'])) {if ($data['rep_26_view']==1) $data['rep_grp_6']=1;}}}
                // if (isset($data['rep_27'])) {if ($data['rep_27']==1) {if (isset($data['rep_27_view'])) {if ($data['rep_27_view']==1) $data['rep_grp_6']=1;}}}
                // if (isset($data['rep_28'])) {if ($data['rep_28']==1) {if (isset($data['rep_28_view'])) {if ($data['rep_28_view']==1) $data['rep_grp_6']=1;}}}
                // if (isset($data['rep_29'])) {if ($data['rep_29']==1) {if (isset($data['rep_29_view'])) {if ($data['rep_29_view']==1) $data['rep_grp_6']=1;}}}
                // if (isset($data['rep_30'])) {if ($data['rep_30']==1) {if (isset($data['rep_30_view'])) {if ($data['rep_30_view']==1) $data['rep_grp_6']=1;}}}

                $data['rep_grp_1']=0;
                $data['rep_grp_2']=0;
                $data['rep_grp_3']=0;
                // $data['rep_grp_4']=0;
                // $data['rep_grp_5']=0;
                // $data['rep_grp_6']=0;

                if (isset($data['rep_1_view'])) {if ($data['rep_1_view']==1) $data['rep_grp_1']=1;}
                if (isset($data['rep_2_view'])) {if ($data['rep_2_view']==1) $data['rep_grp_1']=1;}
                if (isset($data['rep_3_view'])) {if ($data['rep_3_view']==1) $data['rep_grp_1']=1;}
                if (isset($data['rep_4_view'])) {if ($data['rep_4_view']==1) $data['rep_grp_1']=1;}
                if (isset($data['rep_5_view'])) {if ($data['rep_5_view']==1) $data['rep_grp_1']=1;}
                if (isset($data['rep_6_view'])) {if ($data['rep_6_view']==1) $data['rep_grp_1']=1;}
                if (isset($data['rep_19_view'])) {if ($data['rep_19_view']==1) $data['rep_grp_1']=1;}

                if (isset($data['rep_7_view'])) {if ($data['rep_7_view']==1) $data['rep_grp_2']=1;}
                if (isset($data['rep_8_view'])) {if ($data['rep_8_view']==1) $data['rep_grp_2']=1;}
                if (isset($data['rep_9_view'])) {if ($data['rep_9_view']==1) $data['rep_grp_2']=1;}
                if (isset($data['rep_10_view'])) {if ($data['rep_10_view']==1) $data['rep_grp_2']=1;}
                if (isset($data['rep_20_view'])) {if ($data['rep_20_view']==1) $data['rep_grp_2']=1;}

                if (isset($data['rep_11_view'])) {if ($data['rep_11_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_12_view'])) {if ($data['rep_12_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_13_view'])) {if ($data['rep_13_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_14_view'])) {if ($data['rep_14_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_15_view'])) {if ($data['rep_15_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_16_view'])) {if ($data['rep_16_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_17_view'])) {if ($data['rep_17_view']==1) $data['rep_grp_3']=1;}
                if (isset($data['rep_18_view'])) {if ($data['rep_18_view']==1) $data['rep_grp_3']=1;}

                // if (isset($data['rep_17_view'])) {if ($data['rep_17_view']==1) $data['rep_grp_4']=1;}
                // if (isset($data['rep_18_view'])) {if ($data['rep_18_view']==1) $data['rep_grp_4']=1;}
                // if (isset($data['rep_19_view'])) {if ($data['rep_19_view']==1) $data['rep_grp_4']=1;}
                // if (isset($data['rep_20_view'])) {if ($data['rep_20_view']==1) $data['rep_grp_4']=1;}

                // if (isset($data['rep_21_view'])) {if ($data['rep_21_view']==1) $data['rep_grp_5']=1;}
                // if (isset($data['rep_22_view'])) {if ($data['rep_22_view']==1) $data['rep_grp_5']=1;}
                // if (isset($data['rep_23_view'])) {if ($data['rep_23_view']==1) $data['rep_grp_5']=1;}
                // if (isset($data['rep_24_view'])) {if ($data['rep_24_view']==1) $data['rep_grp_5']=1;}
                // if (isset($data['rep_25_view'])) {if ($data['rep_25_view']==1) $data['rep_grp_5']=1;}

                // if (isset($data['rep_26_view'])) {if ($data['rep_26_view']==1) $data['rep_grp_6']=1;}
                // if (isset($data['rep_27_view'])) {if ($data['rep_27_view']==1) $data['rep_grp_6']=1;}
                // if (isset($data['rep_28_view'])) {if ($data['rep_28_view']==1) $data['rep_grp_6']=1;}
                // if (isset($data['rep_29_view'])) {if ($data['rep_29_view']==1) $data['rep_grp_6']=1;}
                // if (isset($data['rep_30_view'])) {if ($data['rep_30_view']==1) $data['rep_grp_6']=1;}

                load_view('reports/view_reports', $data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function download_report() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                load_view_without_data('reports/download_report');
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_report_groups($rep_id) {
        $query=$this->db->query("SELECT * FROM report_groups where rep_id = '$rep_id'");
        $result=$query->result();

        $group_details=null;
        $i=0;

        foreach ($result as $row) {
            $group_details[$i] = array("rep_grp_id"=> $row->rep_grp_id, "rep_view"=> $row->rep_view);
            $i=$i+1;
        }

        echo json_encode($group_details);
    }

    public function get_report_roles($rep_id) {
        $query=$this->db->query("SELECT * FROM report_master where rep_id = '$rep_id'");
        $result=$query->result();
        if (count($result)>0) {
            $all_roles = $result[0]->all_roles;
        } else {
            $all_roles = null;
        }
        
        echo $all_roles;
    }

    public function update_report_groups($rep_id){
        // echo "<script>alert('Hiiii');</script>";

        $group=$this->input->post('group[]');
        $roles=$this->input->post('roles');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $curusr=$this->session->userdata('session_id');


        $this->db->query("update report_master set all_roles = '$roles', modified_by='$curusr', modified_date='$modnow' WHERE rep_id = '$rep_id'");
        
        $this->db->query("update report_groups set rep_view = '0' WHERE rep_id = '$rep_id' and rep_grp_id != '0'");

        for ($i=0; $i < count($group) ; $i++) {
            // echo "<script>console.log('" . count($group) . "');</script>";

            $grp_id=$group[$i];

            $query=$this->db->query("SELECT * FROM report_groups WHERE rep_id = '$rep_id' and rep_grp_id = '$grp_id'");
            $result=$query->result();
            if (count($result)>0) {
                $this->db->query("update report_groups set rep_view = '1', modified_by='$curusr', modified_date='$modnow' WHERE rep_id = '$rep_id' and rep_grp_id = '$grp_id'");
            } else {
                $this->db->query("insert into report_groups (rep_id, rep_grp_id, rep_view, created_by, created_date) values ('$rep_id','$grp_id','1','$curusr','$now')");
            }
        }

        if ($roles==0) {
            $this->db->query("update report_roles set rep_view = '0', modified_by='$curusr', modified_date='$modnow' WHERE rep_id = '$rep_id'");
        } else {
            $query=$this->db->query("SELECT * FROM user_role_master");
            $result=$query->result();
            if (count($result)>0) {
                for ($i=0; $i < count($result) ; $i++) {
                    $rl_id=$result[$i]->rl_id;
                    $query=$this->db->query("SELECT * FROM report_roles WHERE rep_id = '$rep_id' and role_id = '$rl_id'");
                    $result2=$query->result();
                    if (count($result2)>0) {
                        $this->db->query("update report_roles set rep_view = '1', modified_by='$curusr', modified_date='$modnow' WHERE rep_id = '$rep_id' and role_id = '$rl_id'");
                    } else {
                        $this->db->query("insert into report_roles (rep_id, role_id, rep_view, created_by, created_date) values ('$rep_id','$rl_id','1','$curusr','$now')");
                    }
                }
            }
        }

        echo 1;
    }

}
?>