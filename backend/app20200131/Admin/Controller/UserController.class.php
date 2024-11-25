<?php
namespace Admin\Controller;
// 会员管理
class UserController extends CommonController {

	//* 会员列表
	public function index() {
		$User = M('user');

		$map = array();
		if (I('get.id')) $map['id'] = array('eq', I('get.id'));
		if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));
		if (I('get.bankno')) $map['bankno'] = array('eq', I('get.bankno'));

		$_count = $User->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$list=I('get.list');
		if($list){
			$order=$list;
			}else{
				$order='id';
			}
		$_result = $User->where($map)->order($order.' DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($_result as $k=>$v) {
			if($v['deviceid']==''){
				$_result[$k]['consume']='<span style="color:#27c24c">未登录</span>';
			}else{
				if(strpos($v['deviceid'],'-') !== false){ 
	           $_result[$k]['consume']='<span style="color:#ff0000">苹果用户</span>';
                }else{
              	$_result[$k]['consume']='安卓用户';
                }
			
			}
			if ($v['invite_id']) $_result[$k]['invite'] = $User->find($v['invite_id']);
          if($v['status']==0){
          $_result[$k]['status']='未认证';
          }elseif($v['status']==1){
          $_result[$k]['status']='已认证';
          }elseif($v['status']==3){
          $_result[$k]['status']='已冻结';
          }else{
          $_result[$k]['status']='待审核';
          }
		}
		$this->assign('list', $_result);
		$this->display();
	}
  	//* 跑步记录
	public function fk() {
		$fk = M('fk');

		$map = array();
		if (I('get.id')) $map['user_id'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$_count = $fk->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $fk->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list', $_result);
		$this->display();
	}
	//* 跑步记录
	public function steplog() {
		$steplog = M('step_log');

		$map = array();
		if (I('get.id')) $map['userid'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$_count = $steplog->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $steplog->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list', $_result);
		$this->display();
	}
  	//* 糖果明细
	public function tangguolog() {
		$tangguolog = M('tangguo_log');

		$map = array();
		if (I('get.id')) $map['user_id'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$_count = $tangguolog->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $tangguolog->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list', $_result);
		$this->display();
	}
  	//* 活跃度明细
	public function huoyuelog() {
		$huoyuelog = M('huoyuedu_log');

		$map = array();
		if (I('get.id')) $map['user_id'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$_count = $huoyuelog->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $huoyuelog->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list', $_result);
		$this->display();
	}
   	//* 贡献明细
	public function gongxianlog() {
		$gongxianlog = M('gongxian_log');

		$map = array();
		if (I('get.id')) $map['user_id'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$_count = $gongxianlog->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $gongxianlog->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list', $_result);
		$this->display();
	}
   	//* 会员任务
	public function usermission() {
		$usermission = M('user_mission');

		$map = array();
		if (I('get.id')) $map['app_user_id'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));
        $list=I('get.list');
		if($list){
			$order=$list;
		}else{
			$order='id';
		}
		$_count = $usermission->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $usermission->where($map)->order($order.' DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($_result as $k=>$v) {
			$missioninfo = M('mission')->where("id=".$v['mission_id'])->find();
          $_result[$k]['missionname']=$missioninfo['name'];
		}
		$this->assign('list', $_result);
		$this->display();
	}
   	//* 会员交易
	public function market() {
		$market = M('market');

		$map = array();
		if (I('get.id')) $map['id'] = array('eq', I('get.id'));
		//if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));

		$_count = $market->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $market->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($_result as $k=>$v) {
		if($v['type']==0){
		$_result[$k]['type']='买单';
		}else{
		$_result[$k]['type']='<span style="color:#ff0000">卖单</span>';
		}
          if($v['status']==0){
          $_result[$k]['zhuangtai']='发布中';
          }else if($v['status']==1){
          $_result[$k]['zhuangtai']='已成交';
          }else if($v['status']==2){
          $_result[$k]['zhuangtai']='交易中（待付款）';
          }else if($v['status']==3){
          $_result[$k]['zhuangtai']='交易中（已付款，待确认）';
          }

		}
		$this->assign('list', $_result);
		$this->display();
	}
  //* 会员列表
	public function daish() {
		$User = M('user');

		$map = array();
		if (I('get.id')) $map['id'] = array('eq', I('get.id'));
		if (I('get.phone')) $map['phone'] = array('eq', I('get.phone'));
        $map['status']=array('eq', 1);
		$_count = $User->where($map)->count();
		$Page = new \Think\Page($_count, C('PAGE_SIZE'));
		$_page = $Page->show();
		$this->assign('page', $_page);
		$_result = $User->where($map)->order('id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
      
		foreach ($_result as $k=>$v) {
			if ($v['invite_id']>0) $_result[$k]['invite'] = $User->find($v['invite_id']);
          if($v['status']==1){
          $_result[$k]['status']='已认证';
          }else{
          $_result[$k]['status']='待审核';
          }
		}
      
      
		$this->assign('list', $_result);
		$this->display();
	}
	//* 添加会员
	public function add() {
		if (IS_POST) {
				$_post = I('post.');
			$data = array();
			$User = M('user');
			// 推荐人
			if (empty($_post['phone'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'手机号不能为空'));
			if (empty($_post['invite'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'推荐人不能为空'));
			if ($_post['invite']) {
				$map = array(
					'phone' => array('eq', $_post['invite']),
					'status' => array('eq', 1),
				);
				$_invite = $User->where($map)->find();
				if (empty($_invite)) $this->ajaxReturn(array('status'=>2, 'msg'=>'该推荐人信息不存在'));
				$data['invite_id'] = $_invite['id'];
								if($_invite['invites']==''){
    $data['invites']=$_invite['id'];
    }else{
    $data['invites']=$_invite['id'].','.$_invite['invites'];
    }
			}
		    if (empty($_post['password'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'密码不能为空'));
		   // if (empty($_post['level'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'等级不能为空'));
		    $data['phone'] = $_post['phone'];
			$data['nickname'] = $_post['nickname'];
			if ($_post['password']) $data['password'] = get_sha($_post['password']);
			if ($_post['changepass']) $data['changepass'] = get_sha($_post['changepass']);
			$data['alipay'] = $_post['alipay'];
			$data['realname'] = $_post['realname'];
            $data['area'] = $_post['area'];
			$data['status'] = $_post['status'];
          $data['jingdu'] = $_post['jingdu'];
           $data['weidu'] = $_post['weidu'];
          $data['level'] = $_post['level'];
			$_result = $User->add($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'添加失败'));
			}
		} else {
			
			$this->display();
		}
	}
	//* 编辑会员
	public function edit() {
		if (IS_POST) {
			$_post = I('post.');
			$data = array('id'=>I('get.id'));
			$User = M('user');
			// 推荐人
			if ($_post['invite']) {
				$map = array(
					'phone' => array('eq', $_post['invite']),
					'status' => array('eq', 1),
				);
				$_invite = $User->where($map)->find();
				if (empty($_invite)) $this->ajaxReturn(array('status'=>2, 'msg'=>'该推荐人信息不存在'));
				if ($_invite['id'] == $data['id']) $this->ajaxReturn(array('status'=>2, 'msg'=>'推荐人不能为自己'));
				$data['invite_id'] = $_invite['id'];
				if($_invite['invites']==''){
    $data['invites']=$_invite['id'];
    }else{
    $data['invites']=$_invite['id'].','.$_invite['invites'];
    }
			}
			$data['nickname'] = $_post['nickname'];
			if ($_post['password']) $data['password'] = get_sha($_post['password']);
			if ($_post['changepass']) $data['changepass'] = get_sha($_post['changepass']);
			$data['alipay'] = $_post['alipay'];
			$data['realname'] = $_post['realname'];
			$data['lastrztime'] = $_post['lastrztime'];
            $data['area'] = $_post['area'];
			$data['status'] = $_post['status'];
			$data['mian'] = $_post['mian'];
          $data['jingdu'] = $_post['jingdu'];
           $data['weidu'] = $_post['weidu'];
           $data['deviceid'] = $_post['deviceid'];
          $data['level'] = $_post['level'];
          $data['star'] = $_post['star'];
			$_result = $User->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('user')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}
	//* 编辑糖果
	public function tgedit() {
		if (IS_POST) {
			$_post = I('post.');
			$_result = M('user')->find(I('get.id'));
			$num = $_post['num'];
          $_result= addtangguo(I('get.id'), 5, $num, '系统奖励');
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'编辑成功'));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'编辑失败'));
			}
		} else {
			$_result = M('user')->find(I('get.id'));
			$this->assign('data', $_result);
			$this->display();
		}
	}

	//* 删除会员
	public function del() {
		if (IS_POST) {
			$ids = I('post.ids');
			$map = array('id'=>array('in', $ids));
			$_result = M('user')->where($map)->delete();
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功', 'url'=>U('user/index')));
			} else {
				$this->ajaxReturn(array('status'=>2, 'msg'=>'删除失败'));
			}
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}

  	//* 结算交易
	public function jiesuanjy() {
		if (IS_POST) {
			
				$market = M('market');
			$map = array('id'=>$_REQUEST['id']);
			$marketinfo = $market->where($map)->find();
          if($marketinfo['status']<=1){
          $this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
          }
       $User = M('user');
			$map = array('id'=>$marketinfo['s_user_id']);
			$_user = $User->where($map)->find();

          M('market')->save(array(
					'id' => $_REQUEST['id'],
                    'status' => 1, 
                    'confirm_date' => time(),
				));
      //addtangguo($marketinfo['b_user_id'], 1, $marketinfo['shijinum'], '订单ID'.$marketinfo['id'].'交易成功，获得糖果');
      //这里扣除手续费
      //手续费放入奖金池
      /*$money=($marketinfo['num']-$marketinfo['shijinum'])*$marketinfo['price'];
       M('bonus_log')->add(array(
				'user_id' => $marketinfo['s_user_id'],
              'bonus_id' => $marketinfo['id'],
              'money' => $money,
              'create_time' => time(),
			));
      //获取今日时间
      $todaytime=strtotime(date('Y-m-d',time()));
      $bonus = M('bonus');
	  $map1 = array('create_time'=>$todaytime);
	  $bonusinfo = $bonus->where($map1)->find();
      if($bonusinfo){
       M("bonus")->where($map1)->setInc('money', $money);
      }else{
      M('bonus')->add(array(
              'money' => $money,
              'create_time' => $todaytime,
			));
      }
      */
      $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
  
  //* 取消交易
	public function quxiaojy() {
		if (IS_POST) {
			
				$market = M('market');
			$map = array('id'=>$_REQUEST['id']);
			$marketinfo = $market->where($map)->find();
          if($marketinfo['status']!=3){
          $this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
          }
       $User = M('user');
			$map = array('id'=>$marketinfo['s_user_id']);
			$_user = $User->where($map)->find();
if($marketinfo['type']==1){
          M('market')->save(array(
					'id' => $_REQUEST['id'],
                    'status' => 0, 
                    'b_user_id' => 0, 
                    'buy_date' => 0, 
                    'confirm_date' => 0,
                    'pay_date' => 0,
                    'img' => '',
				));	
}else{
	M('market')->save(array(
					'id' => $_REQUEST['id'],
                    'status' => 0, 
                    'buy_date' => 0, 
                    'confirm_date' => 0,
                    'pay_date' => 0,
                    'img' => '',
				));	
}

      
      $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
		} else {
			$this->ajaxReturn(array('status'=>2, 'msg'=>'非法操作'));
		}
	}
	
	   //* 删除交易
	public function deljy() {

				$market = M('market');
			$map = array('id'=>$_REQUEST['id']);
			$marketinfo = $market->where($map)->find();
          if($marketinfo['status']!=0 && $marketinfo['type']!=0 ){
            $this->error('非法操作');

          }
$market->where($map)->delete();

$this->success('操作成功');
      

	}
	//* 层级关系
	public function relation() {
		if (I('get.phone')) {
			$User = M('user');
			$map = array('phone'=>array('eq', I('get.phone')));
			$_user = $User->where($map)->find();
			$this->assign('user', $_user);
			// 分销配置
			//$_config = json_decode(M('config')->where(array('id'=>array('eq', 1)))->getField('distrib'), true);
			$_team = get_team($_user['id'], 100, '*', '*');
			//var_dump($_team);
			$this->assign('team', $_team);
		}
		$this->display();
	}

}