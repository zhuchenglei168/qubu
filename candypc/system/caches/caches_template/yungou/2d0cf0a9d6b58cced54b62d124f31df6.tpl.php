<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?>

<!DOCTYPE html>

<html>

<head><title>

	账户明细 - <?php echo $webname; ?>触屏版

</title><meta content="app-id=518966501" name="apple-itunes-app" /><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" /><meta content="yes" name="apple-mobile-web-app-capable" /><meta content="black" name="apple-mobile-web-app-status-bar-style" /><meta content="telephone=no" name="format-detection" />

<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css" rel="stylesheet" type="text/css" />

<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/member.css" rel="stylesheet" type="text/css" />

<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery190.js" language="javascript" type="text/javascript"></script>

<script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/consumptionlist.js" language="javascript" type="text/javascript"></script>

</head>

<body>

<div class="h5-1yyg-v1" id="loadingPicBlock">

    <input name="loadDataType" type="hidden" id="loadDataType" value="0" />

    

<!-- 栏目页面顶部 -->





<!-- 内页顶部 -->



    <header class="g-header">

        <div class="head-l">

	        <a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>

        </div>

        <h2>帐户明细</h2>

        <div class="head-r">

	        <a href="<?php echo WEB_PATH; ?>/mobile/home" class="z-Member"></a>

        </div>

    </header>



    <section class="clearfix g-member">

	    <article class="clearfix m-round g-userMoney">

		    <a href="<?php echo WEB_PATH; ?>/mobile/home/userrecharge" class="z-Recharge-btn">去充值</a>当前夺宝币<span class="orange"><?php echo $member['money']; ?></span>

	    </article>

	    <article class="mt10 m-round">

		    <ul class="m-userMoneyNav">

			    <li><a id="btnConsumption" href="javascript:;"><b>消费明细</b>(消费总金额：<?php echo $xfsum; ?>)</a><s></s></li>

			    <li><a id="btnRecharge" href="javascript:;"><b>充值明细</b>(充值总金额：<?php echo $czsum; ?>)</a></li>

		    </ul>

		    

		    <ul id="ulConsumption" class="m-userMoneylst m-Consumption">

		    </ul>

		    <ul id="ulRechage" class="m-userMoneylst" style="display:none;">

		    </ul>

		    <div id="divLoad" class="loading"><b></b>正在加载</div>

		    <a id="btnLoadMore" class="loading" href="javascript:;" style="display:none;">点击加载更多</a>

	    </article>

    </section>

    

<?php include templates("mobile/index","footer");?>

<script language="javascript" type="text/javascript">

  var Path = new Object();

  Path.Skin="<?php echo G_TEMPLATES_STYLE; ?>";  

  Path.Webpath = "<?php echo WEB_PATH; ?>";

  

var Base={head:document.getElementsByTagName("head")[0]||document.documentElement,Myload:function(B,A){this.done=false;B.onload=B.onreadystatechange=function(){if(!this.done&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){this.done=true;A();B.onload=B.onreadystatechange=null;if(this.head&&B.parentNode){this.head.removeChild(B)}}}},getScript:function(A,C){var B=function(){};if(C!=undefined){B=C}var D=document.createElement("script");D.setAttribute("language","javascript");D.setAttribute("type","text/javascript");D.setAttribute("src",A);this.head.appendChild(D);this.Myload(D,B)},getStyle:function(A,B){var B=function(){};if(callBack!=undefined){B=callBack}var C=document.createElement("link");C.setAttribute("type","text/css");C.setAttribute("rel","stylesheet");C.setAttribute("href",A);this.head.appendChild(C);this.Myload(C,B)}}
function GetVerNum(){var D=new Date();return D.getFullYear().toString().substring(2,4)+'.'+(D.getMonth()+1)+'.'+D.getDate()+'.'+D.getHours()+'.'+(D.getMinutes()<10?'0':D.getMinutes().toString().substring(0,1))}
Base.getScript('<?php echo G_TEMPLATES_JS; ?>/mobile/Bottom.js?v='+GetVerNum());

</script>



</div>

</body>

</html>

