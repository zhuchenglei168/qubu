<?php 

defined('G_IN_SYSTEM')or exit('No permission resources.');

System::load_app_class('admin',G_ADMIN_DIR,'no');

class member extends admin {

	

	public function __construct(){

		parent::__construct();

		$this->db=System::load_sys_class("model");

		$this->ment=array(

						array("lists","会员列表",ROUTE_M.'/'.ROUTE_C."/lists"),

						array("lists","查找会员",ROUTE_M.'/'.ROUTE_C."/select"),

						array("insert","添加会员",ROUTE_M.'/'.ROUTE_C."/insert"),

						array("insert","会员回收站",ROUTE_M.'/'.ROUTE_C."/lists/del"),

						array("insert","会员配置",ROUTE_M.'/'.ROUTE_C."/config"),

						array("insert","<b>会员福利配置</b>",ROUTE_M.'/'.ROUTE_C."/member_fufen"),

						array("insert","充值记录",ROUTE_M.'/'.ROUTE_C."/recharge"),

						array("insert","未注册成功会员",ROUTE_M.'/'.ROUTE_C."/noregmember"),

						array("insert","快捷及微信注册会员",ROUTE_M.'/'.ROUTE_C."/otherregmember"),

						array("insert","批量导入的会员(虚假会员)",ROUTE_M.'/'.ROUTE_C."/daorumember"),

		);

	} 

	
	public function noregmember(){

		$table = "@#_member";

		$num=20;

		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_member` WHERE `emailcode` <> '1' and `mobilecode` <> '1' and `auto_user` != 1 and (`email` !='' OR `mobile` !='')"); 

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");	

		$members=$this->db->GetPage("SELECT * FROM `@#_member` WHERE `emailcode` <> '1' and `mobilecode` <> '1' and `auto_user` != 1 and (`email` !='' OR `mobile` !='')",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		

		include $this->tpl(ROUTE_M,'member.lists');

	}

	public function otherregmember(){

		$table = "@#_member";

		$num=20;

		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_member`  WHERE `emailcode` <> '1' and `mobilecode` <> '1' and `auto_user` != 1 and (`email` ='' AND `mobile` ='')"); 

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");	

		$members=$this->db->GetPage("SELECT * FROM `@#_member` WHERE `emailcode` <> '1' and `mobilecode` <> '1' and `auto_user` != 1 and (`email` ='' AND `mobile` ='')",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		

		include $this->tpl(ROUTE_M,'member.lists');	

	}

	public function daorumember(){

		$table = "@#_member";

		$num=20;

		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_member`  WHERE `auto_user`= 1"); 

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");	

		$members=$this->db->GetPage("SELECT * FROM `@#_member` WHERE  `auto_user`= 1",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		

		include $this->tpl(ROUTE_M,'member.lists');	

	}

	

	//显示会员

	public function lists(){

	

		$where = $this->segment(4);		

		if($where == 'del'){

			$table = "@#_member_del";

		}else{

			$table = "@#_member";

		}

		

		$sql_where = '';		

	

		if($where == 'login'){

			$login_where = $this->segment(5);			

			switch($login_where){			

				case '1':

				

				break; 

				case '1':

					

				break; 

				case '1':

					

				break; 

				case 'desc':

					

				break; 

				case 'asc':

					

				break; 

				default:

				

				break;			

			}

		}

		

	

		$num=20;

		$total=$this->db->GetCount("SELECT COUNT(*) FROM `$table` WHERE (`emailcode` = '1' or `mobilecode` = '1') and `auto_user` != 1"); 

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");		

		$members=$this->db->GetPage("SELECT * FROM `$table` WHERE (`emailcode` = '1' or `mobilecode` = '1' ) and `auto_user` != 1",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		include $this->tpl(ROUTE_M,'member.lists');	

	}

	//添加会员

	public function insert(){
exit;
		$mysql_model=System::load_sys_class('model');

		$member_allgroup=$mysql_model->Getlist("select groupid,name from `@#_member_group`");



		if(isset($_POST['submit'])){

			$username=htmlspecialchars(trim($_POST['username']));

			if(empty($username)){

				_message("用户名不能为空");

				exit;

			}

			$password=htmlspecialchars(trim($_POST['password']));

			if(empty($password)){

				_message("密码不能为空");

				exit;

			}else{

				$password=md5($password);

			}

			$img = htmlspecialchars($_POST['thumb']);

			$email=htmlspecialchars(trim($_POST['email']));

			$mobile=htmlspecialchars(trim($_POST['mobile']));

			

			$money=htmlspecialchars(trim($_POST['money']));

			$jingyan=htmlspecialchars(trim($_POST['jingyan']));

			$score=htmlspecialchars(trim($_POST['score']));

			$emailcode=htmlspecialchars(trim($_POST['emailcode']));

			$mobilecode=htmlspecialchars(trim($_POST['mobilecode']));

			$qianming=htmlspecialchars(trim($_POST['qianming']));

			$membergroup=htmlspecialchars(trim($_POST['membergroup']));

			$time = time();

			$sql="INSERT INTO `@#_member` (username,img,email,mobile,password,money,jingyan,score,emailcode,mobilecode,qianming,groupid,time) value ('$username','$img','$email','$mobile','$password','$money','$jingyan','$score','$emailcode','$mobilecode','$qianming','$membergroup','$time')";

			$this->db->Query($sql);

			if($this->db->affected_rows()){

					_message("增加成功");

			}else{

					_message("增加失败");

			}

		}

		include $this->tpl(ROUTE_M,'member_insert');

	}



	//修改会员

	public function modify(){
exit;
		$uid=intval($this->segment(4));

		$member=$this->db->Getone("select * from `@#_member` where `uid`='$uid'");

		

		$member_group=$this->db->Getone("select name from `@#_member_group` where `groupid`=".$member['groupid']."");

		$member_allgroup=$this->db->Getlist("select groupid,name from `@#_member_group`");

		

		if(!empty($member['addgroup'])){		

			$member['addgroup'] = trim($member['addgroup'],',');

			$addgroup=explode(',',$member['addgroup']);			

			for($i=0;$i<count($addgroup);$i++){

				$quanzi=$this->db->Getone("select title from `@#_quanzi` where `id`=".$addgroup[$i]."");

				$quanziname[]=$quanzi['title'];

			}

		}

		

		

		if(isset($_POST['submit'])){

		

			$img = htmlspecialchars($_POST['thumb']);				

			$username=htmlspecialchars(trim($_POST['username']));			

			$email=htmlspecialchars(trim($_POST['email']));

			$mobile=htmlspecialchars(trim($_POST['mobile']));

			$password=htmlspecialchars(trim($_POST['password']));

			if(empty($password)){

				$password=$member['password'];

			}else{

				$password=md5($password);

			}

			$money=htmlspecialchars(trim($_POST['money']));

			$jingyan=htmlspecialchars(trim($_POST['jingyan']));

			$score=htmlspecialchars(trim($_POST['score']));

			$emailcode=htmlspecialchars(trim($_POST['emailcode']));

			$mobilecode=htmlspecialchars(trim($_POST['mobilecode']));

			$qianming=htmlspecialchars(trim($_POST['qianming']));

			$membergroup=htmlspecialchars(trim($_POST['membergroup']));			

			$sql="UPDATE `@#_member` SET `username`='$username',`email`='$email',`mobile`='$mobile',`password`='$password',`money`='$money',`jingyan`='$jingyan',`score`='$score',`emailcode`='$emailcode',`mobilecode`='$mobilecode',`img`='$img',`groupid`='$membergroup',`qianming`='$qianming' WHERE `uid`='$uid'";

			

			if($this->db->Query($sql)){

					_message("修改成功");

			}else{

					_message("修改失败");

			}

		}

		

		include $this->tpl(ROUTE_M,'member_modify');	

	}



	

	//恢复会员

	public function huifu(){
exit;
		$uid=intval($this->segment(4));

		$this->db->Autocommit_start();		

		$q1 = $this->db->Query("insert into `@#_member` select * from `@#_member_del` where uid='$uid'");

		$q2 = $this->db->Query("delete from `@#_member_del` where uid='$uid'");		

		if($q1 && $q2){

			$this->db->Autocommit_commit();

			_message("恢复成功");

		}else{

			$this->db->Autocommit_rollback();

			_message("恢复失败");

		}	

		

	}

	

	//删除会员

	public function del(){
exit;
		$uid=intval($this->segment(4));

		$this->db->Autocommit_start();		

		$q1 = $this->db->Query("insert into `@#_member_del` select * from `@#_member` where uid='$uid'");

		$q2 = $this->db->Query("delete from `@#_member` where uid='$uid'");		

		$q3 = $this->db->Query("delete from `@#_member_band` where `b_uid`='$uid'");

		if($q1 && $q2 && $q3){

			$this->db->Autocommit_commit();

			_message("删除成功");

		}else{

			$this->db->Autocommit_rollback();

			_message("删除失败");

		}			

	}

	

	public function del_true(){

		$uid=intval($this->segment(4));

		$q1 = $this->db->Query("delete from `@#_member_del` where uid='$uid'");		

		if($q1){

			_message("删除成功");

		}else{

			_message("删除失败");

		}			

	}

	

	//查找会员

	public function select(){

		if(isset($_POST['submit'])){

			$sousuo=htmlspecialchars(trim($_POST['sousuo']));

			$content=htmlspecialchars(trim($_POST['content']));

		

			if(empty($sousuo) || empty($content)){

				_message("参数错误");

			}

			$members = array();

			if($sousuo=='id'){			

				$members[0]=$this->db->GetOne("SELECT * FROM `@#_member` WHERE `uid` = '$content'");				

			}

			if($sousuo=='nickname'){	

				$members=$this->db->GetList("SELECT * FROM `@#_member` WHERE `username` LIKE '%$content%'"); 

			}

			if($sousuo=='email'){				

				$members=$this->db->GetList("SELECT * FROM `@#_member` WHERE `email` LIKE '%$content%'");				

			}

			if($sousuo=='mobile'){

				$members=$this->db->GetList("SELECT * FROM `@#_member` WHERE `mobile` LIKE '%$content%'");			

			}			

			

		}

		

		include $this->tpl(ROUTE_M,'member_select');

		

	}

	

	//会员组

		public function member_group(){

			$this->ment=array(

						array("member_group","会员组",ROUTE_M.'/'.ROUTE_C."/member_group"),

						array("member_add_group","添加会员组",ROUTE_M.'/'.ROUTE_C."/member_add_group"),

						

			);

			$members=$this->db->Getlist("select * from `@#_member_group` where 1");

			include $this->tpl(ROUTE_M,'member.member_group');		

		}

		

		//修改会员组

		public function group_modify(){

			$id=intval($this->segment(4));

			$members=$this->db->Getone("select * from `@#_member_group` where `groupid`='$id'");

			if(isset($_POST['submit'])){

				$name=htmlspecialchars(trim($_POST['name']));

				$jingyan_start=htmlspecialchars(trim($_POST['jingyan_start']));

				$jingyan_end=htmlspecialchars(trim($_POST['jingyan_end'])); 

				if(empty($name) || empty($jingyan_start)  || empty($jingyan_end)){

					_message('会员组或者经验值不能为空');

				}elseif( $jingyan_start >= $jingyan_end){

					 _message('开始经验不能大于结束经验');

				}elseif($jingyan_end <= $jingyan_start){ 

					_message('结束经验不能小于开始经验');

				}

				$sql="UPDATE `@#_member_group` SET `name`='$name',`jingyan_start`='$jingyan_start', `jingyan_end`='$jingyan_end' WHERE `groupid`='$id'";

				$this->db->Query($sql);

				if($this->db->affected_rows()){

						_message("修改成功");

				}else{

						_message("修改失败");

				}

			}

			include $this->tpl(ROUTE_M,'member.group_modify');		

		}

		

		

		//删除会员组

		public function group_del(){

			$id=intval($this->segment(4));

			$sql="DELETE FROM `@#_member_group` WHERE `groupid`='$id'";

				$this->db->Query($sql);

				if($this->db->affected_rows()){

						_message("删除成功");

				}else{

						_message("删除失败");

				}

		}

		

		//增加会员组

		public function member_add_group(){

			if(isset($_POST['submit'])){

				$name=htmlspecialchars(trim($_POST['name']));

				$jingyan_start=htmlspecialchars(trim($_POST['jingyan_start']));

				$jingyan_end=htmlspecialchars(trim($_POST['jingyan_end']));

				if(empty($name) || empty($jingyan_start) || empty($jingyan_end)){

					_message('会员组或者经验值不能为空');

				}

				$sql="INSERT INTO `@#_member_group` (`name`,`jingyan_start`,`jingyan_end`) value ('$name','$jingyan_start','$jingyan_end')";

				$this->db->Query($sql);

				if($this->db->affected_rows()){

						_message("增加成功");

				}else{

						_message("增加失败");

				}

			}

			include $this->tpl(ROUTE_M,'add_membergroup');

		}

		

		



		//会员配置

		public function config(){

			$nickname = $this->db->GetOne("select * from `@#_caches` where `key` = 'member_name_key' limit 1");			

			if(isset($_POST['submit'])){

				$nicknames = htmlspecialchars($_POST['nickname']);

				$nicknames = trim($nicknames,",");

				$nicknames = str_ireplace(" ",'',$nicknames);

				if($nickname){

					$this->db->Query("UPDATE `@#_caches` SET `value` = '$nicknames' where `key` = 'member_name_key'");

				}else{

					$this->db->Query("INSERT INTO `@#_caches` (`key`,`value`) value ('member_name_key','$nicknames')");

				}

				_message("操作成功");

			}			

			$nickname = $nickname['value'];

			include $this->tpl(ROUTE_M,'member_config');

		}

		

		//福分配置

		public function member_fufen(){

			if(isset($_POST['submit'])){			

				$path =  dirname(__FILE__).'/lib/user_fufen.ini.php';			

				if(!is_writable($path)) _message('Please chmod  user_fufen.ini.php  to 0777 !');

				$f_overziliao=intval(trim($_POST['f_overziliao']));

				$f_shoppay=intval(trim($_POST['f_shoppay']));

				$f_phonecode=intval(trim($_POST['f_phonecode']));

				$f_visituser=intval(trim($_POST['f_visituser']));

				//以上是福分，一下是经验值

				$z_overziliao=intval(trim($_POST['z_overziliao']));

				$z_shoppay=intval(trim($_POST['z_shoppay']));

				$z_phonecode=intval(trim($_POST['z_phonecode']));

				$z_visituser=intval(trim($_POST['z_visituser']));

				$fufen_yuan=intval(trim($_POST['fufen_yuan']));

				$fufen_yongjin=floatval(trim($_POST['fufen_yongjin']));

	

				$fufen_yongjintx=floatval(trim($_POST['fufen_yongjintx']));

				if($fufen_yuan<=0){

					_message('福分输入有错误');

				}

				$jieguo=$fufen_yuan%10;

				if($jieguo!=0){

					_message('福分输入有错误');

				}

			$html=<<<HTML

<?php 

return array (	

	'f_overziliao' => '$f_overziliao',

	'f_shoppay' => '$f_shoppay',

	'f_phonecode' => '$f_phonecode',

	'f_visituser' => '$f_visituser'	,

	'z_overziliao' => '$z_overziliao',

	'z_shoppay' => '$z_shoppay',

	'z_phonecode' => '$z_phonecode',

	'z_visituser' => '$z_visituser',

	'fufen_yuan' => '$fufen_yuan',

	'fufen_yongjin' => '$fufen_yongjin',

	'fufen_yongjintx' => '$fufen_yongjintx'

);

?>

HTML;



				file_put_contents($path,$html);

				_message("修改成功!");

			}

			

			$config = System::load_app_config("user_fufen");		

			include $this->tpl(ROUTE_M,'member_insertfufen');

		}

		

		

				//佣金提现申请管理

	public function commissions(){	

	

		$num=20;

		$total=$this->db->GetCount("SELECT COUNT(*) FROM `@#_member_cashout` WHERE 1"); 

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");		

		$commissions=$this->db->GetPage("SELECT * FROM `@#_member_cashout`  WHERE 1",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		

		//查询用户名

		if(!empty($commissions)){

		   foreach($commissions as $key=>$val){

		      $uid=$val['uid'];

			  $user[$key]=$this->db->GetOne("SELECT username FROM `@#_member` WHERE `uid`='$uid'  ");

			  

		   }

         }

        $fufen = System::load_app_config("user_fufen",'','member');

		include $this->tpl(ROUTE_M,'member.commissions');

	}

	

	//佣金提现申请审核

	public function commreview(){

	 $id=intval($this->segment(4));

	 

      

		 $audsta=$this->db->GetOne("SELECT * FROM `@#_member_cashout` WHERE `id`='$id'  ");

		 $is=$this->db->Query("UPDATE `@#_member_cashout` SET `auditstatus`='1' where `id`=$id "); 

		 if($is==1){

		  //审核通过后将该数据插入到佣金记录表中

		  

		  $type=-3;

		  $content="提现";

		  $is=$this->db->Query("INSERT INTO `@#_member_recodes`(`uid`,`type`,`content`,`money`,`time`,`cashoutid`)VALUES($audsta[uid],'$type','$content','$audsta[money]','$audsta[time]','$audsta[id]')"); 

		  

		  

		   _message("审核成功！");

		 }else{

			_message("审核失败！");	 

		 }

	}

	//充值记录

	public function recharge(){

		

		if(isset($_POST['sososubmit'])){

			$posttime1=isset($_POST['posttime1'])?$_POST['posttime1']:'';

			$posttime2=isset($_POST['posttime2'])?$_POST['posttime2']:'';

			if(empty($posttime1) || empty($posttime2)) _message("2个时间都不为能空！");

			if(!empty($posttime1) && !empty($posttime2)){ //如果2个时间都不为空

				$posttime1=strtotime($posttime1);

				$posttime2=strtotime($posttime2);

				if($posttime1 > $posttime2){

					_message("前一个时间不能大于后一个时间");

				}

				$times= "`time`>='$posttime1' AND `time`<='$posttime2'";

			}

			$chongzhi=isset($_POST['chongzhi'])?$_POST['chongzhi']:'';

			if(!empty($chongzhi) && $chongzhi!='请选择充值来源'){

				$content=" AND `content`='$chongzhi'";

			}

			if(empty($chongzhi) || $chongzhi=='请选择充值来源') $content=" AND (`content`='充值' or `content`='使用佣金充值到云购账户' or `content`='使用余额宝充值到云购账户')";

			

			$yonghu=isset($_POST['yonghu'])?$_POST['yonghu']:'';

			if(empty($yonghu) || $yonghu=='请选择用户类型'){

				$uid=' AND 1';

			}

			$yonghuzhi=isset($_POST['yonghuzhi'])?$_POST['yonghuzhi']:'';

			if($yonghu=='用户id'){

				if($yonghuzhi){

					$uid=" AND `uid`='$yonghuzhi'";

				}else{

					$uid=' AND 1';

				}

			}

			if($yonghu=='用户名称'){

				if($yonghuzhi){

					$user_uid=$this->db->GetOne("select uid from `@#_member` where `username`='$yonghuzhi'");

					if($user_uid){

						$uid=" AND `uid`='$user_uid[uid]'";

					}else{

						_message($yonghuzhi."用户不存在！");

						$uid=' AND 1';

					}

				}else{

					$uid=' AND 1';

				}

			}

			if($yonghu=='用户邮箱'){

				if($yonghuzhi){

					$user_uid=$this->db->GetOne("select uid from `@#_member` where `email`='$yonghuzhi'");

					if($user_uid){

						$uid=" AND `uid`='$user_uid[uid]'";

					}else{

						_message($yonghuzhi."用户不存在！");

						$uid=' AND 1';

					}

				}else{

					$uid=' AND 1';

				}

			}

			if($yonghu=='用户手机'){

				if($yonghuzhi){

					$user_uid=$this->db->GetOne("select uid from `@#_member` where `mobile`='$yonghuzhi'");

					if($user_uid){

						$uid=" AND `uid`='$user_uid[uid]'";

					}else{

						_message($yonghuzhi."用户不存在！");

						$uid=' AND 1';

					}

				}else{

					$uid=' AND 1';

				}

			}

			$wheres=$times.$content.$uid;

		}

		$num=20;

		if(empty($wheres)){

			$total=$this->db->GetCount("SELECT count(*) FROM `@#_member_account` WHERE (`content`='充值' or `content`='使用佣金充值到云购账户' or `content`='使用余额宝充值到云购账户' OR `content`='通过微信公众号充值') AND `type`='1'"); 

			$summoeny=$this->db->GetOne("SELECT sum(money) sum_money FROM `@#_member_account` WHERE (`content`='充值' or `content`='使用佣金充值到云购账户' or `content`='使用余额宝充值到云购账户' OR `content`='通过微信公众号充值') AND `type`='1'"); 

		}else{

			$total=$this->db->GetCount("SELECT count(*) FROM `@#_member_account` WHERE $wheres"); 

			$summoeny=$this->db->GetOne("SELECT sum(money) sum_money FROM `@#_member_account` WHERE $wheres"); 

		}

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");	

		if(empty($wheres)){

			$recharge=$this->db->GetPage("SELECT * FROM `@#_member_account` WHERE (`content`='充值' or `content`='使用佣金充值到云购账户' or `content`='使用余额宝充值到云购账户' OR `content`='通过微信公众号充值') AND `type`='1' order by `time` desc",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		}else{

			$recharge=$this->db->GetPage("SELECT * FROM `@#_member_account` WHERE  $wheres order by `time` desc",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		}

		$members=array();

		for($i=0;$i<count($recharge);$i++){

			$uid=$recharge[$i]['uid'];

			$member=$this->db->GetOne("select * from `@#_member` where `uid`='$uid'");

			$members[$i]=$member['username'];	

			if(empty($member['username'])){

				if(!empty($member['email'])){

					$members[$i]=$member['email'];

				}

				if(!empty($member['mobile'])){

					$members[$i]=$member['mobile'];

				}

			}

		}

		include $this->tpl(ROUTE_M,'member.recharge');		

	}

	//消费记录

	public function pay_list(){

		if(isset($_POST['sososubmit'])){

			$posttime1=isset($_POST['posttime1'])?$_POST['posttime1']:'';

			$posttime2=isset($_POST['posttime2'])?$_POST['posttime2']:'';

			if(empty($posttime1) || empty($posttime2)) _message("2个时间都不为能空！");

			if(!empty($posttime1) && !empty($posttime2)){ //如果2个时间都不为空

				$posttime1=strtotime($posttime1);

				$posttime2=strtotime($posttime2);

				if($posttime1 > $posttime2){

					_message("前一个时间不能大于后一个时间");

				}

				$times= "`time`>='$posttime1' AND `time`<='$posttime2'";

			}

			

			$yonghu=isset($_POST['yonghu'])?$_POST['yonghu']:'';

			if(empty($yonghu) || $yonghu=='请选择用户类型'){

				$uid=' AND 1';

			}

			$yonghuzhi=isset($_POST['yonghuzhi'])?$_POST['yonghuzhi']:'';

			if($yonghu=='用户id'){

				if($yonghuzhi){

					$uid=" AND `uid`='$yonghuzhi'";

				}else{

					$uid=' AND 1';

				}

			}

			if($yonghu=='用户名称'){

				if($yonghuzhi){

					$user_uid=$this->db->GetOne("select uid from `@#_member` where `username`='$yonghuzhi'");

					if($user_uid){

						$uid=" AND `uid`='$user_uid[uid]'";

					}else{

						_message($yonghuzhi."用户不存在！");

						$uid=' AND 1';

					}

				}else{

					$uid=' AND 1';

				}

			}

			if($yonghu=='用户邮箱'){

				if($yonghuzhi){

					$user_uid=$this->db->GetOne("select uid from `@#_member` where `email`='$yonghuzhi'");

					if($user_uid){

						$uid=" AND `uid`='$user_uid[uid]'";

					}else{

						_message($yonghuzhi."用户不存在！");

						$uid=' AND 1';

					}

				}else{

					$uid=' AND 1';

				}

			}

			if($yonghu=='用户手机'){

				if($yonghuzhi){

					$user_uid=$this->db->GetOne("select uid from `@#_member` where `mobile`='$yonghuzhi'");

					if($user_uid){

						$uid=" AND `uid`='$user_uid[uid]'";

					}else{

						_message($yonghuzhi."用户不存在！");

						$uid=' AND 1';

					}

				}else{

					$uid=' AND 1';

				}

			}

			$wheres=$times.$uid;

		}

		$num=20;

		if(empty($wheres)){

			$total=$this->db->GetCount("SELECT count(*) FROM `@#_member_go_record` WHERE 1"); 

			$summoeny=$this->db->GetOne("SELECT sum(moneycount) sum_money FROM `@#_member_go_record` WHERE 1"); 

		}else{

			$total=$this->db->GetCount("SELECT count(*) FROM `@#_member_go_record` WHERE $wheres"); 

			$summoeny=$this->db->GetOne("SELECT sum(moneycount) sum_money FROM `@#_member_go_record` WHERE $wheres"); 

		}

		$page=System::load_sys_class('page');

		if(isset($_GET['p'])){$pagenum=$_GET['p'];}else{$pagenum=1;}	

		$page->config($total,$num,$pagenum,"0");	

		if(empty($wheres)){

			$pay_list=$this->db->GetPage("SELECT * FROM `@#_member_go_record` WHERE 1 order by `time` desc",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		}else{

			$pay_list=$this->db->GetPage("SELECT * FROM `@#_member_go_record` WHERE  $wheres order by `time` desc",array("num"=>$num,"page"=>$pagenum,"type"=>1,"cache"=>0)); 

		}

		$members=array();

		for($i=0;$i<count($pay_list);$i++){

			$uid=$pay_list[$i]['uid'];

			$member=$this->db->GetOne("select * from `@#_member` where `uid`='$uid'");

			$members[$i]=$member['username'];	

			if(empty($member['username'])){

				if(!empty($member['email'])){

					$members[$i]=$member['email'];

				}

				if(!empty($member['mobile'])){

					$members[$i]=$member['mobile'];

				}

			}

		}

		include $this->tpl(ROUTE_M,'member.pay_list');	

	}

}



?>