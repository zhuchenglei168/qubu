<?php
require ('./function.php');
$poEmail=trim($_GET['return_url']);
$poMoney=trim($_GET['total_fee']);
$poTitle=trim($_GET['out_trade_no']);
if(CheckId($poEmail) && CheckMoney($poMoney) && CheckId($poTitle)){
echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="md5.js"></script>

<script>
function pay(){

    var optemail=document.getElementById(\'toptEmail\').value;
	var amount=document.getElementById(\'tpayAmount\').value;
	var tradeNo=document.getElementById(\'ttitle\').value;
	var md5=hex_md5(optemail+"&"+amount+"&"+tradeNo);

    var data=optemail+"%26"+amount+"%26"+tradeNo;
    var postForm=document.createElement("form");
    postForm.method="post";
	//postForm.target="_blank";
    postForm.action="https://www.tenpay.com/v2/account/pay/paymore_cft.shtml?data="+data+"&validate="+md5;
    document.body.appendChild(postForm);
    postForm.submit();
 
 }				
</script>

</head>

<body>
<input type="hidden" name="toptEmail" id="toptEmail" value="'.$poEmail.'">
<input name="payAmount" type="hidden" id="tpayAmount" size="5" value="'.$poMoney.'">
<input type="hidden" name="title" id="ttitle" value="'.$poTitle.'">
<script type="text/javascript">pay();</script>
</body>
</html>';
}

?>


