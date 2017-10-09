/*
Navicat MariaDB Data Transfer

Source Server         : mariaDB
Source Server Version : 100124
Source Host           : localhost:3306
Source Database       : zjb

Target Server Type    : MariaDB
Target Server Version : 100124
File Encoding         : 65001

Date: 2017-10-09 10:58:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '显示名称',
  `org_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT '父级id',
  `path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('13', 'users', 'web', '2017-09-25 11:07:16', '2017-09-25 13:04:05', '用户', null, '0', '0');
INSERT INTO `permissions` VALUES ('14', 'user.add', 'web', '2017-09-25 11:08:43', '2017-09-25 11:08:43', '增加用户', null, '13', '0,13');
INSERT INTO `permissions` VALUES ('18', 'user.del', 'web', '2017-10-07 22:44:04', '2017-10-07 22:44:04', '删除用户', null, '13', '0,13');
INSERT INTO `permissions` VALUES ('19', 'user.index', 'web', '2017-10-07 22:44:28', '2017-10-07 22:44:28', '显示用户', null, '13', '0,13');
INSERT INTO `permissions` VALUES ('20', 'user.edit', 'web', '2017-10-08 16:37:23', '2017-10-08 16:37:23', '编辑用户', null, '13', '0,13');
INSERT INTO `permissions` VALUES ('21', 'role', 'web', '2017-10-08 16:42:18', '2017-10-08 16:42:18', '角色', null, '0', '0');
INSERT INTO `permissions` VALUES ('22', 'role.index', 'web', '2017-10-08 16:42:44', '2017-10-08 16:42:44', '显示角色', null, '21', '0,21');
INSERT INTO `permissions` VALUES ('23', 'role.edit', 'web', '2017-10-08 16:43:07', '2017-10-08 16:43:07', '修改角色', null, '21', '0,21');
INSERT INTO `permissions` VALUES ('24', 'role.del', 'web', '2017-10-08 17:00:36', '2017-10-08 17:00:36', '删除角色', null, '21', '0,21');
INSERT INTO `permissions` VALUES ('25', 'role.add', 'web', '2017-10-08 17:00:56', '2017-10-08 17:00:56', '添加角色', null, '21', '0,21');
INSERT INTO `permissions` VALUES ('26', 'permission', 'web', '2017-10-08 17:01:26', '2017-10-08 17:01:26', '权限', null, '0', '0');
INSERT INTO `permissions` VALUES ('27', 'permission.index', 'web', '2017-10-08 17:01:52', '2017-10-08 17:01:52', '显示权限', null, '26', '0,26');
INSERT INTO `permissions` VALUES ('28', 'permission.add', 'web', '2017-10-08 17:02:12', '2017-10-08 17:02:12', '添加权限', null, '26', '0,26');
INSERT INTO `permissions` VALUES ('29', 'permission.del', 'web', '2017-10-08 17:04:00', '2017-10-08 17:04:00', '删除权限', null, '26', '0,26');
INSERT INTO `permissions` VALUES ('30', 'permission.edit', 'web', '2017-10-08 17:04:16', '2017-10-08 17:04:16', '编辑权限', null, '26', '0,26');
INSERT INTO `permissions` VALUES ('31', 'unit', 'web', '2017-10-08 17:09:55', '2017-10-08 17:09:55', '单位信息', null, '0', '0');
INSERT INTO `permissions` VALUES ('32', 'unit.index', 'web', '2017-10-08 17:10:33', '2017-10-08 17:10:33', '单位信息显示', null, '31', '0,31');
INSERT INTO `permissions` VALUES ('33', 'unit.add', 'web', '2017-10-08 17:11:02', '2017-10-08 17:11:02', '添加单位信息', null, '31', '0,31');
INSERT INTO `permissions` VALUES ('34', 'unit.edit', 'web', '2017-10-08 17:11:23', '2017-10-08 17:11:23', '修改单位信息', null, '31', '0,31');
INSERT INTO `permissions` VALUES ('35', 'unit.del', 'web', '2017-10-08 17:11:40', '2017-10-08 17:11:40', '删除单位信息', null, '31', '0,31');
INSERT INTO `permissions` VALUES ('36', 'departments', 'web', '2017-10-08 17:12:16', '2017-10-08 17:12:16', '组织机构', null, '0', '0');
INSERT INTO `permissions` VALUES ('37', 'departments.add', 'web', '2017-10-08 17:12:41', '2017-10-08 17:17:21', '添加组织机构', null, '36', '0,36');
INSERT INTO `permissions` VALUES ('38', 'departments.index', 'web', '2017-10-08 17:13:01', '2017-10-08 17:13:01', '组织机构显示', null, '36', '0,36');
INSERT INTO `permissions` VALUES ('39', 'departments.del', 'web', '2017-10-08 17:17:02', '2017-10-08 17:17:02', '删除组织机构', null, '36', '0,36');
INSERT INTO `permissions` VALUES ('40', 'departments.edit', 'web', '2017-10-08 17:17:44', '2017-10-08 17:17:58', '编辑组织机构', null, '36', '0,36');
INSERT INTO `permissions` VALUES ('41', 'classify', 'web', '2017-10-08 19:49:25', '2017-10-08 19:49:25', '报修分类', null, '0', '0');
INSERT INTO `permissions` VALUES ('42', 'classify.index', 'web', '2017-10-08 19:50:04', '2017-10-08 19:50:04', '报修分类显示', null, '41', '0,41');
INSERT INTO `permissions` VALUES ('43', 'classify.add', 'web', '2017-10-08 19:50:30', '2017-10-08 19:50:30', '添加报修分类', null, '41', '0,41');
INSERT INTO `permissions` VALUES ('44', 'classfiy.edit', 'web', '2017-10-08 19:51:10', '2017-10-08 19:51:10', '修改报修分类', null, '41', '0,41');
INSERT INTO `permissions` VALUES ('45', 'classfiy.del', 'web', '2017-10-08 19:51:36', '2017-10-08 19:51:36', '删除报修分类', null, '41', '0,41');
INSERT INTO `permissions` VALUES ('46', 'create.repair', 'web', '2017-10-08 20:20:02', '2017-10-08 20:20:02', '新增报修', null, '0', '0');
INSERT INTO `permissions` VALUES ('47', 'create.repair.index', 'web', '2017-10-08 20:20:43', '2017-10-08 20:20:43', '新增报修显示', null, '46', '0,46');
INSERT INTO `permissions` VALUES ('48', 'create.repair.add', 'web', '2017-10-08 20:21:15', '2017-10-08 20:21:15', '增加新增报修', null, '46', '0,46');
INSERT INTO `permissions` VALUES ('49', 'create.repair.edit', 'web', '2017-10-08 20:21:41', '2017-10-08 20:22:08', '修改新增报修', null, '46', '0,46');
INSERT INTO `permissions` VALUES ('50', 'create.repair.del', 'web', '2017-10-08 20:22:44', '2017-10-08 20:22:44', '删除新增报修', null, '46', '0,46');
INSERT INTO `permissions` VALUES ('51', 'repair.list', 'web', '2017-10-08 20:52:01', '2017-10-08 20:52:01', '我的报修列表', null, '0', '0');
INSERT INTO `permissions` VALUES ('52', 'repair.list.index', 'web', '2017-10-08 20:52:49', '2017-10-08 20:52:49', '我的报修单显示', null, '51', '0,51');
INSERT INTO `permissions` VALUES ('53', 'repair.list.add', 'web', '2017-10-08 20:53:19', '2017-10-08 20:53:19', '添加我的报修单', null, '51', '0,51');
INSERT INTO `permissions` VALUES ('54', 'repair.list.edit', 'web', '2017-10-08 20:53:43', '2017-10-08 20:53:43', '修改我的报修单', null, '51', '0,51');
INSERT INTO `permissions` VALUES ('55', 'repair.list.del', 'web', '2017-10-08 20:54:03', '2017-10-08 20:54:03', '删除我的报修单', null, '51', '0,51');
INSERT INTO `permissions` VALUES ('56', 'service.provider', 'web', '2017-10-08 21:03:03', '2017-10-08 21:03:03', '服务商', null, '0', '0');
INSERT INTO `permissions` VALUES ('57', 'service.provider.index', 'web', '2017-10-08 21:03:28', '2017-10-08 21:03:28', '服务商显示', null, '56', '0,56');
INSERT INTO `permissions` VALUES ('58', 'service.provider.edit', 'web', '2017-10-08 21:05:56', '2017-10-08 21:05:56', '修改服务商', null, '56', '0,56');
INSERT INTO `permissions` VALUES ('59', 'service.provider.add', 'web', '2017-10-08 21:06:23', '2017-10-08 21:06:23', '创建服务商', null, '56', '0,56');
INSERT INTO `permissions` VALUES ('60', 'service.provider.del', 'web', '2017-10-08 21:06:39', '2017-10-08 21:06:39', '删除服务商', null, '56', '0,56');
INSERT INTO `permissions` VALUES ('61', 'service.worker', 'web', '2017-10-08 21:43:58', '2017-10-08 21:43:58', '维修人员', null, '0', '0');
INSERT INTO `permissions` VALUES ('62', 'service.worker.index', 'web', '2017-10-08 21:44:19', '2017-10-08 21:44:19', '维修人员显示', null, '61', '0,61');
INSERT INTO `permissions` VALUES ('63', 'service.worker.edit', 'web', '2017-10-08 21:44:34', '2017-10-08 21:44:34', '修改维修人员', null, '61', '0,61');
INSERT INTO `permissions` VALUES ('64', 'service.worker.add', 'web', '2017-10-08 21:44:55', '2017-10-08 21:44:55', '添加维修人员', null, '61', '0,61');
INSERT INTO `permissions` VALUES ('65', 'service.worker.del', 'web', '2017-10-08 21:45:16', '2017-10-08 21:45:16', '删除维修人员', null, '61', '0,61');
INSERT INTO `permissions` VALUES ('66', 'asset', 'web', '2017-10-09 09:52:31', '2017-10-09 09:52:31', '资产', null, '0', '0');
INSERT INTO `permissions` VALUES ('67', 'asset.index', 'web', '2017-10-09 09:53:16', '2017-10-09 09:53:16', '资产显示', null, '66', '0,66');
INSERT INTO `permissions` VALUES ('68', 'asset.add', 'web', '2017-10-09 09:53:36', '2017-10-09 09:53:36', '添加资产', null, '66', '0,66');
INSERT INTO `permissions` VALUES ('69', 'asset.edit', 'web', '2017-10-09 09:54:18', '2017-10-09 09:54:18', '修改资产', null, '66', '0,66');
INSERT INTO `permissions` VALUES ('70', 'aseet.del', 'web', '2017-10-09 09:55:19', '2017-10-09 09:55:19', '删除资产', null, '66', '0,66');
INSERT INTO `permissions` VALUES ('71', 'area', 'web', '2017-10-09 09:55:53', '2017-10-09 09:55:53', '场地位置', null, '0', '0');
INSERT INTO `permissions` VALUES ('72', 'area.index', 'web', '2017-10-09 09:56:22', '2017-10-09 09:56:22', '场地位置显示', null, '71', '0,71');
INSERT INTO `permissions` VALUES ('73', 'area.add', 'web', '2017-10-09 09:56:41', '2017-10-09 09:56:41', '添加场地位置', null, '71', '0,71');
INSERT INTO `permissions` VALUES ('74', 'area.edit', 'web', '2017-10-09 09:56:57', '2017-10-09 09:56:57', '修改场地位置', null, '71', '0,71');
INSERT INTO `permissions` VALUES ('75', 'area.del', 'web', '2017-10-09 09:57:14', '2017-10-09 09:57:14', '删除场地位置', null, '71', '0,71');
INSERT INTO `permissions` VALUES ('76', 'asset.category', 'web', '2017-10-09 09:57:50', '2017-10-09 09:57:50', '资产分类', null, '0', '0');
INSERT INTO `permissions` VALUES ('77', 'asset.category.index', 'web', '2017-10-09 09:58:14', '2017-10-09 09:58:14', '资产分类显示', null, '76', '0,76');
INSERT INTO `permissions` VALUES ('78', 'asset.category.add', 'web', '2017-10-09 09:58:29', '2017-10-09 09:58:29', '添加资产分类', null, '76', '0,76');
INSERT INTO `permissions` VALUES ('79', 'asset.category.edit', 'web', '2017-10-09 09:58:43', '2017-10-09 09:58:43', '修改资产分类', null, '76', '0,76');
INSERT INTO `permissions` VALUES ('80', 'asset.category.del', 'web', '2017-10-09 09:59:07', '2017-10-09 09:59:07', '资产分类删除', null, '76', '0,76');
INSERT INTO `permissions` VALUES ('81', 'asset.return', 'web', '2017-10-09 10:09:17', '2017-10-09 10:09:17', '资产退库', null, '0', '0');
INSERT INTO `permissions` VALUES ('82', 'asset.return.add', 'web', '2017-10-09 10:09:46', '2017-10-09 10:09:46', '添加资产退库', null, '81', '0,81');
INSERT INTO `permissions` VALUES ('83', 'asset.return.edit', 'web', '2017-10-09 10:10:07', '2017-10-09 10:10:07', '修改资产退库', null, '81', '0,81');
INSERT INTO `permissions` VALUES ('84', 'asset.return.index', 'web', '2017-10-09 10:10:53', '2017-10-09 10:10:53', '显示资产退库', null, '81', '0,81');
INSERT INTO `permissions` VALUES ('85', 'asset.return.del', 'web', '2017-10-09 10:11:08', '2017-10-09 10:11:08', '删除资产退库', null, '81', '0,81');
INSERT INTO `permissions` VALUES ('86', 'asset.use', 'web', '2017-10-09 10:11:53', '2017-10-09 10:11:53', '资产领用', null, '0', '0');
INSERT INTO `permissions` VALUES ('87', 'asset.use.index', 'web', '2017-10-09 10:45:21', '2017-10-09 10:45:21', '资产领用显示', null, '86', '0,86');
INSERT INTO `permissions` VALUES ('88', 'asset.use.add', 'web', '2017-10-09 10:45:42', '2017-10-09 10:45:42', '增加资产领用', null, '86', '0,86');
INSERT INTO `permissions` VALUES ('89', 'asset.use.edit', 'web', '2017-10-09 10:46:12', '2017-10-09 10:46:12', '修改资产领用', null, '86', '0,86');
INSERT INTO `permissions` VALUES ('90', 'asset.use.del', 'web', '2017-10-09 10:46:30', '2017-10-09 10:46:30', '删除资产领用', null, '86', '0,86');
INSERT INTO `permissions` VALUES ('91', 'borrow', 'web', '2017-10-09 10:49:35', '2017-10-09 10:49:35', '借用&归还', null, '0', '0');
INSERT INTO `permissions` VALUES ('92', 'borrow.index', 'web', '2017-10-09 10:50:00', '2017-10-09 10:50:00', '显示借用&归还', null, '91', '0,91');
INSERT INTO `permissions` VALUES ('93', 'borrow.add', 'web', '2017-10-09 10:50:23', '2017-10-09 10:50:23', '增加借用&归还', null, '91', '0,91');
INSERT INTO `permissions` VALUES ('94', 'borrow.edit', 'web', '2017-10-09 10:50:39', '2017-10-09 10:50:39', '修改借用&归还', null, '91', '0,91');
INSERT INTO `permissions` VALUES ('95', 'borrow.del', 'web', '2017-10-09 10:50:51', '2017-10-09 10:50:51', '删除借用&归还', null, '91', '0,91');
INSERT INTO `permissions` VALUES ('96', 'contract', 'web', '2017-10-09 10:51:22', '2017-10-09 10:51:22', '资产合同', null, '0', '0');
INSERT INTO `permissions` VALUES ('97', 'contract.index', 'web', '2017-10-09 10:51:47', '2017-10-09 10:51:47', '显示资产合同', null, '96', '0,96');
INSERT INTO `permissions` VALUES ('98', 'contract.add', 'web', '2017-10-09 10:52:05', '2017-10-09 10:52:05', '添加资产合同', null, '96', '0,96');
INSERT INTO `permissions` VALUES ('99', 'contract.edit', 'web', '2017-10-09 10:52:21', '2017-10-09 10:52:21', '修改资产合同', null, '96', '0,96');
INSERT INTO `permissions` VALUES ('100', 'contract.del', 'web', '2017-10-09 10:52:40', '2017-10-09 10:52:40', '删除资产合同', null, '96', '0,96');
INSERT INTO `permissions` VALUES ('101', 'supplier', 'web', '2017-10-09 10:55:04', '2017-10-09 10:55:04', '供应商', null, '0', '0');
INSERT INTO `permissions` VALUES ('102', 'supplier.index', 'web', '2017-10-09 10:57:04', '2017-10-09 10:57:04', '供应商显示', null, '101', '0,101');
INSERT INTO `permissions` VALUES ('103', 'supplier.add', 'web', '2017-10-09 10:57:26', '2017-10-09 10:57:26', '添加供应商', null, '101', '0,101');
INSERT INTO `permissions` VALUES ('104', 'supplier.edit', 'web', '2017-10-09 10:57:42', '2017-10-09 10:57:42', '修改供应商', null, '101', '0,101');
INSERT INTO `permissions` VALUES ('105', 'supplier.del', 'web', '2017-10-09 10:58:02', '2017-10-09 10:58:02', '删除供应商', null, '101', '0,101');
