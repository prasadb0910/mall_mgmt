<?php 
if (! defined('BASEPATH')){exit('No Direct Script Access is allowed');}

class Loan_model Extends CI_Model{

    function __Construct(){
    	parent :: __construct();
        $this->load->helper('common_functions');
        $this->load->model('purchase_model');
    }

    function loanData($status='', $property_id='', $lid=''){
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
            $cond2=" and loan_property_id='" . $property_id . "'";
        } else {
            $cond2="";
        }

        if($lid!=""){
            $cond2=" and txn_id='" . $lid . "'";
        }

        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');
        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $blOwnerExist = true;
            $sql="select * from 
                (select F.*, G.property_id, G.sub_property_id, G.property, G.p_property_name, G.p_display_name, G.p_type, G.sp_name, G.p_status, 
                        G.p_image, G.pr_agreement_area, G.pr_agreement_unit, G.purchase_price, G.p_apartment, G.p_flatno, G.p_floor, 
                        G.p_wing, G.p_address, G.p_landmark, G.p_state, G.p_city, G.p_pincode, G.p_country, G.p_googlemaplink from 
                (select * from 
                (select C.*, D.loan_id, D.brower_id, D.owner_name from 
                (select * from loan_txn where gp_id='$gid'" . $cond2 . " order by modified_date desc) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id and 
                    brower_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.brower_id=B.c_id)) D 
                on C.txn_id=D.loan_id) E 
                where E.owner_name is not null and E.owner_name<>'') F
                left join 
                (select C.*, D.sp_name from 
                (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                    B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                    B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                left join 
                (select A.*, B.purchase_price from 
                (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                    from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) 
                    where A.gp_id='$gid') A 
                left join 
                (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                on A.txn_id = B.purchase_id) B 
                on A.property_id = B.txn_id) C 
                left join 
                (select * from sub_property_allocation where gp_id='$gid') D 
                on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                on F.txn_id = G.loan_id) E 
                where E.owner_name is not null and E.owner_name<>'' " . $cond;
        } else {
            $sql="select * from 
                (select F.*, G.property_id, G.sub_property_id, G.property, G.p_property_name, G.p_display_name, G.p_type, G.sp_name, G.p_status, 
                        G.p_image, G.pr_agreement_area, G.pr_agreement_unit, G.purchase_price, G.p_apartment, G.p_flatno, G.p_floor, 
                        G.p_wing, G.p_address, G.p_landmark, G.p_state, G.p_city, G.p_pincode, G.p_country, G.p_googlemaplink from 
                (select * from 
                (select C.*, D.loan_id, D.brower_id, D.owner_name from 
                (select * from loan_txn where gp_id='$gid'" . $cond2 . " order by modified_date desc) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.brower_id=B.c_id)) D 
                on C.txn_id=D.loan_id) E) F
                left join 
                (select C.*, D.sp_name from 
                (select A.*, B.p_property_name, B.p_display_name, B.p_type, B.p_status, 
                        B.p_image, B.pr_agreement_area, B.pr_agreement_unit, B.purchase_price, B.p_apartment, B.p_flatno, B.p_floor, 
                        B.p_wing, B.p_address, B.p_landmark, B.p_state, B.p_city, B.p_pincode, B.p_country, B.p_googlemaplink from 
                (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                left join 
                (select A.*, B.purchase_price from 
                (select A.*, B.pr_agreement_area, B.pr_agreement_unit 
                    from purchase_txn A left join purchase_property_description B on (A.txn_id=B.purchase_id) 
                    where A.gp_id='$gid') A 
                left join 
                (select purchase_id,sum(net_amount) as purchase_price from purchase_schedule where status = '1' or status = '3' group by purchase_id) B 
                on A.txn_id = B.purchase_id) B 
                on A.property_id = B.txn_id) C 
                left join 
                (select * from sub_property_allocation where gp_id='$gid') D 
                on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                on F.txn_id = G.loan_id) E " . $cond3;
        }

        $query=$this->db->query($sql);
        return $query->result();
    }

    function getAllCountData(){
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();

        if (count($result)>0) {
            $sql="select F.txn_id, F.gp_id, F.ref_id, F.ref_name, F.loan_amount, F.loan_term, F.loan_interest_rate, 
                        F.loan_startdate, F.loan_due_day, F.interest_type, F.txn_status, F.loan_id, F.brower_id, F.owner_name, 
                        G.p_property_name, G.p_display_name, G.sp_name from 
                (select * from 
                (select C.txn_id, C.gp_id, C.ref_id, C.ref_name, C.loan_amount, C.loan_term, C.loan_interest_rate, 
                        C.loan_startdate, C.loan_due_day, C.interest_type, C.txn_status, D.loan_id, D.brower_id, D.owner_name from 
                (select * from loan_txn where gp_id='$gid') C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id and 
                    brower_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.brower_id=B.c_id)) D 
                on C.txn_id=D.loan_id) E 
                where E.owner_name is not null and E.owner_name<>'') F
                left join 
                (select C.loan_id, C.property_id, C.sub_property_id, C.property, C.p_property_name, C.p_display_name, D.sp_name from 
                (select A.loan_id, A.property_id, A.sub_property_id, A.property, B.p_property_name, B.p_display_name from 
                (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                left join 
                (select * from purchase_txn where gp_id='$gid') B 
                on A.property_id = B.txn_id) C 
                left join 
                (select * from sub_property_allocation where gp_id='$gid') D 
                on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                on F.txn_id = G.loan_id";
        } else {
            $sql="select F.txn_id, F.gp_id, F.ref_id, F.ref_name, F.loan_amount, F.loan_term, F.loan_interest_rate, 
                        F.loan_startdate, F.loan_due_day, F.interest_type, F.txn_status, F.loan_id, F.brower_id, F.owner_name, 
                        G.p_property_name, G.p_display_name, G.sp_name from 
                (select * from 
                (select C.txn_id, C.gp_id, C.ref_id, C.ref_name, C.loan_amount, C.loan_term, C.loan_interest_rate, 
                        C.loan_startdate, C.loan_due_day, C.interest_type, C.txn_status, D.loan_id, D.brower_id, D.owner_name from 
                (select * from loan_txn where gp_id='$gid') C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.loan_id, A.brower_id from loan_borrower_details A 
                    where A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.brower_id=B.c_id)) D 
                on C.txn_id=D.loan_id) E) F
                left join 
                (select C.loan_id, C.property_id, C.sub_property_id, C.property, C.p_property_name, C.p_display_name, D.sp_name from 
                (select A.loan_id, A.property_id, A.sub_property_id, A.property, B.p_property_name, B.p_display_name from 
                (select * from loan_property_details A where A.id = (select min(id) from loan_property_details Where A.loan_id = loan_id)) A 
                left join 
                (select * from purchase_txn where gp_id='$gid') B 
                on A.property_id = B.txn_id) C 
                left join 
                (select * from sub_property_allocation where gp_id='$gid') D 
                on C.sub_property_id=D.txn_id and C.property_id = D.property_id) G 
                on F.txn_id = G.loan_id";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getAllTaxes(){
    	$this->db->select('tax_id,tax_name,tax_percent,txn_type');
    	$this->db->where('status = "1" and txn_type like "%Loan%"  and tax_action="1"');
    	$this->db->from('tax_master');
    	$result=$this->db->get();
    	return $result->result();
    }

    function getAccess(){
    	$gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $curusr=$this->session->userdata('session_id');
        $query=$this->db->query("SELECT * FROM user_role_options WHERE section = 'Loan' AND role_id='$roleid' AND (r_insert = 1 OR r_view = 1 OR r_edit=1 OR r_approvals = 1)");
        $result=$query->result();
        return $result;
    }

    function getPropertyDetails() {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

        $query=$this->db->query("select distinct owner_id from user_role_owners where user_id = '$session_id'");
        $result=$query->result();
        if (count($result)>0) {
            $sql="select * from 
                (select distinct txn_id, p_property_name, p_display_name from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select * from 
                (select C.txn_id, C.p_display_name, C.p_property_name, C.p_purchase_date, C.p_type, C.p_status, C.txn_status, 
                        C.sp_id, C.sp_name, D.purchase_id, D.pr_client_id, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, A.txn_status, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                    where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id and 
                    pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)) D 
                on C.txn_id=D.purchase_id) E 
                where E.owner_name is not null and E.owner_name<>'' and E.txn_status='Approved') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                where sales_id is null) H";
        } else {
            $sql="select * from 
                (select distinct txn_id, p_property_name, p_display_name from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select * from 
                (select C.txn_id, C.p_display_name, C.p_property_name, C.p_purchase_date, C.p_type, C.p_status, C.txn_status, 
                        C.sp_id, C.sp_name, D.purchase_id, D.pr_client_id, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, A.txn_status, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved') B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)) D 
                on C.txn_id=D.purchase_id) E 
                where E.txn_status='Approved') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                where sales_id is null) H";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function getSubPropertyDetails($property_id='0') {
        $gid=$this->session->userdata('groupid');
        $roleid=$this->session->userdata('role_id');
        $session_id=$this->session->userdata('session_id');

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
                (select * from 
                (select C.txn_id, C.p_display_name, C.p_property_name, C.p_purchase_date, C.p_type, C.p_status, C.txn_status, 
                        C.sp_id, C.sp_name, D.purchase_id, D.pr_client_id, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, A.txn_status, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                    where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id and 
                    pr_client_id in (select distinct owner_id from user_role_owners where user_id = '$session_id'))) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)) D 
                on C.txn_id=D.purchase_id) E 
                where E.owner_name is not null and E.owner_name<>'' and E.txn_status='Approved') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                where sales_id is null and sp_id<>0";
        } else {
            $sql="select distinct sp_id, sp_name from 
                (select E.txn_id, E.p_property_name, E.p_display_name, E.p_purchase_date, E.sp_id, E.sp_name, 
                    E.owner_name, F.txn_id as sales_id from 
                (select * from 
                (select C.txn_id, C.p_display_name, C.p_property_name, C.p_purchase_date, C.p_type, C.p_status, C.txn_status, 
                        C.sp_id, C.sp_name, D.purchase_id, D.pr_client_id, D.owner_name from 
                (select A.txn_id, A.p_property_name, A.p_display_name, A.p_purchase_date, A.p_type, A.p_status, A.txn_status, 
                    case when B.txn_id is null then 0 else B.txn_id end as sp_id, B.sp_name from 
                (select * from purchase_txn where gp_id = '$gid' and txn_status = 'Approved') A 
                left join 
                (select * from sub_property_allocation where gp_id = '$gid' and txn_status = 'Approved'" . $cond2 . ") B 
                on A.txn_id = B.property_id) C 
                left join 
                (select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name from 
                (select A.purchase_id, A.pr_client_id from purchase_ownership_details A 
                where A.ow_id in (select min(ow_id) from purchase_ownership_details where purchase_id=A.purchase_id)) A 
                left join 
                (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                    case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                    case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                    case when A.c_owner_type='individual' 
                    then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                    else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                where A.c_status='Approved' and A.c_gid='$gid') B 
                on (A.pr_client_id=B.c_id)) D 
                on C.txn_id=D.purchase_id) E 
                where E.txn_status='Approved') E 
                left join 
                (select txn_id, property_id, case when sub_property_id is null then 0 else sub_property_id end as sub_property_id 
                    from sales_txn where gp_id = '$gid' and txn_status <> 'Inactive') F 
                on E.txn_id = F.property_id and E.sp_id = F.sub_property_id) G 
                where sales_id is null and sp_id<>0";
        }

        $query=$this->db->query($sql);
        $result=$query->result();
        return $result;
    }

    function check_availablity($gid, $l_id, $l_ref_id){
        $this->db->select('*');
        $this->db->where('txn_id != ', $l_id);
        $this->db->where("(txn_fkid != '$l_id' OR txn_fkid Is Null)");
        $this->db->where('gp_id', $gid);
        $this->db->where('ref_id', $l_ref_id);
        $this->db->from('loan_txn');
        $query = $this->db->get();
        // echo $this->db->last_query();
        if( $query->num_rows() != 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function insertImage($lid){
        $file_nm='image';
        if(isset($_FILES[$file_nm])) {
            $filePath='uploads/property_loan/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $filePath='uploads/property_loan/property_loan_'.$lid.'/';
            $upload_path = './' . $filePath;
            if(!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $confi['upload_path']=$upload_path;
            $confi['allowed_types']='*';
            $this->load->library('upload', $confi);
            $this->upload->initialize($confi);
            $extension="";

            if(!empty($_FILES[$file_nm]['name'])) {
                if($this->upload->do_upload($file_nm)) {
                    $upload_data=$this->upload->data();
                    $fileName=$upload_data['file_name'];
                    $extension=$upload_data['file_ext'];
                        
                    $data = array(
                        'image' => $filePath.$fileName,
                        'image_name' => $fileName
                    );
                    $this->db->where('txn_id', $lid);
                    $this->db->update('loan_txn',$data);

                    // echo "Uploaded <br>";

                } else {
                    // echo "Failed<br>";
                    // echo $this->upload->data();
                }
            }
        }
    }

    public function send_loan_intimation($lid){
        $gid=$this->session->userdata('groupid');
        
        $group_owners=$this->purchase_model->get_group_owners($gid);
        $property_owners=$this->get_loan_owners($lid);
        $prop_owners="";

        $table=$this->get_loan_list_table($lid);

        if(count($property_owners)>0){
            for($i=0;$i<count($property_owners);$i++){
                $owner_name=$property_owners[$i]->owner_name;
                $to_email=$property_owners[$i]->ow_contact_email_id;

                $prop_owners=$prop_owners.$owner_name.', ';

                $this->send_loan_intimation_to_owner($table, $owner_name, $to_email);
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

                $this->send_loan_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners);
            }
        }
    }

    public function get_loan_owners($loan_id) {
        // $query=$this->db->query("SELECT A.*, B.c_emailid1 as ow_contact_email_id from 
        //                         (SELECT A.brower_id, 
        //                         case when B.ow_type = '0' then 
        //                         (select concat(ifnull(c_name,''),' ',ifnull(c_last_name,'')) as c_name from contact_master where c_id = B.ow_ind_id) 
        //                         when B.ow_type = '1' then B.ow_huf_name 
        //                         when B.ow_type = '2' then B.ow_pvtltd_comapny_name 
        //                         when B.ow_type = '3' then B.ow_ltd_comapny_name 
        //                         when B.ow_type = '4' then B.ow_llp_comapny_name 
        //                         when B.ow_type = '5' then B.ow_prt_comapny_name 
        //                         when B.ow_type = '6' then B.ow_aop_comapny_name 
        //                         when B.ow_type = '7' then B.ow_trs_comapny_name 
        //                         else B.ow_proprietorship_comapny_name end as owner_name, 
        //                         case when B.ow_type = '0' then B.ow_ind_id 
        //                         when B.ow_type = '1' then B.ow_huf_karta_id 
        //                         when B.ow_type = '2' then B.ow_pvtltd_contact 
        //                         when B.ow_type = '3' then B.ow_ltd_contact 
        //                         when B.ow_type = '4' then B.ow_llp_contact 
        //                         when B.ow_type = '5' then B.ow_prt_contact 
        //                         when B.ow_type = '6' then B.ow_aop_contact 
        //                         when B.ow_type = '7' then B.ow_trs_contact 
        //                         else B.ow_proprietorship_contact end as ow_contact_id 
        //                         FROM loan_borrower_details A, owner_master B 
        //                         WHERE A.loan_id = '$loan_id' and A.brower_id=B.ow_id) A 
        //                         left join 
        //                         (select * from contact_master) B 
        //                         on (A.ow_contact_id=B.c_id)");
        
            $sql = "select A.*, B.c_name, B.c_last_name, B.c_emailid1, B.owner_name, B.c_emailid1 as ow_contact_email_id from 
                    (select A.loan_id, A.brower_id from loan_borrower_details A 
                        where A.loan_id = '$loan_id' and A.brower_id in (select min(brower_id) from loan_borrower_details where loan_id=A.loan_id)) A 
                    left join 
                    (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
                        case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
                        case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
                        case when A.c_owner_type='individual' 
                        then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
                        else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
                    from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
                    where A.c_status='Approved') B 
                    on (A.brower_id=B.c_id)";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function get_loan_list_table($lid) {
        $loan = $this->loanData("All", "", $lid);
        $table='';

        if(count($loan)>0) {
            $table='<div>
                    <table style="border-collapse: collapse; border: 1px solid black;">
                        <thead>
                            <tr>
                                <th style="padding:5px; border: 1px solid black;" width="55">ID</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Ref Id</th>
                                <th style="padding:5px; border: 1px solid black;" width="100">Borrower Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Property Name</th>
                                <th style="padding:5px; border: 1px solid black;" width="110">Financial Institution</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Intrest Type</th>
                                <th style="padding:5px; border: 1px solid black;" width="90">Loan Amount (In Rs)</th>
                                <th style="padding:5px; border: 1px solid black;" width="50">Loan Date</th>
                            </tr>
                        </thead>
                        <tbody>';

            for($i=0;$i<count($loan); $i++ ) {
                $table=$table.'<tr>
                                <td style="padding:5px; border: 1px solid black;">'.($i+1).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->ref_id.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->owner_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->p_property_name.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->financial_institution.'</td>
                                <td style="padding:5px; border: 1px solid black;">'.$loan[$i]->interest_type.'</td>
                                <td style="padding:5px; text-align:right; border: 1px solid black;">'.format_money($loan[$i]->loan_amount,2).'</td>
                                <td style="padding:5px; border: 1px solid black;">'.(($loan[$i]->loan_startdate!=null && $loan[$i]->loan_startdate!='')?date('d/m/Y',strtotime($loan[$i]->loan_startdate)):'').'</td>
                            </tr>';
            }

            $table=$table.'</tbody></table></div>';

            // echo $table;
            return $table;
        }
    }

    public function send_loan_intimation_to_group_owner($table, $owner_name, $to_email, $prop_owners) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Loan Intimation';

        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Loan Entry has been created for '.$prop_owners.'. 
                    The Loan details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Loan details are incorrect please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }

    public function send_loan_intimation_to_owner($table, $owner_name, $to_email) {
        $from_email = 'info@pecanreams.com';
        $from_email_sender = 'Pecan REAMS';
        $subject = 'Loan Intimation';
        
        $message = '<html><head></head><body>Dear '.$owner_name.'<br /><br />
                    We would like to bring to your notice that a New Loan Entry has been mapped to you. 
                    The Loan details are as follows.<br /><br />' . $table . '<br /><br />
                    If the above Loan is not in existence please reject the same immediately.<br /><br />Thanks</body></html>';
        $mailSent=send_email($from_email,  $from_email_sender, $to_email, $subject, $message);

        // echo $owner_name . ' ';
    }
}
?>