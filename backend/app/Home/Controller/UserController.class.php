<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}
   
  //APP注册
  public function regist(){
  	//$this->ajaxReturn(array('status'=>0, 'msg'=>'疫情期间平台支持防疫工作，暂停注册'));
          if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     if (empty($_REQUEST['msgCode'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Verification code cannot be empty'));
			if (empty($_REQUEST['invitedId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Introduce code cannot be empty'));
     if (empty($_REQUEST['loginName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number cannot be empty'));
			if (empty($_REQUEST['loginPass'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Password cannot be empty'));
            if (empty($_REQUEST['countryid'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please select a country first'));
     }else{
      if (empty($_REQUEST['msgCode'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'验证码不能为空'));
			if (empty($_REQUEST['invitedId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'推荐码不能为空'));
     if (empty($_REQUEST['loginName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
			if (empty($_REQUEST['loginPass'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'密码不能为空'));
             if (empty($_REQUEST['countryid'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请先选择国家'));
     }


    
    $smscode = M('smscode');
			$map['phone'] = $_REQUEST['loginName'];
           $map['code'] = $_REQUEST['msgCode'];
			$codeinfo = $smscode->where($map)->find();
    if($codeinfo){
    if($codeinfo['add_time']<time()-1800){
      //暂时屏蔽验证码
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone validation code has expired'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码已过期'));
    }
    }else{
      //暂时屏蔽验证码
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone verification code is incorrect'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码不正确'));
    }
			$User = M('user');
			$map = array('phone'=>$_REQUEST['loginName']);
			$_user = $User->where($map)->find();
			if (!empty($_user)){
			  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has been registered'));
      }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'该手机号已注册'));
			}
    $map1 = array('id'=>$_REQUEST['invitedId']);
			$_tuijianinfo = $User->where($map1)->find();
    if(empty($_tuijianinfo)){
    	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Introduce code does not exist'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'推荐码不存在'));
    }
    if($_tuijianinfo['invites']==''){
    $invites=$_REQUEST['invitedId'];
    }else{
    $invites=$_REQUEST['invitedId'].','.$_tuijianinfo['invites'];
    }
    $_result = $User->add(array(
				'quhao' => $_REQUEST['quhao'],
                'countryid' => $_REQUEST['countryid'],
                'countryimg' => $_REQUEST['countryimg'],
                'countryname' => $_REQUEST['countryname'],
                'phone' => $_REQUEST['loginName'],
				'password' => get_sha($_REQUEST['loginPass']),	
                'nickname' =>  '',
				'avatar' =>  '',
				'create_time' => NOW_TIME,
				'create_ip' => get_client_ip(true),
				'invite_id' => $_REQUEST['invitedId'],
                'invites' => $invites,
                'alipay' => '',
				'realname' => '',
				'status' => 0,
			));
   
    if($_result){
      M("user")->where('id in('.$invites.')')->setInc('tdzrs', 1);
      
      
        if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Registration was successful'));
      }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'注册成功'));
    }else{
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Registration was fail'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'注册失败'));
    }
  }
  	// 会员注册
	public function reg() {
		//header("location:/index/appdownload");
		//exit;
		//$this->ajaxReturn(array('status'=>0, 'msg'=>'疫情期间平台支持防疫工作，暂停注册'));
		// 防封域名跳转
		//if ($this->conf['more']['domain'] && I('server.HTTP_HOST') != $this->conf['more']['domain']) redirect('http://'.$this->conf['more']['domain'].I('server.REQUEST_URI'));
		// 邀请人
		$Crypt = new \Think\Crypt();
		
		$auth_info = session('auth_info');
		if (IS_POST) {
			//$this->ajaxReturn(array('status'=>0, 'msg'=>'疫情期间平台支持防疫工作，暂停注册'));
			$post = I('post.');
			$invite_id = intval($post['from']);
		// 检测手机号码是否重复
		$User = M('user');
		$_from = $User->find($invite_id);
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
			if ($this->conf['jiben']['reg_status'] != 1) $this->ajaxReturn(array('status'=>0, 'msg'=>'New user registration closed'));
			if (!$_from) $this->ajaxReturn(array('status'=>0, 'msg'=>'Invitation link has expired'));
			if (strlen($post['password'])<6) $this->ajaxReturn(array('status'=>0, 'msg'=>'Password digits must not be less than 6'));
		//	if (!is_phone($post['phone'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Error in mobile phone number'));
              if (intval($_REQUEST['quhao'])==0) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please select a country first'));
			}else{
			if ($this->conf['jiben']['reg_status'] != 1) $this->ajaxReturn(array('status'=>0, 'msg'=>'新用户注册已关闭'));
			if (!$_from) $this->ajaxReturn(array('status'=>0, 'msg'=>'邀请码不存在'));
			if (strlen($post['password'])<6) $this->ajaxReturn(array('status'=>0, 'msg'=>'密码位数不能小于6'));
		   //if (!is_phone($post['phone'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号码有误'));
               if (intval($_REQUEST['quhao'])==0) $this->ajaxReturn(array('status'=>0, 'msg'=>'请先选择国家'));
			}
			
            $smscode = M('smscode');
			$map['phone'] = $_REQUEST['phone'];
           $map['code'] = $_REQUEST['phonecode'];
			$codeinfo = $smscode->where($map)->find();
    if($codeinfo){
    if($codeinfo['add_time']<time()-1800){
       //暂时屏蔽验证码
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone validation code has expired'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码已过期'));
    }
    }else{
       //暂时屏蔽验证码
        if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone verification code is incorrect'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码不正确'));
    }
$map1 = array('id'=>$invite_id);
			$_tuijianinfo = $User->where($map1)->find();
    if(empty($_tuijianinfo)){
    	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Introduce code does not exist'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'推荐码不存在'));
    }
              if($_tuijianinfo['invites']==''){
    $invites=$invite_id;
    }else{
    $invites=$invite_id.','.$_tuijianinfo['invites'];
    }
			$_exist = $User->where(array('phone'=>array('eq', $post['phone'])))->find();
			if ($_exist){
					  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has been registered'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机已被使用'));
			} 
$map3 = array('quhao'=>$_REQUEST['quhao']);
			$country = M('country')->where($map3)->find();
          if(!$country){
          $this->ajaxReturn(array('status'=>0, 'msg'=>'国家不存在'));
          }
			$_result = $User->add(array(
              'quhao' => $_REQUEST['quhao'],
                'countryid' => $country['id'],
                'countryimg' => $country['cover'],
                'countryname' => $country['name'],
				'phone' => $post['phone'],
				'password' => get_sha($post['password']),
				'openid' => $auth_info ? $auth_info['openid'] : '',
				'nickname' => $auth_info ? $auth_info['nickname'] : '',
				'avatar' => $auth_info ? $auth_info['headimgurl'] : '',
				'create_time' => NOW_TIME,
				'create_ip' => get_client_ip(true),
				'invite_id' => $invite_id,
                'invites' => $invites,
				'alipay' => '',
				'realname' => '',
				'status' => 0,
			));
			if ($_result) {
               M("user")->where('id in('.$invites.')')->setInc('tdzrs', 1);
                if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Registration was successful,please download APP', 'url'=>'http://www.07rjm.cn/index/appdown/id/'.$post['phone']));
      }
				$this->ajaxReturn(array('status'=>1, 'msg'=>'注册成功，请下载APP', 'url'=>'http://www.07rjm.cn/index/appdown/id/'.$post['phone']));
			} else {
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Registration was fail'));
      }
				$this->ajaxReturn(array('status'=>0, 'msg'=>'注册失败'));
			}
		} else {
			$type = M('country')->where('status=1')->order('id ASC')->select();
		    $this->assign('type', $type);
          $ua = $_SERVER['HTTP_USER_AGENT'];

	if ($this->conf['jiben']['reg_status'] != 1) {
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->error('New user registration closed');
      }
	$this->error('新用户注册已关闭');
	}
		
			if (C('WECHAT_AUTH') && is_wechat() && !$auth_info) $this->redirect('/wechat/auth?lasturi='.urlencode(I('server.REQUEST_URI')));
			$this->assign('from', $_from);
			if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
				$appdizhi=$this->conf['jiben']['iosappdizhi'];
   $this->assign('appdizhi', $this->conf['jiben']['iosappdizhi']);
}else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
		$appdizhi=$this->conf['jiben']['appdizhi'];
    $this->assign('appdizhi', $this->conf['jiben']['appdizhi']);
}else{
		$appdizhi=$this->conf['jiben']['iosappdizhi'];
 $this->assign('appdizhi', $this->conf['jiben']['iosappdizhi']);
}

         if (strpos($ua, 'MicroMessenger') == false && strpos($ua, 'Windows Phone') == false) {

$this->assign('isweixin', 0);
} else {
$this->assign('isweixin', 0);
}
$this->assign('isweixin', 0);
          if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
	$this->display('User_regen');
}else{
	$this->display();
}
		
		}
	}
	
	
    //APP忘记密码
  public function forget(){
  
 if (empty($_REQUEST['msgCode'])){
 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Verification code cannot be empty'));
      }
 $this->ajaxReturn(array('status'=>0, 'msg'=>'验证码不能为空'));
 }

     if (empty($_REQUEST['loginName'])) {
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number cannot be empty'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
     }
			if (empty($_REQUEST['loginPass'])){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Password cannot be empty'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'密码不能为空'));
			} 

    
    $smscode = M('smscode');
		$map['phone'] = $_REQUEST['loginName'];
           $map['code'] = $_REQUEST['msgCode'];
			$codeinfo = $smscode->where($map)->find();
    if($codeinfo){
    if($codeinfo['add_time']<time()-1800){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone validation code has expired'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码已过期'));
    }
    }else{
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone verification code is incorrect'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码不正确'));
    }
			$User = M('user');
			$map = array('phone'=>$_REQUEST['loginName']);
			$_user = $User->where($map)->find();
			if (empty($_user)){
			
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has no registered account'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机号没有注册账号'));
			} 

  $_result = $User->save(array(
                    'id'=>$_user['id'],
					'password' => get_sha($_REQUEST['loginPass'])
				));
   
    if($_result){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
      }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'修改成功'));
    }else{
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'修改失败'));
    }
  }
     //APP解绑设备
  public function jiebang(){
   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Please consult customer service for unbinding equipment'));
      }
   $this->ajaxReturn(array('status'=>0, 'msg'=>'解绑设备请咨询客服'));
 if (empty($_REQUEST['msgCode'])){
 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Verification code cannot be empty'));
      }
 $this->ajaxReturn(array('status'=>0, 'msg'=>'验证码不能为空'));
 }

     if (empty($_REQUEST['loginName'])) {
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number cannot be empty'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
     }
			if (empty($_REQUEST['loginPass'])){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Password cannot be empty'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'密码不能为空'));
			}
    
    $smscode = M('smscode');
		$map['phone'] = $_REQUEST['loginName'];
           $map['code'] = $_REQUEST['msgCode'];
			$codeinfo = $smscode->where($map)->find();
   if($codeinfo){
    if($codeinfo['add_time']<time()-1800){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone validation code has expired'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码已过期'));
    }
    }else{
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone verification code is incorrect'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'手机验证码不正确'));
    }
			$User = M('user');
			$map = array('phone'=>$_REQUEST['loginName']);
			$_user = $User->where($map)->find();
			if (empty($_user)){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has no registered account'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机号没有注册账号'));
			} 

  $_result = $User->save(array(
                    'id'=>$_user['id'],
					'deviceid' => '',
					'lastrztime' => 0
				));
   
    if($_result){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
      }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'解绑成功'));
    }else{
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'解绑失败'));
    }
  }
    //APP修改密码
  public function editloginpass(){
   

     if (empty($_REQUEST['loginName'])) {
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number cannot be empty'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
     }
			if (empty($_REQUEST['loginPass'])){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Password cannot be empty'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'密码不能为空'));
			}

			$User = M('user');
			$map = array('phone'=>$_REQUEST['loginName']);
			$_user = $User->where($map)->find();
			if (empty($_user)){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has no registered account'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机号没有注册账号'));
			} 
  $_result = $User->save(array(
                    'id'=>$_user['id'],
					'password' => get_sha($_REQUEST['loginPass'])
				));
   
    if($_result){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
      }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'修改成功'));
    }else{
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'修改失败'));
    }
  }
  //APP修改交换密码
  public function editchangepass(){

     if (empty($_REQUEST['loginName'])) {
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number cannot be empty'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
     }
			if (empty($_REQUEST['changePass'])){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Change password cannot be empty'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'交换密码不能为空'));
			}
 
			$User = M('user');
			$map = array('phone'=>$_REQUEST['loginName']);
			$_user = $User->where($map)->find();
			if (empty($_user)){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has no registered account'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机号没有注册账号'));
			}
  $_result = $User->save(array(
                    'id'=>$_user['id'],
					'changepass' => get_sha($_REQUEST['changePass'])
				));
   
    if($_result){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
      }
    $this->ajaxReturn(array('status'=>1, 'msg'=>'修改成功'));
    }else{
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'修改失败'));
    }
  }

   //验证登录密码
  public function checkChange(){
  if (IS_POST) {
			
			$User = M('user');
			$map = array('token'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
			if(empty($_user['changepass'])){
			 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Please set the exchange password first'));
      }
			 $this->ajaxReturn(array('status'=>0, 'msg'=>'请先设置交换密码'));
			}
			if ($_user['changepass'] == get_sha($_REQUEST['exPass'])) {
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
      }
               $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
            }else{
            
            if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Incorrect password'));
      }
             $this->ajaxReturn(array('status'=>0, 'msg'=>'密码输入错误'));
            }
    
		}
  }
	// 会员登录
	public function login() {
      
		$auth_info = session('auth_info');
		if (IS_POST) {
         
			//$post = I('post.');

			if (empty($_REQUEST['loginName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
			if (empty($_REQUEST['loginPass'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'密码不能为空'));
			$User = M('user');
			$map = array('phone'=>$_REQUEST['loginName']);
			$_user = $User->where($map)->find();
			if (empty($_user)){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number has not been registered yet'));
      }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号尚未注册'));
			} 
          if($_user['status']==3){
          	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Your account is frozen'));
      }
          $this->ajaxReturn(array('status'=>0, 'msg'=>'您的账户被冻结'));
          }
          if(strpos($_user['deviceid'],'-') !== false){ 

          }else{
          	/*
          if($_user['deviceid']!=$_REQUEST['deviceId'] && $_user['deviceid']!=''){
             	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
          $this->ajaxReturn(array('status'=>0, 'msg'=>'You have already bound other devices to login. Please unbind them first'));
          }
          $this->ajaxReturn(array('status'=>0, 'msg'=>'您已经绑定其他设备登录，请先解绑'));
          }
          $map1 = array('deviceid'=>$_REQUEST['deviceId']);
			$userinfo = $User->where($map1)->find();
          if($userinfo['phone']!=$_REQUEST['loginName'] && $userinfo){
           	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'There are other accounts bound to this device. Please unbind it first'));
      }
          $this->ajaxReturn(array('status'=>0, 'msg'=>'已经有其他账号绑定此设备，请先解绑'));
          }
          */
}
         
			if ($_user['password'] == get_sha($_REQUEST['loginPass'])) {
				 $rzcode=time().getrandomstring(64);
				$_result = $User->save(array(
					'id' => $_user['id'],
					'last_login_time' => NOW_TIME,
					'lastrztime' => 0,
                    'deviceid' => $_REQUEST['deviceId'],
					'last_login_ip' => get_client_ip(true),
					'rzcode' => $rzcode,
				));
				if ($_result) {
					if($_user['token']==''){
                      $token=get_sha($_REQUEST['loginName'].$_REQUEST['loginPass']);
                      //这里配置随机数
                    $User->save(array(
                      'id' => $_user['id'],
					'token' => $token,
				));
                    }else{
                    $token=$_user['token'];
                    }
					$data['id']=$_user['id'];
                  $data['token']=$token;
                  $data['rzcode']=$rzcode;
                     	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'msg'=>'Login Success', 'data'=>$data));
      }
					$this->ajaxReturn(array('status'=>1, 'msg'=>'登录成功', 'data'=>$data));
				} else {
				            	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'The system is busy. Please try again'));
      }
					$this->ajaxReturn(array('status'=>0, 'msg'=>'系统繁忙，请重试'));
				}
			} else {
				if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'Incorrect password'));
      }
				$this->ajaxReturn(array('status'=>0, 'msg'=>'密码输入有误'));
			}
		} else {
			exit;
		}
	}
   
  // 注销登录
	public function logout() {
		session('user_id', null);
		cookie('user_session', null);
		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       	$this->ajaxReturn(array('status'=>1, 'msg'=>'Success', 'url'=>'/'));
      }
		$this->ajaxReturn(array('status'=>1, 'msg'=>'注销成功', 'url'=>'/'));
	}
	

  
	// 会员中心
	public function index() {
		// 账户
      exit;
		$map = array('user_id'=>array('eq', $this->user['id']));
		$_account = M('account')->where($map)->find();
		$this->assign('account', $_account);
		// 收益累计
		$map = array(
			'user_id' => array('eq', $this->user['id']),
			'type' => array('gt', 11),
		);
		$_income = M('account_log')->where($map)->sum('`change`');
		$this->assign('income', number_format($_income, 2));
		// 待分润
		$map = array(
			'user_id' => array('eq', $this->user['id']),
			'status' => array('eq', 0),
		);
		$_profit = M('profit')->where($map)->sum('money');
		$this->assign('profit', number_format($_profit, 2));
		// 邀请人
		if ($this->user['invite_id'])
		$_invite = M('user')->find($this->user['invite_id']);
		$this->assign('invite', $_invite);
		$this->display();
	}

	// 修改密码
	public function password() {
		if (IS_POST) {
			$post = I('post.');
			$data = array('id'=>$this->user['id']);
			if ($this->user['password'] != get_sha($post['oldpass'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'原密码输入有误'));
			($post['password'] == $post['repass'] && strlen($post['password']) >= 6) ? $data['password'] = get_sha($post['password']) : $this->ajaxReturn(array('status'=>0, 'msg'=>'两次密码不一致或长度小于6'));
			$_result = M('user')->save($data);
			if ($_result) {
				$this->ajaxReturn(array('status'=>1, 'msg'=>'修改成功', 'url'=>'/user'));
			} else {
				$this->ajaxReturn(array('status'=>0, 'msg'=>'修改失败'));
			}
		} else {
			$this->display();
		}
	}
  // 获取服务器时间
	public function getDate() {
		$beginToday = mktime(0,0,0,date('m'),date('d'),date('Y')); 
		$this->ajaxReturn(array('status'=>1, 'data'=>$beginToday));
	}
	 // 获取APP版本号
	public function getbanbenhao() {
		$banbenhao = $this->conf['jiben'][$_REQUEST['type']];
		$id=intval($_REQUEST['id']);
		
		//$this->ajaxReturn(array('status'=>0, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		if($banbenhao>$_REQUEST['banben']){
			if($_REQUEST['type']=='iosbbh'){
					if($id>=0 && $id<865929){
			            $this->ajaxReturn(array('status'=>1, 'data'=>'https://ios.llc/Y6ELX'));
		              }
			}
		
			$this->ajaxReturn(array('status'=>1, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		}else{
			$this->ajaxReturn(array('status'=>0, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		}
	
	}
	 
  // 获取轮播图
	public function getScrollByType() {
			$slide = M('slide');
			$map = array('status'=>1);
			$data = $slide->where($map)->select();
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
  //获取我的推荐人
  public function myInvitor(){
     if($_REQUEST['randomId']>0){
     $user = M('user');
			$map = array('id'=>$_REQUEST['randomId']);
   
			$data = $user->where($map)->find();
     }else{
       $data=array();
     $data['avatar']='';
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $data['phone']='platform';
      }else{
      $data['phone']='平台';
      }
       
     }
  
    
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
  }
    //获取我的团队
  public function myUsers(){
  
  $user = M('user');
    $id=$_REQUEST['id'];
   
    $data = $user->where("invites like '%,$id,%' or invites like '$id,%' or invites like '%,$id'")->select();
    foreach($data as $k => $v){
    $data[$k]['create_time']=date('Y-m-d H:i:s',$v['create_time']);
    if($v['status']==1){
    	$data[$k]['realname']=substr_replace($v['phone'],'****',3,4);
    }else{
    	$data[$k]['realname']='未实名用户'.$v['phone'];
    }
    }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
  }
 
// 保存跑步记录
	public function addStepRecord() {
		
		$this->ajaxReturn(array('status'=>1, 'data'=>time()));
	}

  
 
    //保存当前经纬度
  public function updateJwd(){
  if (IS_POST) {
			
				$User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();

     $_REQUEST['jingdu'] = str_replace(" ", "", $_REQUEST['jingdu']);
      $_REQUEST['weidu'] = str_replace(" ", "", $_REQUEST['weidu']);
    $url='https://apis.map.qq.com/ws/geocoder/v1/?location='.$_REQUEST['weidu'].','.$_REQUEST['jingdu'].'&key=ZAIBZ-2T2C4-RKTUX-DZ5QC-XDIXH-DXFAF';
    $content = file_get_contents($url);
    $palce=json_decode($content,true);

			 $User->save(array(
                      'id' => $_user['id'],
					'jingdu' => $_REQUEST['jingdu'],
               'weidu' => $_REQUEST['weidu'],
               'haiba' => $_REQUEST['haiba'],
               'area' => $_REQUEST['area'],
               'citycode'=>$palce['result']['ad_info']['city_code']
				));

     $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
		}
  }
  //身份核验
  public function heyansf(){
  if (IS_POST) {
     $User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
    $_user = $User->where($map)->find();
      $img1=explode('/',$_REQUEST['shenfenzheng']);
    $shenfenzheng='/upload/image/'.$img1[1];
    $url = 'https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=DiFFB992bMB7KKc7g2LpsdZT&client_secret=HbHms5cskiYbp8FQPplZKkApmsw0GKWB';
    $res = file_get_contents($url);
  $data=json_decode($res,true);

$url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard?access_token=' . $data['access_token'];

$img = file_get_contents("http://www.07rjm.cn".$shenfenzheng);
$img = base64_encode($img);
$bodys = array(
    "id_card_side"=>'front',
    "image" => $img
);
$res = $this->request_post($url, $bodys);
  $data=json_decode($res,true);
if($data['image_status']=='normal'){
$idCard=$data['words_result']["公民身份号码"]["words"];
$realname=$data['words_result']["姓名"]["words"];
$info['realname']=$realname;
$info['idcard']=$idCard;
$User->save(array(
 'id' => $_user['id'],
 'realname' => $realname,
 'idcard' => $idCard,
));
   $this->ajaxReturn(array('status'=>1, 'data'=>$info, 'msg'=>"身份证识别成功"));
}else{
 $this->ajaxReturn(array('status'=>0, 'msg'=>"身份证识别失败"));
}

  }
  }
     //提交认证
  public function identify(){
  if (IS_POST) {
  	 $this->ajaxReturn(array('status'=>0, 'msg'=>'请更新至最新版本进行实名认证'));
    $User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
if($_REQUEST['type']!='zhifu'){
 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      	if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Non-existent users'));
           if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Real name cannot be empty'));

   // if (empty($_REQUEST['bankName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Banks cannot be empty'));
    //if (empty($_REQUEST['bankNo'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Bank Card Number cannot Be Empty'));

     if (empty($_REQUEST['shenghuozhao'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Upper body photos should not be empty'));
      }else{
      	if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
           if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'真实姓名不能为空'));
   // if (empty($_REQUEST['idCard'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'身份证不能为空'));
    //if (empty($_REQUEST['bankName'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'银行不能为空'));
    //if (empty($_REQUEST['bankNo'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'银行卡号不能为空'));
    //if (empty($_REQUEST['alipay'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'支付宝账号不能为空'));
     //if (empty($_REQUEST['shenfenzheng'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'身份证照片不能为空'));
     if (empty($_REQUEST['shenghuozhao'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'上半身照片不能为空'));
      }
		
 
    // $img1=explode('/',$_REQUEST['shenfenzheng']);
   // $shenfenzheng='/upload/image/'.$img1[1];
    $img2=explode('/',$_REQUEST['shenghuozhao']);
      $map0 = array('name'=>$img2[1]);
			$tupian = M('tupian')->where($map0)->find();
    $shenghuozhao=$tupian['url'];
			
    
    $url = 'https://aip.baidubce.com/oauth/2.0/token';
    $post_data['grant_type']       = 'client_credentials';
    $post_data['client_id']      = 'UPigb0sfCiYnYAOLHRoZgzCp';
    $post_data['client_secret'] = 'L8IhM15bZkRrchBQkMKlS5xjEWfsdo1K';
    $o = "";
    foreach ( $post_data as $k => $v ) 
    {
    	$o.= "$k=" . urlencode( $v ). "&" ;
    }
    $post_data = substr($o,0,-1);
    
    $res = $this->request_post($url, $post_data);
    $data=json_decode($res,true);
 
            $url = 'https://aip.baidubce.com/rest/2.0/face/v3/search?access_token=' . $data['access_token'];
$bodys = "{\"image\":\"".$shenghuozhao."\",\"image_type\":\"URL\",\"group_id_list\":\"shiming\",\"quality_control\":\"LOW\",\"liveness_control\":\"NORMAL\"}";
$res = $this->request_post($url, $bodys);
// $this->ajaxReturn(array('status'=>0, 'msg'=>$res));
$data1=json_decode($res,true);
   if($data1['error_code']=='0'|| $data1['error_code']=='222207'){
    if($data1['result']['user_list'][0]['score']>85){
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The face already exists'));
      }
     $this->ajaxReturn(array('status'=>0, 'msg'=>"该人脸已经存在"));
    }else{
      //$this->ajaxReturn(array('status'=>0, 'msg'=>$res));
    
        $url = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/add?access_token=' . $data['access_token'];
$bodys = "{\"image\":\"".$shenghuozhao."\",\"image_type\":\"URL\",\"group_id\":\"shiming\",\"user_id\":\"user".$_user['id']."\",\"user_info\":\"abc\",\"quality_control\":\"LOW\",\"liveness_control\":\"NORMAL\"}";
$res = $this->request_post($url, $bodys);

      			 $User->save(array(
                    'id' => $_user['id'],
                    'realname' => $_REQUEST['name'],
                'status' => 2,
               //'shenfenzheng' => $shenfenzheng,
                'shenghuozhao' => $shenghuozhao,
                //'idcard' => $_REQUEST['idCard'],
                'bankname' => $_REQUEST['bankName'],
                'bankno' => $_REQUEST['bankNo'],
                //'alipay' => $_REQUEST['alipay'],
				));
        $order = M('order');
            $trade_no=time().rand(1111,9999);
			$_result = $order->add(array(
				'user_id' => $_user['id'],
              'name' => '',
              'area' => '',
              'address' => '',
              'phone' => '',
              'product_id' => 0,
              'money' => 1,
              'create_time' => time(),
               'trade_no' => $trade_no,
			));
     
     }
}else{
if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $msg=baiduapierr($data1['error_code']);
      }else{
      $msg=baiduapierr($data1['error_code']);
      }
     
     $this->ajaxReturn(array('status'=>0, 'msg'=>$msg));
    }
   }
   $map3 = array('product_id'=>0,'user_id'=>$_user['id']);
			$_order = M('order')->where($map3)->find();

      $Alipay = new \Common\Util\Apppay();
			$_result = $Alipay->pay($_order);
     $this->ajaxReturn(array('status'=>1, 'data'=>$_order,'resultStr'=>$_result));

		}
  }
  function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        
        $postUrl = $url;
        $curlPost = $param;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($curl);//运行curl
        curl_close($curl);
        
        return $data;
    }
     //修改基本信息
  public function saveUserInfo(){
  if (IS_POST) {
			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
         $img=explode('/',$_REQUEST['headImg']);
         
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
			
            if(empty($img[1])){
             $image=$_user['avatar'];
         }else{
             $image='/upload/image/'.$img[1];
         }
			 $User->save(array(
                    'id' => $_user['id'],
                    'avatar' => $image,
                'nickname' => $_REQUEST['nickName'],
                'realname' => $_REQUEST['realname'],
                'sex' => $_REQUEST['sex'],
                'wechat' => $_REQUEST['wechat'],
                'bankname' => $_REQUEST['bankName'],
                'bankno' => $_REQUEST['bankNo'],
				));

     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Success'));
      }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'修改成功'));
		}
  }
  //获取当天步数
  public function jinriValue(){
  if (IS_POST) {
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));

			$User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
           
    //获取当天时间
    $today=date('Y-m-d',time());
    $Steplog = M('step_log');
			$map = array('add_time'=>$today,'userid'=>$_user['id']);
			$steploginfo = $Steplog->where($map)->find();
    if($steploginfo['id']>0){

    $laststep=$steploginfo['step_count'];
    }else{

      $laststep=0;
    }
    
        $data['step']=$laststep;   
    $data['jichubushu']=$this->conf['jiben']['jichutemp'];

     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
   //保存当前步数
  public function calculateValue(){
  if (IS_POST) {
  	$post = I('get.');
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			if (empty($_REQUEST['step'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
        
    //获取当天时间
    $today=date('Y-m-d',time());
    $Steplog = M('step_log');
			$map = array('add_time'=>$today,'userid'=>$_user['id']);
			$steploginfo = $Steplog->where($map)->find();
    if($steploginfo['id']>0){

    $steploginfo['step_count']=$_REQUEST['step'];
    $laststep=$steploginfo['laststep'];
    }else{
      if($_REQUEST['step']>50){
      	 $_REQUEST['step']=1;
      }else{
      	 $_REQUEST['step']=$_REQUEST['step'];
      }
     
      
      $steploginfo['step_count']=$_REQUEST['step'];
      $laststep=0;
    }
    if($_REQUEST['step']>$this->conf['jiben']['jichutemp']){
     $step_count=$this->conf['jiben']['jichutemp'];
    }else{
     $step_count=$_REQUEST['step'];
    }
   
     $value=($step_count-$laststep)*$this->conf['jiben']['bianliang']*$_user['huoyuedu'];
    if($value<0){
    $value=0;
    }

    $usermission = M('user_mission')->where("app_user_id='".$_user['id']."' and end_date>'".time()."'")->select();
    foreach($usermission as $k=>$v){
    if($_REQUEST['step']>$v['step']){
    $step_count=$v['step'];
    }else{
     $step_count=$_REQUEST['step'];
    }
    if($v['id']<201720){
    	$value1=($step_count-$laststep)*$v['huoyue']*0.00008;
    }else{
    	$value1=($step_count-$laststep)*$v['huoyue']*$this->conf['jiben']['bianliang'];
    }
      
      if($value1<0){
    $value1=0;
    }
      $value=$value+$value1;
    }
     
     if($steploginfo['id']>0){
     
        $Steplog->save(array(
                      'id' => $steploginfo['id'],
					'step_count' => $_REQUEST['step'],
                    'zidongtg'=>$value,
				));
    
    }else{
      $_result = $Steplog->add(array(
				'userid' => $_user['id'],
              'step_count' => $_REQUEST['step'],
              'add_time' => $today,
              'zidongtg'=>$value,
			));
     }
        $data['step']=$_REQUEST['step'];   
    $data['jichubushu']=$this->conf['jiben']['jichutemp'];
    $data['value']=$value;
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
   //保存当前糖果
  public function sycValue(){
  if (IS_POST) {
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			if (empty($_REQUEST['step'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
		
    $zhuangtai=0;
    //获取当天时间
    $today=date('Y-m-d',time());
    $Steplog = M('step_log');
			$map = array('add_time'=>$today,'userid'=>$_user['id']);
			$steploginfo = $Steplog->where($map)->find();
			if(empty($steploginfo)){
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Please do not repeat the operation.'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'请不要重复操作'));
			}
    if($_REQUEST['step']-$steploginfo['laststep']<30){
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Please do not repeat the operation.'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'请不要重复操作'));
    }
    if($_REQUEST['step']>$this->conf['jiben']['jichutemp']){
    $shandian=$this->conf['jiben']['jichutemp']-$steploginfo['laststep'];
    }else{
    $shandian=$_REQUEST['step']-$steploginfo['laststep'];
    }
            

    $jiangli=$shandian*$this->conf['jiben']['bianliang']*$_user['huoyuedu'];
    if($jiangli<0){
    $jiangli=0;
    }
			 $Steplog->save(array(
                    'id' => $steploginfo['id'],
                    'laststep' => $_REQUEST['step'],
                    'zidongtg'=>0,
				));

    $usermission = M('user_mission')->where("app_user_id='".$_user['id']."' and end_date>'".time()."'")->select();
    foreach($usermission as $k=>$v){
    if($_REQUEST['step']>$v['step']){
    $stepcount=$v['step'];
    }else{
     $stepcount=$_REQUEST['step'];
    }
      if($v['id']<201720){
      	$jiangli1 =($stepcount-$steploginfo['laststep'])*0.00008*$v['huoyue'];
      }else{
      	$jiangli1 =($stepcount-$steploginfo['laststep'])*$this->conf['jiben']['bianliang']*$v['huoyue'];
      }
       
      if($jiangli1<0){
    $jiangli1=0;
    }
      $jiangli +=$jiangli1;
    }
  
      if($jiangli>0){
         $zhuangtai=1;
          if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $_result1 = addtangguo($_user['id'], 2, $jiangli, 'User Task Step Award');
      }else{
      $_result1 = addtangguo($_user['id'], 2, $jiangli, '用户任务步数奖励');
      }
     
     }
    if($zhuangtai==0){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Please do not repeat the operation.'));
      }
    $this->ajaxReturn(array('status'=>0, 'msg'=>'请不要重复操作'));
    }
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Save Success'));
      }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'保存成功'));
		}
  }
     //获取用户数据
  public function getUser(){
  if (IS_POST) {
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
			if(!$_user){
				$this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			}
          $data['value']=round($_user['money'],7);
     $data['gongxian']=$_user['gongxian'];
    $data['level']=$_user['level'];
    $data['loginName']=$_user['phone'];
    $data['status']=$_user['status'];
     $data['randomId']=$_user['id'];
      $data['id']=$_user['token'];
    $data['value']=round($_user['money'],7);
     $data['money']=$_user['wallet'];
        $data['jingdu']=$_user['jingdu'];
     $data['weidu']=$_user['weidu'];
            $data['haiba']=$_user['haiba'];
     $data['area']=$_user['area'];
     $data['star']=$_user['star'];
     $data['huoyuedu']=$_user['huoyuedu'];
     $data['tdhyd']=$_user['tdhyd'];
    $data['tdzrs']=$_user['tdzrs'];
    $data['countryid']=$_user['countryid'];
$today = strtotime(date('Y-m-d',time()));
if($_user['mian']==0){
		if($_user['lastrztime']<$today){
	     $_user['lastrztime']=0;
		//$_user['lastrztime']=1;
}

}else{
	$_user['lastrztime']=1;
}
//$_user['lastrztime']=1;//关闭每天扫脸登陆
$data['lastrztime']=$_user['lastrztime'];
     $data['fenhongbl']=$_user['fenhongbl'];
    $data['invitedId']=$_user['invite_id'];
     $data['avatar']=$_user['avatar'];
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  
       //获取团队
  public function gettduser(){
  if (IS_POST) {
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
          
     $data['randomId']=$_user['id'];
      $data['id']=$_user['token'];
   
        $data['jingdu']=$_user['jingdu'];
     $data['weidu']=$_user['weidu'];
            $data['haiba']=$_user['haiba'];
    
     $data['huoyuedu']=$_user['huoyuedu'];
     $data['tdhyd']=$_user['tdhyd'];
    $map1 = array('invite_id'=>$_user['id']);
    $yingxiong = $User->where($map1)->order('tdhyd DESC')->limit('2')->select();
   $yxhyd=0;
    foreach($yingxiong as $k=>$v){
    $yxhyd +=$v['tdhyd'];	
    }
    $data['tdzrs']=$_user['tdzrs'];
    $data['yxhyd']=$yxhyd;
     $data['fenhongbl']=$_user['fenhongbl'];
    $data['invitedId']=$_user['invite_id'];
     $data['avatar']=$_user['avatar'];
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  //达人规则
  public function getStarList(){
            $star = M('star');
			$_result = $star->order('id ASC')->select();
    foreach($_result as $k => $v){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      if($v['shenfen']==0){
      $_result[$k]['shenfen']='Real-name Certified Members';
      }elseif($v['shenfen']==1){
      $_result[$k]['shenfen']='One Star';
      }elseif($v['shenfen']==2){
      $_result[$k]['shenfen']='Two Star';
      }elseif($v['shenfen']==3){
      $_result[$k]['shenfen']='Three Star';
      }elseif($v['shenfen']==4){
      $_result[$k]['shenfen']='Four Star';
      }elseif($v['shenfen']==5){
      $_result[$k]['shenfen']='Five Star';
      }
      }else{
      if($v['shenfen']==0){
      $_result[$k]['shenfen']='实名认证会员';
      }elseif($v['shenfen']==1){
      $_result[$k]['shenfen']='一星达人';
      }elseif($v['shenfen']==2){
      $_result[$k]['shenfen']='二星达人';
      }elseif($v['shenfen']==3){
      $_result[$k]['shenfen']='三星达人';
      }elseif($v['shenfen']==4){
      $_result[$k]['shenfen']='四星达人';
      }elseif($v['shenfen']==5){
      $_result[$k]['shenfen']='五星达人';
      }
      }
      
      }
    $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
  }
    public function levelList(){
            $star = M('bonus_level');
			$_result = $star->order('id ASC')->select();

    $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
  }
          //糖果明细
  public function getDetail(){
  if (IS_POST) {
			$userid=$_REQUEST['appUserId'];
    $type=$_REQUEST['type'];
    if($type==0){
    $tangguolog = M('tangguo_log');
			$map = array('user_id'=>$userid);
			$data = $tangguolog->where($map)->order('id DESC')->select();
      foreach($data as $k=>$v){
      $data[$k]['addtime']=date('Y-m-d H:i',$v['create_time']);

      }
    }
	if($type==1){
    $huoyuedulog = M('huoyuedu_log');
			$map = array('user_id'=>$userid);
			$data = $huoyuedulog->where($map)->order('id DESC')->select();
      foreach($data as $k=>$v){
      $data[$k]['addtime']=date('Y-m-d H:i',$v['create_time']);
       
      }
    }		
	if($type==2){
    $gongxianlog = M('gongxian_log');
			$map = array('user_id'=>$userid);
			$data = $gongxianlog->where($map)->order('id DESC')->select();
      foreach($data as $k=>$v){
      $data[$k]['addtime']=date('Y-m-d H:i',$v['create_time']);
       
      }
    }	
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  //步数统计
    public function getStepCount(){
  if (IS_POST) {
			$userid=$_REQUEST['appUserId'];

    $steplog = M('step_log');
			$map = array('user_id'=>$userid);
			$data = $steplog->where($map)->order('id DESC')->limit(30)->select();
		
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
    //获取用户数据
  public function getUserInfo(){
  if (IS_POST) {

			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
          $data['realname']=$_user['realname'];
     $data['idcard']=$_user['idcard'];
    $data['bankname']=$_user['bankname'];
     $data['avatar']=$_user['avatar'];
    $data['bankno']=$_user['bankno'];
    $data['sex']=$_user['sex'];
    $data['status']=$_user['status'];
     $data['shenfenzheng']=$_user['shenfenzheng'];
     $data['nickname']=$_user['nickname'];
     $data['wechat']=$_user['wechat'];
     $data['shenghuozhao']=$_user['shenghuozhao'];
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
      //获取用户活跃度
  public function getAct(){
   
  if (IS_POST) {
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
			$User = M('user_mission');
			$data = $User->where('app_user_id='.$_REQUEST['id'].' and end_date>'.time())->sum('huoyue');
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  
        //获取商品分类
  public function shoptype(){
  if (IS_POST) {
			
			$type = M('type');
			
			$data = $type->select();

    
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  
          //获取商品分类列表
  public function goodList(){
  if (IS_POST) {
			
			$product = M('product');
			if($_REQUEST['type']==0){
            $data = $product->order($_REQUEST['ob']." ".$_REQUEST['ad'])->select();
            }else{
            $data = $product->where("type=".$_REQUEST['type'])->order($_REQUEST['ob']." ".$_REQUEST['ad'])->select();
            }
			
        foreach($data as $k => $v){
        $data[$k]['content']=htmlspecialchars_decode($v['content']);
        $data[$k]['encontent']=htmlspecialchars_decode($v['encontent']);
        }
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
    public function savePic(){
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$ret=array('strings'=>$_POST,'error'=>'0');
	$fs=array();
	$Qiniu = new \Common\Util\Qiniu();
		$_result = $Qiniu->appupload();
		
	// 枚举所有提交的文件
	foreach ( $_FILES as $name=>$file ) {
		$fn=$file['name'];
		
		$ft=strrpos($fn,'.',0);
		$fm=substr($fn,0,$ft);
		$fe=substr($fn,$ft);
		$fp='/www/wwwroot/www.07rjm.cn/public/upload/image/'.$fn;
		$fi=1;
		while( file_exists($fp) ) {	// 当提交的文件已经存在时则重命名
			$fn=$fm.'['.$fi.']'.$fe;
			$fp='/www/wwwroot/www.07rjm.cn/public/upload/image/'.$fn;
			$fi++;
		}
		// 将临时文件保存到files目录
		move_uploaded_file($file['tmp_name'],$fp);
		
	 M('tupian')->add(array(
				'name' => $fn,
				'url' => $_result,
				'updated_at' => NOW_TIME,
			));
		
		$fs[$name]=array('name'=>$fn,'url'=>$fp,'type'=>$file['type'],'size'=>$file['size'],);
	}
	$ret['files']=$fs;
	// 输出返回数据格式
	echo json_encode($ret);
}else{
	echo "{'error':'Unsupport GET request!'}";
}
  }
  
      //添加充值记录
  public function cz(){
  if (IS_POST) {
			if (empty($_REQUEST['id'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    if (empty($_REQUEST['amount'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'充值金额不能为空'));
			$User = M('user');
			$map = array('token'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
    
    exit;
         if($_user['money']<$_REQUEST['amount']){
          $this->ajaxReturn(array('status'=>0, 'msg'=>'糖果不足'));
         }else{
          $User->save(array(
                    'id' => $_user['id'],
					'money' => $_user['money']-$_REQUEST['amount'],
                    'wallet' => $_user['wallet']+$_REQUEST['amount'],
				));
         }
    
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  
  // 文章列表
	public function infos() {
		$map = array('status'=>array('eq', 1));
		$_result = M('help')->where($map)->order('sort DESC,id DESC')->select();
      foreach($_result as $k => $v){
      $_result[$k]['content']=htmlspecialchars_decode($v['content']);
      $_result[$k]['encontent']=htmlspecialchars_decode($v['encontent']);
      }
 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
	// 提现记录
	public function cash_ajaxlist() {
		if (IS_POST) {
			$map = array('user_id'=>array('eq', $this->user['id']));
			$_result = M('cash')->where($map)->order('id DESC')->page(I('post.page', 0, 'intval'), 10)->select();
			$this->assign('list', $_result);
			$this->ajaxReturn(array(
				'status' => count($_result) < 10 ? 1 : 0,
				'html' => $this->fetch(),
			));
		}
	}

	// 余额提现
	public function cash() {
		if (IS_POST) {
			$change = I('post.money');
			if (!is_numeric($change)) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现金额输入错误'));
			if ($change < 0.01) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现金额不能小于0.01'));
			if ($change < $this->conf['cash']['cash_min']) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现金额不能小于'.$this->conf['cash']['cash_min']));
			if ($this->conf['cash']['cash_max'] != 0 && $change > $this->conf['cash']['cash_max']) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现金额不能大于'.$this->conf['cash']['cash_max']));
			$Cash = M('cash');
			if ($this->conf['cash']['cash_num']) {
				$map = array(
					'user_id' => array('eq', $this->user['id']),
					'create_time' => array('egt', strtotime(date('Y-m-d'))),
					'status' => array('eq', 1),
				);
				$_count = $Cash->where($map)->count();
				if ($_count >= $this->conf['cash']['cash_num']) $this->ajaxReturn(array('status'=>0, 'msg'=>'每日最大提现笔数'.$this->conf['cash']['cash_num']));
			}
			if ($this->conf['cash']['cash_limit'] > 0) {
				$map = array(
					'user_id' => array('eq', $this->user['id']),
					'status' => array('eq', 1),
				);
				$_total = M('order')->where($map)->sum('money');
				if ($_total < $this->conf['cash']['cash_limit']) $this->ajaxReturn(array('status'=>0, 'msg'=>'消费未满'.$this->conf['cash']['cash_limit']));
			}

			M()->startTrans();
			$Account = M('account');
			$map = array('user_id'=>array('eq', $this->user['id']));
			$_account = $Account->lock(true)->where($map)->find();

			$data = change_account($_account, $change, 1);
			if (is_string($data)) $this->ajaxReturn(array('status'=>0, 'msg'=>$data));

			$res1 = $Account->save(array(
				'id' => $data['id'],
				'total' => $data['total'],
				'freeze' => $data['freeze'],
				'used' => $data['used'],
			));
			$res2 = M('account_log')->add(array(
				'user_id' => $data['user_id'],
				'change' => $change,
				'total' => $data['total'],
				'type' => $data['type'],
				'create_time' => NOW_TIME,
			));
			$cash_fee = $change * $this->conf['cash']['cash_fee'] / 100;
			$res3 = $Cash->add(array(
				'user_id' => $data['user_id'],
				'trade_no' => trade_no(),
				'money' => $change,
				'money_real' => $change - $cash_fee,
				'cash_fee' => $cash_fee,
				'create_time' => NOW_TIME,
			));
			if ($res1 && $res2 && $res3) {
				M()->commit();
				// 实时划账
				$this->cash_auto($res3);
				$this->ajaxReturn(array('status'=>1, 'msg'=>'提现申请已提交', 'url'=>'/user/cash'));
			} else {
				M()->rollback();
				$this->ajaxReturn(array('status'=>0, 'msg'=>'系统繁忙，请稍后再试~'));
			}
		} else {
			$Account = M('account');
			$map = array('user_id'=>array('eq', $this->user['id']));
			$_account = $Account->where($map)->find();
			$this->assign('data', $_account);
			$this->display();
		}
	}
//添加地址
  public function addAddress(){
  if (IS_POST) {
  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Nonexistent users'));
    if (empty($_REQUEST['phone'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Contact calls cannot be empty'));
      if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'The consignee cannot be empty'));
    			if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Areas cannot be empty'));
    if (empty($_REQUEST['address'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Street address cannot be empty'));
      }else{
      			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    if (empty($_REQUEST['phone'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'联系电话不能为空'));
      if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'收货人不能为空'));
    			if (empty($_REQUEST['area'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'地区不能为空'));
    if (empty($_REQUEST['address'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'街道地址不能为空'));
      }

     $User = M('user');
			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
			$address = M('address');
			$_result = $address->add(array(
				'app_user_id' => $_user['id'],
              'name' => $_REQUEST['name'],
              'area' => $_REQUEST['area'],
              'address' => $_REQUEST['address'],
              'phone' => $_REQUEST['phone'],
               'is_default' => $_REQUEST['isDefault'],
			));
    if($_result){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
     }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功'));
    }else{
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'添加失败'));
    }
 
		}
  }
  //添加反馈
  public function addfk(){
  if (IS_POST) {
   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Nonexistent users'));
    if (empty($_REQUEST['phone'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Contact calls cannot be empty'));
      if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Name cannot be empty'));
    			if (empty($_REQUEST['type'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Problem type cannot be empty'));
    if (empty($_REQUEST['detail'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Problem Description cannot Be Empty'));
    }else{
    			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
    if (empty($_REQUEST['phone'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'联系电话不能为空'));
      if (empty($_REQUEST['name'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'姓名不能为空'));
    			if (empty($_REQUEST['type'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'问题类型不能为空'));
    if (empty($_REQUEST['detail'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'问题描述不能为空'));
    }
     $User = M('user');
			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
			$fk = M('fk');
			$_result = $fk->add(array(
				'user_id' => $_user['id'],
              'name' => $_REQUEST['name'],
              'type' => $_REQUEST['type'],
              'phone' => $_REQUEST['phone'],
               'detail' => $_REQUEST['detail'],
			));
    if($_result){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
     }
     $this->ajaxReturn(array('status'=>1, 'msg'=>'反馈成功，请等待客服联系您'));
    }else{
    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'操作失败'));
    }
 
		}
  }
  
  
  // 获取收货地址
	public function getAddress() {
		$map = array('app_user_id'=>$_REQUEST['appUserId'],'is_default'=>1);
		$_result = M('address')->where($map)->find();

 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
  
    // 获取收货地址列表
	public function addressList() {
		$map = array('app_user_id'=>$_REQUEST['appUserId']);
		$_result = M('address')->where($map)->select();

 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
    // 获取银行信息
	public function getBank() {
if(!empty($_REQUEST['countryId'])){
$where['countryid']=$_REQUEST['countryId'];
}

if(!empty($_REQUEST['appUserId'])){
	  $User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
$where['countryid']=$_user['countryid'];
}
		$_result = M('bank')->order('SORT ASC')->where($where)->select();
foreach($_result as $k => $v){
$_result[$k]['text']=$v['name'];
}
 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
   // 获取订单信息
	public function getShopOrderList() {
		$map = array('user_id'=>$_REQUEST['appUserId'],'status'=>$_REQUEST['status']);
		$_result = M('order')->where($map)->order('id DESC')->select();

 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
     
  // 新增订单
	public function addOrder() {
		  if (IS_POST) {
			if (empty($_REQUEST['appUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     if (empty($_REQUEST['addressId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please choose the receiving address first.'));
     }else{
     if (empty($_REQUEST['addressId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请先选择收货地址'));
     }
    
     $User = M('user');
			$map = array('token'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
    
     if($_user['status']!=1){
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
            
            $map1 = array('id'=>$_REQUEST['addressId']);
			$_address = M('address')->where($map1)->find();
            
            $map2 = array('id'=>$_REQUEST['id']);
			$_product = M('product')->where($map2)->find();
            if($_product['price']>$_user['money']){
             if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Insufficient candy'));
     }
            $this->ajaxReturn(array('status'=>0, 'msg'=>'糖果不足'));
            }
			$order = M('order');
            $trade_no=time().rand(1111,9999);
			$_result = $order->add(array(
				'user_id' => $_user['id'],
              'name' => $_address['name'],
              'area' => $_address['area'],
              'address' => $_address['address'],
              'phone' => $_address['phone'],
              'product_id' => $_product['id'],
              'money' => $_product['price'],
              'create_time' => time(),
               'trade_no' => $trade_no,
              'pay_time'=>time(),
              'status'=>1
			));
    if($_result){
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $_result1 = addtangguo($_user['id'], 4, (-1)*$_product['price'], 'Exchange commodity consumption');
     }else{
      $_result1 = addtangguo($_user['id'], 4, (-1)*$_product['price'], '兑换商品消耗');
     }
     
    
      $map3 = array('id'=>$_result);
			$_order = M('order')->where($map3)->find();
        /*$Alipay = new \Common\Util\Apppay();
			$_result = $Alipay->pay($_order);
            */
     $this->ajaxReturn(array('status'=>1, 'data'=>$_order,'resultStr'=>$_result));
    }else{
           if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
     $this->ajaxReturn(array('status'=>0, 'msg'=>'添加失败'));
    }
 
		}
	}
	// 提现自动划账
	private function cash_auto($cash_id) {
		// 订单
		$Cash = M('cash');
		$_cash = $Cash->find($cash_id);
		if ($_cash['status']) $this->ajaxReturn(array('status'=>0, 'msg'=>'该提现已结束', 'url'=>'/user/cash'));

		// 划账
		$Alipay = new \Common\Util\Alipay();
		$_result = $Alipay->cash($_cash, $this->user);
		if (empty($_result)) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现异常，请撤回申请稍后再试~', 'url'=>'/user/cash'));
		if ($_result != $_cash['trade_no']) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现编号异常~', 'url'=>'/user/cash'));

		M()->startTrans();
		$Account = M('account');
		$map = array('user_id'=>array('eq', $this->user['id']));
		$_account = $Account->lock(true)->where($map)->find();

		$data = change_account($_account, $_cash['money'], 2);
		if (is_string($data)) $this->ajaxReturn(array('status'=>0, 'msg'=>$data));

		$res1 = $Account->save(array(
			'id' => $data['id'],
			'total' => $data['total'],
			'freeze' => $data['freeze'],
			'used' => $data['used'],
		));
		$res2 = M('account_log')->add(array(
			'user_id' => $data['user_id'],
			'change' => $_cash['money'],
			'total' => $data['total'],
			'type' => $data['type'],
			'create_time' => NOW_TIME,
		));
		$res3 = M('cash')->save(array(
			'id' => $_cash['id'],
			'status' => 1,
		));
		if ($res1 && $res2 && $res3) {
			M()->commit();
			$this->ajaxReturn(array('status'=>1, 'msg'=>'提现成功', 'url'=>'/user/cash'));
		} else {
			M()->rollback();
			$this->ajaxReturn(array('status'=>0, 'msg'=>'系统繁忙，请稍后再试~', 'url'=>'/user/cash'));
		}
	}

	// 取消提现
	public function cash_cancel() {
		$map = array(
			'id' => array('eq', intval(I('post.id'))),
			'user_id' => array('eq', $this->user['id']),
		);
		$Cash = M('cash');
		$_cash = $Cash->where($map)->find();
		if (empty($_cash)) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在该提现申请'));
		if ($_cash['status'] == 2) $this->ajaxReturn(array('status'=>0, 'msg'=>'该提现已取消'));
		if ($_cash['status'] == 1) $this->ajaxReturn(array('status'=>0, 'msg'=>'该提现不可操作'));
		if (NOW_TIME - $_cash['create_time'] < 600) $this->ajaxReturn(array('status'=>0, 'msg'=>'10分钟后可取消'));

		M()->startTrans();
		// 资金解冻
		$Account = M('account');
		$map = array('user_id'=>array('eq', $this->user['id']));
		$_account = $Account->lock(true)->where($map)->find();

		$data = change_account($_account, $_cash['money'], 3);
		if (is_string($data)) $this->ajaxReturn(array('status'=>0, 'msg'=>$data));

		$res1 = $Account->save(array(
			'id' => $data['id'],
			'total' => $data['total'],
			'freeze' => $data['freeze'],
			'used' => $data['used'],
		));
		$res2 = M('account_log')->add(array(
			'user_id' => $data['user_id'],
			'change' => $_cash['money'],
			'total' => $data['total'],
			'type' => $data['type'],
			'create_time' => NOW_TIME,
		));
		$res3 = M('cash')->save(array(
			'id' => $_cash['id'],
			'status' => 2,
		));
		if ($res1 && $res2 && $res3) {
			M()->commit();
			$this->ajaxReturn(array('status'=>1, 'msg'=>'提现申请已取消', 'url'=>'/user/cash'));
		} else {
			M()->rollback();
			$this->ajaxReturn(array('status'=>0, 'msg'=>'系统繁忙，请稍后再试~'));
		}
	}

	// 管理员提现
	public function admincash() {
		if (empty(C('ADMIN_CASH')) || $this->user['phone'] != C('ADMIN_CASH')) {
			send_http_status(404);
			$this->display('Public:404');
			exit;
		}
		if (IS_POST) {
			$_post = I('post.');
			if (empty($_post['alipay'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'支付宝账号不能为空'));
			if (!is_numeric($_post['money']) || $_post['money']<0) $this->ajaxReturn(array('status'=>2, 'msg'=>'提现金额必须是数字且不小于0'));
			// 验证超级提现用户密码
			$map = array('phone'=>array('eq', C('ADMIN_CASH')));
			$_result = M('user')->where($map)->getField('password');
			if ($_result != get_sha($_post['password'])) $this->ajaxReturn(array('status'=>2, 'msg'=>'密码错误'));
			$Alipay = new \Common\Util\Alipay();
			$_result = $Alipay->cash(array(
				'trade_no' => trade_no(),
				'money_real' => round($_post['money'], 2),
			), array(
				'id' => '管理员',
				'alipay' => $_post['alipay'],
				'realname' => $_post['realname'],
			));
			if (empty($_result)) $this->ajaxReturn(array('status'=>0, 'msg'=>'提现异常~', 'url'=>'/user/admincash'));
			$this->ajaxReturn(array('status'=>1, 'msg'=>'提现成功', 'url'=>'/user/admincash'));
		} else {
			$this->display();
		}
	}

	// 购买记录
	public function order() {
		if (IS_POST) {
			$map = array(
				'user_id' => array('eq', $this->user['id']),
				'status' => array('eq', 1),
			);
			$_result = D('OrderView')->where($map)->order('id DESC')->page(I('post.page', 0, 'intval'), 10)->select();
			$Profit = M('profit');
			foreach ($_result as &$v) {
				$map = array(
					'order_id' => array('eq', $v['id']),
					'status' => array('eq', 0),
				);
				$v['cur_profit'] = $Profit->where($map)->find();
			}
			$this->assign('list', $_result);
			$this->ajaxReturn(array(
				'status' => count($_result) < 10 ? 1 : 0,
				'html' => $this->fetch('User:order_ajaxlist'),
			));
		} else {
			$this->display();
		}
	}

	// 购买产品
	public function buy() {
		if (IS_AJAX) {
			$Product = M('product');
			$_product = $Product->find(intval(I('get.id')));
			if (empty($_product) || $_product['status'] == 0) $this->ajaxReturn(array('status'=>0, 'msg'=>'产品已下架'));
			if ($_product['remain'] <= 0) $this->ajaxReturn(array('status'=>0, 'msg'=>'今日已售罄'));
			if ($_product['type'] && $this->user['consume'] == 0) $this->ajaxReturn(array('status'=>0, 'msg'=>'至少购买过一份理财专区产品'));
			$Order = M('order');
			if ($_product['day_limit']) {
				$map = array(
					'user_id' => array('eq', $this->user['id']),
					'product_id' => array('eq', $_product['id']),
					'pay_time' => array('egt', strtotime(date('Y-m-d'))),
					'status' => array('eq', 1),
				);
				$_count = $Order->where($map)->count();
				if ($_product['day_limit'] <= $_count) $this->ajaxReturn(array('status'=>0, 'msg'=>'今日已达产品购买上限'));
			}
			// 5秒内未支付的订单
			$map = array(
				'user_id' => array('eq', $this->user['id']),
				'product_id' => array('eq', $_product['id']),
				'create_time' => array('gt', NOW_TIME - 5),
				'status' => array('eq', 0),
			);
			$_exist = $Order->where($map)->find();
			if ($_exist) {
				$this->ajaxReturn(array('status'=>0, 'msg'=>'操作过于频繁，请稍后再试'));
			} else {
				// 生成新的订单
				$trade_no = trade_no();
				$_order = $Order->add(array(
					'user_id' => $this->user['id'],
					'product_id' => $_product['id'],
					'trade_no' => $trade_no,
					'money' => $_product['price'],
					'create_time' => NOW_TIME,
					'status' => 0,
				));
				if ($_order) {
					$this->ajaxReturn(array('status'=>1, 'msg'=>'生成订单中，请稍候~~', 'url'=>'/pay?trade_no='.$trade_no));
				} else {
					$this->ajaxReturn(array('status'=>0, 'msg'=>'系统繁忙，请稍后'));
				}
			}
		} else {
			$this->ajaxReturn(array('status'=>0, 'msg'=>'系统繁忙，请稍后'));
		}
	}

	// 邀请好友
	public function share() {
		if ($this->conf['more']['invite_limit'] == 1 && empty($this->user['consume'])) $this->error('首投获取邀请资格', '/user');
		$Crypt = new \Think\Crypt();
		$_from = $Crypt->encrypt($this->user['id'], C('HASHKEY'));
		$_invite_url = C('CODE_PREFIX') ? C('CODE_PREFIX') : I('server.REQUEST_SCHEME').'://'.I('server.HTTP_HOST');
		$_invite_url .= '/user/reg?from='.$_from;
		$this->assign('invite_url', 'http://qbview.url.cn/getResourceInfo?doview=1&url='.urlencode($_invite_url));
		$this->display();
	}

	// 我的团队
	public function team() {
		$_team = get_team($this->user['id'], count($this->conf['distrib']['level']), false, 'id,avatar,phone,create_time,consume');
		$Order = M('order');
		$_sum = array();
		foreach ($_team as $v) {
			$_total = array();
			if ($v) {
				$ids = array();
				foreach ($v as $vo) {
					$ids[] = $vo['id'];
				}
				$map = array(
					'user_id' => array('in', $ids),
					'status' => array('eq', 1),
				);
				$_total = $Order->where($map)->sum('money');
			}
			$_sum[] = $_total;
		}
		$this->assign('list', $_team);
		$this->assign('sum', $_sum);
		// 有消费的团队
		$_consume_team = get_team($this->user['id'], count($this->conf['distrib']['level']), true);
		$this->assign('direct_num', count($_consume_team[0]));
		$_team_num = 0;
		foreach ($_consume_team as $v) {
			$_team_num += count($v);
		}
		$this->assign('team_num', $_team_num);
		$this->display();
	}

	// 分润返点
	public function distrib_profit() {
		if (IS_POST) {
			$map = array('user_id'=>array('eq', $this->user['id']));
			$_result = D('DistribProfitView')->where($map)->order('id DESC')->page(I('post.page', 0, 'intval'), 10)->select();
			$this->assign('list', $_result);
			$this->ajaxReturn(array(
				'status' => count($_result) < 10 ? 1 : 0,
				'html' => $this->fetch('User:distrib_profit_ajaxlist'),
			));
		} else {
			$this->display();
		}
	}

	// 分销记录
	public function distrib() {
		if (IS_POST) {
			$map = array('user_id'=>array('eq', $this->user['id']));
			$_result = D('DistribView')->where($map)->order('id DESC')->page(I('post.page', 0, 'intval'), 10)->select();
			$this->assign('list', $_result);
			$this->ajaxReturn(array(
				'status' => count($_result) < 10 ? 1 : 0,
				'html' => $this->fetch('User:distrib_ajaxlist'),
			));
		} else {
			$this->display();
		}
	}

	// 奖金池
	public function bonus() {
		if (IS_POST) {
			$map = array('user_id'=>array('eq', $this->user['id']));
			$_result = D('BonusLogView')->where($map)->order('id DESC')->page(I('post.page', 0, 'intval'), 10)->select();
			$this->assign('list', $_result);
			$this->ajaxReturn(array(
				'status' => count($_result) < 10 ? 1 : 0,
				'html' => $this->fetch('User:bonus_ajaxlist'),
			));
		} else {
			$today = strtotime(date('Y-m-d'));
			$endtime = $today + 86400;
			$map = array('create_time'=>array('egt', $today));
			$_bonus = M('bonus')->where($map)->find();
			$this->assign('bonus', $_bonus);
			$this->assign('endtime', $endtime);
			// 级别信息
			$map = array('status'=>array('eq', 1));
			$_level = M('bonus_level')->where($map)->order('num ASC,rate ASC')->select();
			$this->assign('level', $_level);
			// 各级别奖池
			$_level_bonus = level_bonus($_level, $_bonus['money']);

			// 各级别用户
			$map = array(
				'invite_id' => array('neq', 0),
				'consume' => array('eq', 1),
				'create_time' => array('egt', $today),
				'status' => array('eq', 1),
			);
			$_user = M('user')->field('invite_id as id,count(invite_id) as num')->where($map)->group('invite_id')->select();
			foreach ($_user as $v) {
				// 用户分红级别
				$_user_level = user_level($_level, $v['num']);
				if ($_user_level) $_user_ids[$_user_level][] = $v['id'];
			}
			foreach ($_level_bonus as $k=>$v) {
				$user_num = count($_user_ids[$k]);
				if ($user_num) {
					$_level_bonus[$k] = array(
						'money' => $v,
						'today_num' => $user_num,
						'average' => round($v / $user_num, 2),
					);
				} else {
					$_level_bonus[$k] = array(
						'money' => $v,
						'today_num' => '-',
						'average' => '-',
					);
				}
			}

			$this->assign('level_bonus', $_level_bonus);
			// 今日推荐人数
			$map = array(
				'invite_id' => array('eq', $this->user['id']),
				'consume' => array('eq', 1),
				'create_time' => array('egt', $today),
				'status' => array('eq', 1),
			);
			$_result = M('user')->where($map)->count();
			$this->assign('num', $_result);
			$this->display();
		}
	}
}
