<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `go_wap`;");
E_C("CREATE TABLE `go_wap` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '????',
  `title` char(100) DEFAULT '' COMMENT '????????',
  `link` char(255) DEFAULT '' COMMENT '??????',
  `img` text COMMENT '?????',
  `color` text COMMENT '????????',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk");
E_D("replace into `go_wap` values('4','ÊÖ»úad3','#','banner/20150905/83816299434195.jpg','#df4f66');");

require("../../inc/footer.php");
?>