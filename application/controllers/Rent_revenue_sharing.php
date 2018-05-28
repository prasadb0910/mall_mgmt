<?php
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Rent_revenue_sharing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->helper('common_functions');
        $this->load->model("rent_model");  
    }

    public function index() {
       $this->checkstatus('All');
      //$this->load->view('Rent_revenue_sharing/rent_revenue_list');
    }
  	public function add() {
         $data['property']= $this->rent_model->getPropertyDetails('',''); 
         load_view('Rent_revenue_sharing/rent_revenue_details',$data);
    }

     public function edit($rid){
        $this->get_record($rid, 'Rent_revenue_sharing/rent_revenue_details');
    }

    public function get_month()
    {
        $where = array("property_id"=>$this->input->post("property_id"),
                        "status"=>0);
        $result = $this->db->select("event_date,revenue_schedule_id")->where($where)->get('revenue_schedule')->result_array();
        foreach ($result as $key => $value) {
            $result[$key]['event_date']= date("F Y",strtotime($value['event_date']));
        }
        
        echo json_encode($result);
    } 

    public function save()
    {
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

        $property_id = $this->input->post('property_id');
        $revenue_id = $this->input->post('revenue_schedule_id');
        $revenue_amount = format_number($this->input->post('revenue_amount'),2);

        
        $this->db->select("revenue_percentage,txn_id,revenue_amount,rs.event_date");
        $this->db->join('revenue_schedule rs', 'rt.txn_id=rs.rent_id','left');
        $this->db->where("rs.revenue_schedule_id",$revenue_id);
        $result=$this->db->get("rent_txn rt")->result();

        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d');

        if($result)
        {
            $revenue_percentage = number_format($result[0]->revenue_percentage, 2);
            $newprice = ($revenue_amount * $revenue_percentage)/100;

            $data = array("event_name"=>'Revenue',
                          "event_type"=>'Revenue',
                          "rent_id" => $result[0]->txn_id,
                          "event_date"=>$result[0]->event_date,
                          "basic_cost"=>$newprice,
                          "net_amount"=>$newprice,
                          "net_amount"=>$newprice,
                          "create_date" => $now,
                          "create_by" => $curusr,
                          "sch_status" => $sch_status,
                          "status" => $sch_status);

            $this->db->insert('rent_schedule', $data);
            $insert_id = $this->db->insert_id();
            //$this->db->insert('rent_schedule');
            $where = array("revenue_schedule_id"=>$revenue_id);
            $set =   array("revenue_amount"=>$revenue_amount,
                           "updated_rent_scehdule_id"=>$insert_id,
                           "revenue_sharing_amount"=>$newprice,
                           "status"=>1);
            $this->db->where($where);
            $this->db->update("revenue_schedule",$set);
            //$this->db->last_query();
            redirect(base_url().'index.php/Rent_revenue_sharing');
        }

    }

    public function checkstatus($status='', $property_id=''){
          $result=$this->rent_model->getAccess();
          if(count($result)>0) {
              $data['access']=$result;
              $data['rent']=$this->rent_model->rent_revenue_sharing($status,$property_id);
              $count_data=$this->rent_model->getAllcount();
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
              

              load_view('Rent_revenue_sharing/rent_revenue_list', $data);

          } else {
              echo '<script>alert("You donot have access to this page.");</script>';
              $this->load->view('login/main_page');
          }
    }

    public function view($rent_id)
      {
         $this->get_record($rent_id, 'Rent_revenue_sharing/rent_revenue_view');
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

                  $data['r_id']=$rid;

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
                      $property_typ_id=$result[0]->property_typ_id;

                      $result = $this->db->query("Select * from property_txn Where property_txn_id  IN((Select property_id from rent_txn))")->result();
                      $data['property']=$result; 

                  } else {
                      $txn_status=3;
                      $property_id='0';
                  }

                  $data['maker_checker'] = $this->session->userdata('maker_checker');
                  $where = array("rent_id"=>$rid,"status"=>1);
                  $result1 = $this->db->select("event_date,revenue_schedule_id,revenue_amount")->where($where)->get('revenue_schedule')->result_array();
                  if(count( $result1)>0)
                  {
                    foreach ($result1 as $key => $value) {
                        $result1[$key]['event_date']= date("F Y",strtotime($value['event_date']));
                    }
                   $data['revenue_sharing']=$result1;
                  }

                  $where2 = array("rent_id"=>$rid,"status"=>0);
                  $pendings = $this->db->select("event_date")->where($where2)->get('revenue_schedule')->result_array();
                  if(count( $pendings)>0)
                  {
                    foreach ($pendings as $key => $value) {
                        $pendings[$key]['event_date']= date("F Y",strtotime($value['event_date']));
                    }
                   $data['revenue_sharing_pending']=$pendings;
                  }

                  load_view($view,$data);
              } else {
                  echo "Unauthorized access";
              }
          } else {
              echo '<script>alert("You donot have access to this page.");</script>';
              $this->load->view('login/main_page');
          }
    }

}
?>