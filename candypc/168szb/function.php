<?php
/*$out_trade_no=trim($_POST['title']);//商户订单号
$total_fee   =trim($_POST['money']);//收款金额
$trade_no    =trim($_POST['order']);//支付宝订单号
$sign        =trim($_POST['sign']);//回调签名   */


function CheckId($cuid){
if(!empty($cuid)){
   preg_match("/^[0-9a-zA-Z]{1,50}$/",$cuid,$puid);
   if(empty($puid[0])){
      return false;
                       }else{return true;}
                  }
				       }


function CheckMoney($Money){
if(!empty($Money)){
   preg_match("/^([0-9]){1,20}$|^([0-9]){1,20}\.([0-9])+$/",$Money,$pMoney);
   if(empty($pMoney[0])){
      return false;
                       }else{return true;}
                  }
				       }


function checkZfb($zfb){//只能是支付宝账号格式
if(!empty($zfb)){
   preg_match("/^(\d){11,11}$|^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/",$zfb,$pzfb);
   //匹配支付宝账号格式
   if(empty($pzfb[0])){
      return false;
                       }else{return true;}
                 }else{ return false; }

}

?>