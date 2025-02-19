<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>晒单 - <?php echo $webname; ?>触屏版</title>     
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

<?php include templates("mobile/index","header");?>


<!-- 内页顶部 -->

    
    <div id="navBox" class="g-snav m_listNav">
        <div class="g-snav-lst z-sgl-crt"><a href="javascript:;" class="gray9">latest</a><b></b></div>
        <div class="g-snav-lst"><a href="javascript:;" class="gray9">popularity</a><b></b></div>
        <div class="g-snav-lst"><a href="javascript:;" class="gray9">most</a></div>
    </div>

    <!-- 晒单列表 -->
    <section>	
		<div class="cSingleCon" id="loadingPicBlock">
		    <div id="postBox10" class="cSingleCon2"></div>
        </div>
		<div id="postLoading" class="loading loading2"><b></b>Loading</div>
        <a id="btnLoadMore" class="loading" href="javascript:;" style="display:none;">Click to load more</a>
		<a id="btnLoadMore2" class="loading"  style="display:none;">no data</a>
        <a id="btnLoadMore3" class="loading"  style="display:none;">It's all over</a>
    </section> 
	<input id="urladdress" value="" type="hidden" />
    <input id="pagenum" value="" type="hidden" />
<?php include templates("mobile/index","footer");?>

<script language="javascript" type="text/javascript">
window.onload=function(){
	sdajax('new');
}
function sdajax(parm){	
	$("#urladdress").val('');
	$("#pagenum").val('');
	$.getJSON('<?php echo WEB_PATH; ?>/mobile/shaidan/shaidanajax/'+parm,function(data){	
		$("#postLoading").hide();
		if(data[0].sum){
			var fg=parm.split("/");
				$("#urladdress").val(fg[0]);
				$("#pagenum").val(data[0].page);
			for(var i=0;i<data.length;i++){
				var pic=data[i].sd_photolist.split(";");
				var t=new Date(data[i].sd_time);
				var div='<div class="cSingleInfo"><dl class="fl">';
					div+='<a href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/'+data[i].sd_userid+'">';
					div+='<img src="<?php echo G_UPLOAD_PATH; ?>/'+data[i].pic+'">';
					div+='<b></b></a></dl><div class="cSingleR m-round">';
					div+='<ul><li><em class="blue" id="'+data[i].sd_userid+'">'+data[i].user+'</em>';
					div+='<span><strong class="c9">：</strong>'+data[i].sd_title+'</span> ';
					div+='<h5>'+data[i].time+'</h5></li>';
					div+='<li><p>'+data[i].sd_content+'</p></li>';
					div+='<li class="maxImg"  id="'+data[i].sd_id+'">';
					for(var x=0;x<pic.length-1;x++){
						div+='<img src="<?php echo G_UPLOAD_PATH; ?>/'+pic[x]+'">';
					}
					div+='</li>';
					div+='<li><dd><s></s>Envied by <strong>'+data[i].sd_zhan+'</strong> people</dd>';
					div+='<dd><i></i><strong>'+data[i].sd_ping+'</strong> comments</dd>';
					div+='</li></ul><b class="z-arrow"></b></div></div>';
				$(".cSingleCon2").append(div);
			}
			if(data[0].page<=data[0].sum){
				$("#btnLoadMore").css('display','block');
				$("#btnLoadMore2").css('display','none');
				$("#btnLoadMore3").css('display','none');
			}else if(data[0].page>data[0].sum){
				$("#btnLoadMore").css('display','none');
				$("#btnLoadMore2").css('display','none');
				$("#btnLoadMore3").css('display','block');
			}
		}else{
			$("#btnLoadMore").css('display','none');
			$("#btnLoadMore2").css('display','block');	
			$("#btnLoadMore3").css('display','none');			
		}
	})
}
$(function(){
	$("#navBox div").click(function(){
		$(".cSingleCon2 div").remove();
		e=$(this).index();
		$("#navBox div").removeClass('z-sgl-crt').eq(e).addClass('z-sgl-crt');
		switch(e){
			case 0:
			sdajax('new');
			break;
			case 1:
			sdajax('renqi');
			break;
			case 2:
			sdajax('pinglun');
			break;
		}
	});
	//加载更多
	$("#btnLoadMore").click(function(){		
		var url=$("#urladdress").val(),
			page=$("#pagenum").val();
		sdajax(url+'/'+page);
	});
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
	//跳转页面
	var gt='.cSingleInfo .maxImg';
	$(document).on('click',gt,function(){
		var id=$(this).attr('id');
		if(id){
			window.location.href="<?php echo WEB_PATH; ?>/mobile/shaidan/detail/"+id;
		}			
	});
	$(document).on('click','.cSingleInfo .blue',function(){
		var id=$(this).attr('id');
		if(id){
			window.location.href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/"+id;
		}	
	});	
})
</script>

</div>
</body>
</html>