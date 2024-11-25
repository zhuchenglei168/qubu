<?php
namespace Home\Controller;
use Think\Controller;
class ClubController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}

 //添加队伍
  public function addClub(){
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
     $team = M('club_user')->where(array('app_user_id'=>$_REQUEST['appUserId']))->find();
    if($team){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'You have created a club and cannot add it again'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您已经创建俱乐部，不能重复添加'));
    }
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     	if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent users'));
    if (empty($_REQUEST['img'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'The club mark cannot be empty'));
    if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Name cannot be empty'));
    if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['areaName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['jd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['wd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['brief'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Description cannot be empty'));
     }else{
		 			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    if (empty($_REQUEST['img'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'俱乐部标志不能为空'));
      if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'名称不能为空'));
    			if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['areaName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
      if (empty($_REQUEST['jd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
         if (empty($_REQUEST['wd'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
      if (empty($_REQUEST['brief'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'描述不能为空'));
	 }
      $_REQUEST['jd'] = str_replace(" ", "", $_REQUEST['jd']);
      $_REQUEST['wd'] = str_replace(" ", "", $_REQUEST['wd']);
     $url='https://apis.map.qq.com/ws/geocoder/v1/?location='.$_REQUEST['wd'].','.$_REQUEST['jd'].'&key=ZAIBZ-2T2C4-RKTUX-DZ5QC-XDIXH-DXFAF';
    $content = file_get_contents($url);
    $palce=json_decode($content,true);

    $img=explode('/',$_REQUEST['img']);
    $image='/upload/image/'.$img[1];
			$Team = M('club');
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
              'citycode'=>$palce['result']['ad_info']['city_code'],
			));
    if($_result){
      $Teamuser = M('club_user');
			$_result11 = $Teamuser->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
				'app_team_id' => $_result,
              'join_date'=>time(),
			));
			 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>1, 'msg'=>'Added Successfully'));
	  }
      //addhuoyuedu($_REQUEST['appUserId'], 3, $this->conf['jiben']['jiajulebuhyd'], '创建俱乐部增加活跃度');
     $this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功'));
    }else{
	   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'Failure to add'));
	  }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'添加失败'));
    }
 
		}
  }
 //获取俱乐部数量
  
     public function getClubsCount(){
  if (IS_POST) {
    $club = M('club');
     if($_REQUEST['id']){
    $userin = M('user')->where(array('id'=>$_REQUEST['id']))->find();
      $map1['citycode'] = $userin['citycode'];
    }else{
    $map1['area'] = $_REQUEST['area'];
    }
    if(!empty($_REQUEST['name'])){
    $map1['name'] = ['like',"%".$_REQUEST['name']."%"];
    }
	$count = M('club')->where($map1)->order('id ASC')->count();		
     $this->ajaxReturn(array('status'=>1, 'data'=>$count));
		}
  }
  //获取俱乐部
  public function getClubs(){
  if (IS_POST) {
    if($_REQUEST['id']){
    $userin = M('user')->where(array('id'=>$_REQUEST['id']))->find();
      $map1['citycode'] = $userin['citycode'];
    }else{
    $map1['area'] = $_REQUEST['area'];
    }
    
    if(!empty($_REQUEST['name'])){
    $map1['name'] = ['like',"%".$_REQUEST['name']."%"];
    }
    $first=($_REQUEST['pageNum']-1)*$_REQUEST['pageSize'];
	$clublist = M('club')->where($map1)->order('id ASC')->limit($first.','.$_REQUEST['pageSize'])->select();		
foreach($clublist as $k => $v){
$clublist[$k]['count'] = M('club_user')->where(array('app_team_id'=>$v['id']))->count();
  $userinfo = M('user')->where(array('id'=>$v['app_user_id']))->find();
  $clublist[$k]['loginName']=$userinfo['phone'];
   $clublist[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
}
     $this->ajaxReturn(array('status'=>1, 'data'=>$clublist));
		}
  }
  
    //获取我的俱乐部
  public function getMyClub(){
  if (IS_POST) {
    $userid = $_REQUEST['appUserId'];
   $id = $_REQUEST['id'];
    $map1['app_user_id']=$userid;
    $map1['app_team_id']=$id;
	$clubinfo = M('club_user')->where($map1)->find();		
    $data['club']=$clubinfo;
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  
     //获取我的俱乐部成员
  public function getClubuser(){
  if (IS_POST) {
   $id = $_REQUEST['id'];
    $map1['app_team_id']=$id;
	$teamuserlist = M('club_user')->where($map1)->select();	
	 foreach($teamuserlist as $k => $v){
      $userinfo = M('user')->where(array('id'=>$v['app_user_id']))->find();
      $teamUser[$k]['phone']=substr_replace($userinfo['phone'],'****',3,4);
      $teamUser[$k]['area']=$userinfo['area'];
      $teamUser[$k]['avatar']=$userinfo['avatar'];
    }
     $this->ajaxReturn(array('status'=>1, 'data'=>$teamUser));
		}
  }
  	    //解散俱乐部
  public function jiesanClub(){
  if (IS_POST) {
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
 if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的俱乐部'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    if(!$_user){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    }
    $club = M('club')->where(array('id'=>$_REQUEST['id']))->find();
     if(!$club){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的俱乐部'));
    }

    if($club['app_user_id']!=$_REQUEST['appUserId']){
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'You are not the founder of the club'));
	  }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'您不是该俱乐部的创建者'));
    }
      $count = M('club_user')->where("app_team_id=".$_REQUEST['id'])->count();
    if($count>1){
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'Your club has been joined by others, the current status can not be disbanded'));
	  }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您的俱乐部已经有其他人加入，当前状态不能解散'));
    }
    $_result1 = M('club')->where("id=".$_REQUEST['id'])->delete();
  
$_result = M('club_user')->where("app_team_id=".$_REQUEST['id'])->delete();
    if($_result){
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>1, 'msg'=>'Successful dissolution'));
	  }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'解散成功'));
      //addhuoyuedu($_REQUEST['appUserId'], 3, (-1)*$this->conf['jiben']['jiajulebuhyd'], '解散俱乐部');
    }else{
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'解散失败'));
    }
     
		}
  }
	    //加入俱乐部
  public function joinClub(){
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
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
 if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的俱乐部'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    if(!$_user){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    }
    $clubuser = M('club_user')->where(array('app_user_id'=>$_REQUEST['appUserId']))->find();
    if($clubuser){
	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'You have joined the club and cannot add it again'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您已经加入俱乐部，不能重复添加'));
    }
    $club = M('club')->where(array('id'=>$_REQUEST['id']))->find();
     if(!$club){
		   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent club'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的俱乐部'));
    }

$_result = M('club_user')->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
				'join_date' => time(),
              'app_team_id' => $_REQUEST['id'],
			));
    if($_result){
 
          M('club')->save(array(
					'id' => $club['id'],
					'huoyuedu' => $club['huoyuedu']+$this->conf['jiben']['jiajulebuhyd'],  
				));
	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      addhuoyuedu($club['app_user_id'], 3, $this->conf['jiben']['jiajulebuhyd'], 'Members join the club');
      addhuoyuedu($_REQUEST['appUserId'], 3, $this->conf['jiben']['jiajulebuhyd'], 'join club');
     }else{
		 addhuoyuedu($club['app_user_id'], 3, $this->conf['jiben']['jiajulebuhyd'], '有会员加入俱乐部');
      addhuoyuedu($_REQUEST['appUserId'], 3, $this->conf['jiben']['jiajulebuhyd'], '加入俱乐部');
	 }
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>1, 'msg'=>'Join success'));
     }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'加入成功'));
    }else{
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Failure to club'));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'加入失败'));
    }
     
		}
  }
 	    //退出俱乐部
  public function quitClub(){
  if (IS_POST) {
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
 if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的俱乐部'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    if(!$_user){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    }
    $club = M('club')->where(array('id'=>$_REQUEST['id']))->find();
     if(!$club){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的俱乐部'));
    }
    $clubuser = M('club_user')->where(array('app_user_id'=>$_REQUEST['appUserId'],'app_team_id'=>$_REQUEST['id']))->find();
    if(!$clubuser){
		
     $this->ajaxReturn(array('status'=>0, 'msg'=>'您还没加入该俱乐部哦'));
    }
$_result = M('club_user')->where("id=".$clubuser['id'])->delete();
    if($_result){
if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		addhuoyuedu($club['app_user_id'], 3, (-1)*$this->conf['jiben']['jiajulebuhyd'], 'Members quit the club');
      addhuoyuedu($_REQUEST['appUserId'], 3, (-1)*$this->conf['jiben']['jiajulebuhyd'], 'Quit club');
	  }else{
		  addhuoyuedu($club['app_user_id'], 3, (-1)*$this->conf['jiben']['jiajulebuhyd'], '有会员退出俱乐部');
      addhuoyuedu($_REQUEST['appUserId'], 3, (-1)*$this->conf['jiben']['jiajulebuhyd'], '退出俱乐部');
	  }
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
	  }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'退出成功'));
    }else{
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'退出失败'));
    }
     
		}
  }
}
