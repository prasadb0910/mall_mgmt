<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Maintenance_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('purchase_model');
}

function getAllTaxes(){
	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
	$this->db->where('status = "1" and txn_type like "%maintenance%" and tax_action="1"');
	$this->db->from('tax_master');
	$result=$this->db->get();
	return $result->result();
}

function getAccess(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Maintenance' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
    $result=$query->result();
    return $result;
}

function maintenanceData($status='', $property_id='', $mid=''){
    if($status=='All'){
        $cond="";
        $cond3="";
    } else if($status=='InProcess'){
        $status='In Process';
        $cond="and C.txn_status='In Process'";
        $cond3="where C.txn_status='In Process'";
    } else if($status=='Pending'){
        $cond="and (C.txn_status='Pending' or C.txn_status='Delete')";
        $cond3="where (C.txn_status='Pending' or C.txn_status='Delete')";
    } else {
        $cond="and C.txn_status='$status'";
        $cond3="where C.txn_status='$status'";
    }

    if($property_id!=""){
        $cond2=" and property_id='" . $property_id . "'";
    } else {
        $cond2="";
    }

    if($mid!=""){
        $cond2=" and txn_id='" . $mid . "'";
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
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.maintenance_amount, A.txn_status, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.maintenance_amount, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' and 
                            property_id in (select distinct purchase_id from purchase_ownership_details 
                                                where pr_client_id in (select distinct owner_id from user_role_owners 
                                                    where user_id = '$session_id')) " . $cond2 . ") A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select m_id, sum(net_amount) as maintenance_amount from maintenance_schedule where status='1' or status='3' group by m_id) D 
            on C.txn_id = D.m_id) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
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
            on C.property_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>'' " . $cond;
    } else {
        $sql="select * from 
            (select C.*, D.owner_name from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.maintenance_amount, A.txn_status, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.maintenance_amount, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' " . $cond2 . ") A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select m_id, sum(net_amount) as maintenance_amount from maintenance_schedule where status='1' or status='3' group by m_id) D 
            on C.txn_id = D.m_id) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
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
            on C.property_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>'' " . $cond3;
    }

    $query=$this->db->query($sql);
    return $query->result();
}

function maintenanceDataForBankEntry($status='', $property_id=''){
    if($status=='All'){
        $cond="";
        $cond3="";
    } else if($status=='InProcess'){
        $status='In Process';
        $cond="and E.txn_status='In Process'";
        $cond3="where E.txn_status='In Process'";
    } else if($status=='Pending'){
        $cond="and (E.txn_status='Pending' or E.txn_status='Delete')";
        $cond3="where (E.txn_status='Pending' or E.txn_status='Delete')";
    } else {
        $cond="and E.txn_status='$status'";
        $cond3="where E.txn_status='$status'";
    }

    if($property_id!=""){
        $cond2=" and property_id='" . $property_id . "'";
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
            (select F.*, G.maintenance_by, G.property_tax_by from 
            (select * from 
            (select C.*, D.owner_name from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.maintenance_amount, A.txn_status, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.maintenance_amount, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' and 
                            property_id in (select distinct purchase_id from purchase_ownership_details 
                                                where pr_client_id in (select distinct owner_id from user_role_owners 
                                                    where user_id = '$session_id')) " . $cond2 . ") A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select m_id, sum(net_amount) as maintenance_amount from maintenance_schedule where status='1' or status='3' group by m_id) D 
            on C.txn_id = D.m_id) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
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
            on C.property_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>'' " . $cond . ") F 
            left join 
            (select * from rent_txn where txn_status='Approved') G 
            on (F.property_id=G.property_id and F.sub_property_id=G.sub_property_id)) H 
            where (H.maintenance_by is null or H.maintenance_by='' or H.maintenance_by<>'Tenant' or 
                   H.property_tax_by is null or H.property_tax_by='' or H.property_tax_by<>'Tenant')";
    } else {
        $sql="select * from 
            (select F.*, G.maintenance_by, G.property_tax_by from 
            (select * from 
            (select C.*, D.owner_name from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.maintenance_amount, A.txn_status, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.maintenance_amount, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' " . $cond2 . ") A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select m_id, sum(net_amount) as maintenance_amount from maintenance_schedule where status='1' or status='3' group by m_id) D 
            on C.txn_id = D.m_id) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
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
            on C.property_id=D.purchase_id) E " . $cond3 . ") F 
            left join 
            (select * from rent_txn where txn_status='Approved') G 
            on (F.property_id=G.property_id and F.sub_property_id=G.sub_property_id)) H 
            where (H.maintenance_by is null or H.maintenance_by='' or H.maintenance_by<>'Tenant' or 
                   H.property_tax_by is null or H.property_tax_by='' or H.property_tax_by<>'Tenant')";
    }

    $query=$this->db->query($sql);
    return $query->result();
}

function getMaintenanceData($status='', $mid=''){
    $gid=$this->session->userdata('groupid');

    if($status=='All'){
        $cond="";
    } else if($status=='InProcess'){
        $status='In Process';
        $cond=" and txn_status='In Process'";
    } else if($status=='Pending'){
        $cond=" and (txn_status='Pending' or txn_status='Delete')";
    } else {
        $cond=" and txn_status='$status'";
    }

    if($mid!=""){
        $cond=" and txn_id='" . $mid . "'";
    }

    $query=$this->db->query("SELECT * FROM maintenance_txn WHERE gp_id='$gid' " . $cond . " order by modified_date desc");
    $result=$query->result();
    $data['property']=$result;

    $data['owner']=NULL;
    for ($i=0; $i < count($result) ; $i++) {
        $mid=$result[$i]->txn_id;
        $query=$this->db->query("select E.txn_id, E.property_id, E.p_property_name, E.p_display_name, E.sub_property_id, F.sp_name, E.create_date, E.total_cost from 
                                (select C.txn_id, C.property_id, D.p_property_name, D.p_display_name, C.sub_property_id, C.create_date, C.total_cost from 
                                (select A.txn_id, A.property_id, A.sub_property_id, A.create_date, B.total_cost from 
                                (select * from maintenance_txn where txn_id='$mid') A 
                                left join 
                                (select m_id, sum(cost) as total_cost from maintenance_cost_details group by m_id) B 
                                on A.txn_id=B.m_id) C 
                                left join 
                                (select * from purchase_txn where txn_status='Approved') D 
                                on C.property_id=D.txn_id) E 
                                left join 
                                (select * from sub_property_allocation where gp_id='$gid' and txn_status='Approved') F 
                                on E.sub_property_id=F.txn_id");
        $res=$query->result();
        $data['purchase'][$i]=$res;

        $pid=$result[$i]->property_id;
        $query=$this->db->query("SELECT * FROM purchase_ownership_details WHERE purchase_id ='$pid'");
        $res=$query->result();
        $oid=$res[0]->pr_client_id;
        
        $query=$this->db->query("SELECT * FROM owner_master WHERE ow_id = '$oid'");
        $re=$query->result();
        
        $data['owner'][$i]['id']=$oid;
        if($re[0]->ow_type==0) {
            $cid=$re[0]->ow_ind_id;
            $quer=$this->db->query("SELECT * FROM contact_master WHERE c_id = '$cid'");
            $re1=$quer->result();
            $data['owner'][$i]['name']=$re1[0]->c_name;
        } else if($re[0]->ow_type==1) {
            $data['owner'][$i]['name']=$re[0]->ow_huf_name;
        } else if($re[0]->ow_type==2) {
            $data['owner'][$i]['name']=$re[0]->ow_pvtltd_comapny_name;
        } else if($re[0]->ow_type==3) {
            $data['owner'][$i]['name']=$re[0]->ow_ltd_comapny_name;
        } else if($re[0]->ow_type==4) {
            $data['owner'][$i]['name']=$re[0]->ow_llp_comapny_name;
        } else if($re[0]->ow_type==5) {
            $data['owner'][$i]['name']=$re[0]->ow_prt_comapny_name;
        } else if($re[0]->ow_type==6) {
            $data['owner'][$i]['name']=$re[0]->ow_aop_comapny_name;
        } else if($re[0]->ow_type==7) {
            $data['owner'][$i]['name']=$re[0]->ow_trs_comapny_name;
        } else if($re[0]->ow_type==8) {
            $data['owner'][$i]['name']=$re[0]->ow_proprietorship_comapny_name;
        }
    }

    return $data;
}

public function send_maintenance_intimation($mid){
    $gid=$this->session->userdata('groupid');

    $sql = "select * from maintenance_txn where txn_id = '$mid'";
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)){
        $property_id=$result[0]->property_id;
        $sub_property_id=$result[0]->sub_property_id;
    } else {
        $property_id='';
        $sub_property_id='';
    }

    $group_owners=$this->purchase_model->get_group_owners($gid);
    $property_owners=$this->purchase_model->get_property_owners($property_id);
    $prop_owners="";

    $table=$this->get_maintenance_list_table($mid);

    if(count($property_owners)>0){
        for($i=0;$i<count($property_owners);$i++){
            $owner_name=$property_owners[$i]->owner_name;
            $to_email=$property_owners[$i]->ow_contact_email_id;

            $prop_owners=$prop_owners.$owner_name.', ';

            $this->send_maintenance_intimation_to_owner($table, $owner_name, $to_email);
        }

        if(strpos($prop_owners, ', ')>0){
            $prop_owners=substr($prop_owners,0,strripos($prop_owners, ', '));
        }

        // echo $prop_owners;
    }

    if(count($group_owners)>0){
        for($i=0;$i<count($group_owners);$i++){
            $owner_name="";
            if(isset($group_owners[$i]->c_name)){
                $owner_name=$group_owners[$i]->c_name;
            }
            if(isset($group_owners[$i]->c_last_name)){
                $owner_name=$owner_name.' '.$group_owners[$i]->c_last_name;
            }
            $to_email=$group_owners[$i]->c_emailid1;

            $this->send_maintenance_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
        }
    }
}

public function get_maintenance_list_table($mid) {
    $data = $this->getMaintenanceData("All", $mid);
    $table='';

    if(count($data['purchase'])>0) {
        $table='<div>
                <table style="border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Owner</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Sub Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="50">Date</th>
                            <th style="padding:5px; border: 1px solid black;" width="110">Total Cost (In Rs)</th>
                        </tr>
                    </thead>
                    <tbody>';

        for($i=0;$i<count($data['purchase']); $i++ ) {
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$data['purchase'][$i][0]->p_property_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.(isset($data['owner'][$i])? $data['owner'][$i]['name']: '').'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$data['purchase'][$i][0]->sp_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.(($data['purchase'][$i][0]->create_date!=null && $data['purchase'][$i][0]->create_date!='')?date('d/m/Y',strtotime($data['purchase'][$i][0]->create_date)):'').'</td>
                            <td style="padding:5px; border: 1px solid black;">'.format_money($data['purchase'][$i][0]->total_cost,2).'</td>
                        </tr>';
        }

        $table=$table.'</tbody></table></div>';

        // echo $table;
        return $table;
    }
}

public function send_maintenance_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
    $from_email = 'info@pecanreams.com';
    $from_email_sender = 'Pecan REAMS';
    $subject = 'Maintenance Intimation';

    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                We would like to bring to your notice that a New Maintenance Entry has been created for '.$prop_owners.'. 
                The Maintenance details are as follows.<br /><br />' . $table . '<br /><br />
                If the above Maintenance details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
    $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

    // echo $owner_name . ' ';
}

public function send_maintenance_intimation_to_owner($table, $owner_name, $to_email) {
    $from_email = 'info@pecanreams.com';
    $from_email_sender = 'Pecan REAMS';
    $subject = 'Maintenance Intimation';
    
    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                We would like to bring to your notice that a New Maintenance Entry has been mapped to you. 
                The Maintenance details are as follows.<br /><br />' . $table . '<br /><br />
                If the above Maintenance are not yours please reject the same immediately.<br /><br />Thanks</body></html>';
    $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

    // echo $owner_name . ' ';
}
}
?>