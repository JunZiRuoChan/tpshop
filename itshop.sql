/*
Navicat MySQL Data Transfer

Source Server         : study
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : itshop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-12-14 14:26:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sp_attribute
-- ----------------------------
DROP TABLE IF EXISTS `sp_attribute`;
CREATE TABLE `sp_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `attr_name` varchar(32) NOT NULL COMMENT '属性名称',
  `type_id` smallint(5) unsigned NOT NULL COMMENT '外键，类型id',
  `attr_sel` enum('only','many') NOT NULL DEFAULT 'only' COMMENT 'only:输入框(唯一)  many:后台下拉列表/前台单选框',
  `attr_write` enum('manual','list') NOT NULL DEFAULT 'manual' COMMENT 'manual:手工录入  list:从列表选择',
  `attr_vals` varchar(256) NOT NULL DEFAULT '' COMMENT '可选值列表信息,例如颜色：白色,红色,绿色,多个可选值通过逗号分隔',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='属性表';

-- ----------------------------
-- Records of sp_attribute
-- ----------------------------
INSERT INTO `sp_attribute` VALUES ('1', '型号', '1', 'many', 'manual', 'honor8');

-- ----------------------------
-- Table structure for sp_auth
-- ----------------------------
DROP TABLE IF EXISTS `sp_auth`;
CREATE TABLE `sp_auth` (
  `auth_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `auth_name` varchar(20) NOT NULL COMMENT '权限名称',
  `auth_pid` smallint(6) unsigned NOT NULL COMMENT '父id',
  `auth_c` varchar(32) NOT NULL DEFAULT '' COMMENT '控制器',
  `auth_a` varchar(32) NOT NULL DEFAULT '' COMMENT '操作方法',
  `auth_level` enum('0','1') NOT NULL DEFAULT '0' COMMENT '权限等级',
  PRIMARY KEY (`auth_id`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of sp_auth
-- ----------------------------
INSERT INTO `sp_auth` VALUES ('101', '商品管理', '0', '', '', '0');
INSERT INTO `sp_auth` VALUES ('102', '订单管理', '0', '', '', '0');
INSERT INTO `sp_auth` VALUES ('103', '权限管理', '0', '', '', '0');
INSERT INTO `sp_auth` VALUES ('104', '商品列表', '101', 'Goods', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('105', '添加商品', '101', 'Goods', 'addGoods', '1');
INSERT INTO `sp_auth` VALUES ('106', '商品分类', '101', 'Category', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('107', '订单列表', '102', 'Order', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('108', '订单打印', '102', 'Order', 'dayin', '1');
INSERT INTO `sp_auth` VALUES ('109', '添加订单', '102', 'Order', 'tianjia', '1');
INSERT INTO `sp_auth` VALUES ('110', '管理员列表', '103', 'Manager', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('111', '角色列表', '103', 'Role', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('112', '权限列表', '103', 'Auth', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('114', '菜单管理', '102', 'auth', 'upd', '1');
INSERT INTO `sp_auth` VALUES ('115', '商品类型', '101', 'Type', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('116', '会员管理', '0', '', '', '0');
INSERT INTO `sp_auth` VALUES ('117', '会员信息', '116', 'Member', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('119', '会员级别列表', '116', 'Member', 'memberLevelList', '1');
INSERT INTO `sp_auth` VALUES ('120', '会员级别修改', '116', 'member', 'updMemberlevel', '1');
INSERT INTO `sp_auth` VALUES ('121', '会员级别添加', '116', 'member', 'addMemberLevel', '1');
INSERT INTO `sp_auth` VALUES ('123', '邮件推广', '0', '', '', '0');
INSERT INTO `sp_auth` VALUES ('124', '推广列表', '123', 'Email', 'showlist', '1');
INSERT INTO `sp_auth` VALUES ('125', '推广信息', '123', 'Email', 'gettuiguang', '1');

-- ----------------------------
-- Table structure for sp_backage
-- ----------------------------
DROP TABLE IF EXISTS `sp_backage`;
CREATE TABLE `sp_backage` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单',
  `backage_state` text NOT NULL COMMENT '快递信息',
  `backage_number` varchar(32) NOT NULL COMMENT '运单号',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='包裹快递';

-- ----------------------------
-- Records of sp_backage
-- ----------------------------

-- ----------------------------
-- Table structure for sp_cart
-- ----------------------------
DROP TABLE IF EXISTS `sp_cart`;
CREATE TABLE `sp_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '0' COMMENT '''0''代表正常，''1''代表清除',
  `goods_num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sp_cart
-- ----------------------------
INSERT INTO `sp_cart` VALUES ('69', '236', '13', '0', '1');
INSERT INTO `sp_cart` VALUES ('68', '236', '13', '0', '1');
INSERT INTO `sp_cart` VALUES ('66', '236', '12', '0', '1');
INSERT INTO `sp_cart` VALUES ('64', '236', '12', '0', '1');

-- ----------------------------
-- Table structure for sp_consignee
-- ----------------------------
DROP TABLE IF EXISTS `sp_consignee`;
CREATE TABLE `sp_consignee` (
  `cgn_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` int(11) NOT NULL COMMENT '会员id',
  `cgn_name` varchar(32) NOT NULL COMMENT '收货人名称',
  `cgn_address` varchar(200) NOT NULL DEFAULT '' COMMENT '收货人地址',
  `cgn_tel` varchar(20) NOT NULL DEFAULT '' COMMENT '收货人电话',
  `cgn_code` char(6) NOT NULL DEFAULT '' COMMENT '邮编',
  PRIMARY KEY (`cgn_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='收货人表';

-- ----------------------------
-- Records of sp_consignee
-- ----------------------------
INSERT INTO `sp_consignee` VALUES ('1', '133', '王二柱', '北京市海淀区苏州街长远天地大厦305室', '13566771298', '306810');
INSERT INTO `sp_consignee` VALUES ('2', '133', '铁锤', '北京市海淀区西北旺用友大厦777室', '13126537865', '600981');
INSERT INTO `sp_consignee` VALUES ('3', '224', '鸭蛋', '北京市海淀区西三旗建材城西路中腾大厦15室', '18902564321', '600214');
INSERT INTO `sp_consignee` VALUES ('4', '224', '赵大海', '北京市海淀区中关村大街太平洋大厦801室', '15765329087', '600983');
INSERT INTO `sp_consignee` VALUES ('5', '226', '变形金刚', '北京市海淀区人大西门和平小区2#4门', '15028374375', '600912');
INSERT INTO `sp_consignee` VALUES ('6', '226', '葫芦娃', '北京市海淀区软件园软件大厦10室', '18679871209', '600011');

-- ----------------------------
-- Table structure for sp_email
-- ----------------------------
DROP TABLE IF EXISTS `sp_email`;
CREATE TABLE `sp_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `email_url` varchar(255) NOT NULL DEFAULT '' COMMENT '推广链接',
  `email_intro` varchar(255) NOT NULL DEFAULT '' COMMENT '推广链接介绍',
  `email_info` text NOT NULL,
  `email_nums` int(255) NOT NULL COMMENT '推广数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sp_email
-- ----------------------------
INSERT INTO `sp_email` VALUES ('3', 'www.baidu.com', '百度一下，你就知道', '&lt;p&gt;这是一&lt;strong&gt;个神奇的网站&lt;/strong&gt;&lt;/p&gt;', '7');
INSERT INTO `sp_email` VALUES ('4', 'www.taobao.com', '淘宝商城', '&lt;p&gt;&lt;strong&gt;万恶之源！！！&lt;/strong&gt;&lt;/p&gt;', '2');
INSERT INTO `sp_email` VALUES ('5', 'www.google.com', '谷歌', '&lt;p&gt;&lt;em&gt;&lt;strong&gt;最优秀&lt;/strong&gt;&lt;/em&gt;的搜索引擎之一&lt;/p&gt;', '8');
INSERT INTO `sp_email` VALUES ('6', 'www.jindong.com', '京东', '33333', '8');

-- ----------------------------
-- Table structure for sp_goods
-- ----------------------------
DROP TABLE IF EXISTS `sp_goods`;
CREATE TABLE `sp_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_name` varchar(128) NOT NULL COMMENT '商品名称',
  `goods_members_price` text NOT NULL COMMENT '本店促销价',
  `goods_tem_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_number` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `goods_weight` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品重量',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '����id',
  `goods_introduce` text COMMENT '商品详情介绍',
  `goods_big_logo` char(128) NOT NULL DEFAULT '' COMMENT '图片logo大图',
  `goods_small_logo` char(128) NOT NULL DEFAULT '' COMMENT '图片logo小图',
  `is_del` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0:正常  1:删除',
  `add_time` int(11) NOT NULL COMMENT '添加商品时间',
  `upd_time` int(11) NOT NULL COMMENT '修改商品时间',
  `goods_member_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '本店促销价',
  PRIMARY KEY (`goods_id`),
  UNIQUE KEY `goods_name` (`goods_name`),
  KEY `goods_price` (`goods_price`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of sp_goods
-- ----------------------------
INSERT INTO `sp_goods` VALUES ('10', '华为荣耀8', '{\"21\":{\"id\":21,\"member_price\":2290,\"flag\":\"1\",\"level_name\":\"\\u521d\\u7ea7\\u4f1a\\u5458\",\"level_rate\":\"98\"}}', '2300.00', '2303.00', '255', '2222', '1', '好用', './Public/Uploads/logo/2017-07-12/59658aff283a4.png', './Public/Uploads/logo/2017-07-12/small_59658aff283a4.png', '0', '1499826943', '1499864980', '0.00');
INSERT INTO `sp_goods` VALUES ('11', '小米5', '{\"21\":{\"id\":21,\"member_price\":3100,\"flag\":\"1\",\"level_name\":\"\\u521d\\u7ea7\\u4f1a\\u5458\",\"level_rate\":\"98\"},\"22\":{\"id\":22,\"member_price\":3290,\"flag\":\"1\",\"level_name\":\"\\u4e2d\\u7ea7\\u4f1a\\u5458\",\"level_rate\":\"96\"},\"23\":{\"id\":23,\"member_price\":3250,\"flag\":\"1\",\"level_name\":\"\\u9ad8\\u7ea7\\u4f1a\\u5458\",\"level_rate\":\"94\"},\"24\":{\"id\":24,\"member_price\":3200,\"flag\":\"1\",\"level_name\":\"\\u81f3\\u5c0a\\u4f1a\\u5458\",\"level_rate\":\"90\"}}', '3300.00', '3333.00', '222', '2222', '1', '为发烧而生、、、、、', './Public/Uploads/logo/2017-07-12/59661f3f2dff8.jpg', './Public/Uploads/logo/2017-07-12/small_59661f3f2dff8.jpg', '0', '1499864895', '1499925912', '0.00');
INSERT INTO `sp_goods` VALUES ('12', '小米6', '2299', '0.00', '2499.00', '100', '50', '1', '&lt;p&gt;&lt;span style=\"color: rgb(176, 176, 176); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Hiragino Sans GB&amp;quot;, &amp;quot;Heiti SC&amp;quot;, &amp;quot;WenQuanYi Micro Hei&amp;quot;, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\"&gt;变焦双摄，4 轴防抖 / 骁龙835 旗舰处理器，6GB 大内存，最大可选128GB 闪存 / 5.15&amp;quot; 护眼屏 / 四曲面玻璃/陶瓷机身&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=\"color: rgb(176, 176, 176); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Hiragino Sans GB&amp;quot;, &amp;quot;Heiti SC&amp;quot;, &amp;quot;WenQuanYi Micro Hei&amp;quot;, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\"&gt;&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=\"/ueditor/php/upload/image/20170824/1503504056.jpg\" style=\"\" title=\"1503504056.jpg\"/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=\"/ueditor/php/upload/image/20170824/1503504057.jpg\" style=\"\" title=\"1503504057.jpg\"/&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=\"color: rgb(176, 176, 176); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, &amp;quot;Microsoft Yahei&amp;quot;, &amp;quot;Hiragino Sans GB&amp;quot;, &amp;quot;Heiti SC&amp;quot;, &amp;quot;WenQuanYi Micro Hei&amp;quot;, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\"&gt;&lt;br/&gt;&lt;/span&gt;&lt;br/&gt;&lt;/p&gt;', './Public/Uploads/logo/2017-08-24/599da6d214a4e.jpg', './Public/Uploads/logo/2017-08-24/small_599da6d214a4e.jpg', '0', '1503504082', '1503504082', '0.00');
INSERT INTO `sp_goods` VALUES ('13', '米66', '', '0.00', '123.00', '10', '111', '1', '&lt;p&gt;还行&lt;br/&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/ueditor/php/upload/image/20170826/1503741368.jpg&quot; title=&quot;1503741368.jpg&quot; alt=&quot;2.jpg&quot;/&gt;&lt;/p&gt;', './Public/Uploads/logo/2017-08-26/59a145c4b170e.jpg', './Public/Uploads/logo/2017-08-26/small_59a145c4b170e.jpg', '0', '1503741380', '1503741380', '0.00');
INSERT INTO `sp_goods` VALUES ('14', '小米666', '', '0.00', '1234.00', '10', '12', '1', '&lt;p&gt;很好用&lt;/p&gt;', './Public/Uploads/logo/2017-08-26/59a14eecb229c.jpg', './Public/Uploads/logo/2017-08-26/small_59a14eecb229c.jpg', '0', '1503743724', '1503743724', '0.00');
INSERT INTO `sp_goods` VALUES ('15', '小米6666', '', '0.00', '1111.00', '10', '10', '1', '&lt;p&gt;便宜好用&lt;/p&gt;&lt;p&gt;&lt;img src=\"/ueditor/php/upload/image/20170827/1503763634.jpg\" title=\"1503763634.jpg\" alt=\"1.jpg\"/&gt;&lt;/p&gt;', './Public/Uploads/logo/2017-08-27/59a19cc205190.jpg', './Public/Uploads/logo/2017-08-27/small_59a19cc205190.jpg', '0', '1503763650', '1503763650', '0.00');

-- ----------------------------
-- Table structure for sp_goods_attr
-- ----------------------------
DROP TABLE IF EXISTS `sp_goods_attr`;
CREATE TABLE `sp_goods_attr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '����id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '��Ʒid',
  `attr_id` smallint(5) unsigned NOT NULL COMMENT '����id',
  `attr_value` varchar(32) NOT NULL COMMENT '��Ʒ��Ӧ���Ե�ֵ',
  PRIMARY KEY (`id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='��Ʒ-���Թ�����';

-- ----------------------------
-- Records of sp_goods_attr
-- ----------------------------
INSERT INTO `sp_goods_attr` VALUES ('17', '10', '1', 'honor8');
INSERT INTO `sp_goods_attr` VALUES ('18', '13', '1', 'honor8');

-- ----------------------------
-- Table structure for sp_goods_pics
-- ----------------------------
DROP TABLE IF EXISTS `sp_goods_pics`;
CREATE TABLE `sp_goods_pics` (
  `pics_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `pics_big` char(128) NOT NULL DEFAULT '' COMMENT '相册大图800*800',
  `pics_mid` char(128) NOT NULL DEFAULT '' COMMENT '相册中图350*350',
  `pics_sma` char(128) NOT NULL DEFAULT '' COMMENT '相册小图50*50',
  PRIMARY KEY (`pics_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='商品-相册关联表';

-- ----------------------------
-- Records of sp_goods_pics
-- ----------------------------
INSERT INTO `sp_goods_pics` VALUES ('25', '74', './Public/Uploads/pics/2017-07-11/big_5964d573001ed.jpg', './Public/Uploads/pics/2017-07-11/mid_5964d573001ed.jpg', './Public/Uploads/pics/2017-07-11/small_5964d573001ed.jpg');
INSERT INTO `sp_goods_pics` VALUES ('26', '1', './Public/Uploads/pics/2017-07-12/big_59656e5018ddd.png', './Public/Uploads/pics/2017-07-12/mid_59656e5018ddd.png', './Public/Uploads/pics/2017-07-12/small_59656e5018ddd.png');
INSERT INTO `sp_goods_pics` VALUES ('27', '3', './Public/Uploads/pics/2017-07-12/big_59657a0e7829e.png', './Public/Uploads/pics/2017-07-12/mid_59657a0e7829e.png', './Public/Uploads/pics/2017-07-12/small_59657a0e7829e.png');
INSERT INTO `sp_goods_pics` VALUES ('28', '4', './Public/Uploads/pics/2017-07-12/big_59657b7e0bb2d.png', './Public/Uploads/pics/2017-07-12/mid_59657b7e0bb2d.png', './Public/Uploads/pics/2017-07-12/small_59657b7e0bb2d.png');
INSERT INTO `sp_goods_pics` VALUES ('29', '5', './Public/Uploads/pics/2017-07-12/big_59657fa529ee1.png', './Public/Uploads/pics/2017-07-12/mid_59657fa529ee1.png', './Public/Uploads/pics/2017-07-12/small_59657fa529ee1.png');
INSERT INTO `sp_goods_pics` VALUES ('30', '6', './Public/Uploads/pics/2017-07-12/big_5965801eafa55.png', './Public/Uploads/pics/2017-07-12/mid_5965801eafa55.png', './Public/Uploads/pics/2017-07-12/small_5965801eafa55.png');
INSERT INTO `sp_goods_pics` VALUES ('31', '8', './Public/Uploads/pics/2017-07-12/big_5965827cca311.png', './Public/Uploads/pics/2017-07-12/mid_5965827cca311.png', './Public/Uploads/pics/2017-07-12/small_5965827cca311.png');
INSERT INTO `sp_goods_pics` VALUES ('32', '11', './Public/Uploads/pics/2017-07-12/big_59661f406af69.jpg', './Public/Uploads/pics/2017-07-12/mid_59661f406af69.jpg', './Public/Uploads/pics/2017-07-12/small_59661f406af69.jpg');
INSERT INTO `sp_goods_pics` VALUES ('33', '12', './Public/Uploads/pics2017-08-24/big_599da6d281831.jpg', './Public/Uploads/pics2017-08-24/mid_599da6d281831.jpg', '2017-08-24/sma_599da6d281831.jpg');
INSERT INTO `sp_goods_pics` VALUES ('34', '13', './Public/Uploads/pics2017-08-26/big_59a145c5016e6.jpg', './Public/Uploads/pics2017-08-26/mid_59a145c5016e6.jpg', '2017-08-26/sma_59a145c5016e6.jpg');
INSERT INTO `sp_goods_pics` VALUES ('35', '14', './Public/Uploads/pics2017-08-26/big_59a14eecea31e.jpg', './Public/Uploads/pics2017-08-26/mid_59a14eecea31e.jpg', '2017-08-26/sma_59a14eecea31e.jpg');
INSERT INTO `sp_goods_pics` VALUES ('36', '15', './Public/Uploads/pics2017-08-27/big_59a19cc241908.jpg', './Public/Uploads/pics2017-08-27/mid_59a19cc241908.jpg', '2017-08-27/sma_59a19cc241908.jpg');

-- ----------------------------
-- Table structure for sp_manager
-- ----------------------------
DROP TABLE IF EXISTS `sp_manager`;
CREATE TABLE `sp_manager` (
  `mg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `mg_name` varchar(32) NOT NULL COMMENT '名称',
  `mg_pwd` varchar(32) NOT NULL COMMENT '密码',
  `mg_time` int(10) unsigned NOT NULL COMMENT '注册时间',
  `role_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '角色id',
  PRIMARY KEY (`mg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=503 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of sp_manager
-- ----------------------------
INSERT INTO `sp_manager` VALUES ('500', 'linken', 'e10adc3949ba59abbe56e057f20f883e', '1499089896', '30');
INSERT INTO `sp_manager` VALUES ('501', 'tom', 'e10adc3949ba59abbe56e057f20f883e', '1499089896', '31');
INSERT INTO `sp_manager` VALUES ('502', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1499089897', '0');

-- ----------------------------
-- Table structure for sp_member_level
-- ----------------------------
DROP TABLE IF EXISTS `sp_member_level`;
CREATE TABLE `sp_member_level` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `level_rate` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '折扣率，100=10折 98=9.8折 90=9折，用时除100',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  `flag` int(1) NOT NULL DEFAULT '1' COMMENT '1正常 0删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='会员级别';

-- ----------------------------
-- Records of sp_member_level
-- ----------------------------
INSERT INTO `sp_member_level` VALUES ('23', '高级会员', '94', '4001', '8000', '1');
INSERT INTO `sp_member_level` VALUES ('21', '初级会员', '98', '0', '2000', '1');
INSERT INTO `sp_member_level` VALUES ('22', '中级会员', '96', '2001', '4000', '1');
INSERT INTO `sp_member_level` VALUES ('24', '至尊会员', '90', '8001', '150000', '1');

-- ----------------------------
-- Table structure for sp_member_price
-- ----------------------------
DROP TABLE IF EXISTS `sp_member_price`;
CREATE TABLE `sp_member_price` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '鍟嗗搧id',
  `level_id` tinyint(3) unsigned NOT NULL COMMENT '绾у埆id',
  `price` decimal(10,2) NOT NULL COMMENT '浠锋牸',
  KEY `goods_id` (`goods_id`),
  KEY `level_id` (`level_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='浼氬憳浠锋牸';

-- ----------------------------
-- Records of sp_member_price
-- ----------------------------

-- ----------------------------
-- Table structure for sp_order
-- ----------------------------
DROP TABLE IF EXISTS `sp_order`;
CREATE TABLE `sp_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `user_id` mediumint(8) unsigned NOT NULL COMMENT '下订单会员id',
  `order_number` varchar(32) NOT NULL COMMENT '订单编号',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `order_pay` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '支付方式 0支付宝 1微信  2银行卡',
  `is_send` enum('是','否') NOT NULL DEFAULT '否' COMMENT '订单是否已经发货',
  `order_fapiao_title` enum('0','1') NOT NULL DEFAULT '0' COMMENT '发票抬头 0个人 1公司',
  `order_fapiao_company` varchar(32) NOT NULL DEFAULT '' COMMENT '公司名称',
  `order_fapiao_content` varchar(32) NOT NULL DEFAULT '' COMMENT '发票内容',
  `cgn_id` int(10) unsigned NOT NULL COMMENT 'consignee收货人地址-外键',
  `order_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '订单状态： 0未付款、1已付款',
  `add_time` int(10) unsigned NOT NULL COMMENT '记录生成时间',
  `upd_time` int(10) unsigned NOT NULL COMMENT '记录修改时间',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `cgn_id` (`cgn_id`),
  KEY `add_time` (`add_time`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of sp_order
-- ----------------------------
INSERT INTO `sp_order` VALUES ('17', '133', 'itcast-shop-20170715155020-7112', '20890.00', '0', '否', '0', '', '明细', '6', '0', '1500105020', '1500105020');
INSERT INTO `sp_order` VALUES ('18', '233', 'itcast-shop-20170715155749-1195', '3100.00', '0', '否', '0', 'ttttt', '明细', '6', '0', '1500105469', '1500105469');
INSERT INTO `sp_order` VALUES ('19', '234', 'itcast-shop-20170716084104-9142', '3100.00', '0', '否', '0', '', '明细', '6', '0', '1500165664', '1500165664');
INSERT INTO `sp_order` VALUES ('20', '234', 'itcast-shop-20170716084747-2067', '6870.00', '0', '否', '0', '', '明细', '6', '0', '1500166067', '1500166067');

-- ----------------------------
-- Table structure for sp_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `sp_order_goods`;
CREATE TABLE `sp_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `order_id` int(10) unsigned NOT NULL COMMENT '订单id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品id',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_number` tinyint(4) NOT NULL DEFAULT '1' COMMENT '购买单个商品数量',
  `goods_total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品小计价格',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='商品订单关联表';

-- ----------------------------
-- Records of sp_order_goods
-- ----------------------------
INSERT INTO `sp_order_goods` VALUES ('18', '17', '11', '0.00', '6', '18600.00');
INSERT INTO `sp_order_goods` VALUES ('19', '17', '10', '0.00', '1', '2290.00');
INSERT INTO `sp_order_goods` VALUES ('20', '18', '11', '0.00', '1', '3100.00');
INSERT INTO `sp_order_goods` VALUES ('21', '19', '11', '0.00', '1', '3100.00');
INSERT INTO `sp_order_goods` VALUES ('22', '20', '10', '0.00', '3', '6870.00');

-- ----------------------------
-- Table structure for sp_role
-- ----------------------------
DROP TABLE IF EXISTS `sp_role`;
CREATE TABLE `sp_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL COMMENT '角色名称',
  `role_auth_ids` varchar(128) NOT NULL DEFAULT '' COMMENT '权限ids,1,2,5',
  `role_auth_ac` text COMMENT '控制器-操作,控制器-操作,控制器-操作',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sp_role
-- ----------------------------
INSERT INTO `sp_role` VALUES ('30', '主管', '104,107,109,110,112', 'Goods-showlist,Order-showlist,Order-tianjia,Manager-showlist,Auth-showlist');
INSERT INTO `sp_role` VALUES ('31', '经理', '101,104,105,106,102,107,109', 'Goods-showlist,Goods-tianjia,Category-showlist,Order-showlist,Order-tianjia');

-- ----------------------------
-- Table structure for sp_type
-- ----------------------------
DROP TABLE IF EXISTS `sp_type`;
CREATE TABLE `sp_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type_name` varchar(32) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='类型表';

-- ----------------------------
-- Records of sp_type
-- ----------------------------
INSERT INTO `sp_type` VALUES ('1', '精品手机');
INSERT INTO `sp_type` VALUES ('2', '书');
INSERT INTO `sp_type` VALUES ('3', '电脑');
INSERT INTO `sp_type` VALUES ('4', '电影');
INSERT INTO `sp_type` VALUES ('5', '笔记本');
INSERT INTO `sp_type` VALUES ('6', '连环画');
INSERT INTO `sp_type` VALUES ('7', '音乐');
INSERT INTO `sp_type` VALUES ('8', '美食');

-- ----------------------------
-- Table structure for sp_user
-- ----------------------------
DROP TABLE IF EXISTS `sp_user`;
CREATE TABLE `sp_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `username` varchar(128) NOT NULL DEFAULT '' COMMENT '登录名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `user_email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `wp_id` int(11) NOT NULL,
  `openid` varchar(128) NOT NULL DEFAULT '',
  `is_active` enum('1','0') NOT NULL DEFAULT '0' COMMENT '0表示未激活，1表示已激活',
  `active_code` char(15) NOT NULL DEFAULT '' COMMENT '激活校验码',
  `user_sex` enum('1','2','3') NOT NULL DEFAULT '3' COMMENT '性别：1代表女；2代表男；3代表保密',
  `user_qq` varchar(32) NOT NULL DEFAULT '' COMMENT 'qq',
  `user_tel` varchar(32) NOT NULL DEFAULT '' COMMENT '手机',
  `user_xueli` tinyint(4) NOT NULL DEFAULT '1' COMMENT '学历',
  `user_hobby` varchar(32) NOT NULL DEFAULT '' COMMENT '爱好',
  `user_introduce` text COMMENT '简介',
  `user_time` int(11) DEFAULT NULL,
  `last_time` int(11) NOT NULL DEFAULT '0',
  `user_status` enum('0','1','2','3') NOT NULL DEFAULT '1' COMMENT '1代表正常状态，2代表暂时冻结，3代表永久冻结，0代表删除',
  `frozen_time` bigint(20) unsigned DEFAULT NULL,
  `jifen` int(11) NOT NULL COMMENT '用户积分',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of sp_user
-- ----------------------------
INSERT INTO `sp_user` VALUES ('133', 'jack', 'e10adc3949ba59abbe56e057f20f883e', '1776243356@qq.com', '0', '0', '1', 'b8ec904efe97eda', '3', '1234987', '17681338214', '0', '', null, '1500031419', '1500031419', '1', '0', '0');
INSERT INTO `sp_user` VALUES ('224', 'jim', 'e10adc3949ba59abbe56e057f20f883e', 'jim@163.com', '0', '0', '0', '', '3', '2233454', '', '0', '', null, null, '0', '1', null, '0');
INSERT INTO `sp_user` VALUES ('226', 'bier', 'e10adc3949ba59abbe56e057f20f883e', 'bier@sohu.com', '0', '0', '0', '', '3', '224234324', '', '0', '', null, null, '0', '1', null, '0');
INSERT INTO `sp_user` VALUES ('227', 'aobama', 'e10adc3949ba59abbe56e057f20f883e', 'aobama@sohu.com', '0', '0', '0', '', '3', '8276382638', '', '0', '', null, null, '0', '1', '0', '0');
INSERT INTO `sp_user` VALUES ('228', 'trump', 'e10adc3949ba59abbe56e057f20f883e', 'trump@163.com', '0', '0', '0', '', '3', '23628322', '', '0', '', null, null, '0', '1', '0', '0');
INSERT INTO `sp_user` VALUES ('230', '邓明君', 'e10adc3949ba59abbe56e057f20f883e', '23434@qq.com', '0', '0', '0', '', '3', '', '', '1', '', null, null, '0', '3', '0', '0');
INSERT INTO `sp_user` VALUES ('231', 'lucy', 'e10adc3949ba59abbe56e057f20f883e', '223454@qq.com', '0', '0', '0', '', '3', '', '17681338214', '1', '', null, '1500013390', '1500013390', '1', null, '0');
INSERT INTO `sp_user` VALUES ('233', 'zhangs', 'e10adc3949ba59abbe56e057f20f883e', '1776243356@qq.com', '0', '0', '1', 'ea09fc9bdbe6533', '3', '', '17681338214', '1', '', null, '1500019159', '1500019159', '1', null, '0');
INSERT INTO `sp_user` VALUES ('234', '归海俩刀', '', '22333@163.com', '-1124867872', '', '1', '', '3', '', '', '1', '', null, '1500122166', '1500122166', '1', null, '0');
INSERT INTO `sp_user` VALUES ('235', '', '202cb962ac59075b964b07152d234b70', '2718826308@qq.com', '0', '', '', '', '3', '', '', '1', '', null, null, '0', '1', null, '0');
INSERT INTO `sp_user` VALUES ('236', '', '202cb962ac59075b964b07152d234b70', '', '0', '', '', '', '3', '', '15228876285', '1', '', null, null, '0', '1', null, '0');
