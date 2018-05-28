<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Non_real_estate_property extends CI_Controller
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
       $this->checkstatus('All','2');
    }
	public function add() {
       $this->load->view('Non_real_estate_property/non_real_estate_prop_details');
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

        echo $pid=$this->purchase_model->insertRecord($txn_status);
        $this->purchase_model->insertImage($pid);
        redirect(base_url().'index.php/Non_real_estate_property/');
    }

    public function edit($pid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $result=$this->purchase_model->getAccess();
       
            if(count($result)>0) {
                $data['p_txn']=$this->purchase_model->purchaseData('All',$pid,'2');
                $data['p_id']=$pid;
                $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id = '$pid'");
                $result=$query->result();
                $data['p_ownership']=$result;
                load_view('Non_real_estate_property/non_real_estate_prop_details',$data);
            } 
          else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }


	public function View($id) {
       $result=$this->purchase_model->getAccess();
       $data['p_id']=$id;
       $data['access']=$result;
       $data['property']=$this->purchase_model->purchaseData('All',$id,'2'); 
       load_view('Non_real_estate_property/non_real_estate_prop_view',$data); 
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
                $created_by = $res[0]->added_by;
                $create_date = $res[0]->added_on;
            } else {
                $rec_status = 'In Process';
                $txn_fkid = '';
                $gp_id = $gid;
                $created_by = $curusr;
                $create_date = $now;
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
                                  'location'=>($this->input->post('loaction')?$this->input->post('loaction'):''),
                                  'added_on' =>date('Y-m-d'),
                                  'added_by' => $curusr,
                                  'updated_on'=>date('Y-m-d')
                                );
               
                                $this->db->insert('property_txn', $data);
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
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('propert_txn',$data);
                        $pid=$this->db->insert_id();

                        $sql = "update propert_txn A, purchase_txn B set A.p_image = B.p_image, A.p_image_name = B.p_image_name 
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
                    redirect(base_url().'index.php/Non_real_estate_property');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }
   
    public function checkstatus($status='',$property_type_id=''){
            $result=$this->purchase_model->getAccess();
            $data['access']=$result;
                $data['property']=$this->purchase_model->purchaseData($status,'',$property_type_id);

                $count_data=$this->purchase_model->getAllCountData();
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
                    $data['approved']=$approved;
                    $data['pending']=$pending;
                    $data['rejected']=$rejected;
                    $data['inprocess']=$inprocess;
                    $data['all']=count($count_data);
                    $result = $this->db->query("call sp_getPropertyOwners('Approved','$gid',$property_id)")->result();
                    mysqli_next_result( $this->db->conn_id );
                    $data['owner_name']=$result; 
                    $data['checkstatus'] = $status;  
                }
                
                $data['maker_checker'] = $this->session->userdata('maker_checker');
                $data['property_type_id']=$property_type_id;

                load_view('Non_real_estate_property/non_real_estate_prop_list', $data);
    }

}
?>