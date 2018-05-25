<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Profile extends CI_Controller
{
    public function __construct() {
        parent::__construct();
       
        $this->load->helper('common_functions');
        $this->load->model('contact_model');
        $this->load->model('document_model');
    }

    public function index(){
        $cid=$this->session->userdata('session_id');
        $gu_id=$this->session->userdata('gu_id');
        $username=$this->session->userdata('username');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$cid'");
        $result=$query->result();
        $data['editcontact']=$result;

        // $data=$this->document_model->add_new_doc('d_cat_individual');

        $docs=$this->document_model->edit_view_doc('d_cat_individual', $cid, 'Contacts');
        $data=array_merge($data, $docs);

        $query=$this->db->query("SELECT A.nm_name, A.nm_relation, concat(ifnull(B.c_name,''), ' ', ifnull(B.c_last_name,''), ' - ', ifnull(B.c_emailid1,''), ' - ', ifnull(B.c_mobile1,''), ' - ', ifnull(B.c_company,'')) as c_name FROM contact_nominee_details A, contact_master B WHERE A.nm_cid='$cid' and A.nm_name = B.c_id");
        $result=$query->result();
        $data['editcontnom']=$result;

        $data['group_name']='';
        $query=$this->db->query("SELECT * FROM group_master WHERE g_id = '$gid'");
        $result=$query->result();
        $data['group_details']=$result;
        if(count($result)>0){
            if($username!=$result[0]->group_name){
                $data['group_name']=$result[0]->group_name;
            }
        }

        $data['c_id'] = $cid;

        if(count($data) > 0){
            load_view('contacts/your_profile', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updateRecord($cid){
        $roleid=$this->session->userdata('role_id');
		$curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');

        $now=date('Y-m-d H:i:s');
        $group_name = $this->input->post('group_name');
        // $maker_checker = $this->input->post('maker_checker');

        if($this->input->post('c_dob')!='') {
            $c_dob=FormatDate($this->input->post('c_dob'));
        } else {
            $c_dob=NULL;
        }

        // $data = array();
        // if($group_name==''){
        //     $group_name = $this->session->userdata('username');
        // }
        // $data = array(
        //             'group_name' => $group_name,
        //             'maker_checker' => $maker_checker,
        //             'modified_date' => $now,
        //             'modified_by' => $curusr
        //         );
        // $this->db->where('g_id',$gid);
        // $this->db->update('group_master', $data);

        $data = array();
        if ($this->input->post('c_last_name')!=""){
            $data = array(
                        'c_name' => $this->input->post('c_name'),
                        'c_middle_name' => $this->input->post('c_middle_name'),
                        'c_last_name' =>  $this->input->post('c_last_name'),
                        'c_dob' => $c_dob,
                        'c_mobile1' => $this->input->post('mobile_no1'),
                        'c_mobile2' => $this->input->post('mobile_no2'),
                        'c_emailid1' => $this->input->post('email_id1'),
                        'c_company' => $this->input->post('c_company'),
                        'c_pan_card' => $this->input->post('c_pan_card'),
                        'c_aadhar_card' => $this->input->post('c_aadhar_card'),
                        'c_address' => $this->input->post('c_address'),
                        // 'c_kyc_required' => $this->input->post('kyc'),
                        'c_gst_no' => $this->input->post('c_gst_no'),
                        'c_modifiedby' => $curusr,
                        'c_modifieddate' => $now
                    );
            $this->db->where('c_id', $cid);
            $this->db->update('contact_master',$data);
            $logarray['table_id']=$cid;
            $logarray['module_name']='Contact';
            $logarray['cnt_name']='contacts';
            $logarray['action']='Contact Record Modified';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            $file_nm='c_image_file';

            if(!empty($_FILES[$file_nm]['name'])) {
                $c_image_file = $_FILES[$file_nm]['name'];
                $c_image_file=str_replace('/', '_', $c_image_file);
                
                $filePath='uploads/client/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }
                $filePath='uploads/client/client_'.$cid.'/';
                $upload_path = './' . $filePath;
                if(!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $confi['upload_path']=$upload_path;
                $confi['allowed_types']='*';
                $this->load->library('upload', $confi);
                $extension="";

                if(!empty($_FILES[$file_nm]['name'])) {
                    if($this->upload->do_upload($file_nm)) {
                        echo "Uploaded <br>";
                    } else {
                        echo "Failed<br>";
                        echo $this->upload->data();
                    }   

                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];

                    $data = array(
                                'c_image' => $filePath.$fileName,
                                'c_image_name' => $fileName
                            );
                    $this->db->where('c_id', $cid);
                    $this->db->update('contact_master',$data);
                }
            }

            if($this->input->post('kyc')=="1") {
                $this->document_model->insert_doc($cid, 'Contacts');
            }

            $this->db->where('nm_cid', $cid);
            $this->db->delete('contact_nominee_details');

            $nominee=$this->input->post('nm_name[]');
            $relation=$this->input->post('nm_relation[]');

            for ($i=0; $i < count($nominee) ; $i++) { 
                $data = array(
                    'nm_cid' => $cid,
                    'nm_name' => $nominee[$i],
                    'nm_relation' => $relation[$i]
                );    

                $this->db->insert('contact_nominee_details',$data);
            }
        }

        $maker_checker_verified='';
        if($maker_checker=='yes'){
            $query=$this->db->query("SELECT * FROM group_master WHERE g_id = '$gid'");
            $result=$query->result();
            if(count($result)>0){
                $maker_checker_verified=$result[0]->maker_checker_verified;
            }
        }

        if($maker_checker=='yes' && $maker_checker_verified!='yes'){
            redirect(base_url().'index.php/dashboard');
        } else {
            redirect(base_url().'index.php/dashboard/home');
        }
    }
}
?>