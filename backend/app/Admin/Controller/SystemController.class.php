<?php
namespace Admin\Controller;
// 系统管理
class SystemController extends CommonController {

	//* 基础设置
	public function index() {
		$Config = M('config');
		$_result = $Config->find(1);
		if (empty($_result)) $Config->add(array('id'=>1));
		$this->assign('data', $_result);
		$this->display();
	}

  //* 任务管理
	public function mission() {
     
		$mission = M('mission');
		$_count = $mission->count();

		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $mission->order('level ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
    
		$this->assign('list', $_result);
		$this->display();
	}
  
  //* 编辑任务
	public function mission_edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'任务名称不能为空'));
			$_post['enname'] ? $data['enname'] = $_post['enname'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'任务名称不能为空'));
			$_post['huoyue'] ? $data['huoyue'] = $_post['huoyue'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'活跃度不能为空'));
          $data['price'] = $_post['price'];
          $_post['rewad'] ? $data['rewad'] = $_post['rewad'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'可获得糖果不能为空'));
          $_post['step'] ? $data['step'] = $_post['step'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'每日所需步数不能为空'));
            $_post['term'] ? $data['term'] = $_post['term'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'期限不能为空'));
           $data['all'] = $_post['all'];
			$_result = M('mission')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('mission')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}
//* 添加任务
	public function mission_add() {
		if (IS_POST) {
			$_post = I('post.');
          $data = array();
			
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'任务名称不能为空'));
			$_post['huoyue'] ? $data['huoyue'] = $_post['huoyue'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'活跃度不能为空'));
          $_post['price'] ? $data['price'] = $_post['price'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'兑换所需糖果不能为空'));
          $_post['rewad'] ? $data['rewad'] = $_post['rewad'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'可获得糖果不能为空'));
          $_post['step'] ? $data['step'] = $_post['step'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'每日所需步数不能为空'));
          $_post['term'] ? $data['term'] = $_post['term'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'期限不能为空'));
			$_result = M('mission')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('bonus/level')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
  	//* 删除任务
	public function mission_del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('mission')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('system/mission')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
	//* 网站设置
	public function setting_site() {
		if (IS_POST) {
			$_post = I('post.');
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'网站标题不能为空'));
			$data['subtitle'] = $_post['subtitle'];
			$data['description'] = $_post['description'];
			$data['keyword'] = $_post['keyword'];
			$data['copyright'] = $_post['copyright'];
			$data['tongji'] = $_post['tongji'];
			$data['status'] = $_post['status'];
			$_result = M('config')->save(array(
				'id' => 1,
				'site' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 公司信息
	public function setting_company() {
		if (IS_POST) {
			$_post = I('post.');
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'公司名称不能为空'));
			$data['address'] = $_post['address'];
			$data['tel'] = $_post['tel'];
			if ($_post['email']) {
				filter_var($_post['email'], FILTER_VALIDATE_EMAIL) ? $data['email'] = $_post['email'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'邮箱地址格式错误'));
			} else {
				$data['email'] = '';
			}
			$data['qq'] = $_post['qq'];
			$data['qqgroup'] = $_post['qqgroup'];
			if ($_post['qrcode']) $data['qrcode'] = $_post['qrcode'];
			$_result = M('config')->save(array(
				'id' => 1,
				'company' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 邮件设置
	public function setting_smtp() {
		if (IS_POST) {
			$_post = I('post.');
			$_post['host'] ? $data['host'] = $_post['host'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'smtp服务器不能为空'));
			$data['port'] = $_post['port'] ? $_post['port'] : '25';
			if ($_post['username']) {
				filter_var($_post['username'], FILTER_VALIDATE_EMAIL) ? $data['username'] = $_post['username'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'邮箱地址格式错误'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'邮箱地址不能为空'));
			}
			$_post['password'] ? $data['password'] = $_post['password'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'密码不能为空'));
			$_result = M('config')->save(array(
				'id' => 1,
				'smtp' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 短信设置
	public function setting_sms() {
		if (IS_POST) {
			$_post = I('post.');
			$_post['username'] ? $data['username'] = $_post['username'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'接口账号不能为空'));
			$_post['password'] ? $data['password'] = $_post['password'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'接口密码不能为空'));
          $_post['SignName'] ? $data['SignName'] = $_post['SignName'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'签名不能为空'));
          $_post['regCode'] ? $data['regCode'] = $_post['regCode'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'注册模板不能为空'));
           $_post['forgetCode'] ? $data['forgetCode'] = $_post['forgetCode'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'修改密码模板不能为空'));
           $_post['jiaoyanCode'] ? $data['jiaoyanCode'] = $_post['jiaoyanCode'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'身份校验模板不能为空'));
			$_result = M('config')->save(array(
				'id' => 1,
				'sms' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 清理缓存
	public function refresh() {
		\Think\Cache::getInstance()->clear();
		$this->ajaxReturn(array('status'=>1, 'msg'=>'清空缓存成功'));
	}

	//* 业务设置
	public function business() {
		$_result = M('config')->find(1);
		$this->assign('data', $_result);
		// 主题
		$_themes = get_dirs('./themes/');
		$this->assign('themes', $_themes);
		// 支付宝配置
		$_result = json_decode(file_get_contents(CONF_PATH . 'alipay.php'), true);
		$this->assign('alipay', $_result);
		$this->display();
	}

	//* 更多设置
	public function setting_more() {
		if (IS_POST) {
			$_post = I('post.');
			//$data['theme'] = $_post['theme'] ? $_post['theme'] : 'default';
			$data['change_status'] = $_post['change_status'] ? 1 : 0;
			
			$data['max'] = $_post['max'];
          $data['min'] = $_post['min'];
          $data['jinri'] = $_post['jinri'];
          $data['minnum'] = $_post['minnum'];
          $data['buyminnum'] = $_post['buyminnum'];
          $data['sellminnum'] = $_post['sellminnum'];
          $data['timelimit'] = $_post['timelimit'];
		  $data['chaoshilimit'] = $_post['chaoshilimit'];
			$_result = M('config')->save(array(
				'id' => 1,
				'more' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
	//* 基本设置
	public function setting_jiben() {
		if (IS_POST) {
			$_post = I('post.');
			//$data['theme'] = $_post['theme'] ? $_post['theme'] : 'default';
			$data['reg_status'] = $_post['reg_status'] ? 1 : 0;
			$data['appdizhi'] = $_post['appdizhi'];
			$data['iosappdizhi'] = $_post['iosappdizhi'];
			$data['appdizhien'] = $_post['appdizhien'];
			$data['iosappdizhien'] = $_post['iosappdizhien'];
			$data['enurl'] = $_post['enurl'];
			$data['azbbh'] = $_post['azbbh'];
			$data['iosbbh'] = $_post['iosbbh'];
			$data['azbbhen'] = $_post['azbbhen'];
			$data['iosbbhen'] = $_post['iosbbhen'];
			$data['regsonghyd'] = $_post['regsonghyd'];
          $data['tgsonggxz'] = $_post['tgsonggxz'];
           $data['dhjzjiahyd'] = $_post['dhjzjiahyd'];
			$data['tgsonghyd'] = $_post['tgsonghyd'];
          $data['bianliang'] = $_post['bianliang'];
          $data['jiajulebuhyd'] = $_post['jiajulebuhyd'];
          $data['jiazuduihyd'] = $_post['jiazuduihyd'];
			$data['jichutemp'] = $_post['jichutemp'];
			$_result = M('config')->save(array(
				'id' => 1,
				'jiben' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
	//* 分销设置
	public function setting_distrib() {
		if (IS_POST) {
			$_post = I('post.');
			$data['status'] = $_post['status'] ? 1 : 0;
			$data['level'] = $_post['level'];
			foreach ($_post['level'] as $v) {
				if (!is_numeric($v) || $v<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'佣金比例必须为数字且大于0'));
			}
			is_numeric($_post['self']) && $_post['self']>=0 ? $data['self'] = $_post['self'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'佣金比例必须为数字且不小于0'));
			if (array_sum($data['level']) + $data['self'] > 100) $this->ajaxReturn(array('status'=>2, 'msg'=>'总佣金比例不得超过100'));
			$_result = M('config')->save(array(
				'id' => 1,
				'distrib' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 分销设置
	public function setting_distrib_sec() {
		if (IS_POST) {
			$_post = I('post.');
			$data['status'] = $_post['status'] ? 1 : 0;
			$data['level'] = $_post['level'];
			foreach ($_post['level'] as $v) {
				if (!is_numeric($v) || $v<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'佣金比例必须为数字且大于0'));
			}
			is_numeric($_post['self']) && $_post['self']>=0 ? $data['self'] = $_post['self'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'佣金比例必须为数字且不小于0'));
			if (array_sum($data['level']) + $data['self'] > 100) $this->ajaxReturn(array('status'=>2, 'msg'=>'总佣金比例不得超过100'));
			$_result = M('config')->save(array(
				'id' => 1,
				'distrib_sec' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 分润返点设置
	public function setting_distrib_profit() {
		if (IS_POST) {
			$_post = I('post.');
			$data['status'] = $_post['status'] ? 1 : 0;
			$data['level'] = $_post['level'];
			foreach ($_post['level'] as $v) {
				if (!is_numeric($v) || $v<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'佣金比例必须为数字且大于0'));
			}
			is_numeric($_post['self']) && $_post['self']>=0 ? $data['self'] = $_post['self'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'佣金比例必须为数字且不小于0'));
			if (array_sum($data['level']) + $data['self'] > 100) $this->ajaxReturn(array('status'=>2, 'msg'=>'总佣金比例不得超过100'));
			$_result = M('config')->save(array(
				'id' => 1,
				'distrib_profit' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 提现设置
	public function setting_cash() {
		if (IS_POST) {
			$_post = I('post.');
			$data['cash_fee'] = $_post['cash_fee'] ? $_post['cash_fee'] : 0;
			if (!is_numeric($data['cash_fee']) || $data['cash_fee']<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'提现手续费必须为数字且不小于0'));
			$data['cash_limit'] = $_post['cash_limit'] ? $_post['cash_limit'] : 0;
			if (!is_numeric($data['cash_limit']) || $data['cash_limit']<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'消费满可提现必须为数字且不小于0'));
			$data['cash_min'] = $_post['cash_min'] ? $_post['cash_min'] : 100;
			if (!is_numeric($data['cash_min']) || $data['cash_min']<=0) $this->ajaxReturn(array('status'=>2, 'msg'=>'单笔最小提现必须为数字且大于0'));
			$data['cash_max'] = $_post['cash_max'] ? $_post['cash_max'] : 0;
			if (!is_numeric($data['cash_max']) || $data['cash_max']<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'最大提现金额必须为数字且大于0'));
			if ($data['cash_max'] != 0 && $data['cash_max'] < $data['cash_min']) $this->ajaxReturn(array('status'=>2, 'msg'=>'单笔最大提现必须不小于单笔最小提现'));
			$data['cash_num'] = $_post['cash_num'] ? $_post['cash_num'] : 0;
			if (intval($_post['cash_num']) != abs($_post['cash_num'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'单日提现次数必须为正整数'));
			$_result = M('config')->save(array(
				'id' => 1,
				'cash' => json_encode($data),
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 支付宝设置
	public function setting_alipay() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array(
				'pay' => array(
					'app_id' => $_post['pay_id'],
					'alipay_public_key' => $_post['pay_public_key'],
					'merchant_private_key' => $_post['pay_private_key'],
				),
			);
			if ($_post['cash_id']) $data['cash'] = array(
				'app_id' => $_post['cash_id'],
				'alipay_public_key' => $_post['cash_public_key'],
				'merchant_private_key' => $_post['cash_private_key'],
			);
			file_put_contents(CONF_PATH . 'alipay.php', json_encode($data));
			$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 海报管理
	public function poster() {
		if (IS_POST) {
			$_post = I('post.');
			$_result = M('config')->save(array(
				'id' => 1,
				'poster' => $_post['html'],
			));
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('config')->field('poster')->find(1);
			$this->assign('data', $_result['poster']);
			$this->display();
		}
	}

}
