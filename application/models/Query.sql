Select  * from (Select * from ( Select A.*,case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from 
(Select  A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount 
from rent_schedule A 
left join rent_schedule_taxation  B on (A.rent_id=B.rent_id and A.sch_id=B.sch_id) 
where A.status = '1' and (B.status = '1' or B.status is null)  
group by A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.net_amount ) A 
left join 
(select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount 
from actual_schedule where table_type = 'rent' group by fk_txn_id, event_type, event_name, event_date) B 
on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C
where C.paid_amount<>C.net_amount ) D
left join 
(Select * from 
(SELECT * FROM rent_tenant_details A
 WHERE A.contact_id in (select min(contact_id) from rent_tenant_details 
where rent_id = A.rent_id)) A 
left join 
(select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, 
case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, 
case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
		else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, 
case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, 
case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, 
case when A.c_owner_type='individual' 
then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) 
else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name 
from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) 
where A.c_status='Approved' and A.c_gid='64' ) B
ON (A.contact_id=B.c_id) )  E on D.rent_id=E.rent_id
