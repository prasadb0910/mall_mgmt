/*
Navicat MySQL Data Transfer

Source Server         : Locahost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mall_mgmt

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-24 14:51:06
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `rent_txn`
-- ----------------------------
DROP TABLE IF EXISTS `rent_txn`;
CREATE TABLE `rent_txn` (
  `txn_id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `sub_property_id` int(11) DEFAULT NULL,
  `tenant_id` varchar(50) DEFAULT NULL,
  `rent_amount` double DEFAULT NULL,
  `free_rent_period` int(11) DEFAULT NULL,
  `deposit_amount` double DEFAULT NULL,
  `deposit_paid_date` date DEFAULT NULL,
  `possession_date` date DEFAULT NULL,
  `lease_period` int(11) DEFAULT NULL,
  `rent_due_day` int(11) DEFAULT NULL,
  `termination_date` date DEFAULT NULL,
  `txn_status` varchar(100) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `remarks` varchar(1000) DEFAULT NULL,
  `txn_fkid` int(11) DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_date` datetime DEFAULT NULL,
  `attorney_id` int(11) DEFAULT NULL,
  `maker_remark` varchar(1000) DEFAULT NULL,
  `maintenance_by` varchar(50) DEFAULT NULL,
  `property_tax_by` varchar(50) DEFAULT NULL,
  `notice_period` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `schedule` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `gst` tinyint(4) DEFAULT NULL,
  `gst_rate` double DEFAULT NULL,
  `tds` tinyint(4) DEFAULT NULL,
  `tds_rate` double DEFAULT NULL,
  `pdc` tinyint(4) DEFAULT NULL,
  `deposit_category` varchar(100) DEFAULT NULL,
  `invoice_issuer` int(11) DEFAULT NULL,
  `rent_type` varchar(50) DEFAULT NULL,
  `revenue_percentage` int(11) DEFAULT NULL,
  `revenue_due_day` int(11) DEFAULT NULL,
  `advance_rent` int(1) DEFAULT NULL,
  `advance_rent_amount` double DEFAULT NULL,
  `rent_module_type` int(11) DEFAULT NULL,
  `locking_period` int(11) DEFAULT NULL,
  PRIMARY KEY (`txn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rent_txn
-- ----------------------------
INSERT INTO rent_txn VALUES ('1', '64', '17', null, null, '50000', '1', '50000', null, '2018-05-01', '36', '5', '2019-07-30', 'Approved', '2018-05-23', '571', '2018-05-23 17:23:02', '571', null, null, null, null, null, null, null, 'TEst', null, null, '1', 'Rent', 'Monthly', '2019-02-26', '0', '0', '0', '0', '0', 'Deposit', null, 'revenue', '12', '5', '1', '3000', '1', '14');
INSERT INTO rent_txn VALUES ('2', '64', null, null, null, '60000', '0', '50', null, '2018-05-01', '0', '0', '2019-06-05', 'In Process', '2018-05-23', '571', '2018-05-23 17:25:06', '571', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', 'Deposit', null, null, '0', null, '0', '0', '2', '13');
INSERT INTO rent_txn VALUES ('3', '64', '11', null, null, '5000', '0', '0', null, '2018-05-23', '1', '0', '2019-03-13', 'Approved', '2018-05-23', '571', '2018-05-23 17:45:21', '571', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', null, null, null, '0', null, '0', '0', null, '9');
INSERT INTO rent_txn VALUES ('4', '64', '11', null, null, '5000', '0', '0', null, '2018-05-28', '1', '0', '2019-07-17', 'Approved', '2018-05-23', '571', '2018-05-23 17:47:58', '571', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0', '0', '0', '0', '0', null, null, null, '0', null, '0', '0', null, '13');
