<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Contacts extends CI_Controller
{
    public function __construct() {
        parent::__construct();
       
        $this->load->helper('common_functions');
        $this->load->model('contact_model');
        $this->load->model('document_model');
        $this->load->model('City_master_model','city_model');
    }

    public function index(){
        // $roleid=$this->session->userdata('role_id');
        // //echo '<script>alert('.$roleid.')</script>';
        // $data=$this->contact_model->getContactDetails($roleid);
        // if(count($data) > 0){
        //     load_view('contacts/contact_list', $data);
        // } else {
        //     echo '<script>alert("You donot have access to this page.");</script>';
        //     $this->load->view('login/main_page');
        // }

        $this->checkstatus('All', 'All');
    }
    
    public function addnew($contact_type='', $owner_type=''){
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $gid=$this->session->userdata('groupid');

            if($owner_type=='individual'){
                $data=$this->document_model->add_new_doc('d_cat_individual');
            } else if($owner_type=='huf'){
                $data=$this->document_model->add_new_doc('d_cat_huf');
            } else if($owner_type=='pvtltd'){
                $data=$this->document_model->add_new_doc('d_cat_privateltd');
            } else if($owner_type=='ltd'){
                $data=$this->document_model->add_new_doc('d_cat_limited');
            } else if($owner_type=='llp'){
                $data=$this->document_model->add_new_doc('d_cat_lpp');
            } else if($owner_type=='partnership'){
                $data=$this->document_model->add_new_doc('d_cat_partnership');
            } else if($owner_type=='aop'){
                $data=$this->document_model->add_new_doc('d_cat_aop');
            } else if($owner_type=='trust'){
                $data=$this->document_model->add_new_doc('d_cat_trust');
            } else if($owner_type=='proprietorship'){
                $data=$this->document_model->add_new_doc('d_cat_proprietorship');
            }
            
            $sql = "select * from 
                    (select c_id, concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as contact_name from contact_master 
                    where c_status='Approved' and c_gid='$gid' and c_owner_type='individual') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['owner']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');
            $data['contact_type'] = $contact_type;
            $data['owner_type'] = $owner_type;
            $data['city'] = $this->city_model->get_city();

            // echo json_encode($data);

            if($owner_type=='individual'){
                load_view('contacts/contact_details', $data);
            } else {
                load_view('contacts/owner_details', $data);
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            if($this->input->post('date_of_birth')!='') {
                $dob=FormatDate($this->input->post('date_of_birth'));
            } else {
                $dob=NULL;
            }
            if($this->input->post('date_of_anniversary')!='') {
                $doe=FormatDate($this->input->post('date_of_anniversary'));
            } else {
                $doe=NULL;
            }
            if($this->input->post('incop_date')!='') {
                $incop_date=FormatDate($this->input->post('incop_date'));
            } else {
                $incop_date=NULL;
            }

            if($this->input->post('submit')=='Submit For Approval') {
                $c_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $c_status='Approved';
            } else {
                $c_status='In Process';
            }
            // if($this->input->post('type')=='Others'){
            //     $c_last_name = $this->input->post('owner_type');
            // } else {
            //     $c_last_name = $this->input->post('c_last_name');
            // }
            $c_last_name = $this->input->post('c_last_name');

            if ($this->input->post('c_name')!="" || $this->input->post('company_name')!=""){
                $data = array(
                    'c_name' => $this->input->post('c_name'),
                    // 'c_company' => $this->input->post('company'),
                    'c_middle_name' => $this->input->post('c_middle_name'),
                    'c_last_name' =>  $c_last_name,
                    'c_dob' => $dob ,
                    'c_anniversarydate' => $doe,
                    'c_gender' => $this->input->post('gender'),
                    'c_designation' => $this->input->post('designation'),
                    // 'c_guardian' => $this->input->post('guardian'),
                    // 'c_relation' => $this->input->post('guardian_relation'),
                    'c_address' => $this->input->post('address'),
                    'c_landmark' => $this->input->post('landmark'),
                    'c_city' => $this->input->post('city'),
                    'c_pincode' => $this->input->post('pincode'),
                    'c_state' => $this->input->post('state'),
                    'c_country' => $this->input->post('country'),
                    'c_emailid1' => $this->input->post('email_id1'),
                    'c_emailid2' => $this->input->post('email_id2'),
                    'c_mobile1' => $this->input->post('mobile_no1'),
                    'c_mobile2' => $this->input->post('mobile_no2'),
                    'c_type' => $this->input->post('type'),
                    'c_kyc_required' => $this->input->post('kyc'),
                    // 'c_contact_type' => (is_numeric($this->input->post('contact_type'))?$this->input->post('contact_type'):null),
                    // 'c_pan_card' => $this->input->post('pan_card'),
                    'c_status' => $c_status,
                    'c_gid' => $gid,
                    'c_createdate' => $now,
    				'c_createdby' => $curusr,
                    'c_modifieddate' => $now,
                    'c_modifiedby' => $curusr,
                    'c_maker_remark' => $this->input->post('maker_remark'),
                    'c_owner_type' => $this->input->post('owner_type'),
                    'c_company_name' => $this->input->post('company_name'),
                    'c_reg_no' => $this->input->post('reg_no'),
                    'c_incop_date' => $incop_date,
                    'c_contact_id' => $this->input->post('contact_id'),
                    'c_branch' => $this->input->post('branch_address'),
                    'c_telephone' => $this->input->post('telephone_number'),
                    'c_mobile' => $this->input->post('mob_number'),
                    'c_invoice_format' => $this->input->post('invoice_format'),
                    'c_invoice_no' => (($this->input->post('invoice_no')=='')? null : $this->input->post('invoice_no')),
                    'c_gst_no' => $this->input->post('gst_no')
                );

                $this->db->insert('contact_master',$data);
                $cid=$this->db->insert_id();
                $logarray['table_id']=$cid;
                $logarray['module_name']='Contact';
                $logarray['cnt_name']='contacts';
                $logarray['action']='Contact Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                if($this->input->post('kyc')=="1" || $this->input->post('owner_type')!='individual') {
                    $this->document_model->insert_doc($cid, 'Contacts');
                }

                $nominee=$this->input->post('nm_name[]');
                $relation=$this->input->post('nm_relation[]');
                for ($i=0; $i < count($nominee) ; $i++) { 
                    if($nominee[$i]!=''){
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $nominee[$i],
                            'type' => 'nominee',
                            'relation' => $relation[$i]
                        );    

                        $this->db->insert('contact_other_details',$data);
                    }
                }
            
                $family=$this->input->post('family[]');
                $relation=$this->input->post('relation[]');
                for ($i=0; $i <  count($family); $i++) {
                    if($family[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $family[$i],
                            'type' => 'family',
                            'relation' => $relation[$i]
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $director=$this->input->post('director[]');
                for ($i=0; $i <  count($director); $i++) {
                    if($director[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $director[$i],
                            'type' => 'director'
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $shareholder=$this->input->post('shareholder[]');
                $shareholder_percent=$this->input->post('shareholder_percent[]');
                $no_of_shares=$this->input->post('no_of_shares[]');
                for ($i=0; $i <  count($shareholder); $i++) {
                    if($shareholder[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $shareholder[$i],
                            'type' => 'shareholder',
                            'percent' => $shareholder_percent[$i]==''?null:$shareholder_percent[$i],
                            'no_of_shares' => $no_of_shares[$i]==''?null:$no_of_shares[$i]
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $partnership=$this->input->post('partnership[]');
                $partnership_percent=$this->input->post('partnership_percent[]');
                for ($i=0; $i <  count($partnership); $i++) {
                    if($partnership[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $partnership[$i],
                            'type' => 'partnership',
                            'percent' => $partnership_percent[$i]==''?null:$partnership_percent[$i]
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $trustee=$this->input->post('trustee[]');
                for ($i=0; $i <  count($trustee); $i++) {
                    if($trustee[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $trustee[$i],
                            'type' => 'trustee'
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $beneficiary=$this->input->post('beneficiary[]');
                $beneficiary_percent=$this->input->post('beneficiary_percent[]');
                for ($i=0; $i <  count($beneficiary); $i++) {
                    if($beneficiary[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $beneficiary[$i],
                            'type' => 'beneficiary',
                            'percent' => $beneficiary_percent[$i]==''?null:$beneficiary_percent[$i]
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $owner=$this->input->post('owner[]');
                for ($i=0; $i <  count($owner); $i++) {
                    if($owner[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $owner[$i],
                            'type' => 'owner'
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $authsignatory=$this->input->post('authsignatory[]');
                $purpose=$this->input->post('purpose[]');
                for ($i=0; $i <  count($authsignatory); $i++) {
                    if($authsignatory[$i]!="") {
                        $data = array(
                            'ref_id' => $cid,
                            'c_id' => $authsignatory[$i],
                            'type' => 'authsignatory',
                            'purpose' => $purpose[$i]
                        );

                        $this->db->insert('contact_other_details', $data);
                    }
                }

                $file_nm='image';
                if(isset($_FILES[$file_nm])) {
                    $filePath='uploads/Contacts/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $filePath='uploads/Contacts/Contacts_'.$cid.'/';
                    $upload_path = './' . $filePath;
                    if(!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                    }

                    $confi['upload_path']=$upload_path;
                    $confi['allowed_types']='*';
                    $this->load->library('upload', $confi);
                    $this->upload->initialize($confi);
                    $extension="";

                    if(!empty($_FILES[$file_nm]['name'])) {
                        if($this->upload->do_upload($file_nm)) {
                            $upload_data=$this->upload->data();
                            $fileName=$upload_data['file_name'];
                            $extension=$upload_data['file_ext'];
                                
                            $data = array(
                                'c_image' => $filePath.$fileName,
                                'c_image_name' => $fileName
                            );
                            $this->db->where('c_id', $cid);
                            $this->db->update('contact_master',$data);

                            // echo "Uploaded <br>";

                        } else {
                            // echo "Failed<br>";
                            // echo $this->upload->data();
                        }
                    }
                }
            }

            redirect(base_url().'index.php/Contacts');
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function viewrecord($cid) {
		$roleid=$this->session->userdata('role_id');
        $gid=$this->session->userdata('groupid');

		$query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $data['access']=$result;
			}
		}
		
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' and r_view=1");
        $result=$query->result();
        if(count($result)>0) {
			$data['contactby']=$this->session->userdata('session_id');

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$cid'");
            $result=$query->result();
            $data['editcontact']=$result;
            if(count($result)>0){
                $owner_type=$result[0]->c_owner_type;
                $contact_type=$result[0]->c_type;
                if($owner_type=='individual'){
                    $contact_id=$result[0]->c_id;
                } else {
                    $contact_id=$result[0]->c_contact_id;
                }
            } else {
                $owner_type='';
                $contact_type='';
                $contact_id='';
            }

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$contact_id'");
            $result=$query->result();
            $data['contact_details']=$result;

            $docs=array();
            if($owner_type=='individual'){
                $docs=$this->document_model->view_doc('d_cat_individual', $cid, 'Contacts');
            } else if($owner_type=='huf'){
                $docs=$this->document_model->view_doc('d_cat_huf', $cid, 'Contacts');
            } else if($owner_type=='pvtltd'){
                $docs=$this->document_model->view_doc('d_cat_privateltd', $cid, 'Contacts');
            } else if($owner_type=='ltd'){
                $docs=$this->document_model->view_doc('d_cat_limited', $cid, 'Contacts');
            } else if($owner_type=='llp'){
                $docs=$this->document_model->view_doc('d_cat_lpp', $cid, 'Contacts');
            } else if($owner_type=='partnership'){
                $docs=$this->document_model->view_doc('d_cat_partnership', $cid, 'Contacts');
            } else if($owner_type=='aop'){
                $docs=$this->document_model->view_doc('d_cat_aop', $cid, 'Contacts');
            } else if($owner_type=='trust'){
                $docs=$this->document_model->view_doc('d_cat_trust', $cid, 'Contacts');
            } else if($owner_type=='proprietorship'){
                $docs=$this->document_model->view_doc('d_cat_proprietorship', $cid, 'Contacts');
            }
            $data=array_merge($data, $docs);

            $query=$this->db->query("SELECT A.*, B.c_name, B.c_last_name, B.c_company_name, B.c_owner_type 
                                    FROM contact_other_details A left join contact_master B 
                                    on (A.c_id=B.c_id) WHERE A.ref_id='$cid' and A.type='nominee'");
            $result=$query->result();
            $data['editcontnom']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='family'");
            $result=$query->result();
            $data['editcontfam']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='director'");
            $result=$query->result();
            $data['editcontdir']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='shareholder'");
            $result=$query->result();
            $data['editcontshr']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='partnership'");
            $result=$query->result();
            $data['editcontprt']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='trustee'");
            $result=$query->result();
            $data['editconttrs']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='beneficiary'");
            $result=$query->result();
            $data['editcontben']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='owner'");
            $result=$query->result();
            $data['editcontown']=$result;

            $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='authsignatory'");
            $result=$query->result();
            $data['editcontauth']=$result;

            $query=$this->db->query("select A.property_id, B.unit_name as p_property_name from 
                                    (select distinct property_txn_id as property_id from property_txn where txn_status='Approved' and 
                                        gp_id='$gid' and property_txn_id in (select distinct ref_id from related_party_details 
                                            where contact_id='$cid' and type='purchase') 
                                    union all 
                                    select distinct property_id from sales_txn where txn_status='Approved' and gp_id='$gid' and 
                                    txn_id in (select distinct ref_id from related_party_details 
                                        where contact_id='$cid' and type='sale')
                                    union all 
                                    select distinct property_id from rent_txn where txn_status='Approved' and gp_id='$gid' and 
                                    txn_id in (select distinct ref_id from related_party_details 
                                        where contact_id='$cid' and type='rent')) A 
                                    left join 
                                    (select * from property_txn where txn_status='Approved' and gp_id='$gid') B 
                                    on A.property_id = B.property_txn_id");
            $result=$query->result();
            $data['related_properties']=$result;

            $sql = "select * from 
                    (select c_id, concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as contact_name from contact_master 
                    where c_status='Approved' and c_gid='$gid' and c_owner_type='individual' and c_id!='$cid' and (c_fkid!='$cid' or c_fkid is null)) A 
                    order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid' and A.c_id!='$cid' and (A.c_fkid!='$cid' or A.c_fkid is null)) A 
                    order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['owner']=$result;

            $data['c_id']=$cid;

            $data['maker_checker'] = $this->session->userdata('maker_checker');
            $data['contact_type'] = $contact_type;
            $data['owner_type'] = $owner_type;

            if($owner_type=='individual'){
                load_view('contacts/contact_view', $data);
            } else {
                load_view('contacts/owner_view', $data);
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function editrecord($cid) {
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $gid=$this->session->userdata('groupid');
                $data['access']=$result;
                
                // $query=$this->db->query("SELECT * FROM contact_master WHERE c_gid = '$gid' order by c_id desc");
                // $result=$query->result();
                // $data['contacts']=$result;
                
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_fkid = '$cid'");
                $result=$query->result();
                if (count($result)>0){
                    $cid = $result[0]->c_id;
                }

                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id='$cid'");
                $result=$query->result();
                $data['editcontact']=$result;
                if(count($result)>0){
                    $owner_type=$result[0]->c_owner_type;
                    $contact_type=$result[0]->c_type;
                } else {
                    $owner_type='';
                    $contact_type='';
                }

                $docs=array();
                if($owner_type=='individual'){
                    $docs=$this->document_model->edit_view_doc('d_cat_individual', $cid, 'Contacts');
                } else if($owner_type=='huf'){
                    $docs=$this->document_model->edit_view_doc('d_cat_huf', $cid, 'Contacts');
                } else if($owner_type=='pvtltd'){
                    $docs=$this->document_model->edit_view_doc('d_cat_privateltd', $cid, 'Contacts');
                } else if($owner_type=='ltd'){
                    $docs=$this->document_model->edit_view_doc('d_cat_limited', $cid, 'Contacts');
                } else if($owner_type=='llp'){
                    $docs=$this->document_model->edit_view_doc('d_cat_lpp', $cid, 'Contacts');
                } else if($owner_type=='partnership'){
                    $docs=$this->document_model->edit_view_doc('d_cat_partnership', $cid, 'Contacts');
                } else if($owner_type=='aop'){
                    $docs=$this->document_model->edit_view_doc('d_cat_aop', $cid, 'Contacts');
                } else if($owner_type=='trust'){
                    $docs=$this->document_model->edit_view_doc('d_cat_trust', $cid, 'Contacts');
                } else if($owner_type=='proprietorship'){
                    $docs=$this->document_model->edit_view_doc('d_cat_proprietorship', $cid, 'Contacts');
                }
                $data=array_merge($data, $docs);

                $query=$this->db->query("SELECT A.*, B.c_name, B.c_last_name, B.c_company_name, B.c_owner_type 
                                        FROM contact_other_details A left join contact_master B 
                                        on (A.c_id=B.c_id) WHERE A.ref_id='$cid' and A.type='nominee'");
                $result=$query->result();
                $data['editcontnom']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='family'");
                $result=$query->result();
                $data['editcontfam']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='director'");
                $result=$query->result();
                $data['editcontdir']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='shareholder'");
                $result=$query->result();
                $data['editcontshr']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='partnership'");
                $result=$query->result();
                $data['editcontprt']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='trustee'");
                $result=$query->result();
                $data['editconttrs']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='beneficiary'");
                $result=$query->result();
                $data['editcontben']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='owner'");
                $result=$query->result();
                $data['editcontown']=$result;

                $query=$this->db->query("SELECT * FROM contact_other_details WHERE ref_id='$cid' and type='authsignatory'");
                $result=$query->result();
                $data['editcontauth']=$result;

                // $query=$this->db->query("SELECT * FROM contact_type_master WHERE g_id = '$gid' order by contact_type");
                // $result=$query->result();
                // $data['contact_type']=$result;

                $sql = "select * from 
                        (select c_id, concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as contact_name from contact_master 
                        where c_status='Approved' and c_gid='$gid' and c_owner_type='individual' and c_id!='$cid' and (c_fkid!='$cid' or c_fkid is null)) A 
                        order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_id!='$cid' and (A.c_fkid!='$cid' or A.c_fkid is null)) A 
                        order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['owner']=$result;

                $data['c_id']=$cid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');
                $data['contact_type'] = $contact_type;
                $data['owner_type'] = $owner_type;
                $data['city'] = $this->city_model->get_city();

                if($owner_type=='individual'){
                    load_view('contacts/contact_details', $data);
                } else {
                    load_view('contacts/owner_details', $data);
                }
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($cid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approverecord($cid);
        } else  {
            $this->updaterecord($cid);
        }
    }

    public function updaterecord($cid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($this->input->post('submit')=='Delete') {
                $c_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $c_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $c_status='Approved';
            } else  {
                $c_status='In Process';
            }

            if($c_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->c_status;
                        $c_fkid = $res[0]->c_fkid;
                        $c_gid = $res[0]->c_gid;
                    } else {
                        $rec_status = '';
                        $c_fkid = '';
                        $c_gid = null;
                    }

                    if ($rec_status=="Approved") {
                        $txn_remarks = $this->input->post('status_remarks');

                        if($maker_checker!='yes'){
                            $c_status = 'Inactive';

                            $this->db->query("update contact_master set c_status='$c_status', c_txn_remarks='$txn_remarks', c_modifiedby='$curusr', 
                                            c_modifieddate='$modnow' WHERE c_id = '$cid'");

                            $logarray['table_id']=$cid;
                            $logarray['module_name']='Contact';
                            $logarray['cnt_name']='contacts';
                            $logarray['action']='Contact Record ' . $c_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM contact_master WHERE c_fkid = '$cid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $cid = $result[0]->c_id;

                                $this->db->query("Update contact_master set c_status='$c_status', c_txn_remarks='$txn_remarks', 
                                                 c_modifieddate='$modnow', c_modifiedby='$curusr' 
                                                 WHERE c_id = '$cid'");
                                $logarray['table_id']=$cid;
                                $logarray['module_name']='Contact';
                                $logarray['cnt_name']='contacts';
                                $logarray['action']='Contact Record Delete approved';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into contact_master (c_name, c_company, c_gid, c_dob, c_anniversarydate, c_gender, c_designation, 
                                                 c_guardian, c_relation, c_address, c_landmark, c_state, c_city, c_country, c_pincode, c_emailid1, c_emailid2, 
                                                 c_mobile1, c_mobile2, c_kyc_required, c_createdate, c_status, c_middle_name, c_last_name, c_type, c_createdby, 
                                                 c_modifieddate, c_modifiedby, c_approveddate, c_approvedby, c_txn_remarks, c_fkid, c_rejectedby, c_rejecteddate,
                                                 c_contact_type, c_pan_card, c_aadhar_card, c_maker_remark, c_image, c_image_name, c_gst_no, c_contact_id, 
                                                 c_company_name, c_reg_no, c_incop_date, c_branch, c_telephone, c_mobile, c_owner_type, c_invoice_format, c_invoice_no)  
                                                 Select c_name, c_company, c_gid, c_dob, c_anniversarydate, c_gender, c_designation, 
                                                 c_guardian, c_relation, c_address, c_landmark, c_state, c_city, c_country, c_pincode, c_emailid1, c_emailid2, 
                                                 c_mobile1, c_mobile2, c_kyc_required, c_createdate, '$c_status', c_middle_name, c_last_name, c_type, c_createdby, 
                                                 '$modnow', '$curusr', c_approveddate, c_approvedby, '$txn_remarks', '$cid', c_rejectedby, c_rejecteddate,
                                                 c_contact_type, c_pan_card, c_aadhar_card, c_maker_remark, c_image, c_image_name, c_gst_no, c_contact_id, 
                                                 c_company_name, c_reg_no, c_incop_date, c_branch, c_telephone, c_mobile, c_owner_type, c_invoice_format, c_invoice_no 
                                                 FROM contact_master WHERE c_id = '$cid'");
                                $new_cid=$this->db->insert_id();

                                // $this->db->query("Insert into contact_kyc_details (kyc_cid, kyc_doc_type, kyc_doc_name, kyc_doc_desc, kyc_doc_ref, 
                                //                  kyc_issuedate, kyc_expirydate, kyc_document, kyc_document_name)  
                                //                  Select '$new_cid', kyc_doc_type, kyc_doc_name, kyc_doc_desc, kyc_doc_ref, 
                                //                  kyc_issuedate, kyc_expirydate, kyc_document, kyc_document_name 
                                //                  FROM contact_kyc_details WHERE kyc_cid = '$cid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_cid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$cid' and doc_ref_type = 'Contacts'");


                                $this->db->query("Insert into contact_other_details (ref_id, c_id, type, relation, percent, no_of_shares, purpose) 
                                                 Select '$new_cid', c_id, type, relation, percent, no_of_shares, purpose 
                                                 FROM contact_other_details WHERE ref_id = '$cid'");

                                $logarray['table_id']=$cid;
                                $logarray['module_name']='Contact';
                                $logarray['cnt_name']='contacts';
                                $logarray['action']='Contact Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            }
                        }
                    } else {
                        $this->db->where('c_id', $cid);
                        $this->db->delete('contact_master');

                        // $this->db->where('kyc_cid', $cid);
                        // $this->db->delete('contact_kyc_details');

                        $this->db->where('doc_ref_id', $cid);
                        $this->db->where('doc_ref_type', 'Contacts');
                        $this->db->delete('document_details');

                        $this->db->where('ref_id', $cid);
                        $this->db->delete('contact_other_details');

                        $logarray['table_id']=$cid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->where('gu_cid', $cid);
                        // $this->db->delete('group_users');
                    }

                    redirect(base_url().'index.php/Contacts');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->c_status;
                        $c_fkid = $res[0]->c_fkid;
                        $c_gid = $res[0]->c_gid;
                        $c_createdby = $res[0]->c_createdby;
                        $c_createdate = $res[0]->c_createdate;
                    } else {
                        $rec_status = '';
                        $c_fkid = '';
                        $c_gid = null;
                        $c_createdby = $curusr;
                        $c_createdate = $now;
                    }

                    if($this->input->post('date_of_birth')!='') {
                        $dob=FormatDate($this->input->post('date_of_birth'));
                    } else {
                        $dob=NULL;
                    }
                    if($this->input->post('date_of_anniversary')!='') {
                        $doe=FormatDate($this->input->post('date_of_anniversary'));
                    } else {
                        $doe=NULL;
                    }
                    if($this->input->post('incop_date')!='') {
                        $incop_date=FormatDate($this->input->post('incop_date'));
                    } else {
                        $incop_date=NULL;
                    }
                    // if($this->input->post('type')=='Others'){
                    //     $c_last_name = $this->input->post('owner_type');
                    // } else {
                    //     $c_last_name = $this->input->post('c_last_name');
                    // }
                    $c_last_name = $this->input->post('c_last_name');

                    if ($this->input->post('c_name')!="" || $this->input->post('company_name')!=""){
                        $data = array(
                            'c_name' => $this->input->post('c_name'),
                            // 'c_company' => $this->input->post('company'),
                            'c_middle_name' => $this->input->post('c_middle_name'),
                            'c_last_name' =>  $c_last_name,
                            'c_dob' => $dob ,
                            'c_anniversarydate' => $doe,
                            'c_gender' => $this->input->post('gender'),
                            'c_designation' => $this->input->post('designation'),
                            // 'c_guardian' => $this->input->post('guardian'),
                            // 'c_relation' => $this->input->post('guardian_relation'),
                            'c_address' => $this->input->post('address'),
                            'c_landmark' => $this->input->post('landmark'),
                            'c_city' => $this->input->post('city'),
                            'c_pincode' => $this->input->post('pincode'),
                            'c_state' => $this->input->post('state'),
                            'c_country' => $this->input->post('country'),
                            'c_emailid1' => $this->input->post('email_id1'),
                            'c_emailid2' => $this->input->post('email_id2'),
                            'c_mobile1' => $this->input->post('mobile_no1'),
                            'c_mobile2' => $this->input->post('mobile_no2'),
                            'c_type' => $this->input->post('type'),
                            'c_kyc_required' => $this->input->post('kyc'),
                            // 'c_contact_type' => (is_numeric($this->input->post('contact_type'))?$this->input->post('contact_type'):null),
                            // 'c_pan_card' => $this->input->post('pan_card'),
                            'c_status' => $c_status,
                            'c_gid' => $gid,
                            'c_createdate' => $now,
                            'c_createdby' => $curusr,
                            'c_modifieddate' => $now,
                            'c_modifiedby' => $curusr,
                            'c_maker_remark' => $this->input->post('maker_remark'),
                            'c_owner_type' => $this->input->post('owner_type'),
                            'c_company_name' => $this->input->post('company_name'),
                            'c_reg_no' => $this->input->post('reg_no'),
                            'c_incop_date' => $incop_date,
                            'c_contact_id' => $this->input->post('contact_id'),
                            'c_branch' => $this->input->post('branch_address'),
                            'c_telephone' => $this->input->post('telephone_number'),
                            'c_mobile' => $this->input->post('mob_number'),
                            'c_invoice_format' => $this->input->post('invoice_format'),
                            'c_invoice_no' => (($this->input->post('invoice_no')=='')? null : $this->input->post('invoice_no')),
                            'c_gst_no' => $this->input->post('gst_no')
                        );

                        if ($rec_status=="Approved" && $maker_checker=='yes') {
                            $c_fkid = $cid;
                            $data['c_fkid'] = $cid;

                            $this->db->insert('contact_master',$data);
                            $cid=$this->db->insert_id();
                            $logarray['table_id']=$c_fkid;
                            $logarray['module_name']='Contact';
                            $logarray['cnt_name']='contacts';
                            $logarray['action']='Contact Approved Record Modified';
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            // if ($c_status=='Delete') {
                            //     $this->db->where('c_id', $cid);
                            //     $this->db->delete('contact_master');

                            //     $this->db->where('gu_cid', $cid);
                            //     $this->db->delete('group_users');
                            // } else {
                                
                                $this->db->where('c_id', $cid);
                                $this->db->update('contact_master',$data);
                                $logarray['table_id']=$cid;
                                $logarray['module_name']='Contact';
                                $logarray['cnt_name']='contacts';
                                $logarray['action']='Contact Record Modified';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            // }
                        }

                        if($this->input->post('kyc')=="1" || $this->input->post('owner_type')!='individual') {
                            $this->document_model->insert_doc($cid, 'Contacts');
                        }

                        if ($rec_status!="Approved" || $maker_checker!='yes') {
                            // $this->db->where('ref_id', $cid);
                            // $this->db->delete('contact_nominee_details');

                            $this->db->where('ref_id', $cid);
                            $this->db->delete('contact_other_details');
                        }

                        if ($c_status!="Delete" || $rec_status=="Approved" || $maker_checker!='yes') {
                            $nominee=$this->input->post('nm_name[]');
                            $relation=$this->input->post('nm_relation[]');
                            for ($i=0; $i < count($nominee) ; $i++) { 
                                if($nominee[$i]!=''){
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $nominee[$i],
                                        'type' => 'nominee',
                                        'relation' => $relation[$i]
                                    );    

                                    $this->db->insert('contact_other_details',$data);
                                }
                            }
                        
                            $family=$this->input->post('family[]');
                            $relation=$this->input->post('relation[]');
                            for ($i=0; $i <  count($family); $i++) {
                                if($family[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $family[$i],
                                        'type' => 'family',
                                        'relation' => $relation[$i]
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $director=$this->input->post('director[]');
                            for ($i=0; $i <  count($director); $i++) {
                                if($director[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $director[$i],
                                        'type' => 'director'
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $shareholder=$this->input->post('shareholder[]');
                            $shareholder_percent=$this->input->post('shareholder_percent[]');
                            $no_of_shares=$this->input->post('no_of_shares[]');
                            for ($i=0; $i <  count($shareholder); $i++) {
                                if($shareholder[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $shareholder[$i],
                                        'type' => 'shareholder',
                                        'percent' => $shareholder_percent[$i]==''?null:$shareholder_percent[$i],
                                        'no_of_shares' => $no_of_shares[$i]==''?null:$no_of_shares[$i]
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $partnership=$this->input->post('partnership[]');
                            $partnership_percent=$this->input->post('partnership_percent[]');
                            for ($i=0; $i <  count($partnership); $i++) {
                                if($partnership[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $partnership[$i],
                                        'type' => 'partnership',
                                        'percent' => $partnership_percent[$i]==''?null:$partnership_percent[$i]
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $trustee=$this->input->post('trustee[]');
                            for ($i=0; $i <  count($trustee); $i++) {
                                if($trustee[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $trustee[$i],
                                        'type' => 'trustee'
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $beneficiary=$this->input->post('beneficiary[]');
                            $beneficiary_percent=$this->input->post('beneficiary_percent[]');
                            for ($i=0; $i <  count($beneficiary); $i++) {
                                if($beneficiary[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $beneficiary[$i],
                                        'type' => 'beneficiary',
                                        'percent' => $beneficiary_percent[$i]==''?null:$beneficiary_percent[$i]
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $owner=$this->input->post('owner[]');
                            for ($i=0; $i <  count($owner); $i++) {
                                if($owner[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $owner[$i],
                                        'type' => 'owner'
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $authsignatory=$this->input->post('authsignatory[]');
                            $purpose=$this->input->post('purpose[]');
                            for ($i=0; $i <  count($authsignatory); $i++) {
                                if($authsignatory[$i]!="") {
                                    $data = array(
                                        'ref_id' => $cid,
                                        'c_id' => $authsignatory[$i],
                                        'type' => 'authsignatory',
                                        'purpose' => $purpose[$i]
                                    );

                                    $this->db->insert('contact_other_details', $data);
                                }
                            }

                            $file_nm='image';
                            if(isset($_FILES[$file_nm])) {
                                $filePath='uploads/Contacts/';
                                $upload_path = './' . $filePath;
                                if(!is_dir($upload_path)) {
                                    mkdir($upload_path, 0777, TRUE);
                                }

                                $filePath='uploads/Contacts/Contacts_'.$cid.'/';
                                $upload_path = './' . $filePath;
                                if(!is_dir($upload_path)) {
                                    mkdir($upload_path, 0777, TRUE);
                                }

                                $confi['upload_path']=$upload_path;
                                $confi['allowed_types']='*';
                                $this->load->library('upload', $confi);
                                $this->upload->initialize($confi);
                                $extension="";

                                if(!empty($_FILES[$file_nm]['name'])) {
                                    if($this->upload->do_upload($file_nm)) {
                                        $upload_data=$this->upload->data();
                                        $fileName=$upload_data['file_name'];
                                        $extension=$upload_data['file_ext'];
                                            
                                        $data = array(
                                            'c_image' => $filePath.$fileName,
                                            'c_image_name' => $fileName
                                        );
                                        $this->db->where('c_id', $cid);
                                        $this->db->update('contact_master',$data);

                                        // echo "Uploaded <br>";

                                    } else {
                                        // echo "Failed<br>";
                                        // echo $this->upload->data();
                                    }
                                }
                            }
                        }
                    }
                    
                    redirect(base_url().'index.php/Contacts');
                } else {
                    echo "Unauthorized access.";
                }
            }
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approverecord($cid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->c_status;
                    $c_fkid = $res[0]->c_fkid;
                    $c_gid = $res[0]->c_gid;
                } else {
                    $rec_status = '';
                    $c_fkid = '';
                    $c_gid = null;
                }

                if($this->input->post('submit')=='Approve') {
                    $c_status='Approved';
                } else  {
                    $c_status='Rejected';
                }
                $txn_remarks = $this->input->post('status_remarks');

                if ($c_status=='Rejected') {
                    $this->db->query("update contact_master set c_status='Rejected', c_txn_remarks='$txn_remarks', c_rejectedby='$curusr', c_rejecteddate='$modnow' WHERE c_id = '$cid'");
                    // $this->db->query("update group_users set assigned_status='Rejected', rejected_by='$curusr', rejected_date='$modnow' WHERE gu_cid = '$cid'");

                    $logarray['table_id']=$cid;
                    $logarray['module_name']='Contact';
                    $logarray['cnt_name']='contacts';
                    $logarray['action']='Contact Record ' . $c_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($c_fkid=='' || $c_fkid==null) {
                        $this->db->query("update contact_master set c_status='Approved',c_txn_remarks='$txn_remarks', c_approvedby='$curusr', c_approveddate='$modnow' WHERE c_id = '$cid'");
                        // $this->db->query("update group_users set assigned_status='Approved', approved_by='$curusr', approved_date='$modnow' WHERE gu_cid = '$cid'");

                        $logarray['table_id']=$cid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Record ' . $c_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $c_status='Inactive';
                        }
                        $this->db->query("update contact_master A, contact_master B set A.c_name=B.c_name, 
                                         A.c_company=B.c_company, A.c_gid=B.c_gid, A.c_dob=B.c_dob, 
                                         A.c_anniversarydate=B.c_anniversarydate, A.c_gender=B.c_gender, 
                                         A.c_designation=B.c_designation, A.c_guardian=B.c_guardian, A.c_relation=B.c_relation, 
                                         A.c_address=B.c_address, A.c_landmark=B.c_landmark, A.c_state=B.c_state, 
                                         A.c_city=B.c_city, A.c_country=B.c_country, A.c_pincode=B.c_pincode, 
                                         A.c_emailid1=B.c_emailid1, A.c_emailid2=B.c_emailid2, A.c_mobile1=B.c_mobile1, 
                                         A.c_mobile2=B.c_mobile2, A.c_kyc_required=B.c_kyc_required, 
                                         A.c_createdate=B.c_createdate, A.c_status='$c_status', A.c_middle_name=B.c_middle_name, 
                                         A.c_last_name=B.c_last_name, A.c_type=B.c_type, A.c_createdby=B.c_createdby, 
                                         A.c_modifieddate=B.c_modifieddate, A.c_modifiedby=B.c_modifiedby, 
                                         A.c_approveddate='$modnow', A.c_approvedby='$curusr', 
                                         A.c_txn_remarks='$txn_remarks', A.c_maker_remark=B.c_maker_remark, A.c_contact_type=B.c_contact_type, 
                                         A.c_pan_card=B.c_pan_card, A.c_aadhar_card=B.c_aadhar_card, A.c_image=B.c_image, 
                                         A.c_image_name=B.c_image_name, A.c_gst_no=B.c_gst_no, A.c_contact_id=B.c_contact_id, 
                                         A.c_company_name=B.c_company_name, A.c_reg_no=B.c_reg_no, A.c_incop_date=B.c_incop_date, 
                                         A.c_branch=B.c_branch, A.c_telephone=B.c_telephone, A.c_mobile=B.c_mobile, A.c_owner_type=B.c_owner_type, 
                                         A.c_invoice_format=B.c_invoice_format, A.c_invoice_no=B.c_invoice_no, A.c_gst_no=B.c_gst_no 
                                         WHERE B.c_id = '$cid' and A.c_id=B.c_fkid");
                        
                        // $this->db->query("update group_users A, contact_master B set A.gu_name=B.c_name, 
                        //                  A.gu_designation=B.c_designation, A.gu_email=B.c_emailid1, A.gu_mobile=B.c_mobile1, 
                        //                  A.assigned_status='$c_status', 
                        //                  A.approved_date='$modnow', A.approved_by='$curusr' 
                        //                  WHERE B.c_id = '$cid' and A.gu_cid=B.c_fkid");

                        $this->db->query("update group_users A, contact_master B set A.name=B.c_name, A.gu_email=B.c_emailid1, 
                                         A.assigned_status='$c_status', A.approved_date='$modnow', A.approved_by='$curusr' 
                                         WHERE B.c_id = '$cid' and A.gu_cid=B.c_fkid");

                        // $this->db->where('kyc_cid', $c_fkid);
                        // $this->db->delete('contact_kyc_details');

                        $this->db->where('doc_ref_id', $c_fkid);
                        $this->db->where('doc_ref_type', 'Contacts');
                        $this->db->delete('document_details');

                        // $this->db->where('ref_id', $c_fkid);
                        // $this->db->delete('contact_nominee_details');

                        $this->db->where('ref_id', $c_fkid);
                        $this->db->delete('contact_other_details');

                        // $this->db->query("update contact_kyc_details set kyc_cid = '$c_fkid' WHERE kyc_cid = '$cid'");

                        $this->db->query("update document_details set doc_ref_id = '$c_fkid' WHERE doc_ref_id = '$cid' and doc_ref_type = 'Contacts'");

                        // $this->db->query("update contact_nominee_details set ref_id = '$c_fkid' WHERE ref_id = '$cid'");

                        $this->db->query("update contact_other_details set ref_id = '$c_fkid' WHERE ref_id = '$cid'");

                        $this->db->query("delete from contact_master WHERE c_id = '$cid'");
                        
                        $logarray['table_id']=$c_fkid;
                        $logarray['module_name']='Contact';
                        $logarray['cnt_name']='contacts';
                        $logarray['action']='Contact Record ' . $c_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }
            }
        }

       redirect(base_url().'index.php/Contacts');
    }
    
    public function checkstatus($status='', $contact_type='', $property_id='') {
		if($status=='InProcess') {
			$status='In Process';
            $cond=" and A.c_status='In Process'";
		} else if($status=='Pending') {
            $cond=" and (A.c_status='Pending' or A.c_status='Delete')";
        } else {
            $cond=" and A.c_status='$status'";
        }

        if($contact_type=='All'){
            $cond2 = '';
            $cond3 = '';
        } else {
            $cond2 = " and A.c_type = '$contact_type'";
            $cond3 = " and c_type = '$contact_type'";
        }

        if($property_id!=''){
            $cond4 = " and A.c_id in (select distinct contact_id from rent_tenant_details 
                        where rent_id in (select distinct txn_id from rent_txn where property_id = '$property_id'))";
            
            $cond5 = " and c_id in (select distinct contact_id from rent_tenant_details 
                        where rent_id in (select distinct txn_id from rent_txn where property_id = '$property_id'))";
        } else {
            $cond4 = '';
            $cond5 = '';
        }

		$roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND (r_view = 1 or r_insert = 1 or r_edit = 1 or r_delete = 1 or r_approvals = 1)");
        $result=$query->result();
        if(count($result)>0) {
            $data['access']=$result;
            $gid=$this->session->userdata('groupid');

            if($status!='All') {
                $sql = "SELECT case when A.c_owner_type='individual' then A.c_name else B.c_name end as c_name, 
                                case when A.c_owner_type='individual' then A.c_last_name else B.c_last_name end as c_last_name, 
                                case when A.c_owner_type='individual' then A.c_emailid1 else B.c_emailid1 end as c_emailid1, 
                                case when A.c_owner_type='individual' then A.c_mobile1 else B.c_mobile1 end as c_mobile1, 
                                A.c_id, A.c_owner_type, A.c_company_name,A.c_type 
                        FROM contact_master A LEFT JOIN contact_master B ON A.c_contact_id=B.c_id 
                        WHERE A.c_gid = '$gid' " . $cond2 . $cond . $cond4 . " 
                        ORDER BY A.c_modifieddate DESC";
            } else {
                $sql = "SELECT case when A.c_owner_type='individual' then A.c_name else B.c_name end as c_name, 
                                case when A.c_owner_type='individual' then A.c_last_name else B.c_last_name end as c_last_name, 
                                case when A.c_owner_type='individual' then A.c_emailid1 else B.c_emailid1 end as c_emailid1, 
                                case when A.c_owner_type='individual' then A.c_mobile1 else B.c_mobile1 end as c_mobile1, 
                                A.c_id, A.c_owner_type, A.c_company_name,A.c_type
                        FROM contact_master A LEFT JOIN contact_master B ON A.c_contact_id=B.c_id 
                        WHERE A.c_gid = '$gid' " . $cond2 . $cond4 . " and A.c_status!='Inactive' 
                        ORDER BY A.c_modifieddate DESC";
            }

            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contacts']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status!='Inactive' AND c_gid='$gid'" . $cond3 . $cond5);
            $result=$query->result();
            $data['all']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='In Process' AND c_gid='$gid'" . $cond3 . $cond5);
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Approved' AND c_gid='$gid'" . $cond3 . $cond5);
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE (c_status='Pending' or c_status='Delete') AND c_gid='$gid'" . $cond3 . $cond5);
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM contact_master WHERE c_status='Rejected' AND c_gid='$gid'" . $cond3 . $cond5);
            $result=$query->result();
            $data['rejected']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $data['contact_type'] = $contact_type;
            $data['checkstatus'] = $status;

            // echo json_encode($data);

            load_view('contacts/contact_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
	}

    public function saveContact(){
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Contacts' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');

            $maker_checker = $this->session->userdata('maker_checker');
            if($maker_checker!='yes'){
                $c_status='Approved';
            } else {
                $c_status='In Process';
            }
            
            if ($this->input->post('con_last_name')!=""){
                $data = array(
                            'c_name' => $this->input->post('con_first_name'),
                            'c_middle_name' => $this->input->post('con_middle_name'),
                            'c_last_name' =>  $this->input->post('con_last_name'),
                            'c_emailid1' => $this->input->post('con_email_id1'),
                            'c_mobile1' => $this->input->post('con_mobile_no1'),
                            'c_status' => $c_status,
                            'c_gid' => $this->session->userdata('groupid'),
                            'c_createdate' => $now,
                            'c_createdby' => $curusr,
                            'c_modifieddate' => $now,
                            'c_maker_remark'=>$this->input->post('maker_remark')
                        );
                $this->db->insert('contact_master',$data);
                $cid=$this->db->insert_id();
                $logarray['table_id']=$cid;
                $logarray['module_name']='Contact';
                $logarray['cnt_name']='contacts';
                $logarray['action']='Contact Record Inserted';
                $logarray['gp_id']=$gid;
                $this->user_access_log_model->insertAccessLog($logarray);

                // $data = array(
                //             // 'gu_name' => $this->input->post('con_first_name'),
                //             'gu_email' => $this->input->post('con_email_id1'),
                //             // 'gu_mobile' => $this->input->post('con_mobile_no1'),
                //             'gu_role' => 'User',
                //             'gu_cid' => $cid,
                //             'gu_gid' => $this->session->userdata('groupid'),
                //             'add_date' => $now,
                //             'create_date' => $now,
                //             'create_by' => $curusr,
                //             'modified_date' => $now,
                //         );
                // $this->db->insert('group_users', $data);
                
                echo $cid;
            }
            
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function check_availablity() {
        $gid=$this->session->userdata('groupid');
        $c_id = html_escape($this->input->post('c_id'));
        $c_name = html_escape($this->input->post('c_name'));
        $c_last_name = html_escape($this->input->post('c_last_name'));
        $email_id1 = html_escape($this->input->post('email_id1'));
        $mobile_no1 = html_escape($this->input->post('mobile_no1'));

        // $c_name = "Swapnil";
        // $c_last_name = "Darekar";
        // $email_id1 = "swapnil.darekar@otbconsulting.co.in";
        // $mobile_no1 = "9821311980";

        $result = $this->contact_model->check_availablity($gid, $c_id, $c_name, $c_last_name, $email_id1, $mobile_no1);
        echo $result;
    }

    function get_m_status() {
        $doc_name = html_escape($this->input->post('doc_name'));
        $doc_type = html_escape($this->input->post('doc_type'));

        // $doc_name = "Adhar Card";
        // $doc_type = "ID Proof";

        $result = $this->contact_model->get_m_status($doc_name, $doc_type);
        echo $result;
    }

    function check_contact_availablity() {
        $gid=$this->session->userdata('groupid');
        $c_name = html_escape($this->input->post('con_first_name'));
        $c_last_name = html_escape($this->input->post('con_last_name'));
        $email_id1 = html_escape($this->input->post('con_email_id1'));
        $mobile_no1 = html_escape($this->input->post('con_mobile_no1'));

        // $c_name = "Test";
        // $c_last_name = "Test";
        // $email_id1 = "ad@bd.com";
        // $mobile_no1 = "9833449918";

        $result = $this->contact_model->check_contact_availablity($gid, $c_name, $c_last_name, $email_id1, $mobile_no1);
        echo $result;
    }

    public function get_state_country()
    {
        $cityid = html_escape($this->input->post('cityid'));
        $this->db->select("s.state_name,cm.country_name");
        $this->db->join("city_master c", "c.state_id=s.id");
        $this->db->join("country_master cm" ,"s.country_id=cm.id");
        $this->db->where("c.id=$cityid");
        $result  = $this->db->get("state_master s")->result_array();

        if($result)
            echo json_encode($result);
        else
            echo null;

    }

}
?>