<?php
	 //提交到支付宝转账页面
	 //如果乱码加accept-charset="GBK" onsubmit="document.charset=\'GBK\'"
require ('./function.php');
$poEmail=trim($_POST['optEmail']);
$poMoney=trim($_POST['payAmount']);
$poTitle=trim($_POST['title']);
if(checkZfb($poEmail) && CheckMoney($poMoney) && CheckId($poTitle)){
header("content-Type:text/html;charset=GBK"); 
$memo=iconv('UTF-8','GBK','请不要修改付款说明和付款金额，以免造成充值失败【收支宝自动充值接口】');//utf-8转换成GBK
	 echo '<form name="myform" action="https://shenghuo.alipay.com/send/payment/fill.htm" method="post">
			<input name="optEmail" id="optEmail"  value="'.$poEmail.'"  type="hidden">
			<input name="payAmount" id="payAmount" value="'.$poMoney.'" type="hidden">
			<input name="title" id="title" value="'.$poTitle.'" type="hidden">
			<input name="memo" id="memo" value="'.$memo.'" type="hidden">
			<script type="text/javascript">document.myform.submit();</script>';
}

?>