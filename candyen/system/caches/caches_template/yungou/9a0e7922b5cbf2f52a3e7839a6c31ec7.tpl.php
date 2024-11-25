<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>
	<?php echo $key; ?>
</title><meta content="app-id=518966501" name="apple-itunes-app" /><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" /><meta content="yes" name="apple-mobile-web-app-capable" /><meta content="black" name="apple-mobile-web-app-status-bar-style" /><meta content="telephone=no" name="format-detection" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/comm.css?v=20150129" rel="stylesheet" type="text/css" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/goods.css" rel="stylesheet" type="text/css" />
<link href="<?php echo G_TEMPLATES_CSS; ?>/mobile/top.css" rel="stylesheet" type="text/css" />
<script src="<?php echo G_TEMPLATES_JS; ?>/mobile/jquery190.js" language="javascript" type="text/javascript"></script>
<?php if($shopitem=='itemfun'): ?>
	<script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/goodsInfo.js" language="javascript" type="text/javascript"></script>
<?php  else: ?>
<script id="pageJS" data="<?php echo G_TEMPLATES_JS; ?>/mobile/LotteryDetail.js" language="javascript" type="text/javascript"></script>
<?php endif; ?>
</head>
<body>
<div class="h5-1yyg-v1" id="loadingPicBlock">

<!-- 栏目页面顶部 -->


<!-- 内页顶部 -->

<?php include templates("mobile/index","top");?>
<!-- 内页顶部 -->

    <input name="hidGoodsID" type="hidden" id="hidGoodsID" value="<?php if($itemlist): ?><?php echo $itemlist['0']['q_uid']; ?><?php endif; ?>"/>   <!--上期获奖者id-->
    <input name="hidCodeID" type="hidden" id="hidCodeID" value="<?php echo $item['id']; ?>"/>     <!--本期奖品id-->
    <section class="goodsCon pCon">
	    <!-- 导航 -->
        <div id="divPeriod" class="pNav">
            <div class="loading"><b></b>Loading...</div>
    	    <ul class="slides">
    	       <?php echo $loopqishu; ?>
            </ul>
        </div>

		<?php 
            $sysj=$item['xsjx_time']-time();
         ?>


        <!-- 揭晓信息 -->
        <?php if($item['q_end_time']!='' && $item['q_end_time'] <= time() && $item['money']!=$item['yunjiage']): ?>
        <div class="pProcess pProcess2">
    	    <div class="pResults">
        	    <div class="pResultsL" onclick="location.href='<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $item['q_uid']; ?>'">
            	    <a>
            	        <img src="<?php echo get_user_key($item['q_uid'],'img'); ?>">
            	        <span><?php echo get_user_name($item['q_uid']); ?></span>
            	    </a>
                    <s></s>
                </div>
        	    <div class="pResultsR">
                    <div class="g-snav">
                        <div class="g-snav-lst">All<br><dd><b class="orange"><?php echo $gorecode['gonumber']; ?></b><br></dd></div>
                        <div class="g-snav-lst">Unveiling time<br><dd class="gray9"><span><?php echo str_replace(' ','<br>',microt($item['q_end_time'])); ?></span></dd></div>
                        <div class="g-snav-lst">Purchase time<br><dd class="gray9"><span><?php echo str_replace(' ','<br>',microt($gorecode['time'])); ?></span></dd></div>
                    </div>
                </div>
        	    <p><a href="<?php echo WEB_PATH; ?>/mobile/mobile/calResult/<?php echo $item['id']; ?>" class="fr">Calculation results</a>Lucky code：<b class="orange"><?php echo $item['q_user_code']; ?></b></p>
            </div>
        </div>
        <?php endif; ?>

		<!-- 揭晓倒计时 -->
		<?php if(( $item['q_end_time']!='' && $item['q_end_time'] > time()  && $item['money']!=$item['yunjiage']) ): ?>
			<div id="divLotteryTime" class="pProcess clearfix" data-id="<?php echo $item['id']; ?>" data-endtime="<?php echo ceil($item['q_end_time']-time()); ?>">
				<div class="pCountdown">
					<div class="g-snav">
						<div class="g-snav-lst">Unveiling<br>count down<s></s></div>
						<div class="g-snav-lst"><b class="minute">99</b><em>:</em></div>
						<div class="g-snav-lst"><b class="second">99</b><em>:</em></div>
						<div class="g-snav-lst"><b class="millisecond">99</b><em></em></div>
					</div>
				</div>
			</div>
        <?php endif; ?>

        <!-- 产品图 -->
        <div class="pPic pPicBor">
            <div class="pPic2">
    	        <div id="sliderBox" class="pImg">
                    <div class="loading"><b></b>Loading</div>
                    <ul class="slides">
					<?php $ln=1;if(is_array($item['picarr'])) foreach($item['picarr'] AS $imgtu): ?>
					<li><img src="<?php echo G_UPLOAD_PATH; ?>/<?php echo $imgtu; ?>" class="animClass" /></li>
					<?php  endforeach; $ln++; unset($ln); ?>
                    </ul>
                </div>
            </div>
			<?php if($item['q_end_time']=='' && $item['xsjx_time']!=0): ?>
            <span id="spAutoFlag" class="z-limit-tips">Time limited unveiling</span>
			 <?php endif; ?>
        </div>

        <!-- 条码信息 -->


        <div class="pDetails <?php if($item['q_end_time']!=''): ?>pDetails-end<?php endif; ?>">
                <b>(Phase <?php echo $item['qishu']; ?>)<?php echo $item['title2']; ?> <span></span></b>
                <p class="price">Price：<em class="arial gray">$<?php echo $item['money']; ?></em></p>

			<?php if(empty($item['q_end_time'])): ?>
				<div class="Progress-bar">
					<p class="u-progress" title="<?php echo percent($item['canyurenshu'],$item['zongrenshu']); ?>">
						<span class="pgbar" style="width:<?php echo $item['canyurenshu']/$item['zongrenshu']*100; ?>%;">
							<span class="pging"></span>
						</span>
					</p>
					<ul class="Pro-bar-li">
						<li class="P-bar01"><em><?php echo $item['canyurenshu']; ?></em>Participated</li>
						<li class="P-bar02"><em><?php echo $item['zongrenshu']; ?></em>ALL Needed</li>
						<li class="P-bar03"><em><?php echo $item['zongrenshu']-$item['canyurenshu']; ?></em>surplus</li>
					</ul>
				</div>
			<?php endif; ?>
			<?php if($item['q_end_time'] !=''): ?>
				<?php if($item['q_end_time'] > time() ): ?>
				  <div class="pClosed">Unveiling</div>
				<?php  else: ?>
				  <div class="pClosed">Unveiled</div>
				<?php endif; ?>
				<?php if($itemxq==1): ?>
				<div class="pOngoing" codeid="<?php echo $itemzx['id']; ?>">Phase <em class="arial"><?php echo $itemzx['qishu']; ?></em> In progress<span class="fr">Detail</span></div>
				<?php endif; ?>
           	<?php elseif ($item['zongrenshu']==$item['canyurenshu']): ?>
			  <?php if($item['xsjx_time']!=0): ?>
               <div id="divAutoRTime" class="pSurplus" time="<?php echo $sysj; ?>" timeAlt="<?php echo date('Y-m-d-H',$item['xsjx_time']); ?>"><p><span>Time limited unveiling</span>Time remaining：<em>00</em>:<em>00</em>:<em>00</em></p></div>
			   <?php endif; ?>
               <div class="pClosed">It's empty</div>
		    <?php  else: ?>
               <?php if($item['xsjx_time']!=0): ?>
			  <div id="divAutoRTime" class="pSurplus" time="<?php echo $sysj; ?>" timeAlt="<?php echo date('Y-m-d-H',$item['xsjx_time']); ?>"><p><span>Time limited unveiling</span>Time remaining：<em>00</em>:<em>00</em>:<em>00</em></p></div>
			  <?php endif; ?>
              <div id="btnBuyBox" class="pBtn" codeid="<?php echo $item['id']; ?>">
              		<?php if($item['money']==$item['yunjiage']): ?>
                 		<a href="javascript:;" class="fl buyBtn" style="width: 98%;">Buy</a>
                 	<?php  else: ?>
                 		<a href="javascript:;" class="fl buyBtn">Buy</a>
				<a href="javascript:;" class="fr addBtn">Add to cart</a>
                 	<?php endif; ?>
				
			  </div>
			<?php endif; ?>
        </div>
        <!-- 参与记录，奖品详细，晒单导航 -->
        <div class="joinAndGet">
    	    <dl>
    	        

				<a href="<?php echo WEB_PATH; ?>/mobile/mobile/goodspost/<?php echo $item['sid']; ?>"><b class="fr z-arrow"></b>already existing <span class="orange arial"><?php echo count($shaidan); ?></span> lucky people share<strong class="orange arial"><?php echo $sum; ?></strong> comments</a>
                                                    <a href="<?php echo WEB_PATH; ?>/mobile/mobile/goodsdesc/<?php echo $item['id']; ?>"><b class="fr z-arrow"></b>Graphic details<em>(recommended for WiFi)</em> </a>
				<a href="<?php echo WEB_PATH; ?>/mobile/mobile/buyrecords/<?php echo $item['id']; ?>"><b class="fr z-arrow"></b>All purchase records</a>
            </dl>
        <!-- 上期获得者 -->
		<?php if($item['q_end_time'] !=''): ?>
			<?php if(( $item['q_end_time']!='' && $item['q_end_time'] > time() ) ): ?>
			<?php  else: ?>
				<ul id="prevPeriod" class="m-round" codeid="<?php echo $gorecode['shopid']; ?>" uweb="<?php echo $gorecode['uid']; ?>">
        	    <li class="fl"><s></s><img src="<?php echo G_TEMPLATES_IMAGE; ?>/mobile/loading.gif" src2="<?php echo get_user_key($itemlist[0]['q_uid'],'img'); ?>"/></li>
                <li class="fr"><b class="z-arrow"></b></li>
                <li class="getInfo">
            	    <dd>
					<em class="blue"><?php echo get_user_name($itemlist[0]['q_uid']); ?></em>(<?php echo get_ip($gorecode['id'],'ipcity'); ?>) 
					</dd>
                    <dd>Total purchases：<em class="orange arial"><?php echo $gorecode['gonumber']; ?></em>人次</dd>
                    <dd>Lucky purchase code：<em class="orange arial"><?php echo $gorecode['huode']; ?></em></dd>
                    <dd>Opening time：<?php echo microt($itemlist[0]['q_end_time']); ?></dd>								   
                    <dd>Purchase time：<?php echo microt($gorecode['time']); ?></dd>
                </li>
            </ul>
			 <?php endif; ?>
			<?php endif; ?>

        </div>
    </section>

<?php include templates("mobile/index","footer");?>
<script language="javascript" type="text/javascript">
  var Path = new Object();
  Path.Skin="<?php echo G_TEMPLATES_STYLE; ?>";
  Path.Webpath = "<?php echo WEB_PATH; ?>";

var Base = {
    head: document.getElementsByTagName("head")[0] || document.documentElement,
    Myload: function(B, A) {
        this.done = false;
        B.onload = B.onreadystatechange = function() {
            if (!this.done && (!this.readyState || this.readyState === "loaded" || this.readyState === "complete")) {
                this.done = true;
                A();
                B.onload = B.onreadystatechange = null;
                if (this.head && B.parentNode) {
                    this.head.removeChild(B)
                }
            }
        }
    },
    getScript: function(A, C) {
        var B = function() {};
        if (C != undefined) {
            B = C
        }
        var D = document.createElement("script");
        D.setAttribute("language", "javascript");
        D.setAttribute("type", "text/javascript");
        D.setAttribute("src", A);
        this.head.appendChild(D);
        this.Myload(D, B)
    },
    getStyle: function(A, B) {
        var B = function() {};
        if (callBack != undefined) {
            B = callBack
        }
        var C = document.createElement("link");
        C.setAttribute("type", "text/css");
        C.setAttribute("rel", "stylesheet");
        C.setAttribute("href", A);
        this.head.appendChild(C);
        this.Myload(C, B)
    }
}
function GetVerNum() {
    var D = new Date();
    return D.getFullYear().toString().substring(2, 4) + '.' + (D.getMonth() + 1) + '.' + D.getDate() + '.' + D.getHours() + '.' + (D.getMinutes() < 10 ? '0': D.getMinutes().toString().substring(0, 1))
}
Base.getScript('<?php echo G_TEMPLATES_JS; ?>/mobile/Bottom.js');


</script>
<script>
$(function(){
	<?php if($itemlist): ?>
  $(".blue").click(function(){
	 window.location.href="<?php echo WEB_PATH; ?>/mobile/mobile/userindex/<?php echo $itemlist['0']['q_uid']; ?>";
  });

  $(".orange.arial").click(function(){
	 window.location.href="<?php echo WEB_PATH; ?>/mobile/mobile/dataserver/<?php echo $itemlist['0']['id']; ?>";
  });
  <?php endif; ?>

	// 揭晓倒计时
	var divLotteryTime = $('#divLotteryTime');
	if ( divLotteryTime.size() > 0 ) {
		var id = divLotteryTime.attr('data-id');
		var minute = divLotteryTime.find('b.minute');
		var second = divLotteryTime.find('b.second');
		var millisecond = divLotteryTime.find('b.millisecond');
		var tips = minute.parent().prev();
		var times = (new Date().getTime()) + 1000 * divLotteryTime.attr('data-endtime');
		var timer = setInterval(function(){
			var time = times - (new Date().getTime());
			if ( time < 1 ) {
				clearInterval(timer);
				tips.css('line-height', '35px').css('color','#FF5152').html('刷新下，幸运者就是你！');
				minute.parent().remove();
				second.parent().remove();
				millisecond.parent().remove();

				var checker = function(){
					$.getJSON(Gobal.Webpath+"/api/getshop/lottery_shop_huode/"+new Date().getTime(),{'test':true,'gid':id},function(info){
						if ( info.error ) {
							tips.html('刷新下，幸运者就是你');
							setTimeout(checker,1000);
						} else {
							tips.html('揭晓成功！');
							setTimeout(function(){
								location.reload();
							},200);
						}
					});
				};
				setTimeout(checker,750);
				return;
			}

			i =  parseInt((time/1000)/60);
			s =  parseInt((time/1000)%60);
			ms =  String(Math.floor(time%1000));
			ms = parseInt(ms.substr(0,2));
			if(i<10)i='0'+i;
			if(s<10)s='0'+s;
			if(ms<10)ms='0'+ms;
			minute.html(i);
			second.html(s);
			millisecond.html(ms);
		}, 41);

	}

})

</script>
</div>
</body>
</html>
