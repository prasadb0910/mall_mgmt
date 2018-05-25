/*
Navicat MySQL Data Transfer

Source Server         : Locahost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : mall_mgmt

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-05-24 14:51:23
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `revenue_schedule`
-- ----------------------------
DROP TABLE IF EXISTS `revenue_schedule`;
CREATE TABLE `revenue_schedule` (
  `revenue_schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `rent_id` int(11) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '0',
  `revenue_amount` bigint(11) DEFAULT NULL,
  `updated_rent_scehdule_id` int(11) DEFAULT NULL,
  `revenue_sharing_amount` bigint(11) DEFAULT NULL,
  PRIMARY KEY (`revenue_schedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of revenue_schedule
-- ----------------------------
INSERT INTO revenue_schedule VALUES ('1', '1', '2018-05-05', '17', '1', '100000', '275', '12000');
INSERT INTO revenue_schedule VALUES ('2', '1', '2018-06-05', '17', '1', '90000', '276', '10800');
INSERT INTO revenue_schedule VALUES ('3', '1', '2018-07-05', '17', '1', '70000', '274', '8400');
INSERT INTO revenue_schedule VALUES ('4', '1', '2018-08-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('5', '1', '2018-09-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('6', '1', '2018-10-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('7', '1', '2018-11-05', '17', '1', '900000', '277', '108000');
INSERT INTO revenue_schedule VALUES ('8', '1', '2018-12-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('9', '1', '2019-01-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('10', '1', '2019-02-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('11', '1', '2019-03-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('12', '1', '2019-04-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('13', '1', '2019-05-05', '17', '0', '0', '0', null);
INSERT INTO revenue_schedule VALUES ('14', '1', '2019-06-05', '17', '0', '0', '0', null);
