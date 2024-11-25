<?php
namespace Admin\Controller;
// 分润管理
class ProfitController extends CommonController {

	//* 分润记录
	public function index() {
		$Profit = D('ProfitView');

		$map = array();
		if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));
		if (I('get.trade_no')) $map['trade_no'] = array('eq', I('get.trade_no'));
		if (isset($_GET['time'])) {
			$today = strtotime(date('Y-m-d'));
			$yestoday = strtotime(date('Y-m-d', strtotime('-1 day')));
			$week = strtotime(date('Y-m-d', strtotime('-1 week')));
			$month = strtotime(date('Y-m-d', strtotime('-1 month')));
			switch (I('get.time')) {
				case 1:
					$map['create_time'] = array('egt', $today);
					break;
				case 2:
					$map['create_time'] = array('between', array($yestoday, $today));
					break;
				case 3:
					$map['create_time'] = array('egt', $week);
					break;
				case 4:
					$map['create_time'] = array('egt', $month);
					break;
			}
		}

		$_count = $Profit->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $Profit->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('list', $_result);
		$this->display();
	}

	//* 删除分润记录
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('profit')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('profit/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 分润返点记录
	public function distrib() {
		$DistribProfit = D('DistribProfitView');

		$map = array();
		if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$today = strtotime(date('Y-m-d'));
		$yestoday = strtotime(date('Y-m-d', strtotime('-1 day')));
		$week = strtotime(date('Y-m-d', strtotime('-1 week')));
		$month = strtotime(date('Y-m-d', strtotime('-1 month')));
		switch (I('get.time')) {
			case 1:
				$map['create_time'] = array('egt', $today);
				break;
			case 2:
				$map['create_time'] = array('between', array($yestoday, $today));
				break;
			case 3:
				$map['create_time'] = array('egt', $week);
				break;
			case 4:
				$map['create_time'] = array('egt', $month);
				break;
		}

		$_count = $DistribProfit->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $DistribProfit->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('list', $_result);
		$this->display();
	}

	//* 删除分润返点记录
	public function distrib_del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('distrib_profit')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('profit/distrib')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

}