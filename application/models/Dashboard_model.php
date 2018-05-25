<?php 
if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class dashboard_model extends CI_Model
{
    public function __construct() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        parent::__construct();
    }

    function getAllTasks($status) {
        if($status=='all' || $status=='mytask' || $status=='assigned'){
            $cond="";
            $cond2="";
        } else {
            $cond=" and E.status='$status'";
            $cond2=" where E.status='$status'";
        }
    }

    function getAllSchedule($status) {
        if($status=='all' || $status=='mytask' || $status=='assigned'){
            $cond="";
            $cond2="";
        } else {
            $cond=" and E.status='$status'";
            $cond2=" where E.status='$status'";
        }

        $today=date('Y-m-d');
        $compairDate=date('Y-m-d', strtotime('7 day', strtotime($today)));

    	//for purchase
        $dataarray=array();
        $i=0;
        $blOwnerExist=false;

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $blOwnerExist=true;
            $sql="select * from 
                (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, '' as sub_property_id, '' as sp_name, C.p_type, C.p_status, 
                        C.txn_status, C.purchase_id, C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                        C.net_amount, C.paid_amount, C.completed_on, D.pr_client_id, D.owner_name, 
                        case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select * from 
                (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                    A.txn_status, B.purchase_id, B.event_type, B.event_name, B.event_date, B.net_amount, B.paid_amount, B.completed_on from 
                (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
                from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
                left join 
                (select * from 
                (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select purchase_id, event_type, event_name, event_date, net_amount 
                from purchase_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'purchase' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) B 
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
                (select C.txn_id, C.gp_id, C.p_property_name, C.p_display_name, C.p_purchase_date, '' as sub_property_id, '' as sp_name, C.p_type, C.p_status, 
                        C.txn_status, C.purchase_id, C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                        C.net_amount, C.paid_amount, C.completed_on, D.pr_client_id, D.owner_name, 
                        case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select * from 
                (select A.txn_id, A.gp_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, 
                    A.txn_status, B.purchase_id, B.event_type, B.event_name, B.event_date, B.net_amount, B.paid_amount, B.completed_on from 
                (select txn_id, gp_id, p_property_name, p_display_name, p_purchase_date, p_type, p_status, txn_status 
                from purchase_txn where gp_id='$gid' and txn_status = 'Approved') A 
                left join 
                (select * from 
                (select A.purchase_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select purchase_id, event_type, event_name, event_date, net_amount 
                from purchase_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'purchase' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.purchase_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) B 
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
                where purchase_id=A.purchase_id group by purchase_id)) D 
                on C.txn_id=D.purchase_id) E" . $cond2;
        }

        $result1=$this->db->query($sql);
        // $result1=$query->result();
        if($result1->num_rows() > 0){
            foreach($result1->result() as $row){
                $dataarray[$i]['property']=(($row->p_property_name== null || $row->p_property_name=='')?'':$row->p_property_name) . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['task']='Purchase';
                $dataarray[$i]['event_name']=$row->event_name;
                $dataarray[$i]['due_date']=$row->event_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->status;
                $dataarray[$i]['prop_id']="p_".$row->purchase_id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $dataarray[$i]['owner_name']=$row->owner_name;
                $i++;
            }
        }



    	//for sale
        if ($blOwnerExist==true) {
            $sql="select * from 
                (select D.buyer_id, D.owner_name, C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.sale_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.date_of_sale, C.txn_status, 
                    C.p_property_name, C.p_display_name, C.p_type, C.p_status, 
                    case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.sale_id, A.event_type, A.event_name, 
                    A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.date_of_sale, A.txn_status, B.p_property_name, 
                    B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.sale_id, D.event_type, D.event_name, 
                    D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.date_of_sale, C.txn_status from 
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
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select sale_id, event_type, event_name, event_date, net_amount 
                from sales_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'sales' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
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
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.date_of_sale, C.txn_status, 
                    C.p_property_name, C.p_display_name, C.p_type, C.p_status, 
                    case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.sale_id, A.event_type, A.event_name, 
                    A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.date_of_sale, A.txn_status, B.p_property_name, 
                    B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.sale_id, D.event_type, D.event_name, 
                    D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.date_of_sale, C.txn_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.date_of_sale, A.txn_status from 
                (select * from sales_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.sale_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select sale_id, event_type, event_name, event_date, net_amount 
                from sales_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'sales' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.sale_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
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
                on C.txn_id=D.sale_id) E" . $cond2;
        }

        $result2=$this->db->query($sql);
    	if($result2->num_rows() > 0){
    		foreach($result2->result() as $row){
                $dataarray[$i]['property']=(($row->p_property_name== null || $row->p_property_name=='')?'':$row->p_property_name) . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['task']='Sale';
                $dataarray[$i]['event_name']=$row->event_name;
                $dataarray[$i]['due_date']=$row->event_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->status;
    			$dataarray[$i]['prop_id']="s_".$row->sale_id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $dataarray[$i]['owner_name']=$row->owner_name;

    			$i++;
    		}
    	}




    	//for rent
        if ($blOwnerExist==true) {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.rent_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.rent_amount, C.possession_date, 
                    C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.rent_amount, A.possession_date, 
                    A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.tenant_id, C.c_name, C.gp_id, D.rent_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.rent_amount, C.possession_date, 
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
                (select A.rent_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select rent_id, event_type, event_name, event_date, net_amount 
                from rent_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'rent' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
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
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.rent_amount, C.possession_date, 
                    C.termination_date, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.tenant_id, A.c_name, A.gp_id, A.rent_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.rent_amount, A.possession_date, 
                    A.termination_date, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.tenant_id, C.c_name, C.gp_id, D.rent_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.rent_amount, C.possession_date, 
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
                (select A.rent_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select rent_id, event_type, event_name, event_date, net_amount 
                from rent_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'rent' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
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
                on C.property_id=D.purchase_id) E" . $cond2;
        }

		$result3=$this->db->query($sql);
    	if($result3->num_rows() > 0){
    		foreach($result3->result() as $row){
                $dataarray[$i]['property']=(($row->p_property_name== null || $row->p_property_name=='')?'':$row->p_property_name) . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['task']='Rent';
                $dataarray[$i]['event_name']=$row->event_name;
                $dataarray[$i]['due_date']=$row->event_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->status;
    			$dataarray[$i]['prop_id']="r_".$row->rent_id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $dataarray[$i]['owner_name']=$row->owner_name;

    			$i++;
    		}
    	}




        //for loan
        if ($blOwnerExist==true) {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.loan_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.loan_amount, C.loan_startdate, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.loan_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.loan_amount, 
                    A.loan_startdate, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.loan_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.loan_amount, C.loan_startdate, C.txn_status from 
                (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.loan_amount, A.loan_startdate, A.txn_status from 
                (select txn_id, ref_id, ref_name, null as property_id, null as sub_property_id, loan_amount, loan_startdate, gp_id, txn_status 
                    from loan_txn where gp_id = '$gid' and txn_status='Approved') A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select loan_id, event_type, event_name, event_date, net_amount 
                from loan_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'loan' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.loan_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                on C.txn_id=D.loan_id) E) A 
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
                on C.property_id=D.purchase_id) E" . $cond2;
        } else {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.loan_id, 
                    C.event_type, C.event_name, C.event_date, C.net_amount, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.paid_amount, C.completed_on, C.loan_amount, C.loan_startdate, C.txn_status, C.p_property_name, C.p_display_name, 
                C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.loan_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.loan_amount, 
                    A.loan_startdate, A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.ref_id, C.ref_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.loan_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.loan_amount, C.loan_startdate, C.txn_status from 
                (select A.txn_id, A.ref_id, A.ref_name, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.loan_amount, A.loan_startdate, A.txn_status from 
                (select txn_id, ref_id, ref_name, null as property_id, null as sub_property_id, loan_amount, loan_startdate, gp_id, txn_status 
                    from loan_txn where gp_id = '$gid' and txn_status='Approved') A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.loan_id, A.event_type, A.event_name, A.event_date, A.net_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select loan_id, event_type, event_name, event_date, net_amount 
                from loan_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'loan' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.loan_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                on C.txn_id=D.loan_id) E) A 
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
                on C.property_id=D.purchase_id) E" . $cond2;
        }
        $result4=$this->db->query($sql);
        if($result4->num_rows() > 0){
            foreach($result4->result() as $row){
                $dataarray[$i]['property']=(($row->ref_name== null || $row->ref_name=='')?'':$row->ref_name) . (($row->p_property_name== null || $row->p_property_name=='')?'':' - ' . $row->p_property_name) . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['task']='Loan';
                $dataarray[$i]['event_name']=$row->event_name;
                $dataarray[$i]['due_date']=$row->event_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->status;
                $dataarray[$i]['prop_id']="l_".$row->loan_id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $dataarray[$i]['owner_name']=$row->owner_name;
                
                $i++;
            }
        }




        //for expense
        if ($blOwnerExist==true) {
            $sql="select * from 
                (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.expense_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.expense_amount, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.client_id, A.c_name, A.gp_id, A.expense_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.expense_amount, 
                    A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.client_id, C.c_name, C.gp_id, D.expense_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.expense_amount, C.txn_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.client_id, A.c_name, A.gp_id, A.expense_amount, A.txn_status from 
                (select AA.txn_id, AA.property_id, AA.sub_property_id, AA.client_id, 
                    concat(ifnull(BB.c_name,''),' ',ifnull(BB.c_last_name,'')) as c_name, AA.gp_id, AA.expense_amount, AA.txn_status 
                from expense_txn AA, contact_master BB where AA.gp_id = '$gid' and AA.client_id=BB.c_id and 
                    AA.property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id'))) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.expense_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select expense_id, event_type, event_name, event_date, net_amount 
                from expense_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'expense' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.expense_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                on C.txn_id=D.expense_id) E where E.event_name is not null) A 
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
                (select C.txn_id, D.owner_name, C.c_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.expense_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.expense_amount, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.client_id, A.c_name, A.gp_id, A.expense_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, A.expense_amount, 
                    A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.client_id, C.c_name, C.gp_id, D.expense_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.expense_amount, C.txn_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.client_id, A.c_name, A.gp_id, A.expense_amount, A.txn_status from 
                (select AA.txn_id, AA.property_id, AA.sub_property_id, AA.client_id, 
                    concat(ifnull(BB.c_name,''),' ',ifnull(BB.c_last_name,'')) as c_name, AA.gp_id, AA.expense_amount, AA.txn_status 
                from expense_txn AA, contact_master BB where AA.gp_id = '$gid' and AA.client_id=BB.c_id) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.expense_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select expense_id, event_type, event_name, event_date, net_amount 
                from expense_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'expense' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.expense_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                on C.txn_id=D.expense_id) E where E.event_name is not null) A 
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
                on C.property_id=D.purchase_id) E" . $cond2;
        }

        $result5=$this->db->query($sql);
        if($result5->num_rows() > 0){
            foreach($result5->result() as $row){
                $dataarray[$i]['property']=(($row->p_property_name== null || $row->p_property_name=='')?'':$row->p_property_name) . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['task']='Expense';
                $dataarray[$i]['event_name']=$row->event_name;
                $dataarray[$i]['due_date']=$row->event_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->status;
                $dataarray[$i]['prop_id']="e_".$row->expense_id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $dataarray[$i]['owner_name']=$row->owner_name;

                $i++;
            }
        }




        //for maintenance
        if ($blOwnerExist==true) {
            $sql="select * from 
                (select F.*, G.maintenance_by, G.property_tax_by from 
                (select * from 
                (select C.txn_id, D.owner_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.m_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.m_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, 
                    A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.m_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.txn_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
                (select AA.txn_id, AA.property_id, AA.sub_property_id, AA.gp_id, AA.txn_status 
                from maintenance_txn AA where AA.gp_id = '$gid' and 
                    AA.property_id in (select distinct purchase_id from purchase_ownership_details 
                                        where pr_client_id in (select distinct owner_id from user_role_owners 
                                            where user_id = '$session_id'))) A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.m_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select m_id, event_type, event_name, event_date, net_amount 
                from maintenance_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'maintenance' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.m_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                on C.txn_id=D.m_id) E where E.event_name is not null) A 
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
                where E.owner_name is not null and E.owner_name<>''" . $cond . ") F 
                left join 
                (select * from rent_txn where txn_status='Approved') G 
                on (F.property_id=G.property_id and F.sub_property_id=G.sub_property_id)) H 
                where (H.maintenance_by is null or H.maintenance_by='' or H.maintenance_by<>'Tenant' or 
                       H.property_tax_by is null or H.property_tax_by='' or H.property_tax_by<>'Tenant')";
        } else {
            $sql="select * from 
                (select F.*, G.maintenance_by, G.property_tax_by from 
                (select * from 
                (select C.txn_id, D.owner_name, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, C.m_id, 
                    C.event_type, C.event_name, C.event_date, datediff(C.event_date,str_to_date(CURDATE(),'%Y-%m-%d')) AS no_of_days, 
                    C.net_amount, C.paid_amount, C.completed_on, C.txn_status, C.p_property_name, C.p_display_name, 
                    C.p_type, C.p_status, case when C.net_amount<=C.paid_amount then 'Completed' else 'Pending' end as status from 
                (select A.txn_id, A.property_id, A.sub_property_id, A.sp_name, A.gp_id, A.m_id, 
                    A.event_type, A.event_name, A.event_date, A.net_amount, A.paid_amount, A.completed_on, 
                    A.txn_status, B.p_property_name, B.p_display_name, B.p_type, B.p_status from 
                (select * from (select C.txn_id, C.property_id, C.sub_property_id, C.sp_name, C.gp_id, D.m_id, 
                    D.event_type, D.event_name, D.event_date, D.net_amount, D.paid_amount, D.completed_on, C.txn_status from 
                (select A.txn_id, A.property_id, A.sub_property_id, B.sp_name, A.gp_id, A.txn_status from 
                (select AA.txn_id, AA.property_id, AA.sub_property_id, AA.gp_id, AA.txn_status 
                from maintenance_txn AA where AA.gp_id = '$gid') A 
                left join 
                (select * from sub_property_allocation where txn_status='Approved' and gp_id = '$gid') B 
                on A.sub_property_id = B.txn_id) C 
                left join 
                (select * from 
                (select A.m_id, A.event_type, A.event_name, A.event_date, A.net_amount, 
                    case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount, B.completed_on from 
                (select m_id, event_type, event_name, event_date, net_amount 
                from maintenance_schedule where status = '1') A 
                left join 
                (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount) as paid_amount, max(created_on) as completed_on 
                from actual_schedule where table_type = 'maintenance' group by fk_txn_id, event_type, event_name, event_date) B 
                on (A.m_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C) D 
                on C.txn_id=D.m_id) E where E.event_name is not null) A 
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
                on C.property_id=D.purchase_id) E" . $cond2 . ") F 
                left join 
                (select * from rent_txn where txn_status='Approved') G 
                on (F.property_id=G.property_id and F.sub_property_id=G.sub_property_id)) H 
                where (H.maintenance_by is null or H.maintenance_by='' or H.maintenance_by<>'Tenant' or 
                       H.property_tax_by is null or H.property_tax_by='' or H.property_tax_by<>'Tenant')";
        }

        $result6=$this->db->query($sql);
        if($result6->num_rows() > 0){
            foreach($result6->result() as $row){
                if((($row->event_name=="CAMP (Rs. PSF)" || $row->event_name=="Maintenance") && $row->maintenance_by=="Tenant") || 
                   ($row->event_name=="Property Tax" && $row->property_tax_by=="Tenant")) {
                    continue;
                }

                $dataarray[$i]['property']=(($row->p_property_name== null || $row->p_property_name=='')?'':$row->p_property_name) . (($row->sp_name== null || $row->sp_name=='')?'':' - ' . $row->sp_name);
                $dataarray[$i]['task']='Maintenance';
                $dataarray[$i]['event_name']=$row->event_name;
                $dataarray[$i]['due_date']=$row->event_date;
                $dataarray[$i]['completed_on']=$row->completed_on;
                $dataarray[$i]['status']=$row->status;
                $dataarray[$i]['prop_id']="m_".$row->m_id;
                $dataarray[$i]['no_of_days']=$row->no_of_days;
                $dataarray[$i]['owner_name']=$row->owner_name;

                $i++;
            }
        }




        if($result1->num_rows() > 0 || $result2->num_rows() > 0 || $result3->num_rows() > 0 || $result4->num_rows() > 0 || 
           $result5->num_rows() > 0 || $result6->num_rows() > 0){
            foreach ($dataarray as $key => $value) {
                $sort[$key] = strtotime($value['due_date']);
            }

            array_multisort($sort, SORT_DESC, $dataarray);
            //var_dump($dataarray);
        }

		return $dataarray;
    }
}
?>