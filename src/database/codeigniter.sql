/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : codeigniter

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-07-08 17:24:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(32) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  `time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='配置表';

-- ----------------------------
-- Records of log
-- ----------------------------

-- ----------------------------
-- Table structure for sys_email_log
-- ----------------------------
DROP TABLE IF EXISTS `sys_email_log`;
CREATE TABLE `sys_email_log` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `To` varchar(50) NOT NULL,
  `Content` text NOT NULL COMMENT '邮件内容',
  `Status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否发送标识[0为未发送，1为已发送]',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='定时发邮件日志表';

-- ----------------------------
-- Records of sys_email_log
-- ----------------------------

-- ----------------------------
-- Table structure for sys_email_login
-- ----------------------------
DROP TABLE IF EXISTS `sys_email_login`;
CREATE TABLE `sys_email_login` (
  `Id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ToEmail` varchar(50) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `Password` char(50) NOT NULL COMMENT '动态验证码',
  `Status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '使用状态(0为未使用，1为已使用)',
  `ValidDate` int(11) NOT NULL COMMENT '有效时间',
  `CreateDate` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='动态密码登陆记录表';

-- ----------------------------
-- Records of sys_email_login
-- ----------------------------

-- ----------------------------
-- Table structure for sys_menu
-- ----------------------------
DROP TABLE IF EXISTS `sys_menu`;
CREATE TABLE `sys_menu` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ParentId` mediumint(9) NOT NULL DEFAULT '0',
  `Title` varchar(155) NOT NULL DEFAULT '',
  `Sort` smallint(6) NOT NULL DEFAULT '0',
  `LinkInfo` varchar(255) NOT NULL DEFAULT '',
  `Status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(55) NOT NULL DEFAULT '' COMMENT '分类小图标',
  `Deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='管理后台菜单';

-- ----------------------------
-- Records of sys_menu
-- ----------------------------
INSERT INTO `sys_menu` VALUES ('1', '0', '系统管理', '-1', '', '1', '', '0');
INSERT INTO `sys_menu` VALUES ('2', '0', '开发模块', '-2', '', '1', '', '0');
INSERT INTO `sys_menu` VALUES ('5', '2', '控制器管理', '0', 'a:3:{s:1:\"d\";s:5:\"admin\";s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:8:\"ctrllist\";}', '1', '', '0');
INSERT INTO `sys_menu` VALUES ('6', '1', '菜单管理', '0', 'a:3:{s:1:\"d\";s:5:\"admin\";s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:8:\"menulist\";}', '1', '', '0');
INSERT INTO `sys_menu` VALUES ('7', '1', '角色管理', '2', 'a:3:{s:1:\"d\";s:5:\"admin\";s:1:\"c\";s:4:\"Role\";s:1:\"a\";s:8:\"rolelist\";}', '1', '', '0');
INSERT INTO `sys_menu` VALUES ('9', '2', '模型管理', '0', 'a:3:{s:1:\"d\";s:5:\"admin\";s:1:\"c\";s:3:\"Mod\";s:1:\"a\";s:7:\"modlist\";}', '1', '', '1');
INSERT INTO `sys_menu` VALUES ('10', '1', '用户管理', '3', 'a:3:{s:1:\"d\";s:5:\"admin\";s:1:\"c\";s:4:\"User\";s:1:\"a\";s:8:\"userlist\";}', '1', '', '0');

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `Id` smallint(6) NOT NULL AUTO_INCREMENT,
  `Name` char(50) NOT NULL DEFAULT '' COMMENT '角色名',
  `Intro` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `Status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '角色状态 0:禁用,1:正常',
  `Permissions` text NOT NULL COMMENT '权限',
  `Deleted` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`Id`),
  KEY `Name` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户角色';

-- ----------------------------
-- Records of sys_role
-- ----------------------------
INSERT INTO `sys_role` VALUES ('1', '系统管理员', '系统管理员用户组', '1', 'a:7:{s:4:\"Ctrl\";a:7:{s:13:\"addcontroller\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:13:\"addcontroller\";s:1:\"d\";s:5:\"admin\";}s:9:\"addaction\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:9:\"addaction\";s:1:\"d\";s:5:\"admin\";}s:8:\"ctrllist\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:8:\"ctrllist\";s:1:\"d\";s:5:\"admin\";}s:8:\"funclist\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:8:\"funclist\";s:1:\"d\";s:5:\"admin\";}s:7:\"add_dir\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:7:\"add_dir\";s:1:\"d\";s:5:\"admin\";}s:8:\"editctrl\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:8:\"editctrl\";s:1:\"d\";s:5:\"admin\";}s:8:\"editfunc\";a:3:{s:1:\"c\";s:4:\"Ctrl\";s:1:\"a\";s:8:\"editfunc\";s:1:\"d\";s:5:\"admin\";}}s:3:\"Mod\";a:5:{s:7:\"modlist\";a:3:{s:1:\"c\";s:3:\"Mod\";s:1:\"a\";s:7:\"modlist\";s:1:\"d\";s:5:\"admin\";}s:8:\"addmodel\";a:3:{s:1:\"c\";s:3:\"Mod\";s:1:\"a\";s:8:\"addmodel\";s:1:\"d\";s:5:\"admin\";}s:7:\"addfunc\";a:3:{s:1:\"c\";s:3:\"Mod\";s:1:\"a\";s:7:\"addfunc\";s:1:\"d\";s:5:\"admin\";}s:7:\"methods\";a:3:{s:1:\"c\";s:3:\"Mod\";s:1:\"a\";s:7:\"methods\";s:1:\"d\";s:5:\"admin\";}s:7:\"add_dir\";a:3:{s:1:\"c\";s:3:\"Mod\";s:1:\"a\";s:7:\"add_dir\";s:1:\"d\";s:5:\"admin\";}}s:4:\"Menu\";a:6:{s:8:\"add_menu\";a:3:{s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:8:\"add_menu\";s:1:\"d\";s:5:\"admin\";}s:9:\"edit_menu\";a:3:{s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:9:\"edit_menu\";s:1:\"d\";s:5:\"admin\";}s:7:\"add_cat\";a:3:{s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:7:\"add_cat\";s:1:\"d\";s:5:\"admin\";}s:8:\"edit_cat\";a:3:{s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:8:\"edit_cat\";s:1:\"d\";s:5:\"admin\";}s:8:\"menulist\";a:3:{s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:8:\"menulist\";s:1:\"d\";s:5:\"admin\";}s:6:\"delete\";a:3:{s:1:\"c\";s:4:\"Menu\";s:1:\"a\";s:6:\"delete\";s:1:\"d\";s:5:\"admin\";}}s:4:\"User\";a:4:{s:8:\"userlist\";a:3:{s:1:\"c\";s:4:\"User\";s:1:\"a\";s:8:\"userlist\";s:1:\"d\";s:5:\"admin\";}s:7:\"adduser\";a:3:{s:1:\"c\";s:4:\"User\";s:1:\"a\";s:7:\"adduser\";s:1:\"d\";s:5:\"admin\";}s:9:\"edit_user\";a:3:{s:1:\"c\";s:4:\"User\";s:1:\"a\";s:9:\"edit_user\";s:1:\"d\";s:5:\"admin\";}s:6:\"delete\";a:3:{s:1:\"c\";s:4:\"User\";s:1:\"a\";s:6:\"delete\";s:1:\"d\";s:5:\"admin\";}}s:4:\"Role\";a:4:{s:8:\"rolelist\";a:3:{s:1:\"c\";s:4:\"Role\";s:1:\"a\";s:8:\"rolelist\";s:1:\"d\";s:5:\"admin\";}s:7:\"addrole\";a:3:{s:1:\"c\";s:4:\"Role\";s:1:\"a\";s:7:\"addrole\";s:1:\"d\";s:5:\"admin\";}s:8:\"editrole\";a:3:{s:1:\"c\";s:4:\"Role\";s:1:\"a\";s:8:\"editrole\";s:1:\"d\";s:5:\"admin\";}s:6:\"delete\";a:3:{s:1:\"c\";s:4:\"Role\";s:1:\"a\";s:6:\"delete\";s:1:\"d\";s:5:\"admin\";}}s:4:\"Home\";a:1:{s:5:\"index\";a:3:{s:1:\"c\";s:4:\"Home\";s:1:\"a\";s:5:\"index\";s:1:\"d\";s:5:\"admin\";}}s:7:\"Crontab\";a:1:{s:3:\"run\";a:3:{s:1:\"c\";s:7:\"Crontab\";s:1:\"a\";s:3:\"run\";s:1:\"d\";s:0:\"\";}}}', '0');

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `Id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `UserName` char(32) NOT NULL DEFAULT '' COMMENT '微信企业号id',
  `NickName` char(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `RoleId` smallint(6) NOT NULL DEFAULT '0' COMMENT '角色组ID',
  `Email` char(50) NOT NULL COMMENT '邮箱',
  `Status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户状态 0:禁用,1:正常',
  `LastLogTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最近登录时间',
  `LastLogIP` char(15) NOT NULL DEFAULT '' COMMENT '最近登录IP',
  `LogFaild` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '登陆失败次数',
  `Deleted` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`Id`),
  KEY `sys_user_ibfk_2` (`RoleId`),
  CONSTRAINT `sys_user_ibfk_2` FOREIGN KEY (`RoleId`) REFERENCES `sys_role` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('2', 'zsm', '匿名', '1', 'your email', '1', '1467968703', '192.168.9.76', '0', '0');
