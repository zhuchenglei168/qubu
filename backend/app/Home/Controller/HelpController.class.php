<?php
namespace Home\Controller;
use Think\Controller;
class HelpController extends CommonController {

	// 列表
	public function index() {
		$map = array('status'=>array('eq', 1));
		$_result = M('help')->where($map)->order('sort DESC,id DESC')->select();
		$this->assign('list', $_result);
		$this->display();
	}

	// 详情
	public function detail() {
		$map = array(
			'slug'=>array('eq', I('get.slug')),
			'status'=>array('eq', 1),
		);
		$_result = M('help')->where($map)->find();
		if (empty($_result)) $this->error('您访问的页面丢失了~');
		$this->assign('data', $_result);
		$this->display();
	}

}