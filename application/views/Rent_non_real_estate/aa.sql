select * from (select C.*, C.total_amount-C.paid_amount as bal_amount, D.contact_id, D.c_full_name as payer_name, D.tenant_name from (select A.*, B.unit_name,B.unit_type from (select * from (select C.*, D.rent_id, D.event_type, D.event_name, D.event_date, case when D.basic_cost is null then 0 else D.basic_cost end as basic_cost, case when D.total_amount is null then 0 else D.total_amount end as total_amount, case when D.tax_amount is null then 0 else D.tax_amount end as tax_amount, case when D.paid_amount is null then 0 else D.paid_amount end as paid_amount from (select A.* from (select * from rent_txn where gp_id = '64' and txn_status='Approved' and property_id in (select distinct purchase_id from purchase_ownership_details) and property_id='576' ) A ) C left join (select * from (select A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.total_amount, A.tax_amount, case when B.paid_amount is null then 0 else B.paid_amount end as paid_amount from (select A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.total_amount, sum(B.tax_amount) as tax_amount from rent_schedule A left join rent_schedule_taxation B on (A.rent_id=B.rent_id and A.sch_id=B.sch_id) where A.status = '1' and (B.status = '1' or B.status is null) group by A.sch_id, A.rent_id, A.event_type, A.event_name, A.event_date, A.basic_cost, A.total_amount) A left join (select fk_txn_id, event_type, event_name, event_date, sum(paid_amount)+sum(tds_amount) as paid_amount from actual_schedule where table_type = 'rent' group by fk_txn_id, event_type, event_name, event_date) B on (A.rent_id=B.fk_txn_id and A.event_type=B.event_type and A.event_name=B.event_name and A.event_date=B.event_date)) C where C.paid_amount<>C.total_amount) D on C.txn_id=D.rent_id) E where E.paid_amount<>E.total_amount) A left join (select * from property_txn where gp_id = '64') B on A.property_id=B.property_txn_id) C left join (SELECT A.*, B.c_name, B.c_last_name, B.c_full_name, B.c_emailid1, B.tenant_name FROM (SELECT * FROM rent_tenant_details A WHERE A.contact_id in (select min(contact_id) from rent_tenant_details where rent_id = A.rent_id)) A LEFT JOIN (select A.c_id, case when A.c_owner_type='individual' then ifnull(A.c_name,'') else ifnull(B.c_name,'') end as c_name, case when A.c_owner_type='individual' then ifnull(A.c_last_name,'') else ifnull(B.c_last_name,'') end as c_last_name, case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) else concat(ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as c_full_name, case when A.c_owner_type='individual' then ifnull(A.c_emailid1,'') else ifnull(B.c_emailid1,'') end as c_emailid1, case when A.c_owner_type='individual' then ifnull(A.c_mobile1,'') else ifnull(B.c_mobile1,'') end as c_mobile1, case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as tenant_name from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) where A.c_status='Approved' and A.c_gid='64') B ON (A.contact_id=B.c_id)) D on C.txn_id=D.rent_id) E left join (Select purchase_id,pr_client_id,owner_name from (SELECT purchase_id,pr_client_id from purchase_ownership_details) A LEFT JOIN (select A.c_id,case when A.c_owner_type='individual' then concat(ifnull(A.c_name,''),' ',ifnull(A.c_last_name,'')) else concat(ifnull(A.c_company_name,''),' - ',ifnull(B.c_name,''),' ',ifnull(B.c_last_name,'')) end as owner_name from contact_master A left join contact_master B on (A.c_contact_id=B.c_id) where A.c_status='Approved' and A.c_gid='64') B ON (A.pr_client_id=B.c_id) ) D on E.property_id=D.purchase_id where E.tenant_name is not null and E.tenant_name<>''