<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?>﻿<!DOCTYPE html>

<html>

<head><meta content="text/html; charset=utf-8" http-equiv="Content-Type" />

<title><?php echo $key; ?></title>

<meta content="app-id=518966501" name="apple-itunes-app" /><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" /><meta content="yes" name="apple-mobile-web-app-capable" /><meta content="black" name="apple-mobile-web-app-status-bar-style" /><meta content="telephone=no" name="format-detection" /><link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css" rel="stylesheet" type="text/css" /><link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/goods.css" rel="stylesheet" type="text/css" /><script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery190.js" language="javascript" type="text/javascript"></script><script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/BuyRecord.js" language="javascript" type="text/javascript"></script></head>

<body>

<div class="h5-1yyg-v1" id="loadingPicBlock">

    

<!-- 栏目页面顶部 -->





<!-- 内页顶部 -->



    <header class="g-header">

        <div class="head-l">

	        <a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>

        </div>

        <h2><?php echo $key; ?></h2>

        <div class="head-r">

	        <a id="btnSort" href="javascript:;" class="z-sort"><i></i>排序<s class="z-SswOn"></s><s class="z-SswNt"></s></a>

        </div>

    </header>



    <input name="hidCodeID" type="hidden" id="hidCodeID" value="18101" />

    <input name="hidIsEnd" type="hidden" id="hidIsEnd" value="1" />



    <!-- 梦想购记录 -->

    <section id="buyRecordPage" class="goodsCon">

        <div id="divRecordList" class="recordCon z-minheight" style="display:block; height:auto;">

	<?php if($co < 1): ?>

		<div id="divNone" class="haveNot z-minheight" style="display:block"><s></s><p>抱歉，暂时还没有记录！</p></div>

	  <?php  else: ?>

           <?php $ln=1;if(is_array($cords)) foreach($cords AS $c): ?> 

			<ul>

				<li class="rBg"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $c['uid']; ?>">

					<img id="imgUserPhoto" src="<?php echo get_user_key($c['uid'],'img'); ?>"   border="0"/>

					<s></s></a>

				</li>

				<li class="rInfo"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $c['uid']; ?>"><?php echo userid($c['uid'],'username'); ?></a>

					<strong><?php if($c['ip']): ?>

							(<?php echo get_ip($c['id'],'ipcity'); ?> IP:<?php echo get_ip($c['id'],'ipmac'); ?>)

							<?php endif; ?></strong><br>

					<span><?php echo _cfg('web_name_two'); ?>了<b class="orange"><?php echo $c['gonumber']; ?></b>人次</span><em class="arial"><?php echo date("Y-m-d H:i:s",$c['time']); ?></em>

				</li><i></i>

			</ul>

		   <?php  endforeach; $ln++; unset($ln); ?>

	<?php endif; ?>

        </div>

    </section>



    

<?php include templates("mobile/index","footer");?>



</div>

</body>

</html>
