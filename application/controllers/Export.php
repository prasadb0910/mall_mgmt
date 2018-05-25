<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Export extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the Library
        // $this->load->library("excel");
        // Load the Model
        $this->load->helper('common_functions');
        $this->load->model("export_model");
        $this->load->model("export_model_owner_level");
        $this->load->model("export_model_asset_level");
    }

    public function index() {
        // $this->excel->setActiveSheetIndex(0);
        // // Gets all the data using MY_Model.php
        // $data = $this->export_model->get_all();

        // $this->excel->stream('contact_details.xls', $data);



        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Users list');
 
        // load database
        // $this->load->database();
 
        // load model
        // $this->load->model('userModel');
 
        // get all users in array formate
        // $users = $this->userModel->get_users();
        $users = $this->export_model->get_all();
 
        // read data to active sheet
        $this->excel->getActiveSheet()->fromArray($users);
 
        $filename='just_some_random_name.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }

    public function set_report_criteria($rep_id){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                $data = array();
                if($rep_id==1){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Asset Allocation Owner Wise Report';
                    $data['sample_report_name'] = 'Group_Level_Asset_Allocation_-_Owner_Wise.xlsx';
                } else if($rep_id==2){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Asset Allocation Usage Wise Report';
                    $data['sample_report_name'] = 'Group_Level_Asset_Allocation_-_Usage_Wise.xlsx';
                } else if($rep_id==3){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Loan Details Report';
                    $data['sample_report_name'] = 'Group_Level_-_Loan_Details_Report.xlsx';
                } else if($rep_id==4){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Maintenance Property Tax Report';
                    $data['sample_report_name'] = 'Group_Level_-_Maintenance___Property_Tax_Report.xlsx';
                } else if($rep_id==5){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Related Party Report';
                    $data['sample_report_name'] = 'Group_Level_-_Related_Party_Reports.xlsx';
                } else if($rep_id==6){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Rent Summary Report';
                    $data['sample_report_name'] = 'Group_Level_-_Rent_Summary_Report.xlsx';
                } else if($rep_id==7){
                    $data['report_type'] = 'Owner Level';
                    $data['report_name'] = 'Owner Level Asset Allocation Usage Wise Report';
                    $data['sample_report_name'] = 'Owner_Level_Asset_Allocation_-_Usage_Wise.xlsx';
                } else if($rep_id==8){
                    $data['report_type'] = 'Owner Level';
                    $data['report_name'] = 'Owner Level Loan Details Report';
                    $data['sample_report_name'] = 'Owner_Level_-_Loan_Details_Report.xlsx';
                } else if($rep_id==9){
                    $data['report_type'] = 'Owner Level';
                    $data['report_name'] = 'Owner Level Related Party Report';
                    $data['sample_report_name'] = 'Owner_Level_-_Related_Party_Reports.xlsx';
                } else if($rep_id==10){
                    $data['report_type'] = 'Owner Level';
                    $data['report_name'] = 'Owner Level Rent Summary Report';
                    $data['sample_report_name'] = 'Owner_Level_-_Rent_Summary_Report.xlsx';
                } else if($rep_id==11){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Profitability Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Profitability_Report.xlsx';
                    $data['txn_type'] = 'Sale';
                    $data['purchase_data'] = $this->export_model_asset_level->get_sale_properties();
                } else if($rep_id==12){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Purchase Variance Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Purchase_Variance_Report.xlsx';
                    $data['txn_type'] = 'Purchase';
                    $data['purchase_data'] = $this->export_model_asset_level->getProperty();
                } else if($rep_id==13){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Related Party Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Related_Party_Reports.xlsx';
                    $data['txn_type'] = 'Purchase';
                    $data['purchase_data'] = $this->export_model_asset_level->getProperty();
                } else if($rep_id==14){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Rent Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Rent_Report.xlsx';
                    $data['txn_type'] = 'Rent';
                    $data['purchase_data'] = $this->export_model_asset_level->get_rent_properties();
                } else if($rep_id==15){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Sale Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Sale_Report.xlsx';
                    $data['txn_type'] = 'Sale';
                    $data['purchase_data'] = $this->export_model_asset_level->get_sale_properties();
                } else if($rep_id==16){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Sale Variance Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Sale_Variance_Report.xlsx';
                    $data['txn_type'] = 'Sale';
                    $data['purchase_data'] = $this->export_model_asset_level->get_sale_properties();
                } else if($rep_id==17){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Purchase Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Purchase_Details_Report_TBG.xlsx';
                    $data['txn_type'] = 'Purchase';
                    $data['purchase_data'] = $this->export_model_asset_level->getProperty();
                } else if($rep_id==18){
                    $data['report_type'] = 'Asset Level';
                    $data['report_name'] = 'Asset Level Loan Report';
                    $data['sample_report_name'] = 'Asset_Level_-_Loan_Report_TBG.xlsx';
                    $data['txn_type'] = 'Purchase';
                    $data['purchase_data'] = $this->export_model_asset_level->get_loan_properties();
                } else if($rep_id==19){
                    $data['report_type'] = 'Group Level';
                    $data['report_name'] = 'Group Level Sale Details Report';
                    $data['sample_report_name'] = 'Group_Level_-_Sale_Details_Report.xlsx';
                } else if($rep_id==20){
                    $data['report_type'] = 'Owner Level';
                    $data['report_name'] = 'Owner Level Sale Details Report';
                    $data['sample_report_name'] = 'Owner_Level_-_Sale_Details_Report.xlsx';
                }

                $data['report_id'] = $rep_id;
                $data['owner'] = $this->export_model_owner_level->get_owners();

                load_view('reports/download_report',$data);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function generate_report($rep_id) {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        if(isset($roleid)){
            $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Reports' AND role_id='$roleid' AND r_view = 1");
            $result=$query->result();
            if(count($result)>0) {
                if($rep_id==1) {
                    $this->export_model->generate_group_level_asset_alloc_owner_wise_report();
                } else if($rep_id==2) {
                    $this->export_model->generate_group_level_asset_alloc_usage_wise_report();
                } else if($rep_id==3) {
                    $this->export_model->generate_group_level_loan_details_report();
                } else if($rep_id==4) {
                    $this->export_model->generate_group_level_maintenance_property_tax_report();
                } else if($rep_id==5) {
                    $this->export_model->generate_group_level_related_party_report();
                } else if($rep_id==6) {
                    $this->export_model->generate_group_level_rent_summary_report();
                } else if($rep_id==7) {
                    $this->export_model_owner_level->generate_owner_level_asset_alloc_usage_wise_report();
                } else if($rep_id==8) {
                    $this->export_model_owner_level->generate_owner_level_loan_details_report();
                } else if($rep_id==9) {
                    $this->export_model_owner_level->generate_owner_level_related_party_report();
                } else if($rep_id==10) {
                    $this->export_model_owner_level->generate_owner_level_rent_summary_report();
                } else if($rep_id==11) {
                    $this->export_model_asset_level->generate_asset_level_profitability_report();
                } else if($rep_id==12) {
                    $this->export_model_asset_level->generate_asset_level_purchase_variance_report();
                } else if($rep_id==13) {
                    $this->export_model_asset_level->generate_asset_level_related_party_report();
                } else if($rep_id==14) {
                    $this->export_model_asset_level->generate_asset_level_rent_report();
                } else if($rep_id==15) {
                    $this->export_model_asset_level->generate_asset_level_sale_report();
                } else if($rep_id==16) {
                    $this->export_model_asset_level->generate_asset_level_sale_variance_report();
                } else if($rep_id==17) {
                    $this->export_model_asset_level->generate_asset_level_purchase_report();
                } else if($rep_id==18) {
                    $this->export_model_asset_level->generate_asset_level_loan_report();
                } else if($rep_id==19) {
                    $this->export_model->generate_group_level_sale_details_report();
                } else if($rep_id==20) {
                    $this->export_model_owner_level->generate_owner_level_sale_details_report();
                }
                
                $this->set_report_criteria($rep_id);
            } else {
                echo '<script>alert("You donot have access to this page.");</script>';
                $this->load->view('login/main_page');
            }
        } else {
            echo '<script>alert("You donot have access to this page.");</script>';
            $this->load->view('login/main_page');
        }
    }

    public function get_sub_property() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $property_id = html_escape($this->input->post('property_id'));
        $txn_type = html_escape($this->input->post('txn_type'));

        if($txn_type=="Sale") {
            $sql = "select * from sub_property_allocation where property_id = '$property_id' and txn_status = 'Approved' and 
                    txn_id in(select distinct sub_property_id from sales_txn where property_id = '$property_id' and txn_status = 'Approved')";
        } else if($txn_type=="Rent") {
            $sql = "select * from sub_property_allocation where property_id = '$property_id' and txn_status = 'Approved' and 
                    txn_id in(select distinct sub_property_id from rent_txn where property_id = '$property_id' and txn_status = 'Approved')";
        } else {
            $sql = "";
        }
        
        $sub_property_list="";

        if ($sql != "") {
            $query=$this->db->query($sql);
            $result=$query->result();

            if (count($result)>0) {
                $sub_property_list = '<option value="">Select Sub Property</option>';

                foreach ($result as $row) {
                    $sub_property_list = $sub_property_list . '<option value="' . $row->txn_id . '">' . $row->sp_name . '</option>';
                }
            }

            if($sub_property_list == '<option value="">Select Sub Property</option>'){
                $sub_property_list="";
            }
        }
        

        echo $sub_property_list;
    }
}
 ?>