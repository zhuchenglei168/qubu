<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $key; ?></title>     
    <meta content="app-id=518966501" name="apple-itunes-app" />     
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0"/>
    <meta content="yes" name="apple-mobile-web-app-capable" />     
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />     
    <meta content="telephone=no" name="format-detection" />
    <link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css?" rel="stylesheet" type="text/css" />
	<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/single.css?" rel="stylesheet" type="text/css" />
	<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery190.js" language="javascript" type="text/javascript"></script>
	<script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/postlist.js" language="javascript" type="text/javascript"></script>
</head>
<body>
<div class="h5-1yyg-v1">
    
<!-- 栏目页面顶部 -->


 <header class="g-header">
	<div class="head-l">
		<a href="javascript:;" onclick="history.go(-1)" class="z-HReturn"><s></s><b>返回</b></a>
	</div>
	<h2>晒单详细</h2>
	<div class="head-r">
		<a href="<?php echo WEB_PATH; ?>/mobile/mobile" class="z-Home"></a>
	</div>
</header>

<!-- 内页顶部 -->

        <section class="clearfix g-share-lucky">        
			<!-- <s class="z-Reward"></s> -->
			<a class="fl u-lucky-img" href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $shaidan['sd_userid']; ?>"><img border="0" alt="" src="<?php echo toujpg($shaidan['sd_userid']); ?>"> </a>
			<div class="u-lucky-r">
				<p>Winner：<a href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $shaidan['sd_userid']; ?>" class="z-user blue"><?php echo userid($shaidan['sd_userid'],'username'); ?></a></p>
				<?php 
				$jikxiao = get_shop_if_jiexiao($shaidan['sd_shopid']);	
				$q_end_time=date("Y-m-d H:i:s",$jikxiao['q_end_time']);
				 ?>
				<?php if($jikxiao['q_uid']): ?>
				<p>Lucky code：<em class="orange"><?php echo $jikxiao['q_user_code']; ?></em></p>
				<?php endif; ?>
				<p>Current period：<em class="orange"><?php echo get_user_goods_num($shaidan['sd_userid'],$shaidan['sd_shopid']); ?></em> Person time</p>
				<p>Opening time：<em class="arial"><?php echo $q_end_time; ?></em></p> 
				
			</div>                
        </section>
        <!-- 热门推荐 -->
        <section class="clearfix g-share-ct">		
	        <b class="z-aw-es z-arrow"></b>	
	        <article class="m-share-con">
		        <h2><?php echo $shaidan['sd_title']; ?></h2>
		        <em class="arial"><?php echo date("Y-m-d H:i",$shaidan['sd_time']); ?></em>
		        <p class="z-share-pad" id="shareContent"><?php echo $shaidan['sd_content']; ?></p>
				<?php 
					$pic_list=explode(";",$shaidan['sd_photolist']);
					for($i=0;$i<count($pic_list)-1;$i++){
						echo '<p><img src="'.G_UPLOAD_PATH.'/'.$pic_list[$i].'" border="0" alt="" ></p>';
					}
				 ?>		        
	        </article>	        
			<!-- <aside class="clearfix m-share-goods" onclick="location.href='/lottery/detail-17474.html'">
				<h3 class="fl">获得的商品</h3>
				<a class="fl u-goods-img" href="javascript:void(0)"><img border="0" alt="" src="http://mimg.1yyg.com/GoodsPic/Pic-200-200/20130528150540192.jpg"></a>
				<div class="u-goods-r">
					<p class="z-goods-tt"><a href="javascript:void(0)" class="gray6">(第78期)羽博（Yaoboo）YB-637 移动电源</a></p>
					<p>价值：<em class="arial">￥178.00</em></p>
				</div>
				<a href="/lottery/detail-17474.html" class="u-rs-m1"><b class="z-arrow"></b></a>
			</aside> -->
            <div class="m-share-fixed">
                <div id="CommentNav"> 
                    <div class="m-share-btn">
                        <div id="divtest" class="u-btn-w"><a id="emHits" class="z-btn-mood"><s></s>羡慕嫉妒恨(<em><?php echo $shaidan['sd_zhan']; ?></em>)</a></div>
                        <div class="u-btn-w"><a id="btnComment" href="javascript:void(0);" class="z-btn-comment"><s></s>我要评论</a></div>
                        <div class="u-btn-w"><a id="btnShare" href="javascript:void(0);" class="z-btn-Share"><s></s>分享</a></div>
                    </div>
                    <div class="m-comment" style="display:none;">
                        <div class="u-comment ">
                            <textarea name="comment" id="comment" rows="3" class="z-comment-txt" ></textarea>
                        </div>
                        <div class="u-Btn">
                            <div class="u-Btn-li"><a id="btnCancel" href="javascript:;" class="z-CloseBtn">取 消</a></div>
                            <div class="u-Btn-li"><a id="btnPublish" href="javascript:;" class="z-DefineBtn">发表评论</a></div>
                        </div>
                    </div>
                    <div class="m-shareT-round"></div>
                </div>
                <div id="fillDiv" style="display:none;"></div>
            </div>        
            <article class="m-share-comment m-round">
                <h3>共<span id="ReplyCount"  class="z-user orange"><?php echo $shaidan['sd_ping']; ?></span>条评论</h3>
                <ul id="replyList">
					<?php $ln=1;if(is_array($shaidan_hueifu)) foreach($shaidan_hueifu AS $sdhf): ?>
					<li>
						<a class="fl u-comment-img" href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $sdhf['sdhf_userid']; ?>">
							<?php if(userid($sdhf['sdhf_userid'],'img')==null): ?>
							<img src="<?php echo G_TEMPLATES_STYLE; ?>/images/prmimg.jpg"  />
							<?php  else: ?>
							<img id="imgUserPhoto" src="<?php echo G_UPLOAD_PATH; ?>/<?php echo userid($sdhf['sdhf_userid'],'img'); ?>"  border="0"/>
							<?php endif; ?>		
						</a>
						<div class="u-comment-r">
							<p class="z-comment-name"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $sdhf['sdhf_userid']; ?>" class="blue"><?php echo userid($sdhf['sdhf_userid'],'username'); ?></a></p>
							<p class="gray6"><span><?php echo $sdhf['sdhf_content']; ?></span><b><?php echo date("Y-m-d H:i",$sdhf['sdhf_time']); ?></b></p>
						</div>
					</li>
					<?php  endforeach; $ln++; unset($ln); ?>
				</ul>
                <!-- <a id="btnLoadMore" class="loading" href="javascript:void(0);" style="display:none;">点击加载更多</a>
                <div id="divLoading" class="loading"style="display:none;"><b></b>正在加载</div> -->
            </article>
        </section>

<?php include templates("mobile/index","footer");?>

<script language="javascript" type="text/javascript">
$(function(){
	//返回顶部
	$(window).scroll(function(){
		if($(window).scrollTop()>50){
			$("#btnTop").show();
		}else{
			$("#btnTop").hide();
		}
	});
	$("#btnTop").click(function(){
		$("body").animate({scrollTop:0},10);
	});	
	function addsuccess(dat){
		$("#pageDialogBG .Prompt").text("");
		var w=($(window).width()-255)/2,
			h=($(window).height()-45)/2;
		$("#pageDialogBG").css({top:h,left:w,opacity:0.8});
		$("#pageDialogBG").stop().fadeIn(1000);
		$("#pageDialogBG .Prompt").append('<s></s>'+dat);
		$("#pageDialogBG").fadeOut(1000);
	}
	//展开发表评论
	$("#btnComment").click(function(){
		if('<?php echo $member; ?>'){
			$(".m-comment").show();
		}else{
			addsuccess('请登录!');
		}		
	});
	//取消发表
	$("#btnCancel").click(function(){
		$(".m-comment").hide();
	});
	//发表评论
	$("#btnPublish").click(function(){
		var c=$("#comment").val();
		if(!c){
			addsuccess('不能为空!');
		}else if(c.length<3){
			addsuccess('字符不能少于3个!');
		}else{
			$.post(
				"<?php echo WEB_PATH; ?>/mobile/shaidan/plajax",
				{count:c,sd_id:"<?php echo $shaidan['sd_id']; ?>"},
				function(data){
					if(data==1){
						addsuccess('回复成功');
						//window.location.reload(); 
					}else{
						addsuccess('回复失败!');
					}
					$(".m-comment").hide();
				}
			);
		}
	});
	//读取cookies 
	function getCookie(name){ 
		var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");	 
		if(arr=document.cookie.match(reg))	 
			return unescape(arr[2]); 
		else 
			return null; 
	} 
	//羡慕嫉妒恨
	if(getCookie('xianmu')==<?php echo $shaidan['sd_id']; ?>){
		$("#emHits").addClass("z-btn-moodgray");
	}
	$("#emHits").click(function(){	
		if(getCookie('xianmu')==<?php echo $shaidan['sd_id']; ?>){
			$("#emHits").addClass("z-btn-moodgray");
			return false;
		}
		$.post(
			"<?php echo WEB_PATH; ?>/mobile/shaidan/xianmu",
			{id:"<?php echo $shaidan['sd_id']; ?>"},
			function(data){
				$("#emHits em").text(data);
				$("#emHits").addClass("z-btn-moodgray");
				$.cookie("xianmu","<?php echo $shaidan['sd_id']; ?>", { expires:7,path: '/'});
			}
		);
	});
	//分享
	$("#btnShare").click(function(){
		var w=($(window).width()-300)/2,
			h=($(window).height()-100)/2;
		$("#pageDialog").css({top:h,left:w});
		$("#pageDialog").show();
	});
	$("#btnMsgCancel").click(function(){
		$("#pageDialog").hide();
	});
	$("#shareType li").click(function(){
		var n=$(this).index();
		$(".jiathis_style a").eq(n).click();
	});
})
</script>
</div>
</body>
</html>

<style>
#pageDialogBG{-webkit-border-radius:5px; width:255px;height:45px;color:#fff;font-size:16px;text-align:center;line-height:45px;}

</style>
<div id="pageDialogBG" class="pageDialogBG">
<div class="Prompt"></div>
</div>
<div id="pageDialog" class="pageDialog" style="width:300px; height:100px; position: fixed; display: none;">
	<div class="clearfix m-round f-share-tips"><div class="f-share-tit">请选择以下方式分享</div>
	<a id="btnMsgCancel" href="javascript:void(0)" class="f-share-Close"></a>
	<ul id="shareType" class="f-share-li">
		<li><a href="javascript:void(0);"><b class="z-sina"><s></s></b><em>新浪微博</em></a></li>
		<li><a href="javascript:void(0);"><b class="z-qq"><s></s></b><em>腾讯微博</em></a></li>
		<li><a href="javascript:void(0);"><b class="z-qzone"><s></s></b><em>QQ空间</em></a></li>
	</ul>
	<!-- JiaThis Button BEGIN -->
	<div class="jiathis_style" style="display:none;">	
		<a class="jiathis_button_tsina"></a>
		<a class="jiathis_button_tqq"></a>
		<a class="jiathis_button_qzone"></a>
	</div>
	<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1383891407386925" charset="utf-8"></script>
	<!-- JiaThis Button END -->
	</div> 
</div>