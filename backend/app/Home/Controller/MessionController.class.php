<?php
namespace Home\Controller;
use Think\Controller;
class MessionController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
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
  //获取任务
  public function getMission(){
  if (IS_POST) {
  
	$messionlist = M('mission')->where('1')->order('level ASC')->select();		

     $this->ajaxReturn(array('status'=>1, 'data'=>$messionlist));
		}
  }
  
    //购买任务
  public function buyMission(){
  if (IS_POST) {
    $userid = $_REQUEST['appUserId'];
    $User = M('user');

			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
  
   $missionId = $_REQUEST['missionId'];
    
    $Mession = M('mission')->where(array('id'=>$_REQUEST['missionId']))->find();

    if($Mession['price']>$_user['money']){
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>"You don't have enough candy."));
     }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'您的糖果不足哦'));
    }
     $usermessioncount = M('user_mission')->where("app_user_id='".$_user['id']."' and mission_id='".$missionId."' and end_date>'".time()."'")->count();
    if($usermessioncount<$Mession['all'] && $Mession['all']>0){
    $_result = M('user_mission')->add(array(
				'app_user_id' => $_user['id'],
                'parent_id' => $_user['invite_id'],
				'mission_id' => $missionId,
               'huoyue' => $Mession['huoyue'],
               'step' => $Mession['step'],
              'start_date' => time(),
              'end_date' => time()+($Mession['term']*86400),
              'status' => 0,
			));
	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $return1 = addtangguo($_user['id'], 1, (-1)*$Mession['price'], 'Exchange Task');
     }else{
		$return1 = addtangguo($_user['id'], 1, (-1)*$Mession['price'], '兑换任务'); 
	 }
      

      if($_user['invite_id']>0){
        $jiangli=$Mession['huoyue']*$this->conf['jiben']['dhjzjiahyd'];
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
        $return1 = addhuoyuedu($_user['invite_id'], 2, $jiangli, 'Recommended member '.$_user['phone'].' exchange task');
     }else{
        $return1 = addhuoyuedu($_user['invite_id'], 2, $jiangli, '直推会员'.$_user['phone'].'兑换任务');
	 }

      }
     
    }else{
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'The number of simultaneous possessions of the task is'.$Mession['all']));
     }  
    $this->ajaxReturn(array('status'=>0, 'msg'=>'该任务同时拥有数量为'.$Mession['all']));
    }
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>1, 'msg'=>"Successful Exchange"));
     }  
     $this->ajaxReturn(array('status'=>1, 'msg'=>'兑换成功'));
		}
  }
	    //我的任务
  public function mineMission(){
  if (IS_POST) {
   if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));

			$User = M('user');
			$map = array('token'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
       
    $usermission = M('user_mission')->where("end_date>'".time()."' and app_user_id='".$_user['id']."'")->select();
    $minemission=array();
foreach($usermission as $k => $v){
  $mission = M('mission')->where(array('id'=>$v['mission_id']))->find();
$minemission[$k]['startDate']=date('Y-m-d H:i:s',$v['start_date']);
  $minemission[$k]['endDate']=date('Y-m-d H:i:s',$v['end_date']);
  $minemission[$k]['bId']=$v['id'];
  if($v['isjiangli']==1){
  	$minemission[$k]['name']=$mission['name']."(系统奖励)";
  }else{
  	$minemission[$k]['name']=$mission['name'];
  }
  
  $minemission[$k]['step']=$mission['step'];
    $minemission[$k]['huoyue']=$mission['huoyue'];
      $minemission[$k]['price']=$mission['price'];
   $minemission[$k]['rewad']=$mission['rewad'];
     $minemission[$k]['level']=$mission['level'];
}

     $this->ajaxReturn(array('status'=>1, 'data'=>$minemission));
		}
  }
  
  	    //历史任务
  public function historyMission(){
  if (IS_POST) {
   if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));

			$User = M('user');
			$map = array('token'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
       
    $usermission = M('user_mission')->where("end_date<'".time()."' and app_user_id='".$_user['id']."'")->select();
    $minemission=array();
foreach($usermission as $k => $v){
  $mission = M('mission')->where(array('id'=>$v['mission_id']))->find();
$minemission[$k]['startDate']=date('Y-m-d H:i:s',$v['start_date']);
  $minemission[$k]['endDate']=date('Y-m-d H:i:s',$v['end_date']);
  $minemission[$k]['bId']=$v['id'];
  $minemission[$k]['name']=$mission['name'];
  $minemission[$k]['step']=$mission['step'];
    $minemission[$k]['huoyue']=$mission['huoyue'];
      $minemission[$k]['price']=$mission['price'];
   $minemission[$k]['rewad']=$mission['rewad'];
     $minemission[$k]['level']=$mission['level'];
}

     $this->ajaxReturn(array('status'=>1, 'data'=>$minemission));
		}
  }
 
}
