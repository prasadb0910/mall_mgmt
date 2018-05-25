/*
Navicat MySQL Data Transfer

Source Server         : Locahost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mall_mgmt

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-24 14:50:40
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `property_txn`
-- ----------------------------
DROP TABLE IF EXISTS `property_txn`;
CREATE TABLE `property_txn` (
  `property_txn_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_typ_id` int(11) NOT NULL,
  `gp_id` int(11) NOT NULL,
  `unit_name` varchar(250) NOT NULL,
  `unit_type` varchar(250) NOT NULL,
  `unit_no` varchar(250) NOT NULL,
  `floor` varchar(250) NOT NULL,
  `area` varchar(250) NOT NULL,
  `area_unit` varchar(250) NOT NULL,
  `allocated_cost` bigint(11) NOT NULL,
  `allocated_maintenance` varchar(250) NOT NULL,
  `txn_status` varchar(50) NOT NULL,
  `added_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `p_image` varchar(100) DEFAULT NULL,
  `p_image_name` varchar(100) DEFAULT NULL,
  `location` varchar(250) DEFAULT NULL,
  `txn_fkid` int(11) DEFAULT NULL,
  PRIMARY KEY (`property_txn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of property_txn
-- ----------------------------
INSERT INTO property_txn VALUES ('1', '1', '64', '186,J B Road,Sewree west', 'Basement', '56', '2', '788888', 'Sqm', '67000', 'Test', '', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('2', '1', '64', 'EERR', 'Shop', '45', 'B', '5000', 'Sqft', '56777', '45', 'Approved', '571', '2018-05-21 15:39:20', '0', '2018-05-21 00:00:00', 'uploads/property_purchase/property_purchase_2/building.jpg', 'building.jpg', '', null);
INSERT INTO property_txn VALUES ('3', '1', '64', '56', 'Basement', '45', '6', '67888', 'Sqm', '789555', 'Test', 'In Process', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('4', '1', '64', '186,J B Road,Sewree west', 'Basement', '909', 'B', '90909', 'Sqm', '67990', 'Test', 'In Process', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('5', '1', '64', 'XSR', 'Shop', '45', 'B', '6000', 'Sqft', '56000', '56000', 'In Process', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('6', '1', '64', 'XSR', 'Shop', '45', 'B', '6000', 'Sqft', '56000', '56000', 'In Process', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('7', '1', '64', 'XSR', 'Shop', '45', 'B', '6000', 'Sqft', '56000', '56000', 'In Process', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('8', '1', '64', 'XSR', 'Shop', '45', 'B', '6000', 'Sqft', '56000', '56000', 'In Process', '571', '2018-05-18 00:00:00', '0', '2018-05-18 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('9', '1', '64', 'Khar', 'Shop', '56', '2', '5677', 'Sqft', '67897', 'Test', 'In Process', '571', '2018-05-19 00:00:00', '0', '2018-05-19 00:00:00', null, null, null, null);
INSERT INTO property_txn VALUES ('10', '1', '64', 'Khar', 'Shop', '56', '2', '5677', 'Sqft', '67897', 'Test', 'In Process', '571', '2018-05-19 00:00:00', '0', '2018-05-19 00:00:00', 'uploads/property_purchase/property_purchase_10/sample.jpg', 'sample.jpg', null, null);
INSERT INTO property_txn VALUES ('11', '1', '64', 'Sangeeta ', 'Basement', '56', '3', '5000', 'Sqft', '565765', 'Test', 'Approved', '571', '2018-05-19 00:00:00', '0', '2018-05-19 00:00:00', null, null, '', null);
INSERT INTO property_txn VALUES ('12', '1', '64', 'Khar', 'Kiosks', '56', '3', '56000', 'Sqft', '0', '', 'In Process', '571', '2018-05-19 00:00:00', '0', '2018-05-19 00:00:00', null, null, '', null);
INSERT INTO property_txn VALUES ('15', '1', '64', '', 'Kiosks', '', '', '56000', 'Sqft', '0', '', 'In Process', '571', '2018-05-19 00:00:00', '0', '2018-05-19 00:00:00', null, null, '', null);
INSERT INTO property_txn VALUES ('16', '2', '64', 'weewr', 'Hoarding', '', '', '32423', 'Sqft', '0', '', 'In Process', '571', '2018-05-21 15:49:46', '0', '2018-05-21 00:00:00', 'uploads/property_purchase/property_purchase_16/building.jpg', 'building.jpg', '', null);
INSERT INTO property_txn VALUES ('17', '2', '64', 'weewr', 'Hoarding', '', '', '32423', 'Sqft', '0', '', 'Approved', '571', '2018-05-21 15:53:20', '0', '2018-05-21 00:00:00', 'uploads/property_purchase/property_purchase_17/images_(1).jpg', 'images_(1).jpg', 'Mumbai', null);
INSERT INTO property_txn VALUES ('18', '1', '64', 'weewr', 'Hoarding', '', '', '32423', 'Sqft', '0', '', 'In Process', '571', '2018-05-19 00:00:00', '0', '2018-05-19 00:00:00', null, null, '', null);
