<?php
/* 
 * File Name: group_list.php
 */
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Sale extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model('sales_model');
        $this->load->model('transaction_model');
        $this->load->model('document_model');
    }

    public function index() {
        $this->checkstatus('All');
    }

    public function loadsaledocuments($pid) {
        $document_details=null;

        $query=$this->db->query("SELECT * FROM purchase_txn WHERE txn_id = '$pid'");
        $result=$query->result();

        if (count($result)>0) {
            $pcolname="";
            $ptype=$result[0]->p_type;

            if($ptype=='Building'){
                $pcolname="d_type_building";
            } else if($ptype=='Apartment'){
                $pcolname="d_type_apartment";
            } else if($ptype=='Bunglow'){
                $pcolname="d_type_bunglow";
            } else if($ptype=='Commercial'){
                $pcolname="d_type_commercial";
            } else if($ptype=='Retail'){
                $pcolname="d_type_retail";
            } else if($ptype=='Industrial'){
                $pcolname="d_type_industry";
            } else if($ptype=='Land-Agriculture'){
                $pcolname="d_type_landagriculture";
            } else if($ptype=='Land-Non Agriculture'){
                $pcolname="d_type_landnonagricultural";
            } 

            if ($pcolname!="") {
                // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%sale%' and " . $pcolname . " = 'Yes'");
                // $result=$query->result();
                // $i=0;
                
                // foreach ($result as $row) {
                //     $document_details[$i] = array("d_id"=> $row->d_id, "d_m_status"=> $row->d_m_status, "d_documentname"=> $row->d_documentname, "d_description"=> $row->d_description);
                //     $i=$i+1;
                // }

                // $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                //                         (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                //                         (select * from document_details where doc_ref_id='$pid' and doc_ref_type='Property_Purchase') A 
                //                         left join 
                //                         (select * from document_type_master) B 
                //                         on (A.doc_type_id=B.d_type_id)) C 
                //                         left join 
                //                         (select * from document_master) D 
                //                         on (C.doc_doc_id=D.d_id)");
                // $result=$query->result();
                // $data['documents']=$result;

                // for($i=0; $i<count($result); $i++){
                //     $d_type_id = $result[$i]->d_type_id;

                //     $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                //                             (select * from document_types where d_type_id='$d_type_id') A 
                //                             left join 
                //                             (select * from document_master where d_t_type like '%sale%' and $pcolname='Yes') B 
                //                             on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                //     $data['docs'][$d_type_id]=$query->result();
                // }

                $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                                        '' as doc_documentname, '' as d_show_expiry_date, 
                                        '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                                        '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
                                        from document_type_master");
                $result=$query->result();
                $data['documents']=$result;

                for($i=0; $i<count($result); $i++){
                    $d_type_id = $result[$i]->d_type_id;

                    $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                                            (select * from document_types where d_type_id='$d_type_id') A 
                                            left join 
                                            (select * from document_master where d_t_type like '%sale%' and $pcolname='Yes') B 
                                            on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                    $data['docs'][$d_type_id]=$query->result();
                }
            }
        }

        // echo json_encode($document_details);
        $document_data=$this->load->view('templates/document_dynamic',$data,true);
        $returnarray=array('status'=>true,"data"=>$document_data);
        echo json_encode($returnarray);
    }

    public function addnew(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $result=$this->sales_model->getAccess();
        if(count($result)>0) {
            $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%sale%' AND status = '1' AND tax_action='1'");
            $result=$query->result();
            $data['tax']=$result;
            $data['tax_details']=$this->sales_model->getAllTaxes();

            $data['property']= $this->sales_model->getPropertyDetails();

            // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%Sale%'");
            // $result=$query->result();
            // $data['docs']=$result;

            // $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
            //                         '' as doc_documentname, '' as d_show_expiry_date, 
            //                         '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
            //                         '' as doc_doe, '' as doc_document, '' as document_name, '' as doc_doc_name 
            //                         from document_type_master");
            // $result=$query->result();
            // $data['documents']=$result;

            // for($i=0; $i<count($result); $i++){
            //     $d_type_id = $result[$i]->d_type_id;

            //     $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
            //                             (select * from document_types where d_type_id='$d_type_id') A 
            //                             left join 
            //                             (select * from document_master where d_t_type like '%sale%') B 
            //                             on (A.d_id=B.d_id)) C where C.d_documentname is not null");

            //     $data['docs'][$d_type_id]=$query->result();
            // }

            // $query=$this->db->query("select * from document_type_master");
            // $result=$query->result();
            // $data['doc_types']=$result;

            // $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
            // $result=$query->result();
            // $data['contact_type']=$result;

            $docs=$this->document_model->add_new_doc('', 'sale');
            $data=array_merge($data, $docs);

            $sql = "select * from 
                    (select A.c_id, case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
            $query=$this->db->query($sql);
            $result=$query->result();
            $data['contact']=$result;

            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('sale/sales_details',$data);
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function loadpropertydet($pid) {
        $query=$this->db->query("select sum(net_amount) as cost_of_purchase from purchase_schedule where purchase_id = '$pid' and sch_status = '1'");
        $result=$query->result();

        echo $result[0]->cost_of_purchase;
    }

    public function validateDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function getindex($date) {
        $index = 0;

        if ($this->validateDate($date)) {
            $date=FormatDate($date);

            $year = substr($date, 0, 4);
            $month = date("m", strtotime($date));
            if ($month<=3) {
                $end_year = $year;
                $start_year = intval($year) - 1;
            } else {
                $start_year = $year;
                $end_year = intval($year) + 1;
            }

            $financial_year = $start_year . '-' . substr($end_year,2);
            // echo $financial_year;

            $query=$this->db->query("SELECT * FROM indexation_master WHERE i_financial_year = '$financial_year'");
            $result=$query->result();

            if (count($result)>0) {
                $index = $result[0]->i_cost_inflation_index;
                $index = str_replace(",", "", $index);
            } else {
                $index = 0;
            }
        }

        return $index;
    }

    public function getcostofacquisition() {
        $sldt=$this->input->post('sale_date');

        if($sldt==''){
            $sldt=NULL;
        }

        $slindex = $this->getindex($sldt);
        if (is_numeric ($slindex)) {
            $slindex = floatval($slindex);
        } else {
            $slindex = 0;
        }

        $pid = $this->input->post('property');
        
        $query=$this->db->query("SELECT sum(net_amount) as cost_of_purchase FROM purchase_schedule WHERE purchase_id = '$pid' and status = '1'");
        $result=$query->result();
        if (count($result)>0) {
            $cost_of_purchase=$result[0]->cost_of_purchase;
            if (is_numeric ($cost_of_purchase)) {
                $cost_of_purchase = floatval($cost_of_purchase);
            } else {
                $cost_of_purchase = 0;
            }
        } else {
            $cost_of_purchase = 0;
        }

        $query=$this->db->query("SELECT txn_id, DATE_FORMAT(p_purchase_date,'%d/%m/%Y') as p_purchase_date FROM purchase_txn WHERE txn_id = '$pid'");
        $result=$query->result();
        if (count($result)>0) {
            $p_purchase_date=$result[0]->p_purchase_date;
            $prindex = $this->getindex($p_purchase_date);
            if (is_numeric ($prindex)) {
                $prindex = floatval($prindex);
            } else {
                $prindex = 0;
            }
        } else {
            $prindex = 0;
        }

        $prindex = ($prindex==0)?1:$prindex;
        $cost_of_acqisition = $cost_of_purchase * ($slindex/$prindex);

        echo $cost_of_acqisition;
    }

   public function get_sub_property() {
        $property_id = html_escape($this->input->post('property_id'));
        $txn_id = html_escape($this->input->post('txn_id'));

        $query=$this->db->query("SELECT * FROM sales_txn WHERE txn_id='$txn_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sub_property_id = $result[0]->sub_property_id;
        } else {
            $sub_property_id = '0';
        }

        $query=$this->db->query("SELECT * FROM sub_property_allocation WHERE property_id='$property_id' AND txn_status='Approved'");
        $result=$query->result();

        $result= $this->sales_model->getSubPropertyDetails($txn_id, $property_id);

        if(count($result)>0)
        {
          $result1['sub_property']=$result;
          $result1['sub_property_id']=  $sub_property_id;
          echo json_encode($result1);
        }
        else
        {
            echo 0;
        }


        /*$sub_property_list = '<option value="" Selected>Select Sub Property</option>';

        foreach ($result as $row) {
            if ($sub_property_id == $row->sp_id) {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '" selected>' . $row->sp_name . '</option>';
            } else {
                $sub_property_list = $sub_property_list . '<option value="' . $row->sp_id . '">' . $row->sp_name . '</option>';
            }
        }

        echo $sub_property_list;*/
    }

    public function saverecord(){
        $result=$this->sales_model->getAccess();

        if(count($result)>0) {
            $now=date('Y-m-d H:i:s');
            $modnow=date('Y-m-d H:i:s');

            $sldt=$this->input->post('sale_date');
            if($sldt==''){
                $sldt=NULL;
            } else {
                $sldt=FormatDate($sldt);
            }
            if($this->input->post('submit')=='Submit For Approval') {
                $txn_status='Pending';
            } else if($this->input->post('submit')=='Submit') {
                $txn_status='Approved';
            } else  {
                $txn_status='In Process';
            }

            $pid=$this->sales_model->insertRecord($sldt, $txn_status); // insert record in to table sales_txn
            $response_sales_consideration=$this->sales_model->insertSchedule($pid, $txn_status);//create Schedule
            $sales_ownership_details=$this->sales_model->insertBuyerDetails($pid);
            
            $this->sales_model->insertImage($pid);

            // $this->transaction_model->insertRPDetails($pid, 'sale');
            // $this->transaction_model->insertPendingActivity($pid, 'sale');

            $this->document_model->insert_doc($pid, 'Property_Sale');

            redirect(base_url().'index.php/Sale');
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function edit($pid){
        $this->get_record($pid, 'sale/sales_details');
    }

    public function view($pid){
        $this->get_record($pid, 'sale/sales_view');
    }

    public function get_record($pid, $view){
        $data['tax_details']=$this->sales_model->getAllTaxes();

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $data['saleby']=$this->session->userdata('session_id');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sale' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit==1 or $result[0]->r_approvals==1) {
                $data['access']=$result;
                $ptype = '';

                $query=$this->db->query("SELECT * FROM sales_txn WHERE txn_fkid = '$pid'");
                $result1=$query->result();
                if (count($result1)>0){
                    $pid = $result1[0]->txn_id;
                }

                $query=$this->db->query("SELECT * FROM tax_master WHERE txn_type like '%sale%' AND status = '1' AND tax_action='1'");
                $result=$query->result();
                $data['tax']=$result;
                
                $data['property']= $this->sales_model->getPropertyDetails($pid);

                // $query=$this->db->query("SELECT * FROM document_master WHERE d_t_type like '%Sale%'");
                // $result=$query->result();
                // $data['docs']=$result;

                // $query=$this->db->query("select C.*, D.sp_name from 
                //                         (select A.*, B.p_property_name, B.p_display_name, B.p_type from 
                //                         (select * from sales_txn where txn_id = '$pid') A 
                //                         left join 
                //                         (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') B 
                //                         on A.property_id = B.txn_id) C 
                //                         left join 
                //                         (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') D 
                //                         on C.sub_property_id = D.txn_id");
                // $result=$query->result();
                // $data['s_txn']=$result;

                $result= $this->sales_model->salesData('All','',$pid);
                $data['s_txn']=$result;
                if(count($result)>0) {
                    $ptype = $result[0]->p_type;

                    if ($result[0]->txn_status=="Approved") {
                        $txn_status=1;
                    } else {
                        $txn_status=3;
                    }
                    $property_id=$result[0]->property_id;
                } else {
                    $txn_status=3;
                    $property_id='0';
                }
                
                $data['sub_property']= $this->sales_model->getSubPropertyDetails($pid, $property_id);

                $query=$this->db->query("SELECT A.*, B.c_name, B.c_last_name, B.c_emailid1, B.c_mobile1, B.owner_name FROM 
                                        (SELECT * FROM purchase_ownership_details WHERE purchase_id = '$property_id') A 
                                        LEFT JOIN 
                                        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                                            case when A.c_owner_type='individual' 
                                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                        where A.c_status='Approved' and A.c_gid='$gid') B 
                                        ON (A.pr_client_id=B.c_id)");
                $result=$query->result();
                $data['s_owner']=$result;

                $query=$this->db->query("SELECT A.*, B.c_name, B.c_last_name, B.c_emailid1, B.c_mobile1, B.owner_name FROM 
                                        (SELECT * FROM sales_buyer_details WHERE sale_id = '$pid') A 
                                        LEFT JOIN 
                                        (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                                            case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                                            case when A.c_owner_type='individual' 
                                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                                        where A.c_status='Approved' and A.c_gid='$gid') B 
                                        ON (A.buyer_id=B.c_id)");
                $result=$query->result();
                $data['s_buyer']=$result;

                $distict_tax=$this->sales_model->getDistinctTaxDetail($pid, $txn_status);
                $data['tax_name']=$distict_tax;
                $event_type='';
                $event_name='';
                $basic_amount=0;
                $net_amount=0;
                $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM sales_schedule 
                    WHERE sale_id = '".$pid."' and status = '$txn_status' GROUP BY event_type";
                
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['p_schedule1']=array();

                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){                     
                        $data['p_schedule1'][$k]['event_type']=$row->event_type;
                        $data['p_schedule1'][$k]['event_name']=$event_name;
                        $data['p_schedule1'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule1'][$k]['net_amount']=$row->net_amount;
                        //  $data['p_schedule1'][$k]['sch_pay_type']=$row->sch_pay_type;
                        // $data['p_schedule1'][$k]['sch_agree_value']=$row->sch_agree_value;
                        $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM sales_schedule_taxation 
                                                WHERE sale_id = '".$pid."' and event_type = '".$row->event_type."' and status = '$txn_status' 
                                                group by tax_type order by tax_type asc");
                        $result_tax=$query->result();
                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule1'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule1'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                                $j++;
                            }
                        }

                        $k++;
                    }
                }

                $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM sales_schedule_taxation 
                                        WHERE sale_id = '".$pid."'  and status = '$txn_status' group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                $k=0;
                foreach($result_tax as $row){
                    $data['total_tax_amount'][$k]=$row->total_tax_amount;
                    $k++;
                }

                $query=$this->db->query("SELECT * FROM sales_schedule WHERE sale_id = '$pid' and status = '$txn_status' ");
                $result=$query->result();
                $data['p_schedule']=array();
               
                $k=0;
                if(count($result)>0) {
                    foreach($result as $row){
                        $data['p_schedule'][$k]['schedule_id']=$row->sch_id;
                        $data['p_schedule'][$k]['event_type']=$row->event_type;
                        $data['p_schedule'][$k]['event_name']=$row->event_name;
                        $data['p_schedule'][$k]['basic_cost']=$row->basic_cost;
                        $data['p_schedule'][$k]['net_amount']=$row->net_amount;
                        $data['p_schedule'][$k]['event_date']=$row->event_date;
                        //  $data['p_schedule'][$k]['sch_pay_type']=$row->sch_pay_type;
                        // $data['p_schedule'][$k]['sch_agree_value']=$row->sch_agree_value;

                        $query=$this->db->query("SELECT * FROM sales_schedule_taxation WHERE sale_id = '$pid' and sch_id = '$row->sch_id' and status = '$txn_status' order by tax_master_id Asc ");
                        $result_tax=$query->result();

                        $j=0;
                        if(count($result_tax) > 0){
                            foreach($result_tax as $taxrow){
                                $data['p_schedule'][$k]['tax_id'][$j]=$taxrow->txsc_id;
                                $data['p_schedule'][$k]['tax_master_id'][$j]=$taxrow->tax_master_id;                            
                                $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                                $data['p_schedule'][$k]['tax_amount'][$j]=$taxrow->tax_amount;
                                $data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                        $j++;
                            }
                        }

                        $k++;
                    }
                } 

                // $query=$this->db->query("SELECT A.*, B.d_m_status FROM (SELECT * FROM sales_document_details WHERE sl_doc_saleid = '$pid') A LEFT JOIN (SELECT * FROM document_master) B ON (A.fk_d_id=B.d_id)");
                // $result=$query->result();

                // if(count($result)>0) {
                //     $data['editdocs']=$result;
                // }

                if($ptype=='Building'){
                    $pcolname="d_type_building";
                } else if($ptype=='Apartment'){
                    $pcolname="d_type_apartment";
                } else if($ptype=='Bunglow'){
                    $pcolname="d_type_bunglow";
                } else if($ptype=='Commercial'){
                    $pcolname="d_type_commercial";
                } else if($ptype=='Retail'){
                    $pcolname="d_type_retail";
                } else if($ptype=='Industrial'){
                    $pcolname="d_type_industry";
                } else if($ptype=='Land-Agriculture'){
                    $pcolname="d_type_landagriculture";
                } else if($ptype=='Land-NonAgriculture'){
                    $pcolname="d_type_landnonagricultural";
                } else {
                    $pcolname="";
                }

                $docs=$this->document_model->edit_view_doc($pcolname, $pid, 'Property_Sale', 'sale');
                $data=array_merge($data, $docs);

                // $query=$this->db->query("select C.*, D.d_documentname as doc_documentname, d_show_expiry_date from 
                //                         (select A.*, B.d_type_id, B.d_type, B.d_m_status from 
                //                         (select * from document_details where doc_ref_id='$pid' and doc_ref_type='Property_Sale') A 
                //                         left join 
                //                         (select * from document_type_master) B 
                //                         on (A.doc_type_id=B.d_type_id)) C 
                //                         left join 
                //                         (select * from document_master) D 
                //                         on (C.doc_doc_id=D.d_id)");
                // $result=$query->result();
                // $data['documents']=$result;

                // if(count($result)>0){
                //     for($i=0; $i<count($result); $i++){
                //         $d_type_id = $result[$i]->d_type_id;

                //         $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                //                                 (select * from document_types where d_type_id='$d_type_id') A 
                //                                 left join 
                //                                 (select * from document_master where d_t_type like '%sale%' and $pcolname='Yes') B 
                //                                 on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                //         $data['docs'][$d_type_id]=$query->result();
                //     }
                // } else {
                //     $query=$this->db->query("select d_type_id, d_type, d_m_status, '' as doc_doc_id, 
                //                             '' as doc_documentname, '' as d_show_expiry_date, 
                //                             '' as doc_description, '' as doc_ref_no, '' as doc_doi, 
                //                             '' as doc_doe, '' as doc_document, '' as document_name 
                //                             from document_type_master");
                //     $result=$query->result();
                //     $data['documents']=$result;

                //     for($i=0; $i<count($result); $i++){
                //         $d_type_id = $result[$i]->d_type_id;

                //         $query=$this->db->query("select * from (select A.d_id, B.d_documentname from 
                //                                 (select * from document_types where d_type_id='$d_type_id') A 
                //                                 left join 
                //                                 (select * from document_master where d_t_type like '%sale%') B 
                //                                 on (A.d_id=B.d_id)) C where C.d_documentname is not null");

                //         $data['docs'][$d_type_id]=$query->result();
                //     }
                // }

                // $query=$this->db->query("select * from document_type_master");
                // $result=$query->result();
                // $data['doc_types']=$result;


                $sql = "select * from 
                        (select A.c_id, case when A.c_owner_type='individual' 
                            then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                            else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as contact_name 
                        from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                        where A.c_status='Approved' and A.c_gid='$gid') A order by A.contact_name";
                $query=$this->db->query($sql);
                $result=$query->result();
                $data['contact']=$result;


                // $query=$this->db->query("SELECT * FROM contact_type_master where g_id = '$gid' order by id desc");
                // $result=$query->result();
                // $data['contact_type']=$result;

                // $sql = "select A.*, B.contact_name, B.c_contact_type, B.contact_type from
                //         (select * from related_party_details where ref_id = '$pid' and type = 'sale') A 
                //         left join 
                //         (select * from 
                //         (select A.c_id, A.c_contact_type, B.contact_type, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',
                //             ifnull(A.c_emailid1,''),' - ',ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',
                //             ifnull(B.contact_type,'')) as contact_name from 
                //         (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
                //         left join 
                //         (select * from contact_type_master where g_id='$gid') B 
                //         on A.c_contact_type = B.id) C) B 
                //         on A.contact_id = B.c_id";
                // $query=$this->db->query($sql);
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['related_party']=$result;
                // }

                // $query=$this->db->query("SELECT * FROM pending_activity WHERE ref_id = '$pid' and type = 'sale'");
                // $result=$query->result();
                // if(count($result)>0){
                //     $data['pending_activity']=$result;
                // }

                $data['s_id']=$pid;

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

    public function update($pid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($pid);
        } else  {
            $this->updaterecord($pid);
        }
    }

    public function updaterecord($pid){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');
        $maker_checker = $this->session->userdata('maker_checker');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sale' AND role_id='$roleid'");
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

            $query=$this->db->query("SELECT * FROM sales_txn WHERE txn_id = '$pid'");
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

                            $this->db->query("update sales_txn set txn_status='$txn_status', remarks='$txnremarks', modified_by='$curusr', 
                                            modified_date='$modnow' WHERE txn_id = '$pid'");
                            $logarray['table_id']=$pid;
                            $logarray['module_name']='Sale';
                            $logarray['cnt_name']='Sale';
                            $logarray['action']='Sale Record ' . $txn_status;
                            $logarray['gp_id']=$gid;
                            $this->user_access_log_model->insertAccessLog($logarray);
                        } else {
                            $query=$this->db->query("SELECT * FROM sales_txn WHERE txn_fkid = '$pid'");
                            $result=$query->result();
                            if (count($result)>0){
                                $pid = $result[0]->txn_id;

                                $this->db->query("Update sales_txn set txn_status='$txn_status', remarks='$txnremarks', 
                                                 modified_date='$modnow', modified_by='$curusr' 
                                                 WHERE txn_id = '$pid'");
                                $logarray['table_id']=$pid;
                                $logarray['module_name']='Sale';
                                $logarray['cnt_name']='Sale';
                                $logarray['action']='Sale Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);
                            } else {
                                $this->db->query("Insert into sales_txn (property_id, sub_property_id, date_of_sale, 
                                                 sales_consideration, cost_of_purchase, cost_of_acquisition, 
                                                 profit_loss, gp_id, txn_status, created_by, create_date, modified_by, 
                                                 modified_date, approved_by, approved_date, remarks, sales_consideration, 
                                                 txn_fkid, rejected_by, rejected_date, maker_remark, p_image, p_image_name) 
                                                 Select property_id, sub_property_id, date_of_sale, 
                                                 sales_consideration, cost_of_purchase, cost_of_acquisition, 
                                                 profit_loss, '$gp_id', '$txn_status', '$created_by', '$create_date', '$curusr', 
                                                 '$modnow', approved_by, approved_date, '$txnremarks', sales_consideration, 
                                                 '$pid', rejected_by, rejected_date, maker_remark, p_image, p_image_name 
                                                 FROM sales_txn WHERE txn_id = '$pid'");
                                $new_pid=$this->db->insert_id();

                                $logarray['table_id']=$pid;
                                $logarray['module_name']='Sale';
                                $logarray['cnt_name']='Sale';
                                $logarray['action']='Sale Record Delete (sent for approval)';
                                $logarray['gp_id']=$gid;
                                $this->user_access_log_model->insertAccessLog($logarray);

                                $this->db->query("Insert into sales_buyer_details (sale_id, buyer_id, share_percent) 
                                                 Select '$new_pid', buyer_id, share_percent 
                                                 FROM sales_buyer_details WHERE sale_id = '$pid'");

                                // $this->db->query("Insert into sales_document_details (sl_doc_saleid, sl_doc_name, sl_doc_description, 
                                //                  sl_doc_ref_no, sl_doc_doi, sl_doc_doe, sl_document, sl_document_name, fk_d_id) 
                                //                  Select '$new_pid', sl_doc_name, sl_doc_description, 
                                //                  sl_doc_ref_no, sl_doc_doi, sl_doc_doe, sl_document, sl_document_name, fk_d_id 
                                //                  FROM sales_document_details WHERE sl_doc_saleid = '$pid'");

                                $this->db->query("Insert into document_details (doc_ref_id, doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name)  
                                                 Select '$new_pid', doc_ref_type, doc_type_id, doc_doc_id, 
                                                 doc_description, doc_ref_no, doc_doi, doc_doe, doc_document, document_name 
                                                 FROM document_details WHERE doc_ref_id = '$pid' and doc_ref_type = 'Property_Sale'");

                                $query=$this->db->query("SELECT * FROM sales_schedule WHERE sale_id = '$pid'");
                                $result=$query->result();
                                if (count($result)>0){
                                    for($i=0; $i<count($result); $i++) {
                                        $sch_id = $result[$i]->sch_id;
                                        $sch_create_date = $result[$i]->create_date;
                                        $sch_create_by = $result[$i]->create_by;

                                        $this->db->query("Insert into sales_schedule (sale_id, event_name, event_type, event_date, basic_cost, 
                                                         net_amount, sch_status, create_date, create_by, modified_date, modified_by, status) 
                                                         Select '$new_pid', event_name, event_type, event_date, basic_cost, net_amount, '3', 
                                                         '$sch_create_date', '$sch_create_by', '$modnow', '$cursur', '3' 
                                                         FROM sales_schedule WHERE sale_id = '$pid' and sch_id = '$sch_id'");
                                        $new_sch_id=$this->db->insert_id();

                                        $this->db->query("Insert into sales_schedule_taxation (sch_id, tax_master_id, tax_type, tax_percent, 
                                                         tax_amount, sale_id, event_type, '3') 
                                                         Select '$new_sch_id', tax_master_id, tax_type, tax_percent, tax_amount, '$new_pid', event_type, status 
                                                         FROM sales_schedule_taxation WHERE sale_id = '$pid' and sch_id = '$sch_id'");
                                    }
                                }

                                $this->db->query("Insert into related_party_details (ref_id, type, contact_id, remarks) 
                                                 Select '$new_pid', type, contact_id, remarks FROM related_party_details 
                                                 WHERE ref_id = '$pid' and type = 'sale'");

                                $this->db->query("Insert into pending_activity (ref_id, type, pending_activity) 
                                                 Select '$new_pid', type, pending_activity FROM pending_activity 
                                                 WHERE ref_id = '$pid' and type = 'sale'");
                            }
                        }
                    } else {
                        $this->db->where('txn_id', $pid);
                        $this->db->delete('sales_txn');

                        $this->db->where('sale_id', $pid);
                        $this->db->delete('sales_buyer_details');

                        // $this->db->where('sl_doc_saleid', $pid);
                        // $this->db->delete('sales_document_details');

                        $this->db->where('doc_ref_id', $pid);
                        $this->db->where('doc_ref_type', 'Property_Sale');
                        $this->db->delete('document_details');

                        $this->db->where('sale_id', $pid);
                        $this->db->delete('sales_schedule');

                        $this->db->where('sale_id', $pid);
                        $this->db->delete('sales_schedule_taxation');

                        $this->db->where('ref_id', $pid);
                        $this->db->where('type', 'sale');
                        $this->db->delete('related_party_details');

                        $this->db->where('ref_id', $pid);
                        $this->db->where('type', 'sale');
                        $this->db->delete('pending_activity');

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Sale';
                        $logarray['cnt_name']='Sale';
                        $logarray['action']='Sale Record Deleted';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    redirect(base_url().'index.php/Sale');
                } else {
                    echo "Unauthorized access.";
                }
            } else {
                if($result[0]->r_edit==1) {
                    $sldt=$this->input->post('sale_date');
                    if($sldt==''){
                        $sldt=NULL;
                    } else {
                        $sldt=FormatDate($sldt);
                    }

                    // echo '<script>alert("' . $sldt . '");</script>';

                    $sub_property_id = $this->input->post('sub_property');
                    if($sub_property_id==''){
                        $sub_property_id = null;
                    }

                    $data = array(
                                'gp_id' => $gp_id,
                                'property_id' => $this->input->post('property'),
                                'sub_property_id' => $sub_property_id,
                                'date_of_sale' => $sldt,
                                // 'sale_price' => format_number($this->input->post('saleamount'),2),
                                // 'registeration_amt' => format_number($this->input->post('registeration'),2),
                                // 'stamp_duty' => format_number($this->input->post('stampduty'),2),
                                'sales_consideration' => format_number($this->input->post('sales_consideration'),2),
                                'cost_of_purchase' => format_number($this->input->post('cost_purchase'),2),
                                'cost_of_acquisition' => format_number($this->input->post('cost_of_acquisition'),2),
                                'profit_loss' => format_number($this->input->post('profit_loss'),2),
                                'txn_status' => $txn_status,
                                'maker_remark' => $this->input->post('maker_remark')
                            );

                    if ($rec_status=="Approved" && $maker_checker=='yes') {
                        $txn_fkid = $pid;
                        $data['txn_fkid'] = $txn_fkid;
                        $data['create_date'] = $create_date;
                        $data['created_by'] = $created_by;
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->insert('sales_txn',$data);
                        $pid=$this->db->insert_id();

                        $sql = "update sales_txn A, sales_txn B set A.p_image = B.p_image, A.p_image_name = B.p_image_name 
                                where A.txn_id = '$pid' and B.txn_id = '$txn_fkid'";
                        $this->db->query($sql);
                        
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Sale';
                        $logarray['cnt_name']='Sale';
                        $logarray['action']='Sale Approved Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);

                        // $this->db->query("Insert into sales_document_details (sl_doc_saleid, sl_doc_name, 
                        //                  sl_doc_description, sl_doc_ref_no, sl_doc_doi, sl_doc_doe, sl_document, 
                        //                  sl_document_name, fk_d_id) 
                        //                  Select '$pid', sl_doc_name, sl_doc_description, sl_doc_ref_no, sl_doc_doi, 
                        //                  sl_doc_doe, sl_document, sl_document_name, fk_d_id FROM sales_document_details 
                        //                  WHERE sl_doc_saleid = '$txn_fkid'");
                    } else {
                        $data['modified_date'] = $modnow;
                        $data['modified_by'] = $curusr;

                        $this->db->where('txn_id', $pid);
                        $this->db->update('sales_txn',$data);

                        $logarray['table_id']=$pid;
                        $logarray['module_name']='Sale';
                        $logarray['cnt_name']='Sale';
                        $logarray['action']='Sale Record Updated';
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }

                    if ($rec_status!="Approved" || $maker_checker!='yes') {
                        $this->db->where('sale_id', $pid);
                        $this->db->delete('sales_buyer_details');

                        $this->db->where('sale_id', $pid);
                        $this->db->delete('sales_schedule');
                        
                        $this->db->where('sale_id', $pid);
                        $this->db->delete('sales_schedule_taxation');

                        $this->db->where('ref_id', $pid);
                        $this->db->where('type', 'sale');
                        $this->db->delete('related_party_details');
                        
                        $this->db->where('ref_id', $pid);
                        $this->db->where('type', 'sale');
                        $this->db->delete('pending_activity');
                    }

                    $this->sales_model->insertBuyerDetails($pid);
                    $this->sales_model->insertSchedule($pid, $txn_status);

                    $this->sales_model->insertImage($pid);

                    // $this->transaction_model->insertRPDetails($pid, 'sale');
                    // $this->transaction_model->insertPendingActivity($pid, 'sale');

                    $this->document_model->insert_doc($pid, 'Property_Sale');

                    redirect(base_url().'index.php/Sale');
                } else {
                    echo "Unauthorized access";
                }
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function approve($sid) {
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $gid=$this->session->userdata('groupid');
        $now=date('Y-m-d H:i:s');
        $modnow=date('Y-m-d H:i:s');

        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Sale' AND role_id='$roleid'");
        $result=$query->result();
        if(count($result)>0) {
            if($result[0]->r_edit == 1 || $result[0]->r_approvals == 1) {
                $query=$this->db->query("SELECT * FROM sales_txn WHERE txn_id = '$sid'");
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
                    $this->db->query("update sales_txn set txn_status='Rejected', remarks='$remarks', rejected_by='$curusr', rejected_date='$modnow' WHERE txn_id = '$sid'");

                    $logarray['table_id']=$sid;
                    $logarray['module_name']='Sale';
                    $logarray['cnt_name']='Sale';
                    $logarray['action']='Sale Record ' . $txn_status;
                    $logarray['gp_id']=$gid;
                    $this->user_access_log_model->insertAccessLog($logarray);
                } else {
                    if ($txn_fkid=='' || $txn_fkid==null) {
                        $this->db->query("update sales_txn set txn_status='Approved', remarks='$remarks', approved_by='$curusr', approved_date='$modnow' WHERE txn_id = '$sid'");
                        $this->db->query("update sales_schedule set sch_status = '1', status='1' WHERE sale_id = '$sid'");
                        $this->db->query("update sales_schedule_taxation set status='1' WHERE sale_id = '$sid'");

                        $logarray['table_id']=$sid;
                        $logarray['module_name']='Sale';
                        $logarray['cnt_name']='Sale';
                        $logarray['action']='Sale Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    } else {
                        if ($rec_status=='Delete') {
                            $txn_status='Inactive';
                        }
                        $this->db->query("update sales_txn A, sales_txn B set A.property_id=B.property_id, 
                                         A.sub_property_id=B.sub_property_id, A.date_of_sale=B.date_of_sale, 
                                         A.sales_consideration=B.sales_consideration, A.cost_of_purchase=B.cost_of_purchase, 
                                         A.cost_of_acquisition=B.cost_of_acquisition, A.profit_loss=B.profit_loss, 
                                         A.gp_id=B.gp_id, A.txn_status='$txn_status', A.created_by=B.created_by, 
                                         A.create_date=B.create_date, A.modified_by=B.modified_by, 
                                         A.modified_date=B.modified_date, A.approved_by='$curusr', 
                                         A.approved_date='$modnow', A.remarks='$remarks', 
                                         A.sales_consideration=B.sales_consideration, 
                                         A.rejected_by=B.rejected_by, A.rejected_date=B.rejected_date, 
                                         A.maker_remark=B.maker_remark, A.p_image=B.p_image, A.p_image_name=B.p_image_name 
                                         WHERE B.txn_id = '$sid' and A.txn_id=B.txn_fkid");

                        $this->db->where('sale_id', $txn_fkid);
                        $this->db->delete('sales_buyer_details');
                        $this->db->query("update sales_buyer_details set sale_id = '$txn_fkid' WHERE sale_id = '$sid'");

                        // $this->db->where('sl_doc_saleid', $txn_fkid);
                        // $this->db->delete('sales_document_details');
                        // $this->db->query("update sales_document_details set sl_doc_saleid = '$txn_fkid' WHERE sl_doc_saleid = '$sid'");

                        $this->db->where('doc_ref_id', $txn_fkid);
                        $this->db->where('doc_ref_type', 'Property_Sale');
                        $this->db->delete('document_details');
                        $this->db->query("update document_details set doc_ref_id = '$txn_fkid' WHERE doc_ref_id = '$sid' and doc_ref_type = 'Property_Sale'");

                        $this->db->query("update sales_schedule set sch_status = '2', status='2' WHERE sale_id = '$txn_fkid'");
                        $this->db->query("update sales_schedule set sale_id = '$txn_fkid', sch_status = '1', status='1' WHERE sale_id = '$sid'");

                        $this->db->query("update sales_schedule_taxation set status='2' WHERE sale_id = '$txn_fkid'");
                        $this->db->query("update sales_schedule_taxation set sale_id = '$txn_fkid', status='1' WHERE sale_id = '$sid'");

                        $this->db->where('ref_id', $txn_fkid);
                        $this->db->where('type', 'sale');
                        $this->db->delete('related_party_details');
                        $this->db->query("update related_party_details set ref_id = '$txn_fkid' WHERE ref_id = '$sid' and type = 'sale'");

                        $this->db->where('ref_id', $txn_fkid);
                        $this->db->where('type', 'sale');
                        $this->db->delete('pending_activity');
                        $this->db->query("update pending_activity set ref_id = '$txn_fkid' WHERE ref_id = '$sid' and type = 'sale'");

                        $this->db->query("delete from sales_txn WHERE txn_id = '$sid'");
                            
                        $logarray['table_id']=$txn_fkid;
                        $logarray['module_name']='Sale';
                        $logarray['cnt_name']='Sale';
                        $logarray['action']='Sale Record ' . $txn_status;
                        $logarray['gp_id']=$gid;
                        $this->user_access_log_model->insertAccessLog($logarray);
                    }
                }

                redirect(base_url().'index.php/Sale');
            } else {
                echo "Unauthorized access.";
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function checkstatus($status=''){
        $result=$this->sales_model->getAccess();
        if(count($result)>0) {
            $data['access']=$result;
            $sales_data=$this->sales_model->salesData($status);
            $data['sales']=$sales_data;

            $count_data=$this->sales_model->getAllCountData();
            $approved=0;
            $pending=0;
            $rejected=0;
            $inprocess=0;

            if (count($result)>0){
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

            $data['approved']=$approved;
            $data['pending']=$pending;
            $data['rejected']=$rejected;
            $data['inprocess']=$inprocess;
            $data['all']=count($count_data);

            $data['checkstatus'] = $status;
            $data['maker_checker'] = $this->session->userdata('maker_checker');

            load_view('sale/sales_list', $data);

        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    function insertTempSchedule(){
        $response=$this->sales_model->insertTempSchedule();
        //print_r($response);
        $schedule_data=$this->load->view('sale/schedule_temp_view',$response,true);
        //echo $schedule_data;
        $returnarray=array('status'=>true,"data"=>$schedule_data,"total_net_amount"=>$response['total_net_amount']);
        echo json_encode($returnarray);
    }

    function getTaxDetailsCalculation(){
        // $tax_id = [1,2,5];
        // $sch_basiccost = 2019480;
        // $response=$this->sales_model->getTaxDetailsCalculation($tax_id,$sch_basiccost);
        // echo json_encode($response);

        // echo format_number(2322401,2);

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $sch_type=$this->input->post('sch_type');
        $sch_event=$this->input->post('sch_event');
        $sch_date=$this->input->post('sch_date');
        $sch_basiccost=$this->input->post('sch_basiccost');
        // $sch_pay_type=$this->input->post('sch_pay_type');
        // $sch_agree_value=$this->input->post('sch_agree_value');   
        $pid=uniqid(4);         
        // print_r($sch_type);
        for ($i=0; $i < count($sch_event) ; $i++) {
            //echo "date".$sch_date[$i];
            //echo "hi";
            if($sch_date[$i]==NULL){
                $scdt=NULL;
            } else {
                //echo $sch_date[$i];
                 $scdt=formatdate($sch_date[$i]);
                //exit;
            }
            $sch_tax='';
             $sch_tax=$this->input->post('sch_tax_'.($i+1));
           //  echo count($sch_tax);

            $sch_basiccost[$i]=format_number($sch_basiccost[$i],2);
            if(count($sch_tax) > 0) {
                $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);

                $data = array(   
                        'txn_type'=>$pid,                
                        'event_type'=>$sch_type[$i],
                        'event_name' => $sch_event[$i],
                        'event_date' => $scdt ,
                        'basic_cost' => format_number($sch_basiccost[$i],2) ,
                        'net_amount' => format_number($tax_detail["netamount"],2),
                        // 'sch_pay_type'=>$sch_pay_type[$i],
                        // 'sch_agree_value'=>$sch_agree_value[$i+1],
                        'create_date' => date('Y-m-d'),
                        'created_by' => $curusr,
                        'sch_status'=>'1',
                        'status'=>'1'
                        );
            } else {
                $data = array(   
                        'txn_type'=>$pid,                
                        'event_type'=>$sch_type[$i],
                        'event_name' => $sch_event[$i],
                        'event_date' => $scdt ,
                        // 'sch_pay_type'=>$sch_pay_type[$i],
                        // 'sch_agree_value'=>$sch_agree_value[$i+1],                   
                        'basic_cost' => format_number($sch_basiccost[$i],2),
                        'net_amount' => format_number($sch_basiccost[$i],2),
                        'create_date' => date('Y-m-d'),
                        'created_by' => $curusr,
                        'sch_status'=>'1',
                        'status'=>'1'
                        );
            }

            $this->db->insert('temp_schedule', $data);
            $scid=$this->db->insert_id();
            $scid_array[]=$scid;
            if(count($sch_tax) > 0){
                $tax_detail=$this->getTaxDetailsCalculation($sch_tax,$sch_basiccost[$i]);
                $j=0;
                foreach($tax_detail['tax_detail'] as $row){
                    // print_r($tax_detail['tax_detail'][$j]);

                    //$tax_array=explode(',',$sch_tax[$j]);

                    $data = array(
                            'sch_id' => $scid,
                            'event_type' => $sch_type[$i],
                            'tax_master_id'=> $tax_detail['tax_detail'][$j]['tax_id'],
                            'tax_type' => $tax_detail['tax_detail'][$j]['tax_type'],
                            'tax_percent' => format_number($tax_detail['tax_detail'][$j]['tax_percent'],2),
                            'tax_amount' => format_number($tax_detail['tax_detail'][$j]['tax_amount'],2),                            
                            'create_date' => date('Y-m-d'),
                            'created_by' => $curusr,
                            'pur_id'=>$pid,
                            'status'=>'1'
                             );
                    $this->db->insert('temp_schedule_taxation', $data);  
                    $j++;
                }
            }
        }

        //code for display
        $this->db->select('tax_type');
        $this->db->where('pur_id = "'.$pid.'" and status = "1" ');
        $this->db->from('temp_schedule_taxation');
        $this->db->group_by('tax_type');
        $this->db->order_by('tax_type','Asc');
        $result_dist=$this->db->get();
        // echo $this->db->last_query();
        $distict_tax=$result_dist->result();
        $data['tax_name']=$distict_tax;
        $event_type='';
        $event_name='';
        $basic_amount=0;
        $net_amount=0;
        $sql="SELECT event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM temp_schedule 
            WHERE txn_type = '".$pid."' and status = '1' GROUP BY event_type";
        // $sql="SELECT sch_pay_type,sch_agree_value,event_type,sum(basic_cost) as basic_cost,sum(net_amount) as net_amount FROM temp_schedule  WHERE txn_type = '".$pid."' and status = '1' GROUP BY event_type";
        //$query=$this->db->query("SELECT * FROM temp_schedule WHERE txn_type = '".$pid."' and status = '1' ");
        $query=$this->db->query($sql);
        $result=$query->result();
        $data['p_schedule']=array();
        //echo $pid;           
        $k=0;
        $total_net_amount=0;
        if(count($result)>0) {
            foreach($result as $row){
                $data['p_schedule'][$k]['event_type']=$row->event_type;
                $data['p_schedule'][$k]['event_name']=$event_name;
                // $data['p_schedule'][$k]['sch_pay_type']=$row->sch_pay_type;
                // $data['p_schedule'][$k]['sch_agree_value']=$row->sch_agree_value;
                $data['p_schedule'][$k]['basic_cost']=format_money($row->basic_cost,2);
                $data['p_schedule'][$k]['net_amount']=format_money($row->net_amount,2);
                    //distint tax name
                // $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM temp_schedule_taxation WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '1' group by tax_type order by tax_master_id asc ");
                $query=$this->db->query("SELECT tax_type,sum(tax_amount) as tax_amount FROM temp_schedule_taxation 
                                        WHERE pur_id = '".$pid."' and event_type = '".$row->event_type."' and status = '1' 
                                        group by tax_type order by tax_type asc ");
                $result_tax=$query->result();
                $j=0;
                if(count($result_tax) > 0){
                    foreach($result_tax as $taxrow){
                        $data['p_schedule'][$k]['tax_type'][$j]=$taxrow->tax_type;
                        $data['p_schedule'][$k]['tax_amount'][$j]=format_money($taxrow->tax_amount,2);
                        //$data['p_schedule'][$k]['tax_percent'][$j]=$taxrow->tax_percent;
                        $j++;
                    }
                }


                $total_net_amount=$total_net_amount+$row->net_amount;

                //$data['p_schtxn']=$result;
                $k++;
            }
        }
            
        $query=$this->db->query("SELECT tax_type, sum(tax_amount) as total_tax_amount FROM temp_schedule_taxation 
                                WHERE pur_id = '".$pid."'  and status = '1' 
                                group by tax_type order by tax_type asc ");
        $result_tax=$query->result();
        //echo $this->db->last_query();
        $k=0;
        foreach($result_tax as $row){
            $data['total_tax_amount'][$k]=format_money($row->total_tax_amount,2);
            $k++;
        }
        $data['total_net_amount']=format_money($total_net_amount,2);
        // print_r($scid_array);
        return $data;
    }
}
?>