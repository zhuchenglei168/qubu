<?php
namespace Home\Controller;
use Think\Controller;
class SchoolController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}
  // 文章列表
	public function shcoolList() {
		$map = array('status'=>1,'type'=>$_REQUEST['type']);
		$_result = M('help')->where($map)->order('sort DESC,id DESC')->select();
      foreach($_result as $k => $v){
      $_result[$k]['content']=htmlspecialchars_decode($v['content']);
      $_result[$k]['encontent']=htmlspecialchars_decode($v['encontent']);
        $_result[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
	
	  // 文章列表
	public function gundongList() {
		$map = array('status'=>1,'gundong'=>1);
		$_result = M('help')->where($map)->order('sort DESC,id DESC')->select();
		if($_result){
			foreach($_result as $k => $v){
      $_result[$k]['content']=htmlspecialchars_decode($v['content']);
      $_result[$k]['encontent']=htmlspecialchars_decode($v['encontent']);
        $_result[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
      $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
		}else{

		$_result1 = M('user_mission')->order('id DESC')->limit(20)->select();
		if($_result1){
			foreach($_result1 as $k => $v){
            $userinfo = M('user')->where("id=".$v['app_user_id'])->find();
            $_result1[$k]['nickname']=substr_replace($userinfo['phone'],'****',3,4);
            $mission = M('mission')->where("id=".$v['mission_id'])->find();
            $_result1[$k]['name']=$mission['name'];
            $_result1[$k]['enname']=$mission['enname'];
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$_result1));
		}
      
 
	}
	}
 
}
