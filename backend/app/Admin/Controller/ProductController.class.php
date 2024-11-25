<?php
namespace Admin\Controller;
// 产品管理
class ProductController extends CommonController {

	//* 产品列表
	public function index() {
		$Product = M('product');
		$_count = $Product->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
      $type = M('type')->order('sort DESC,id DESC')->select();
		$this->assign('type', $type);
		$_result = $Product->order('sort DESC,id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
      foreach($_result as $k => $v){
       $typeinfo=M('type')->where('id='.$v['type'])->find();
        $_result[$k]['typename']=$typeinfo['name'];
      }
		$this->assign('list', $_result);
		$this->display();
	}

	//* 添加产品
	public function add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'产品标题不能为空'));
			is_numeric($_post['price']) && $_post['price']>=0 ? $data['price'] = $_post['price'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'产品价格必须是数字且不小于0'));
			intval($_post['stock']) == abs($_post['stock']) ? $data['stock'] = $_post['stock'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'库存总量必须是正整数'));
			intval($_post['remain']) == abs($_post['remain']) ? $data['remain'] = $_post['remain'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'剩余库存必须是正整数'));
			if ($_post['remain'] > $_post['stock']) $this->ajaxReturn(array('status'=>2, 'msg'=>'剩余库存不大于库存总量'));
			intval($_post['day_limit']) == abs($_post['day_limit']) ? $data['day_limit'] = $_post['day_limit'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'每日限购必须是正整数'));

			is_numeric($_post['profit']) && $_post['profit']>=0 ? $data['profit'] = $_post['profit'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'分润必须是数字且不小于0'));
			$data['type'] = $_post['type'];
          $data['img'] = $_post['img'];
			$data['sort'] = $_post['sort'];
          $data['content'] = $_post['content'];
			$data['status'] = 1;
			$_result = M('product')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('product/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

	//* 编辑产品
	public function edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['title'] ? $data['title'] = $_post['title'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'产品标题不能为空'));
			is_numeric($_post['price']) && $_post['price']>=0 ? $data['price'] = $_post['price'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'产品价格必须是数字且不小于0'));
			intval($_post['stock']) == abs($_post['stock']) ? $data['stock'] = $_post['stock'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'库存总量必须是正整数'));
			intval($_post['remain']) == abs($_post['remain']) ? $data['remain'] = $_post['remain'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'剩余库存必须是正整数'));
			if ($_post['remain'] > $_post['stock']) $this->ajaxReturn(array('status'=>2, 'msg'=>'剩余库存不大于库存总量'));
			intval($_post['day_limit']) == abs($_post['day_limit']) ? $data['day_limit'] = $_post['day_limit'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'每日限购必须是正整数'));

			is_numeric($_post['profit']) && $_post['profit']>=0 ? $data['profit'] = $_post['profit'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'分润必须是数字且不小于0'));
			$data['type'] = $_post['type'];
			$data['entitle'] = $_post['entitle'];
          $data['img'] = $_post['img'];
			$data['sort'] = $_post['sort'];
			$data['status'] = $_post['status'];
          $data['content'] = $_post['content'];
          $data['encontent'] = $_post['encontent'];
			$_result = M('product')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
          $type = M('type')->order('sort DESC,id DESC')->select();
		$this->assign('type', $type);
			$_result = M('product')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}

	//* 删除产品
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('product')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('product/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

  	//* 分类列表
	public function type() {
		$type = M('type');
		
		$_result = $type->order('sort DESC,id DESC')->select();
		$this->assign('list', $_result);
		$this->display();
	}
  
  //* 添加分类
	public function type_add() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array();
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'分类名称不能为空'));
			
			$data['sort'] = $_post['sort'];
          $data['add_time'] = time();
			$_result = M('type')->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功', 'url'=>U('product/type')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
  
  //* 编辑分类
	public function type_edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$_post['name'] ? $data['name'] = $_post['name'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'分类名称不能为空'));
			$_post['enname'] ? $data['enname'] = $_post['enname'] : $this->ajaxReturn(array('status'=>2, 'msg'=>'分类名称不能为空'));
			$data['sort'] = $_post['sort'];
			$_result = M('type')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('type')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}
  
  	//* 删除分类
	public function type_del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('type')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('product/type')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
}
