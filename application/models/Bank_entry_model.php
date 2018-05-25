<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Bank_entry_model Extends CI_Model{

function __Construct(){
	parent :: __construct();
    $this->load->helper('common_functions');
    $this->load->model('purchase_model');
    $this->load->model('loan_model');
}

/**
@input parmeters schedule master id and txn master along with transaction type eg sale , purchase, rent
@output Details About property and all transaction done against that property
*/


function bankentryData($status='', $property_id='', $created_on=''){
    if($status=='All'){
        $cond="";
        $cond3="";
    } else if($status=='InProcess'){
        $status='In Process';
        $cond=" and E.txn_status='In Process'";
        $cond3=" where E.txn_status='In Process'";
    } else if($status=='Pending'){
        $cond=" and (E.txn_status='Pending' or E.txn_status='Delete')";
        $cond3=" where (E.txn_status='Pending' or E.txn_status='Delete')";
    } else {
        $cond=" and E.txn_status='$status'";
        $cond3=" where E.txn_status='$status'";
    }

    // if($property_id!=""){
    //     $cond2=" and AA.property_id='" . $property_id . "'";
    // } else {
    //     $cond2="";
    // }

    if($created_on!=""){
        $cond2=" and created_on='" . $created_on . "' ";
    } else {
        $cond2="";
    }

    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $blOwnerExist=false;
    $dataarray=array();
    $i=0;

    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

    if (count($result)>0) {
        $blOwnerExist=true;

        //for purchase
        $sql="select * from 
            (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, '' as sub_property_id, 
                    '' as sp_name, C.p_type, C.p_status, C.purchase_id, C.event_type, C.event_name, C.event_date, 
                    C.net_amount, C.bank_entry_id, C.txn_status, C.paid_amount, C.entry_type, D.pr_client_id, D.owner_name from 
            (select * from 
            (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                    B.purchase_id, B.event_type, B.event_name, B.event_date, B.net_amount, B.bank_entry_id, 
                    B.txn_status, B.paid_amount, B.entry_type from 
            (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status 
            from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
            left join 
            (select * from 
            (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select purchase_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
                from purchase_schedule where status = '1' 
             union all 
             select fk_txn_id as purchase_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'purchase') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, paid_amount+tds_amount as paid_amount 
             from actual_schedule where table_type = 'purchase' ".$cond2."
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
             amount_paid as paid_amount from actual_schedule_taxes where table_type = 'purchase' ".$cond2.") B 
            on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) B 
            on A.txn_id = B.purchase_id) C where C.event_name is not null) C 
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
            on C.txn_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>''" . $cond;
    } else {
        $sql="select * from 
            (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, '' as sub_property_id, 
                    '' as sp_name, C.p_type, C.p_status, C.purchase_id, C.event_type, C.event_name, C.event_date, 
                    C.net_amount, C.bank_entry_id, C.txn_status, C.paid_amount, C.entry_type, D.pr_client_id, D.owner_name from 
            (select * from 
            (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                    B.purchase_id, B.event_type, B.event_name, B.event_date, B.net_amount, B.bank_entry_id, 
                    B.txn_status, B.paid_amount, B.entry_type from 
            (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status 
            from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
            left join 
            (select * from 
            (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select purchase_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
                from purchase_schedule where status = '1' 
             union all 
             select fk_txn_id as purchase_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'purchase') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, paid_amount+tds_amount as paid_amount 
             from actual_schedule where table_type = 'purchase' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
             amount_paid as paid_amount from actual_schedule_taxes where table_type = 'purchase' ".$cond2.") B 
            on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) B 
            on A.txn_id = B.purchase_id)C where C.event_name is not null) C 
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
            on C.txn_id=D.purchase_id) E" . $cond3;
    }

    $result1=$this->db->query($sql);
    if($result1->num_rows() > 0){
        foreach($result1->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Purchase';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property_id']=$row->purchase_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="p_".$row->purchase_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->bank_entry_id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']=$row->entry_type;
            $i++;
        }
    }

    //for sale
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select D.buyer_id, D.owner_name, C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.sale_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.date_of_sale, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status, C.bank_entry_id, C.txn_status, C.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.sale_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.date_of_sale, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status, A.bank_entry_id, A.txn_status, A.entry_type from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.sale_id, D.event_type, D.event_name, 
                D.event_date, D.net_amount, D.paid_amount, C.date_of_sale, D.bank_entry_id, D.txn_status, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                txn_id in (select distinct sale_id from sales_buyer_details 
                where buyer_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select sale_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from sales_schedule where status = '1' 
             union all 
             select fk_txn_id as sale_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'sales') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status 
             from actual_schedule where table_type = 'sales' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             amount_paid as paid_amount, txn_status from actual_schedule_taxes where table_type = 'sales' ".$cond2.") B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.sale_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id and buyer_id in (select distinct owner_id from user_role_owners 
            where user_id = '$session_id') group by sale_id)) A 
            LEFT JOIN 
            (select concat('c_',c_id) as c_id, contact_name as owner_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B where ow_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E 
            where E.owner_name is not null and E.owner_name<>''" . $cond;
    } else {
        $sql="select * from 
            (select D.buyer_id, D.owner_name, C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.sale_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.date_of_sale, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status, C.bank_entry_id, C.txn_status, C.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.sale_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.date_of_sale, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status, A.bank_entry_id, A.txn_status, A.entry_type from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.sale_id, D.event_type, D.event_name, 
                D.event_date, D.net_amount, D.paid_amount, C.date_of_sale, D.bank_entry_id, D.txn_status, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select sale_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from sales_schedule where status = '1' 
             union all 
             select fk_txn_id as sale_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'sales') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status 
             from actual_schedule where table_type = 'sales' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             amount_paid as paid_amount, txn_status from actual_schedule_taxes where table_type = 'sales' ".$cond2.") B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.sale_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id group by sale_id)) A 
            LEFT JOIN 
            (select concat('c_',c_id) as c_id, contact_name as owner_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B where ow_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E" . $cond3;
    }

    $result2=$this->db->query($sql);
    if($result2->num_rows() > 0){
        foreach($result2->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Sale';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="s_".$row->sale_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->bank_entry_id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']=$row->entry_type;
            $i++;
        }
    }

    //for rent
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.rent_amount, C.possession_date, 
                C.termination_date, C.p_property_name, C.p_display_name, C.p_type, C.p_status, 
                C.bank_entry_id, C.txn_status, C.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_id, 
                A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.rent_amount, A.possession_date, 
                A.termination_date, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                A.bank_entry_id, A.txn_status, A.entry_type from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.tenant_id, C.c_name, C.gp_id, 
                D.rent_id, D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, C.rent_amount, 
                C.possession_date, C.termination_date, D.bank_entry_id, D.txn_status, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                A.possession_date, A.termination_date from 
            (select AA.*, BB.c_name from 
            (select * from rent_txn where gp_id = '$gid' and txn_status='Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) AA 
            left join 
            (select concat('c_',c_id) as c_id, contact_name as c_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name as c_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B 
            where ow_gid='$gid') BB 
            on (AA.tenant_id=BB.c_id)) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.rent_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, 
                B.id as bank_entry_id, B.txn_status, A.entry_type from 
            (select rent_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from rent_schedule where status = '1' 
             union all 
             select fk_txn_id as rent_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'rent') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status 
             from actual_schedule where table_type = 'rent' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             amount_paid as paid_amount, txn_status from actual_schedule_taxes where table_type = 'rent' ".$cond2.") B 
            on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id=D.rent_id) E where E.event_name is not null) A 
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
            where E.owner_name is not null and E.owner_name<>''" . $cond;
    } else {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.rent_amount, C.possession_date, 
                C.termination_date, C.p_property_name, C.p_display_name, C.p_type, C.p_status, 
                C.bank_entry_id, C.txn_status, C.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_id, 
                A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.rent_amount, A.possession_date, 
                A.termination_date, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                A.bank_entry_id, A.txn_status, A.entry_type from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.tenant_id, C.c_name, C.gp_id, 
                D.rent_id, D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, C.rent_amount, 
                C.possession_date, C.termination_date, D.bank_entry_id, D.txn_status, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                A.possession_date, A.termination_date from 
            (select AA.*, BB.c_name from 
            (select * from rent_txn where gp_id = '$gid' and txn_status='Approved') AA 
            left join 
            (select concat('c_',c_id) as c_id, contact_name as c_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name as c_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B 
            where ow_gid='$gid') BB 
            on (AA.tenant_id=BB.c_id)) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.rent_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, 
                B.id as bank_entry_id, B.txn_status, A.entry_type from 
            (select rent_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from rent_schedule where status = '1' 
             union all 
             select fk_txn_id as rent_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'rent') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status 
             from actual_schedule where table_type = 'rent' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             amount_paid as paid_amount, txn_status from actual_schedule_taxes where table_type = 'rent' ".$cond2.") B 
            on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id=D.rent_id) E where E.event_name is not null) A 
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
            on C.property_id=D.purchase_id) E" . $cond3;
    }

    $result3=$this->db->query($sql);
    if($result3->num_rows() > 0){
        foreach($result3->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Rent';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="r_".$row->rent_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->bank_entry_id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']=$row->entry_type;
            $i++;
        }
    }

    //for loan
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, 
                C.loan_id, C.event_type, C.event_name, C.event_date, C.net_amount, C.loan_amount, 
                C.loan_startdate, C.bank_entry_id, C.txn_status, C.paid_amount, C.entry_type, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, 
                A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, A.loan_amount, 
                A.loan_startdate, A.bank_entry_id, A.txn_status, A.paid_amount, A.entry_type, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, 
                D.loan_id, D.event_type, D.event_name, D.event_date, D.net_amount, C.loan_amount, C.loan_startdate, 
                D.bank_entry_id, D.txn_status, D.paid_amount, D.entry_type from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.loan_amount, 
                A.loan_startdate from 
            (select txn_id, ref_id, ref_name, null as property_id, null as sub_property_id, loan_amount, 
                loan_startdate, gp_id from loan_txn where gp_id = '$gid' and txn_status='Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select loan_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from loan_schedule where status = '1' 
             union all 
             select fk_txn_id as loan_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'loan') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, (paid_amount+tds_amount) as paid_amount 
             from actual_schedule where table_type = 'loan' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
             amount_paid as paid_amount from actual_schedule_taxes where table_type = 'loan' ".$cond2.") B 
            on (A.loan_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id=D.loan_id) E where E.event_name is not null) A 
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
            on C.property_id=D.purchase_id) E" . $cond3;
    } else {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, 
                C.loan_id, C.event_type, C.event_name, C.event_date, C.net_amount, C.loan_amount, 
                C.loan_startdate, C.bank_entry_id, C.txn_status, C.paid_amount, C.entry_type, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, 
                A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, A.loan_amount, 
                A.loan_startdate, A.bank_entry_id, A.txn_status, A.paid_amount, A.entry_type, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, 
                D.loan_id, D.event_type, D.event_name, D.event_date, D.net_amount, C.loan_amount, C.loan_startdate, 
                D.bank_entry_id, D.txn_status, D.paid_amount, D.entry_type from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.loan_amount, 
                A.loan_startdate from 
            (select txn_id, ref_id, ref_name, null as property_id, null as sub_property_id, loan_amount, 
                loan_startdate, gp_id from loan_txn where gp_id = '$gid' and txn_status='Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select loan_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from loan_schedule where status = '1' 
             union all 
             select fk_txn_id as loan_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'loan') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, (paid_amount+tds_amount) as paid_amount 
             from actual_schedule where table_type = 'loan' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
             amount_paid as paid_amount from actual_schedule_taxes where table_type = 'loan' ".$cond2.") B 
            on (A.loan_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id=D.loan_id) E where E.event_name is not null) A 
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
            on C.property_id=D.purchase_id) E" . $cond3;
    }

    $result4=$this->db->query($sql);
    if($result4->num_rows() > 0){
        foreach($result4->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Loan';
            $dataarray[$i]['event_name']=$row->event_name;
            // $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->ref_name;
            $dataarray[$i]['prop_id']="l_".$row->loan_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->bank_entry_id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=$row->ref_id;
            $dataarray[$i]['ref_name']=$row->ref_name;
            $dataarray[$i]['entry_type']=$row->entry_type;
            $i++;
        }
    }

    //for expense
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.expense_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.expense_date, 
                C.bank_entry_id, C.txn_status, C.paid_amount, C.entry_type, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.expense_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.expense_date, A.bank_entry_id, A.txn_status, A.paid_amount, A.entry_type, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.expense_id, D.event_type, D.event_name, 
                D.event_date, D.net_amount, C.expense_date, D.bank_entry_id, D.txn_status, D.paid_amount, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.expense_date from 
            (select * from expense_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.expense_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select expense_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from expense_schedule where status = '1' 
             union all 
             select fk_txn_id as expense_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'expense') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, (paid_amount+tds_amount) as paid_amount 
             from actual_schedule where table_type = 'expense' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
             amount_paid as paid_amount from actual_schedule_taxes where table_type = 'expense' ".$cond2.") B 
            on (A.expense_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.expense_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C ) E" . $cond3;
    } else {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.expense_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.expense_date, 
                C.bank_entry_id, C.txn_status, C.paid_amount, C.entry_type, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.expense_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.expense_date, A.bank_entry_id, A.txn_status, A.paid_amount, A.entry_type, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.expense_id, D.event_type, D.event_name, 
                D.event_date, D.net_amount, C.expense_date, D.bank_entry_id, D.txn_status, D.paid_amount, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.expense_date from 
            (select * from expense_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.expense_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select expense_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from expense_schedule where status = '1' 
             union all 
             select fk_txn_id as expense_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'expense') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, txn_status, (paid_amount+tds_amount) as paid_amount 
             from actual_schedule where table_type = 'expense' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, txn_status, 
             amount_paid as paid_amount from actual_schedule_taxes where table_type = 'expense' ".$cond2.") B 
            on (A.expense_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.expense_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C ) E" . $cond3;
    }

    $result5=$this->db->query($sql);
    if($result5->num_rows() > 0){
        foreach($result5->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Expense';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="e_".$row->expense_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->bank_entry_id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']=$row->entry_type;
            $i++;
        }
    }


    //for maintenance
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.m_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.bank_entry_id, C.txn_status, 
                C.entry_type, C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.m_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.bank_entry_id, A.txn_status, A.paid_amount, A.entry_type, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.m_id, D.event_type, D.event_name, 
                D.event_date, D.net_amount, D.bank_entry_id, D.txn_status, D.paid_amount, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.m_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select m_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from maintenance_schedule where status = '1' 
             union all 
             select fk_txn_id as m_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'maintenance') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status 
             from actual_schedule where table_type = 'maintenance' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             amount_paid as paid_amount, txn_status from actual_schedule_taxes where table_type = 'maintenance' ".$cond2.") B 
            on (A.m_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.m_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C ) E" . $cond;
    } else {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.m_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.bank_entry_id, C.txn_status, 
                C.entry_type, C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.m_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.bank_entry_id, A.txn_status, A.paid_amount, A.entry_type, 
                B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.m_id, D.event_type, D.event_name, 
                D.event_date, D.net_amount, D.bank_entry_id, D.txn_status, D.paid_amount, D.entry_type from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.m_id, A.event_type, A.event_name, A.event_date, A.net_amount, B.id as bank_entry_id, B.txn_status, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, A.entry_type from 
            (select m_id, event_type, event_name, event_date, net_amount, 'schedule' as entry_type 
             from maintenance_schedule where status = '1' 
             union all 
             select fk_txn_id as m_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             tax_amount as net_amount, 'tax' as entry_type from actual_schedule_taxes where table_type = 'maintenance') A 
            left join 
            (select id, fk_txn_id, event_type, event_name, event_date, (paid_amount+tds_amount) as paid_amount, txn_status 
             from actual_schedule where table_type = 'maintenance' ".$cond2." 
             union all 
             select id, fk_txn_id, tax_applied as event_type, 'tax' as event_name, created_on as event_date, 
             amount_paid as paid_amount, txn_status from actual_schedule_taxes where table_type = 'maintenance' ".$cond2.") B 
            on (A.m_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount>0) D 
            on C.txn_id = D.m_id) E where E.event_name is not null) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C ) E" . $cond3;
    }

    $result6=$this->db->query($sql);
    if($result6->num_rows() > 0){
        foreach($result6->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Maintenance';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="m_".$row->m_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->bank_entry_id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']=$row->entry_type;
            $i++;
        }
    }


    //for other expense
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.*, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
            (select A.*, B.sp_name from 
            (select * from actual_other_expense where gp_id = '$gid' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from purchase_txn where gp_id = '$gid') D 
            on C.property_id=D.txn_id) E" . $cond3;
    } else {
        $sql="select * from 
            (select C.*, D.p_property_name, D.p_display_name, D.p_type, D.p_status from 
            (select A.*, B.sp_name from 
            (select * from actual_other_expense where gp_id = '$gid') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from purchase_txn where gp_id = '$gid') D 
            on C.property_id=D.txn_id) E" . $cond3;
    }

    $result7=$this->db->query($sql);
    if($result7->num_rows() > 0){
        foreach($result7->result() as $row){
            $dataarray[$i]['due_date']=$row->expense_date;
            $dataarray[$i]['particulars']='Other Expense';
            $dataarray[$i]['event_name']='';
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="o_".$row->id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->expense_amount;
            $dataarray[$i]['paid_amount']=$row->expense_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']='schedule';
            $i++;
        }
    }


    //for other schedule
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.*, case when D.p_property_name is null then 'Other' when D.p_property_name='' then 'Other' else D.p_property_name end as p_property_name, 
                D.p_display_name, D.p_type, D.p_status from 
            (select A.*, B.sp_name from 
            (select * from actual_other_schedule where gp_id = '$gid' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from purchase_txn where gp_id = '$gid') D 
            on C.property_id=D.txn_id) E" . $cond3;
    } else {
        $sql="select * from 
            (select C.*, case when D.p_property_name is null then 'Other' when D.p_property_name='' then 'Other' else D.p_property_name end as p_property_name, 
                D.p_display_name, D.p_type, D.p_status from 
            (select A.*, B.sp_name from 
            (select * from actual_other_schedule where gp_id = '$gid') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from purchase_txn where gp_id = '$gid') D 
            on C.property_id=D.txn_id) E" . $cond3;
    }

    $result7=$this->db->query($sql);
    if($result7->num_rows() > 0){
        foreach($result7->result() as $row){
            $dataarray[$i]['due_date']=$row->sch_date;
            $dataarray[$i]['particulars']='Other Schedule';
            $dataarray[$i]['event_name']='';
            $dataarray[$i]['property_id']=$row->property_id;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="t_".$row->id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['bank_entry_id']=$row->id;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->amount;
            $dataarray[$i]['paid_amount']=$row->amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $dataarray[$i]['entry_type']='schedule';
            $i++;
        }
    }

    return $dataarray;
}

function getPendingBankEntry() {
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');
    $blOwnerExist=false;
    $dataarray=array();
    $i=0;

    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();

    if (count($result)>0) {
        $blOwnerExist=true;

        //for purchase
        $sql="select * from 
            (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, '' as sub_property_id, '' as sp_name, C.p_type, C.p_status, 
                    C.txn_status, C.purchase_id, C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, D.pr_client_id, D.owner_name from 
            (select * from 
            (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                A.txn_status, B.purchase_id, B.event_type, B.event_name, B.event_date, 
                case when B.net_amount is null then 0 else B.net_amount end as net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
            from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
            left join 
            (select * from 
            (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select purchase_id, event_type, event_name, event_date, net_amount 
            from purchase_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'purchase' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) B 
            on A.txn_id = B.purchase_id) C where C.paid_amount<>C.net_amount) C 
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
            on C.txn_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>''";
    } else {
        $sql="select * from 
            (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, '' as sub_property_id, '' as sp_name, C.p_type, C.p_status, 
                    C.txn_status, C.purchase_id, C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, D.pr_client_id, D.owner_name from 
            (select * from 
            (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                A.txn_status, B.purchase_id, B.event_type, B.event_name, B.event_date, 
                case when B.net_amount is null then 0 else B.net_amount end as net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
            from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
            left join 
            (select * from 
            (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select purchase_id, event_type, event_name, event_date, net_amount 
            from purchase_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'purchase' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) B 
            on A.txn_id = B.purchase_id) C where C.paid_amount<>C.net_amount) C 
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
            on C.txn_id=D.purchase_id) E 
            where E.owner_name is not null and E.owner_name<>''";
    }

    $result1=$this->db->query($sql);
    if($result1->num_rows() > 0){
        foreach($result1->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Purchase';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="p_".$row->purchase_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $i++;
        }
    }

    //for sale
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select D.buyer_id, D.owner_name, C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.sale_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.date_of_sale, C.txn_status, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.sale_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.date_of_sale, A.txn_status, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.sale_id, D.event_type, D.event_name, 
                D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.date_of_sale, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale, A.txn_status from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                txn_id in (select distinct sale_id from sales_buyer_details 
                where buyer_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select sale_id, event_type, event_name, event_date, net_amount 
            from sales_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'sales' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id = D.sale_id) E where E.paid_amount<>E.net_amount) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id and buyer_id in (select distinct owner_id from user_role_owners 
            where user_id = '$session_id') group by sale_id)) A 
            LEFT JOIN 
            (select concat('c_',c_id) as c_id, contact_name as owner_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B where ow_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E 
            where E.owner_name is not null and E.owner_name<>''";
    } else {
        $sql="select * from 
            (select D.buyer_id, D.owner_name, C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.sale_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.date_of_sale, C.txn_status, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.sale_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.date_of_sale, A.txn_status, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.sale_id, D.event_type, D.event_name, 
                D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.date_of_sale, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale, A.txn_status from 
            (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.sale_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select sale_id, event_type, event_name, event_date, net_amount 
            from sales_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'sales' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id = D.sale_id) E where E.paid_amount<>E.net_amount) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C 
            left join 
            (SELECT A.*, B.owner_name FROM 
            (SELECT * FROM sales_buyer_details A WHERE A.buyer_id in (select min(buyer_id) from sales_buyer_details 
            where sale_id = A.sale_id group by sale_id)) A 
            LEFT JOIN 
            (select concat('c_',c_id) as c_id, contact_name as owner_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B where ow_gid='$gid') B 
            ON (A.buyer_id=B.c_id)) D 
            on C.txn_id=D.sale_id) E 
            where E.owner_name is not null and E.owner_name<>''";
    }

    $result2=$this->db->query($sql);
    if($result2->num_rows() > 0){
        foreach($result2->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Sale';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="s_".$row->sale_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $i++;
        }
    }

    //for rent
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.rent_amount, C.possession_date, 
                C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
            C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_id, 
                A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.rent_amount, A.possession_date, 
                A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.tenant_id, C.c_name, C.gp_id, D.rent_id, 
                D.event_type, D.event_name, D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.rent_amount, C.possession_date, 
                C.termination_date, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                A.possession_date, A.termination_date, A.txn_status from 
            (select AA.*, BB.c_name from 
            (select * from rent_txn where gp_id = '$gid' and txn_status='Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) AA 
            left join 
            (select concat('c_',c_id) as c_id, contact_name as c_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name as c_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B 
            where ow_gid='$gid') BB 
            on (AA.tenant_id=BB.c_id)) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.rent_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select rent_id, event_type, event_name, event_date, net_amount 
            from rent_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'rent' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id=D.rent_id) E where E.paid_amount<>E.net_amount) A 
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
            where E.owner_name is not null and E.owner_name<>''";
    } else {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.rent_amount, C.possession_date, 
                C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
            C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_id, 
                A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.rent_amount, A.possession_date, 
                A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.tenant_id, C.c_name, C.gp_id, D.rent_id, 
                D.event_type, D.event_name, D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.rent_amount, C.possession_date, 
                C.termination_date, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_amount, 
                A.possession_date, A.termination_date, A.txn_status from 
            (select AA.*, BB.c_name from 
            (select * from rent_txn where gp_id = '$gid' and txn_status='Approved') AA 
            left join 
            (select concat('c_',c_id) as c_id, contact_name as c_name from 
            (select A.*, concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,''),' - ',ifnull(A.c_emailid1,''),' - ',
                ifnull(A.c_mobile1,''),' - ',ifnull(A.c_company,''),' - ',ifnull(B.contact_type,'')) as contact_name from 
            (select * from contact_master where c_status='Approved' and c_gid='$gid') A 
            left join 
            (select * from contact_type_master where g_id='$gid') B 
            on (A.c_contact_type = B.id)) C 
            union all 
            select concat('o_',ow_id) as c_id, owner_name as c_name from 
            (select ow_gid, ow_id, ow_type, case when ow_type = '0' then ow_ind_name 
                when ow_type = '1' then ow_huf_name when ow_type = '2' then ow_pvtltd_comapny_name 
                when ow_type = '3' then ow_ltd_comapny_name when ow_type = '4' then ow_llp_comapny_name 
                when ow_type = '5' then ow_prt_comapny_name when ow_type = '6' then ow_aop_comapny_name 
                when ow_type = '7' then ow_trs_comapny_name else ow_proprietorship_comapny_name end as owner_name 
                from (select ow_gid, ow_id, ow_type, 
                    (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master 
                        where c_id = ow_ind_id) as ow_ind_name, ow_huf_name, 
                    ow_pvtltd_comapny_name, ow_ltd_comapny_name, ow_llp_comapny_name, ow_prt_comapny_name, 
                    ow_aop_comapny_name, ow_trs_comapny_name, ow_proprietorship_comapny_name from owner_master 
            where ow_status='Approved' and ow_gid='$gid') A) B 
            where ow_gid='$gid') BB 
            on (AA.tenant_id=BB.c_id)) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.rent_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select rent_id, event_type, event_name, event_date, net_amount 
            from rent_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'rent' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id=D.rent_id) E where E.paid_amount<>E.net_amount) A 
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
            where E.owner_name is not null and E.owner_name<>''";
    }

    $result3=$this->db->query($sql);
    if($result3->num_rows() > 0){
        foreach($result3->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Rent';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="r_".$row->rent_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $i++;
        }
    }

    //for loan
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.loan_id, C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.loan_amount, C.loan_startdate, C.txn_status, C.p_property_name, C.p_display_name, 
            C.p_type, C.p_status from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.loan_amount, A.loan_startdate, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.loan_id, D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, C.loan_amount, C.loan_startdate, C.txn_status from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.loan_amount, A.loan_startdate, A.txn_status from 
            (select txn_id, ref_id, ref_name, null as property_id, null as sub_property_id, loan_amount, loan_startdate, gp_id, txn_status from loan_txn where gp_id = '$gid' and txn_status='Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select loan_id, event_type, event_name, event_date, net_amount 
            from loan_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'loan' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.loan_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id=D.loan_id) E where E.paid_amount<>E.net_amount) A 
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
            on C.property_id=D.purchase_id) E ";
    } else {
        $sql="select * from 
            (select C.txn_id, D.owner_name, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.loan_id, C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.loan_amount, C.loan_startdate, C.txn_status, C.p_property_name, C.p_display_name, 
            C.p_type, C.p_status from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.loan_amount, A.loan_startdate, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.loan_id, D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, C.loan_amount, C.loan_startdate, C.txn_status from 
            (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.loan_amount, A.loan_startdate, A.txn_status from 
            (select txn_id, ref_id, ref_name, null as property_id, null as sub_property_id, loan_amount, loan_startdate, gp_id, txn_status from loan_txn where gp_id = '$gid' and txn_status='Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select loan_id, event_type, event_name, event_date, net_amount 
            from loan_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'loan' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.loan_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id=D.loan_id) E where E.paid_amount<>E.net_amount) A 
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
            on C.property_id=D.purchase_id) E ";
    }

    $result4=$this->db->query($sql);
    if($result4->num_rows() > 0){
        foreach($result4->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Loan';
            $dataarray[$i]['event_name']=$row->event_name;
            // $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['property']=$row->ref_id;
            $dataarray[$i]['prop_id']="l_".$row->loan_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=$row->ref_id;
            $dataarray[$i]['ref_name']=$row->ref_name;
            $i++;
        }
    }

    //for expense
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.expense_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.expense_date, C.txn_status, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.expense_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.expense_date, A.txn_status, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.expense_id, D.event_type, D.event_name, 
                D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.expense_date, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.expense_date, A.txn_status from 
            (select * from expense_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.expense_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select expense_id, event_type, event_name, event_date, net_amount 
            from expense_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'expense' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.expense_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id = D.expense_id) E where E.paid_amount<>E.net_amount) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C) E";
    } else {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.expense_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.expense_date, C.txn_status, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.expense_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.expense_date, A.txn_status, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.expense_id, D.event_type, D.event_name, 
                D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.expense_date, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.expense_date, A.txn_status from 
            (select * from expense_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.expense_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select expense_id, event_type, event_name, event_date, net_amount 
            from expense_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'expense' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.expense_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id = D.expense_id) E where E.paid_amount<>E.net_amount) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C) E";
    }
    $result5=$this->db->query($sql);
    if($result5->num_rows() > 0){
        foreach($result5->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Expense';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="e_".$row->expense_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $i++;
        }
    }


    //for maintenance
    if ($blOwnerExist==true) {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.m_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.txn_status, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.m_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.txn_status, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.m_id, D.event_type, D.event_name, 
                D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' and txn_status = 'Approved' and 
                property_id in (select distinct purchase_id from purchase_ownership_details 
                                    where pr_client_id in (select distinct owner_id from user_role_owners 
                                        where user_id = '$session_id'))) A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.m_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select m_id, event_type, event_name, event_date, net_amount 
            from maintenance_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'maintenance' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.m_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id = D.m_id) E where E.paid_amount<>E.net_amount) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C) E";
    } else {
        $sql="select * from 
            (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.m_id, 
                C.event_type, C.event_name, C.event_date, C.net_amount, C.paid_amount, C.txn_status, 
                C.p_property_name, C.p_display_name, C.p_type, C.p_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.m_id, A.event_type, A.event_name, 
                A.event_date, A.net_amount, A.paid_amount, A.txn_status, B.p_property_name, 
                B.p_display_name, B.p_type, B.p_status from 
            (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.m_id, D.event_type, D.event_name, 
                D.event_date, case when D.net_amount is null then 0 else D.net_amount end as net_amount, 
                case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount, C.txn_status from 
            (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
            (select * from maintenance_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
            on A.sub_property_id = B.txn_id) C 
            left join 
            (select * from 
            (select A.m_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
            (select m_id, event_type, event_name, event_date, net_amount 
            from maintenance_schedule where status = '1') A 
            left join 
            (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
            from actual_schedule where table_type = 'maintenance' group by fk_txn_id, event_type, event_name, event_date) B 
            on (A.m_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C 
            where C.paid_amount<>C.net_amount) D 
            on C.txn_id = D.m_id) E where E.paid_amount<>E.net_amount) A 
            left join 
            (select * from purchase_txn where gp_id = '$gid') B 
            on A.property_id=B.txn_id) C) E";
    }
    $result6=$this->db->query($sql);
    if($result6->num_rows() > 0){
        foreach($result6->result() as $row){
            $dataarray[$i]['due_date']=$row->event_date;
            $dataarray[$i]['particulars']='Maintenance';
            $dataarray[$i]['event_name']=$row->event_name;
            $dataarray[$i]['property']=$row->p_property_name;
            $dataarray[$i]['prop_id']="m_".$row->m_id;
            $dataarray[$i]['sub_property']=$row->sp_name;
            $dataarray[$i]['txn_status']=$row->txn_status;
            $dataarray[$i]['net_amount']=$row->net_amount;
            $dataarray[$i]['paid_amount']=$row->paid_amount;
            $dataarray[$i]['ref_id']=null;
            $dataarray[$i]['ref_name']=null;
            $i++;
        }
    }

    return $dataarray;
}


function getOtherExpenseDetail($fk_txn_id, $bank_entry_id=null, $entry_type=null){
    $fk_txn_id=explode("_",$fk_txn_id);

    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $schedule_table="actual_".$tableType;
    $sch_type_id='';

    $dataarray['property_id']=0;
    $dataarray['sub_property_id']=0;
    $dataarray['txn_type']=$tableType;

    $gid=$this->session->userdata('groupid');

    $dataarray['payment']='selected';
    $dataarray['receipt']='';
    $dataarray['expense']='selected';

    $created_on='';
    $fk_created_on=null;
    $dataarray['txn_fkid']='';
    $dataarray['txn_status']='Approved';
    $dataarray['remarks']='';
    $dataarray['maker_remark']='';
    $dataarray['modified_by']='';
    $dataarray['created_by']='';
    $dataarray['payment_mode']='';
    $dataarray['account_number']='';
    $dataarray['b_name']='';
    $dataarray['payment_date']='';
    $dataarray['cheque_no']='';

    $table_name = "actual_other_expense";

    $sql = "select A.*, concat(B.b_name,' - ',B.b_accountnumber) as b_name from 
            (select * from ".$table_name." where id='$bank_entry_id') A 
            left join 
            (select * from bank_master where b_status='Approved') B 
            on A.account_number=B.b_id";
    $query=$this->db->query($sql);
    if($query->num_rows() >0){
        $result=$query->result();
        $created_on=$result[0]->created_on;
        $fk_created_on=null;
        $txn_fkid=$result[0]->txn_fkid;

        $dataarray['txn_fkid']=$txn_fkid;
        $dataarray['txn_status']=$result[0]->txn_status;
        $dataarray['remarks']=$result[0]->remarks;
        $dataarray['maker_remark']=$result[0]->maker_remark;
        $dataarray['created_by']=$result[0]->created_by;
        $dataarray['modified_by']=$result[0]->modified_by;
        $dataarray['payment_mode']=$result[0]->payment_mode;
        $dataarray['account_number']=$result[0]->account_number;
        $dataarray['b_name']=$result[0]->b_name;
        $dataarray['payment_date']=$result[0]->payment_date;
        $dataarray['cheque_no']=$result[0]->cheque_no;
    }

    $dataarray['created_on']=$created_on;
    $dataarray['fk_created_on']=$fk_created_on;

    $sql="select * from 
        (select A.*, B.p_property_name from 
        (select * from actual_other_expense where id='" . $fk_txn_id[1] . "' and gp_id = '$gid') A 
        left join 
        (select * from purchase_txn where gp_id = '$gid') B 
        on A.property_id = B.txn_id) C";
    $query=$this->db->query($sql);
    $result=$query->result();

    if(count($result)>0){
        $dataarray['expense_category']=$result[0]->expense_category;
        $dataarray['property_id']=$result[0]->property_id;
        $dataarray['property_name']=$result[0]->p_property_name;
        $dataarray['sub_property_id']=$result[0]->sub_property_id;
        $dataarray['expense_description']=$result[0]->expense_description;
        $dataarray['expense_date']=$result[0]->expense_date;
        $dataarray['expense_amount']=$result[0]->expense_amount;
    }

    $dataarray['fk_txn_id']=implode('_',$fk_txn_id);
    $dataarray['bank_entry_id']=$bank_entry_id;
    $dataarray['entry_type']=$entry_type;
    $dataarray['other_expense']='true';
    
    return $dataarray;
}


function getOtherScheduleDetail($fk_txn_id, $bank_entry_id=null, $entry_type=null){
    $fk_txn_id=explode("_",$fk_txn_id);

    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $schedule_table="actual_".$tableType;
    $sch_type_id='';

    $dataarray['property_id']=0;
    $dataarray['sub_property_id']=0;
    $dataarray['txn_type']=$tableType;

    $gid=$this->session->userdata('groupid');

    $dataarray['payment']='selected';
    $dataarray['receipt']='';
    $dataarray['other']='selected';

    $created_on='';
    $fk_created_on=null;
    $dataarray['txn_fkid']='';
    $dataarray['txn_status']='Approved';
    $dataarray['remarks']='';
    $dataarray['maker_remark']='';
    $dataarray['modified_by']='';
    $dataarray['created_by']='';
    $dataarray['payment_mode']='';
    $dataarray['account_number']='';
    $dataarray['b_name']='';
    $dataarray['payment_date']='';
    $dataarray['cheque_no']='';

    $table_name = "actual_other_schedule";

    $sql = "select A.*, concat(B.b_name,' - ',B.b_accountnumber) as b_name from 
            (select * from ".$table_name." where id='$bank_entry_id') A 
            left join 
            (select * from bank_master where b_status='Approved') B 
            on A.account_number=B.b_id";
    $query=$this->db->query($sql);
    if($query->num_rows() >0){
        $result=$query->result();
        $created_on=$result[0]->created_on;
        $fk_created_on=null;
        $txn_fkid=$result[0]->txn_fkid;

        $dataarray['txn_fkid']=$txn_fkid;
        $dataarray['txn_status']=$result[0]->txn_status;
        $dataarray['remarks']=$result[0]->remarks;
        $dataarray['maker_remark']=$result[0]->maker_remark;
        $dataarray['created_by']=$result[0]->created_by;
        $dataarray['modified_by']=$result[0]->modified_by;
        $dataarray['payment_mode']=$result[0]->payment_mode;
        $dataarray['account_number']=$result[0]->account_number;
        $dataarray['b_name']=$result[0]->b_name;
        $dataarray['payment_date']=$result[0]->payment_date;
        $dataarray['cheque_no']=$result[0]->cheque_no;

        if($result[0]->type=="payment"){
            $dataarray['payment']='selected';
            $dataarray['receipt']='';
        } else {
            $dataarray['payment']='';
            $dataarray['receipt']='selected';
        }
    }

    $dataarray['created_on']=$created_on;
    $dataarray['fk_created_on']=$fk_created_on;

    $sql="select * from 
        (select A.*, B.p_property_name from 
        (select * from actual_other_schedule where id='" . $fk_txn_id[1] . "' and gp_id = '$gid') A 
        left join 
        (select * from purchase_txn where gp_id = '$gid') B 
        on A.property_id = B.txn_id) C";
    $query=$this->db->query($sql);
    $result=$query->result();

    if(count($result)>0){
        $dataarray['type']=$result[0]->type;
        $dataarray['property_id']=$result[0]->property_id;
        $dataarray['property_name']=$result[0]->p_property_name;
        $dataarray['sub_property_id']=$result[0]->sub_property_id;
        $dataarray['description']=$result[0]->description;
        $dataarray['sch_date']=$result[0]->sch_date;
        $dataarray['amount']=$result[0]->amount;
    }

    $dataarray['fk_txn_id']=implode('_',$fk_txn_id);
    $dataarray['bank_entry_id']=$bank_entry_id;
    $dataarray['entry_type']=$entry_type;
    $dataarray['other_schedule']='true';
    
    return $dataarray;
}


function getAllPropertyDetail($fk_txn_id, $bank_entry_id=null, $entry_type=null){
    $fk_txn_id=explode("_",$fk_txn_id);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $schedule_table=$tableType."_schedule";
    $sch_type_id='';
    $dataarray['property_id']=0;
    $dataarray['sub_property_id']=0;
    $dataarray['txn_type']=$tableType;
    $gid=$this->session->userdata('groupid');
    $tot_outstanding=0;

    $maintenance_by='Owner';
    $property_tax_by='Owner';

    if($fk_txn_id[0]=='p'){
        $sch_type_id='purchase_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['purchase']='selected';
        $tax_type='purchase';
        $dataarray['property_id']=$fk_txn_id[1];
    }
    if($fk_txn_id[0]=='s'){
        $sch_type_id='sale_id';
        $dataarray['receipt']='selected';
        $dataarray['payment']='';
        $dataarray['sale']='selected';
        $tax_type='sale';

        $query=$this->db->query("select * from sales_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }
    if($fk_txn_id[0]=='r'){
        $sch_type_id='rent_id';
        $dataarray['receipt']='selected';
        $dataarray['payment']='';
        $dataarray['rent']='selected';
        $tax_type='rent';

        $query=$this->db->query("select * from rent_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }
    if($fk_txn_id[0]=='l'){
        $sch_type_id='loan_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['loan']='selected';
        $tax_type='loan';
        $dataarray['loan_txn_id']=$fk_txn_id[1];
        
        $query=$this->db->query("select * from loan_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['int_type']=$result[0]->interest_type;
            $dataarray['int_rate']=$result[0]->loan_interest_rate;
            $dataarray['tot_outstanding']=$result[0]->loan_amount;
            $dataarray['last_paid_date']=$result[0]->loan_startdate;
            $tot_outstanding=$dataarray['tot_outstanding'];
        }

        // $query=$this->db->query("select * from actual_schedule where id = (select max(id) from actual_schedule where fk_txn_id = '" . $fk_txn_id[1] . "' and table_type='loan' and txn_status='Approved')");
        // $result=$query->result();
        // if (count($result)>0) {
        //     $dataarray['last_paid_date']=$result[0]->payment_date;
        // }

        $query=$this->db->query("select sum(disbursement_amount) as tot_outstanding from loan_disbursement where loan_id = '" . $fk_txn_id[1] . "' and txn_status='Approved'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['tot_outstanding']=$result[0]->tot_outstanding;
            $tot_outstanding=$dataarray['tot_outstanding'];
        }
    }
    if($fk_txn_id[0]=='e'){
        $sch_type_id='expense_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['expense']='selected';
        $tax_type='expense';

        $query=$this->db->query("select * from expense_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }
    if($fk_txn_id[0]=='m'){
        $sch_type_id='m_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['maintenance']='selected';
        $tax_type='maintenance';

        $property_id='0';
        $sub_property_id='0';

        $dataarray['maintenance_by']='Owner';
        $dataarray['property_tax_by']='Owner';

        $query=$this->db->query("select * from maintenance_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;

            $property_id=$result[0]->property_id;
            $sub_property_id=$result[0]->sub_property_id;
        }

        $query=$this->db->query("select * from rent_txn where txn_status='Approved' and property_id = '" . $property_id . "' and sub_property_id = '" . $sub_property_id . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['maintenance_by']=$result[0]->maintenance_by;
            $dataarray['property_tax_by']=$result[0]->property_tax_by;

            $maintenance_by=$result[0]->maintenance_by;
            $property_tax_by=$result[0]->property_tax_by;
        }
    }

    $created_on='';
    $fk_created_on=null;
    $dataarray['txn_fkid']='';
    $dataarray['txn_status']='Approved';
    $dataarray['remarks']='';
    $dataarray['maker_remark']='';
    $dataarray['modified_by']='';
    $dataarray['created_by']='';
    $dataarray['payment_mode']='';
    $dataarray['account_number']='';
    $dataarray['b_name']='';
    $dataarray['payment_date']='';
    $dataarray['cheque_no']='';

    if($entry_type=='tax') {
        $table_name = "actual_schedule_taxes";
    } else {
        $table_name = "actual_schedule";
    }

    $sql = "select A.*, concat(B.b_name,' - ',B.b_accountnumber) as b_name from 
            (select * from ".$table_name." where id='$bank_entry_id') A 
            left join 
            (select * from bank_master where b_status='Approved') B 
            on A.account_number=B.b_id";
    
    $query=$this->db->query($sql);
    if($query->num_rows() >0){
        $result=$query->result();
        $created_on=$result[0]->created_on;
        $fk_created_on=$result[0]->fk_created_on;
        $txn_fkid=$result[0]->txn_fkid;

        $dataarray['txn_fkid']=$txn_fkid;
        $dataarray['txn_status']=$result[0]->txn_status;
        $dataarray['remarks']=$result[0]->remarks;
        $dataarray['maker_remark']=$result[0]->maker_remark;
        $dataarray['created_by']=$result[0]->created_by;
        $dataarray['modified_by']=$result[0]->modified_by;
        $dataarray['payment_mode']=$result[0]->payment_mode;
        $dataarray['account_number']=$result[0]->account_number;
        $dataarray['b_name']=$result[0]->b_name;
        $dataarray['payment_date']=$result[0]->payment_date;
        $dataarray['cheque_no']=$result[0]->cheque_no;

        // if(isset($txn_fkid) && $txn_fkid!=''){
        //     $this->db->select('*');
        //     $this->db->from('actual_schedule');
        //     $this->db->where('id="'.$txn_fkid.'"');
        //     $query=$this->db->get();
        //     if($query->num_rows() >0){
        //         $result=$query->result();
        //         $fk_created_on=$result[0]->created_on;
        //     }
        // }
    }

    $dataarray['created_on']=$created_on;
    $dataarray['fk_created_on']=$fk_created_on;

    $this->db->select('tax_id,tax_name,tax_percent,txn_type');
    $this->db->where('status = "1" and tax_action="0"');
    $this->db->where('txn_type like "%'.$tax_type.'%" ');
    $this->db->from('tax_master');
    $result=$this->db->get();
    //echo $this->db->last_query();
    $dataarray['allTaxes']= $result->result();

    if($fk_txn_id[0]=='l'){
        $this->db->select('s.*');
        $this->db->from($schedule_table.' s ');
        $this->db->where(' s.'.$sch_type_id.' = '.$fk_txn_id[1].' and s.status="1"  ');
        $this->db->order_by('s.event_date','ASC');
        $result=$this->db->get();
        // echo $this->db->last_query();

        $row=$result->row();
       // var_dump($result);
    } else {
        $this->db->select('pt.p_property_name,s.*');
        $this->db->from('purchase_txn pt , '.$schedule_table.' s ');
        $this->db->where(' s.'.$sch_type_id.' = '.$fk_txn_id[1].' and s.status="1"  ');
        if($fk_txn_id[0]=='p'){
            $this->db->where('pt.txn_id = s.'.$sch_type_id.' ');
        }
        if($fk_txn_id[0]=='s'){
            $this->db->from('sales_txn st');
            $this->db->where('st.txn_id = s.'.$sch_type_id.' and pt.txn_id = st.property_id');
        }
        if($fk_txn_id[0]=='r'){
            $this->db->from('rent_txn st');
            $this->db->where('st.txn_id = s.'.$sch_type_id.' and pt.txn_id = st.property_id');
        }
        if($fk_txn_id[0]=='e'){
            $this->db->from('expense_txn st');
            $this->db->where('st.txn_id = s.'.$sch_type_id.' and pt.txn_id = st.property_id');
        }
        if($fk_txn_id[0]=='m'){
            $this->db->from('maintenance_txn st');
            $this->db->where('st.txn_id = s.'.$sch_type_id.' and pt.txn_id = st.property_id');
        }
        $this->db->order_by('s.event_date','ASC');
        $result=$this->db->get();
        // echo $this->db->last_query();

        $row=$result->row();
       // var_dump($result);

        $dataarray['property_name']=$row->p_property_name;
    }

    $dataarray['fk_txn_id']=implode('_',$fk_txn_id);
    $dataarray['bank_entry_id']=$bank_entry_id;
    $dataarray['entry_type']=$entry_type;
    $i=0;

    foreach($result->result() as $rowsch){
        if($fk_txn_id[0]=='m'){
            if((($rowsch->event_name=="CAMP (Rs. PSF)" || $rowsch->event_name=="Maintenance") && $maintenance_by=="Tenant") || 
               ($rowsch->event_name=="Property Tax" && $property_tax_by=="Tenant")) {
                continue;
            }
        }

        $dataarray['schedule_detail'][$i]['event_type']=$rowsch->event_type;
        $dataarray['schedule_detail'][$i]['event_name']=$rowsch->event_name;
        $dataarray['schedule_detail'][$i]['event_date']=$rowsch->event_date;
        $dataarray['schedule_detail'][$i]['net_amount']=$rowsch->net_amount;

        $net_amount=$rowsch->net_amount;
        $this->db->select('*');
        $this->db->from('actual_schedule');
        $this->db->where('fk_txn_id = "'.$fk_txn_id[1].'" and table_type = "' . $tableType . '" and 
                        event_type = "'.$rowsch->event_type.'" and event_name = "'.$rowsch->event_name.'" and 
                        event_date = "'.$rowsch->event_date.'"');
        $result_sch=$this->db->get();
        $amount_paid_till_date=0;
        $amount_paid_till_date_pending=0;
        $tds_amount_paid=0;
        $balance_amount=0;
        $tax_applied="";
        $int_type="";
        $int_rate="";
        $interest="";
        $principal="";
        if($result_sch->num_rows()>0){
            foreach($result_sch->result() as $sch){
                if($sch->txn_status=='Approved' && $sch->created_on!=$created_on) {
                    if($sch->created_on!=$fk_created_on){
                        $amount_paid_till_date=$amount_paid_till_date+$sch->paid_amount+$sch->tds_amount;
                        $tot_outstanding=$tot_outstanding-$sch->principal;
                        $dataarray['last_paid_date']=$sch->payment_date;
                    }
                } else {
                    if($sch->created_on==$created_on){
                        $tax_applied=$tax_applied.$sch->tax_applied;
                        $int_type=$sch->int_type;
                        $int_rate=round($sch->int_rate);
                        $interest=round($sch->interest);
                        $principal=round($sch->principal);
                        $amount_paid_till_date_pending=$amount_paid_till_date_pending+$sch->paid_amount;
                        $tds_amount_paid=$tds_amount_paid+$sch->tds_amount;
                    }
                }
            }
            $balance_amount=$net_amount-$amount_paid_till_date-$amount_paid_till_date_pending-$tds_amount_paid;
        }
        $dataarray['schedule_detail'][$i]['amount_paid']=$amount_paid_till_date;
        $dataarray['schedule_detail'][$i]['amount_paid_pending']=$amount_paid_till_date_pending;
        $dataarray['schedule_detail'][$i]['tds_amount_paid']=$tds_amount_paid;
        $dataarray['schedule_detail'][$i]['balance_amount']=$balance_amount;
        $dataarray['schedule_detail'][$i]['tax_applied']=$tax_applied;
        $dataarray['schedule_detail'][$i]['int_type']=$int_type;
        $dataarray['schedule_detail'][$i]['int_rate']=$int_rate;
        $dataarray['schedule_detail'][$i]['interest']=$interest;
        $dataarray['schedule_detail'][$i]['principal']=$principal;

        $i++;
    }


    $dataarray['tot_outstanding']=$tot_outstanding;


    // $result=$this->db->query("select A.id, A.fk_txn_id, A.tax_applied, A.tax_id, B.tax_name, A.net_amount, A.tax_amount, 
    //                         A.amount_paid, A.balance from 
    //                         (select id, fk_txn_id, tax_applied, 
    //                             case when instr(tax_applied,'_')>0 then substring(tax_applied,1,instr(tax_applied,'_')-1) else 0 end as tax_id, 
    //                             net_amount, tax_amount, total_amount_paid as amount_paid, balance from actual_schedule_taxes A 
    //                             where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and txn_status = 'Approved' and 
    //                             id=(select max(id) from actual_schedule_taxes B where A.tax_applied = B.tax_applied and 
    //                                 fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and txn_status = 'Approved')) A 
    //                         left join 
    //                         (select * from tax_master) B 
    //                         on A.tax_id=B.tax_id");

    // $i=0;

    // foreach($result->result() as $rowsch){
    //     $dataarray['schedule_tax_detail'][$i]['txn_id']=$rowsch->id;
    //     $dataarray['schedule_tax_detail'][$i]['fk_txn_id']=$rowsch->fk_txn_id;
    //     $dataarray['schedule_tax_detail'][$i]['tax_applied']=$rowsch->tax_applied;
    //     $dataarray['schedule_tax_detail'][$i]['tax_id']=$rowsch->tax_id;
    //     $dataarray['schedule_tax_detail'][$i]['tax_name']=$rowsch->tax_name;
    //     $dataarray['schedule_tax_detail'][$i]['net_amount']=$rowsch->net_amount;
    //     $dataarray['schedule_tax_detail'][$i]['tax_amount']=$rowsch->tax_amount;
    //     $dataarray['schedule_tax_detail'][$i]['tax_amount_actual']=$rowsch->tax_amount;
    //     $dataarray['schedule_tax_detail'][$i]['amount_paid']=$rowsch->amount_paid;
    //     $dataarray['schedule_tax_detail'][$i]['balance_amount']=$rowsch->balance;

    //     $i++;
    // }


   //  //amount paid 
   //  //get Tax amount
   //  $this->db->select('tax_amount,paid_tax_amount');
   //  $this->db->from('actual_schedule');
   //  $this->db->where('fk_txn_id = "'.$fk_txn_id[1].'" and table_type = "' . $tableType . '" and id = (select max(id) from actual_schedule where fk_txn_id = "'.$fk_txn_id[1].'" and table_type = "' . $tableType . '")');
   // // $this->db->order_by('id','ASC');
   // //$this->db->limit('1,0');
   //  $result_tax=$this->db->get();
   // // echo $this->db->last_query();
   //  $tax_amount=0;
   //  $tax_paid_amount=0;
   //  if($result_tax->num_rows() > 0){
   //      foreach($result_tax->result() as $rowtax){
   //          $tax_amount=$tax_amount+$rowtax->tax_amount;
   //          $tax_paid_amount=$tax_paid_amount+$rowtax->paid_tax_amount;
   //      }
   //  }
   //  $dataarray['tax_amount']=$tax_amount;
   //  $dataarray['tax_paid_amount']=$tax_paid_amount;
   //  $dataarray['tax_differnece']=$tax_amount-$tax_paid_amount;



    $this->db->select('tax_applied,tax_amount,paid_tax_amount,net_amount,paid_amount,total_amount_paid,payment_mode,account_number,payment_date,cheque_no');
    $this->db->from('actual_schedule');
    $this->db->where('fk_txn_id = "'.$fk_txn_id[1].'" and table_type = "' . $tableType . '" ');
    $actual_schedule_result=$this->db->get();
    if($actual_schedule_result->num_rows() > 0){
        $j=0;
        $total_tax_amount=0;
        $total_paid_amount=0;
        foreach($actual_schedule_result->result() as $row){
            $dataarray['actual_schedule'][$j]['paid_amount']=$row->paid_amount;
            $dataarray['actual_schedule'][$j]['net_amount']=$row->net_amount;
            $dataarray['actual_schedule'][$j]['alltaxes']=$row->tax_applied;
            $dataarray['actual_schedule'][$j]['tax_amount']=$row->tax_amount;
            $dataarray['actual_schedule'][$j]['paid_tax_amount']=$row->paid_tax_amount;
            $dataarray['actual_schedule'][$j]['total_amount_paid']=$row->total_amount_paid;
            $dataarray['actual_schedule'][$j]['payment_mode']=$row->payment_mode;
            $dataarray['actual_schedule'][$j]['account_number']=$row->account_number;
            $dataarray['actual_schedule'][$j]['payment_date']=date('d/m/Y',strtotime($row->payment_date));
            $dataarray['actual_schedule'][$j]['cheque_no']=$row->cheque_no;

            $total_tax_amount =$total_tax_amount + $row->tax_amount;
            $total_paid_amount=$total_paid_amount + $row->paid_amount;
        }

        $dataarray['actual_total_tax_amount']=$total_tax_amount;
        $dataarray['actual_total_paid_Amount']=$total_paid_amount;
    }



    $query=$this->db->query("select * from 
                            (select 'others' as other, sum(C.net_amount) as net_amount, sum(C.paid_amount) as paid_amount, 
                            sum(C.balance) as balance from 
                            (select A.id, A.net_amount, A.paid_amount, A.balance, B.sch_id from 
                            (select id, table_type, event_type, event_name, event_date, concat(trim(event_type), 
                                trim(event_name), trim(event_date)) as temp_col, fk_txn_id, net_amount, paid_amount, balance 
                            from actual_schedule where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '". $tableType ."') A 
                            left join 
                            (select sch_id, event_type, event_name, event_date, concat(trim(event_type), trim(event_name), 
                                trim(event_date)) as temp_col from " . $schedule_table . " 
                            where " . $sch_type_id . "='".$fk_txn_id[1]."' and status='1') B 
                            on A.temp_col = B.temp_col) C 
                            where C.sch_id is null) D where net_amount is not null or paid_amount is not null or balance is not null");
    $result=$query->result();
    if (count($result)>0) {
        $dataarray['others']=$result[0]->other;
        $dataarray['others_net_amount']=$result[0]->net_amount;
        $dataarray['others_paid_amount']=$result[0]->paid_amount;
        $dataarray['others_balance']=$result[0]->balance;
    }

    return $dataarray;
}


function getServiceTax($event_type,$event_name,$event_date,$actual_amount,$fk_txn_id){
    $fk_txn_id=explode('_',$fk_txn_id);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $schedule_table=$tableType."_schedule";
    $table_name=$tableType."_schedule_taxation";
    $sch_type_id='';
    $dataarray['property_id']=0;
    $dataarray['sub_property_id']=0;

    if($fk_txn_id[0]=='p'){
        $sch_type_id='purchase_id';
    }
    if($fk_txn_id[0]=='s'){
        $sch_type_id='sale_id';
    }
    if($fk_txn_id[0]=='r'){
        $sch_type_id='rent_id';
    }
    if($fk_txn_id[0]=='l'){
        $sch_type_id='loan_id';
    }
    if($fk_txn_id[0]=='e'){
        $sch_type_id='expense_id';
    }
    if($fk_txn_id[0]=='m'){
        $sch_type_id='m_id';
    }

    $this->db->select('sch_id');
    $this->db->from($schedule_table);
    $this->db->where('event_type = "'.$event_type.'" and event_name = "'.$event_name.'" and event_date = "'.$event_date.'" and '. $sch_type_id .' = '.$fk_txn_id[1].' ');
    $query=$this->db->get();
    if($query->num_rows() > 0){
        $result=$query->result();
        $schedule_id=$result[0]->sch_id;
    } else {
        $schedule_id=0;
    }

    $this->db->select('tax_percent');
    $this->db->from($table_name);
    $this->db->where('sch_id = '.$schedule_id.' ');
    $result=$this->db->get();
    $total_tax_amount=0;
    if($result->num_rows() > 0){
        foreach($result->result() as $row){
            $actual_amount = format_number($actual_amount,2);
            $tax_amount=round(($actual_amount * $row->tax_percent)/100);
            $total_tax_amount=$total_tax_amount+$tax_amount;
        }
        $response=array("status"=>true,"tax_amount"=>$total_tax_amount);
    }
    else{
        $response=array("status"=>false,"tax_amount"=>$total_tax_amount);

    }
    return $response;
}

function TaxDetails($form_data){
    $fk_txn_id=explode('_',$form_data['fk_txn_id']);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');

    // echo "<script>console.log('".$fk_txn_id."');</script>";

    $created_on=$form_data['created_on'];
    if(isset($form_data['fk_created_on'])){
        $fk_created_on=$form_data['fk_created_on'];
    } else {
        $fk_created_on='';
    }
    $txn_status=$form_data['txn_status'];
    if(isset($form_data['txn_fkid'])){
        $txn_fkid=$form_data['txn_fkid'];
    } else {
        $txn_fkid='';
    }

    $dataarray['schedule_tax_detail']=array();

    $result=$this->db->query("select A.id, A.fk_txn_id, A.tax_applied, A.created_on, A.txn_status, A.tax_id, B.tax_name, 
                            A.net_amount, A.tax_amount, A.amount_paid, A.total_amount_paid, A.balance from 
                            (select id, fk_txn_id, tax_applied, created_on, txn_status, 
                                case when instr(tax_applied,'_')>0 then substring(tax_applied,1,instr(tax_applied,'_')-1) else 0 end as tax_id, 
                                net_amount, tax_amount, amount_paid, total_amount_paid, balance from actual_schedule_taxes A 
                                where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and txn_status = 'Approved' and 
                                id=(select max(id) from actual_schedule_taxes B where A.tax_applied = B.tax_applied and 
                                    fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and txn_status = 'Approved')) A 
                            left join 
                            (select * from tax_master where tax_action='0') B 
                            on A.tax_id=B.tax_id");

    $row=0;

    foreach($result->result() as $rowsch){
        $dataarray['schedule_tax_detail'][$row]['txn_id']=$rowsch->id;
        $dataarray['schedule_tax_detail'][$row]['fk_txn_id']=$rowsch->fk_txn_id;
        $dataarray['schedule_tax_detail'][$row]['tax_applied']=$rowsch->tax_applied;
        $dataarray['schedule_tax_detail'][$row]['tax_id']=$rowsch->tax_id;
        $dataarray['schedule_tax_detail'][$row]['tax_name']=$rowsch->tax_name;
        $dataarray['schedule_tax_detail'][$row]['net_amount']=$rowsch->net_amount;
        $dataarray['schedule_tax_detail'][$row]['tax_amount']=$rowsch->tax_amount;
        $dataarray['schedule_tax_detail'][$row]['tax_amount_actual']=$rowsch->tax_amount;
        $dataarray['schedule_tax_detail'][$row]['amount_paid']=$rowsch->total_amount_paid;
        $dataarray['schedule_tax_detail'][$row]['total_amount_paid']=$rowsch->total_amount_paid;
        $dataarray['schedule_tax_detail'][$row]['amount_paid_pending']=0;
        $dataarray['schedule_tax_detail'][$row]['balance_amount']=$rowsch->balance;
        $dataarray['schedule_tax_detail'][$row]['amount_paid_status']=false;

        $row++;
    }

    if (count($dataarray['schedule_tax_detail'])>0){
        if($txn_status=='Approved' || $fk_created_on!=''){
            if($txn_status=='Approved'){
                $query=$this->db->query("select * from actual_schedule 
                                        where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                        txn_status = 'Approved' and created_on = '$created_on'");
            } else {
                $query=$this->db->query("select * from actual_schedule 
                                        where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                        txn_status = 'Approved' and created_on = '$fk_created_on'");
            }
            $result=$query->result();

            if (count($result)>0){
                for($i=0;$i<count($result);$i++){
                    $paid_amount=floatval($result[$i]->paid_amount) + floatval($result[$i]->tds_amount);
                    $tax_applied=$result[$i]->tax_applied;
                    $event_type=$result[$i]->event_type;
                    $event_name=$result[$i]->event_name;
                    $event_date=$result[$i]->event_date;

                    if ($tableType=='purchase'){
                        $selectedTaxes=explode(',',$tax_applied);
                    } else if ($tableType=='sales'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from sales_schedule_taxation 
                                                where sale_id='".$fk_txn_id[1]."' and sch_id = (select sch_id from sales_schedule 
                                                    where sale_id='".$fk_txn_id[1]."' and 
                                                    event_type='".$event_type."' and event_name='".$event_name."' and 
                                                    event_date='".$event_date."' and status='1' limit 1)");
                        $result2=$query->result();
                        $tax_details=array();
                        if(count($result2)>0){
                            for($a=0;$a<count($result2);$a++){
                                $selectedTaxes[$a]=$result2[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='rent'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from rent_schedule_taxation 
                                                where rent_id='".$fk_txn_id[1]."' and sch_id = (select sch_id from rent_schedule 
                                                    where rent_id='".$fk_txn_id[1]."' and 
                                                          event_type='".$event_type."' and event_name='".$event_name."' and 
                                                          event_date='".$event_date."' and status='1' limit 1)");
                        $result2=$query->result();
                        $tax_details=array();
                        if(count($result2)>0){
                            for($a=0;$a<count($result2);$a++){
                                $selectedTaxes[$a]=$result2[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='loan'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from loan_schedule_taxation 
                                                where loan_id='".$fk_txn_id[1]."' and sch_id = (select sch_id from loan_schedule 
                                                    where loan_id='".$fk_txn_id[1]."' and 
                                                          event_type='".$event_type."' and event_name='".$event_name."' and 
                                                          event_date='".$event_date."' and status='1' limit 1)");
                        $result2=$query->result();
                        $tax_details=array();
                        if(count($result2)>0){
                            for($a=0;$a<count($result2);$a++){
                                $selectedTaxes[$a]=$result2[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='expense'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from expense_schedule_taxation 
                                                where expense_id='".$fk_txn_id[1]."' and sch_id = (select sch_id 
                                                    from expense_schedule where expense_id='".$fk_txn_id[1]."' and 
                                                    event_type='".$event_type."' and event_name='".$event_name."' and 
                                                    event_date='".$event_date."' and status='1' limit 1)");
                        $result2=$query->result();
                        $tax_details=array();
                        if(count($result2)>0){
                            for($a=0;$a<count($result2);$a++){
                                $selectedTaxes[$a]=$result2[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='maintenance'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from maintenance_schedule_taxation 
                                                where m_id='".$fk_txn_id[1]."' and sch_id = (select sch_id 
                                                    from maintenance_schedule where m_id='".$fk_txn_id[1]."' and 
                                                    event_type='".$event_type."' and event_name='".$event_name."' and 
                                                    event_date='".$event_date."' and status='1' limit 1)");
                        $result2=$query->result();
                        $tax_details=array();
                        if(count($result2)>0){
                            for($a=0;$a<count($result2);$a++){
                                $selectedTaxes[$a]=$result2[$a]->tax_detail;
                            }
                        }
                    }
                    

                    if ($tableType=='purchase' || $tableType=='expense' || $tableType=='maintenance'){
                        //Do nothing
                    } else {
                        $exact_percent=0;
                        for($j=0;$j<count($selectedTaxes);$j++){
                            $percenttax=$selectedTaxes[$j];
                            $percent1=explode('_',$percenttax);
                            $exact_percent=$exact_percent+$percent1[1];
                        }
                        $paid_amount=($paid_amount*100)/(100+$exact_percent);
                    }
                    
                    for($j=0;$j<count($selectedTaxes);$j++){
                        $percenttax=$selectedTaxes[$j];
                        $percent1=explode('_',$percenttax);
                        $tax_id=0;
                        $tax_id=$percent1[0];
                        $exact_percent=0;
                        $exact_percent=$percent1[1];
                        $percentAmount=0;
                        if ($tableType=='purchase' || $tableType=='expense' || $tableType=='maintenance'){
                            $percentAmount=intval($exact_percent*$paid_amount/100);
                        } else {
                            // $paid_amount=($paid_amount*100)/(100+$exact_percent);
                            $percentAmount=intval($exact_percent*$paid_amount/100);
                            // $paid_amount=intval($paid_amount);
                        }
                        
                        for($l=0;$l<count($dataarray['schedule_tax_detail']);$l++){
                            if($dataarray['schedule_tax_detail'][$l]['tax_id']==$tax_id){
                                $net_amount=intval($dataarray['schedule_tax_detail'][$l]['net_amount']);
                                $tax_amount=intval($dataarray['schedule_tax_detail'][$l]['tax_amount']);
                                $tax_amount_paid=intval($dataarray['schedule_tax_detail'][$l]['total_amount_paid']);

                                $net_amount=$net_amount-$paid_amount;
                                $tax_amount=$tax_amount-$percentAmount;

                                $dataarray['schedule_tax_detail'][$l]['net_amount']=$net_amount;
                                $dataarray['schedule_tax_detail'][$l]['tax_amount']=$tax_amount;
                                $dataarray['schedule_tax_detail'][$l]['tax_amount_actual']=$tax_amount;
                                $dataarray['schedule_tax_detail'][$l]['balance_amount']=$tax_amount-$tax_amount_paid;
                            }
                        }
                    }
                }
            }

            if($txn_status=='Approved'){
                $query=$this->db->query("select * from actual_schedule_taxes 
                                        where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                        txn_status = 'Approved' and created_on = '$created_on'");
            } else {
                $query=$this->db->query("select * from actual_schedule_taxes 
                                        where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                        txn_status = 'Approved' and created_on = '$fk_created_on'");
            }
            $result=$query->result();
            if (count($result)>0){
                for($i=0;$i<count($result);$i++){
                    $tax_applied=$result[$i]->tax_applied;
                    $tax_amount_paid=$result[$i]->amount_paid;

                    for($l=0;$l<count($dataarray['schedule_tax_detail']);$l++){
                        if($tax_applied==$dataarray['schedule_tax_detail'][$l]['tax_applied']){
                            $tax_amount=$dataarray['schedule_tax_detail'][$l]['tax_amount'];
                            $amount_paid=$dataarray['schedule_tax_detail'][$l]['amount_paid'];
                            $total_amount_paid=$dataarray['schedule_tax_detail'][$l]['total_amount_paid'];

                            $amount_paid=$amount_paid-$tax_amount_paid;
                            $total_amount_paid=$total_amount_paid-$tax_amount_paid;

                            $dataarray['schedule_tax_detail'][$l]['amount_paid']=$amount_paid;
                            $dataarray['schedule_tax_detail'][$l]['total_amount_paid']=$total_amount_paid;
                            if($txn_status=='Approved'){
                                $dataarray['schedule_tax_detail'][$l]['amount_paid_pending']=$tax_amount_paid;
                            }
                            // $dataarray['schedule_tax_detail'][$l]['balance_amount']=$tax_amount-$total_amount_paid-$tax_amount_paid;
                        }
                    }
                }
            }
        }



        $query=$this->db->query("select * from actual_schedule_taxes 
                                where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                txn_status = '$txn_status' and created_on = '$created_on'");
        $result=$query->result();

        if (count($result)>0){
            for($i=0;$i<count($result);$i++){
                $tax_applied=$result[$i]->tax_applied;
                $amount_paid_pending=$result[$i]->amount_paid;

                for($l=0;$l<count($dataarray['schedule_tax_detail']);$l++){
                    if($tax_applied==$dataarray['schedule_tax_detail'][$l]['tax_applied']){
                        $tax_amount=$dataarray['schedule_tax_detail'][$l]['tax_amount'];
                        $amount_paid=$dataarray['schedule_tax_detail'][$l]['amount_paid'];

                        $amount_paid=$amount_paid+$amount_paid_pending;

                        $dataarray['schedule_tax_detail'][$l]['amount_paid']=$amount_paid;
                        $dataarray['schedule_tax_detail'][$l]['amount_paid_pending']=$amount_paid_pending;
                        $dataarray['schedule_tax_detail'][$l]['balance_amount']=$tax_amount-$amount_paid;
                        $dataarray['schedule_tax_detail'][$l]['amount_paid_status']=true;
                    }
                }
            }
        }
    }

    $i=0;

    if(isset($form_data['paid_amount'])){
        foreach($form_data['paid_amount'] as $rowsch){
            $form_data['paid_amount'][$i]=format_number($form_data['paid_amount'][$i],2);
            $form_data['paid_amount_actual'][$i]=format_number($form_data['paid_amount_actual'][$i],2);

        // for($i=0;$i<count($form_data['actual_amount']);$i++){
            if($form_data['paid_amount'][$i] != '0' && $form_data['paid_amount'][$i] != null && 
               $form_data['paid_amount'][$i] != '' && $form_data['paid_amount'][$i]!=$form_data['paid_amount_actual'][$i]){

                $paid_amount=intval($form_data['paid_amount'][$i]-$form_data['paid_amount_actual'][$i]);
                $event_type=$form_data['event_type'][$i];
                $event_name=$form_data['event_name'][$i];
                $event_date=$form_data['event_date'][$i];
                // $total_tax_amount=0;

                // if($this->input->post('extra_taxes_'.($i+1)) != ''){
                    $taxesExtra="";
                    $selectedTaxes=array();

                    if ($tableType=='purchase'){
                        if($this->input->post('extra_taxes_'.($i+1)) != ''){
                            $taxesExtra=implode(',',$form_data['extra_taxes_'.($i+1)]);
                            $selectedTaxes=explode(',',$taxesExtra);
                        }
                    } else if ($tableType=='sales'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from sales_schedule_taxation 
                                                where sale_id='".$fk_txn_id[1]."' and sch_id = (select sch_id from sales_schedule 
                                                    where sale_id='".$fk_txn_id[1]."' and event_type='".$event_type."' and 
                                                          event_name='".$event_name."' and event_date='".$event_date."' and status='1' limit 1)");
                        $result=$query->result();
                        $tax_details=array();
                        if(count($result)>0){
                            for($a=0;$a<count($result);$a++){
                                $selectedTaxes[$a]=$result[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='rent'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from rent_schedule_taxation 
                                                where rent_id='".$fk_txn_id[1]."' and sch_id = (select sch_id from rent_schedule 
                                                    where rent_id='".$fk_txn_id[1]."' and event_type='".$event_type."' and 
                                                          event_name='".$event_name."' and event_date='".$event_date."' and status='1' limit 1)");
                        $result=$query->result();
                        $tax_details=array();
                        if(count($result)>0){
                            for($a=0;$a<count($result);$a++){
                                $selectedTaxes[$a]=$result[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='loan'){
                            $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from loan_schedule_taxation 
                                                    where loan_id='".$fk_txn_id[1]."' and sch_id = (select sch_id from loan_schedule 
                                                        where loan_id='".$fk_txn_id[1]."' and 
                                                              event_type='".$event_type."' and event_name='".$event_name."' and 
                                                              event_date='".$event_date."' and status='1' limit 1)");
                            $result=$query->result();
                            $tax_details=array();
                            if(count($result)>0){
                                for($a=0;$a<count($result);$a++){
                                    $selectedTaxes[$a]=$result[$a]->tax_detail;
                                }
                            }
                        } else if ($tableType=='expense'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from expense_schedule_taxation 
                                                where expense_id='".$fk_txn_id[1]."' and sch_id = (select sch_id 
                                                    from expense_schedule where expense_id='".$fk_txn_id[1]."' and 
                                                    event_type='".$event_type."' and 
                                                    event_name='".$event_name."' and event_date='".$event_date."' and 
                                                    status='1' limit 1)");
                        $result=$query->result();
                        $tax_details=array();
                        if(count($result)>0){
                            for($a=0;$a<count($result);$a++){
                                $selectedTaxes[$a]=$result[$a]->tax_detail;
                            }
                        }
                    } else if ($tableType=='maintenance'){
                        $query=$this->db->query("select concat(tax_master_id,'_',tax_percent) as tax_detail from maintenance_schedule_taxation 
                                                where m_id='".$fk_txn_id[1]."' and sch_id = (select sch_id 
                                                    from maintenance_schedule where m_id='".$fk_txn_id[1]."' and 
                                                    event_type='".$event_type."' and 
                                                    event_name='".$event_name."' and event_date='".$event_date."' and 
                                                    status='1' limit 1)");
                        $result=$query->result();
                        $tax_details=array();
                        if(count($result)>0){
                            for($a=0;$a<count($result);$a++){
                                $selectedTaxes[$a]=$result[$a]->tax_detail;
                            }
                        }
                    }

                    if ($tableType=='purchase' || $tableType=='expense' || $tableType=='maintenance'){
                        //Do nothing
                    } else {
                        $exact_percent=0;
                        for($j=0;$j<count($selectedTaxes);$j++){
                            $percenttax=$selectedTaxes[$j];
                            $percent1=explode('_',$percenttax);
                            $exact_percent=$exact_percent+$percent1[1];
                        }
                        $paid_amount=($paid_amount*100)/(100+$exact_percent);
                    }
                    
                    for($j=0;$j<count($selectedTaxes);$j++){
                        $percenttax=$selectedTaxes[$j];
                        $percent1=explode('_',$percenttax);
                        $tax_id=0;
                        $tax_id=$percent1[0];
                        $exact_percent=0;
                        $exact_percent=$percent1[1];
                        $percentAmount=0;
                        if ($tableType=='purchase' || $tableType=='expense' || $tableType=='maintenance'){
                            $percentAmount=intval($exact_percent*$paid_amount/100);
                        } else {
                            // $paid_amount=($paid_amount*100)/(100+$exact_percent);
                            $percentAmount=round($exact_percent*$paid_amount/100);
                            // $paid_amount=intval($paid_amount);
                        }
                        
                        $tax_amount_paid=0;
                        // $total_tax_amount=$total_tax_amount+$percentAmount;

                        if(isset($form_data['tax_applied'])){
                            $k=0;
                            foreach($form_data['tax_applied'] as $taxsch){
                                $form_data['tax_paid_amount'][$k]=format_number($form_data['tax_paid_amount'][$k],2);
                                if($form_data['tax_applied'][$k]==$percenttax){
                                    $tax_amount_paid=intval($form_data['tax_paid_amount'][$k]);
                                }
                                $k++;
                            }
                        } else {
                            $query=$this->db->query("select * from actual_schedule_taxes 
                                                    where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                                    txn_status = '$txn_status' and created_on = '$created_on' and 
                                                    tax_applied = '$percenttax'");
                            $result=$query->result();

                            if (count($result)>0){
                                $tax_applied=$result[0]->tax_applied;
                                $amount_paid=intval($result[0]->amount_paid);

                                for($l=0;$l<count($dataarray['schedule_tax_detail']);$l++){
                                    if($tax_applied==$dataarray['schedule_tax_detail'][$l]['tax_applied']){
                                        $tax_amount_paid=intval($dataarray['schedule_tax_detail'][$l]['amount_paid']);
                                        if($txn_status!='Approved' && $dataarray['schedule_tax_detail'][$l]['amount_paid_status']==false){
                                            $tax_amount_paid=$amount_paid+$tax_amount_paid;
                                        }
                                        $dataarray['schedule_tax_detail'][$l]['amount_paid']=$tax_amount_paid;
                                    }
                                }
                            }
                        }
                        

                        $blFlag=false;
                        for($l=0;$l<count($dataarray['schedule_tax_detail']);$l++){
                            if($dataarray['schedule_tax_detail'][$l]['tax_id']==$tax_id){
                                // if($tax_amount_paid==null){
                                //     $tax_amount_paid=intval($dataarray['schedule_tax_detail'][$l]['amount_paid']);
                                // }

                                $net_amount=intval($dataarray['schedule_tax_detail'][$l]['net_amount']);
                                $tax_amount=intval($dataarray['schedule_tax_detail'][$l]['tax_amount']);
                                // $balance_amount=intval($dataarray['schedule_tax_detail'][$l]['balance_amount']);

                                $net_amount=$net_amount+$paid_amount;
                                $tax_amount=$tax_amount+$percentAmount;
                                // $balance_amount=$balance_amount+$percentAmount;

                                $dataarray['schedule_tax_detail'][$l]['net_amount']=$net_amount;
                                $dataarray['schedule_tax_detail'][$l]['tax_amount']=$tax_amount;
                                $dataarray['schedule_tax_detail'][$l]['balance_amount']=$tax_amount-$tax_amount_paid;

                                $blFlag=true;
                            }
                        }

                        if($blFlag==false){
                            $query=$this->db->query("select * from tax_master where tax_id = '" . $tax_id . "'");
                            $result2=$query->result();

                            if(count($result2)>0){
                                $tax_name=$result2[0]->tax_name;
                            } else {
                                $tax_name="";
                            }

                            if(!isset($form_data['tax_applied'])){
                                $query=$this->db->query("select * from actual_schedule_taxes 
                                                        where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '".$tableType."' and 
                                                        txn_status = '$txn_status' and created_on = '$created_on' and 
                                                        tax_applied = '$percenttax'");
                                $result=$query->result();

                                if (count($result)>0){
                                    $tax_applied=$result[0]->tax_applied;
                                    $tax_amount_paid=intval($result[0]->amount_paid);
                                }
                            }

                            $dataarray['schedule_tax_detail'][$row]['txn_id']="";
                            $dataarray['schedule_tax_detail'][$row]['fk_txn_id']=$fk_txn_id[1];
                            $dataarray['schedule_tax_detail'][$row]['tax_applied']=$percenttax;
                            $dataarray['schedule_tax_detail'][$row]['tax_id']=$tax_id;
                            $dataarray['schedule_tax_detail'][$row]['tax_name']=$tax_name;
                            $dataarray['schedule_tax_detail'][$row]['net_amount']=$paid_amount;
                            $dataarray['schedule_tax_detail'][$row]['tax_amount']=$percentAmount;
                            $dataarray['schedule_tax_detail'][$row]['tax_amount_actual']=0;
                            $dataarray['schedule_tax_detail'][$row]['amount_paid']=$tax_amount_paid;
                            $dataarray['schedule_tax_detail'][$row]['total_amount_paid']='';
                            $dataarray['schedule_tax_detail'][$row]['amount_paid_pending']=$tax_amount_paid;
                            $dataarray['schedule_tax_detail'][$row]['balance_amount']=$percentAmount-$tax_amount_paid;

                            $row++;
                        }

                    }
                
                // else{
                //     $taxesExtra='';
                // }
            }

            $i++;
        }
    }

    return $dataarray;
}

function getTaxDetailsView($form_data){
    if ($form_data['fk_txn_id']!=null && $form_data['fk_txn_id']!="") {

        $data['property_details']=$this->TaxDetails($form_data);

        $html=$this->load->view('bank_entry/schedule_tax_detail_view',$data,true);
        $response=array('status'=>true,"htmldata"=>$html);
        return $response;
    } else {
        return "";
    }
}

function getTaxDetails($form_data){
    if ($form_data['fk_txn_id']!=null && $form_data['fk_txn_id']!="") {
        $data['property_details']=$this->TaxDetails($form_data);
        $html=$this->load->view('bank_entry/schedule_tax_detail',$data,true);
        $response=array('status'=>true,"htmldata"=>$html);
        return $response;
    } else {
        return "";
    }
}

function getPaidDetails($event_type,$event_name,$event_date,$fk_txn_id){
    $fk_txn_id=explode("_",$fk_txn_id);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $dataarray['table_type']=$tableType;

    $this->db->select('tax_applied,tax_amount,paid_tax_amount,net_amount,paid_amount,tds_amount,total_amount_paid,payment_mode,account_number,payment_date,cheque_no');
    $this->db->from('actual_schedule');
    $this->db->where('fk_txn_id = "'.$fk_txn_id[1].'" and table_type = "' . $tableType . '" and event_type = "'.$event_type.'" and event_name = "'.$event_name.'" and event_date = "'.$event_date.'" and txn_status="Approved"');
    $actual_schedule_result=$this->db->get();
    if($actual_schedule_result->num_rows() > 0){
        $j=0;
        $total_tax_amount=0;
        $total_paid_amount=0;
        foreach($actual_schedule_result->result() as $row){
            $dataarray['actual_schedule'][$j]['paid_amount']=$row->paid_amount;
            $dataarray['actual_schedule'][$j]['tds_amount']=$row->tds_amount;
            $dataarray['actual_schedule'][$j]['net_amount']=$row->net_amount;
            $dataarray['actual_schedule'][$j]['alltaxes']=$row->tax_applied;
            $dataarray['actual_schedule'][$j]['tax_amount']=$row->tax_amount;
            $dataarray['actual_schedule'][$j]['paid_tax_amount']=$row->paid_tax_amount;
            $dataarray['actual_schedule'][$j]['total_amount_paid']=$row->total_amount_paid;
            $dataarray['actual_schedule'][$j]['payment_mode']=$row->payment_mode;
            $dataarray['actual_schedule'][$j]['account_number']=$row->account_number;
            $dataarray['actual_schedule'][$j]['payment_date']=date('d/m/Y',strtotime($row->payment_date));
            $dataarray['actual_schedule'][$j]['cheque_no']=$row->cheque_no;

            $total_tax_amount =$total_tax_amount + $row->tax_amount;
            $total_paid_amount=$total_paid_amount + $row->paid_amount;

            $j=$j+1;
        }

        $dataarray['actual_total_tax_amount']=$total_tax_amount;
        $dataarray['actual_total_paid_Amount']=$total_paid_amount;
    }
    // print_r($dataarray);

    $html=$this->load->view('bank_entry/schedule_actual_paid_detail_view',$dataarray,true);
    $response=array('status'=>true,"htmldata"=>$html);
    return $response;
}

function getTaxPaidDetails($tax_applied,$fk_txn_id){
    $fk_txn_id=explode("_",$fk_txn_id);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $dataarray['table_type']=$tableType;

    $this->db->select('*');
    $this->db->from('actual_schedule_taxes');
    $this->db->where('fk_txn_id = "'.$fk_txn_id[1].'" and table_type = "' . $tableType . '" and tax_applied = "'.$tax_applied.'" and amount_paid<>0 and txn_status = "Approved" ');
    $actual_schedule_result=$this->db->get();
    if($actual_schedule_result->num_rows() > 0){
        $j=0;
        $total_tax_amount=0;
        $total_paid_amount=0;
        foreach($actual_schedule_result->result() as $row){
            $dataarray['actual_schedule'][$j]['paid_amount']=$row->amount_paid;
            $dataarray['actual_schedule'][$j]['net_amount']=$row->net_amount;
            $dataarray['actual_schedule'][$j]['alltaxes']=$row->tax_applied;
            $dataarray['actual_schedule'][$j]['tax_amount']=$row->tax_amount;
            $dataarray['actual_schedule'][$j]['total_amount_paid']=$row->total_amount_paid;
            $dataarray['actual_schedule'][$j]['payment_mode']=$row->payment_mode;
            $dataarray['actual_schedule'][$j]['account_number']=$row->account_number;
            $dataarray['actual_schedule'][$j]['payment_date']=date('d/m/Y',strtotime($row->payment_date));
            $dataarray['actual_schedule'][$j]['cheque_no']=$row->cheque_no;

            $total_tax_amount =$total_tax_amount + $row->tax_amount;
            $total_paid_amount=$total_paid_amount + $row->amount_paid;

            $j=$j+1;
        }

        $dataarray['actual_total_tax_amount']=$total_tax_amount;
        $dataarray['actual_total_paid_Amount']=$total_paid_amount;
    }
    // print_r($dataarray);

    $html=$this->load->view('bank_entry/schedule_actual_tax_paid_detail_view',$dataarray,true);
    $response=array('status'=>true,"htmldata"=>$html);
    return $response;
}

function getOtherSchedule($fk_txn_id){
    $fk_txn_id=explode("_",$fk_txn_id);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $schedule_table=$tableType."_schedule";
    $sch_type_id='';
    $dataarray['property_id']=0;
    $dataarray['sub_property_id']=0;

    if($fk_txn_id[0]=='p'){
        $sch_type_id='purchase_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['purchase']='selected';
        $tax_type='purchase';
        $dataarray['property_id']=$fk_txn_id[1];
    }
    if($fk_txn_id[0]=='s'){
        $sch_type_id='sale_id';
        $dataarray['receipt']='selected';
        $dataarray['payment']='';
        $dataarray['sale']='selected';
        $tax_type='sale';

        $query=$this->db->query("select * from sales_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }
    if($fk_txn_id[0]=='r'){
        $sch_type_id='rent_id';
        $dataarray['receipt']='selected';
        $dataarray['payment']='';
        $dataarray['rent']='selected';
        $tax_type='rent';

        $query=$this->db->query("select * from rent_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }
    if($fk_txn_id[0]=='e'){
        $sch_type_id='expense_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['expense']='selected';
        $tax_type='expense';

        $query=$this->db->query("select * from expense_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }
    if($fk_txn_id[0]=='m'){
        $sch_type_id='m_id';
        $dataarray['payment']='selected';
        $dataarray['receipt']='';
        $dataarray['maintenance']='selected';
        $tax_type='maintenance';

        $query=$this->db->query("select * from maintenance_txn where txn_id = '" . $fk_txn_id[1] . "'");
        $result=$query->result();
        if (count($result)>0) {
            $dataarray['property_id']=$result[0]->property_id;
            $dataarray['sub_property_id']=$result[0]->sub_property_id;
        }
    }

    $query=$this->db->query("select C.id, C.table_type, C.event_type, C.event_name, C.event_date, 
                                C.net_amount, C.paid_amount, C.balance, C.total_amount_paid from 
                            (select A.id, A.table_type, A.event_type, A.event_name, A.event_date, 
                                A.net_amount, A.paid_amount, A.balance, A.total_amount_paid, B.sch_id from 
                            (select id, table_type, event_type, event_name, event_date, concat(trim(event_type), trim(event_name), 
                                trim(event_date)) as temp_col, fk_txn_id, net_amount, paid_amount, balance, total_amount_paid 
                            from actual_schedule where fk_txn_id = '".$fk_txn_id[1]."' and table_type = '". $tableType ."') A 
                            left join 
                            (select sch_id, event_type, event_name, event_date, concat(trim(event_type), trim(event_name), 
                                trim(event_date)) as temp_col from " . $schedule_table . " 
                            where " . $sch_type_id . "='".$fk_txn_id[1]."' and status='1') B 
                            on A.temp_col = B.temp_col) C 
                            where C.sch_id is null");
    $result=$query->result();
    if(count($result)>0){
        $dataarray['other_sch']=$result;
    }

    $query=$this->db->query("select sch_id, event_type, event_name, event_date, concat(trim(event_type), ' - ', trim(event_name), 
                                ' - ', trim(date_format(event_date, '%d/%m/%Y'))) as temp_col from " . $schedule_table . " 
                            where " . $sch_type_id . "='".$fk_txn_id[1]."' and status='1'");
    $result=$query->result();
    if(count($result)>0){
        $dataarray['total_sch']=$result;
    }

    $html=$this->load->view('bank_entry/schedule_select_other_detail_view',$dataarray,true);
    $response=array('status'=>true,"htmldata"=>$html);
    return $response;
}

function saveOtherSchDetails($form_data){
    $now = date('Y-m-d H:m:s');
    $fk_txn_id=explode('_',$form_data['fk_txn_id']);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $schedule_table=$tableType."_schedule";
    $table_name=$tableType."_schedule_taxation";
    $sch_type_id='';

    if($fk_txn_id[0]=='p'){
        $sch_type_id='purchase_id';
    }
    if($fk_txn_id[0]=='s'){
        $sch_type_id='sale_id';
    }
    if($fk_txn_id[0]=='r'){
        $sch_type_id='rent_id';
    }
    if($fk_txn_id[0]=='e'){
        $sch_type_id='expense_id';
    }
    if($fk_txn_id[0]=='m'){
        $sch_type_id='m_id';
    }


    $i=0;

    if(isset($form_data['new_sch_id'])){
        foreach($form_data['new_sch_id'] as $rowsch){
            $new_sch_id=intval($form_data['new_sch_id'][$i]);

            if($new_sch_id>0){
                $sch_id=intval($form_data['sch_id'][$i]);
                if($sch_id>0){
                    $query=$this->db->query("select * from " . $schedule_table . " where sch_id = '".$new_sch_id."' and status = '1'");
                    $result=$query->result();

                    if(count($result)>0){
                        $event_type=$result[0]->event_type;
                        $event_name=$result[0]->event_name;
                        $event_date=$result[0]->event_date;

                        $this->db->query("update actual_schedule set event_type = '" . $event_type . "', 
                                         event_name = '" . $event_name . "', event_date = '" . $event_date . "', created_on = '" . $now . "' 
                                         where id = '".$sch_id."'");
                    }
                }


            }

            $i=$i+1;
        }
    }
    return true;
}

function saveActualBankEntry($form_data, $txn_status, $fk_created_on=null){
    //print_r($form_data);
    //exit;
    $gid=$this->session->userdata('groupid');
    $fk_txn_id=explode('_',$form_data['fk_txn_id']);
    $tableType=$this->config->item($fk_txn_id[0],'txnTypeArray');
    $now = date('Y-m-d H:m:s');
    $payment_date=FormatDate($form_data['payment_date']);
    $bl_insert = false;

    if($txn_status=='Approved'){
        $sch_status = '1';
    } else {
        $sch_status = '3';
    }

    // $i=0;
    // $actual_amount=0;
    // foreach($form_data['actual_amount'] as $row){
    //     if($form_data['actual_amount'][$i] !=''){
    //         $actual_amount=$actual_amount+$form_data['actual_amount'][$i];
    //     }
    //     $i++;
    // }

    $i=0;

    // foreach($form_data['event_type'] as $row){
    for($i=0;$i<count($form_data['paid_amount']);$i++) {
        $form_data['net_amount'][$i]=format_number($form_data['net_amount'][$i],2);
        $form_data['paid_amount'][$i]=format_number($form_data['paid_amount'][$i],2);
        $form_data['paid_amount_actual'][$i]=format_number($form_data['paid_amount_actual'][$i],2);
        $form_data['balance'][$i]=format_number($form_data['balance'][$i],2);

        if($form_data['paid_amount'][$i]!='0' && $form_data['paid_amount'][$i]!='' && $form_data['paid_amount'][$i]!=null && 
           $form_data['paid_amount'][$i]!=$form_data['paid_amount_actual'][$i]){
            $taxesExtra='';
            if(isset($form_data['extra_taxes_'.($i+1)])){
                if($this->input->post('extra_taxes_'.($i+1)) != ''){
                    $taxesExtra=implode(',',$form_data['extra_taxes_'.($i+1)]);
                }
            }

            $paid_amount = 0;
            $tds_amount = 0;
            $int_type='';
            $int_rate=0;
            $interest=0;
            $principal=0;
            $tot_outstanding=0;

            if(isset($form_data['tds_amount'][$i])){
                if(is_numeric($form_data['tds_amount'][$i])){
                    $tds_amount = format_number($form_data['tds_amount'][$i],2);
                }
            }
            if(isset($form_data['int_type'][$i])){
                $int_type = $form_data['int_type'][$i];
            }
            if(isset($form_data['int_rate'][$i])){
                if(is_numeric($form_data['int_rate'][$i])){
                    $int_rate = format_number($form_data['int_rate'][$i],2);
                }
            }
            if(isset($form_data['interest'][$i])){
                if(is_numeric($form_data['interest'][$i])){
                    $interest = format_number($form_data['interest'][$i],2);
                }
            }
            if(isset($form_data['principal'][$i])){
                if(is_numeric($form_data['principal'][$i])){
                    $principal = format_number($form_data['principal'][$i],2);
                }
            }
            if(isset($form_data['tot_outstanding'][$i])){
                if(is_numeric($form_data['tot_outstanding'][$i])){
                    $tot_outstanding = format_number($form_data['tot_outstanding'][$i],2);
                }
            }

            $paid_amount = $form_data['paid_amount'][$i]-$form_data['paid_amount_actual'][$i]-$tds_amount;


            $insert_array=array(
                            'table_type'=>$tableType,
                            'event_type'=>$form_data['event_type'][$i],
                            'event_name'=>$form_data['event_name'][$i],
                            'event_date'=>$form_data['event_date'][$i],
                            'fk_txn_id'=>$fk_txn_id[1],
                            'net_amount'=>$form_data['net_amount'][$i],
                            'paid_amount'=>$paid_amount,
                            'tds_amount'=>$tds_amount,
                            'total_amount_paid'=>$form_data['paid_amount'][$i],
                            'balance'=>$form_data['balance'][$i],
                            'tax_applied'=>$taxesExtra,
                            'payment_mode'=>$form_data['payment_mode'],
                            'account_number'=>$form_data['account_number'],
                            'payment_date'=>$payment_date,
                            'cheque_no'=>$form_data['cheq_no'],
                            'created_by'=>$this->session->userdata('session_id'),
                            'created_on'=>$now,
                            'int_type'=>$int_type,
                            'int_rate'=>$int_rate,
                            'interest'=>$interest,
                            'principal'=>$principal,
                            'tot_outstanding'=>$tot_outstanding,
                            'txn_status'=>$txn_status,
                            'maker_remark'=>$form_data['maker_remark'],
                            'fk_created_on'=>$fk_created_on,
                            'gp_id'=>$gid
                        );
            $this->db->insert('actual_schedule',$insert_array);
            $bl_insert = true;
        }

        // $i=$i+1;
    }

    $i=0;
    if(isset($form_data['tax_paid_amount'])){
        $form_data['tax_paid_amount'][$i]=format_number($form_data['tax_paid_amount'][$i],2);
        $form_data['tax_paid_amount_actual'][$i]=format_number($form_data['tax_paid_amount_actual'][$i],2);
        $form_data['tax_net_amount'][$i]=format_number($form_data['tax_net_amount'][$i],2);
        $form_data['tax_amount'][$i]=format_number($form_data['tax_amount'][$i],2);
        $form_data['tax_amount_actual'][$i]=format_number($form_data['tax_amount_actual'][$i],2);
        $form_data['tax_balance'][$i]=format_number($form_data['tax_balance'][$i],2);

        foreach($form_data['tax_paid_amount'] as $row){
            if(($form_data['tax_paid_amount'][$i] !='0' && $form_data['tax_paid_amount'][$i] !='' && 
                $form_data['tax_paid_amount'][$i] !=null && $form_data['tax_paid_amount'][$i]!=$form_data['tax_paid_amount_actual'][$i]) || 
                $form_data['tax_amount'][$i]!=$form_data['tax_amount_actual'][$i] || 
                ($form_data['tax_id'][$i] =='0' || $form_data['tax_id'][$i] =='' && $form_data['tax_id'][$i] ==null)){
                $insert_array=array(
                                'table_type'=>$tableType,
                                'fk_txn_id'=>$fk_txn_id[1],
                                'tax_applied'=>$form_data['tax_applied'][$i],
                                'net_amount'=>$form_data['tax_net_amount'][$i],
                                'tax_amount'=>$form_data['tax_amount'][$i],
                                'amount_paid'=>$form_data['tax_paid_amount'][$i]-$form_data['tax_paid_amount_actual'][$i],
                                'total_amount_paid'=>$form_data['tax_paid_amount'][$i],
                                'balance'=>$form_data['tax_balance'][$i],
                                'payment_mode'=>$form_data['payment_mode'],
                                'account_number'=>$form_data['account_number'],
                                'payment_date'=>$payment_date,
                                'cheque_no'=>$form_data['cheq_no'],
                                'created_by'=>$this->session->userdata('session_id'),
                                'created_on'=>$now,
                                'status'=>$sch_status,
                                'txn_status'=>$txn_status,
                                'maker_remark'=>$form_data['maker_remark'],
                                'fk_created_on'=>$fk_created_on,
                                'gp_id'=>$gid
                            );
                $this->db->insert('actual_schedule_taxes',$insert_array);
                $bl_insert = true;
            }

            $i=$i+1;
        }
    }

    if ($bl_insert == true){
        $logarray['table_id']=$now;
        $logarray['module_name']='Bank Entry';
        $logarray['cnt_name']=$tableType;
        $logarray['action']='Bank Entry Record Inserted';
        $logarray['gp_id']=$gid;
        $this->user_access_log_model->insertAccessLog($logarray);
    }

    $this->send_bank_entry_intimation($now);
}

function saveOtherExpenseBankEntry($form_data, $txn_status, $txn_fkid=null){
    $gid=$this->session->userdata('groupid');
    $now = date('Y-m-d H:m:s');
    $expense_date=FormatDate($form_data['expense_date']);
    $payment_date=FormatDate($form_data['payment_date']);
    $expense_amount=format_number($form_data['expense_amount'],2);

    $insert_array=array(
                    'expense_category'=>$form_data['expense_category'],
                    'property_id'=>$form_data['prop_name'],
                    'sub_property_id'=>$form_data['sub_property'],
                    'expense_description'=>$form_data['expense_description'],
                    'expense_date'=>$expense_date,
                    'expense_amount'=>$expense_amount,
                    'payment_mode'=>$form_data['payment_mode'],
                    'account_number'=>$form_data['account_number'],
                    'payment_date'=>$payment_date,
                    'cheque_no'=>$form_data['cheq_no'],
                    'created_by'=>$this->session->userdata('session_id'),
                    'created_on'=>$now,
                    'txn_status'=>$txn_status,
                    'maker_remark'=>$form_data['maker_remark'],
                    'txn_fkid'=>$txn_fkid,
                    'gp_id'=>$gid
                );
    $this->db->insert('actual_other_expense',$insert_array);
    $logarray['table_id']=$this->db->insert_id();
    $logarray['module_name']='Bank Entry Expense';
    $logarray['cnt_name']='Expense';
    $logarray['action']='Bank Entry Record Inserted';
    $logarray['gp_id']=$gid;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function saveOtherScheduleBankEntry($form_data, $txn_status, $txn_fkid=null){
    $gid=$this->session->userdata('groupid');
    $now = date('Y-m-d H:m:s');
    $sch_date=FormatDate($form_data['sch_date']);
    $payment_date=FormatDate($form_data['payment_date']);
    $amount=format_number($form_data['amount'],2);

    $insert_array=array(
                    'type'=>$form_data['type'],
                    'property_id'=>$form_data['prop_name'],
                    'sub_property_id'=>$form_data['sub_property'],
                    'description'=>$form_data['description'],
                    'sch_date'=>$sch_date,
                    'amount'=>$amount,
                    'payment_mode'=>$form_data['payment_mode'],
                    'account_number'=>$form_data['account_number'],
                    'payment_date'=>$payment_date,
                    'cheque_no'=>$form_data['cheq_no'],
                    'created_by'=>$this->session->userdata('session_id'),
                    'created_on'=>$now,
                    'txn_status'=>$txn_status,
                    'maker_remark'=>$form_data['maker_remark'],
                    'txn_fkid'=>$txn_fkid,
                    'gp_id'=>$gid
                );
    $this->db->insert('actual_other_schedule',$insert_array);
    $logarray['table_id']=$this->db->insert_id();
    $logarray['module_name']='Bank Entry Schedule';
    $logarray['cnt_name']='Schedule';
    $logarray['action']='Bank Entry Record Inserted';
    $logarray['gp_id']=$gid;
    $this->user_access_log_model->insertAccessLog($logarray);
}

function getAllTaxes(){
	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
	$this->db->where('status = "1" and txn_type like "%Sale%" and tax_action="1"');
	$this->db->from('tax_master');
	$result=$this->db->get();
	return $result->result();
}

function getAccess(){
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $curusr=$this->session->userdata('session_id');
    $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'BankEntry' AND role_id='$roleid' AND 
                            (r_view = 1 or r_insert = 1 or r_edit = 1 or r_delete = 1 or r_approvals = 1)");
    $result=$query->result();
    return $result;
}


function ownerDetails($gid){
    $query=$this->db->query("SELECT * FROM owner_master WHERE ow_gid = '$gid'");
    $result=$query->result();
    return $result;
}

function getPropertyDetails($txn_id='0') {
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    if ($txn_id!='0') {
        $cond = " and txn_id<>'$txn_id'";
    } else {
        $cond = "";
    }

    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();
    if (count($result)>0) {
        $sql="select distinct txn_id, p_property_name, p_display_name from 
            (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                E.owner_name, F.txn_id as sales_id from 
            (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
            (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') B 
            on A.txn_id = B.property_id) C 
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
            on C.txn_id = D.purchase_id where D.owner_name is not null and D.owner_name <> '') E 
            left join 
            (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null";
    } else {
        $sql="select distinct txn_id, p_property_name, p_display_name from 
            (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                E.owner_name, F.txn_id as sales_id from 
            (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
            (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') B 
            on A.txn_id = B.property_id) C 
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
            on C.txn_id = D.purchase_id) E 
            left join 
            (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                from sales_txn where gp_id = '$gid' and txn_status = 'Approved'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null";
    }

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

function getSubPropertyDetails($txn_id='0', $property_id='0') {
    $gid=$this->session->userdata('groupid');
    $roleid=$this->session->userdata('role_id');
    $session_id=$this->session->userdata('session_id');

    if ($txn_id!='0') {
        $cond = " and txn_id<>'$txn_id'";
    } else {
        $cond = "";
    }

    if ($property_id!='0') {
        $cond2 = " and property_id='$property_id'";
    } else {
        $cond2 = "";
    }

    $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
    $result=$query->result();
    if (count($result)>0) {
        $sql="select distinct sp_id, sp_name from 
            (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                E.owner_name, F.txn_id as sales_id from 
            (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
            (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
            on A.txn_id = B.property_id) C 
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
            on C.txn_id = D.purchase_id where D.owner_name is not null and D.owner_name <> '') E 
            left join 
            (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null and sp_id is not null and sp_id<>0";
    } else {
        $sql="select distinct sp_id, sp_name from 
            (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                E.owner_name, F.txn_id as sales_id from 
            (select C.txn_id, C.p_property_name, C.p_display_name, C.p_purchase_date, C.sp_id, C.sp_name, D.owner_name from 
            (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, 
                case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
            (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
            left join 
            (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
            on A.txn_id = B.property_id) C 
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
            on C.txn_id = D.purchase_id) E 
            left join 
            (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                from sales_txn where gp_id = '$gid' and txn_status = 'Approved'" . $cond . ") F 
            on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
            where sales_id is null and sp_id is not null and sp_id<>0";
    }

    $query=$this->db->query($sql);
    $result=$query->result();
    return $result;
}

public function send_bank_entry_intimation($created_on){
    $gid=$this->session->userdata('groupid');

    $bankentry=$this->bankentryData("All", "", $created_on);
    if(count($bankentry)>0){
        $prop_id=explode("_",$bankentry[0]['prop_id']);

        $property_id=$bankentry[0]['property_id'];
        if($prop_id[0]=="p"){
            $table_type="Purchase";
            $tranaction="Paid";
        } else if($prop_id[0]=="s"){
            $table_type="Sale";
            $tranaction="Received";
        } else if($prop_id[0]=="r"){
            $table_type="Rent";
            $tranaction="Received";
        } else if($prop_id[0]=="l"){
            $table_type="Loan";
            $tranaction="Paid";
        } else if($prop_id[0]=="m"){
            $table_type="Maintenance";
            $tranaction="Paid";
        } else if($prop_id[0]=="e"){
            $table_type="Expense";
            $tranaction="Paid";
        } else {
            $table_type="";
            $tranaction="";
        }

        $property_name=$bankentry[0]['property'];
        if(isset($bankentry[0]['sub_property'])){
            if($bankentry[0]['sub_property']!=""){
                $property_name=$property_name.' - '.$bankentry[0]['sub_property'];
            }
        }

        $group_owners=$this->purchase_model->get_group_owners($gid);

        if($table_type=="Loan"){
            $property_owners=$this->loan_model->get_loan_owners($prop_id[1]);
        } else {
            $property_owners=$this->purchase_model->get_property_owners($property_id);
        }
        
        $prop_owners="";
        $table="";
        $payment_amount=0;

        $table='<div>
                <table style="border-collapse: collapse; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="100">Sub Property Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Particulars</th>
                            <th style="padding:5px; border: 1px solid black;" width="110">Event Name</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Event Date</th>
                            <th style="padding:5px; border: 1px solid black;" width="50">Net Amount (In Rs)</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Amount (In Rs)</th>
                            <th style="padding:5px; border: 1px solid black;" width="90">Status</th>
                        </tr>
                    </thead>
                    <tbody>';

        for($i=0;$i<count($bankentry);$i++){
            $table=$table.'<tr>
                            <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$bankentry[$i]['property'].'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$bankentry[$i]['sub_property'].'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$bankentry[$i]['particulars'].'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$bankentry[$i]['event_name'].'</td>
                            <td style="padding:5px; border: 1px solid black;">'.(($bankentry[$i]['due_date']!=null && $bankentry[$i]['due_date']!="")?date("d/m/Y",strtotime($bankentry[$i]['due_date'])):"").'</td>
                            <td style="padding:5px; border: 1px solid black; text-align: right;">'.format_money($bankentry[$i]['net_amount'],2).'</td>
                            <td style="padding:5px; border: 1px solid black; text-align: right;">'.format_money($bankentry[$i]['paid_amount'],2).'</td>
                            <td style="padding:5px; border: 1px solid black;">'.$bankentry[$i]['txn_status'].'</td>
                        </tr>';

            $payment_amount=$payment_amount+floatval($bankentry[$i]['paid_amount']);
        }

        $table=$table.'</tbody></table></div>';

        if(count($property_owners)>0){
            for($i=0;$i<count($property_owners);$i++){
                $owner_name=$property_owners[$i]->owner_name;
                $to_email=$property_owners[$i]->ow_contact_email_id;

                $prop_owners=$prop_owners.$owner_name.', ';

                $from_email = 'info@pecanreams.com';
                $from_email_sender = 'Pecan REAMS';
                $subject = 'Bank Entry Intimation';
                
                if($table_type=="Loan"){
                    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                                We would like to bring to your notice that Rs. '.format_money($payment_amount,2).' 
                                has been paid towards the Loan Repayment. 
                                The bank entry details are as follows.<br /><br />' . $table . '<br /><br />
                                If the above bank entry is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
                } else {
                    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                                We would like to bring to your notice that Rs. '.format_money($payment_amount,2).' 
                                has been '.$tranaction.' towards the '.$table_type.' of '.$property_name.' owned by you. 
                                The bank entry details are as follows.<br /><br />' . $table . '<br /><br />
                                If the above bank entry is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
                }
                
                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

                // echo $owner_name . ' ';
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

                $from_email = 'info@pecanreams.com';
                $from_email_sender = 'Pecan REAMS';
                $subject = 'Bank Entry Intimation';

                if($table_type=="Loan"){
                    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                                We would like to bring to your notice that Rs. '.format_money($payment_amount,2).' 
                                has been paid towards the Loan Repayment by '.$prop_owners.'. 
                                The bank entry details are as follows.<br /><br />' . $table . '<br /><br />
                                If the above bank entry is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
                } else {
                    $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                                We would like to bring to your notice that Rs. '.format_money($payment_amount,2).' 
                                has been '.$tranaction.' towards the '.$table_type.' of '.$property_name.' owned by '.$prop_owners.'. 
                                The bank entry details are as follows.<br /><br />' . $table . '<br /><br />
                                If the above bank entry is incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
                }
                
                $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);
            }
        }
    }
}

}
?>