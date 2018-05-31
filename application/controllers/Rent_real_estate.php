<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent_real_estate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("rent_model");
        $this->load->model('document_model');
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
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%rent%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;
            //$data['property']= $this->rent_model->getPropertyDetails('',1);
            $result = $this->db->query("call sp_getpropertynorent(1,'')")->result();
            mysqli_next_result( $this->db->conn_id );
            $data['property']=$result; 
            $gid=$this->session->userdata('groupid');
            $result = $this->db->query("call sp_getcontact('Approved','$gid','Tenants')")->result();
            mysqli_next_result( $this->db->conn_id );
            $data['contact']=$result; 
            $data['tax_details']=$this->rent_model->getAllTaxes('rent');

            $query=$this->db->query("select * from notification_master");
            $result=$query->result();
            $data['notification']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            $docs=$this->document_model->add_new_doc('', 'rent');
            $data=array_merge($data, $docs);
            
            load_view('Rent_real_estate/rent_real_estate_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
        //$this->load->view('Rent_real_estate/rent_real_estate_details');
    }

    public function view($rent_id)
    {
        $this->get_record($rent_id, 'Rent_real_estate/rent_real_estate_view');
       /* $data['rent']=$this->rent_model->rentData('ALL', '','',$rent_id);
        if(count($data['rent'])>0)
        {
            foreach ($data['rent'] as $key => $value) {
                $gid =  $value->gp_id;
                $property_id =  $value->property_id;
                $result = $this->db->query("call sp_getPropertyOwners('Approved','$gid',$property_id)")->result();
                mysqli_next_result( $this->db->conn_id );
                $data['rent'][$key]->owner_name=$result; 
            }
        }
        load_view('Rent_real_estate/rent_real_estate_view', $data);*/
    }

    public function edit($rid){
        $this->get_record($rid, 'Rent_real_estate/rent_real_estate_details');
    }

    public function get_record($rid, $view){
        $data['tax_details']=$this->rent_model->getAllTaxes('rent');

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                $data['access']=$result;
                $ptype = '';

                $data['rentby']=$this->session->userdata('session_id');

                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_fkid = '$rid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $rid = $result1[0]->txn_id;
                }

                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%Rent%' AND status = '1' AND tax_action='1'"); 
                $result=$query->result();
                $data['tax']=$result;

                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $txn_fkid = $result1[0]->txn_fkid;
                }

               /* if($txn_fkid!=''){
                    $data['property']=$this->purchase_model->purchaseData('All',$txn_fkid,'1');
                } else {
                    $data['property'] = $this->purchase_model->purchaseData('All',$rid,'1');
                }*/

                

                $result=$this->rent_model->rentData('All', '','',$rid);
                if(count($result)>0) {
                    $data['rent']=$result;
                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                    $property_id=$result[0]->property_id;
                    $gid=$result[0]->gp_id;
                    $result = $this->db->query("call sp_getPropertyOwners('Approved','$gid',$property_id)")->result();
                    mysqli_next_result( $this->db->conn_id );
                    $data['rent'][0]->owner_name=$result; 

                    /*$data['property'] = $this->db->query("Select * from property_txn Where  property_txn_id NOT IN((Select property_id from rent_txn)) 
                        and property_typ_id=1
                        OR  property_txn_id IN($property_id)")->result();*/

                    $result = $this->db->query("call sp_getpropertynorent(1,$property_id)")->result();
                    mysqli_next_result( $this->db->conn_id );
                    $data['property']=$result; 

                } else {
                    $txn_status=3;
                    $property_id='0';
                }

                

                $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                $result=$query->result();
                $data['contact_type']=$result;
                

                $distict_tax=$this->rent_model->getDistinctTaxDetail($rid, $txn_status);
                $data['tax_name']=$distict_tax;

                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;
                $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM rent_schedule 
                        WHERE rent_id = '".$rid."' and status = '$txn_status' GROUP BY event_type";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule']=array();

                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){                     
                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;

                        $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM rent_schedule_taxation 
                                                WHERE rent_id = '".$rid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                group by tax_type order by tax_type asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $j++;
                            }
                        }

                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM rent_schedule_taxation 
                                        WHERE rent_id = '".$rid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }

                $sql="SELECT * FROM rent_schedule  WHERE rent_id = '".$rid."' and status = '$txn_status' ";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule1']=array();
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row) {
                        $data['p_schedule1'][$k]['schedule_id']=$row->sch_id;
                        $data['p_schedule1'][$k]['event_type']=$row->event_type;
                        $data['p_schedule1'][$k]['event_name']=$row->event_name;
                        $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                        $data['p_schedule1'][$k]['event_date']=$row->event_date;

                        $query=$this->db->query("SELECT * FROM rent_schedule_taxation WHERE rent_id = '".$rid."' and sch_id = '".$row->sch_id."' and status = '$txn_status' order by tax_master_id Asc ");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule1'][$k]['tax_id'][$j]=$taxrow->txsc_id;
                                $data['p_schedule1'][$k]['tax_master_id'][$j]=$taxrow->tax_master_id;                            
                                $data['p_schedule1'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule1'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $data['p_schedule1'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                                $j++;
                            }
                        }
                        $k++;
                    }
                }

                $sql = "select A.* from rent_escalation_details A where A.rent_id = '$rid' order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['escalations']=$result;

                $sql = "select A.* from rent_pdc_details A where A.rent_id = '$rid' order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['pdcs']=$result;

                $sql = "select A.* from rent_other_amt_details A where A.rent_id = '$rid' order by A.id";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['other_amt_details']=$result;

                $data['utility'] = $this->rent_model->getPropertyUtilities($rid, $property_id);

                $sql = "select * from rent_notification_details where rent_id = '$rid'";
                /*$sql = "select A.*, B.notification_id, B.owner, B.tenant from 
                        (select * from notification_master) A 
                        left join 
                        (select * from rent_notification_details where rent_id = '$rid') B 
                        on (A.id = B.notification_id) order by A.id";*/
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['notification']=$result;

                $sql = "select sum(paid_amount) as paid_amount from actual_schedule where table_type='rent' and event_type='Deposit' and fk_txn_id='$rid' and txn_status='Approved'";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['deposit_paid_details']=$result;
                $data['r_id']=$rid;

                $pcolname="";
                $docs=$this->document_model->edit_view_doc($pcolname, $rid, 'Property_Rent', 'rent');
                $data=array_merge($data, $docs);

                $result = $this->db->query("call sp_GetTenant($rid,$gid)")->result();
                mysqli_next_result( $this->db->conn_id );
                $data['tenants']=$result;

                 $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid' and A.c_type='Tenants') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;

                $data['maker_checker'] = $this->session->userdata('maker_checker');

                load_view($view,$data);
            } else {
                echo "Unauthorized access";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function saverecord(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid' AND r_insert = 1");
        $result=$query->result();
        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');

            //maker_checker = no

            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $deposit_paid_date=$this->input->post('deposit_paid_date');
            if(validateDate($deposit_paid_date)) {
                $deposit_paid_date=FormatDate($deposit_paid_date);
            } else {
                $deposit_paid_date=null;
            }

            $possession_date=$this->input->post('possession_date');
            if(validateDate($possession_date)) {
                $possession_date=FormatDate($possession_date);
            } else {
                $possession_date=null;
            }

            $termination_date=$this->input->post('termination_date');
            if(validateDate($termination_date)) {
                $termination_date=FormatDate($termination_date);
            } else {
                $termination_date=null;
            }

            $invoice_date=$this->input->post('invoice_date');
            if(validateDate($invoice_date)) {
                $invoice_date=FormatDate($invoice_date);
            } else {
                $invoice_date=null;
            }

            $sub_property_id = $this->input->post('sub_property');
            if($sub_property_id==''){
                $sub_property_id = null;
            }

            $data = array(
                'gp_id' => $gid,
                'property_id' => $this->input->post('property'),
                'sub_property_id' => $sub_property_id,
                'tenant_id' => $this->input->post('owners'),
                'attorney_id'=>$this->input->post('attorney'),
                'rent_amount' => format_number($this->input->post('rent_amount'),2),
                'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                'deposit_paid_date' => $deposit_paid_date,
                'possession_date' => $possession_date,
                'lease_period' => format_number($this->input->post('lease_period'),2),
                'locking_period'=> format_number($this->input->post('locking_period'),2),
                'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                'termination_date' => $termination_date,
                'txn_status' => $txn_status,
                'create_date' => $now,
                'created_by' => $curusr,
                'modified_date' => $now,
                'modified_by' => $curusr,
                'maker_remark' => $this->input->post('maker_remark'),
                'maintenance_by' => $this->input->post('maintenance_by'),
                'property_tax_by' => $this->input->post('property_tax_by'),
                'notice_period' => $this->input->post('notice_period'),
                'category' => $this->input->post('category'),
                'schedule' => $this->input->post('schedule'),
                'invoice_date' => $invoice_date,
                'gst' => ($this->input->post('gst')=='yes'?'1':'0'),
                'gst_rate' => format_number($this->input->post('gst_rate'),2),
                'tds' => ($this->input->post('tds')=='yes'?'1':'0'),
                'tds_rate' => format_number($this->input->post('tds_rate'),2),
                'pdc' => ($this->input->post('pdc')=='yes'?'1':'0'),
                'deposit_category' => $this->input->post('deposit_category'),
                'rent_type' => $this->input->post('rent_type'),
                'rent_module_type' => $this->input->post('rent_module_type'),
                'revenue_percentage' => ($this->input->post('revenue_percentage')!=""?$this->input->post('revenue_percentage'):''),
                'revenue_due_day' => ($this->input->post('revenue_due_day')!=""?$this->input->post('revenue_due_day'):NULL),
                'advance_rent' => ($this->input->post('advance_rent')=='yes'?'1':'0'),
                'advance_rent_amount' => ($this->input->post('advance_rent_amount')!=""?format_number($this->input->post('advance_rent_amount'),2):'')
                 );


            $this->db->insert('rent_txn', $data);
            $rid=$this->db->insert_id();    
            //$this->db->last_query();        
            $logarray['table_id']=$rid;
            $logarray['module_name']='Rent';
            $logarray['cnt_name']='Rent';
            $logarray['action']='Rent Record Inserted';
            $logarray['gp_id']=$gid;
            $this->user_access_log_model->insertAccessLog($logarray);

            // $response_purchase_consideration=$this->rent_model->insertSchedule($rid, $txn_status);

            $this->rent_model->insertTenantDetails($rid);
            $this->rent_model->insertEscalationDetails($rid);
            $this->rent_model->insertPDCDetails($rid);
            $this->rent_model->insertUtilityDetails($rid);
            $this->rent_model->insertNotificationDetails($rid);

            $this->rent_model->insertOtherAmtDetails($rid);

            $this->document_model->insert_doc($rid, 'Property_Rent');

            $this->rent_model->setSchedule($rid, $txn_status);

            $this->rent_model->setOtherSchedule($rid, $txn_status);

            //$this->rent_model->send_rent_intimation($rid);
            if($this->input->post('revenue_due_day')!="")    
                $this->rent_model->revenueSchedule($rid,$this->input->post('property'));

            redirect(base_url().'index.php/Rent_real_estate');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function update($rid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($rid);
        } else  {
            $this->updaterecord($rid);
        }
    }

    public function approve($rid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
                $res=$query->result();
                if(count($res)>0) {
                    $rec_status = $res[0]->txn_status;
                    $txn_fkid = $res[0]->txn_fkid;
                    $gp_id = $res[0]->gp_id;
                } else {
                    $rec_status = 'In Process';
                    $txn_fkid = '';
                    $gp_id = $this->session->userdata('groupid');
                }

                if($this->input->post('submit')=='Approve') {
                    $txn_status='Approved';
                } else  {
                    $txn_status='Rejected';
                }
                $remarks = $this->input->post('status_remarks');

                if ($txn_status=='Rejected') {
                    $this->db->query("update rent_txn set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$rid'");

                    $logarray['table_id']=$rid;
                    $logarray['module_name']='Rent';
                    $logarray['cnt_name']='Rent';
                    $logarray['action']='Rent Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update rent_txn set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$rid'");
                        $this->db->query("update rent_schedule set sch_status = '1', status='1' WHERE rent_id = '$rid'");
                        $this->db->query("update rent_schedule_taxation set status='1' WHERE rent_id = '$rid'");

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update rent_txn A, rent_txn B set A.gp_id=B.gp_id, A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.tenant_id=B.tenant_id, 
                                         A.rent_amount=B.rent_amount, A.free_rent_period=B.free_rent_period, 
                                         A.deposit_amount=B.deposit_amount, A.deposit_paid_date=B.deposit_paid_date, 
                                         A.possession_date=B.possession_date, A.lease_period=B.lease_period, 
                                         A.rent_due_day=B.rent_due_day, A.termination_date=B.termination_date, 
                                         A.txn_status='$txn_status', A.create_date=B.create_date, A.created_by=B.created_by, 
                                         A.modified_date=B.modified_date, A.modified_by=B.modified_by, 
                                         A.approved_by='$curusr', A.approved_date='$modnow', 
                                         A.remarks='$remarks', A.rejected_by=B.rejected_by, 
                                         A.rejected_date=B.rejected_date, A.maker_remark=B.maker_remark, 
                                         A.maintenance_by=B.maintenance_by, A.property_tax_by=B.property_tax_by, 
                                         A.notice_period=B.notice_period, A.category=B.category, A.schedule=B.schedule, A.invoice_date=B.invoice_date, 
                                         A.gst=B.gst, A.gst_rate=B.gst_rate, A.tds=B.tds, A.tds_rate=B.tds_rate, A.pdc=B.pdc, 
                                         A.deposit_category=B.deposit_category, A.invoice_issuer=B.invoice_issuer 
                                         ,A.rent_type=B.rent_type,A.revenue_percentage=B.revenue_percentage,A.revenue_due_day=B.revenue_due_day,A.advance_rent=B.advance_rent,A.advance_rent_amount=B.advance_rent_amount,A.rent_module_type=B.rent_module_type,A.locking_period=B.locking_period
                                         WHERE B.txn_id = '$rid' and A.txn_id=B.txn_fkid");

                        $this->db->where('doc_ref_id', $txn_fkid);
                        $this->db->where('doc_ref_type', 'Property_Rent');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$txn_fkid' WHERE doc_ref_id = '$rid' and doc_ref_type = 'Property_Rent'");

                        $this->db->query("update rent_schedule set sch_status = '2', status='2' WHERE rent_id = '$txn_fkid' and (invoice_no is null || invoice_no='')");
                        $this->db->query("update rent_schedule set rent_id = '$txn_fkid', sch_status = '1', status='1' WHERE rent_id = '$rid'");

                        $this->db->query("update rent_schedule_taxation set status='2' WHERE rent_id = '$txn_fkid'");
                        $this->db->query("update rent_schedule_taxation set rent_id = '$txn_fkid', status='1' WHERE rent_id = '$rid'");

                        $this->db->where('rent_id', $txn_fkid);
                        $this->db->delete('rent_tenant_details');
                        $this->db->query("update rent_tenant_details set rent_id = '$txn_fkid' WHERE rent_id = '$rid'");

                        $this->db->query("delete from rent_txn WHERE txn_id = '$rid'");

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Rent_real_estate');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function updaterecord($rid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Rent' AND role_id='$roleid'");
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

            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_id = '$rid'");
            $res=$query->result();
            if(count($res)>0) {
                $rec_status = $res[0]->txn_status;
                $txn_fkid = $res[0]->txn_fkid;
                $gp_id = $res[0]->gp_id;
                $created_by = $res[0]->created_by;
                $create_date = $res[0]->create_date;
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

                            $this->db->query("update rent_txn set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE txn_id = '$rid'");
                            $logarray['table_id']=$rid;
                            $logarray['module_name']='Rent';
                            $logarray['cnt_name']='Rent';
                            $logarray['action']='Rent Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM rent_txn WHERE txn_fkid = '$rid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $rid = $result[0]->txn_id;

                                $this->db->query("Update rent_txn set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$rid'");
                                
                                $logarray['table_id']=$rid;
                                $logarray['module_name']='Rent';
                                $logarray['cnt_name']='Rent';
                                $logarray['action']='Rent Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into rent_txn (gp_id, property_id, sub_property_id, tenant_id, rent_amount, 
                                                 free_rent_period, deposit_amount, deposit_paid_date, possession_date, lease_period, 
                                                 rent_due_day, termination_date, txn_status, create_date, created_by, 
                                                 modified_date, modified_by, approved_by, approved_date, remarks, txn_fkid, 
                                                 rejected_by, rejected_date, attorney_id, maker_remark, maintenance_by, property_tax_by, 
                                                 notice_period, category, schedule, invoice_date, gst, gst_rate, tds, tds_rate, 
                                                 pdc, deposit_category, invoice_issuer,rent_type,revenue_percentage,revenue_due_day,advance_rent,advance_rent_amount,rent_module_type,locking_period) 
                                                 Select '$gp_id', property_id, sub_property_id, tenant_id, rent_amount, 
                                                 free_rent_period, deposit_amount, deposit_paid_date, possession_date, lease_period, 
                                                 rent_due_day, termination_date, '$txn_status', '$create_date', '$created_by', 
                                                 '$modnow', '$curusr', approved_by, approved_date, '$txnremarks', '$rid', 
                                                 rejected_by, rejected_date, attorney_id, maker_remark, maintenance_by, property_tax_by, 
                                                 notice_period, category, schedule, invoice_date, gst, gst_rate, tds, tds_rate, 
                                                 pdc, deposit_category, invoice_issuer,rent_type,revenue_percentage,revenue_due_day,advance_rent,advance_rent_amount,rent_module_type,locking_period 
                                                 FROM rent_txn WHERE txn_id = '$rid'");
                                $new_rid=$this->db->insert_id();

                                $logarray['table_id']=$rid;
                                $logarray['module_name']='Rent';
                                $logarray['cnt_name']='Rent';
                                $logarray['action']='Rent Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_rid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$rid' and doc_ref_type = 'Property_Rent'");

                                $query=$this->db->query("SELECT * FROM rent_schedule WHERE rent_id = '$rid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into rent_schedule (rent_id, event_name, event_type, event_date, basic_cost, 
                                                         net_amount, sch_status, create_date, create_by, modified_date, modified_by, status, 
                                                         invoice_no, invoice_date, tax_amount, tds_amount) 
                                                         Select '$new_rid', event_name, event_type, event_date, basic_cost, net_amount, '3', 
                                                         '$sch_create_date', '$sch_create_by', '$modnow', '$curusr', '3', 
                                                         invoice_no, invoice_date, tax_amount, tds_amount 
                                                         FROM rent_schedule WHERE rent_id = '$rid' and sch_id = '$sch_id' and 
                                                         (invoice_no is null or invoice_no='')");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into rent_schedule_taxation (sch_id, tax_master_id, tax_type, tax_percent, 
                                                         tax_amount, rent_id, event_type, status) 
                                                         Select '$new_sch_id', tax_master_id, tax_type, tax_percent, tax_amount, '$new_rid', 
                                                         event_type, '3' 
                                                         FROM rent_schedule_taxation WHERE rent_id = '$rid' and sch_id = '$sch_id'");
                                    }
                                }

                                $this->db->query("Insert into rent_tenant_details (rent_id, contact_id) 
                                                 Select '$new_rid', contact_id FROM rent_tenant_details WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_escalation_details (rent_id, esc_date, escalation) 
                                                 Select '$new_rid', esc_date, escalation FROM rent_escalation_details WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_pdc_details (rent_id, pdc_date, pdc_particular, pdc_amt, pdc_gst, 
                                                    pdc_tds, pdc_net_amt, pdc_chq_no, pdc_bank) 
                                                 Select '$new_rid', pdc_date, pdc_particular, pdc_amt, pdc_gst, 
                                                    pdc_tds, pdc_net_amt, pdc_chq_no, pdc_bank FROM rent_pdc_details 
                                                 WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_other_amt_details (rent_id, amount, due_day, schedule, 
                                                    invoice_date, gst, gst_rate, tds, tds_rate, invoice_issuer, event_name) 
                                                 Select '$new_rid', amount, due_day, schedule, invoice_date, gst, gst_rate, tds, tds_rate, 
                                                    invoice_issuer, event_name FROM rent_other_amt_details 
                                                    WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_utility_details (rent_id, utility_id, landlord, tenant, na) 
                                                 Select '$new_rid', utility_id, landlord, tenant, na FROM rent_utility_details 
                                                 WHERE rent_id = '$rid'");

                                $this->db->query("Insert into rent_notification_details (rent_id, notification_id, owner, tenant) 
                                                 Select '$new_rid', notification_id, owner, tenant FROM rent_notification_details 
                                                 WHERE rent_id = '$rid'");
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $rid);
                        $this->db->delete('rent_txn');

                        $this->db->where('doc_ref_id', $rid);
                        $this->db->where('doc_ref_type', 'Property_Rent');
                        $this->db->delete('document_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule_taxation');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_tenant_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_escalation_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_pdc_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_other_amt_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_utility_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_notification_details');

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Rent');
                } else {
                    echo "Unauthorized access.";
                }
            } else {

                    

                if($result[0]->r_edit==1) {
                    $deposit_paid_date=$this->input->post('deposit_paid_date');
                    if(validateDate($deposit_paid_date)) {
                        $deposit_paid_date=FormatDate($deposit_paid_date);
                    } else {
                        $deposit_paid_date=null;
                    }

                    $possession_date=$this->input->post('possession_date');
                    if(validateDate($possession_date)) {
                        $possession_date=FormatDate($possession_date);
                    } else {
                        $possession_date=null;
                    }

                    $termination_date=$this->input->post('termination_date');
                    if(validateDate($termination_date)) {
                        $termination_date=FormatDate($termination_date);
                    } else {
                        $termination_date=null;
                    }

                    $invoice_date=$this->input->post('invoice_date');
                    if(validateDate($invoice_date)) {
                        $invoice_date=FormatDate($invoice_date);
                    } else {
                        $invoice_date=null;
                    }


                    $data = array(
                    'gp_id' => $gid,
                    'property_id' => $this->input->post('property'),
                    'attorney_id'=>$this->input->post('attorney'),
                    'rent_amount' => format_number($this->input->post('rent_amount'),2),
                    'free_rent_period' => format_number($this->input->post('free_rent_period'),2),
                    'deposit_amount' => format_number($this->input->post('deposit_amount'),2),
                    'deposit_paid_date' => $deposit_paid_date,
                    'possession_date' => $possession_date,
                    'lease_period' => format_number($this->input->post('lease_period'),2),
                    'locking_period'=> format_number($this->input->post('locking_period'),2),
                    'rent_due_day' => format_number($this->input->post('rent_due_day'),2),
                    'termination_date' => $termination_date,
                    'txn_status' => $txn_status,
                    'maker_remark' => $this->input->post('maker_remark'),
                    'maintenance_by' => $this->input->post('maintenance_by'),
                    'property_tax_by' => $this->input->post('property_tax_by'),
                    'notice_period' => $this->input->post('notice_period'),
                    'category' => $this->input->post('category'),
                    'schedule' => $this->input->post('schedule'),
                    'invoice_date' => $invoice_date,
                    'gst' => ($this->input->post('gst')=='yes'?'1':'0'),
                    'gst_rate' => format_number($this->input->post('gst_rate'),2),
                    'tds' => ($this->input->post('tds')=='yes'?'1':'0'),
                    'tds_rate' => format_number($this->input->post('tds_rate'),2),
                    'pdc' => ($this->input->post('pdc')=='yes'?'1':'0'),
                    'deposit_category' => $this->input->post('deposit_category'),
                    'rent_type' => $this->input->post('rent_type'),
                    'rent_module_type' => $this->input->post('rent_module_type'),
                    'revenue_percentage' => ($this->input->post('revenue_percentage')!=""?$this->input->post('revenue_percentage'):''),
                    'revenue_due_day' => ($this->input->post('revenue_due_day')!=""?$this->input->post('revenue_due_day'):NULL),
                    'advance_rent' => ($this->input->post('advance_rent')=='yes'?'1':'0'),
                    'advance_rent_amount' => ($this->input->post('advance_rent_amount')!=""?format_number($this->input->post('advance_rent_amount'),2):'')
                     );
                    
                    /*Case 1 */
                    if ($rec_status=="Approved" && $maker_checker=='yes') {


                        $txn_fkid = $rid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('rent_txn',$data);
                        $rid=$this->db->insert_id();

                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                        /* It will be sent for approval */
                    } else {

                        /*Case 2   
                         -- if status != approved and maker checker is no dircet updated */

                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $rid);
                        $this->db->update('rent_txn',$data);

                        $logarray['table_id']=$rid;
                        $logarray['module_name']='Rent';
                        $logarray['cnt_name']='Rent';
                        $logarray['action']='Rent Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    /*IF rec_status is not approved && maker cehck is no previous entries is  deleted */
                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule');
                        
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_schedule_taxation');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_tenant_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_escalation_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_pdc_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_other_amt_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_utility_details');

                        $this->db->where('rent_id', $rid);
                        $this->db->delete('rent_notification_details');
                    }

                    // $this->rent_model->insertSchedule($rid, $txn_status);
                    /*For the entries which is appproved and send for approval new entries is created*/

                    $this->rent_model->insertTenantDetails($rid);
                    $this->rent_model->insertEscalationDetails($rid);
                    $this->rent_model->insertPDCDetails($rid);
                    $this->rent_model->insertUtilityDetails($rid);
                    $this->rent_model->insertNotificationDetails($rid);

                    $this->rent_model->insertOtherAmtDetails($rid);
                    
                    $this->document_model->insert_doc($rid, 'Property_Rent');

                    $this->rent_model->setSchedule($rid, $txn_status);

                    $this->rent_model->setOtherSchedule($rid, $txn_status);
                     if($this->input->post('revenue_due_day')!="")  
                     {
                        $this->db->where('rent_id', $rid);
                        $this->db->delete('revenue_schedule');    
                        $this->rent_model->revenueSchedule($rid,$this->input->post('property'));
                    
                     }
                        
                   redirect(base_url().'index.php/Rent_real_estate');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function revenue_sharing(){
        $currentdate = date("Y-m-d");

        $sql = "Select * from (select A.*, B.sch_id, B.event_type, B.event_name, B.event_date, B.basic_cost, B.net_amount from (select * from rent_txn where txn_status = 'Approved') A left join (select * from rent_schedule where status = '1' and event_type!='Deposit' ) B on (A.txn_id = B.rent_id) where B.sch_id is not null) as E Where tenant_id is not null and property_id is not null  GROUP BY txn_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        $this->db->last_query();
        if(count($result)>0){

            for($i=0; $i<count($result); $i++)
            {
                $r_id = $result[$i]->txn_id;
                $sch_id = $result[$i]->sch_id;
                $invoice_issuer = $result[$i]->invoice_issuer;
                $termination_date = $result[$i]->termination_date;
                $invoice_month =  date("F", strtotime($termination_date));
                 $termination_date1_40 =  date('Y-m-d',strtotime('-40 days',strtotime($termination_date)));
                 $termination_date1_30 =  date('Y-m-d',strtotime('-30 days',strtotime($termination_date)));
                 $termination_date1_10 =  date('Y-m-d',strtotime('-10 days',strtotime($termination_date)));

                $event_date = $result[$i]->event_date;
                $property_id = $result[$i]->property_id;
                if($property_id!=""){
                    $result_prop = $this->db->select("p_property_name")->where("txn_id=$property_id")->get("purchase_txn")->result();
                    if($result_prop>0)
                      $property_name=   $result_prop[0]->p_property_name;
                }
                $tenant_id = $result[$i]->tenant_id;
                $net_amount = $result[$i]->net_amount;
                 $owners = $this->purchase_model->get_property_owners($property_id);
                if(count($owners)>0){
                      $owner_name = $owners[0]->owner_name;
                      $owner_email = $owners[0]->c_emailid1;
                }

                $tenent = $this->get_contact_personname($tenant_id);
                if(count($tenent)>0){
                     $tenent_name = $tenent[0]->owner_name;
                     $tenent_email = $tenent[0]->c_emailid1;
                } 

                if($termination_date1_40==$currentdate || $termination_date1_30==$currentdate || $termination_date1_10==$currentdate)
                {   

                 $message= '<html>
                                  <head></head>
                                  <body>
                                    Hi, <br>
                                    <p>Please note lease term of <b>'.$property_name.'</b> property is expiring on <b>'.date('d-m-Y',strtotime($termination_date)).'</b></p>
                                    <p>Please ignore if already received.</p>
                                    <p>Regards,<br>
                                    Team Pecan Reams.</p>
                                    </body>
                             </html>'; 
                    $subject = "Lease expiring for  ".$property_name." property on  ".date('d-m-Y',strtotime($termination_date));
                    send_email($from_email='',"Pecan Reams", $owner_email, $subject, $message);
                    send_email($from_email='',$owner_name, $tenent_email, $subject, $message);
                }
                /*$tenant_id = 571;
                $tenent = $this->get_contact_personname($tenant_id);
                if(count($tenent)>0){
                     $tenent_name = $tenent[0]->owner_name;
                     $tenent_email = $tenent[0]->c_emailid1;
                }*/
            }
        }
    }
    
    public function checkstatus($status='', $property_type_id='', $property_id=''){
        $result=$this->rent_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $data['rent']=$this->rent_model->rentData($status, $property_type_id,'');
            $count_data=$this->rent_model->getallrentdatacount(1);

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

            if(count($data['rent'])>0)
            {
                foreach ($data['rent'] as $key => $value) {
                    $gid =  $value->gp_id;
                    $property_id =  $value->property_id;
                    $rid =  $value->txn_id;
                    $result = $this->db->query("call sp_getPropertyOwners('Approved','$gid',$property_id)")->result();
                    mysqli_next_result( $this->db->conn_id );
                    $data['rent'][$key]->owner_name=$result; 

                    $result = $this->db->query("call sp_GetTenant($rid,$gid)")->result();
                    mysqli_next_result( $this->db->conn_id );
                    $data['rent'][$key]->tenant_name=$result; 
                }


            }
            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);
            $data['checkstatus'] = $status;
            //$data['propertynorent']=$this->rent_model->getPropertyNotOnRent();
            $data['maker_checker'] = $this->session->userdata('maker_checker');
            

            load_view('Rent_real_estate/rent_real_estate_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

       

}
?>