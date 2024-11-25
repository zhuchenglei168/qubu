<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
  <head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="renderer" content="webkit">
    <title><?php echo $webname; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css" rel="stylesheet" type="text/css" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/index.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo G_TEMPLATES_CSS; ?>/mobile/reset.css">
<link rel="stylesheet" href="<?php echo G_TEMPLATES_CSS; ?>/mobile/animate.css">
<link rel="stylesheet" href="<?php echo G_TEMPLATES_CSS; ?>/mobile/style.css">
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/main.css" rel="stylesheet" type="text/css">



<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/js.cookie.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/lodash.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/response.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/swiper.min.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/countdown.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/simpop.min.js"></script>
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery.lazyload.min.js"></script>
<script>
var DuoBao = {};
var __data__ = (function(){
  return JSON.parse('{}');
})();
var __user__ = (function(){
  return JSON.parse('{}');

})();
var __touchorclick__ = (function(){
  if ('ontouchend' in document)
    return 'touchend';
  else
    return 'click';
})();
</script>
</head>
  <style>
    .img-topright {
      padding-right: 0.8rem;
      padding-top: 1rem;
      height: 3.5rem;
      width: auto;
      float: right;
    }
  </style>

  <body >
<?php include templates("mobile/index","header");?>
    <div class="container">
<main class="db-main db-main-index">
<style type="text/css">
.zxjx>a:link, .zxjx>a:visited, .zxjx>a:hover, .zxjx>a:active,
.tabs>a:link, .tabs>a:visited, .tabs>a:hover, .tabs>a:active {
    color: #323232;
}
.tab_selected {
    color: #ff5151;
    border-bottom: 3px solid #ff5151;
}
.color_blue {
    color: #2a99e0;
}
.btn_buy {
    font-size: 1rem;
    border-radius: 0.3rem;
    border: 1px solid #ff5151;
    color: #ff5151;
    text-align: center;
    padding: 0.5rem 0.3rem;
}
.item_bottom_container {
   overflow: hidden;
   padding: 0 5%;
   margin-top: 0.8rem;
   font-size: 1rem;
}
.jdt_container {
    float: left;
    width: 60%;
}
.jdt_container div {
    color: #646464;
}
.buy_container {
    float: left;
    width: 40%;
    text-align: center;
}
.tab_load_more {
    text-align: center;
    color: #868686;
    font-size: 1.2rem;
    padding: 0.8rem 0rem 0rem;
}
</style>
    <!-- 焦点图 -->
    <div class="swiper-container">
      <div class="swiper-wrapper">
       <?php $ln=1;if(is_array($shop_ad)) foreach($shop_ad AS $ad): ?>
        <div class="swiper-slide swiper-slide-active">
          <a href="<?php echo $ad['link']; ?>">
            <img alt="<?php echo $ad['title']; ?>" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $ad['img']; ?>">
          </a>
        </div>
        <?php  endforeach; $ln++; unset($ln); ?>  
      </div>
      <div class="swiper-pagination swiper-pagination-clickable"><span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span><span class="swiper-pagination-bullet"></span></div>
    </div>
    <script> 
    var mySwiper = new Swiper('.swiper-container', {
      autoplay: 5000,//可选选项，自动滑动
      pagination : '.swiper-pagination',
      paginationClickable :true,
    })
    </script>
  <div class="zxjx">
    <a href="<?php echo WEB_PATH; ?>/mobile/mobile/lottery">The latest recent<label style="position:absolute; right:1rem; cursor:pointer">Show all&nbsp;></label></a>
    <ul class="ul ">
      <script>
        (function(){
          DuoBao.refresh_prize = function refresh_prize(){
            var $el = $($(this).data('dom_id'));
            $.get($el.attr('title'), {raw_only: 'true'}, function(data){
                $el.html(data);
            });
          };

        })();
      </script>
     <?php $ln=1; if(is_array($shopqishu)) foreach($shopqishu AS $k => $qishu): ?>
      <?php 
                  $qishu['q_user'] = unserialize($qishu['q_user']);
       ?>
      
      <li>
        <a href="<?php echo WEB_PATH; ?>/mobile/mobile/item/<?php echo $qishu['id']; ?>" id="r<?php echo $qishu['id']; ?>" title="<?php echo WEB_PATH; ?>/mobile/mobile/itemajax/<?php echo $qishu['id']; ?>">
          <div style="width:90%; margin-left:5%;">
            <img  style="width:90%; margin-left:5%;" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $qishu['thumb']; ?>"  class="lazy_loading_image">
          </div>
          <div class="txt" style="">
            <h6><?php echo _strcut($qishu['title'],20); ?></h6>
            <?php if($qishu['q_showtime']=='N'): ?>
            <div class="zj"><span>Winner</span><span style="color: #5bb6ea;"><?php echo get_user_name($qishu['q_uid'],'username'); ?></span></div>
            <?php  else: ?>
            <div class="zj">
            <div style="text-align:center; padding: 0.2rem;white-space: nowrap; text-overflow: ellipsis; overflow: hidden; background-color:#ff5151; color:#fff; border-radius:1rem;">
              <time class="countdown"
                style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden;"
                data-dom_id="#r<?php echo $qishu['id']; ?>"
                data-sec="<?php echo ceil($qishu['q_end_time']-time()); ?>"
                data-text="unveiling..."
                data-delay="1000"
                data-callback="DuoBao.refresh_prize">Start countdown</time>
            </div>
            </div>
            <?php endif; ?>
          </div>
        </a>
      </li>
       <?php  endforeach; $ln++; unset($ln); ?>
    </ul>
  </div>
  
  


  <div class="tabs-wrap" style="min-height:1000px;">
    <div class="zxjx">
      <a href="<?php echo WEB_PATH; ?>/mobile/mobile/glist" class="tab_selected" data-order_by='level'>The latest prize<label style="position:absolute; right:1rem; cursor:pointer">Show all&nbsp;></label></a>
    </div>
    <div class="tabs-content">
      <ul class="ul">
      <?php $ln=1;if(is_array($shoplistrenqi)) foreach($shoplistrenqi AS $renqi): ?>
           <li id="<?php echo $renqi['id']; ?>">
           <a id="prize_url" href="javascript:;" class="add1" codeid="<?php echo $renqi['id']; ?>" >
             <img style="display: block;" data-original="<?php echo G_UPLOAD_PATH; ?>/<?php echo $renqi['thumb']; ?>" id="prize_image" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $renqi['thumb']; ?>">
             <h6 id="prize_title"><?php echo $renqi['title2']; ?></h6>
             <div class="item_bottom_container">
               <div class="jdt_container">
                 <div>speed of progress&nbsp;<label class="color_blue" id="jd"><?php echo percent($renqi['canyurenshu'],$renqi['zongrenshu']); ?></label></div>
                 <span class="jdt" style="margin-left:0rem;"><span style="width:<?php echo $renqi['canyurenshu']/$renqi['zongrenshu']*100; ?>%;"></span></span>
               </div>
               <div class="buy_container">
                 <?php if($renqi['money']==$renqi['yunjiage']): ?>
                 	<div class="btn_buy" style="background:#ff5151;color:#fff">
                 	BUY
                 	</div>
                 	<?php  else: ?>
                 	<div class="btn_buy">
                 	BUY
                 	</div>
                 	<?php endif; ?>
               </div>
             </div>
           </a>
         </li>
          <?php  endforeach; $ln++; unset($ln); ?>
      </ul>
 <script type="text/javascript">
      //打开页面加载数据
      window.onload=function(){
      	//购物车数量
      	$.getJSON('<?php echo WEB_PATH; ?>/mobile/ajax/cartnum',function(data){
      		if(data.num){
      			$("#btnCart").append('<em>'+data.num+'</em>');
      		}
      	});
      }
      	//添加到购物车
      	$(document).on("click",'.add1',function(){
      		var codeid=$(this).attr('codeid');
      		window.location.href="<?php echo WEB_PATH; ?>/mobile/mobile/item/"+codeid;	
      	});
</script>
	  
	  

<footer class="footer">

    </div>
  </div>
</main>
 <script src="<?php echo G_TEMPLATES_JS; ?>/mobile/main.js"></script> 
</div>
   <?php 
    $f_home = '';
    $f_whole = '';
    $f_jiexiao = '';
    $f_car = '';
    $f_personal = '';

    if( ROUTE_C == 'home' || ROUTE_C == 'user' ){
      $f_personal = 'cur';
    }else if( ROUTE_C == 'mobile' && ROUTE_A == 'init'){
      $f_home = 'cur';
    }else if( ROUTE_C == 'mobile' && ROUTE_A == 'glist'){
      $f_whole = 'cur';
    }else if( ROUTE_C == 'mobile' && ROUTE_A == 'lottery'){
      $f_jiexiao = 'cur';
    }else if( ROUTE_C == 'shaidan'){
      $f_car = 'cur';
    }
    ?>
   <p>
    <br />
   </p>
   <p>
    <br />
   </p>
   <p>
    <br />
   </p>
   <style>
   .footerdi .f_home i.cur{
    background-position: 0 0 !important;
   }
   .footerdi .f_whole i.cur{
    background-position: 0 -52px !important;
   }
   .footerdi .f_jiexiao i.cur{
    background-position: 0 -222px !important;
   }
   .footerdi .f_car i.cur{
    background-position: 0 -105px !important;
   }
   .footerdi .f_personal i.cur{
    background-position: 0 -152px !important;
   }
   </style>   
   <div class="footerdi" style="bottom: 0px;">
    <ul>
      <li class="f_home">
        <a title="Home" href="<?php echo WEB_PATH; ?>/mobile/mobile/"><i class="<?php echo $f_home; ?>">&nbsp;</i>Home</a>
      </li>
      <li class="f_whole">
        <a title="Prize" href="<?php echo WEB_PATH; ?>/mobile/mobile/glist"><i class="<?php echo $f_whole; ?>">&nbsp;</i>Prize</a>
      </li>
      <li class="f_jiexiao">
        <a title="Unveiling" href="<?php echo WEB_PATH; ?>/mobile/mobile/lottery"><i class="<?php echo $f_jiexiao; ?>">&nbsp;</i>Unveiling</a>
      </li>
      <li class="f_car">
        <a title="Share" href="<?php echo WEB_PATH; ?>/mobile/shaidan"><i class="<?php echo $f_car; ?>">&nbsp;</i>Share</a>
      </li>
      <li class="f_personal">
        <a title="Mine" href="<?php echo WEB_PATH; ?>/mobile/home"><i class="<?php echo $f_personal; ?>">&nbsp;</i>Mine</a>
      <li>
    </ul>
   </div>
  </body>
</html>
<style>
#pageDialogBG{-webkit-border-radius:5px; width:255px;height:45px;color:#fff;font-size:16px;text-align:center;line-height:45px;}
</style>
<div id="pageDialogBG" class="pageDialogBG">
<div class="Prompt"></div>
</div>


	  <style>
 .contact-public{
    position:fixed;
    right:0px;
    width:30px;
    padding:0;
    line-height:15px;
    border-radius:5px;
    background:rgba(255, 222, 173, 1);
    bottom:70px;
    text-align:center;
    color:#fff;
    z-index:2;
 }
.contact-public li{
   display:block;
   border-bottom:1px solid #7D7D7D;
   text-align:center;
               -webkit-box-sizing:border-box;
                  -moz-box-sizing:border-box;
                     -o-box-sizing:border-box;   
                        box-sizing:border-box;
}
.contact-public li:last-child{
   border-bottom:0;
   border-top:1px solid #242424;
}
.contact-public a{
   display:block;
   color:#FD94FC;
   font-size:16px;
   text-align:center;
   padding:6px;
}
.contact-public .icon-tel{
   display:block;
   margin:0px auto 0 auto;
   width:25px;
   height:20px;
   background:url("http://wfx.91dcw.com/weixin/images/distribution2.png") -200px -820px;
   background-size:300px 1000px;
}
</style>

 <script>
   wx.config({
     debug: false,
     appId: "<?php  echo $wechat['appid']; ?>",
     timestamp: <?php  echo $signPackage["timestamp"]; ?>,
     nonceStr: '<?php  echo $signPackage["nonceStr"]; ?>',
     signature: '<?php  echo $signPackage["signature"]; ?>',
   jsApiList: ["checkJsApi", "onMenuShareAppMessage", "onMenuShareTimeline", "onMenuShareWeibo", "onMenuShareQQ"]
   });
 wx.ready(function () {
 var n = $("#hidLineLink").val();
     wx.onMenuShareTimeline({
         title: "1元就能购买iphone6哦，快去看看吧！", // 分享标题
         link: n, // 分享链接
         imgUrl: "<?php echo G_TEMPLATES_STYLE; ?>/images/mobile/iphone6.jpg", // 分享图标
         success: function () { 
            alert('已分享');
         },
         cancel: function () { 
             alert('已取消');
         }
     });
     wx.onMenuShareAppMessage({
         title: "1元就能购买iphone6哦，快去看看吧！", // 分享标题
         desc: "1元就能购买iphone6哦，快去看看吧！", // 分享描述
         link: n, // 分享链接
         imgUrl: "<?php echo G_TEMPLATES_STYLE; ?>/images/mobile/iphone6.jpg", // 分享图标
         type: '', // 分享类型,music、video或link，不填默认为link
         dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
          success: function () { 
            alert('已分享');
         },
         cancel: function () { 
             alert('已取消');
         }
     });
     wx.onMenuShareQQ({
         title: "1元就能购买iphone6哦，快去看看吧！", // 分享标题
         desc: "1元就能购买iphone6哦，快去看看吧！", // 分享描述
         link: n, // 分享链接
         imgUrl: "<?php echo G_TEMPLATES_STYLE; ?>/images/mobile/iphone6.jpg", // 分享图标
         success: function () { 
            // 用户确认分享后执行的回调函数
         },
         cancel: function () { 
            // 用户取消分享后执行的回调函数
         }
     });
     wx.onMenuShareWeibo({
         title: "1元就能购买iphone6哦，快去看看吧！", // 分享标题
         desc: "1元就能购买iphone6哦，快去看看吧！", // 分享描述
         link: n, // 分享链接
         imgUrl: "<?php echo G_TEMPLATES_STYLE; ?>/images/mobile/iphone6.jpg", // 分享图标
         success: function () { 
            alert('已分享');
         },
         cancel: function () { 
             alert('已取消');
         }
     });
 });
 </script>