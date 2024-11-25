<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {

	// 首页
	public function index() {
		
		set_time_limit(0);
    $User = M('user');
	$_userlist = $User->where("(citycode=0 or citycode=2 or citycode='') and area !=''")->limit(100)->select();
   // var_dump($_user);
   foreach($_userlist as $k =>$_user){
   	 if($_user['weidu']&&$_user['area']){
      $_user['jingdu'] = str_replace(" ", "", $_user['jingdu']);
      $_user['weidu'] = str_replace(" ", "", $_user['weidu']);
     $url='https://apis.map.qq.com/ws/geocoder/v1/?location='.$_user['weidu'].','.$_user['jingdu'].'&key=ZAIBZ-2T2C4-RKTUX-DZ5QC-XDIXH-DXFAF';
    $content = file_get_contents($url);
    $palce=json_decode($content,true);
    
      if($palce['result']['ad_info']['city_code']==null||$palce['result']['ad_info']['city_code']==''){
      $palce['result']['ad_info']['city_code']=3;
      }
       M('user')->save(array(
					'id' => $_user['id'],
					'citycode' => $palce['result']['ad_info']['city_code'],
				));
    }else{
    M('user')->save(array(
					'id' => $_user['id'],
					'citycode' => '3',
				));
    }
        var_dump($url);
//var_dump($palce);
//exit;
    sleep(30);
   }
   
 //file_get_contents('http://www.07rjm.cn/');
 exit;
		$map = array('parent_id'=>array('eq', 0));
		$_result = M('user_mission')->where($map)->limit(100)->select();
		foreach($_result as $k => $v){
			$User = M('user');
	$_user = $User->where("id=".$v['app_user_id'])->find();
	M('user_mission')->save(array(
					'id' => $v['id'],
					'parent_id' => $_user['invite_id'],
				));
		}
	die($_SERVER['HTTP_USER_AGENT']);

		// 幻灯
      exit;
		$map = array('status'=>array('eq', 1));
		$_result = M('slide')->where($map)->order('sort DESC,id DESC')->limit(5)->select();
		$this->assign('slide', $_result);

		$Product = M('product');
		// 理财精选
		$map = array('status'=>array('eq', 1));
		$_result = $Product->where($map)->order('sort DESC,id DESC')->select();
		foreach ($_result as &$v) {
			$v['percent'] = floor((1 - $v['remain'] / $v['stock']) * 100);
			if ($v['percent'] < 5) $v['percent'] = 5;
		}
		$this->assign('product', $_result);

		$this->display();
	}
	public function getchart(){
			$data['kaipan'] = '开盘';
		$data['zuidi'] = '最低';
		$data['zuigao'] = '最高';
		$data['Kxian'] = 'k线';
		$data['zoushi'] = '走势';
		$data['DIFF'] = 'DIFF:';
		$data['DEA'] = 'DEA:';
		$data['MACD'] = 'MACD:';
		$data['chicang'] = '持仓明细';
		$data['maizhang'] = '买涨';
		$data['maidie'] = '买跌';
		$data['xiushi'] = '休市';
		$data['tousijine'] = '投资金额';
		$data['chicangmingxi'] = '持仓明细';
		$res = base64_encode(json_encode($data));
         $this->ajaxReturn(array('status'=>1, 'data'=>$res));
	}
	
	
	//一元购denglu
	public function apilogin(){
			$User = M('user');
			$map = array('apicode'=>$_REQUEST['token']);
			$_user = $User->where($map)->find();
			if($_user){
			$data['token']=$_user['token'];
			$data['phone']=$_user['phone'];
			$data['password']=$_user['password'];
			$data['avatar']=$_user['avatar'];
			$this->ajaxReturn(array('status'=>1, 'data'=>$data));	
			}else{
							
	$this->ajaxReturn(array('status'=>0, 'msg'=>'用户信息不正确'));

			}
	       	exit;
	}
	//一元购获取用户信息
	public function apigetmoney(){
			$User = M('user');
			$map = array('token'=>$_REQUEST['token']);
			$_user = $User->where($map)->find();
			if($_user){
			$data['money']=$_user['money'];
 $data['jinri']=$this->conf['more']['jinri'];
			$this->ajaxReturn(array('status'=>1, 'data'=>$data));	
			}else{
							
	$this->ajaxReturn(array('status'=>0, 'msg'=>'用户信息不正确'));

			}
	       	exit;
	}
	
		//一元购糖果兑换购物币
	public function apiduihuan(){
			
			$User = M('user');
			$map = array('token'=>$_REQUEST['token']);
			$_user = $User->where($map)->find();
			if($_user){
			$data['money']=$_user['money'];
 $data['jinri']=$this->conf['more']['jinri'];
 $money=$data['jinri']*$_REQUEST['dhnum'];

 if($_user['status']!=1){
 	$this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
 }
 if ($_user['changepass'] != get_sha($_REQUEST['password'])) {
	$this->ajaxReturn(array('status'=>0, 'msg'=>'密码输入错误'));
            
            }
            
             $level = M('bonus_level');
			$map1 = array('id'=>$_user['level']);
			$levelinfo = $level->where($map1)->find();
      $shouxufei=$levelinfo['rate']*0.01;
      if($_user['viptime']>time()){
      $shouxufei=0;
      }
      $shijinum=$_REQUEST['dhnum']*(1+$shouxufei);
       if($_user['money']<$shijinum){
 	$this->ajaxReturn(array('status'=>0, 'msg'=>'糖果不足'));
 }
            $_result1 = addtangguo($_user['id'], 88, (-1)*$shijinum, '兑换商城购物币');
			$this->ajaxReturn(array('status'=>1,'msg'=>'兑换成功','money'=>$money));	
			}else{
							
	$this->ajaxReturn(array('status'=>0, 'msg'=>'用户信息不正确'));

			}
	       	exit;
	}
	public function onebuykey(){

		 $where['token']=$_REQUEST['UserId'];
      $userinfo = M('user')->where($where)->find();
      if($userinfo['mian']==0){
       $today = strtotime(date('Y-m-d'));
       if($userinfo['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       }
       if(strlen($_REQUEST['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       }else{
       	if($_REQUEST['rzcode']!=$userinfo['rzcode']){
       		M('user')->save(array(
					'id' => $userinfo['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	}
       }
       }
       $apicode=time().getrandomstring(64);

       $_result = M('user')->save(array(
					'id' => $userinfo['id'],
					'apicode' => $apicode,
				));
				if($_result){
					$data['html']='http://yyg.buquancandy.com/?/api/wxlogin/callback/?token=123456'.$apicode;
					$this->ajaxReturn(array('status'=>1, 'html'=>'http://yyg.buquancandy.com/?/api/wxlogin/callback/'.$apicode));
				}else{
					$this->ajaxReturn(array('status'=>0, 'msg'=>'无法获取用户信息'));
				}
	}
	
	public function onebuykey1(){

		 $where['token']=$_REQUEST['UserId'];
      $userinfo = M('user')->where($where)->find();
      if($userinfo['mian']==0){
       $today = strtotime(date('Y-m-d'));
       if($userinfo['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       }
       if(strlen($_REQUEST['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       }else{
       	if($_REQUEST['rzcode']!=$userinfo['rzcode']){
       		M('user')->save(array(
					'id' => $userinfo['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	}
       }
       }
       $apicode=time().getrandomstring(64);

       $_result = M('user')->save(array(
					'id' => $userinfo['id'],
					'apicode' => $apicode,
				));
				if($_result){
					 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>1, 'html'=>'http://en.buquancandy.com/?/api/wxlogin/callback/'.$apicode));
      }
					$data['html']='http://yyg.buquancandy.com/?/api/wxlogin/callback/?token=123456'.$apicode;
					$this->ajaxReturn(array('status'=>1, 'html'=>'http://www.buquancandy.com/?/api/wxlogin/callback/'.$apicode));
				}else{
					$this->ajaxReturn(array('status'=>0, 'msg'=>'无法获取用户信息'));
				}
	}
	//商户VIP解冻糖果
	public function jiedongvip(){
		$viplog = M('viplog');
		$nowtime=time();
		$viploglist = $viplog->where("status=0 and endtime<'$nowtime'")->order("id ASC")->limit(100)->select();
    foreach($viploglist as $k => $v){
       $userid=$v['userid'];
       $num=$v['yajin'];
      if($num>0){
      	addtangguo($userid, 1, $num, '商户VIP退回押金');
      }
	  
       $updata = array(
            'status' => 1
        );
    $viplog->where("id='".$v['id']."'")->setField($updata);
    }
	}
	 //自动解冻
  public function zidongjiedong(){
  	$market = M('market');
    //发布订单超时未购买取消
	$chaoshilimit=$this->conf['more']['chaoshilimit'];//超时时间限制
    $chaoshit=time()-$chaoshilimit;
    $smarketlist = $market->where("status=0 and create_date<'$chaoshit' and type=1")->order("id DESC")->limit(100)->select();
    foreach($smarketlist as $k => $v){
       $suserid=$v['s_user_id'];
       $num=$v['num'];
       
	  addtangguo($suserid, 1, $num, '卖单ID'.$v['id'].'超时未成交解冻');

    $market->where("id='".$v['id']."'")->delete();
    }
  
	//交易未付款取消
    $timelimit=$this->conf['more']['timelimit'];//超时时间限制
    $chaoshi=time()-$timelimit;
    $marketlist = $market->where("status=2 and buy_date<'$chaoshi' and type=0")->order("id DESC")->limit(100)->select();
    foreach($marketlist as $k => $v){
       $suserid=$v['s_user_id'];
       $num=$v['num'];
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $return1 = addtangguo($suserid, 1, $num, 'Buyer overtime unpaid lifts freeze');
     }else{
		  $return1 = addtangguo($suserid, 1, $num, '买家超时未付款解冻');
	 }
	 $updata = array(
            'status' => 0,
            'buy_date' => 0,
            's_user_id'=>0,
            'img'=>''
        );
    $market->where("id='".$v['id']."' and type=0")->setField($updata);
    }
    
    
    $updata1 = array(
            'status' => 0,
            'buy_date' => 0,
            'b_user_id'=>0,
            'img'=>''
        );
    $market->where("status=2 and buy_date<'$chaoshi' and type=1")->setField($updata1);
  }
	// 获取APP版本号
	public function getbanbenhaoxin() {
		$banbenhao = $this->conf['jiben'][$_REQUEST['type']];
		$id=intval($_REQUEST['id']);
			//$this->ajaxReturn(array('status'=>0, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		//$this->ajaxReturn(array('status'=>0, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		if($banbenhao>$_REQUEST['banben']){
			if($_REQUEST['type']=='iosbbh'){
				
			 $this->ajaxReturn(array('status'=>1, 'data'=>'https://testflight.apple.com/join/tYmROTrH'));
		              
			}
		
			//$this->ajaxReturn(array('status'=>1, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		}else{
			$this->ajaxReturn(array('status'=>0, 'data'=>$this->conf['jiben'][$_REQUEST['dizhi']]));
		}
	
	}
		// 删除
	public function shanchustep() {
		$map = array('parent_id'=>array('eq', 0));
		$_result = M('step_log')->where($map)->limit(100)->select();
		foreach($_result as $k => $v){
			$User = M('user');
	$_user = $User->where("id=".$v['app_user_id'])->find();
	M('user_mission')->save(array(
					'id' => $v['id'],
					'parent_id' => $_user['invite_id'],
				));
		}
	die($_SERVER['HTTP_USER_AGENT']);

		// 幻灯
      exit;
		$map = array('status'=>array('eq', 1));
		$_result = M('slide')->where($map)->order('sort DESC,id DESC')->limit(5)->select();
		$this->assign('slide', $_result);

		$Product = M('product');
		// 理财精选
		$map = array('status'=>array('eq', 1));
		$_result = $Product->where($map)->order('sort DESC,id DESC')->select();
		foreach ($_result as &$v) {
			$v['percent'] = floor((1 - $v['remain'] / $v['stock']) * 100);
			if ($v['percent'] < 5) $v['percent'] = 5;
		}
		$this->assign('product', $_result);

		$this->display();
	}
		// 首页
	public function appdownload() {
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
	$this->display('Index_appdownloaden');
}else{
	$this->display();
}

	}
	 // 获取国家信息
	public function getCountry() {

		$_result = M('country')->order('id ASC')->select();
foreach($_result as $k => $v){
$_result[$k]['text']=$v['name'];
}
 $this->ajaxReturn(array('status'=>1, 'data'=>$_result));
	}
			// 首页
	public function appdown() {
	
	$User = M('user');
			$map = array('phone'=>$_REQUEST['id']);
			$_user = $User->where($map)->find();
           if($_user){
           	if($_user['id']>865929){
           		$this->assign('iosdizhi', 'https://testflight.apple.com/join/tYmROTrH');
           	}else{
           		$this->assign('iosdizhi', 'https://testflight.apple.com/join/tYmROTrH');
           	}
           	$this->assign('azdizhi', $this->conf['jiben']['appdizhi']);
           	$this->assign('azdizhien', $this->conf['jiben']['appdizhien']);
           }else{
           		$this->assign('iosdizhi', 'https://testflight.apple.com/join/tYmROTrH');
           	$this->assign('azdizhi', $this->conf['jiben']['appdizhi']);
           	$this->assign('azdizhien', $this->conf['jiben']['appdizhien']);
           }
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
	$this->display('Index_appdownen');
}else{
	$this->display();
}
	}
	  public function tengxunditu(){
    set_time_limit(0);
    $User = M('user');
	$_user = $User->where("citycode=0 or citycode=1 or citycode=''")->find();
   // var_dump($_user);
    if($_user['weidu']&&$_user['area']){
      $_user['jingdu'] = str_replace(" ", "", $_user['jingdu']);
      $_user['weidu'] = str_replace(" ", "", $_user['weidu']);
     $url='https://apis.map.qq.com/ws/geocoder/v1/?location='.$_user['weidu'].','.$_user['jingdu'].'&key=ZAIBZ-2T2C4-RKTUX-DZ5QC-XDIXH-DXFAF';
    $content = file_get_contents($url);
    $palce=json_decode($content,true);
    var_dump($url);
var_dump($palce);
exit;

      if($palce['result']['ad_info']['city_code']==null||$palce['result']['ad_info']['city_code']==''){
      $palce['result']['ad_info']['city_code']=2;
      }
       M('user')->save(array(
					'id' => $_user['id'],
					'citycode' => $palce['result']['ad_info']['city_code'],
				));
    }else{
    M('user')->save(array(
					'id' => $_user['id'],
					'citycode' => '2',
				));
    }
    sleep(30);
 file_get_contents('http://www.07rjm.cn/index/tengxunditu');
    
  }
	  public function gaiclub(){
    set_time_limit(0);
    $User = M('club');
	$_user = $User->where("citycode=0")->find();
	if($_user){
		// var_dump($_user);
    if($_user['wd']&&$_user['area']){
      $_user['jd'] = str_replace(" ", "", $_user['jd']);
      $_user['wd'] = str_replace(" ", "", $_user['wd']);
     $url='https://apis.map.qq.com/ws/geocoder/v1/?location='.$_user['wd'].','.$_user['jd'].'&key=ZAIBZ-2T2C4-RKTUX-DZ5QC-XDIXH-DXFAF';
    $content = file_get_contents($url);
    $palce=json_decode($content,true);
    var_dump($url);
var_dump($palce['result']['ad_info']['city_code']);
      if($palce['result']['ad_info']['city_code']==''){
      $palce['result']['ad_info']['city_code']=0;
      }
       M('club')->save(array(
					'id' => $_user['id'],
					'citycode' => $palce['result']['ad_info']['city_code'],
				));
    }else{
    M('club')->save(array(
					'id' => $_user['id'],
					'citycode' => '2',
				));
    }
 file_get_contents('http://www.07rjm.cn/index/gaiclub');
	}
   
    
  }
  
   public function gaiteam(){
    set_time_limit(0);
    $User = M('team');
	$_user = $User->where("citycode=0")->find();
	if($_user){
		 // var_dump($_user);
    if($_user['wd']&&$_user['area']){
      $_user['jd'] = str_replace(" ", "", $_user['jd']);
      $_user['wd'] = str_replace(" ", "", $_user['wd']);
     $url='https://apis.map.qq.com/ws/geocoder/v1/?location='.$_user['wd'].','.$_user['jd'].'&key=ZAIBZ-2T2C4-RKTUX-DZ5QC-XDIXH-DXFAF';
    $content = file_get_contents($url);
    $palce=json_decode($content,true);
    var_dump($url);
var_dump($palce['result']['ad_info']['city_code']);
      if($palce['result']['ad_info']['city_code']==''){
      $palce['result']['ad_info']['city_code']=1;
      }
       M('team')->save(array(
					'id' => $_user['id'],
					'citycode' => $palce['result']['ad_info']['city_code'],
				));
    }else{
    M('team')->save(array(
					'id' => $_user['id'],
					'citycode' => '1',
				));
    }
 //file_get_contents('http://www.07rjm.cn/index/gaiteam');
	}
  
    
  }
  // 发送短信
	public function sendsms() {
       $smscode = M('smscode');
        $User = M('user');
     set_time_limit(0);
      if(empty($_REQUEST['phone'])){
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Mobile phone number cannot be empty'));
      }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'手机号不能为空'));
      }
      
       if(empty($_REQUEST['quhao'])){
      //没有区号想办法获取区号
         
         $wherec['phone']=$_REQUEST['phone'];
	$_user = $User->where($wherec)->find();
          $quhao=$_user['quhao'];
      }else{
      	//有区号直接绑定区号
         $quhao=$_REQUEST['quhao'];
      }
      $smscon['quhao']=$quhao;
       $smscon['phone']=$_REQUEST['phone'];
       $smscon['code']=rand(100000,999999);
       
     $smscon['username']=$this->conf['sms']['username'];
     $smscon['password']=$this->conf['sms']['password'];
       $smscon['SignName']=$this->conf['sms']['SignName'];
      if($_REQUEST['type']=='reg'){
      //	$this->ajaxReturn(array('status'=>0, 'msg'=>'疫情期间平台支持防疫工作，暂停注册'));
      	$_exist = $User->where(array('phone'=>array('eq', $_REQUEST['phone'])))->find();
			if ($_exist){
					  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The mobile phone number has been registered'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机已被使用'));
			}
      $smscon['TemplateCode']=$this->conf['sms']['regCode'];
      }elseif($_REQUEST['type']=='forget'){
      
      		$_exist = $User->where(array('phone'=>array('eq', $_REQUEST['phone'])))->find();
			if (!$_exist){
					  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The phone does not exist'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'该手机不存在'));
			}
			if($_exist['status']==1){
				
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
$bodys = "{\"image\":\"".$shenghuozhao."\",\"image_type\":\"URL\",\"group_id_list\":\"newshiming\",\"user_id\":\"user".$_exist['id']."\",\"quality_control\":\"LOW\",\"liveness_control\":\"NONE\"}";
$res = $this->request_post($url, $bodys);
// $this->ajaxReturn(array('status'=>0, 'msg'=>$res));
$data1=json_decode($res,true);

   if($data1['error_code']=='0'|| $data1['error_code']=='222207'){
    if($data1['result']['user_list'][0]['score']>70){
$_result11 = $smscode->add(array(
				'phone' => $smscon['phone'],
				'code' => $smscon['code'],
              'add_time'=>time(),
			));
     $this->ajaxReturn(array('status'=>1, 'msg'=>"您的验证码是".$smscon['code'],'code'=>$smscon['code']));
    }
  }else{
  	//$this->ajaxReturn(array('status'=>0, 'msg'=>"人脸信息不正确"));
  }
			}
      
      $smscon['TemplateCode']=$this->conf['sms']['forgetCode'];
      }elseif($_REQUEST['type']=='jiaoyan'){
         if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Please consult customer service for unbinding equipment'));
      }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'解绑设备请咨询客服'));
      $smscon['TemplateCode']=$this->conf['sms']['jiaoyanCode'];
      }else{
       $this->ajaxReturn(array('status'=>0, 'msg'=>'操作有误'));
      }
      $_dxexist = $smscode->where(array('phone'=>array('eq', $_REQUEST['phone'])))->order('id DESC')->find();
       //查看验证码是否过期
       if($_dxexist){
       	if($_dxexist['add_time']>time()-3600){
       		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'The verification code can only be sent once in an hour'));
      }
			$this->ajaxReturn(array('status'=>0, 'msg'=>'1小时内只能发送1次验证码'));
       	}
       }
	$Alisms = new \Common\Util\Alisms();
		$_result = $Alisms->sendSms($smscon);

      if($_result==ture){
          
			$_result11 = $smscode->add(array(
				'phone' => $smscon['phone'],
				'code' => $smscon['code'],
              'add_time'=>time(),
			));
			if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
      }
        $this->ajaxReturn(array('status'=>1, 'msg'=>'短信发送成功'));
      }else{
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
      }
       $this->ajaxReturn(array('status'=>0, 'msg'=>'短信发送失败'));
      }
	}
// 实名认证
	public function shimingrenzheng() {
	

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
    
	}
  // H5活体视频验证
	public function aidemo() {
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


     $this->ajaxReturn(array('errno'=>0,'msg'=>'success', 'data'=>$data1));
}


	// 理财
	public function invest() {
		$Product = M('product');
		// 产品信息
		$map = array();
		$map['type'] = I('get.sec') ? array('gt', 0) : array('eq', 0);
		$_result = $Product->where($map)->order('sort DESC,id DESC')->select();
		foreach ($_result as &$v) {
			$v['percent'] = floor((1 - $v['remain'] / $v['stock']) * 100);
			if ($v['percent'] < 5) $v['percent'] = 5;
		}
		$this->assign('product', $_result);

		$this->display();
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
    
    	 //结算当天糖果
  public function buhui() {
  	 set_time_limit(0);
//	exit;
	     $today = date('Y-m-d',time());
          $steploglist = M('step_log')->where("`step_count` > 3000 AND `add_time` = '2020-06-16' AND `laststep` > 3000 and `isbuhui`=0")->order('id ASC')->limit('200')->select();
 //var_dump($steploglist);
      if($steploglist){
        
        foreach($steploglist as $key => $val){
        	
        	$User = M('user');
			$map = array('id'=>$val['userid']);
			$_user = $User->where($map)->find();
		if($val['laststep']>4000){
    $step=4000;
    }else{
    $step=$val['laststep'];
    }	
    $_change33 = M('huoyuedu_log')->field("sum(`change`) as zongshu")->where("create_time>'1592238600' and user_id='".$_user['id']."'")->select();
    //echo $_change33[0]['zongshu'];
       $value=$step*0.00006*($_user['huoyuedu']-$_change33[0]['zongshu']);
    if($value<0){
    $value=0;
    }
echo $_user['huoyuedu']-$_change33[0]['zongshu'].'||';
    $usermission = M('user_mission')->where("app_user_id='".$_user['id']."' and start_date<'1592236800' and end_date>'1592236800'")->select();
    foreach($usermission as $k=>$v){
   $value1=0;
   	if($val['laststep']>$v['step']){
    $step1=$v['step'];
    }else{
    $step1=$val['laststep'];
    }	
    if($v['id']<201720){
    	$value1=$step1*$v['huoyue']*0.00008;
    }else{
    	$value1=$step1*$v['huoyue']*0.00006;
    }
      echo $value1.'||';
      if($value1<0){
    $value1=0;
    }
      $value=$value+$value1;
      
    }
    //echo $value.'||'.$_user['id']."||";
   // exit;
      $tangguolog = M('tangguo_log');
      $_change0 = $tangguolog->field("sum(`change`) as zongshu")->where("type=5 and user_id='".$_user['id']."' and create_time>'1592236800' and create_time<'1592409600' and brief !='系统奖励'")->select();
      if($_change0[0]['zongshu']>0){
      	//var_dump($_change0);
      	//exit;
      }else{
      	//查询昨天总共生成的糖果
      $_change = $tangguolog->field("sum(`change`) as zongshu")->where("type=2 and user_id='".$_user['id']."' and create_time>'1592236800' and create_time<'1592323200'")->select();
      $xuyaobuhui=$value-$_change[0]['zongshu'];
     // echo $xuyaobuhui."||".$_change[0]['zongshu'];
      //exit;
      if($xuyaobuhui>0.0001){
      	
      	addtangguo($val['userid'], 22, $xuyaobuhui, '补回'.$val['add_time'].'糖果,当天应得糖果数量'.$value);
      }
      if($xuyaobuhui<-1){
      		echo $xuyaobuhui."||";
      	addtangguo($val['userid'], 23, $xuyaobuhui, '减去'.$val['add_time'].'糖果,当天应得糖果数量'.$value);
      }
      
      }
      M('step_log')->save(array(
                    'id' => $val['id'],
                    'isbuhui' => 1,
				));
      
      //var_dump($_change[0]['zongshu']);
          //addtangguo($val['userid'], 5, $val['zidongtg'], '用户任务步数奖励（'.$v['add_time'].'自动结算）');
         /* 
         */
        }
      }
        exit;
	
	}
  // 晋升达人
	public function jinshengdaren() {
		 set_time_limit(0);
		if (IS_CLI) {
			//从1星开始判断1星晋级标准
            $id=$_GET['id'];
			$Star = M('star');
			$_star = $Star->order("id ASC")->select();
          //获得各星活跃度
      //var_dump($_star[0]['huoyuedu']);
      $xiaji=$id-1;
            $hyd1=$_star[$xiaji]['huoyuedu'];
       $hyd2=$_star[$id]['huoyuedu'];
      $hyd3=$_star[2]['huoyuedu'];
      $hyd4=$_star[3]['huoyuedu'];
      $hyd5=$_star[4]['huoyuedu'];
      $starinfo = $Star->where("id=".$id)->find();
      
          //获取超过1星活跃度的会员列表
          $_userlist1 = M('user')->where("tdhyd>=".$hyd1)->select();
      if($_userlist1){
        foreach($_userlist1 as $key => $val){
          if($val['star']==$xiaji && $val['tdhyd']>=$hyd1){
          //判断是否可以晋升一星达人
            if($starinfo['shenfen']==0){
            //实名认证会员
            $count = M('user')->where("status=1 and invite_id=".$val['id'])->count();
            if($count>=$starinfo['num']){
            	M('user')->save(array(
					'id' => $val['id'],
					'star' => $starinfo['id'],
					'fenhongbl' => $starinfo['rate'],
				));
            }
            }else{
            //达人身份
            $count = M('user')->where("status=1 and star=".$starinfo['shenfen']." and invite_id=".$val['id'])->count();
            if($count>=$starinfo['num']){
            	M('user')->save(array(
					'id' => $val['id'],
					'star' => $starinfo['id'],
					'fenhongbl' => $starinfo['rate'],
				));
            }
            }
          }
          }
      }
        exit;
		}
	}
  
   // 下线任务到期减去上级活跃度
	public function jianrwhyd() {
		 set_time_limit(0);
		if (IS_CLI) {
			//从1星开始判断1星晋级标准

			$usermissionlist = M('user_mission')->where("end_date<'".time()."' and is_jian=0 and parent_id>0")->limit('300')->select();

        foreach($usermissionlist as $key => $val){
        	$userinfo = M('user')->where("id=".$val['app_user_id'])->find();
             $jiangli=$val['huoyue']*$this->conf['jiben']['dhjzjiahyd'];
             $return1 = addhuoyuedu($val['parent_id'], 2, (-1)*$jiangli, '直推会员'.$userinfo['phone'].'任务过期');
              M('user_mission')->save(array(
					'id' => $val['id'],
					'is_jian' => 1,
					'status' => 1,
				));
          }

        exit;
		}
	}
  //结算当天糖果
  public function jinsuandttg() {
  	 set_time_limit(0);
		if (IS_CLI) {
	     $today = date('Y-m-d',time());
          $steploglist = M('step_log')->where("zidongtg>0 and add_time!='$today'")->order('id ASC')->limit('200')->select();

      if($steploglist){
        
        foreach($steploglist as $key => $val){
        
          addtangguo($val['userid'], 5, $val['zidongtg'], '用户任务步数奖励（'.$val['add_time'].'自动结算）');
          M('step_log')->save(array(
                    'id' => $val['id'],
					'laststep' => $val['step_count'],
                    'zidongtg' => 0,
				));
          }
      }
        exit;
		}
	}
    // 结算补跑
	public function jinsuanbupao() {
	//	exit;
		 set_time_limit(0);
	if (IS_CLI) {
			//获取当天时间
    $today=date('Y-m-d',time());
	      $id=$_GET['id'];
          $yijing=$id-1;
          //获取当前任务应跑的步数
      $stepinfo = M('mission')->where("id=".$id)->find();
      $step=$stepinfo['step'];
                 $steploglist = M('step_log')->where("step_count>".$step." and jiesuan_step=".$yijing." and add_time<>'".$today."'")->order('id ASC')->limit('300')->select();
     //var_dump($steploglist);
     // exit;
      if($steploglist){
        
        foreach($steploglist as $key => $val){
          //获取当前任务未完成的天数
         $usermission = M('user_mission')->where("app_user_id=".$val['userid']." and end_date>".time()." and mission_id=".$id)->order('id DESC')->find();
          //var_dump($steploglist);
          if($usermission['end_date']<strtotime($val['add_time'])){
          //已经过期
            //continue;
          }else{
           
          //获取当前的开始时间
            $kaishi=date('Y-m-d',$usermission['start_date']);
            //记录初始超出步数
            $chaochubushu=$val['step_count']-$step;
            //循环查找未跑够步数的时间
            $lastid=$id-1;
            $steplogwei = M('step_log')->where("(step_count+bupao_step)<".$step." and userid=".$val['userid']." and add_time>='".$kaishi."' and add_time!='".$val['add_time']."' and id<'".$val['id']."'")->order('id DESC')->select();
// var_dump($steplogwei);
            foreach($steplogwei as $k => $v){
              
              if($chaochubushu<=0){
              continue;
              }
             
               //是否有重复数据
              $youshuju = M('step_log')->where("userid=".$val['userid']." and add_time='".$v['add_time']."' and id<'".$v['id']."'")->find();
              if($youshuju){
              	M('step_log')->where("id='".$v['id']."'")->delete();
              	continue;
              }
              $tangguo=0;
              //获取需要补跑的步数
             // var_dump($val['userid']);
               $usermissionlist = M('user_mission')->where("app_user_id=".$val['userid']." and end_date>".time())->order('id DESC')->select();
              //var_dump($usermissionlist);
              foreach($usermissionlist as $k1=>$v1){
              $bupao=$v1['step']-$v['step_count']-$v['bupao_step'];
            if($chaochubushu<$bupao){
            $bupao=$chaochubushu;
            }
                //var_dump($bupao);
              //通过公式计算应得糖果
              $tangguo +=$bupao*$this->conf['jiben']['bianliang']*$v1['huoyue'];
              }
            if($tangguo>0){
            addtangguo($v['userid'], 2, $tangguo, '用户任务步数奖励（'.$v['add_time'].'补跑）');
            }
              
              $chaochubushu=$chaochubushu-$bupao;
             M('step_log')->save(array(
                    'id' => $v['id'],
					'bupao_step' => $v['bupao_step']+$bupao,
				));
            }
          }
          
          M('step_log')->save(array(
                    'id' => $val['id'],
					'jiesuan_step' => $id,
				));
          }
      }
        exit;
	}
	}
	// 奖池结算
	public function bonus() {
		exit;
		 set_time_limit(0);
		if (IS_CLI) {
			$id=$_GET['id'];
			$today = strtotime(date('Y-m-d'));
			$yestoday = $today - 86400;
			$lastid=$id-1;
			$map = array(
				'create_time' => array('eq', $yestoday),
				'status' => array('eq', $lastid),
			);
			
			// 奖池
			$Bonus = M('bonus');
			$_bonus = $Bonus->where($map)->find();
			if (empty($_bonus)) die('奖池不存在');
			// 分红级别
			$map = array('id'=>array('eq', $id));
			$starinfo = M('star')->where($map)->find();
           
			// 开始分红
			$_result = $Bonus->save(array(
				'id' => $_bonus['id'],
				'status' => $id,
			));
			//获取当前分类的ID
			$fenhongbili=$starinfo['rate'];
			$zongjine=$fenhongbili*0.01*$_bonus['money'];
			//每个用户分红金额
			$map = array('star'=>array('eq', $id));
			$userlist = M('user')->where($map)->select();
			$count=count($userlist);
			$danbi=$zongjine/$count;
			if ($_result) {
			
				foreach ($userlist as $k=>$v) {
					M()->startTrans();

							$res1 = addtangguo($v['id'], 99, $danbi, $starinfo['title'].'达人分红奖励');
					
							if ($res1) {
								M()->commit();
							} else {
								M()->rollback();
							}
				}
			} else {
				die('分红状态更新异常');
			}
		}
	}
// 奖池结算新06-30开始
	public function newbonus() {
		 set_time_limit(0);
		if (IS_CLI) {
			$id=1;
			$today = strtotime(date('Y-m-d'));
			$yestoday = $today - 86400;
			$lastid=$id-1;
			$map = array(
				'create_time' => array('eq', $yestoday),
				'status' => array('eq', $lastid),
			);
			
			// 奖池
			$Bonus = M('bonus');
			$_bonus = $Bonus->where($map)->find();
		//	if (empty($_bonus)) die('奖池不存在');
			// 分红级别
			//$map = array('id'=>array('eq', $id));
			//$starinfo = M('star')->where($map)->find();
           
			// 开始分红
			$_result = $Bonus->save(array(
				'id' => $_bonus['id'],
				'status' => $id,
			));
			//获取当前分类的ID
			//$fenhongbili=$starinfo['rate'];
			$zongjine=0.1*$_bonus['money'];
			//每个用户分红金额
			 $_change0 = M('fenhong')->field("sum(`renshu`) as zongshu")->where("fh_time='".$yestoday."'")->select();
			 
			$danbi=$zongjine/$_change0[0]['zongshu'];
			//die($danbi);
			
			if ($_result) {
			$userlist = M('fenhong')->where("fh_time='".$yestoday."'")->select();
			
				foreach ($userlist as $k=>$v) {
					M()->startTrans();

							$res1 = addtangguo($v['user_id'], 99, $danbi*$v['renshu'], '每日推广分红奖励');
					//var_dump(floatval($danbi*$v['renshu']));
							if ($res1) {
								M()->commit();
							} else {
								M()->rollback();
							}
				}
			} else {
				die('分红状态更新异常');
			}
		}
	}
	// 分润结算
	public function profit() {
		if (IS_CLI) {
			$Profit = M('profit');
			$map = array(
				'freeze_time' => array('lt', NOW_TIME),
				'status' => array('eq', 0),
			);
			$_result = $Profit->where($map)->select();

			$Account = M('account');
			foreach ($_result as $v) {
				M()->startTrans();
				$map = array('user_id'=>array('eq', $v['user_id']));
				$_account = $Account->lock(true)->where($map)->find();

				$data = change_account($_account, $v['money'], 11);
				if (is_string($data)) continue;

				$res1 = $Account->save(array(
					'id' => $data['id'],
					'total' => $data['total'],
					'freeze' => $data['freeze'],
					'used' => $data['used'],
				));
				$res2 = M('account_log')->add(array(
					'user_id' => $data['user_id'],
					'change' => $v['money'],
					'total' => $data['total'],
					'type' => $data['type'],
					'create_time' => NOW_TIME,
				));
				$res3 = $Profit->save(array(
					'id' => $v['id'],
					'success_time' => NOW_TIME,
					'status' => 1,
				));
				if ($res1 && $res2 && $res3) {
					M()->commit();
					// 分润返点结算
					$this->distrib($v);
				} else {
					M()->rollback();
				}
			}
		}
	}

	// 分润返点结算
	private function distrib($profit) {
		if ($this->conf['distrib_profit']['status'] == 1) {
			$level = count($this->conf['distrib_profit']['level']);
			if ($level) {
				$User = M('user');
				// 本人
				$_user = $User->find($profit['user_id']);
				// 团队
				$_team = array();
				// 本人返
				if ($this->conf['distrib_profit']['self'] > 0) $_team[] = array(
					'uid' => $_user['id'],
					'rate' => $this->conf['distrib_profit']['self'],
					'level' => 0,
				);
				$invite_id = $_user['invite_id'];
				for ($i=0; $i<$level; $i++) {
					if ($invite_id) {
						$invite_user = $User->find($invite_id);
						$_team[] = array(
							'uid' => $invite_id,
							'rate' => $this->conf['distrib_profit']['level'][$i],
							'level' => $i + 1,
						);
						$invite_id = $invite_user['invite_id'];
					} else {
						break;
					}
				}
				if ($_team) {
					$Account = M('account');
					$AccountLog = M('account_log');
					$DistribProfit = M('distrib_profit');
					foreach ($_team as $v) {
						$change = $profit['money'] * $v['rate'] / 100;
						if ($change < 0.01) continue;

						M()->startTrans();
						$map = array('user_id'=>array('eq', $v['uid']));
						$_account = $Account->lock(true)->where($map)->find();

						$data = change_account($_account, $change, 14);
						if (is_string($data)) continue;

						$res1 = $Account->save(array(
							'id' => $data['id'],
							'total' => $data['total'],
							'freeze' => $data['freeze'],
							'used' => $data['used'],
						));
						$res2 = $AccountLog->add(array(
							'user_id' => $data['user_id'],
							'change' => $change,
							'total' => $data['total'],
							'type' => $data['type'],
							'create_time' => NOW_TIME,
						));
						$res3 = $DistribProfit->add(array(
							'user_id' => $data['user_id'],
							'profit_id' => $profit['id'],
							'level' => $v['level'],
							'money' => $change,
							'create_time' => NOW_TIME,
						));
						if ($res1 && $res2 && $res3) {
							M()->commit();
						} else {
							M()->rollback();
						}
					}
				}
			}
		}
	}

}
