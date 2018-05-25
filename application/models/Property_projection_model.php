<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Property_projection_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
}

function getAgreementArea($property_id){
    $this->db->select('pr_agreement_area');
    $this->db->from('purchase_property_description');
    $this->db->where('purchase_id = '.$property_id.' ');
    $result=$this->db->get();
    if($result->num_rows() > 0){
        $agreement_area=$result->row()->pr_agreement_area;

    }
    else{
        $agreement_area=0;
    }
    return array("status"=>true,"agreement_area"=>$agreement_area);
}

function getAllTaxes(){
    $this->db->select('tax_id,tax_name,tax_percent,txn_type');
    $this->db->where('status = "1" and txn_type like "%valuation%" and tax_action="1"');
    $this->db->from('tax_master');
    $result=$this->db->get();
    return $result->result();
}

function getDetails($id){
    if($id !=''){
        $cond = " where id = '$id'";
    } else {
        $cond = "";
    }

    $sql = "select E.*, F.tax_name from 
            (select C.*, D.sp_name from 
            (select A.*, B.p_property_name from 
            (select * from property_projection_details".$cond.") A 
            left join 
            (select * from purchase_txn) B 
            on (A.purchase_id = B.txn_id)) C 
            left join 
            (select * from sub_property_allocation) D 
            on (C.sub_property_id=D.txn_id)) E 
            left join 
            (select * from tax_master) F 
            on (E.tax_applicable=F.tax_id)";
    $query = $this->db->query($sql);
    return $query->result();

    // $this->db->select('a.*,p.p_property_name,t.tax_name');
    // $this->db->from('purchase_txn p,property_projection_details a');
    // $this->db->where('p.txn_id = a.purchase_id and p.gp_id = '.$this->session->userdata("groupid").' ');
    // if($id !=''){
    //  $this->db->where('a.id = '.$id.' ');
    // }
    // $this->db->join('tax_master t','a.tax_applicable = t.tax_id','left');
    // $this->db->order_by('a.created_on','asc');
    // $result=$this->db->get();
    // //echo $this->db->last_query();
    // return $result->result();
}

function projectionData($status='', $id=''){
    if($status=='All'){
        $cond="";
        $cond3="";
    } else if($status=='InProcess'){
        $status='In Process';
        $cond="and E.status='In Process'";
        $cond3="where E.status='In Process'";
    } else if($status=='Pending'){
        $cond="and (E.status='Pending' or E.status='Delete')";
        $cond3="where (E.status='Pending' or E.status='Delete')";
    } else {
        $cond="and E.status='$status'";
        $cond3="where E.status='$status'";
    }

    if($id!=""){
        $cond2=" and id='" . $id . "'";
    } else {
        $cond2="";
    }

    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

    if (count($result)>0) {
        $sql="select * from 
            (select C.*, D.owner_name from 
            (select E.*, F.tax_name from 
            (select C.*, D.sp_name from 
            (select A.*, B.p_property_name from 
            (select * from property_projection_details where gp_id = '$gid'" . $cond2 . ") A 
            left join 
            (select * from purchase_txn where txn_status='Approved' and gp_id = '$gid') B 
            on A.purchase_id = B.txn_id) C 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') D 
            on C.sub_property_id = D.txn_id) E 
            left join 
            (select * from tax_master) F 
            on (E.tax_applicable=F.tax_id)) C 
            left join 
            (select A.purchase_id, A.pr_client_id, 
                    case when B.ow_type = '0' then 
                            (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
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
            where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
            where purchase_id=A.purchase_id and pr_client_id in (select distinct owner_id from user_role_owners 
            where user_id = '$session_id') group by purchase_id)) D 
            on C.purchase_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>'' " . $cond . " order by id desc";
    } else {
        $sql="select * from 
            (select C.*, D.owner_name from 
            (select E.*, F.tax_name from 
            (select C.*, D.sp_name from 
            (select A.*, B.p_property_name from 
            (select * from property_projection_details where gp_id = '$gid'" . $cond2 . ") A 
            left join 
            (select * from purchase_txn where txn_status='Approved' and gp_id = '$gid') B 
            on A.purchase_id = B.txn_id) C 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') D 
            on C.sub_property_id = D.txn_id) E 
            left join 
            (select * from tax_master) F 
            on (E.tax_applicable=F.tax_id)) C 
            left join 
            (select A.purchase_id, A.pr_client_id, 
                    case when B.ow_type = '0' then 
                            (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
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
            where A.pr_client_id=B.ow_id and A.pr_client_id in (select min(pr_client_id) from purchase_ownership_details 
            where purchase_id=A.purchase_id group by purchase_id)) D 
            on C.purchase_id=D.purchase_id) E " . $cond3 . " order by id desc";
    }

    $query=$this->db->query($sql);
    // echo $this->db->last_query();
    return $query->result();
}

function getAccess(){
	$gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Valuation' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
    $result=$query->result();
    return $result;
}

function insertRecord($purdt, $status){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $projection_date=$this->input->post('projection_date');
    if($projection_date==''){
        $projection_date=NULL;
    } else {
        $projection_date=formatdate($projection_date);
    }
    $data = array(
        'purchase_id'=>$this->input->post('property'),
        'sub_property_id'=>$this->input->post('sub_property'),
        'req_rate_return'=>format_number($this->input->post('req_rate_return'),2),
        'rrv_value'=>format_number($this->input->post('rrv_value'),2),
        'cost_of_aqua'=>format_number($this->input->post('index_cost_value'),2),
        'market_rate'=>format_number($this->input->post('market_rate'),2),
        'market_value'=>format_number($this->input->post('market_value'),2),
        'tax_applicable'=>($this->input->post('tax_app')==''?'0':$this->input->post('tax_app')),
        'profit_loss'=>format_number($this->input->post('profit_loss'),2),
        'maker_remark'=>$this->input->post('maker_remark'),
        'projection_date'=>FormatDate($this->input->post('projection_date')),
        'gp_id'=>$gid,
        'status' => $status,
        'created_on' =>date('Y-m-d'),
        'created_by' => $curusr,
        'updated_on' =>date('Y-m-d'),
        'updated_by' => $curusr
    );

    $this->db->insert('property_projection_details', $data);
    $id=$this->db->insert_id();
    $logarray['table_id']=$id;
    $logarray['module_name']='Property Projection';
    $logarray['cnt_name']='Property_projection';
    $logarray['action']='Property Projection Record Inserted';
    $logarray['gp_id']=$gid;
    $this->user_access_log_model->insertAccessLog($logarray);
    return $pid;
}

}
?>