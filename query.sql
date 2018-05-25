ALTER TABLE `contact_master` ADD `c_contact_id` INT NULL DEFAULT NULL AFTER `c_gst_no`, ADD `c_company_name` VARCHAR(100) NULL DEFAULT NULL AFTER `c_contact_id`, ADD `c_incop_date` DATE NULL DEFAULT NULL AFTER `c_company_name`, ADD `c_branch` VARCHAR(100) NULL DEFAULT NULL AFTER `c_incop_date`, ADD `c_telephone` VARCHAR(100) NULL DEFAULT NULL AFTER `c_branch`, ADD `c_mobile` VARCHAR(100) NULL DEFAULT NULL AFTER `c_telephone`, ADD `c_owner_type` VARCHAR(100) NULL DEFAULT NULL AFTER `c_mobile`;

ALTER TABLE `contact_master` ADD `c_reg_no` VARCHAR(100) NULL DEFAULT NULL AFTER `c_company_name`;

ALTER TABLE `contact_master` CHANGE `c_name` `c_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `c_company` `c_company` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `c_middle_name` `c_middle_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `c_last_name` `c_last_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `c_type` `c_type` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `txn_remarks` `c_txn_remarks` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL, CHANGE `maker_remark` `c_maker_remark` VARCHAR(500) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `contact_nominee_details` DROP `nm_designation`, DROP `nm_mobile`, DROP `nm_emailid`;

delete from contact_nominee_details where nm_name = '';

ALTER TABLE `contact_nominee_details` CHANGE `nm_id` `id` INT(11) NOT NULL AUTO_INCREMENT, CHANGE `nm_cid` `ref_id` INT(11) NULL DEFAULT NULL, CHANGE `nm_name` `c_id` INT(11) NULL DEFAULT NULL, CHANGE `nm_relation` `relation` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

CREATE TABLE `contact_family_details` (`id` int(11) NOT NULL, `ref_id` int(11) DEFAULT NULL, `c_id` int(11) DEFAULT NULL, `relation` varchar(100) CHARACTER SET utf8 DEFAULT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `purchase_txn` ADD `p_image` VARCHAR(255) NULL DEFAULT NULL AFTER `maker_remark`, ADD `p_image_name` VARCHAR(255) NULL DEFAULT NULL AFTER `p_image`;

ALTER TABLE `rent_txn` ADD `notice_period` INT(11) NULL DEFAULT NULL AFTER `property_tax_by`;

ALTER TABLE `rent_txn` CHANGE `free_rent_period` `free_rent_period` INT NULL DEFAULT NULL, CHANGE `deposit_amount` `deposit_amount` DOUBLE NULL DEFAULT NULL, CHANGE `lease_period` `lease_period` INT NULL DEFAULT NULL, CHANGE `rent_due_day` `rent_due_day` INT NULL DEFAULT NULL, CHANGE `created_by` `created_by` INT NULL DEFAULT NULL, CHANGE `modified_by` `modified_by` INT NULL DEFAULT NULL, CHANGE `approved_by` `approved_by` INT NULL DEFAULT NULL;

ALTER TABLE `rent_txn` ADD `category` VARCHAR(100) NULL DEFAULT NULL AFTER `notice_period`, ADD `schedule` VARCHAR(100) NULL DEFAULT NULL AFTER `category`, ADD `invoice_date` DATE NULL DEFAULT NULL AFTER `schedule`, ADD `gst` TINYINT NULL DEFAULT NULL AFTER `invoice_date`, ADD `gst_rate` DOUBLE NULL DEFAULT NULL AFTER `gst`, ADD `tds` TINYINT NULL DEFAULT NULL AFTER `gst_rate`, ADD `tds_rate` DOUBLE NULL DEFAULT NULL AFTER `tds`, ADD `pdc` TINYINT NULL DEFAULT NULL AFTER `tds_rate`, ADD `deposit_category` VARCHAR(100) NULL DEFAULT NULL AFTER `pdc`;

ALTER TABLE `sales_txn` ADD `p_image` VARCHAR(255) NULL DEFAULT NULL AFTER `maker_remark`, ADD `p_image_name` VARCHAR(255) NULL DEFAULT NULL AFTER `p_image`;

Alter table sales_txn drop column sale_price;

ALTER TABLE `loan_txn` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `financial_institution`, ADD `image_name` VARCHAR(255) NULL DEFAULT NULL AFTER `image`;

ALTER TABLE `loan_disbursement` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `maker_remark`, ADD `image_name` VARCHAR(255) NULL DEFAULT NULL AFTER `image`;

ALTER TABLE `purchase_schedule` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `sales_schedule` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `rent_schedule` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `loan_schedule` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `status`;
ALTER TABLE `expense_schedule` CHANGE `modified_date` `modified_date` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `expense_schedule` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `sch_status`;
ALTER TABLE `maintenance_schedule` ADD `invoice_no` VARCHAR(100) NULL DEFAULT NULL AFTER `status`;

ALTER TABLE `actual_schedule` CHANGE `table_type` `table_type` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `event_type` `event_type` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL, CHANGE `event_name` `event_name` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `actual_schedule_taxes` ADD `fk_sch_id` INT NULL DEFAULT NULL AFTER `gp_id`;

ALTER TABLE `actual_other_schedule` ADD `basic_cost` DOUBLE NULL DEFAULT NULL AFTER `gst_rate`;

ALTER TABLE `actual_schedule` ADD `tds_amount_received` TINYINT NULL DEFAULT NULL AFTER `payer_id`;

ALTER TABLE `actual_schedule` ADD `tds_amount_received_by` INT(11) NULL DEFAULT NULL AFTER `tds_amount_received`, ADD `tds_amount_received_date` DATETIME NULL DEFAULT NULL AFTER `tds_amount_received_by`;

ALTER TABLE `user_task_detail` ADD `request_initiated_date` DATE NULL DEFAULT NULL AFTER `sub_property_id`, ADD `request_due_date` DATE NULL DEFAULT NULL AFTER `request_initiated_date`, ADD `started_to_work_date` DATE NULL DEFAULT NULL AFTER `request_due_date`, ADD `completed_work_date` DATE NULL DEFAULT NULL AFTER `started_to_work_date`;

ALTER TABLE `user_task_detail` ADD `check_in_date` DATE NULL DEFAULT NULL AFTER `completed_work_date`, ADD `time1` TINYINT NULL DEFAULT NULL AFTER `check_in_date`, ADD `time2` TINYINT NULL DEFAULT NULL AFTER `time1`, ADD `time3` TINYINT NULL DEFAULT NULL AFTER `time2`, ADD `time4` TINYINT NULL DEFAULT NULL AFTER `time3`;

ALTER TABLE `user_task_detail` ADD `self_assigned` TINYINT NULL DEFAULT NULL AFTER `time4`;

ALTER TABLE `contact_master` ADD `c_invoice_format` VARCHAR(100) NULL DEFAULT NULL AFTER `c_owner_type`, ADD `c_invoice_no` INT NULL DEFAULT NULL AFTER `c_invoice_format`;

ALTER TABLE `rent_txn` ADD `invoice_issuer` INT NULL DEFAULT NULL AFTER `deposit_category`;

ALTER TABLE `rent_schedule` ADD `invoice_date` DATE NULL DEFAULT NULL AFTER `invoice_no`;

ALTER TABLE `actual_other_schedule` ADD `invoice_date` DATE NULL DEFAULT NULL AFTER `invoice_no`;



Rent txn - 
rent_type	

Create table
Revenue_Schedule - 

