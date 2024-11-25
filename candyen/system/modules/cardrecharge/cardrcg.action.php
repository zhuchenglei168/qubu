<?php 
defined('G_IN_SYSTEM')or exit('No permission resources.');
System::load_app_class('base','member','no');
System::load_app_fun('my','go');
System::load_app_fun('user','go');
System::load_sys_fun('send');
System::load_sys_fun('user');
class cardrcg extends base {
	public function __construct(){	
		parent::__construct();
		$this->db = System::load_sys_class("model");
		$member=$this->userinfo;
		if(empty($member['uid'])){
			_message('请先登录',WEB_PATH.'/member/user/login');
		}
	}
	
	
	//余额宝充值明细
	public function init(){	
		$member=$this->userinfo;
 
		/*if($member['mobilecode']==-1 || empty($member['mobile'])){
		   _message("对不起充值只针对绑定手机的<br/>客户使用，赶紧去绑定吧！");
		   exit;
		}*/
	
			$code=htmlspecialchars($_POST['code']);
			$codepwd=htmlspecialchars($_POST['codepwd']);
			$res=$this->db->GetOne("select * from `@#_czk` where `czknum`='$code'");
			 
			if(!$res){ _message("卡密号码输入有误！");exit;}
			if($res['password']!=$codepwd){_message("卡密密码输入有误！");exit;}			
			if($res['status']<>1){
			     _message("您的充值卡已使用完！请换用别的密卡！");
				 exit;
			}

				$time=time();
                $this->db->query("update `@#_czk` set `status`=0 where `id`='$res[id]'");
				$member_money=$this->db->query("update `@#_member` set money=money+'$res[mianzhi]' where `uid`='$member[uid]'");
				$member_money1=$this->db->query("insert into `@#_member_account` (`uid`,`type`,`pay`,`content`,`money`,`time`) values ('$member[uid]','1','账户','卡密充值','$res[mianzhi]','$time')");
				if($member_money){
				  _message("卡密充值成功，请查看您的账户！");exit;
				}else{
				  _message("充值失败！");exit;
				}
			
		}
		
	}
	

?>