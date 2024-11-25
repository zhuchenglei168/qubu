<?php
namespace Admin\Controller;
// 公共控制器
class PublicController extends CommonController {

	// 登录
	public function login(){
		if (IS_POST) {
			$_post = I('post.');
			if ($this->check_vcode($_post['vcode'])) {
				$map = array('username'=>array('eq', $_post['username']));
				$_result = D('StaffView')->where($map)->find();
				if ($_result) {
					if ($_result['role_id'] && $_result['role_status'] == 0) {
						$this->ajaxReturn(array('status'=>2, 'msg'=>'角色不存在或已冻结'));
					} elseif ($_result['status'] == 0) {
						$this->ajaxReturn(array('status'=>2, 'msg'=>'员工不存在或已冻结'));
					} else {
						if (get_sha($_post['password']) == $_result['password']) {
							session('staff_id', $_result['id']);
							$this->ajaxReturn(array('status'=>1, 'msg'=>'登录成功', 'url'=>U('index/index')));
						} else {
							$this->ajaxReturn(array('status'=>2, 'msg'=>'输入的密码有误'));
						}
					}
				} else {
					$this->ajaxReturn(array('status'=>2, 'msg'=>'该员工不存在'));
				}
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'验证码错误'));
			}
		} else {
			if ($this->staff) $this->redirect(U('index/index'));
			$this->display();
		}
	}

	// 注销
	public function logout() {
		session('staff_id', null);
		$this->ajaxReturn(array('status'=>1, 'msg'=>'注销成功', 'url'=>U('public/login')));
	}

	// 验证码
	public function vcode() {
		$Verify = new \Think\Verify();
		$Verify->fontSize = 100;
		$Verify->length = 4;
		$Verify->useNoise = false;
		$Verify->fontttf = '4.ttf';
		$Verify->entry();
	}

	// 验证验证码
	private function check_vcode($str) {
		$Verify = new \Think\Verify();
		return $Verify->check($str);
	}

}