<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

	// 初始化
	protected function _initialize() {
		// XSS检测
		$Webscan = new \Common\Util\Webscan();
		if ($Webscan->check()) {
			IS_AJAX ? $this->ajaxReturn(array('status'=>2, 'msg'=>'检测到危险代码')) : $this->error('检测到危险代码', '', 1);
		} else {
			// 网站配置信息
			$_conf = M('config')->find(1);
			$this->conf = array_merge($_conf, array(
				'site' => json_decode($_conf['site'], true),
				'company' => json_decode($_conf['company'], true),
				'smtp' => json_decode($_conf['smtp'], true),
				'sms' => json_decode($_conf['sms'], true),
				'distrib' => json_decode($_conf['distrib'], true),
				'distrib_sec' => json_decode($_conf['distrib_sec'], true),
				'distrib_profit' => json_decode($_conf['distrib_profit'], true),
				'cash' => json_decode($_conf['cash'], true),
				'more' => json_decode($_conf['more'], true),
              'jiben' => json_decode($_conf['jiben'], true),
			));
			if ($this->conf['site']['status'] == 0) $this->error('网站维护中，请稍后...');

			// 主题配置
			if ($this->conf['more']['theme'] != 'default') $this->theme($this->conf['more']['theme']);

			// 邀请信息
			$from = I('get.from');
			$Crypt = new \Think\Crypt();
			$id = $Crypt->decrypt($from, C('HASHKEY'));
			if (intval($id) && M('user')->find($id)) cookie('from', $from, 3600);
		}
	}

	// 空操作
	public function _empty() {
		send_http_status(404);
		$this->display('Public:404');
	}

	// 失败提示
	protected function error($message, $url=false, $wait=3) {
		$this->assign('error', $message);
		if ($url) $this->assign('url', $url);
		$this->assign('wait', $wait);
		$this->display(C('TMPL_ACTION_ERROR'));
		exit;
	}

	// 成功提示
	protected function success($message, $url=false, $wait=3) {
		$this->assign('success', $message);
		if ($url) $this->assign('url', $url);
		$this->assign('wait', $wait);
		$this->display(C('TMPL_ACTION_ERROR'));
		exit;
	}

}