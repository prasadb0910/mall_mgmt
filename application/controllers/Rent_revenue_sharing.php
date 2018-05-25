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
       $this->load->view('Rent_revenue_sharing/rent_revenue_list');
    }
	public function add() {
       $data['property']= $this->rent_model->getPropertyDetails(); 
       load_view('Rent_revenue_sharing/rent_revenue_details',$data);
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

}
?>