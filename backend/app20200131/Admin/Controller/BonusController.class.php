<?php
namespace Admin\Controller;
// 分红管理
class BonusController extends CommonController {

	//* 奖金池
	public function index() {
		$Bonus = M('bonus');
		$_count = $Bonus->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $Bonus->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}

	//* 编辑奖池
	public function edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$data['money'] = $_post['money'] ? $_post['money'] : 0;
			if (!is_numeric($data['money']) || $data['money']<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'奖池金额必须为数字且不小于0'));
			$data['status'] = $_post['status'];
			$_result = M('bonus')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('bonus')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}

	//* 删除奖池
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('bonus')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('bonus/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 分红详情
	public function log() {
		$BonusLog = D('BonusLogView');
		$map = array('bonus_id'=>array('eq', I('get.id')));
		$_count = $BonusLog->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $BonusLog->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('list', $_result);
		$this->display();
	}

	//* 级别列表
	public function level() {
		$BonusLevel = M('bonus_level');
		$_count = $BonusLevel->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $BonusLevel->order('num ASC,rate ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}
  
  	//* 星级达人
	public function star() {
		$BonusLevel = M('star');
		$_count = $BonusLevel->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $BonusLevel->order('num ASC,rate ASC')->limit($Page->firstRow.','.$Page->listRows)->select();
      foreach($_result as $k => $v){
      if($v['shenfen']==0){
      $_result[$k]['shenfen']='实名认证会员';
      }elseif($v['shenfen']==1){
      $_result[$k]['shenfen']='一星达人';
      }elseif($v['shenfen']==2){
      $_result[$k]['shenfen']='二星达人';
      }elseif($v['shenfen']==3){
      $_result[$k]['shenfen']='三星达人';
      }elseif($v['shenfen']==4){
      $_result[$k]['shenfen']='四星达人';
      }elseif($v['shenfen']==5){
      $_result[$k]['shenfen']='五星达人';
      }
      }
		$this->assign('list', $_result);
		$this->display();
	}
	//* 银行列表
	public function bank() {
		$BonusLevel = M('bank');
		$_count = $BonusLevel->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$type = M('country')->order('id DESC')->select();
		foreach($type as $k => $v){
			
		}
		    $this->assign('type', $type);
		$this->assign('page', $_page);
		$_result = $BonusLevel->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}
  
  //* 添加银行
	public function bank_add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'银行名称不能为空'));
			$data['countryid'] = $_post['countryid'] ? $_post['countryid'] : 0;
			$data['sort'] = $_post['sort'] ? $_post['sort'] : 0;
			$_result = M('bank')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('bonus/bank')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
  //* 编辑银行
	public function bank_edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'银行名称不能为空'));
			
			$data['sort'] = $_post['sort'] ? $_post['sort'] : 0;
			$data['countryid'] = $_post['countryid'] ? $_post['countryid'] : 0;
			$_result = M('bank')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$type = M('country')->order('id DESC')->select();
		    $this->assign('type', $type);
			$_result = M('bank')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}

//* 删除银行
	public function bank_del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('bank')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('bonus/bank')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
	//* 添加级别
	public function level_add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'级别名称不能为空'));
			$_post['num'] > 0 && intval($_post['num']) == abs($_post['num']) ? $data['num'] = $_post['num'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'直推人数必须为正整数'));
			$data['rate'] = $_post['rate'] ? $_post['rate'] : 0;
			if (!is_numeric($data['rate']) || $data['rate']<=0) $this->ajaxReturn(array('status'=>2, 'msg'=>'奖金池占流水比例必须为数字且大于0'));
			$data['status'] = 1;
			$_result = M('bonus_level')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('system/mission')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 编辑级别
	public function level_edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'级别名称不能为空'));
			$_post['num'] > 0 && intval($_post['num']) == abs($_post['num']) ? $data['num'] = $_post['num'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'经验值必须为正整数'));
			$data['rate'] = $_post['rate'] ? $_post['rate'] : 0;
			if (!is_numeric($data['rate']) || $data['rate']<=0) $this->ajaxReturn(array('status'=>2, 'msg'=>'交易手续费必须为数字且大于0'));
			$data['status'] = $_post['status'];
			$_result = M('bonus_level')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('bonus_level')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}

  //* 编辑级别
	public function star_edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			//$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'名称不能为空'));
			$_post['num'] > 0 && intval($_post['num']) == abs($_post['num']) ? $data['num'] = $_post['num'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'直推人数必须为正整数'));
			$data['rate'] = $_post['rate'] ? $_post['rate'] : 0;
          $data['huoyuedu'] = $_post['huoyuedu'] ? $_post['huoyuedu'] : 0;
          $data['shenfen'] = $_post['shenfen'] ? $_post['shenfen'] : 0;
          if (!is_numeric($data['huoyuedu']) || $data['huoyuedu']<=0) $this->ajaxReturn(array('status'=>2, 'msg'=>'团队基本活跃度必须为数字且大于0'));
			if (!is_numeric($data['rate']) || $data['rate']<=0) $this->ajaxReturn(array('status'=>2, 'msg'=>'分红比例必须为数字且大于0'));
			$data['status'] = $_post['status'];
			$_result = M('star')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
     
		$_result1 = M('star')->select();
		$this->assign('type', $_result1);
			$_result = M('star')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}
  
	//* 删除级别
	public function level_del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('bonus_level')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('bonus/level')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

}