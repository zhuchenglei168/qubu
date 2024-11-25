<?php
namespace Home\Controller;
use Think\Controller;
class FriendController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}

 //发布朋友圈
  public function addFriend(){
  if (IS_POST) {
			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    if (empty($_REQUEST['img'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请添加图片'));
    			if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['areaName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));

  
    $image=str_replace("_downloads","/upload/image",$_REQUEST['img']);
   // $image='/upload/image/'.$img[1];
			$friend = M('friend');
			$_result = $friend->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
				'img' => $image,
              'area' => $_REQUEST['area'],
              'area_name' => $_REQUEST['areaName'],
              'content' => $_REQUEST['content'],
              'tip' => $_REQUEST['tip'],
              'create_date'=>time(),
              'top_term'=>time(),
			));
    if($_result){
    
     $this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功'));
    }else{
     $this->ajaxReturn(array('status'=>0, 'msg'=>'添加失败'));
    }
 
		}
  }
 //获取俱乐部数量
  
     public function getClubsCount(){
  if (IS_POST) {
    $club = M('club');
    $map1['area'] = $_REQUEST['area'];
    if(!empty($_REQUEST['name'])){
    $map1['name'] = ['like',"%".$_REQUEST['name']."%"];
    }
	$count = M('club')->where($map1)->order('id ASC')->count();		
     $this->ajaxReturn(array('status'=>1, 'data'=>$count));
		}
  }
  //获取朋友圈
  public function getQz(){
  if (IS_POST) {
    $map1['app_user_id'] = $_REQUEST['appUserId'];
   
    //$first=($_REQUEST['pageNum']-1)*$_REQUEST['pageSize'];
	$friendlist = M('friend')->where($map1)->order('id DESC')->limit($first.','.$_REQUEST['pageSize'])->select();		
foreach($friendlist as $k => $v){
$friendlist[$k]['comment'] = M('friend_comment')->where(array('app_friend_id'=>$v['id']))->select();
  $userinfo = M('user')->where(array('id'=>$v['app_user_id']))->find();
  $friendlist[$k]['loginName']=$userinfo['phone'];
   $friendlist[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
  
}
     $this->ajaxReturn(array('status'=>1, 'data'=>$friendlist));
		}
  }
  
    //获取朋友圈
  public function friendByArea(){
  if (IS_POST) {
    $map1['app_user_id'] = $_REQUEST['appUserId'];
   
    //$first=($_REQUEST['pageNum']-1)*$_REQUEST['pageSize'];
	$friendlist = M('friend')->where($map1)->order('id DESC')->limit($first.','.$_REQUEST['pageSize'])->select();		
foreach($friendlist as $k => $v){
$friendlist[$k]['comment'] = M('friend_comment')->where(array('app_friend_id'=>$v['id']))->select();
  
  $userinfo = M('user')->where(array('id'=>$v['app_user_id']))->find();
  $friendlist[$k]['headImg']=$userinfo['avatar'];
  $friendlist[$k]['loginName']=$userinfo['phone'];
   $friendlist[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
}
     $this->ajaxReturn(array('status'=>1, 'data'=>$friendlist));
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
	    //删除信息
  public function delete(){
  if (IS_POST) {
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
if (empty($_REQUEST['appFriendId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的信息'));
			$User = M('user');
			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    
    $friend = M('friend')->where(array('app_user_id'=>$_user['id'],'id'=>$_REQUEST['appFriendId']))->find();
$map = array('id'=>$friend['id']);
			$_result = M('friend')->where($map)->delete();
     $this->ajaxReturn(array('status'=>1, 'msg'=>'删除成功'));
		}
  }
  
  	    //评论
  public function addPl(){
  if (IS_POST) {
   if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
if (empty($_REQUEST['appFriendId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的信息'));
    if (empty($_REQUEST['content'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'评价内容不能为空'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    if(empty($_user)){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    }
    $friend = M('friend')->where(array('app_user_id'=>$_user['id'],'id'=>$_REQUEST['appFriendId']))->find();

    $friendcomment = M('friend_comment');
			$_result = $friendcomment->add(array(
				'app_user_id' => $_REQUEST['appUserId'],
              'app_friend_id' => $_REQUEST['appFriendId'],
              'content' => $_REQUEST['content'],
              'nickname' => $_user['phone'],
              'create_date'=>time(),
			));
    if($_result){
    
     $this->ajaxReturn(array('status'=>1, 'msg'=>'评论成功'));
    }else{
     $this->ajaxReturn(array('status'=>0, 'msg'=>'评论失败'));
    }
 
		}
  }
    //获取附近的人
  public function getNbUser(){
  if (IS_POST) {
    $Teamuser = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_teamuser = $Teamuser->where($map)->select();

    
     $this->ajaxReturn(array('status'=>1, 'data'=>$_teamuser));
		}
  }
  
      //获取附近的队伍
  public function getNbTeam(){
  if (IS_POST) {
    $Teamuser = M('team');
		//$map = array('id'=>$_REQUEST['id']);
			$_teamuser = $Teamuser->select();

    
     $this->ajaxReturn(array('status'=>1, 'data'=>$_teamuser));
		}
  }
}
