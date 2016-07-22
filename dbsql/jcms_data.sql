/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : jcms

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-07-13 17:05:17
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jcms_attach_cate
-- ----------------------------
INSERT INTO `jcms_attach_cate` VALUES ('1', '2', '5784a74dde77d', '1');
INSERT INTO `jcms_attach_cate` VALUES ('3', '3', '5784aa229f869', '6');
INSERT INTO `jcms_attach_cate` VALUES ('4', '1', '5784aa229f869', '6');
INSERT INTO `jcms_attach_cate` VALUES ('5', '4', '5784a85c323ee', '0');
INSERT INTO `jcms_attach_cate` VALUES ('6', '5', '5784ac426a355', '12');
INSERT INTO `jcms_attach_cate` VALUES ('7', '6', '5784ac426a355', '12');
INSERT INTO `jcms_attach_cate` VALUES ('8', '8', '5784add1d583d', '15');
INSERT INTO `jcms_attach_cate` VALUES ('9', '9', '5784add1d583d', '15');
INSERT INTO `jcms_attach_cate` VALUES ('10', '10', '5784add1d583d', '15');
INSERT INTO `jcms_attach_cate` VALUES ('11', '11', '5784add1d583d', '15');
INSERT INTO `jcms_attach_cate` VALUES ('12', '12', '5784add1d583d', '15');
INSERT INTO `jcms_attach_cate` VALUES ('13', '4', '5784a8a70847c', '0');
INSERT INTO `jcms_attach_cate` VALUES ('14', '13', '5784aeafe12e1', '19');
INSERT INTO `jcms_attach_cate` VALUES ('15', '14', '5784aeafe12e1', '19');
INSERT INTO `jcms_attach_cate` VALUES ('16', '15', '5784aeafe12e1', '19');
INSERT INTO `jcms_attach_cate` VALUES ('17', '2', '5784a87b63907', '0');
INSERT INTO `jcms_attach_cate` VALUES ('18', '16', '5785ad2fd8100', '20');
INSERT INTO `jcms_attach_cate` VALUES ('19', '17', '5785ad2fd8100', '20');
INSERT INTO `jcms_attach_cate` VALUES ('20', '18', '5785ad2fd8100', '20');
INSERT INTO `jcms_attach_cate` VALUES ('21', '19', '5785b49de86aa', '21');

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
-- Records of jcms_attach_doc
-- ----------------------------
INSERT INTO `jcms_attach_doc` VALUES ('1', '7', '5785a5f842f9d', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of jcms_attachment
-- ----------------------------
INSERT INTO `jcms_attachment` VALUES ('1', '1', '80d172d770ee0d1fdf074eb74d9c6f.jpeg', '5080d172d770ee0d1fdf074eb74d9c6f', 'jpeg', '6210', '16', '1468314130', '/upload/50/80d172d770ee0d1fdf074eb74d9c6f.jpeg');
INSERT INTO `jcms_attachment` VALUES ('2', '1', '04fae256dce64bd40a9e9ed129474d.jpeg', 'a604fae256dce64bd40a9e9ed129474d', 'jpeg', '118027', '16', '1468314130', '/upload/a6/04fae256dce64bd40a9e9ed129474d.jpeg');
INSERT INTO `jcms_attachment` VALUES ('3', '1', '2830de44ceb4cb7d32d88bc7c77a66.jpeg', '422830de44ceb4cb7d32d88bc7c77a66', 'jpeg', '4381', '15', '1468315293', '/upload/42/2830de44ceb4cb7d32d88bc7c77a66.jpeg');
INSERT INTO `jcms_attachment` VALUES ('4', '1', 'ab1d934864c071009922fb3534f19c.jpeg', '78ab1d934864c071009922fb3534f19c', 'jpeg', '37867', '12', '1468376141', '/upload/78/ab1d934864c071009922fb3534f19c.jpeg');
INSERT INTO `jcms_attachment` VALUES ('5', '1', '33a82f7d6f1c16afc77f9102586597.jpeg', '9033a82f7d6f1c16afc77f9102586597', 'jpeg', '4196', '12', '1468376186', '/upload/90/33a82f7d6f1c16afc77f9102586597.jpeg');
INSERT INTO `jcms_attachment` VALUES ('6', '1', 'bcd1b4c4c9f39cc251bcbfe56178f3.jpeg', 'd0bcd1b4c4c9f39cc251bcbfe56178f3', 'jpeg', '5604', '11', '1468376231', '/upload/d0/bcd1b4c4c9f39cc251bcbfe56178f3.jpeg');
INSERT INTO `jcms_attachment` VALUES ('7', '1', 'eb67c7455cd5fd2b7d72da1c3da7b5.jpeg', 'cdeb67c7455cd5fd2b7d72da1c3da7b5', 'jpeg', '6199', '10', '1468376639', '/upload/cd/eb67c7455cd5fd2b7d72da1c3da7b5.jpeg');
INSERT INTO `jcms_attachment` VALUES ('8', '1', 'ca2c45821f9236e9e29bca9ad8c342.jpeg', 'a9ca2c45821f9236e9e29bca9ad8c342', 'jpeg', '5103', '8', '1468377590', '/upload/a9/ca2c45821f9236e9e29bca9ad8c342.jpeg');
INSERT INTO `jcms_attachment` VALUES ('9', '1', 'e214b68cf999802acf2fb572fe4dd5.jpeg', '4fe214b68cf999802acf2fb572fe4dd5', 'jpeg', '5544', '8', '1468377590', '/upload/4f/e214b68cf999802acf2fb572fe4dd5.jpeg');
INSERT INTO `jcms_attachment` VALUES ('10', '1', '3040534feb312b1fb85e4bf4ea6fc8.jpeg', '073040534feb312b1fb85e4bf4ea6fc8', 'jpeg', '70614', '7', '1468377726', '/upload/07/3040534feb312b1fb85e4bf4ea6fc8.jpeg');
INSERT INTO `jcms_attachment` VALUES ('11', '1', 'afe3c7531c949c86852de16970b56f.jpeg', '1fafe3c7531c949c86852de16970b56f', 'jpeg', '47399', '7', '1468377751', '/upload/1f/afe3c7531c949c86852de16970b56f.jpeg');
INSERT INTO `jcms_attachment` VALUES ('12', '1', 'da0148fa4aa91713d3ac63638f89f4.jpeg', 'f5da0148fa4aa91713d3ac63638f89f4', 'jpeg', '66346', '7', '1468377776', '/upload/f5/da0148fa4aa91713d3ac63638f89f4.jpeg');
INSERT INTO `jcms_attachment` VALUES ('13', '1', '45f6355b9cb85e9e9b43cbe201d577.jpeg', 'a145f6355b9cb85e9e9b43cbe201d577', 'jpeg', '4869', '4', '1468377916', '/upload/a1/45f6355b9cb85e9e9b43cbe201d577.jpeg');
INSERT INTO `jcms_attachment` VALUES ('14', '1', '51ae374e0f83af986bb14c4a82d845.jpeg', '1c51ae374e0f83af986bb14c4a82d845', 'jpeg', '4304', '4', '1468377916', '/upload/1c/51ae374e0f83af986bb14c4a82d845.jpeg');
INSERT INTO `jcms_attachment` VALUES ('15', '1', '54c7aa9a53dfdcfa3b76130c1d43cd.jpeg', '8d54c7aa9a53dfdcfa3b76130c1d43cd', 'jpeg', '86589', '3', '1468377998', '/upload/8d/54c7aa9a53dfdcfa3b76130c1d43cd.jpeg');
INSERT INTO `jcms_attachment` VALUES ('16', '1', '03de31dd02b01193b6d0123547c363.jpeg', '5e03de31dd02b01193b6d0123547c363', 'jpeg', '88835', '2', '1468378472', '/upload/5e/03de31dd02b01193b6d0123547c363.jpeg');
INSERT INTO `jcms_attachment` VALUES ('17', '1', 'dd26911e85de10fc8264b812fddb20.jpeg', '1cdd26911e85de10fc8264b812fddb20', 'jpeg', '192554', '2', '1468378472', '/upload/1c/dd26911e85de10fc8264b812fddb20.jpeg');
INSERT INTO `jcms_attachment` VALUES ('18', '1', 'd33adf37ccc88ea1a7ca94abd8b788.jpeg', 'a2d33adf37ccc88ea1a7ca94abd8b788', 'jpeg', '192264', '2', '1468378472', '/upload/a2/d33adf37ccc88ea1a7ca94abd8b788.jpeg');
INSERT INTO `jcms_attachment` VALUES ('19', '1', 'a688081485ebf3dc05829ce6c133f8.jpeg', '16a688081485ebf3dc05829ce6c133f8', 'jpeg', '3306', '1', '1468380333', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg');

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='文章栏目';

-- ----------------------------
-- Records of jcms_category
-- ----------------------------
INSERT INTO `jcms_category` VALUES ('1', '0', '1', '1', '1', '0', '关于大成', '/category/6', '100', '2', '', '5784a74dde77d', '', '', '', 'index', 'index', '1468311411', '1468315598', '1', '1', '1', '/upload/50/80d172d770ee0d1fdf074eb74d9c6f.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('2', '0', '1', '1', '1', '0', '新闻公告', '/category/12', '90', '4', '', '5784a85c323ee', '', '', '', 'index', 'index', '1468311670', '1468313861', '1', '1', '1', '', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('3', '0', '1', '1', '1', '0', '旗下产品', '/category/15', '80', '2', '', '5784a87b63907', '', '', '', 'index', 'index', '1468311693', '1468313888', '1', '1', '1', '', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('4', '0', '1', '1', '0', '0', '客户服务', '/category/4', '70', '0', '', '5784a88fd0d55', '', '', '', 'index', 'index', '1468311711', '1468313912', '1', '1', '1', '', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('5', '0', '1', '1', '1', '0', '联系我们', '/category/19', '60', '4', '', '5784a8a70847c', '', '', '', 'index', 'index', '1468311731', '1468313922', '1', '1', '1', '', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('6', '1', '2', '1', '1', '0', '公司简介', '0', '100', '0', '<p><span style=\"color: rgb(101, 101, 101); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; line-height: 30px; text-indent: 32px; background-color: rgb(255, 255, 255);\">成立于2010年，是一家致力于为客户提供资产管理服务的专业量化投资机构，其资产管理服务范围包括股票、债券、期货、股权投资以及其他金融衍生品等。目前管理多只量化对冲基金，均获取稳健收益。成立于2010年，是一家致力于为客户提供资产管理服务的专业量化投资机构，其资产管理服务范围包括股票、债券、期货、股权投资以及其他金融衍生品等。目前管理多只量化对冲基金，均获取稳健收益。成立于2010年，是一家致力于为客户提供资产管理服务的专业量化投资机构，其资产管理服务范围包括股票、债券、期货、股权投资以及其他金融衍生品等。目前管理多只量化对冲基金，均获取稳健收益。成立于2010年，是一家致力于为客户提供资产管理服务的专业量化投资机构，其资产管理服务范围包括股票、债券、期货、股权投资以及其他金融衍生品等。目前管理多只量化对冲基金，均获取稳健收益。</span></p>', '5784aa229f869', '', '', '', 'index', 'index', '1468312127', '1468315613', '1', '1', '1', '/upload/50/80d172d770ee0d1fdf074eb74d9c6f.jpeg', '/upload/42/2830de44ceb4cb7d32d88bc7c77a66.jpeg', '专注策略研究，发掘团队价值 · 大成永兴帮您', '', '', '');
INSERT INTO `jcms_category` VALUES ('7', '1', '2', '1', '1', '0', '投资团队', '0', '90', '0', '', '5784aa58d36c8', '', '', '', 'index', 'index', '1468312163', '1468374062', '1', '1', '1', '/upload/50/80d172d770ee0d1fdf074eb74d9c6f.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('8', '1', '2', '1', '1', '0', '董事长致辞', '0', '80', '0', '', '5784aa67a4709', '', '', '', 'index', 'index', '1468312190', '1468374072', '1', '1', '1', '/upload/50/80d172d770ee0d1fdf074eb74d9c6f.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('9', '1', '2', '1', '1', '0', '荣誉资质', '0', '70', '0', '', '5784aa8a3cc5f', '', '', '', 'index', 'index', '1468312216', '1468374081', '1', '1', '1', '/upload/50/80d172d770ee0d1fdf074eb74d9c6f.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('12', '2', '2', '1', '1', '0', '公司新闻', '0', '100', '0', '<p>啊等方式</p>', '5784ac426a355', '', '', '', 'index', 'index', '1468312668', '1468377077', '1', '1', '1', '/upload/d0/bcd1b4c4c9f39cc251bcbfe56178f3.jpeg', '/upload/90/33a82f7d6f1c16afc77f9102586597.jpeg', '为客户创造持续而稳健的回报 · 大成永兴', '', '', '');
INSERT INTO `jcms_category` VALUES ('13', '2', '2', '1', '1', '0', '新闻资讯', '0', '90', '0', '', '5784ac8ed97f9', '', '', '', 'index', 'index', '1468312729', '1468377505', '1', '1', '1', '/upload/d0/bcd1b4c4c9f39cc251bcbfe56178f3.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('14', '2', '2', '1', '1', '0', '公司动态', '0', '80', '0', '', '5784ac9c94b28', '', '', '', 'index', 'index', '1468312742', '1468377513', '1', '1', '1', '/upload/d0/bcd1b4c4c9f39cc251bcbfe56178f3.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('15', '3', '2', '1', '1', '0', '多策略FOF', '0', '100', '0', '<h1 style=\"padding: 0px 0px 0px 12px; margin: 0px; font-size: 16px; color: rgb(247, 72, 45); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; line-height: 36px; white-space: normal; background-color: rgb(255, 255, 255);\">产品净值</h1><p><img src=\"/upload/07/3040534feb312b1fb85e4bf4ea6fc8.jpeg\" title=\"3040534feb312b1fb85e4bf4ea6fc8.jpeg\" alt=\"ny_04.jpg\"/></p><p></p><p><span style=\"color: rgb(86, 82, 83); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; line-height: 36px; background-color: rgb(255, 255, 255);\"></span></p><h1 style=\"padding: 0px 0px 0px 12px; margin: 0px; font-size: 16px; color: rgb(247, 72, 45); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; line-height: 36px; white-space: normal; background-color: rgb(255, 255, 255);\">产品介绍</h1><p><img src=\"/upload/1f/afe3c7531c949c86852de16970b56f.jpeg\" title=\"afe3c7531c949c86852de16970b56f.jpeg\" alt=\"ny_05.jpg\"/></p><p></p><p><span style=\"color: rgb(86, 82, 83); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; line-height: 36px; background-color: rgb(255, 255, 255);\"></span></p><h1 style=\"padding: 0px 0px 0px 12px; margin: 0px; font-size: 16px; color: rgb(247, 72, 45); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; line-height: 36px; white-space: normal; background-color: rgb(255, 255, 255);\">历史净值</h1><p></p><p><img src=\"/upload/f5/da0148fa4aa91713d3ac63638f89f4.jpeg\" title=\"da0148fa4aa91713d3ac63638f89f4.jpeg\" alt=\"ny_06.jpg\"/></p><p></p>', '5784add1d583d', '', '', '', 'index', 'index', '1468313048', '1468377787', '1', '1', '1', '/upload/a9/ca2c45821f9236e9e29bca9ad8c342.jpeg', '/upload/4f/e214b68cf999802acf2fb572fe4dd5.jpeg', '为客户创造持续而稳健的回报 · 大成永兴', '', '', '');
INSERT INTO `jcms_category` VALUES ('16', '3', '2', '1', '1', '0', '股票FOF', '0', '90', '0', '', '5784adecd918a', '', '', '', 'index', 'index', '1468313077', '1468377811', '1', '1', '1', '/upload/a9/ca2c45821f9236e9e29bca9ad8c342.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('17', '3', '2', '1', '1', '0', '相对价值FOF', '0', '80', '0', '', '5784adfe9e73b', '', '', '', 'index', 'index', '1468313095', '1468377819', '1', '1', '1', '/upload/a9/ca2c45821f9236e9e29bca9ad8c342.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('18', '3', '2', '1', '1', '0', '公募FOF', '0', '70', '0', '', '5784ae0f64885', '', '', '', 'index', 'index', '1468313113', '1468377826', '1', '1', '1', '/upload/a9/ca2c45821f9236e9e29bca9ad8c342.jpeg', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('19', '5', '2', '1', '1', '0', '联系方式', '0', '100', '0', '<p><img src=\"/upload/8d/54c7aa9a53dfdcfa3b76130c1d43cd.jpeg\" title=\"54c7aa9a53dfdcfa3b76130c1d43cd.jpeg\" alt=\"ny_11.jpg\"/></p>', '5784aeafe12e1', '', '', '', 'index', 'index', '1468313270', '1468378005', '1', '1', '1', '/upload/a1/45f6355b9cb85e9e9b43cbe201d577.jpeg', '/upload/1c/51ae374e0f83af986bb14c4a82d845.jpeg', '为客户创造持续而稳健的回报 · 大成永兴', '', '', '');
INSERT INTO `jcms_category` VALUES ('20', '0', '1', '1', '0', '0', '轮播图片', '0', '0', '0', '', '5785ad2fd8100', '', '', '', 'index', 'index', '1468378436', '1468380314', '1', '1', '1', '', '', '', '', '', '');
INSERT INTO `jcms_category` VALUES ('21', '0', '1', '1', '0', '0', '友情链接图片', '0', '0', '0', '', '5785b49de86aa', '', '', '', 'index', 'index', '1468380338', '0', '1', '0', '1', '', '', '', '', '', '');

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
-- Records of jcms_document
-- ----------------------------
INSERT INTO `jcms_document` VALUES ('1', '12', '', '0', '1', '公司擅长短线交易，拥有成熟稳健的短线交易策略和模型', '', '7', '<p><span style=\"color: rgb(101, 101, 101); font-family: PingHei, &quot;PingFang SC&quot;, &quot;Helvetica Neue&quot;, Helvetica, STHeitiSC-Light, &quot;Microsoft YaHei&quot;, Arial, sans-serif; font-size: 12px; line-height: 30px; background-color: rgb(255, 255, 255);\">具有16年的从业背景，精通证券业务，IT技术，证券资产。拥有成熟稳健的短线交易策略和模型，专注做热门题材类龙头股票，果断介入获取股票主升带来的高额收益</span></p>', '5785a5f842f9d', '', '', '具有16年的从业背景，精通证券业务，IT技术，证券资产。拥有成熟稳健的短线交易策略和模型，专注做热门题材类龙头股票，果断介入获取股票主升带来的高额收益', 'index', '1468368000', '0', '1468377087', '1', '1', '0', '', '', '', '', '', '');

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
-- Records of jcms_group
-- ----------------------------
INSERT INTO `jcms_group` VALUES ('1', '首页图片轮播', '首页图片轮播', '1');
INSERT INTO `jcms_group` VALUES ('2', '首页新闻公告', '首页新闻公告', '1');
INSERT INTO `jcms_group` VALUES ('3', '首页友情链接', '首页友情链接', '1');

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
-- Records of jcms_group_content
-- ----------------------------
INSERT INTO `jcms_group_content` VALUES ('1', '1', '图片1', '', '', '/upload/1c/dd26911e85de10fc8264b812fddb20.jpeg', '2', '0');
INSERT INTO `jcms_group_content` VALUES ('3', '3', '友情链接1', '', '', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg', '0', '0');
INSERT INTO `jcms_group_content` VALUES ('6', '3', '友情链接2', '', '', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg', '0', '0');
INSERT INTO `jcms_group_content` VALUES ('7', '3', '友情链接3', '', '', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg', '0', '0');
INSERT INTO `jcms_group_content` VALUES ('8', '3', '友情链接4', '', '', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg', '0', '0');
INSERT INTO `jcms_group_content` VALUES ('9', '3', '友情链接5', '', '', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg', '0', '0');
INSERT INTO `jcms_group_content` VALUES ('10', '3', '友情链接6', '', '', '/upload/16/a688081485ebf3dc05829ce6c133f8.jpeg', '0', '0');
INSERT INTO `jcms_group_content` VALUES ('11', '2', '公司擅长短线交易，拥有成熟稳健的短线交易策略和模型', '具有16年的从业背景，精通证券业务，IT技术，证券资产。拥有成熟稳健的短线交易策略和模型，专注做热门题材类龙头股票，果断介入获取股票主升带来的高额收益', '/.html', '/upload/cd/eb67c7455cd5fd2b7d72da1c3da7b5.jpeg', '0', '1468368000');
INSERT INTO `jcms_group_content` VALUES ('12', '2', '公司擅长短线交易，拥有成熟稳健的短线交易策略和模型', '具有16年的从业背景，精通证券业务，IT技术，证券资产。拥有成熟稳健的短线交易策略和模型，专注做热门题材类龙头股票，果断介入获取股票主升带来的高额收益', '/.html', '/upload/cd/eb67c7455cd5fd2b7d72da1c3da7b5.jpeg', '0', '1468368000');
INSERT INTO `jcms_group_content` VALUES ('13', '2', '公司擅长短线交易，拥有成熟稳健的短线交易策略和模型', '具有16年的从业背景，精通证券业务，IT技术，证券资产。拥有成熟稳健的短线交易策略和模型，专注做热门题材类龙头股票，果断介入获取股票主升带来的高额收益', '/.html', '/upload/cd/eb67c7455cd5fd2b7d72da1c3da7b5.jpeg', '0', '1468368000');
INSERT INTO `jcms_group_content` VALUES ('14', '1', '图片2', '', '', '/upload/5e/03de31dd02b01193b6d0123547c363.jpeg', '3', '0');
INSERT INTO `jcms_group_content` VALUES ('15', '1', '图片3', '', '', '/upload/a2/d33adf37ccc88ea1a7ca94abd8b788.jpeg', '1', '0');

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
-- Records of jcms_image
-- ----------------------------
INSERT INTO `jcms_image` VALUES ('1', '205', '78');
INSERT INTO `jcms_image` VALUES ('2', '1920', '216');
INSERT INTO `jcms_image` VALUES ('3', '146', '44');
INSERT INTO `jcms_image` VALUES ('4', '1920', '216');
INSERT INTO `jcms_image` VALUES ('5', '146', '46');
INSERT INTO `jcms_image` VALUES ('6', '205', '78');
INSERT INTO `jcms_image` VALUES ('7', '184', '138');
INSERT INTO `jcms_image` VALUES ('8', '205', '78');
INSERT INTO `jcms_image` VALUES ('9', '187', '46');
INSERT INTO `jcms_image` VALUES ('10', '660', '660');
INSERT INTO `jcms_image` VALUES ('11', '850', '410');
INSERT INTO `jcms_image` VALUES ('12', '850', '680');
INSERT INTO `jcms_image` VALUES ('13', '205', '78');
INSERT INTO `jcms_image` VALUES ('14', '122', '44');
INSERT INTO `jcms_image` VALUES ('15', '884', '554');
INSERT INTO `jcms_image` VALUES ('16', '1920', '498');
INSERT INTO `jcms_image` VALUES ('17', '1920', '498');
INSERT INTO `jcms_image` VALUES ('18', '1920', '498');
INSERT INTO `jcms_image` VALUES ('19', '166', '84');

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

-- ----------------------------
-- Records of jcms_users
-- ----------------------------
INSERT INTO `jcms_users` VALUES ('1', 'admin', '$2y$10$BNYhQnWaBbeRdryyPoSo7ew5a46PYt5yubQpOXQBBLAfqLDWbo/cW', '0drO0N6XGK8KowsMQeNb67a7l8j3zJwvqjWwXibXbZxJlrciWBmGU3fWEIu1', null, '2016-07-12 08:10:02');
