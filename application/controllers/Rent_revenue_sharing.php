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

    public function edit($rid,$revenue_id=''){
      $this->get_record($rid, 'Rent_revenue_sharing/rent_revenue_details',$revenue_id);
    }

    public function get_month()
    {   
        if($this->input->post('edit')==1)
            $where = array("property_id"=>$this->input->post("property_id"));
        else
            $where = array("property_id"=>$this->input->post("property_id"),
                        "status"=>0);

        $this->db->select("event_date,revenue_schedule_id");
        $this->db->where($where);
        $result = $this->db->get('revenue_schedule')->result_array();
        foreach ($result as $key => $value) {
            $result[$key]['event_date']= date("F Y",strtotime($value['event_date']));
        }
        
        echo json_encode($result);
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

        if($txn_status=='Approved'){
            $sch_status = '1';
        } else {
            $sch_status = '3';
        }

        $property_id = $this->input->post('property_id');
        $revenue_id = $this->input->post('revenue_schedule_id');
        $revenue_amount = format_number($this->input->post('revenue_amount'),2);

        
        $this->db->select("revenue_percentage,txn_id,revenue_amount,rs.event_date,rent_id");
        $this->db->join('revenue_schedule rs', 'rt.txn_id=rs.rent_id','left');
        $this->db->where("rs.revenue_schedule_id",$revenue_id);
        $result=$this->db->get("rent_txn rt")->result();

        $curusr=$this->session->userdata('session_id');
        $now=date('Y-m-d');

        if($result)
        {
            $revenue_percentage = number_format($result[0]->revenue_percentage, 2);
            $newprice = ($revenue_amount * $revenue_percentage)/100;

            $event_data = $result[0]->event_date;
            $rent_id = $result[0]->rent_id;
            $rv_amount =$newprice;    

            $time=strtotime($event_data);
            echo $month=date("m",$time);
            echo $year=date("Y",$time);
  
            /*$data = array("event_name"=>'Revenue',
                          "event_type"=>'Revenue',
                          "rent_id" => $result[0]->txn_id,
                          "event_date"=>$result[0]->event_date,
                          "basic_cost"=>$newprice,
                          "net_amount"=>$newprice,
                          "net_amount"=>$newprice,
                          "create_date" => $now,
                          "create_by" => $curusr,
                          "sch_status" => $sch_status,
                          "status" => $sch_status);*/
            $result1 = $this->db->query("Select * from  rent_schedule  WHERE MONTH(event_date) = '$month' AND YEAR(event_date) = '$year' and rent_id='$rent_id'  and event_type='Rent'")->result();
             $this->db->last_query();
             $txn_id = $result1[0]->rent_id;
              $sch_id = $result1[0]->sch_id;
              $net_amount = $result1[0]->net_amount;
              $total_amount = $net_amount+$rv_amount;

            $data = array("revenue_amount"=>$rv_amount,'total_amount'=>$total_amount);
            $this->db->where('MONTH(event_date)',$month);
            $this->db->where('YEAR(event_date)',$year);
            $this->db->where('rent_id',$rent_id);
            $this->db->where('event_type','Rent');
            $this->db->update('rent_schedule', $data) ; 
            $this->db->last_query();
           
            /*$this->db->insert('rent_schedule', $data);
            $insert_id = $this->db->insert_id();*/
            //$this->db->insert('rent_schedule');
            $where = array("revenue_schedule_id"=>$revenue_id);
            $set =   array("revenue_amount"=>$revenue_amount,
                           "updated_rent_scehdule_id"=>$sch_id,
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
              $count_data=$this->rent_model->countAllrevenuesharing();
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

    public function get_record($rid, $view,$revenue_id=''){
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
                  
                  $sql = "Select rt.*,pt.unit_name,pt.area,pt.area_unit,pt.floor,pt.unit_name,pt.unit_no,pt.unit_type,pd.pr_client_id,pt.p_image,pt.property_typ_id
                    from rent_txn rt
                    left join property_txn pt on rt.property_id=pt.property_txn_id
                    left join purchase_ownership_details pd on pt.property_txn_id=pd.purchase_id
                    Where rt.property_id NOT IN(Select property_id from sales_txn) and rt. txn_status <> 'Inactive' and rt.gp_id='$gid' and rt.revenue_percentage!=0;";
                  $query=$this->db->query($sql);
                  $result=$query->result();/*
                  $result=$this->rent_model->rentData('All', '','',$rid);*/
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
                  if($revenue_id!="")
                    $where['revenue_schedule_id']=$revenue_id;
                  $result1 = $this->db->select("event_date,revenue_schedule_id,revenue_amount,property_id,revenue_sharing_amount")->where($where)->get('revenue_schedule')->result_array();
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

    public function updaterecord($r_id)
    {
      $gid=$this->session->userdata('groupid');
      $roleid=$this->session->userdata('role_id');
      $curusr=$this->session->userdata('session_id');
      $modnow=date('Y-m-d H:i:s');
      $maker_checker = $this->session->userdata('maker_checker');

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
         $rent_id = $result[0]->txn_id;
         $event_date = $result[0]->event_date;
         /*$result1 = $this->db->query("Select rent_id,ac.event_name from rent_schedule rs
                        left join actual_schedule ac on rs.rent_id=ac.fk_txn_id
                        Where  ac.event_date='$event_date' and ac.event_name=rs.event_name and rs.event_type=ac.event_type
                        and table_type ='Revenue' and ac.fk_txn_id=$rent_id")->result();*/
          $revenue_percentage = number_format($result[0]->revenue_percentage, 2);
          $newprice = ($revenue_amount * $revenue_percentage)/100;

          $time=strtotime($event_date);
          $month=date("m",$time);
          $year=date("Y",$time);
          
          $result1 = $this->db->query("Select * from  rent_schedule  WHERE MONTH(event_date) = '$month' AND YEAR(event_date) = '$year' and rent_id='$rent_id'  and event_type='Rent'")->result();
           $this->db->last_query();
           $txn_id = $result1[0]->rent_id;
           $sch_id = $result1[0]->sch_id;
           $net_amount = $result1[0]->net_amount;
           $total_amount = $net_amount+$rv_amount;

          $data = array("revenue_amount"=>$rv_amount,'total_amount'=>$total_amount);
          $this->db->where('MONTH(event_date)',$month);
          $this->db->where('YEAR(event_date)',$year);
          $this->db->where('rent_id',$rent_id);
          $this->db->where('event_type','Rent');
          $this->db->update('rent_schedule', $data) ; 
          $this->db->last_query();

          /*$data = array("event_name"=>'Revenue',
                        "event_type"=>'Revenue',
                        "rent_id" => $result[0]->txn_id,
                        "event_date"=>$result[0]->event_date,
                        "basic_cost"=>$newprice,
                        "net_amount"=>$newprice,
                        "net_amount"=>$newprice,
                        "create_date" => $now,
                        "create_by" => $curusr);

          $where = array("rent_id"=>$result[0]->txn_id);
          $this->db->where($where);
          $this->db->update('rent_schedule', $data);
          $insert_id = $this->db->insert_id();*/

          $where = array("revenue_schedule_id"=>$revenue_id);
          $set =   array("revenue_amount"=>$revenue_amount,
                         "updated_rent_scehdule_id"=>$result[0]->txn_id,
                         "revenue_sharing_amount"=>$newprice,
                         "status"=>1);
          $this->db->where($where);
          $this->db->update("revenue_schedule",$set);
         
          redirect(base_url().'index.php/Rent_revenue_sharing/add');
      }

    }

    public function check_revenue()
    {
      $revenue_id = $this->input->post('revenue_id');
      $this->db->select("revenue_percentage,txn_id,revenue_amount,rs.event_date");
      $this->db->join('revenue_schedule rs', 'rt.txn_id=rs.rent_id','left');
      $this->db->where("rs.revenue_schedule_id",$revenue_id);
      $result=$this->db->get("rent_txn rt")->result();
      $this->db->last_query();

      $rent_id = $result[0]->txn_id;
      $event_date = $result[0]->event_date;

      $result = $this->db->query("Select rent_id,ac.event_name from rent_schedule rs
                        left join actual_schedule ac on rs.rent_id=ac.fk_txn_id
                        Where  ac.event_date='$event_date' and ac.event_name=rs.event_name and rs.event_type=ac.event_type
                        and table_type ='Revenue' and ac.fk_txn_id=$rent_id")->result();
     if(count($result)==0)
        echo 0;
      else
        echo 1;

    }

    public function update($rid) {
        if($this->input->post('submit')=='Approve' || $this->input->post('submit')=='Reject') {
            $this->approve($rid);
        } else  {
            $this->updaterecord($rid);
        }
    }

   public function approve($revenue_id)
   {
      $where['revenue_schedule_id']=$revenue_id;
      $result1 = $this->db->select("event_date,revenue_schedule_id,revenue_amount,property_id,rent_id")->where($where)->get('revenue_schedule')->result_array();
      $event_date = $result1[0]['event_date'];
      $rent_id = $result1[0]['rent_id'];

      $rent_schedule = $this->db->query("Select * from rent_schedule Where event_type='Revenue' and event_name='Revenue'  and event_date='$event_date' and rent_id='$rent_id' ")->result_array();
      echo $this->db->last_query();
      dump($rent_schedule);
      die();
   }

}
?>