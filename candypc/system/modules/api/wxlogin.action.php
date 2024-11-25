<?php

defined('G_IN_SYSTEM')or exit("no");
class wxlogin extends SystemAction {
	
	private $qc;
	private $db;
	private $conf;
	private $qq_openid;
	public function __construct(){	
		$this->conf = System::load_app_config("connect");
	}
	
	//wexin登录
	public function init(){
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->conf['weixin']['id'].'&redirect_uri='.WEB_PATH.'/api/wxlogin/callback/&response_type=code&scope=snsapi_userinfo&state=wechat123&connect_redirect=1#wechat_redirect';
		header("location:$url");
	}
	//wexin回调
	public function callback(){
      $token=trim($this->segment(4));
      if(!$token){
      die("操作错误!");
      }
      $access_token_url = 'http://www.07rjm.cn/index/apilogin/token/'.$token;
		//转成对象
      
		$access_token = json_decode(getCurl($access_token_url),true);
      if($access_token['status']==1){
            //var_dump($access_token);
$weixin_openid=$access_token['data']['token'];
		$this->db = System::load_sys_class("model");
		$go_user_info = $this->db->GetOne("select * from `@#_member_band` where `b_code` = '$weixin_openid' LIMIT 1");
		if(!$go_user_info){
			$this->qq_add_member($access_token['data']);
		}else{
			$uid = intval($go_user_info['b_uid']);
			$this->qq_set_member($uid,'login_bind');
		}
      }else{
      die("操作错误!");
      }

	}

	private function qq_add_member($data){
		$go_user_name=$data['phone'];
      $go_user_pass=$data['password'];
      $go_user_img='http://www.07rjm.cn/'.$data['avatar'];
      $go_user_himg='http://www.07rjm.cn/'.$data['avatar'];
      $qq_openid=$data['token'];
      $go_user_time=time();
     // var_dump($data);
      //exit;
		$q1 = $this->db->Query("INSERT INTO `@#_member` (`username`,`password`,`img`,`yaoqing`,`headimg`,`wxid`,`time`) VALUES ('$go_user_name','$go_user_pass','$go_user_img','0','$go_user_himg','$qq_openid','$go_user_time')");
		$go_user_id = $this->db->insert_id();
		$q2 = $this->db->Query("INSERT INTO `@#_member_band` (`b_uid`, `b_type`, `b_code`, `b_time`) VALUES ('$go_user_id', 'weixin', '$qq_openid', '$go_user_time')");
		// 查询用户注册
		if($q1 && $q2){
			$this->db->Autocommit_commit();
			$this->qq_set_member($go_user_id,'add');
header("location:".WEB_PATH.'/mobile/mobile');
		}else{
			$this->db->Autocommit_rollback();
			_message("登录失败!",G_WEB_PATH);
		}
		
	}

	private function qq_set_member($uid=null,$type='bind_add_login'){	
		
		$member_db=System::load_app_class('base','member');
		$memberone=$member_db->get_user_info();
		
		$member = $this->db->GetOne("select uid,password,mobile,email from `@#_member` where `uid` = '$uid' LIMIT 1");		
		$_COOKIE['uid'] = null;
		$_COOKIE['ushell'] = null;
		$_COOKIE['UID'] = null;
		$_COOKIE['USHELL'] = null;	
		$s1 = _setcookie("uid",_encrypt($member['uid']),60*60*24*7);			
		$s2 = _setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])),60*60*24*7);
		if($s1 && $s2){
			header("location:".WEB_PATH.'/mobile/mobile');
		}else{
			_message("登录失败请检查cookie!",G_WEB_PATH);
		}		
	}
	
	public function wx_set_config(){
		System::load_app_class("admin",G_ADMIN_DIR,'no');
		$objadmin = new admin();		
		$config = System::load_app_config("connect");
		if(isset($_POST['dosubmit'])){
			$wx_off = intval($_POST['type']);
			$wx_id = $_POST['id'];
			$wx_key = $_POST['key'];
			$config['weixin'] = array("off"=>$wx_off,"id"=>$wx_id,"key"=>$wx_key);
			$html = var_export($config,true);
			$html = "<?php return ".$html."; ?>";
			$path =  dirname(__FILE__).'/lib/connect.ini.php';
			if(!is_writable($path)) _message('Please chmod  connect.ini.php  to 0777 !');
			$ok=file_put_contents($path,$html);
			_message("配置更新成功!");
		}
		$config = $config['weixin'];		
		include $this->tpl(ROUTE_M,'wx_set_config');
	}

	
}

?>