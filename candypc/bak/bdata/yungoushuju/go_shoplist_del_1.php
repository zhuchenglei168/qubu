<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `go_shoplist_del`;");
E_C("CREATE TABLE `go_shoplist_del` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `sid` int(10) unsigned NOT NULL COMMENT '同一个商品',
  `cateid` smallint(6) unsigned DEFAULT NULL COMMENT '所属栏目ID',
  `brandid` smallint(6) unsigned DEFAULT NULL COMMENT '所属品牌ID',
  `title` varchar(100) DEFAULT NULL COMMENT '商品标题',
  `title_style` varchar(100) DEFAULT NULL,
  `title2` varchar(100) DEFAULT NULL COMMENT '副标题',
  `keywords` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00' COMMENT '金额',
  `yunjiage` decimal(4,2) unsigned DEFAULT '1.00' COMMENT '云购人次价格',
  `zongrenshu` int(10) unsigned DEFAULT '0' COMMENT '总需人数',
  `canyurenshu` int(10) unsigned DEFAULT '0' COMMENT '已参与人数',
  `shenyurenshu` int(10) unsigned DEFAULT NULL,
  `def_renshu` int(10) unsigned DEFAULT '0',
  `qishu` smallint(6) unsigned DEFAULT '0' COMMENT '期数',
  `maxqishu` smallint(5) unsigned DEFAULT '1' COMMENT ' 最大期数',
  `thumb` varchar(255) DEFAULT NULL,
  `picarr` text COMMENT '商品图片',
  `content` mediumtext COMMENT '商品内容详情',
  `codes_table` char(20) DEFAULT NULL,
  `xsjx_time` int(10) unsigned DEFAULT NULL,
  `pos` tinyint(4) unsigned DEFAULT NULL COMMENT '是否推荐',
  `renqi` tinyint(4) unsigned DEFAULT '0' COMMENT '是否人气商品0否1是',
  `time` int(10) unsigned DEFAULT NULL COMMENT '时间',
  `order` int(10) unsigned DEFAULT '1',
  `q_uid` int(10) unsigned DEFAULT NULL COMMENT '中奖人ID',
  `q_user` text NOT NULL COMMENT '中奖人信息',
  `q_user_code` char(20) DEFAULT NULL COMMENT '中奖码',
  `q_content` mediumtext COMMENT '揭晓内容',
  `q_counttime` char(20) DEFAULT NULL COMMENT '总时间相加',
  `q_end_time` char(20) DEFAULT NULL COMMENT '揭晓时间',
  `q_showtime` char(1) DEFAULT 'N' COMMENT 'Y/N揭晓动画',
  `zhiding` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '指定中奖人',
  PRIMARY KEY (`id`),
  KEY `renqi` (`renqi`),
  KEY `order` (`yunjiage`),
  KEY `q_uid` (`q_uid`),
  KEY `sid` (`sid`),
  KEY `shenyurenshu` (`shenyurenshu`),
  KEY `q_showtime` (`q_showtime`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='商品表'");
E_D("replace into `go_shoplist_del` values('78','78','6','10','苹果（Apple）iPad Air 2 9.7英寸平板电脑 16G WiFi版薄至6.1mm','color:#FF0000;','突破性的 Touch ID 技术，新 A8X 芯片，迄今为止速度最快、性能极强的一款 iPad！（颜色随机发）','佳能,单反,数码相机','我就是ipad aire','3.00','1.00','3','3','0','0','1','100','shopimg/20150827/52531622645752.jpg','a:2:{i:0;s:35:\"shopimg/20150827/26080915645761.jpg\";i:1;s:35:\"shopimg/20150827/59251602645768.jpg\";}','<p>	</p><p>	</p><p style=\"font-size:45px; line-height:50px; padding:10px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:5px;\">	iPad Air 2</p><p>	</p><p style=\"font-size:35px; line-height:40px; padding:30px 0px 20px 55px; margin:0px; text-align:center; letter-spacing:10px; color:#333;\">	轻轻地，改变一切。</p><p>	</p><p style=\"padding-top:50px; margin:0px; text-align:center;\">	<img src=\"http://goodsimg.1yyg.com/GoodsInfo/20141024154812638.jpg\"/></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:30px; line-height:45px; padding:30px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	多才多能，让你不想放手；<br/>	又轻又薄，让你不觉在手。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:440px 50px 0px 50px; margin:0px; text-align:center;\">	对于 iPad，我们一直都有一个看似自相矛盾的目标：要创造一部功能极为强大，但又轻盈纤薄到你不觉在手的设备；一部让你能全力挥洒，但却毫不费力的设备。 iPad Air 2 不仅实现了这一切，甚至还超出了我们的预期。</p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:55px; padding:160px 0px 0px 350px; margin:0px; letter-spacing:1px; color:#333;\">	显示屏，不仅更薄，<br/>	还更显出色。</p><p>	</p><p style=\"font-size:15px; line-height:26px; padding:20px 20px 0px 350px; margin:0px; letter-spacing:1px; color:#333;\">	为打造 iPad Air 2 令人惊叹的纤薄外形，我们从重新设计 Retina\n显示屏开始，将原本的三层合为一层。这样做的成果不仅是让它更薄，同时也让显示效果更好。由此色彩表现更鲜艳，对比度也更出色。而且我们还增添了抗反射涂\n层，让 iPad Air 2 的反光率再创新低。</p><p>	</p><p style=\"font-size:13px; line-height:48px; padding:20px 0px 0px 350px; margin:0px; letter-spacing:2px; color:#333;\">	<span style=\"font-size:38px;\">9.7</span> 英寸 <span style=\"font-size:35px; padding-left:20px;\">2048×1536</span></p><p>	</p><p style=\"font-size:15px; line-height:20px; padding:0px 0px 0px 350px; margin:0px; letter-spacing:2px; color:#333;\">	显示屏 <span style=\"padding-left:70px;\">分辨率</span></p><p>	</p><p style=\"font-size:13px; line-height:48px; padding:20px 0px 0px 350px; margin:0px; letter-spacing:2px; color:#333;\">	<span style=\"font-size:38px;\">310 </span> 万 <span style=\"font-size:35px; padding-left:20px;\">264</span></p><p>	</p><p style=\"font-size:15px; line-height:20px; padding:0px 0px 0px 355px; margin:0px; letter-spacing:2px; color:#333;\">	像素 <span style=\"padding-left:90px;\">PPI</span></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:50px; padding:50px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	力量极强大，形态极简约。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:410px 60px 0px 60px; margin:0px; text-align:center;\">	iPad Air 2 不仅薄了许多，还强大更多。和上一代相比，我们设计的全新 A8X\n芯片在中央处理器和图形处理器性能上均有切实显著的提升。事实上，凭借 64 位台式电脑级架构，iPad Air 2\n所拥有的强大性能可与众多个人电脑相媲美。不仅如此，它的能效也非常出色，长达 10\n小时的电池使用时间，可满足你日常一天的工作、娱乐、浏览网络及购物所用。</p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:55px; padding:50px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	独一无二的指纹，<br/>	成就独到的安全保护。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:20px 60px 0px 60px; margin:0px; text-align:center;\">	iPad Air 2 配备了我们突破性的 Touch ID\n技术，它凭借你的指纹，这一与生俱来的完美密码，将安全性提升到前所未有的级别。因此，只需轻轻一触，你即可解锁自己的 iPad Air 2。但\nTouch ID 所能做的远不止于此，它还可以让你在 iBooks 及 App Store 中安全地进行下载或购买。</p><p>	</p><p style=\"padding-top:50px; margin:0px; text-align:center;\">	<img src=\"http://goodsimg.1yyg.com/GoodsInfo/20141024154914756.jpg\"/></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:55px; padding:50px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	两部出色的相机，<br/>	藏身一部 iPad 之中。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:20px 30px 0px 30px; margin:0px; text-align:center;\">	iPad Air 2 配备了我们迄今为止极为出色的全新 iSight 摄像头。它拥有先进的光学技术、优化的传感器和 Apple\n设计的强大图像信号处理器。它还加入一系列照片和视频的全新功能，如全景、延时摄影视频、慢动作视频，以及连拍快照和计时模式。前置 FaceTime\nHD\n高清摄像头也经过重新设计，拥有优化的传感器和更大尺寸像素，使其在弱光条件下的表现更出色。这一切，让你所有照片和视频，以及视频通话和自拍，看起来都\n漂亮极了。</p><p>	</p><p style=\"padding-top:50px; margin:0px; text-align:center;\">	<img src=\"http://goodsimg.1yyg.com/GoodsInfo/20141024154920765.jpg\"/></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:55px; padding:50px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	更快无线网络连接，<br/>	精彩无需等待。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:20px 50px 0px 50px; margin:0px; text-align:center;\">	Pad Air 2 的无线网络连接速度非常快，达到前代产品的两倍以上。因此，下载大文件和传输流媒体视频都比以往更省时间。而且 WLAN + Cellular 机型还具备更快速、更先进的 4G LTE 技术，因此即使身处匆匆行程之中，你也能轻松连接高速网络。</p><p>	</p><p style=\"padding-top:20px; margin:0px; text-align:center;\">	<img src=\"http://goodsimg.1yyg.com/GoodsInfo/20141024154927978.jpg\"/></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:55px; padding:50px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	众多 App，为 iPad 量身打造，<br/>	也为成就你想做的一切。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:20px 50px 0px 50px; margin:0px; text-align:center;\">	iPad Air 2 内置多款强大 app\n来让你处理日常事务，比如浏览网络，查收电子邮件，编辑影片和照片，撰写报告和阅读图书。不仅如此，App Store 中还有成千上万款 app，专为 iPad 宽大的多点触控 Retina 显示屏而精心设计，绝不仅仅是手机 app\n的简单放大。因此，无论你是爱好摄影，游戏，旅行，还是想管理自己的财务，总有一款 app 会让你做得更出色。</p><p>	</p><p style=\"padding-top:50px; margin:0px; text-align:center;\">	<img src=\"http://goodsimg.1yyg.com/GoodsInfo/20141024154934369.jpg\"/></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:35px; line-height:55px; padding:50px 0px 0px 0px; margin:0px; text-align:center; letter-spacing:4px; color:#333;\">	iOS 8 和 iPad Air 2，<br/>	强强联手。</p><p>	</p><p style=\"font-size:14px; line-height:26px; padding:20px 30px 0px 30px; margin:0px; text-align:center;\">	iOS 8 是超前的移动操作系统，其先进功能让 iPad Air 2\n变得更不可或缺。连续互通功能可让你在这部设备上开始一个项目，然后在另一部设备上继续完成。家人共享功能让你与多达六人轻松共享图书和 app。而\niCloud Drive 可让你安全存储各种类型的文档，并从你的各种设备上访问。事实上，iOS 8 上的一切功能不仅是为了与 iPad Air 2 默契配合而设计，也是为了将强大的 A8X 芯片、超快的无线连接、以及绚丽 Retina 显示屏的优势发挥到淋漓尽致而打造。</p><p>	</p><p style=\"padding-top:50px; margin:0px; text-align:center;\">	<img src=\"http://goodsimg.1yyg.com/GoodsInfo/20141024154942167.jpg\"/></p><p>	</p><p>	</p><p>	</p><p style=\"font-size:18px; line-height:25px; padding:20px 0 10px 0px; margin:0px;\">	重要说明：</p><p>	</p><p style=\"font-size:14px; line-height:22px; padding:0 0 10px 40px; margin:0px;\">	1元云购将在商品到货后第一时间按订单顺序发出，颜色随机发。</p><p>	</p><p><br/></p>','shopcodes_1','0','1','1','1440645807','1','1','a:20:{s:3:\"uid\";s:1:\"1\";s:8:\"username\";s:9:\"崔银明\";s:5:\"email\";s:18:\"cuiyinming@126.com\";s:6:\"mobile\";s:11:\"18649625719\";s:8:\"password\";s:32:\"e10adc3949ba59abbe56e057f20f883e\";s:7:\"user_ip\";s:10:\",127.0.0.1\";s:3:\"img\";s:34:\"touimg/20150823/48140424264534.jpg\";s:8:\"qianming\";s:0:\"\";s:7:\"groupid\";s:1:\"1\";s:8:\"addgroup\";s:6:\"1,5,2,\";s:5:\"money\";s:6:\"137.00\";s:9:\"emailcode\";s:1:\"1\";s:10:\"mobilecode\";s:1:\"1\";s:8:\"passcode\";s:1:\"1\";s:7:\"reg_key\";N;s:5:\"score\";s:5:\"14133\";s:7:\"jingyan\";s:4:\"1400\";s:7:\"yaoqing\";N;s:4:\"band\";N;s:4:\"time\";N;}','10000002','a:100:{i:0;a:8:{s:4:\"time\";s:14:\"1440728639.925\";s:8:\"username\";s:9:\"崔银明\";s:3:\"uid\";s:1:\"1\";s:6:\"shopid\";s:2:\"78\";s:8:\"shopname\";s:72:\"苹果（Apple）iPad Air 2 9.7英寸平板电脑 16G WiFi版薄至6.1mm\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"102359925\";}i:1;a:8:{s:4:\"time\";s:14:\"1440687001.201\";s:8:\"username\";s:9:\"崔银明\";s:3:\"uid\";s:1:\"1\";s:6:\"shopid\";s:2:\"77\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"10\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"225001201\";}i:2;a:8:{s:4:\"time\";s:14:\"1440686991.642\";s:8:\"username\";s:9:\"崔银明\";s:3:\"uid\";s:1:\"1\";s:6:\"shopid\";s:2:\"78\";s:8:\"shopname\";s:72:\"苹果（Apple）iPad Air 2 9.7英寸平板电脑 16G WiFi版薄至6.1mm\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"224951642\";}i:3;a:8:{s:4:\"time\";s:14:\"1440647133.717\";s:8:\"username\";s:9:\"崔银明\";s:3:\"uid\";s:1:\"1\";s:6:\"shopid\";s:2:\"78\";s:8:\"shopname\";s:72:\"苹果（Apple）iPad Air 2 9.7英寸平板电脑 16G WiFi版薄至6.1mm\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"114533717\";}i:4;a:8:{s:4:\"time\";s:14:\"1440647133.717\";s:8:\"username\";s:9:\"崔银明\";s:3:\"uid\";s:1:\"1\";s:6:\"shopid\";s:2:\"77\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"10\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"114533717\";}i:5;a:8:{s:4:\"time\";s:14:\"1440640898.825\";s:8:\"username\";s:9:\"崔银明\";s:3:\"uid\";s:1:\"1\";s:6:\"shopid\";s:2:\"68\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"2\";s:8:\"gonumber\";s:1:\"3\";s:8:\"time_add\";s:9:\"100138825\";}i:6;a:8:{s:4:\"time\";s:14:\"1440582428.450\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"77\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"10\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"174708450\";}i:7;a:8:{s:4:\"time\";s:14:\"1440581560.849\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"77\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"10\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"173240849\";}i:8;a:8:{s:4:\"time\";s:14:\"1440580894.808\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"76\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"9\";s:8:\"gonumber\";s:2:\"45\";s:8:\"time_add\";s:9:\"172134808\";}i:9;a:8:{s:4:\"time\";s:14:\"1440580311.896\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"75\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"8\";s:8:\"gonumber\";s:2:\"45\";s:8:\"time_add\";s:9:\"171151896\";}i:10;a:8:{s:4:\"time\";s:14:\"1440579928.458\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"73\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"7\";s:8:\"gonumber\";s:2:\"45\";s:8:\"time_add\";s:9:\"170528458\";}i:11;a:8:{s:4:\"time\";s:14:\"1440578994.978\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"16\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:2:\"26\";s:8:\"time_add\";s:9:\"164954978\";}i:12;a:8:{s:4:\"time\";s:14:\"1440578193.306\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"72\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"6\";s:8:\"gonumber\";s:2:\"45\";s:8:\"time_add\";s:9:\"163633306\";}i:13;a:8:{s:4:\"time\";s:14:\"1440577741.796\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"41\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"5\";s:8:\"gonumber\";s:2:\"30\";s:8:\"time_add\";s:9:\"162901796\";}i:14;a:8:{s:4:\"time\";s:14:\"1440555207.978\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"41\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"5\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"101327978\";}i:15;a:8:{s:4:\"time\";s:14:\"1440554119.070\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"70\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"43\";s:8:\"gonumber\";s:1:\"2\";s:8:\"time_add\";s:8:\"95519070\";}i:16;a:8:{s:4:\"time\";s:14:\"1440498553.022\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"69\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"42\";s:8:\"gonumber\";s:1:\"2\";s:8:\"time_add\";s:9:\"182913022\";}i:17;a:8:{s:4:\"time\";s:14:\"1440497145.328\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"67\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"41\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"180545328\";}i:18;a:8:{s:4:\"time\";s:14:\"1440497083.788\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:2:\"67\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:2:\"41\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"180443788\";}i:19;a:8:{s:4:\"time\";s:14:\"1440494020.367\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:3:\"685\";s:8:\"time_add\";s:9:\"171340367\";}i:20;a:8:{s:4:\"time\";s:14:\"1440494011.447\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171331447\";}i:21;a:8:{s:4:\"time\";s:14:\"1440494006.177\";s:8:\"username\";s:6:\"王五\";s:3:\"uid\";s:2:\"14\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171326177\";}i:22;a:8:{s:4:\"time\";s:14:\"1440493965.293\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171245293\";}i:23;a:8:{s:4:\"time\";s:14:\"1440493959.984\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171239984\";}i:24;a:8:{s:4:\"time\";s:14:\"1440493955.126\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171235126\";}i:25;a:8:{s:4:\"time\";s:14:\"1440493950.307\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171230307\";}i:26;a:8:{s:4:\"time\";s:14:\"1440493945.448\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171225448\";}i:27;a:8:{s:4:\"time\";s:14:\"1440493939.557\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171219557\";}i:28;a:8:{s:4:\"time\";s:14:\"1440493934.633\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171214633\";}i:29;a:8:{s:4:\"time\";s:14:\"1440493929.427\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171209427\";}i:30;a:8:{s:4:\"time\";s:14:\"1440493923.633\";s:8:\"username\";s:9:\"孔乙己\";s:3:\"uid\";s:2:\"17\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171203633\";}i:31;a:8:{s:4:\"time\";s:14:\"1440493878.957\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171118957\";}i:32;a:8:{s:4:\"time\";s:14:\"1440493867.542\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171107542\";}i:33;a:8:{s:4:\"time\";s:14:\"1440493865.470\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171105470\";}i:34;a:8:{s:4:\"time\";s:14:\"1440493850.696\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171050696\";}i:35;a:8:{s:4:\"time\";s:14:\"1440493845.847\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171045847\";}i:36;a:8:{s:4:\"time\";s:14:\"1440493841.195\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171041195\";}i:37;a:8:{s:4:\"time\";s:14:\"1440493836.499\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171036499\";}i:38;a:8:{s:4:\"time\";s:14:\"1440493831.738\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171031738\";}i:39;a:8:{s:4:\"time\";s:14:\"1440493826.797\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171026797\";}i:40;a:8:{s:4:\"time\";s:14:\"1440493822.148\";s:8:\"username\";s:6:\"彩彩\";s:3:\"uid\";s:2:\"18\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"171022148\";}i:41;a:8:{s:4:\"time\";s:14:\"1440493778.439\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170938439\";}i:42;a:8:{s:4:\"time\";s:14:\"1440493772.346\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170932346\";}i:43;a:8:{s:4:\"time\";s:14:\"1440493767.364\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170927364\";}i:44;a:8:{s:4:\"time\";s:14:\"1440493762.019\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170922019\";}i:45;a:8:{s:4:\"time\";s:14:\"1440493757.266\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170917266\";}i:46;a:8:{s:4:\"time\";s:14:\"1440493752.050\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170912050\";}i:47;a:8:{s:4:\"time\";s:14:\"1440493746.611\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170906611\";}i:48;a:8:{s:4:\"time\";s:14:\"1440493738.643\";s:8:\"username\";s:9:\"劝分党\";s:3:\"uid\";s:2:\"19\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170858643\";}i:49;a:8:{s:4:\"time\";s:14:\"1440493694.758\";s:8:\"username\";s:6:\"李四\";s:3:\"uid\";s:2:\"13\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170814758\";}i:50;a:8:{s:4:\"time\";s:14:\"1440493689.739\";s:8:\"username\";s:6:\"李四\";s:3:\"uid\";s:2:\"13\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170809739\";}i:51;a:8:{s:4:\"time\";s:14:\"1440493684.892\";s:8:\"username\";s:6:\"李四\";s:3:\"uid\";s:2:\"13\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170804892\";}i:52;a:8:{s:4:\"time\";s:14:\"1440493680.127\";s:8:\"username\";s:6:\"李四\";s:3:\"uid\";s:2:\"13\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170800127\";}i:53;a:8:{s:4:\"time\";s:14:\"1440493674.812\";s:8:\"username\";s:6:\"李四\";s:3:\"uid\";s:2:\"13\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170754812\";}i:54;a:8:{s:4:\"time\";s:14:\"1440493638.418\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170718418\";}i:55;a:8:{s:4:\"time\";s:14:\"1440493633.379\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170713379\";}i:56;a:8:{s:4:\"time\";s:14:\"1440493628.230\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170708230\";}i:57;a:8:{s:4:\"time\";s:14:\"1440493623.641\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170703641\";}i:58;a:8:{s:4:\"time\";s:14:\"1440493618.508\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170658508\";}i:59;a:8:{s:4:\"time\";s:14:\"1440493613.695\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170653695\";}i:60;a:8:{s:4:\"time\";s:14:\"1440493607.334\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170647334\";}i:61;a:8:{s:4:\"time\";s:14:\"1440493595.100\";s:8:\"username\";s:9:\"明の明\";s:3:\"uid\";s:1:\"4\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170635100\";}i:62;a:8:{s:4:\"time\";s:14:\"1440493558.745\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170558745\";}i:63;a:8:{s:4:\"time\";s:14:\"1440493553.904\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170553904\";}i:64;a:8:{s:4:\"time\";s:14:\"1440493548.640\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170548640\";}i:65;a:8:{s:4:\"time\";s:14:\"1440493543.203\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170543203\";}i:66;a:8:{s:4:\"time\";s:14:\"1440493537.009\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170537009\";}i:67;a:8:{s:4:\"time\";s:14:\"1440493528.341\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170528341\";}i:68;a:8:{s:4:\"time\";s:14:\"1440493522.570\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170522570\";}i:69;a:8:{s:4:\"time\";s:14:\"1440493516.342\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170516342\";}i:70;a:8:{s:4:\"time\";s:14:\"1440493510.727\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170510727\";}i:71;a:8:{s:4:\"time\";s:14:\"1440493505.382\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170505382\";}i:72;a:8:{s:4:\"time\";s:14:\"1440493500.880\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170500880\";}i:73;a:8:{s:4:\"time\";s:14:\"1440493496.158\";s:8:\"username\";s:9:\"房祖名\";s:3:\"uid\";s:1:\"6\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170456158\";}i:74;a:8:{s:4:\"time\";s:14:\"1440493449.420\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170409420\";}i:75;a:8:{s:4:\"time\";s:14:\"1440493442.303\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170402303\";}i:76;a:8:{s:4:\"time\";s:14:\"1440493436.935\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170356935\";}i:77;a:8:{s:4:\"time\";s:14:\"1440493430.909\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170350909\";}i:78;a:8:{s:4:\"time\";s:14:\"1440493425.188\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170345188\";}i:79;a:8:{s:4:\"time\";s:14:\"1440493420.665\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170340665\";}i:80;a:8:{s:4:\"time\";s:14:\"1440493414.932\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170334932\";}i:81;a:8:{s:4:\"time\";s:14:\"1440493410.251\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170330251\";}i:82;a:8:{s:4:\"time\";s:14:\"1440493405.384\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170325384\";}i:83;a:8:{s:4:\"time\";s:14:\"1440493400.188\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170320188\";}i:84;a:8:{s:4:\"time\";s:14:\"1440493395.507\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170315507\";}i:85;a:8:{s:4:\"time\";s:14:\"1440493390.660\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170310660\";}i:86;a:8:{s:4:\"time\";s:14:\"1440493385.956\";s:8:\"username\";s:6:\"张三\";s:3:\"uid\";s:2:\"11\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170305956\";}i:87;a:8:{s:4:\"time\";s:14:\"1440493335.969\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170215969\";}i:88;a:8:{s:4:\"time\";s:14:\"1440493324.828\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170204828\";}i:89;a:8:{s:4:\"time\";s:14:\"1440493319.277\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170159277\";}i:90;a:8:{s:4:\"time\";s:14:\"1440493313.518\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170153518\";}i:91;a:8:{s:4:\"time\";s:14:\"1440493307.640\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170147640\";}i:92;a:8:{s:4:\"time\";s:14:\"1440493302.441\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170142441\";}i:93;a:8:{s:4:\"time\";s:14:\"1440493295.776\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170135776\";}i:94;a:8:{s:4:\"time\";s:14:\"1440493290.571\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170130571\";}i:95;a:8:{s:4:\"time\";s:14:\"1440493285.636\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170125636\";}i:96;a:8:{s:4:\"time\";s:14:\"1440493277.559\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170117559\";}i:97;a:8:{s:4:\"time\";s:14:\"1440493267.169\";s:8:\"username\";s:15:\"孤独值班者\";s:3:\"uid\";s:2:\"20\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"170107169\";}i:98;a:8:{s:4:\"time\";s:14:\"1440493192.807\";s:8:\"username\";s:9:\"罗振宇\";s:3:\"uid\";s:1:\"8\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"165952807\";}i:99;a:8:{s:4:\"time\";s:14:\"1440493187.316\";s:8:\"username\";s:9:\"罗振宇\";s:3:\"uid\";s:1:\"8\";s:6:\"shopid\";s:1:\"6\";s:8:\"shopname\";s:54:\"苹果（Apple）iMac ME086CH/A 21.5英寸一体电脑\";s:9:\"shopqishu\";s:1:\"1\";s:8:\"gonumber\";s:1:\"1\";s:8:\"time_add\";s:9:\"165947316\";}}','16792139119','1440728819.930','N','0');");

require("../../inc/footer.php");
?>