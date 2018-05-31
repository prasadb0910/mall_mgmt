<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Real_estate_property extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');

    }


    public function index() {

        $this->checkstatus('All','1');
    }

	public function add() {

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $gid=$this->session->userdata('groupid');
            $result = $this->db->query("call sp_getcontact('Approved','$gid','Owners')")->result();
            mysqli_next_result( $this->db->conn_id );
            $data['owner']=$result;
            
            $sresult = $this->db->query("call sp_getcontact('Approved','$gid','')")->result();
            mysqli_next_result( $this->db->conn_id );
            $data['contact']=$sresult;
            $data['maker_checker'] = $this->session->userdata('maker_checker');
        
            load_view('Real_estate_property/real_estate_property_details',$data);
        }else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
        
    }

    public function saverecord()
    {
        if($this->input->post('submit')=='Submit For Approval') {
            $txn_status='Pending';
        } else if($this->input->post('submit')=='Submit') {
            $txn_status='Approved';
        } else {
            $txn_status='In Process';
        }

        $pid=$this->purchase_model->insertRecord($txn_status);
        $this->purchase_model->insertImage($pid);
        $this->purchase_model->insertOwnershipDetails($pid);
        redirect(base_url().'index.php/Real_estate_property');
    }

   public function edit($pid){

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $result=$this->purchase_model->getAccess();
        
            if(count($result)>0) {
                $data['p_txn']=$this->purchase_model->purchaseData('All',$pid,'1');
                $data['p_id']=$pid;
                $result = $this->db->query("call sp_getcontact('Approved','$gid','Owners')")->result();
                mysqli_next_result( $this->db->conn_id );
                $data['owner']=$result;    

                $sresult = $this->db->query("call sp_getcontact('Approved','$gid','')")->result();
                mysqli_next_result( $this->db->conn_id );
                $data['contact']=$sresult;

                $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id = '$pid'");
                $result=$query->result();
                $data['p_ownership']=$result;
				$data['maker_checker'] = $this->session->userdata('maker_checker');
                load_view('Real_estate_property/real_estate_property_details',$data);
            } 
          else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updaterecord($pid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Purchase' AND role_id='$roleid'");
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

            $query=$this->db->query("SELECT * FROM property_txn WHERE property_txn_id = '$pid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $gp_id = $res[0]->gp_id;
                $added_by = $res[0]->added_by;
                $added_on = $res[0]->added_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $added_by = $curusr;
                $added_on = $now;
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    if ($rec_status=="Approved") {
                        $txnremarks = $this->input->post('status_remarks');
                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update property_txn set txn_status='$txn_status', 
                                            updated_by='$curusr', updated_on='$modnow' WHERE property_txn_id = '$pid'");

                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Purchase';
                            $logarray['cnt_name']='Purchase';
                            $logarray['action']='Purchase Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM property_txn WHERE txn_fkid = '$pid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $pid = $result[0]->property_txn_id;
                                $this->db->query("update property_txn set txn_status='$txn_status',updated_by='$curusr', updated_on='$modnow' WHERE property_txn_id = '$pid'");
                                $logarray['table_id']=$pid;
                                $logarray['module_name']='Purchase';
                                $logarray['cnt_name']='Purchase';
                                $logarray['action']='Purchase Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {

                              $pid=$this->purchase_model->insertRecord($txn_status);
                                $new_pid=$this->db->insert_id();
                                $logarray['table_id']=$pid;
                                $logarray['module_name']='Purchase';
                                $logarray['cnt_name']='Purchase';
                                $logarray['action']='Purchase Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $pid);
                        $this->db->delete('property_txn');

                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_ownership_details');

                        
                        $this->db->where('doc_ref_id', $pid);
                        $this->db->where('doc_ref_type', 'Property_Purchase');
                        $this->db->delete('document_details');

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Purchase');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit == 1) {
                    $purdt=$this->input->post('date_of_purchase');
                    if($purdt==''){
                        $purdt=NULL;
                    } else {
                        $purdt=formatdate($purdt);
                    }
                    $data = array('gp_id' => $gid,
                                  'property_typ_id'=>($this->input->post('type_id')?$this->input->post('type_id'):''),
                                  'unit_name'=> ($this->input->post('unit')?$this->input->post('unit'):''),
                                  'unit_type'=> ($this->input->post('unit_type')?$this->input->post('unit_type'):''),
                                  'unit_no'=> ($this->input->post('unit_no')?$this->input->post('unit_no'):''),
                                  'floor'=> ($this->input->post('floor')?$this->input->post('floor'):''),
                                  'area'=> ($this->input->post('area')?$this->input->post('area'):''),
                                  'area_unit'=> ($this->input->post('area_unit')?$this->input->post('area_unit'):''),
                                  'allocated_cost'=>($this->input->post('allocated_cost')?$this->input->post('allocated_cost'):''),
                                  'allocated_maintenance'=>($this->input->post('allocated_maintenance')?$this->input->post('allocated_maintenance'):''),
                                  'txn_status'=>$txn_status,
                                  'location'=>($this->input->post('location')?$this->input->post('location'):''),
                                  'added_on' =>date('Y-m-d'),
                                  'added_by' => $curusr,
                                  'updated_on'=>date('Y-m-d')
                                );
                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $pid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['added_on'] = $added_on;
                        $data['added_by'] = $added_by;
                        $data['updated_on'] = $modnow;
                        $data['updated_by'] = $curusr;

                        $this->db->insert('property_txn',$data);
                        $pid=$this->db->insert_id();

                        $sql = "update property_txn A, property_txn B set A.p_image = B.p_image, A.p_image_name = B.p_image_name 
                                where A.property_txn_id = '$pid' and B.property_txn_id = '$txn_fkid'";
                        $this->db->query($sql);
                        
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                    } else {
                        $data['added_on'] = $modnow;
                        $data['added_by'] = $curusr;

                        $this->db->where('property_txn_id', $pid);
                        $this->db->update('property_txn',$data);

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Purchase';
                        $logarray['cnt_name']='Purchase';
                        $logarray['action']='Purchase Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes')
                     {
                        $this->db->where('purchase_id', $pid);
                        $this->db->delete('purchase_ownership_details');
                     
                    }

                    $purchase_ownership_details=$this->purchase_model->insertOwnershipDetails($pid);

                    $this->purchase_model->insertImage($pid);
                    redirect(base_url().'index.php/real_estate_property');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

	public function View($id) {
       $data['p_id']=$id;
       $result=$this->purchase_model->getAccess();
       $data['access']=$result;
       $data['property']=$this->purchase_model->purchaseData('All',$id,'1');
       $property_id = $data['property'][0]->property_txn_id;
       $gid = $data['property'][0]->gp_id;


        $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id = '$property_id'");
        $result=$query->result();
        $data['p_ownership']=$result;

        $result = $this->db->query("call sp_getcontact('Approved','$gid','Owners')")->result();
        mysqli_next_result( $this->db->conn_id );
        $data['owner']=$result;
        $result = $this->db->query("call sp_getPropertyOwners('Approved','$gid',$property_id)")->result();
        mysqli_next_result( $this->db->conn_id );
        $data['owner_name']=$result;  

       load_view('Real_estate_property/real_estate_property_view',$data);
    }

    public function checkstatus($status='',$property_type_id=''){
            $result=$this->purchase_model->getAccess();
            $data['access']=$result;
            $data['property']=$this->purchase_model->purchaseData($status,'',$property_type_id);

            $count_data=$this->purchase_model->getAllCountData($property_type_id);
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($count_data)>0){
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

            if(count($data['property'])>0)
            {
                $property_id = $data['property'][0]->property_txn_id;
                $gid = $data['property'][0]->gp_id;
              
                $result = $this->db->query("call sp_getPropertyOwners('Approved','$gid',$property_id)")->result();
                mysqli_next_result( $this->db->conn_id );
                $data['owner_name']=$result; 
            }
            
            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);
            $data['checkstatus'] = $status;
            $data['maker_checker'] = $this->session->userdata('maker_checker');
            $data['property_type_id']=$property_type_id;
            

            load_view('Real_estate_property/real_estate_property_list', $data);
    }
 
}
?>