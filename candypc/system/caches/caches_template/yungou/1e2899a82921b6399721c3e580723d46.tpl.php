<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?>

<!DOCTYPE html>
<html>
<head><title>
	糖果兑换 - <?php echo $webname; ?>触屏版
</title>
<meta content="app-id=518966501" name="apple-itunes-app" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css?v=130715" rel="stylesheet" type="text/css" />
      <link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/login.css" rel="stylesheet" type="text/css" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/member.css?v=130726" rel="stylesheet" type="text/css" />
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery190.js" language="javascript" type="text/javascript"></script>
<script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/recharge.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">

<!-- 栏目页面顶部 -->

<!-- 内页顶部 -->

   <header class="g-header">
        <div class="head-l">
	        <a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>
        </div>
        <h2>糖果兑换</h2>
        
    </header>

    <div class="g-Total gray9">夺宝币：<span class="orange arial"><?php echo $member['money']; ?></span>元
      &nbsp;&nbsp;糖果：<span class="orange arial"><?php echo $money; ?></span>颗</div>
 <div>
    
            <section>
                <div class="registerCon">
                    <form action="<?php echo WEB_PATH; ?>/mobile/home/addduihuan" method="post">
                        <ul>
                            <li class="accAndPwd">
                                <dl><input id="txtAccount" type="text" placeholder="请输入兑换糖果数量" class="lEmail" name="dhnum" maxlength="20"><s class="rs4"></s></dl>
                                <dl>
                                    <input type="password" id="txtPassword" class="lPwd" placeholder="请输入糖果交换密码" name="password" maxlength="20">
                                    <s class="rs3"></s>
                                </dl>
                            </li>
                            <li><input type="submit" value="确认兑换" style="color: #ff0000"/></li>
                          <div class="g-Total gray9"><span class="orange arial">1</span>糖果=<span class="orange arial"><?php echo $jinri; ?></span>夺宝币</div>
                           </ul>
                       
                    </form>
             
                   
                </div>
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
