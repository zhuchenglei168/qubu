<?php defined('G_IN_SYSTEM')or exit('No permission resources.'); ?>﻿<footer class="footer">
	
	<!--<p class="grayc">Vennet Services Sdn Bhd (1243366-H)</p>
	<p class="grayc">Address: 15-1, Jalan OP1/2, Off Jalan Puchong, Pusat Perdagangan One Puchong, 47160 Selangor, Malaysia.</p>
	<p class="grayc">Email: Vennet services@hotmail.com</p>-->
	<a id="btnTop" href="javascript:;" class="z-top" style="display:none;"><b class="z-arrow"></b></a>
</footer>
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
	}else if( ROUTE_C == 'cart'){
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
			<a title="Goods" href="<?php echo WEB_PATH; ?>/mobile/mobile/glist"><i class="<?php echo $f_whole; ?>">&nbsp;</i>Goods</a>
		</li>
		<li class="f_jiexiao">
			<a title="Unveiling" href="<?php echo WEB_PATH; ?>/mobile/mobile/lottery"><i class="<?php echo $f_jiexiao; ?>">&nbsp;</i>Recent</a>
		</li>
		<li class="f_car">
			<a title="Cart" href="<?php echo WEB_PATH; ?>/mobile/cart/cartlist"><i class="<?php echo $f_car; ?>">&nbsp;</i>Cart</a>
		</li>
		<li class="f_personal">
			<a title="Mine" href="<?php echo WEB_PATH; ?>/mobile/home"><i class="<?php echo $f_personal; ?>">&nbsp;</i>Mine</a>
		<li>
	</ul>
</div>

