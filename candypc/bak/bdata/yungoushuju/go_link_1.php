<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `go_link`;");
E_C("CREATE TABLE `go_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情链接ID',
  `type` tinyint(1) unsigned NOT NULL COMMENT '链接类型',
  `name` char(20) NOT NULL COMMENT '名称',
  `logo` varchar(250) NOT NULL COMMENT '图片',
  `url` varchar(50) NOT NULL COMMENT '地址',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8");
E_D("replace into `go_link` values('2','1','聚美优品','','http://www.jumei.com');");
E_D("replace into `go_link` values('5','1','百度','','http://www.baidu.com');");

require("../../inc/footer.php");
?>