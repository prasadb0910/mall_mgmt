<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Maintenance extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->library('session');
        $this->load->model('maintenance_model');
        $this->load->database();
    }

    public function index(){
        $this->checkstatus('All');
    }

    public function get_sub_property() {
        $property_id = html_escape($this->input->post('property_id'));
        $txn_id = html_escape($this->input->post('txn_id'));

        $query=$this->db->query("SELECT * FROM maintenance_txn WHERE txn_id='$txn_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sub_property = $result[0]->sub_property_id;
        } else {
            $sub_property = '0';
        }

        $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id='$property_id' AND txn_status='Approved'");
        $result=$query->result();

        $sub_property_list = '<option value="0" Selected>Select Sub Property</option>';

        foreach ($result as $row) {
            if ($sub_property == $row->txn_id) {
                $sub_property_list = $sub_property_list . '<option value="' . $row->txn_id . '" selected>' . $row->sp_name . '</option>';
            } else {
                $sub_property_list = $sub_property_list . '<option value="' . $row->txn_id . '">' . $row->sp_name . '</option>';
            }
        }

        if($sub_property_list == '<option value="0" Selected>Select Sub Property</option>'){
            $sub_property_list="";
        }

        echo $sub_property_list;
    }

    public function get_property_type() {
        $p_id = html_escape($this->input->post('property_id'));

        $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id='$p_id'");
        $result=$query->result();
        if (count($result)>0) {
            if($result[0]->p_type=='Building' || $result[0]->p_type=='Apartment' || $result[0]->p_type=='Bunglow') {
                $p_asset_type = 'Residential';
            } else {
                $p_asset_type = 'Commercial';
            }
        } else {
            $p_asset_type = '';
        }

        echo $p_asset_type;
    }

    public function get_cost() {
        $property_id = html_escape($this->input->post('property_id'));
        $sub_property_id = html_escape($this->input->post('sub_property_id'));

        // $property_id = '19';
        // $sub_property_id = '28';

        if($sub_property_id=="" || $sub_property_id==null) {
            $sub_property_id=0;
        }

        $txn_id="";
        
        $query=$this->db->query("select * from maintenance_txn where property_id = '$property_id' and sub_property_id = '$sub_property_id'");
        $result=$query->result();
        if (count($result)>0) {
            $txn_id=$result[0]->txn_id;
        }

        $data['txn_id']=$txn_id;

        echo json_encode($data);
    }

    public function get_tax_details() {
        $tax_id = html_escape($this->input->post('tax_id'));

        $txn_id="";
        
        $query=$this->db->query("select * from tax_master where tax_id = '$tax_id'");
        $result=$query->result();
        if (count($result)>0) {
            $tax_percent=$result[0]->tax_percent;
        }

        $data['tax_percent']=$tax_percent;

        echo json_encode($data);
    }

    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%maintenance%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax_details']=$result;

            $query=$this->db->query("SELECT txn_id, p_property_name, 
                                            case when p_type='Building' or p_type='Apartment' or p_type='Bunglow' then 
                                            'Residential' else 'Commercial' end as asset_type 
                                    FROM purchase_txn WHERE gp_id = '$gid' and txn_status='Approved'");
            $result=$query->result();
            $data['property']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('maintenance/maintenance_details', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function save(){
        $gid=$this->session->userdata('groupid');
        $curusr=$this->session->userdata('session_id');
        $roleid=$this->session->userdata('role_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now = date('Y-m-d H:i:s');
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else {
                $txn_status='In Process';
            }

            if($txn_status=='Approved'){
                $sch_status = '1';
            } else {
                $sch_status = '3';
            }

            if($this->input->post('sub_property')!=null){
                $sub_property = $this->input->post('sub_property');
            } else {
                $sub_property = '0';
            }

            $data = array(
                        'property_id' => $this->input->post('property'),
                        'sub_property_id' => $sub_property,
                        'txn_status' => $txn_status,
                        'gp_id' => $gid,
                        'create_date' => $now,
                        'created_by' => $curusr,
                        'modified_date' => $now,
                        'modified_by' => $curusr,
                        'maker_remark' => $this->input->post('maker_remark')
                    );
            $this->db->insert('maintenance_txn', $data);
            $mid=$this->db->insert_id();

            $logarray['table_id']=$this->db->insert_id();
            $logarray['module_name']='Maintenance';
            $logarray['cnt_name']='Maintenance';
            $logarray['action']='Maintenance Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);
            
            $particular=$this->input->post('particular[]');
            $due_date=$this->input->post('due_date[]');
            $frequency=$this->input->post('frequency[]');
            $cost=$this->input->post('cost[]');

            for ($i=0; $i < count($particular); $i++) { 
                if($due_date[$i]==NULL || $due_date[$i]=='') {
                    $dueDate=NULL;
                } else {
                    $dueDate=formatdate($due_date[$i]);
                }

                $cost[$i]=format_number($cost[$i],2);
                if($this->input->post('sch_tax_'.($i+1))!=null){
                    $sch_tax=$this->input->post('sch_tax_'.($i+1));
                    if(count($sch_tax) > 0){
                        $service_tax=implode(",",$sch_tax);
                    }
                } else {
                    $sch_tax=array();
                }

                $data = array(
                            'm_id' => $mid,
                            'particular' =>  $particular[$i],
                            'cost' => format_number($cost[$i],2),
                            'due_date' =>  $dueDate,
                            'frequency' =>  $frequency[$i],
                            'service_tax' =>  $service_tax
                        );
                $this->db->insert('maintenance_cost_details', $data);

                if(count($sch_tax) > 0){
                    $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$cost[$i]);
                }

                $week_index=0;
                $to_date = date ("Y-m-d", strtotime ($dueDate ."+1 years"));
                $cur_date = date('Y-m-d');
                
                while($dueDate<=$to_date) {
                    if(count($sch_tax) > 0){
                        $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$cost[$i]);

                        $data = array(
                            'm_id' => $mid ,
                            'event_type'=>'maintenance',
                            'event_name' => $particular[$i],
                            'event_date' => $dueDate,
                            'basic_cost' => $cost[$i],
                            'net_amount' => $tax_detail["netamount"],
                            'create_date' => date('Y-m-d'),
                            'create_by' => $curusr,
                            'sch_status'=>$sch_status,
                            'status'=>$sch_status
                        );
                    } else {
                        $data = array(
                            'm_id' => $mid ,
                            'event_type'=>'maintenance',
                            'event_name' => $particular[$i],
                            'event_date' => $dueDate,
                            'basic_cost' => $cost[$i],
                            'net_amount' => $cost[$i],
                            'create_date' => date('Y-m-d'),
                            'create_by' => $curusr,
                            'sch_status'=>$sch_status,
                            'status'=>$sch_status
                        );
                    }
                    $this->db->insert('maintenance_schedule', $data);
                    $scid=$this->db->insert_id();



                    if(count($sch_tax) > 0){
                        $j=0;
                        foreach($tax_detail['tax_detail'] as $row){
                            // print_r($tax_detail['tax_detail'][$j]);

                            //$tax_array=explode(',',$sch_tax[$j]);

                            $data = array(
                                'sch_id' => $scid,
                                'event_type' => 'Maintenance',
                                'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                                'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                                'tax_percent' => $tax_detail['tax_detail'][$j]['tax_percent'],
                                'tax_amount' => $tax_detail['tax_detail'][$j]['tax_amount'],
                                'm_id' => $mid,
                                'status'=>$sch_status
                            );
                            $this->db->insert('maintenance_schedule_taxation', $data);  
                            $j++;
                        }
                    }

                    if($frequency[$i]=="monthly") {
                        $date = explode('-',$dueDate);
                        $dueDate = $date[0] . '-' . strval(intval($date[1])+intval(1)) . '-' . $date[2];
                        $d = DateTime::createFromFormat("Y-m-d", $dueDate);
                        $dueDate = strval($d->format('Y-m-d'));
                    } else if($frequency[$i]=="quarterly") {
                        $date = explode('-',$dueDate);
                        $dueDate = $date[0] . '-' . strval(intval($date[1])+intval(3)) . '-' . $date[2];
                        $d = DateTime::createFromFormat("Y-m-d", $dueDate);
                        $dueDate = strval($d->format('Y-m-d'));
                    } else if($frequency[$i]=="yearly") {
                        $dueDate = date ("Y-m-d", strtotime ($dueDate ."+1 years"));
                    }
                }
            }

            $this->maintenance_model->send_maintenance_intimation($mid);

            redirect(base_url().'index.php/Maintenance');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function getTaxDetailsCalculation($tax_id,$sch_basiccost){
        //  print_r($tax_id);
        $tax_id=implode(',',$tax_id);
        $this->db->select('tax_id,tax_name,tax_percent,tax_action');
        $this->db->from('tax_master');
        $this->db->where('tax_id in ('.$tax_id.') and status = "1" and tax_action="1"');
        $result=$this->db->get();
        // echo $this->db->last_query();
        $netamount=$sch_basiccost;
        foreach ($result->result() as $row){
            $tax_amount=round(($sch_basiccost * $row->tax_percent)/100);
            if($row->tax_action==1){
                $netamount=$netamount+$tax_amount;
            }
            else if($row->tax_action==0){
                $netamount=$netamount-$tax_amount;
            }
            $tax_detail[]=array("tax_id"=>$row->tax_id,"tax_type"=>$row->tax_name,"tax_percent"=>$row->tax_percent,"tax_amount"=>$tax_amount);
        }
        //print_r($tax_detail);
        $dataarray=array("netamount"=>$netamount,"tax_detail"=>$tax_detail);
        return $dataarray;
    }

    public function view($mid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid' and txn_status='Approved'");
                $result=$query->result();
                $data['property']=$result;

                $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE gp_id = '$gid' and txn_status='Approved'");
                $result=$query->result();
                $data['subproperty']=$result;

                $data['maintenance_by']=$this->session->userdata('session_id');

                // $query=$this->db->query("SELECT * FROM maintenance_txn WHERE m_fkid = '$mid'");
                // $result=$query->result();
                // if (count($result)>0){
                //     $mid = $result[0]->txn_id;
                // }
               
                

                $query=$this->db->query("SELECT * FROM maintenance_txn WHERE txn_id = '$mid'");
                $result=$query->result();
                $data['maintenance_txn']=$result;

                 $sql_owner="select  A.purchase_id ,A.pr_client_id ,case when B.ow_type = '0' then (select  concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                            where c_id = B.ow_ind_id) 
                        when B.ow_type = '1' then B.ow_huf_name 
                        when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
                        when B.ow_type = '3' then B.ow_ltd_comapny_name 
                        when B.ow_type = '4' then B.ow_llp_comapny_name 
                        when B.ow_type = '5' then B.ow_prt_comapny_name 
                        when B.ow_type = '6' then B.ow_aop_comapny_name 
                        when B.ow_type = '7' then B.ow_trs_comapny_name 
                        else B.ow_proprietorship_comapny_name end as owner_name 
                        from purchase_ownership_details A, owner_master B 
                        where B.ow_id = A.pr_client_id and A.purchase_id = '".$result[0]->property_id."' ";

                $result_owner=$this->db->query($sql_owner);
                $data['owner']=$result_owner->result();

                $sql="select A.tax_master_id, B.tax_name, B.tax_percent from 
                      (select distinct tax_master_id from maintenance_schedule_taxation where m_id='$mid') A 
                      left join 
                      (select * from tax_master WHERE txn_type like '%maintenance%' AND status = '1') B 
                      on (A.tax_master_id = B.tax_id) 
                      order by A.tax_master_id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['tax_details']=$result;

                $query=$this->db->query("SELECT * FROM maintenance_cost_details WHERE m_id = '$mid' order by id");
                $result=$query->result();
                $data['maintenance_cost_details']=$result;
                if(count($result)>0){
                    $service_tax_amt=array();
                    $net_amount=array();
                    $total_cost=0;
                    $total_service_tax_amt=array();
                    $total_net_amount=0;

                    for($i=0;$i<count($result);$i++){
                        $cost=$result[$i]->cost;
                        $service_tax=$result[$i]->service_tax;
                        $tax_id=explode(",", $service_tax);
                        $net_amount[$i]=$cost;

                        $total_cost=$total_cost+$cost;
                        $total_net_amount=$total_net_amount+$cost;

                        if(count($tax_id)>0){
                            sort($tax_id);
                            for($j=0;$j<count($tax_id);$j++){
                                if(!isset($total_service_tax_amt[$j])){
                                    $total_service_tax_amt[$j]=0;
                                }
                                $sql="select * from tax_master WHERE tax_id = '" . $tax_id[$j] . "'";
                                $query=$this->db->query($sql);
                                $result2=$query->result();
                                if(count($result2)>0) {
                                    $tax_percent = $result2[0]->tax_percent;
                                    $tax_amount = ($cost*$tax_percent)/100;
                                    $service_tax_amt[$i][$j] = $tax_amount;
                                    $net_amount[$i]=$net_amount[$i]+$tax_amount;

                                    $total_service_tax_amt[$j]=$total_service_tax_amt[$j]+$tax_amount;
                                    $total_net_amount=$total_net_amount+$tax_amount;
                                }
                            }
                        }
                    }
                }

                $data['total_cost']=$total_cost;
                $data['service_tax_amt']=$service_tax_amt;
                $data['net_amount']=$net_amount;
                $data['total_service_tax_amt']=$total_service_tax_amt;
                $data['total_net_amount']=$total_net_amount;


                // $query=$this->db->query("SELECT sum(cost) as total_cost FROM maintenance_cost_details WHERE m_id = '$mid'");
                // $result=$query->result();
                // if (count($result)>0) {
                //     $data['total_cost']=$result[0]->total_cost;
                // } else {
                //     $data['total_cost']=0;
                // }
                
                $data['m_id']=$mid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('maintenance/maintenance_view', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($mid) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1  or $result[0]->r_approvals==1 ) {
                $data['access']=$result;

                $query=$this->db->query("SELECT * FROM maintenance_txn WHERE m_fkid = '$mid'");
                $result=$query->result();
                if (count($result)>0){
                    $mid = $result[0]->txn_id;
                }

                $query=$this->db->query("SELECT * FROM maintenance_txn WHERE txn_id = '$mid'");
                $result=$query->result();
                $data['maintenance_txn']=$result;

                if (count($result)>0){
                    $property_id=$result[0]->property_id;
                } else {
                    $property_id=0;
                }

                $query=$this->db->query("SELECT * FROM purchase_txn WHERE gp_id = '$gid' and txn_status='Approved'");
                $result=$query->result();
                $data['property']=$result;

                $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id = '$property_id' and txn_status='Approved'");
                $result=$query->result();
                $data['subproperty']=$result;

                $query=$this->db->query("SELECT * FROM maintenance_cost_details WHERE m_id = '$mid' order by id");
                $result=$query->result();
                if (count($result)>0) {
                    $data['maintenance_cost_details']=$result;
                }

                $query=$this->db->query("SELECT sum(cost) as total_cost FROM maintenance_cost_details WHERE m_id = '$mid'");
                $result=$query->result();
                if (count($result)>0) {
                    $data['total_cost']=$result[0]->total_cost;
                } else {
                    $data['total_cost']=0;
                }
                
                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%maintenance%' AND status = '1'");
                $result=$query->result();
                $data['tax_details']=$result;

                $data['m_id']=$mid;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view('maintenance/maintenance_details', $data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($mid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {

            if($this->input->post('submit')=='Delete') {
                $txn_status='Delete';
            } elseif($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else {
                $txn_status='In Process';
            }

            if($txn_status=='Approved'){
                $sch_status = '1';
            } else {
                $sch_status = '3';
            }

            if($txn_status=='Delete') {
                if($result[0]->r_delete == 1) {
                    $query=$this->db->query("SELECT * FROM maintenance_txn WHERE txn_id = '$mid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->txn_status;
                        $m_fkid = $res[0]->m_fkid;
                        $gp_id = $res[0]->gp_id;
                        $created_by = $res[0]->created_by;
                        $create_date = $res[0]->create_date;
                    } else {
                        $rec_status = '';
                        $m_fkid = '';
                        $gp_id = null;
                        $created_by = $curusr;
                        $create_date = $now;    
                    }

                    if ($rec_status=="Approved") {
                        $txn_remarks = $this->input->post('status_remarks');

                        if($maker_checker!='yes'){
                            $txn_status = 'Inactive';

                            $this->db->query("update maintenance_txn set txn_status='$txn_status', txn_remarks='$txn_remarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE txn_id = '$mid'");

                            $logarray['table_id']=$mid;
                            $logarray['module_name']='Maintenance';
                            $logarray['cnt_name']='Maintenance';
                            $logarray['action']='Maintenance Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM maintenance_txn WHERE m_fkid = '$mid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $mid = $result[0]->txn_id;

                                $this->db->query("Update maintenance_txn set txn_status='$txn_status', txn_remarks='$txn_remarks', 
                                                 modified_date='$modnow', modified_by='$curusr'
                                                 WHERE txn_id = '$mid'");

                                $logarray['table_id']=$mid;
                                $logarray['module_name']='Maintenance';
                                $logarray['cnt_name']='Maintenance';
                                $logarray['action']='Maintenance Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                            } else {
                                $this->db->query("Insert into maintenance_txn (property_id, sub_property_id, txn_status, txn_remarks, 
                                                 create_date, created_by, modified_date, modified_by, approved_date, approved_by, 
                                                 gp_id, m_fkid, rejected_by, rejected_date, maker_remark)  
                                                 Select property_id, sub_property_id, txn_status, txn_remarks, 
                                                 '$create_date', '$created_by', '$modnow', '$curusr', approved_date, approved_by, 
                                                 '$gp_id', '$mid', rejected_by, rejected_date, maker_remark 
                                                 FROM maintenance_txn WHERE txn_id = '$mid'");
                                $new_mid=$this->db->insert_id();

                                $logarray['table_id']=$mid;
                                $logarray['module_name']='Maintenance';
                                $logarray['cnt_name']='Maintenance';
                                $logarray['action']='Maintenance Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into maintenance_cost_details (m_id, particular, cost)  
                                                 Select '$new_mid', particular, cost 
                                                 FROM maintenance_cost_details WHERE m_id = '$mid'");

                                $query=$this->db->query("SELECT * FROM maintenance_schedule WHERE m_id = '$mid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into maintenance_schedule (m_id, event_name, event_date, basic_cost, 
                                                         net_amount, sch_status, create_date, create_by, modified_date, modified_by, event_type, status) 
                                                         Select '$new_pid', event_name, event_date, basic_cost, net_amount, '3', 
                                                         '$sch_create_date', '$sch_create_by', '$modnow', '$cursur', event_type, status 
                                                         FROM maintenance_schedule WHERE m_id = '$mid' and sch_id = '$sch_id'");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into maintenance_schedule_taxation (sch_id, tax_type, tax_percent, 
                                                         tax_amount, m_id, event_type, tax_master_id, status) 
                                                         Select '$new_sch_id', tax_type, tax_percent, tax_amount, '$new_mid', event_type, tax_master_id, status 
                                                         FROM maintenance_schedule_taxation WHERE m_id = '$mid' and sch_id = '$sch_id'");
                                    }
                                }
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $mid);
                        $this->db->delete('maintenance_txn');

                        $this->db->where('m_id', $mid);
                        $this->db->delete('maintenance_cost_details');

                        $this->db->where('m_id', $mid);
                        $this->db->delete('maintenance_schedule');

                        $this->db->where('m_id', $mid);
                        $this->db->delete('maintenance_schedule_taxation');

                        $logarray['table_id']=$mid;
                        $logarray['module_name']='Maintenance';
                        $logarray['cnt_name']='Maintenance';
                        $logarray['action']='Maintenance Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Maintenance');
                } else {
                    echo "Unauthorized access.";
                }
            } else {

                if($result[0]->r_edit == 1) {
                    $now = date('Y-m-d H:i:s');
                    $query=$this->db->query("SELECT * FROM maintenance_txn WHERE txn_id = '$mid'");
                    $res=$query->result();
                    if(count($res)>0) {
                        $rec_status = $res[0]->txn_status;
                        $m_fkid = $res[0]->m_fkid;
                        $gp_id = $res[0]->gp_id;
                        $created_by = $res[0]->created_by;
                        $create_date = $res[0]->create_date;
                    } else {
                        $rec_status = '';
                        $m_fkid = '';
                        $gp_id = $gid;
                        $created_by = $curusr;
                        $create_date = $now;
                    }

                    if($this->input->post('sub_property')!=null){
                        $sub_property = $this->input->post('sub_property');
                    } else {
                        $sub_property = '0';
                    }

                    $data = array(
                        'property_id' => $this->input->post('property') ,
                        'sub_property_id' => $sub_property,
                        'txn_status' => $txn_status,
                        'gp_id' => $gp_id,
                        'maker_remark' => $this->input->post('maker_remark')
                    );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $m_fkid = $mid;
                        $data['m_fkid'] = $mid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;
                        $this->db->insert('maintenance_txn',$data);
                        $mid=$this->db->insert_id();

                        $logarray['table_id']=$m_fkid;
                        $logarray['module_name']='Maintenance';
                        $logarray['cnt_name']='Maintenance';
                        $logarray['action']='Maintenance Approved Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;
                        $this->db->where('txn_id', $mid);
                        $this->db->update('maintenance_txn',$data);

                        $logarray['table_id']=$mid;
                        $logarray['module_name']='Maintenance';
                        $logarray['cnt_name']='Maintenance';
                        $logarray['action']='Maintenance Record Modified';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('m_id', $mid);
                        $this->db->delete('maintenance_cost_details');

                        $this->db->where('m_id', $mid);
                        $this->db->delete('maintenance_schedule');

                        $this->db->where('m_id', $mid);
                        $this->db->delete('maintenance_schedule_taxation');
                    }

                    $particular=$this->input->post('particular[]');
                    $due_date=$this->input->post('due_date[]');
                    $frequency=$this->input->post('frequency[]');
                    $cost=$this->input->post('cost[]');

                    for ($i=0; $i < count($particular); $i++) {
                        if($due_date[$i]==NULL || $due_date[$i]=='') {
                            $dueDate=NULL;
                        } else {
                            $dueDate=formatdate($due_date[$i]);
                        }

                        $cost[$i]=format_number($cost[$i],2);
                        if($this->input->post('sch_tax_'.($i+1))!=null){
                            $sch_tax=$this->input->post('sch_tax_'.($i+1));
                            if(count($sch_tax) > 0){
                                $service_tax=implode(",",$sch_tax);
                            }
                        } else {
                            $sch_tax=array();
                        }

                        $data = array(
                                    'm_id' => $mid,
                                    'particular' =>  $particular[$i],
                                    'cost' => format_number($cost[$i],2),
                                    'due_date' =>  $dueDate,
                                    'frequency' =>  $frequency[$i],
                                    'service_tax' =>  $service_tax
                                );
                        $this->db->insert('maintenance_cost_details', $data);
                        
                        $week_index=0;
                        $to_date = date ("Y-m-d", strtotime ($dueDate ."+1 years"));
                        $cur_date = date('Y-m-d');

                        while($dueDate<=$to_date) {
                            if(count($sch_tax) > 0){
                                $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$cost[$i]);

                                $data = array(
                                    'm_id' => $mid,
                                    'event_type'=>'maintenance',
                                    'event_name' => $particular[$i],
                                    'event_date' => $dueDate,
                                    'basic_cost' => $cost[$i],
                                    'net_amount' => $tax_detail["netamount"],
                                    'create_date' => date('Y-m-d'),
                                    'create_by' => $curusr,
                                    'sch_status'=>$sch_status,
                                    'status'=>$sch_status
                                );
                            } else {
                                $data = array(
                                    'm_id' => $mid ,
                                    'event_type'=>'maintenance',
                                    'event_name' => $particular[$i],
                                    'event_date' => $dueDate,
                                    'basic_cost' => $cost[$i],
                                    'net_amount' => $cost[$i],
                                    'create_date' => date('Y-m-d'),
                                    'create_by' => $curusr,
                                    'sch_status'=>$sch_status,
                                    'status'=>$sch_status
                                );
                            }
                            $this->db->insert('maintenance_schedule', $data);
                            $scid=$this->db->insert_id();

                            if(count($sch_tax) > 0){
                                $j=0;
                                foreach($tax_detail['tax_detail'] as $row){
                                    // print_r($tax_detail['tax_detail'][$j]);

                                    //$tax_array=explode(',',$sch_tax[$j]);

                                    $data = array(
                                        'sch_id' => $scid,
                                        'event_type' => 'Maintenance',
                                        'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                                        'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                                        'tax_percent' => $tax_detail['tax_detail'][$j]['tax_percent'],
                                        'tax_amount' => $tax_detail['tax_detail'][$j]['tax_amount'],
                                        'm_id' => $mid,
                                        'status'=>$sch_status
                                    );
                                    $this->db->insert('maintenance_schedule_taxation', $data);  
                                    $j++;
                                }
                            }

                            if($frequency[$i]=="monthly") {
                                $date = explode('-',$dueDate);
                                $dueDate = $date[0] . '-' . strval(intval($date[1])+intval(1)) . '-' . $date[2];
                                $d = DateTime::createFromFormat("Y-m-d", $dueDate);
                                $dueDate = strval($d->format('Y-m-d'));
                            } else if($frequency[$i]=="quarterly") {
                                $date = explode('-',$dueDate);
                                $dueDate = $date[0] . '-' . strval(intval($date[1])+intval(3)) . '-' . $date[2];
                                $d = DateTime::createFromFormat("Y-m-d", $dueDate);
                                $dueDate = strval($d->format('Y-m-d'));
                            } else if($frequency[$i]=="yearly") {
                                $dueDate = date ("Y-m-d", strtotime ($dueDate ."+1 years"));
                            }
                        }
                    }

                    redirect(base_url().'index.php/Maintenance');
                }  else {
                    echo "Unauthorized access.";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($mid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid'");
        $result=$query->result();
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM maintenance_txn WHERE txn_id = '$mid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $m_fkid = $res[0]->m_fkid;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $m_fkid = '';
                    $gp_id = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else {
                    $txn_status='Rejected';
                }
                $txn_remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update maintenance_txn set txn_status='Rejected', txn_remarks='$txn_remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$mid'");
                    
                    $logarray['table_id']=$mid;
                    $logarray['module_name']='Maintenance';
                    $logarray['cnt_name']='Maintenance';
                    $logarray['action']='Maintenance Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($m_fkid=='' || $m_fkid==null) {
                        $this->db->query("update maintenance_txn set txn_status='Approved', txn_remarks='$txn_remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$mid'");
                        $this->db->query("update maintenance_schedule set sch_status = '1', status='1' WHERE m_id = '$mid'");
                        $this->db->query("update maintenance_schedule_taxation set status='1' WHERE m_id = '$mid'");
                        
                        $logarray['table_id']=$mid;
                        $logarray['module_name']='Maintenance';
                        $logarray['cnt_name']='Maintenance';
                        $logarray['action']='Maintenance Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update maintenance_txn A, maintenance_txn B set A.property_id=B.property_id,
                                         A.sub_property_id=B.sub_property_id,
                                         A.txn_status='$txn_status',A.txn_remarks='$txn_remarks',A.create_date=B.create_date,
                                         A.created_by=B.created_by,A.modified_date=B.modified_date,A.modified_by=B.modified_by,
                                         A.approved_date='$modnow',A.approved_by='$curusr',A.gp_id=B.gp_id,
                                         A.rejected_by=B.rejected_by,A.rejected_date=B.rejected_date,A.maker_remark=B.maker_remark 
                                         WHERE B.txn_id = '$mid' and A.txn_id=B.m_fkid");

                        $this->db->where('m_id', $m_fkid);
                        $this->db->delete('maintenance_cost_details');

                        $this->db->query("update maintenance_cost_details set m_id = '$m_fkid' WHERE m_id = '$mid'");

                        $this->db->query("update maintenance_schedule set sch_status = '2', status='2' WHERE m_id = '$m_fkid'");
                        $this->db->query("update maintenance_schedule set m_id = '$m_fkid', sch_status = '1', status='1' WHERE m_id = '$mid'");

                        $this->db->query("update maintenance_schedule_taxation set status='2' WHERE m_id = '$m_fkid'");
                        $this->db->query("update maintenance_schedule_taxation set m_id = '$m_fkid', status='1' WHERE m_id = '$mid'");

                        $this->db->query("delete from maintenance_txn WHERE txn_id = '$mid'");
                        
                        $logarray['table_id']=$m_fkid;
                        $logarray['module_name']='Maintenance';
                        $logarray['cnt_name']='Maintenance';
                        $logarray['action']='Maintenance Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

            }
        }

       redirect(base_url().'index.php/Maintenance');
    }
	
	public function checkstatus($status=''){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid' AND r_view = 1");
        $result=$query->result();
        if(count($result)>0) {
            $data = $this->maintenance_model->getMaintenanceData($status);

            $data['access']=$result;

            $query=$this->db->query("SELECT * FROM maintenance_txn WHERE gp_id = '$gid'");
            $result=$query->result();
            $data['all']=$result;
            
            $query=$this->db->query("SELECT * FROM maintenance_txn WHERE gp_id = '$gid' AND txn_status='In Process'");
            $result=$query->result();
            $data['inprocess']=$result;

            $query=$this->db->query("SELECT * FROM maintenance_txn WHERE gp_id = '$gid' AND txn_status='Approved'");
            $result=$query->result();
            $data['approved']=$result;

            $query=$this->db->query("SELECT * FROM maintenance_txn WHERE gp_id='$gid' AND  (txn_status='Pending' or txn_status='Delete')");
            $result=$query->result();
            $data['pending']=$result;

            $query=$this->db->query("SELECT * FROM maintenance_txn WHERE gp_id='$gid' AND txn_status='Rejected'");
            $result=$query->result();
            $data['rejected']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('maintenance/maintenance_list', $data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function send_maintenance_intimation($mid){
        $this->maintenance_model->send_maintenance_intimation($mid);
    }
}
?>