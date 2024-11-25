<?php
namespace Admin\Controller;
// 幻灯管理
class SlideController extends CommonController {

	//* 幻灯列表
	public function index() {
		$Slide = M('slide');
		$_count = $Slide->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $Slide->order('sort DESC,id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}

//* 国家列表
	public function duoguo() {
		$Country = M('country');
		$_count = $Country->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $Country->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}
	//* 添加幻灯
	public function add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'幻灯标题不能为空'));
			$data['cover'] = $_post['cover'];
			$data['url'] = $_post['url'];
			$data['sort'] = $_post['sort'];
			$data['create_time'] = NOW_TIME;
			$data['status'] = 1;
			$_result = M('slide')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('slide/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

//* 添加国家
	public function addcountry() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'国家名称不能为空'));
			$data['cover'] = $_post['cover'];
			$data['quhao'] = $_post['quhao'];
			$data['huilv'] = $_post['huilv'];
			$data['fuhao'] = $_post['fuhao'];
			$data['status'] = 1;
			$_result = M('country')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('slide/duoguo')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
	//* 编辑幻灯
	public function edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'幻灯标题不能为空'));
			$data['cover'] = $_post['cover'];
			$data['url'] = $_post['url'];
			$data['sort'] = $_post['sort'];
			$data['status'] = $_post['status'];
			$_result = M('slide')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('slide')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}
	//* 编辑国家
	public function editcountry() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
				$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'国家名称不能为空'));
				$data['cover'] = $_post['cover'];
			$data['quhao'] = $_post['quhao'];
			$data['huilv'] = $_post['huilv'];
			$data['fuhao'] = $_post['fuhao'];
			$data['status'] = $_post['status'];
			$_result = M('country')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('country')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}
	//* 删除幻灯
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('slide')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('slide/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

}