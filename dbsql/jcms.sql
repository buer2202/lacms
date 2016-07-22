/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : jcms

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-07-13 11:06:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for jcms_attach_cate
-- ----------------------------
DROP TABLE IF EXISTS `jcms_attach_cate`;
CREATE TABLE `jcms_attach_cate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(10) unsigned NOT NULL COMMENT '附件id',
  `text_no` char(13) NOT NULL COMMENT '富文本编号',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for jcms_attach_doc
-- ----------------------------
DROP TABLE IF EXISTS `jcms_attach_doc`;
CREATE TABLE `jcms_attach_doc` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(10) unsigned NOT NULL COMMENT '附件id',
  `text_no` char(13) NOT NULL COMMENT '富文本编号',
  `did` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for jcms_attachment
-- ----------------------------
DROP TABLE IF EXISTS `jcms_attachment`;
CREATE TABLE `jcms_attachment` (
  `aid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL COMMENT '类型: 1.图片 2.文档',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '附件描述',
  `md5` char(32) NOT NULL COMMENT 'md5哈希',
  `ext` varchar(10) NOT NULL COMMENT '扩展名',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '附件大小',
  `refer` int(11) NOT NULL DEFAULT '0' COMMENT '引用次数',
  `time_upload` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `uri` varchar(200) NOT NULL COMMENT '存放路径',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Table structure for jcms_category
-- ----------------------------
DROP TABLE IF EXISTS `jcms_category`;
CREATE TABLE `jcms_category` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `parent_cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父栏目 id, 默认 0, 为根栏目',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '栏目层级',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态: 0.删除 1.正常 2.禁用',
  `nav_show` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '导航栏显示: 0.不显示 1.显示(默认)',
  `nav_sortord` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  `name` varchar(100) NOT NULL COMMENT '栏目名称',
  `path` varchar(50) NOT NULL DEFAULT '' COMMENT '栏目路径',
  `sortord` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `cover_aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面图片 jcms_attachment.aid',
  `description` mediumtext COMMENT '栏目介绍',
  `text_no` char(13) NOT NULL COMMENT '富文本编号',
  `seo_title` varchar(200) NOT NULL DEFAULT '' COMMENT 'seo 标题',
  `seo_keywords` varchar(200) NOT NULL DEFAULT '' COMMENT 'seo 关键字',
  `seo_description` varchar(500) NOT NULL DEFAULT '' COMMENT 'seo 描述',
  `cate_tpl` varchar(50) NOT NULL DEFAULT 'index' COMMENT '列表模板',
  `doc_tpl` varchar(50) NOT NULL DEFAULT 'index' COMMENT '文章模板',
  `time_create` int(10) unsigned NOT NULL COMMENT '创建时间',
  `time_last_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `uid_creator` int(10) unsigned NOT NULL COMMENT '创建者 uid',
  `uid_last_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后编辑者 uid',
  `list_allow` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '允许列表',
  `info_1` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_2` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_3` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_4` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_5` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_6` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='文章栏目';

-- ----------------------------
-- Table structure for jcms_document
-- ----------------------------
DROP TABLE IF EXISTS `jcms_document`;
CREATE TABLE `jcms_document` (
  `did` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `cid` int(10) unsigned NOT NULL COMMENT 'jcms_category.cid, 栏目 id, 0 为单页面',
  `filename` varchar(50) NOT NULL COMMENT '文档 url 结尾文件名',
  `sortord` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态: 0.删除 1.正常 2.禁用',
  `title` varchar(200) NOT NULL COMMENT '文档标题',
  `title_sub` varchar(200) NOT NULL DEFAULT '' COMMENT '文档子标题',
  `cover_aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '封面图片 jcms_attachment.aid',
  `content` mediumtext COMMENT '内容',
  `text_no` char(13) NOT NULL COMMENT '富文本编号',
  `seo_title` varchar(200) NOT NULL COMMENT 'seo 标题',
  `seo_keywords` varchar(200) NOT NULL COMMENT 'seo 关键字',
  `seo_description` varchar(500) NOT NULL COMMENT 'seo 描述',
  `template` varchar(50) NOT NULL DEFAULT '' COMMENT '页面模板',
  `time_document` int(10) unsigned NOT NULL COMMENT '文档时间',
  `time_create` int(10) unsigned NOT NULL COMMENT '创建时间',
  `time_last_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  `uid_creator` int(10) unsigned NOT NULL COMMENT '创建者 uid',
  `uid_last_modify` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后编辑者 uid',
  `hits` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `info_1` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_2` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_3` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_4` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_5` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  `info_6` varchar(500) NOT NULL DEFAULT '' COMMENT '备选信息',
  PRIMARY KEY (`did`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文档内容';

-- ----------------------------
-- Table structure for jcms_group
-- ----------------------------
DROP TABLE IF EXISTS `jcms_group`;
CREATE TABLE `jcms_group` (
  `gid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) NOT NULL COMMENT '群组名称',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '说明',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '状态: 0.删除 1.正常 2.停用',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='群组';

-- ----------------------------
-- Table structure for jcms_group_content
-- ----------------------------
DROP TABLE IF EXISTS `jcms_group_content`;
CREATE TABLE `jcms_group_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `gid` int(10) unsigned NOT NULL COMMENT '群组 id: jcms_group.gid',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(500) NOT NULL DEFAULT '' COMMENT '描述',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接',
  `img` varchar(200) NOT NULL DEFAULT '' COMMENT '图片地址',
  `sortord` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `time` int(10) unsigned NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='群组内容';

-- ----------------------------
-- Table structure for jcms_image
-- ----------------------------
DROP TABLE IF EXISTS `jcms_image`;
CREATE TABLE `jcms_image` (
  `aid` int(10) unsigned NOT NULL COMMENT 'jcms_attachment.aid',
  `width` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '宽',
  `height` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '高',
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图片表';

-- ----------------------------
-- Table structure for jcms_users
-- ----------------------------
DROP TABLE IF EXISTS `jcms_users`;
CREATE TABLE `jcms_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
