<?php
namespace Common\Util;

// 引入支付宝SDK
require_once(__DIR__.'/Alipay/AopSdk.php');
require_once(__DIR__.'/Alipay/wappay/service/AlipayTradeService.php');
require_once(__DIR__.'/Alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php');

class Alipay {

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

	// 支付
	public function pay($order) {

		$this->config = array_merge(C('ALIPAY'), $this->config['pay']);

		$payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
		$payRequestBuilder->setBody('');
		$payRequestBuilder->setSubject($order['trade_no']);
		$payRequestBuilder->setOutTradeNo($order['trade_no']);
		$payRequestBuilder->setTotalAmount($order['money']);
		$payRequestBuilder->setTimeExpress('1m');

		$payResponse = new \AlipayTradeService($this->config);
		$payResponse->wapPay($payRequestBuilder, $this->config['return_url'], $this->config['notify_url']);

		return;
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
