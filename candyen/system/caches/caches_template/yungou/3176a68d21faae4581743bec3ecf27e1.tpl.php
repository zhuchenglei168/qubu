<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?><!-- 栏目页面顶部 -->en.buquancandy.com

    <header class="header">

        <h1 class="fl"><span><?php echo $webname; ?></span><a href="<?php echo WEB_PATH; ?>/mobile/mobile"><img src="http://en.tangguoduobao.com/statics/uploads/<?php echo Getlogo(); ?>" style="height:30px;"/></a></h1>

        <div class="fr head-r">

            <a href="<?php echo WEB_PATH; ?>/mobile/user/login" class="z-Member"></a>

            <a id="btnCart" href="<?php echo WEB_PATH; ?>/mobile/cart/cartlist" class="z-shop"></a>

        </div>

    </header> 

    <!-- 栏目导航 -->

    <nav class="g-snav u-nav">

	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/" <?php if($key=="Home" ): ?>class="nav-crt"<?php endif; ?>>Home</a> <?php if($key=="Home" ): ?><s class="z-arrowh"></s><?php endif; ?></div>

		

	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/glist" <?php if($key=="Goods" ): ?>class="nav-crt"<?php endif; ?>>Goods</a><?php if($key=="Goods" ): ?><s class="z-arrowh"></s><?php endif; ?></div>

		

	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/mobile/lottery" <?php if($key=="Recent" ): ?>class="nav-crt"<?php endif; ?>>Recent</a><?php if($key=="Recent" ): ?><s class="z-arrowh"></s><?php endif; ?></div>

		

	    <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/shaidan/" <?php if($key=="Share" ): ?>class="nav-crt"<?php endif; ?>>Share</a><?php if($key=="Share" ): ?><s class="z-arrowh"></s><?php endif; ?></div>

        <div class="g-snav-lst"><a href="<?php echo WEB_PATH; ?>/mobile/home/userqiandao" <?php if($key=="Sign" ): ?>class="nav-crt"<?php endif; ?>>Sign</a><?php if($key=="Sign" ): ?><s class="z-arrowh"></s><?php endif; ?></div>

	
		

    </nav>