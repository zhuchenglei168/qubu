<?php
namespace Admin\Controller;
use Think\Controller;
// 通用控制器
class CommonController extends Controller {

	// 初始化
	protected function _initialize() {
		
		// XSS检测
		$Webscan = new \Common\Util\Webscan();
		if ($Webscan->check()) {
			if (IS_AJAX) {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'检测到危险代码'));
			} elseif (I('get.iframe') == 1) {
				$this->close_iframe('检测到危险代码');
			} else {
				$this->error('检测到危险代码', 'javascript:history.go(-1)', 1);
			}
		}
		
		// 登录检测
		$staff_id = session('staff_id');
		if ($staff_id) {
			// 员工信息
			$this->staff = D('StaffView')->find($staff_id);
			// 权限检测
			if (!in_array(CONTROLLER_NAME, array('Index', 'Public', 'Empty'))) {
				if ($this->staff['role_id'] && !in_array(CONTROLLER_NAME . '_'. ACTION_NAME, json_decode($this->staff['rules'], true))) {
					if (IS_AJAX) {
						$this->ajaxReturn(array('status'=>2, 'msg'=>'权限不足'));
					} elseif (I('get.iframe') == 1) {
						$this->close_iframe('权限不足');
					} else {
						$this->error('权限不足', 'javascript:history.go(-1)', 1);
					}
				}
			}
		} else {
			if (CONTROLLER_NAME != 'Public') redirect(U('public/login'));
		}
	}

	// 关闭iframe
	protected function close_iframe($msg, $sec=1) {
		die('<script>parent.layer.closeAll("iframe");parent.layer.msg("'.$msg.'", {time:'.($sec * 1000).', anim:6});</script>');
	}

	// 空操作
	public function _empty() {
		send_http_status(404);
		$this->display('Public:404');
	}

}