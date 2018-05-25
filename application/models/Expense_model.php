<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Expense_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('purchase_model');
}

function getAllTaxes(){
	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
	$this->db->where('status = "1" and txn_type like "%expense%" and tax_action="1"');
	$this->db->from('tax_master');
	$result=$this->db->get();
	return $result->result();
}

function getAccess(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Expense' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
    $result=$query->result();
    return $result;
}

function expenseData($status='', $property_id=''){
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
            (select C.*, D.owner_name from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.expense_amount, A.expense_date, A.txn_status, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.expense_amount, C.expense_date, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.expense_date, A.txn_status from 
            (select * from expense_txn where gp_id = '$gid' and 
                        property_id in (select distinct purchase_id from purchase_ownership_details 
                                            where pr_client_id in (select distinct owner_id from user_role_owners 
                                                where user_id = '$session_id')) " . $cond2 . ") A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select expense_id, sum(net_amount) as expense_amount from expense_schedule where status='1' or status='3' group by expense_id) D 
            on C.txn_id = D.expense_id) A 
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
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.expense_amount, A.expense_date, A.txn_status, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.expense_amount, C.expense_date, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.expense_date, A.txn_status from 
            (select * from expense_txn where gp_id = '$gid' " . $cond2 . ") A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select expense_id, sum(net_amount) as expense_amount from expense_schedule where status='1' or status='3' group by expense_id) D 
            on C.txn_id = D.expense_id) A 
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
            on C.property_id=D.purchase_id) E " . $cond3;
    }

    $query=$this->db->query($sql);
    return $query->result();
}

// public function getExpenseData(){
//     $sql = "select G.*, H.expense_category from 
//             (select E.*, concat(ifnull(F.c_name,''),' ',ifnull(F.c_last_name,'')) as contact_name from 
//             (select C.*, D.sp_name from 
//             (select A.*, B.p_property_name from 
//             (select A.*, B.b_name as bank_name_name from 
//             (select * from expense_txn where mail_sent = '0') A 
//             left join 
//             (select * from bank_master) B 
//             on (A.bank_name=B.b_id)) A 
//             left join 
//             (select * from purchase_txn where txn_status='Approved') B 
//             on A.property_id=B.txn_id) C 
//             left join 
//             (select * from sub_property_allocation where txn_status='Approved') D 
//             on C.sub_property_id=D.txn_id) E 
//             left join 
//             (select * from contact_master where c_status='Approved') F 
//             on E.vendor_id=F.c_id) G 
//             left join 
//             (select * from expense_category_master) H 
//             on G.category=H.id
//             ORDER BY G.modified_date DESC";
//     $query=$this->db->query($sql);
//     $result=$query->result();
//     return $result;
// }

public function send_expense_intimation(){
    $sql = "select * from 
            (select E.*, F.c_emailid1 as ow_contact_email_id from 
            (select C.*, D.pr_client_id as owner_id, D.owner_name, D.ow_contact_id from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.*, D.tot_expense_amount from 
            (select A.*, B.sp_name from 
            (select C.*, concat(ifnull(D.c_name,''),' ',ifnull(D.c_last_name,'')) as contact_name from 
            (select A.*, B.expense_category from 
            (select * from expense_txn where mail_sent = '0' and txn_status='Pending') A 
            left join 
            (select * from expense_category_master) B 
            on (A.category=B.id)) C
            left join 
            (select * from contact_master where c_status='Approved') D
            on (C.vendor_id=D.c_id)) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select expense_id, sum(net_amount) as tot_expense_amount from expense_schedule where status='1' or status='3' group by expense_id) D 
            on C.txn_id = D.expense_id) A 
            left join 
            (select * from purchase_txn where txn_status='Approved') B 
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
                        else B.ow_proprietorship_comapny_name end as owner_name, 
                    case when B.ow_type = '0' then B.ow_ind_id 
                        when B.ow_type = '1' then B.ow_huf_karta_id 
                        when B.ow_type = '2' then B.ow_pvtltd_contact 
                        when B.ow_type = '3' then B.ow_ltd_contact 
                        when B.ow_type = '4' then B.ow_llp_contact 
                        when B.ow_type = '5' then B.ow_prt_contact 
                        when B.ow_type = '6' then B.ow_aop_contact 
                        when B.ow_type = '7' then B.ow_trs_contact 
                        else B.ow_proprietorship_contact end as ow_contact_id 
            from purchase_ownership_details A, owner_master B 
            where A.pr_client_id=B.ow_id) D 
            on C.property_id=D.purchase_id) E 
            left join 
            (select * from contact_master) F 
            on (E.ow_contact_id=F.c_id) where E.owner_id is not null) G order by owner_id";
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)){
        $owner_name="";
        $table="";
        $table2="";
        $j=1;
        $bl_send_mail=false;

        for($i=0; $i<count($result); $i++){
            $sp_name=($result[$i]->sp_name==null)?"":"-".$result[$i]->sp_name;
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->expense_category.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->p_property_name.$sp_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->payment_mode.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->contact_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.format_money($result[$i]->expense_amount,2).'</td>
                        </tr>';

            if($result[$i]->payment_time=="now"){
                $table2=$table2.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.$j.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->expense_category.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->p_property_name.$sp_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->payment_mode.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->contact_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.format_money($result[$i]->expense_amount,2).'</td>
                            </tr>';
                $j=$j+1;
            }

            if(isset($result[$i+1])){
                if($result[$i]->owner_id!=$result[$i+1]->owner_id){
                    $bl_send_mail=true;
                }
            } else {
                $bl_send_mail=true;
            }

            if($bl_send_mail==true){
                $from_email = 'info@pecanreams.com';
                $from_email_sender = 'Pecan REAMS';
                $owner_name=$result[$i]->owner_name;
                $to_email=$result[$i]->ow_contact_email_id;
                $subject = 'Expense Intimation';

                $table='<div>
                        <table style="border-collapse: collapse; border: 1px solid black;">
                            <thead>
                                <tr>
                                    <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Expense Category</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Payment Mode</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Vendor Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="110">Expense Amount</th>
                                </tr>
                            </thead>
                            <tbody>'.$table.'</tbody></table></div>';

                $table2='<div>
                        <table style="border-collapse: collapse; border: 1px solid black;">
                            <thead>
                                <tr>
                                    <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Expense Category</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Payment Mode</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Vendor Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="110">Expense Amount</th>
                                </tr>
                            </thead>
                            <tbody>'.$table2.'</tbody></table></div>';

                $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                            We would like to bring to your notice that a New Expense Entry has been created. 
                            The Expense details are as follows.<br /><br />' . $table . '<br /><br />
                            If the above Expense is not yours please reject the same immediately.<br /><br />
                            Also the following Entry has been paid/received. The details are as follows.<br /><br />' . $table2 . '
                            <br /><br />If the above Entry is not yours please reject the same immediately.
                            <br /><br />Thanks</body></html>';

                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

                $owner_name="";
                $table="";
                $table2="";
                $j=1;
                $bl_send_mail=false;
            }
        }
    }

    $sql = "select * from 
            (select C.*, D.c_id, D.c_name, D.c_last_name, D.c_emailid1 from 
            (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select C.*, D.tot_expense_amount from 
            (select A.*, B.sp_name from 
            (select C.*, concat(ifnull(D.c_name,''),' ',ifnull(D.c_last_name,'')) as contact_name from 
            (select A.*, B.expense_category from 
            (select * from expense_txn where mail_sent = '0' and txn_status='Pending') A 
            left join 
            (select * from expense_category_master) B 
            on (A.category=B.id)) C
            left join 
            (select * from contact_master where c_status='Approved') D
            on (C.vendor_id=D.c_id)) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select expense_id, sum(net_amount) as tot_expense_amount from expense_schedule where status='1' or status='3' group by expense_id) D 
            on C.txn_id = D.expense_id) A 
            left join 
            (select * from purchase_txn where txn_status='Approved') B 
            on A.property_id=B.txn_id) C 
            left join 
            (select * from contact_master where c_createdby='0' and c_status != 'Inactive') D 
            on C.gp_id=D.c_gid) E order by c_id";
    $query = $this->db->query($sql);
    $result = $query->result();

    if(count($result)){
        $owner_name="";
        $table="";
        $table2="";
        $j=1;
        $bl_send_mail=false;
        $expense_ids="";

        for($i=0; $i<count($result); $i++){
            $txn_id=$result[$i]->txn_id;
            $expense_ids=$expense_ids.$txn_id.", ";
            $sp_name=($result[$i]->sp_name==null)?"":"-".$result[$i]->sp_name;
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->expense_category.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->p_property_name.$sp_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->payment_mode.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->contact_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.format_money($result[$i]->expense_amount,2).'</td>
                        </tr>';

            if($result[$i]->payment_time=="now"){
                $table2=$table2.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.$j.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->expense_category.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->p_property_name.$sp_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->payment_mode.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$result[$i]->contact_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.format_money($result[$i]->expense_amount,2).'</td>
                            </tr>';
                $j=$j+1;
            }

            if(isset($result[$i+1])){
                if($result[$i]->c_id!=$result[$i+1]->c_id){
                    $bl_send_mail=true;
                }
            } else {
                $bl_send_mail=true;
            }

            if($bl_send_mail==true){
                $from_email = 'info@pecanreams.com';
                $from_email_sender = 'Pecan REAMS';
                $owner_name="";
                if(isset($result[$i]->c_name)){
                    $owner_name=$result[$i]->c_name;
                }
                if(isset($result[$i]->c_last_name)){
                    $owner_name=$owner_name.' '.$result[$i]->c_last_name;
                }
                $to_email=$result[$i]->c_emailid1;
                $subject = 'Expense Intimation';

                $table='<div>
                        <table style="border-collapse: collapse; border: 1px solid black;">
                            <thead>
                                <tr>
                                    <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Expense Category</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Payment Mode</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Vendor Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="110">Expense Amount</th>
                                </tr>
                            </thead>
                            <tbody>'.$table.'</tbody></table></div>';

                $table2='<div>
                        <table style="border-collapse: collapse; border: 1px solid black;">
                            <thead>
                                <tr>
                                    <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Expense Category</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="100">Payment Mode</th>
                                    <th style="padding:5px; border: 1px solid black;" width="90">Vendor Name</th>
                                    <th style="padding:5px; border: 1px solid black;" width="110">Expense Amount</th>
                                </tr>
                            </thead>
                            <tbody>'.$table2.'</tbody></table></div>';

                $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                            We would like to bring to your notice that a New Expense Entry has been created. 
                            The Expense details are as follows.<br /><br />' . $table . '<br /><br />
                            If the above Expense details are incorrect please reject the same immediately.<br /><br />
                            Also the following Entry has been paid/received. The details are as follows.<br /><br />' . $table2 . '
                            <br /><br />If the above Expense details are incorrect please reject the same immediately.
                            <br /><br />Thanks</body></html>';

                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

                if($mailSent==1){
                    if(strpos($expense_ids, ', ')>0){
                        $expense_ids=substr($expense_ids,0,strripos($expense_ids, ', '));
                    }
                    $sql="update expense_txn set mail_sent='1' where txn_id in (".$expense_ids.")";
                    $this->db->query($sql);
                    $expense_ids="";
                }

                $owner_name="";
                $table="";
                $table2="";
                $j=1;
                $bl_send_mail=false;
            }
        }
    }
}

public function get_expense_list_table($e_id) {
    $sql = "select G.*, H.expense_category from 
            (select E.*, concat(ifnull(F.c_name,''),' ',ifnull(F.c_last_name,'')) as contact_name from 
            (select C.*, D.sp_name from 
            (select A.*, B.p_property_name from 
            (select A.*, B.b_name as bank_name_name from 
            (select * from expense_txn where mail_sent = '0') A 
            left join 
            (select * from bank_master) B 
            on (A.bank_name=B.b_id)) A 
            left join 
            (select * from purchase_txn where txn_status='Approved') B 
            on A.property_id=B.txn_id) C 
            left join 
            (select * from sub_property_allocation where txn_status='Approved') D 
            on C.sub_property_id=D.txn_id) E 
            left join 
            (select * from contact_master where c_status='Approved') F 
            on E.vendor_id=F.c_id) G 
            left join 
            (select * from expense_category_master) H 
            on G.category=H.id
            ORDER BY G.modified_date DESC";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;

    $table='';

    if(count($result)>0) {
        $table='<div>
                <table style="border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Expense Category</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Payment Mode</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Vendor Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="110">Expense Amount</th>
                        </tr>
                    </thead>
                    <tbody>';

        for($i=0;$i<count($result); $i++ ) {
            $sp_name=($result[$i]->sp_name=="")?"":"-".$result[$i]->sp_name;
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->expense_category.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->p_property_name.$sp_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->payment_mode.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->contact_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.format_money($result[$i]->expense_amount,2).'</td>
                        </tr>';
        }

        $table=$table.'</tbody></table></div>';

        // echo $table;
        return $table;
    }
}

public function get_paid_expense_list_table($e_id) {
    $sql = "select G.*, H.expense_category from 
            (select E.*, concat(ifnull(F.c_name,''),' ',ifnull(F.c_last_name,'')) as contact_name from 
            (select C.*, D.sp_name, '' as vendor_id from 
            (select A.*, B.p_property_name from 
            (select A.*, B.b_name as bank_name_name from 
            (select * from expense_txn where mail_sent = '0' and payment_time='now') A 
            left join 
            (select * from bank_master) B 
            on (A.account_number=B.b_id)) A 
            left join 
            (select * from purchase_txn where txn_status='Approved') B 
            on A.property_id=B.txn_id) C 
            left join 
            (select * from sub_property_allocation where txn_status='Approved') D 
            on C.sub_property_id=D.txn_id) E 
            left join 
            (select * from contact_master where c_status='Approved') F 
            on E.vendor_id=F.c_id) G 
            left join 
            (select * from expense_category_master) H 
            on G.expense_category=H.id
            ORDER BY G.modified_date DESC";
    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;

    $table='';

    if(count($result)>0) {
        $table='<div>
                <table style="border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Expense Category</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Payment Mode</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Vendor Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="110">Expense Amount</th>
                        </tr>
                    </thead>
                    <tbody>';

        for($i=0;$i<count($result); $i++ ) {
            $sp_name=($result[$i]->sp_name=="")?"":"-".$result[$i]->sp_name;
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->expense_category.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->p_property_name.$sp_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->payment_mode.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$result[$i]->contact_name.'</td>
                            <td style="padding:5px; border: 1px solid black;">'.format_money($result[$i]->expense_amount,2).'</td>
                        </tr>';
        }

        $table=$table.'</tbody></table></div>';

        // echo $table;
        return $table;
    }
}

public function send_expense_intimation_to_group_owner($table, $table2, $owner_name, $to_email, $prop_owners) {
    $from_email = 'info@pecanreams.com';
    $from_email_sender = 'Pecan REAMS';
    $subject = 'Rent Intimation';

    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                We would like to bring to your notice that a New Expense Entry has been created for '.$prop_owners.'. 
                The Expense details are as follows.<br /><br />' . $table . '<br /><br />
                If the above Expense details are incorrect please reject the same immediately.<br /><br />
                Also the following Entry has been paid/received. The details are as follows.<br /><br />' . $table2 . '
                <br /><br />If the above Expense details are incorrect please reject the same immediately.
                <br /><br />Thanks</body></html>';
    $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    return $mailSent;
    // echo $owner_name . ' ';
}

public function send_expense_intimation_to_owner($table, $table2, $owner_name, $to_email) {
    $from_email = 'info@pecanreams.com';
    $from_email_sender = 'Pecan REAMS';
    $subject = 'Rent Intimation';
    
    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                We would like to bring to your notice that a New Expense Entry has created. 
                The Expense details are as follows.<br /><br />' . $table . '<br /><br />
                If the above Expense is not yours please reject the same immediately.<br /><br />
                Also the following Entry has been paid/received. The details are as follows.<br /><br />' . $table2 . '
                <br /><br />If the above Entry is not yours please reject the same immediately.
                <br /><br />Thanks</body></html>';
    $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
    return $mailSent;
    // echo $owner_name . ' ';
}
}
?>