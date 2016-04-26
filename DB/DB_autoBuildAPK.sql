/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : sourceid

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-04-26 17:51:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for function
-- ----------------------------
DROP TABLE IF EXISTS `function`;
CREATE TABLE `function` (
  `f_name` varchar(100) COLLATE gbk_bin NOT NULL,
  `f_value` varchar(50) COLLATE gbk_bin NOT NULL,
  `f_venv` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of function
-- ----------------------------
INSERT INTO `function` VALUES ('首次下卡屏蔽更新', 'firstgetcard_updateoff', '1');
INSERT INTO `function` VALUES ('官网版本 ', 'online', '0');
INSERT INTO `function` VALUES ('仅屏蔽更新 ', 'offupdate', '2');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `value` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('0', '超级管理员', '神一般存在', '0');
INSERT INTO `permission` VALUES ('1', '管理员', '可添加用户、上传包、运行', '1');
INSERT INTO `permission` VALUES ('3', '添加用户', '可以添加用户', '3');
INSERT INTO `permission` VALUES ('4', '打包员', '可运行打包程序', '4');
INSERT INTO `permission` VALUES ('5', '只读管理员', '可以切换到管理员界面查看', '5');
INSERT INTO `permission` VALUES ('9', '查看', '仅仅查看某页面', '9');
INSERT INTO `permission` VALUES ('2', '上传', '上传无签名包', '2');

-- ----------------------------
-- Table structure for platform
-- ----------------------------
DROP TABLE IF EXISTS `platform`;
CREATE TABLE `platform` (
  `p_name` varchar(25) COLLATE gbk_bin NOT NULL,
  `p_value` varchar(25) COLLATE gbk_bin NOT NULL,
  `p_venv` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of platform
-- ----------------------------
INSERT INTO `platform` VALUES ('官网环境', 'online', '1');
INSERT INTO `platform` VALUES ('模拟环境', 'demo', '2');
INSERT INTO `platform` VALUES ('测试环境', 'test', '3');

-- ----------------------------
-- Table structure for source
-- ----------------------------
DROP TABLE IF EXISTS `source`;
CREATE TABLE `source` (
  `s_id` int(10) NOT NULL AUTO_INCREMENT,
  `v_id` int(50) NOT NULL COMMENT 'version内',
  `f_id` int(5) NOT NULL COMMENT '特殊功能存储',
  `p_id` int(5) NOT NULL COMMENT '环境标识',
  `v_version` varchar(50) COLLATE gbk_bin NOT NULL COMMENT 'version内渠道号',
  `s_status` int(5) NOT NULL COMMENT '0，成功；1,失败',
  `client_platform` int(2) NOT NULL,
  `percentage` int(5) NOT NULL DEFAULT '0' COMMENT '临时存储进度',
  `s_value` text COLLATE gbk_bin NOT NULL COMMENT '存放每次提交的所有sourceid',
  `s_submitdatetime` datetime DEFAULT NULL COMMENT '提交时间',
  `update_time` datetime DEFAULT NULL,
  `u_mailcc` varchar(255) COLLATE gbk_bin NOT NULL DEFAULT 'liuxue@vancl.cn' COMMENT '抄送邮件',
  `uid` int(5) NOT NULL COMMENT '保存user_admin内的uid',
  `mail` varchar(50) COLLATE gbk_bin NOT NULL COMMENT 'session[mail]',
  `ftp` longtext COLLATE gbk_bin COMMENT 'ftp信息',
  `s_describe` varchar(600) COLLATE gbk_bin NOT NULL COMMENT '描述信息',
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of source
-- ----------------------------
INSERT INTO `source` VALUES ('1', '1', '0', '1', 'v3.2.0', '1', '0', '11', 0x76767630310A7676763032736166736166617366617366640A7676763033666473660A767676303466666666660A767676303573616661660A767676303661736173660A76767630370A767676303873616466736166647361667676763020390A76767631300A7676763131, '2013-01-17 19:22:57', '2013-01-18 14:11:16', 'test@kinggoo.com', '2', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('2', '1', '0', '1', 'v3.2.0', '1', '0', '1', '', '2013-01-17 20:23:12', '2013-01-17 20:23:12', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('3', '1', '0', '1', 'v3.2.0', '1', '0', '1', '', '2013-01-17 20:26:38', '2013-01-17 20:26:38', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('4', '1', '0', '1', 'v3.2.0', '1', '0', '1', 0x30, '2013-01-17 20:27:37', '2013-01-17 20:27:37', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('5', '1', '0', '1', 'v3.2.0', '1', '0', '1', 0x30, '2013-01-17 20:30:12', '2013-01-17 20:30:12', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('6', '1', '0', '1', 'v3.2.0', '1', '0', '1', 0x30, '2013-01-17 20:45:44', '2013-01-17 20:45:44', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, 'f');
INSERT INTO `source` VALUES ('7', '1', '0', '1', 'v3.2.0', '1', '0', '1', 0x30, '2013-01-17 20:49:38', '2013-01-17 20:49:38', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('8', '1', '0', '1', 'v3.2.0', '1', '0', '1', 0x30, '2013-01-17 20:52:21', '2013-01-17 20:52:21', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('9', '1', '0', '1', 'v3.2.0', '1', '0', '1', 0x30, '2013-01-17 20:54:00', '2013-01-17 20:54:00', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('10', '1', '0', '1', 'v3.2.0', '1', '0', '1', '', '2013-01-17 20:54:38', '2013-01-17 20:54:38', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('11', '1', '0', '1', 'v3.2.0', '1', '0', '2', 0x6673667330310A667366733032, '2013-01-17 21:00:03', '2013-01-17 21:00:03', 'test@kinggoo.com', '1', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, '无描述');
INSERT INTO `source` VALUES ('12', '2', '1', '1', '1', '1', '0', '1', 0x666631313131312E61706B20206775616E, '2013-01-18 18:06:26', '2013-01-18 18:06:26', 'test@kinggoo.com', '2', 'test@kinggoo.com', 0xE69CAAE689A7E8A18CE79BB8E585B3E6938DE4BD9C, 'f');

-- ----------------------------
-- Table structure for user_admin
-- ----------------------------
DROP TABLE IF EXISTS `user_admin`;
CREATE TABLE `user_admin` (
  `uid` int(5) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `password` varchar(100) COLLATE gbk_bin NOT NULL DEFAULT '084e0343a0486ff05530df6c705c8bb4' COMMENT 'LADP验证密码替代品',
  `username` varchar(30) COLLATE gbk_bin NOT NULL COMMENT '用户名称，可能会是邮箱地址',
  `email` varchar(255) COLLATE gbk_bin NOT NULL,
  `ugid` int(5) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of user_admin
-- ----------------------------
INSERT INTO `user_admin` VALUES ('1', 'eb88f6710da3f3cf32cbb3b568698136', 'admin', 'admin@kinggoo.cn', '0');
INSERT INTO `user_admin` VALUES ('2', 'a89769766a1da3539aba65057c3c5ea9', 'test-2', 'test@kinggoo.cn', '2');
INSERT INTO `user_admin` VALUES ('3', '16262cf36b4582b3afcf9030095a227a', 'test3', 'test@kinggoo.com', '4');
INSERT INTO `user_admin` VALUES ('4', 'd36e156c948906b46bf11b3388e651e5', 'test4', 'test4@kinggoo.com', '4');

-- ----------------------------
-- Table structure for user_group
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `gid` int(5) NOT NULL,
  `gname` varchar(25) COLLATE gbk_bin NOT NULL,
  `user_shell` varchar(200) COLLATE gbk_bin NOT NULL,
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of user_group
-- ----------------------------
INSERT INTO `user_group` VALUES ('1', '管理员', '15');
INSERT INTO `user_group` VALUES ('2', '提交组', '7');
INSERT INTO `user_group` VALUES ('3', '删除', '3');
INSERT INTO `user_group` VALUES ('4', '查看', '1');

-- ----------------------------
-- Table structure for version
-- ----------------------------
DROP TABLE IF EXISTS `version`;
CREATE TABLE `version` (
  `v_id` int(25) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) COLLATE gbk_bin NOT NULL,
  `v_versioncode` int(255) NOT NULL DEFAULT '0' COMMENT 'VersionCode',
  `v_packname` varchar(200) COLLATE gbk_bin NOT NULL COMMENT '软件包名',
  `client_platform` int(2) NOT NULL,
  `size` float NOT NULL COMMENT '包大小',
  `v_path` varchar(1000) COLLATE gbk_bin NOT NULL DEFAULT '/var/html/www/abc/' COMMENT '存放路径',
  `v_function` int(10) NOT NULL COMMENT '0:官网,1:下卡屏新,2:屏更新',
  `v_version` varchar(255) COLLATE gbk_bin NOT NULL,
  `v_env` int(5) NOT NULL COMMENT '1:online,2:demo,3:test',
  `submittime` datetime NOT NULL,
  PRIMARY KEY (`v_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk COLLATE=gbk_bin;

-- ----------------------------
-- Records of version
-- ----------------------------
INSERT INTO `version` VALUES ('1', 'liuxue', '426', 'AndroidPhone_v3.2.0.0000_05_20121122_online_unsign_versionCode426.apk', '0', '4.14109', '../upfile/', '0', 'v3.2.0', '1', '2013-01-17 19:22:34');
INSERT INTO `version` VALUES ('2', 'liuxue', '1', '1.apk', '0', '4.14109', '../upfile/', '1', '1', '1', '2013-01-18 17:48:05');
INSERT INTO `version` VALUES ('3', 'liuxue', '2', '2.apk', '0', '4.14109', '../upfile/', '1', '2', '2', '2013-01-18 17:48:05');
INSERT INTO `version` VALUES ('4', 'admin', '2323', 'mhash_0.9.9.apk', '0', '0.87702', '../upfile/', '0', 'v1', '1', '2016-04-26 14:26:53');
