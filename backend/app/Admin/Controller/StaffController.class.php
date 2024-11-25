<?php
namespace Admin\Controller;
// 员工管理
class StaffController extends CommonController {

	//* 员工列表
	public function index() {
		$Staff = D('StaffView');
		$_count = $Staff->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $Staff->order('id ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		// 角色
		$map = array('status'=>array('eq', 1));
		$_result = M('staff_role')->field('id, title')->where($map)->select();
		$this->assign('role', $_result);
		$this->display();
	}

	//* 添加员工
	public function add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['role_id'] ? $data['role_id'] = $_post['role_id'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'角色不能为空'));
			$_post['username'] ? $data['username'] = $_post['username'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'用户名不能为空'));
			// 判断用户名唯一性
			$Staff = M('staff');
			$map = array('username'=>array('eq', $_post['username']));
			$_result = $Staff->where($map)->find();
			if ($_result) $this->ajaxReturn(array('status'=>2, 'msg'=>'用户名已存在'));
			$_post['password'] ? $data['password'] = get_sha($_post['password']) : $this->ajaxReturn(array('status'=>2, 'msg'=>'密码不能为空'));
			$data['nickname'] = $_post['nickname'];
			$data['create_time'] = NOW_TIME;
			$data['status'] = 1;
			$_result = $Staff->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('staff/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 编辑员工
	public function edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			// Admin账号防误操作
			if (I('get.id') == 1) $this->ajaxReturn(array('status'=>2, 'msg'=>'Admin账号不可编辑'));
			$_post['role_id'] ? $data['role_id'] = $_post['role_id'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'角色不能为空'));
			$_post['password'] ? $data['password'] = get_sha($_post['password']) : '';
			$data['nickname'] = $_post['nickname'];
			$data['status'] = $_post['status'];
			$_result = M('staff')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('staff')->find(I('get.id'));
			$this->assign('data', $_result);
			// 角色
			$map = array('status'=>array('eq', 1));
			$_result = M('staff_role')->field('id, title')->where($map)->select();
			$this->assign('role', $_result);
			$this->display();
		}
	}

	//* 删除员工
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			// Admin账号防误操作
			if (in_array(1, $ids)) $this->ajaxReturn(array('status'=>2, 'msg'=>'Admin账号不可删除'));
			$map = array('id'=>array('in', $ids));
			$_result = M('staff')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('staff/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 员工角色
	public function role() {
		$StaffRole = M('staff_role');
		$_count = $StaffRole->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $StaffRole->order('id ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}

	//* 添加角色
	public function role_add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'角色名称不能为空'));
			// 判断角色名称唯一性
			$StaffRole = M('staff_role');
			$map = array('title'=>array('eq', $_post['title']));
			$_result = $StaffRole->where($map)->find();
			if ($_result) $this->ajaxReturn(array('status'=>2, 'msg'=>'角色名称已存在'));
			$data['description'] = $_post['description'];
			$data['status'] = 1;
			$_result = $StaffRole->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('staff/role')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 编辑角色
	public function role_edit(){
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'角色名称不能为空'));
			// 判断角色名称唯一性
			$StaffRole = M('staff_role');
			$map = array('title'=>array('eq', $_post['title']));
			$_result = $StaffRole->where($map)->find();
			if ($_result && $_result['id'] != I('get.id')) $this->ajaxReturn(array('status'=>2, 'msg'=>'角色名称已存在'));
			$data['description'] = $_post['description'];
			$data['status'] = $_post['status'];
			$data['rules'] = json_encode($_post['rules']);
			$_result = $StaffRole->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('staff_role')->find(I('get.id'));
			$_result['rules'] = $_result['rules'] ? json_decode($_result['rules'], true) : '';
			$this->assign('data', $_result);
			$this->assign('nodes', $this->get_nodes());
			$this->display();
		}
	}

	// 获取节点数组
	private function get_nodes() {
		$_dir = realpath(MODULE_PATH . 'Controller');
		// 排除控制器文件
		$_excludes = array('CommonController.class.php', 'IndexController.class.php', 'PublicController.class.php', 'EmptyController.class.php');
		// 获取控制器文件列表
		$_files = get_files($_dir);
		$_nodes = array();
		// 遍历文件
		foreach ($_files as $v) {
			if (!in_array($v, $_excludes)) {
				$_str = file_get_contents($_dir . '/' . $v);
				// 匹配类名
				preg_match("/\/\/ (.*?)\nclass/smi", $_str, $match);
				if ($match) {
					$key = strstr($v, 'Controller', true);
					$_nodes[$key]['name'] = trim($match[1]);
					// 匹配节点
					preg_match_all("/\/\/\* (.*?)\n.*?public function(.*?)\(/smi", $_str, $matches);
					// 组装数组
					if ($matches) {
						foreach ($matches[2] as $k=>$val) {
							$_nodes[$key]['list'][trim($val)] = trim($matches[1][$k]);
						}
					}
				}
			}
		}
		return $_nodes;
	}

	//* 删除角色
	public function role_del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('staff_role')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('staff/role')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 我的设置
	public function profile() {
		if (IS_POST) {
			$_post = I('post.');
			// 昵称
			if ($_post['nickname'] && $_post['nickname'] != $this->staff['nickname']) {
				$map = array('id'=>array('eq', $this->staff['id']));
				M('staff')->where($map)->save(array('nickname'=>$_post['nickname']));
			}
			// 详细信息
			$StaffInfo = M('staff_info');
			$map = array('staff_id'=>array('eq', $this->staff['id']));
			$_result = $StaffInfo->where($map)->find();
			$data = $_result ? array() : array('staff_id'=>$this->staff['id']);
			$data['realname'] = $_post['realname'];
			$data['phone'] = $_post['phone'];
			if ($_post['email']) {
				filter_var($_post['email'], FILTER_VALIDATE_EMAIL) ? $data['email'] = $_post['email'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'邮箱地址格式错误'));
			} else {
				$data['email'] = '';
			}
			$data['qq'] = $_post['qq'];
			$data['wechat'] = $_post['wechat'];
			$data['address'] = $_post['address'];
			$data['intro'] = $_post['intro'];
			$data['status'] = $_post['status'];
			if ($_result) {
				$map = array('staff_id'=>array('eq', $this->staff['id']));
				$_result = $StaffInfo->where($map)->save($data);
			} else {
				$_result = $StaffInfo->add($data);
			}
			$this->ajaxReturn(array('status'=>1, 'msg'=>'更新成功', 'url'=>U('staff/profile')));
		} else {
			$map = array('staff_id'=>array('eq', $this->staff['id']));
			$_result = M('staff_info')->where($map)->find();
			$this->assign('data', $_result);
			$this->display();
		}
	}

	//* 修改头像
	public function avatar() {
		if (IS_POST) {
			$avatar = base64_decode(str_replace('data:image/png;base64,', '', I('post.avatar')));
			if (empty($avatar)) $this->ajaxReturn(array('status'=>2, 'msg'=>'头像文件不能为空'));
			$save_dir = dirname(APP_PATH) . '/public/upload/avatar/';
			if (!file_exists($save_dir)) mkdir($save_dir, 0777, true);
			$filename = uniqid().'.png';
			$_result = file_put_contents($save_dir.$filename, $avatar);
			if ($_result) {
				$data = array(
					'id' => $this->staff['id'],
					'avatar' => '/upload/avatar/'.$filename,
				);
				$_result = M('staff')->save($data);
				if ($_result) {
					$this->ajaxReturn(array('status'=>1, 'msg'=>'保存成功'));
				} else {
					$this->ajaxReturn(array('status'=>2, 'msg'=>'保存失败'));
				}
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'头像上传失败'));
			}
		}
	}

	//* 修改密码
	public function password(){
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>$this->staff['id']);
			$_post['password'] ? $data['password'] = get_sha($_post['password']) : $this->ajaxReturn(array('status'=>2, 'msg'=>'新密码不能为空'));
			if ($_post['password'] != $_post['checkpass']) $this->ajaxReturn(array('status'=>2, 'msg'=>'两次密码输入不一致'));
			$_result = M('staff')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'更新成功', 'url'=>U('staff/profile')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'更新失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

}