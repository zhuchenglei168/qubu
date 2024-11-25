<?php
namespace Home\Controller;
use Think\Controller;
class WechatController extends Controller {

	// 初始化
	protected function _initialize() {
		$this->config = require_once(CONF_PATH.'wechat.php');
	}

	// 验证接口
	public function index() {
		$Wechat = new \Common\Util\Wechat($this->config);
		$Wechat->valid();
	}

	// 网页授权
	public function auth() {
		$Wechat = new \Common\Util\Wechat($this->config);
		$res = $Wechat->getOauthAccessToken();
		if($res['openid']) {
			$map = array(
				'openid' => array('eq', $res['openid']),
			);
			$_user = M('user')->where($map)->find();
			// 开启session
			session_start();
			if ($_user) {
				session('user_id', $_user['id']);
				$this->redirect('/user');
			} else {
				$info = $Wechat->getOauthUserinfo($res['access_token'], $res['openid']);
				session('auth_info', $info);
				$lasturi = urldecode(I('get.lasturi'));
				$this->redirect($lasturi ? $lasturi : '/user/login');
			}
		} else {
			$callback = I('server.REQUEST_SCHEME') . '://' . I('server.HTTP_HOST') . I('server.REQUEST_URI');
			redirect($Wechat->getOauthRedirect($callback));
		}
	}

}