<?php
namespace Common\Util;

// 引入支付宝SDK
require_once(__DIR__.'/Apppay/aop/AopClient.php');
require_once(__DIR__.'/Apppay/aop/request/AlipayTradeAppPayRequest.php');

class Apppay {

	private $config;

	public function __construct() {

		$this->config = json_decode(file_get_contents(CONF_PATH.'alipay.php'), true);

	}

	// 返回验签
	public function check($arr, $log=false) {

		$this->config = array_merge(C('ALIPAY'), $this->config['pay']);

		$alipaySevice = new \AlipayTradeService($this->config);
		if ($log) $alipaySevice->writeLog(var_export($arr, true));
		$_result = $alipaySevice->check($arr);
		return $_result ? $this->config['app_id'] == $arr['app_id'] : false;
	}

  public function notify($arr){
    $this->config = array_merge(C('ALIPAY'), $this->config['pay']);
  $aop = new \AopClient;
$aop->alipayrsaPublicKey = $this->config['alipay_public_key'];
$_result = $aop->rsaCheckV1($arr, NULL, "RSA2");
    return $_result ? $this->config['app_id'] == $arr['app_id'] : false;
  }
	// 支付
	public function pay($order) {

		$this->config = array_merge(C('ALIPAY'), $this->config['pay']);
$total = $order['money'];
      $aop = new \AopClient;
$aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
$aop->appId =  $this->config['app_id'];
$aop->rsaPrivateKey = $this->config['merchant_private_key'];
$aop->format = "json";
$aop->charset = "UTF-8";
$aop->signType = "RSA2";
$aop->alipayrsaPublicKey =  $this->config['alipay_public_key'];
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
$request = new \AlipayTradeAppPayRequest();

// 异步通知地址
$notify_url = urlencode('http://qubu.bbscodes.com/pay/notify');
// 订单标题
$subject = '支付订单';
// 订单详情
$body = '支付订单'; 
// 订单号，示例代码使用时间值作为唯一的订单ID号
$out_trade_no = $order['trade_no'];

//SDK已经封装掉了公共参数，这里只需要传入业务参数
$bizcontent = "{\"body\":\"".$body."\","
                . "\"subject\": \"".$subject."\","
                . "\"out_trade_no\": \"".$out_trade_no."\","
                . "\"timeout_express\": \"30m\","
                . "\"total_amount\": \"".$total."\","
                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                . "}";
$request->setNotifyUrl($notify_url);
$request->setBizContent($bizcontent);
//这里和普通的接口调用不同，使用的是sdkExecute
$response = $aop->sdkExecute($request);

// 注意：这里不需要使用htmlspecialchars进行转义，直接返回即可
return $response;
	
	}

	// 提现
	public function cash($cash, $user) {

		if ($this->config['cash']) {
			$this->config = array_merge(C('ALIPAY'), $this->config['cash']);
		} else {
			$this->config = array_merge(C('ALIPAY'), $this->config['pay']);
		}

		$aop = new \AopClient();
		$aop->gatewayUrl = $this->config['gatewayUrl'];
		$aop->appId = $this->config['app_id'];
		$aop->rsaPrivateKey = $this->config['merchant_private_key'];
		$aop->alipayrsaPublicKey = $this->config['alipay_public_key'];
		$aop->apiVersion = '1.0';
		$aop->signType = $this->config['sign_type'];
		$aop->postCharset = $this->config['charset'];
		$aop->format = 'json';
		$request = new \AlipayFundTransToaccountTransferRequest();
		// 提现处理
		$request->setBizContent(json_encode(array(
			'out_biz_no' => $cash['trade_no'],
			'payee_type' => 'ALIPAY_LOGONID',
			'payee_account' => $user['alipay'],
			'amount' => $cash['money_real'],
			'payer_show_name' => '用户'.$user['id'].'提现',
			'payee_real_name' => $user['realname'],
			'remark' => '',
		), 320));
		$result = $aop->execute($request);
		// 提现返回处理
		$responseNode = str_replace('.', '_', $request->getApiMethodName()) . '_response';
		$resultCode = $result->$responseNode->code;
		return (!empty($resultCode) && $resultCode == 10000) ? $result->$responseNode->out_biz_no : false;
	}

}
