<?php
namespace Admin\Controller;
// 帮助中心
class HelpController extends CommonController {

	//* 帮助列表
	public function index() {
		$Help = M('help');
		$_count = $Help->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $Help->order('sort DESC,id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list', $_result);
		$this->display();
	}

	//* 添加帮助
	public function add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'标题不能为空'));
			if (empty($_post['slug'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'缩略名不能为空'));
			$Help = M('help');
			$map = array('slug'=>array('eq', $_post['slug']));
			$_help = $Help->where($map)->find();
			empty($_help) ? $data['slug'] = $_post['slug'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'缩略名已存在'));
			$data['sort'] = $_post['sort'];
            $data['cover'] = $_post['cover'];
            $data['type'] = $_post['type'];
			$data['content'] = $_post['content'];
			$data['status'] = 1;
			$data['create_date']=time();
			$_result = M('help')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('help/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 编辑帮助
	public function edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'标题不能为空'));
			if (empty($_post['slug'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'缩略名不能为空'));
			$Help = M('help');
			$map = array('slug'=>array('eq', $_post['slug']));
			$_help = $Help->where($map)->find();
			empty($_help) || $_help['id'] == $data['id'] ? $data['slug'] = $_post['slug'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'缩略名已存在'));
			$data['url'] = $_post['url'];
            $data['cover'] = $_post['cover'];
            $data['type'] = $_post['type'];
			$data['sort'] = $_post['sort'];
			$data['entitle'] = $_post['entitle'];
			$data['content'] = $_post['content'];
			$data['encontent'] = $_post['encontent'];
			$data['status'] = $_post['status'];
			$data['gundong'] = $_post['gundong'];
			$data['create_date']=time();
			$_result = M('help')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('help')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}

	//* 删除帮助
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('help')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('help/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

}