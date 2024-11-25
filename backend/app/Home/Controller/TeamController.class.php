<?php
namespace Home\Controller;
use Think\Controller;
class TeamController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}

 //添加队伍
  public function addTeam(){
  if (IS_POST) {
     $User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
      if($_user['status']!=1){
		  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
       $team = M('team')->where(array('app_user_id'=>$_REQUEST['appUserId']))->find();
    if($team){
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'You have created a team and cannot add it again'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您已经创建组队，不能重复添加'));
    }
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     	if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent users'));
    if (empty($_REQUEST['img'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'The team mark cannot be empty'));
    if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Name cannot be empty'));
    if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['areaName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['jd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['wd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['brief'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Description cannot be empty'));
     }else{
		 	if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    if (empty($_REQUEST['img'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'队标不能为空'));
    if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'名称不能为空'));
    if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['areaName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['jd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['wd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['brief'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'描述不能为空'));
	 }

    $img=explode('/',$_REQUEST['img']);
    $image='/upload/image/'.$img[1];
			$Team = M('team');
			$_result = $Team->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
				'img' => $image,
              'name' => $_REQUEST['name'],
              'area' => $_REQUEST['area'],
              'area_name' => $_REQUEST['areaName'],
              'jd' => $_REQUEST['jd'],
              'wd' => $_REQUEST['wd'],
              'brief' => $_REQUEST['brief'],
              'create_date'=>time(),
              'update_date'=>time(),
			));
    if($_result){
      $Teamuser = M('team_user');
			$_result11 = $Teamuser->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
				'app_team_id' => $_result,
              'join_date'=>time(),
			));
      //addhuoyuedu($_REQUEST['appUserId'], 1, $this->conf['jiben']['jiazuduihyd'], '创建组队增加活跃度');
	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>1, 'msg'=>'Added Successfully'));
	  }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功'));
    }else{
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'Failure to add'));
	  }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'添加失败'));
    }
 
		}
  }
  //获取我的团队
  public function getMyTeam(){
  if (IS_POST) {
    $Teamuser = M('team_user');
			$map = array('app_user_id'=>$_REQUEST['appUserId']);
			$_teamuser = $Teamuser->where($map)->find();
      
			$map1 = array('app_team_id'=>$_teamuser['app_team_id']);
			$teamuserlist = M('team_user')->where($map1)->order('id ASC')->select();
			$map2 = array('id'=>$_teamuser['app_team_id']);
			$teaminfo = M('team')->where($map2)->find();
    $teaminfo['createDate']=date('Y-m-d H:i:s',$teaminfo['create_date']);
      $data['team']=$teaminfo;
    //获取当天时间
    $today=date('Y-m-d',time());
    foreach($teamuserlist as $k => $v){
      $userinfo = M('user')->where(array('id'=>$v['app_user_id']))->find();
$steplog = M('step_log')->where(array('userid'=>$v['app_user_id'],'add_time'=>$today))->find();
    $teamUser[$k]['user']['loginName']=substr_replace($userinfo['phone'],'****',3,4);
       $teamUser[$k]['act']['tgValue']=$userinfo['huoyuedu'];
       $teamUser[$k]['act']['clubAddValue']=0;
       $teamUser[$k]['act']['teamAddValue']=0;
      $teamUser[$k]['act']['missionAddValue']=0;
      $teamUser[$k]['step']=$steplog['step_count'];
      $teamUser[$k]['headImg']=$userinfo['avatar'];
    }
     $data['teamUser']=$teamUser;
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
	    //删除队伍
  public function deleteTeam(){
  if (IS_POST) {
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));

			$User = M('user');
			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    
    $team = M('team')->where(array('app_user_id'=>$_user['id']))->find();
     $count = M('team_user')->where("app_team_id=".$team['id'])->count();
    if($count>1){
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'Your team has been joined by others, the current status can not be disbanded'));
	  }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您的组队已经有其他人加入，当前状态不能解散'));
    }
$map = array('id'=>$team['id']);
			$_result = M('team')->where($map)->delete();
    $_result1 = M('team_user')->where(array('app_team_id'=>$team['id']))->delete();
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>1, 'msg'=>'Successful dissolution'));
	  }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'解散成功'));
		}
  }
  	    //退出队伍
  public function tuichuTeam(){
  if (IS_POST) {
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));

			$User = M('user');
			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    $map1 = array('app_user_id'=>$_user['id']);
			$teamuser = M('team_user')->where($map1)->find();
			if(!$teamuser){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }	
			}
	$map2 = array('user_id'=>$_user['id']);
       $hydinfo = M('huoyuedu_log')->where($map2)->order('id DESC')->find();
       if($hydinfo['create_time']>time()-2){
       		  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
       }
     $team = M('team')->where(array('id'=>$teamuser['app_team_id']))->find();
     if($teamuser['join_date']<time()){
 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 addhuoyuedu($team['app_user_id'], 3, (-1)*$this->conf['jiben']['jiazuduihyd'], 'Members withdraw from the team');
    addhuoyuedu($_user['id'], 3, (-1)*$this->conf['jiben']['jiazuduihyd'], 'Withdraw from the team');
	  }else{
		  addhuoyuedu($team['app_user_id'], 3, (-1)*$this->conf['jiben']['jiazuduihyd'], '有会员退出组队');
    addhuoyuedu($_user['id'], 3, (-1)*$this->conf['jiben']['jiazuduihyd'], '退出组队');
	  }
     }
    $_result1 = M('team_user')->where(array('app_user_id'=>$_user['id']))->delete();
	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
	  }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'退出成功'));
		}
  }
    //获取附近的人
  public function getNbUser(){
  if (IS_POST) {
   $User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
			//$map1['area'] = array('eq',$_REQUEST['area']);
            //$map1['id'] = array('neq',$_user['id']);
			$_teamuser = $User->where("id !='".$_user['id']."' and (area='".$_REQUEST['area']."' or citycode='".$_user['id']."')")->field('phone,area,avatar')->select();
foreach($_teamuser as $k => $v){
    $_teamuser[$k]['phone']=substr_replace($v['phone'],'****',3,4);
}
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$_teamuser));
		}
  }
  	    //加入组队
  public function joinTeam(){
  if (IS_POST) {
        $User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
      if($_user['status']!=1){
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
   if (empty($_REQUEST['appUserId'])) {
	     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent users'));
     }
	   $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
   }
 if (empty($_REQUEST['id'])){
	   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent team'));
     }
	 $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的组队'));
 } 
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    if(!$_user){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    }
     $teamuser = M('team_user')->where(array('app_user_id'=>$_REQUEST['appUserId']))->find();
    if($teamuser){
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'You have joined the team and cannot add it again'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您已经加入组队，不能重复添加'));
    }
    $team = M('team')->where(array('id'=>$_REQUEST['id']))->find();
     if(!$team){
		  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent team'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的组队'));
    }

$_result = M('team_user')->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
				'join_date' => time(),
              'app_team_id' => $_REQUEST['id'],
			));
    if($_result){
    	/*
  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      addhuoyuedu($_REQUEST['appUserId'], 3, $this->conf['jiben']['jiazuduihyd'], 'Join team');
      addhuoyuedu($team['app_user_id'], 3, $this->conf['jiben']['jiazuduihyd'], 'Members join the team');
     }else{
		 
		  addhuoyuedu($_REQUEST['appUserId'], 3, $this->conf['jiben']['jiazuduihyd'], '加入组队');
      addhuoyuedu($team['app_user_id'], 3, $this->conf['jiben']['jiazuduihyd'], '有会员加入组队');
	 }*/
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>1, 'msg'=>'Join success'));
     }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'加入成功'));
    }else{
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Failure to join'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'加入失败'));
    }
     
		}
  }
      //获取附近的队伍
  public function getNbTeam(){
  if (IS_POST) {
    $Team = M('team');
		 if($_REQUEST['id']){
    $userin = M('user')->where(array('id'=>$_REQUEST['id']))->find();
      $map1['citycode'] = $userin['citycode'];
    }else{
    $map1['area'] = $_REQUEST['area'];
    }
			$_team = $Team->where($map1)->select();
foreach($_team as $k => $v){
$_team[$k]['count']=M('team_user')->where("app_team_id=".$v['id'])->count();
}
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$_team));
		}
  }
}
