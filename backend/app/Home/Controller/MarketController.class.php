<?php
namespace Home\Controller;
use Think\Controller;
class MarketController extends CommonController {

	// 初始化
	protected function _initialize() {
		// 继承父级初始化
		parent::_initialize();
		// 开启session
		session_start();
		
	}
       //获取交易大厅设置
  public function getMarketConfig(){
  if (IS_POST) {
    $market = M('market');
    
			$marketinfo = $market->order("id DESC")->find();
    $data['b'] = $market->where("status=1 and type=0")->sum('num');
     $data['s'] = $market->where("status=1 and type=1")->sum('num');
     $data['b']=ceil($data['b']);
     $data['s']=ceil($data['s']);
     $updata1 = array(
            'status' => 3
        );
    $market->where("status=2 and pay_date>0")->setField($updata1);
  
     $data['day_now']=$this->conf['more']['jinri'];
    $data['min']=$this->conf['more']['min'];
    $data['max']=$this->conf['more']['max'];
    $data['jinri']=$this->conf['more']['jinri'];
        $data['day_min']=$this->conf['more']['min'];
    $data['day_max']=$this->conf['more']['max'];
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
    //获取当前订单信息
  public function getmarketinfo(){
  if (IS_POST) {
     $market = M('market');
    $post = $_REQUEST;
      $map2 = array('id'=>$post['id']);
			$marketinfo = $market->where($map2)->find();
    if($marketinfo['status']>0){
    $this->ajaxReturn(array('status'=>0, 'msg'=>'当前订单不存在'));
       	exit;
    }
    //查看卖家所在的国家银行信息
    $map3 = array('id'=>$marketinfo['s_user_id']);
       $_user = M('user')->where($map3)->find();
    
    $map4 = array('id'=>$_user['countryid']);
       $_country = M('country')->where($map4)->find();
       	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $html='You need to pay '.($_country['huilv']*$marketinfo['price']*$marketinfo['shijinum']).$_country['fuhao'];
      }else{
      	$html='你需要付款'.($_country['huilv']*$marketinfo['price']*$marketinfo['shijinum']).$_country['fuhao'];
      }
    
    
    $map5 = array('userid'=>$_user['id']);
       $usercountrylist = M('usercountry')->where($map5)->select();
    foreach($usercountrylist as $key => $val){
    	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $html .=' or '.($val['huilv']*$marketinfo['price']*$marketinfo['shijinum']).$val['fuhao'];
      }else{
      $html .='或者'.($val['huilv']*$marketinfo['price']*$marketinfo['shijinum']).$val['fuhao'];
      }
    
    }
    $data['miaoshu']=$html;
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
		}
  }
  // 添加国家
	public function savecountryyh() {
       $post = $_REQUEST;
      $map2 = array('id'=>$post['appUserId']);
       $_user = M('user')->where($map2)->find();
       //人脸识别校验
       if($_user['mian']==0){
       	$today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       	}
       }
       }
      if(empty($post['realname'])){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写姓名'));
      }
      if(empty($post['bankName'])){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写银行名称'));
      }
      if(empty($post['bankNo'])){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写银行账号'));
      }
      if(empty($post['changePass'])){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写交换密码'));
      }
      if(empty($_user['changepass'])){
			 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Please set the exchange password first'));
      }
			 $this->ajaxReturn(array('status'=>0, 'msg'=>'请先设置交换密码'));
			}
      if ($_user['changepass'] != get_sha($_REQUEST['changePass'])) {
            if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
       $this->ajaxReturn(array('status'=>0, 'msg'=>'Incorrect password'));
      }
             $this->ajaxReturn(array('status'=>0, 'msg'=>'密码输入错误'));
      }
       //人脸识别校验
      if($post['type']=='save'){
        $map1 = array('userid'=>$post['appUserId'],'countryid'=>$post['countryid']);
			$usercountry = M('usercountry')->where($map1)->find();
      if($usercountry){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的账户已经开通当前国家交易'));
      }else{
      	$map3 = array('id'=>$post['countryid']);
			$country = M('country')->where($map3)->find();
        if($country['yajin']>$_user['money']){
        $this->ajaxReturn(array('status'=>0, 'msg'=>'您的糖果不足以支付押金'));
        }
         
          	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  addtangguo($_user['id'], 88, (-1)*$country['yajin'], 'Opening Multi Country transaction to pay deposit');
	  }else{
		   addtangguo($_user['id'], 88, (-1)*$country['yajin'], '开通多国交易支付押金');
	  }
       
      $data = array();
        $data['countryid'] =$country['id'];
			$data['name'] =$country['name'];
			$data['cover'] = $country['cover'];
			$data['quhao'] = $country['quhao'];
			$data['huilv'] = $country['huilv'];
			$data['fuhao'] = $country['fuhao'];
            $data['yajin'] = $country['yajin'];
			$data['userid'] = $post['appUserId'];
            $data['realname'] = $post['realname'];
            $data['bankname'] = $post['bankName'];
            $data['bankno'] = $post['bankNo'];
        $data['add_time'] = time();
			$_result = M('usercountry')->add($data);
        $this->ajaxReturn(array('status'=>1, 'msg'=>'添加成功'));
      }
      }else{
        $map1 = array('userid'=>$post['appUserId'],'countryid'=>$post['countryid']);
			$usercountry = M('usercountry')->where($map1)->find();
      if(!$usercountry){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的账户还没有开通当前国家的交易'));
      }else{
    
       
      $data = array();
        $data['id'] =$usercountry['id'];
            $data['realname'] = $post['realname'];
            $data['bankname'] = $post['bankName'];
            $data['bankno'] = $post['bankNo'];
            
			$_result = M('usercountry')->save($data);
        $this->ajaxReturn(array('status'=>1, 'msg'=>'修改成功'));
      }
      }
    

		
	}
       // 获取多国列表
	public function getmycountry() {
            $post = $_REQUEST;
      $shuzu=array();
			$map1 = array('userid'=>$_REQUEST['UserId']);
			$usercountry = M('usercountry')->where($map1)->order('id DESC')->select();
      foreach($usercountry as $key => $val){
      $shuzu[]=$val['countryid'];
      }
			$country = M('country');
			$map['status'] = 1;
      $map['id']  = array('neq',$_REQUEST['countryid']);
			$data = $country->where($map)->order('id ASC')->select();
      foreach($data as $k => $v){
        
      if(in_array($v['id'], $shuzu)){
         $data[$k]['yikaitong']=1;
        } else {
         $data[$k]['yikaitong']=0;
        }

      }
      
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
	  // 获取多国列表
	public function getcountry() {
   $country = M('country');
			$map['status'] = 1;
			$data = $country->where($map)->order('id ASC')->select();

		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
     // 获取当前国家银行信息
	public function getmyBank() {
            $post = $_REQUEST;
			$map1['userid'] =$post['UserId'];
            $map1['countryid'] =$post['countryid'];
			$usercountry = M('usercountry')->where($map1)->find();

		$this->ajaxReturn(array('status'=>1, 'data'=>$usercountry));
	}
  
     // 获取VIP信息
	public function getvip() {
           $this->ajaxReturn(array('status'=>0, 'msg'=>'超级VIP暂时关闭'));
			$viplist = M('cjvip')->select();

		$this->ajaxReturn(array('status'=>1, 'data'=>$viplist));
	}
  
  //* 开通商户VIP
	public function ktvip() {
		 $this->ajaxReturn(array('status'=>0, 'msg'=>'超级VIP暂时关闭'));
      $cjvip = M('cjvip');
      $post = $_REQUEST;
	  $map = array('id'=>$post['id']);
       $info = M('cjvip')->where($map)->find();
       if(!$info){
      	  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
       }
       $map1 = array('token'=>$post['userid']);
       $_user = M('user')->where($map1)->find();
       //人脸识别校验
       if($_user['mian']==0){
       	$today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       	}
       }
       }
       //人脸识别校验
      if($_user['money']<$info['yajin']){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>"You don't have enough candy."));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的糖果不足'));
      }
      if($_user['viptime']>time()){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>"Your VIP has not expired yet. Please open it after it expires"));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的VIP还没到期,请到期后再开通'));
      }
      
      $_result = M('viplog')->add(array(
				'userid' => $_user['id'],
              'yajin' => $info['yajin'],
              'name' => $info['name'],
              'endtime' => time()+86400*$info['day'],
              'status' => 0,
			));
      if($_result){
        
      M('user')->save(array(
					'id' => $_user['id'],
                    'viptime' => time()+86400*$info['day'],
				));
          	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  addtangguo($_user['id'], 77, (-1)*$info['yajin'], 'Open merchant VIP');
	  }else{
		   addtangguo($_user['id'], 77, (-1)*$info['yajin'], '开通商户VIP');
	  }
       $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
        
      }else{
      if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
      }
	}
       // 获取交易列表
	public function getPriceList() {
			$market = M('market');
			$map = array('status'=>1);
			$data = $market->where($map)->order('id DESC')->limit('50')->select();
      foreach($data as $k => $v){
      $data[$k]['date']=date('m-d H:i',$v['create_date']);
        $data[$k]['priceToday']=$v['price'];
      }
      
		$this->ajaxReturn(array('status'=>1, 'data'=>array_reverse($data)));
	}
    // 获取我的买入
	public function getMyBuyByType() {
			$market = M('market');
			$post = $_REQUEST;
			$map = array('type'=>0,'status'=>0,'b_user_id'=>$post['bUserId']);
			$data = $market->where($map)->order('id DESC')->select();
      foreach($data as $k => $v){
        $User = M('user');
			$map = array('id'=>$post['bUserId']);
			$_user = $User->where($map)->find();
      $data[$k]['bUserName']=substr_replace($_user['phone'],'****',3,4);
        $data[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
   // 获取我的卖出
	public function getMySellByType() {
			$market = M('market');
			$map = array('type'=>1,'status'=>0,'s_user_id'=>$_REQUEST['sUserId']);
			$data = $market->where($map)->order('id DESC')->select();
       foreach($data as $k => $v){
        $User = M('user');
			$map = array('id'=>$_REQUEST['sUserId']);
			$_user = $User->where($map)->find();
      $data[$k]['sUserName']=substr_replace($_user['phone'],'****',3,4);
        $data[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
  // 获取我正在交易的订单
	public function getMyMarketing() {
			$market = M('market');
			$post = $_REQUEST;
			$map = array('status'=>1,'s_user_id'=>$post['sUserId']);
			$data = $market->where('status>1 and (s_user_id='.$post['sUserId'].' or b_user_id='.$post['sUserId'].')')->order('id DESC')->limit('100')->select();
       foreach($data as $k => $v){
        $User = M('user');
			$map = array('id'=>$v['s_user_id']);
			$_user = $User->where($map)->find();
      $data[$k]['sUserName']=substr_replace($_user['phone'],'****',3,4);
         			$map1 = array('id'=>$v['b_user_id']);
			$_user1 = $User->where($map1)->find();
      $data[$k]['bUserName']=substr_replace($_user1['phone'],'****',3,4);
         $data[$k]['bUserId']=$v['b_user_id'];
          $data[$k]['sUserId']=$v['s_user_id'];
         $data[$k]['status']=$v['status'];
        $data[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
  // 获取我正在交易的订单数量
	public function getJynum() {
			$market = M('market');
			$post = $_REQUEST;
			$data = $market->where('status>1 and (s_user_id='.$post['id'].' or b_user_id='.$post['id'].')')->count();
    
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
    // 获取yiwancheng
	public function getMyMarketDown() {
			$market = M('market');
			$post = $_REQUEST;
			$map = array('status'=>1,'s_user_id'=>$post['sUserId']);
			$data = $market->where("status=1 and (s_user_id=".$post['sUserId']." or b_user_id=".$post['bUserId'].")")->order('id DESC')->select();
       foreach($data as $k => $v){
        $User = M('user');
			$map = array('id'=>$v['s_user_id']);
			$_user = $User->where($map)->find();
         $map1 = array('id'=>$v['b_user_id']);
			$_user1 = $User->where($map1)->find();
      $data[$k]['sUserName']=substr_replace($_user['phone'],'****',3,4);
         $data[$k]['bUserName']=substr_replace($_user1['phone'],'****',3,4);
       // $data[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
  	//* 删除交易
	public function cancelOrder() {
      $market = M('market');
      $post = $_REQUEST;
	  $map = array('id'=>$post['id']);
       $info = M('market')->where($map)->find();
       if($info['type']==1){
       	$map1 = array('user_id'=>$info['s_user_id']);
       $tginfo = M('tangguo_log')->where($map1)->order('id DESC')->find();
       if($tginfo['create_time']>time()-2){
       		  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
       }
       }
       $map1 = array('id'=>$post['userid']);
       $_user = M('user')->where($map1)->find();
       //人脸识别校验
       if($_user['mian']==0){
       	$today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       	}
       }
       }
       //人脸识别校验
       if($info['status']>0){
       		  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
       }
      $_result = M('market')->where($map)->delete();
		if ($_result) {
          if($info['type']==1){
			  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  addtangguo($info['s_user_id'], 1, $info['num'], 'Cancel change');
	  }else{
		   addtangguo($info['s_user_id'], 1, $info['num'], '取消交易');
	  }
         
          }
		  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>1, 'msg'=>'Cancellation Successful'));
	  }
          $this->ajaxReturn(array('status'=>1, 'msg'=>'取消成功'));
        }else{
	   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }
        $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
        }
	}
    // 获取交易列表
	public function getMarket() {
			$market = M('market');
			 $post = $_REQUEST;
      
      
			$map = array('status'=>0,'type'=>$post['type']);
			if($post['type']==0){
				$data = $market->where($map)->order('price desc')->select();
			}else{
				$data = $market->where($map)->order('price ASC')->select();
			}
			
       foreach($data as $k => $v){
        $User = M('user');
         if($v['type']==0){
         $uid=$v['b_user_id'];
           $map = array('id'=>$uid);
			$_user = $User->where($map)->find();
      //$data[$k]['bUserName']=substr_replace($_user['phone'],'****',3,4);
      $data[$k]['bUserName']=$_user['id'];
      $data[$k]['bHead']=$_user['avatar'];

        $data[$k]['countryimg'][0]['cover']=$_user['countryimg'];
       $map1 = array('userid'=>$uid);

	  $countrylist = M('usercountry')->where($map1)->order('id ASC')->select();
      foreach($countrylist as $key => $val){
      $data[$k]['countryimg'][$val['id']]['cover']=$val['cover'];
      }
         }else{
          $uid=$v['s_user_id'];
           $map = array('id'=>$uid);
			$_user = $User->where($map)->find();
      //$data[$k]['sUserName']=substr_replace($_user['phone'],'****',3,4);
      $data[$k]['sUserName']=$_user['id'];
       $data[$k]['sHead']=$_user['avatar'];
        $data[$k]['countryimg'][0]['cover']=$_user['countryimg'];
       $map1 = array('userid'=>$uid);

	  $countrylist = M('usercountry')->where($map1)->order('id ASC')->select();
      foreach($countrylist as $key => $val){
      $data[$k]['countryimg'][$val['id']]['cover']=$val['cover'];
      }

         }
			
        $data[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
      // 确认该订单
	public function sellMarket() {
			$market = M('market');
			$post = $_REQUEST;
			$map = array('id'=>$post['id']);
			$data = $market->where($map)->find();
      
      $where['token']=$post['sUserId'];
      $userinfo = M('user')->where($where)->find();
      
       if($userinfo['status']!=1){
  	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
       //人脸识别校验
       
       if($userinfo['mian']==0){
       $today = strtotime(date('Y-m-d'));
       if($userinfo['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       }else{
       	if($post['rzcode']!=$userinfo['rzcode']){
       		M('user')->save(array(
					'id' => $userinfo['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	}
       }
       }
       //人脸识别校验
       	$map1 = array('user_id'=>$userinfo['id']);
       $tginfo = M('tangguo_log')->where($map1)->order('id DESC')->find();
       if($tginfo['create_time']>time()-10){
       		  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
       }
     
      if($userinfo['level']==0){
  	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Users with a user level of 0 cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'用户等级为0的用户无法操作'));
      }
      if($data['type']==1){
		  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
      }
     
      $where1['id']=$data['b_user_id'];
      $maiinfo = M('user')->where($where1)->find();
      if(empty($maiinfo)){
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
      }
      
       if($data['b_user_id']==$userinfo['id']){
		   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'You cannot operate your order'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您不能操作自己的订单哦'));
      }
      $map = array('id'=>$post['id']);
	  $data = $market->where($map)->find();
      if($data['status']==2){
			   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'The order has been operated on'));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'该订单已被操作'));
      exit;
      }
      
      
      //判断这个用户是否可以交易
        $shuzu=array();
      $you=0;
      $shuzu[]=$maiinfo['countryid'];
			$map1 = array('userid'=>$data['b_user_id']);
			$usercountry = M('usercountry')->where($map1)->order('id DESC')->select();
      foreach($usercountry as $key => $val){
      $shuzu[]=$val['countryid'];
      }

      if(in_array($userinfo['countryid'], $shuzu)){
      //有这个国家
        $you=1;
      }else{
      $mapuc['userid']  = $userinfo['id'];
			$datacountry = M('usercountry')->where($mapuc)->order('id ASC')->select();
      foreach($datacountry as $k => $v){
        
      if(in_array($v['countryid'], $shuzu)){
          //有这个国家
        $you=1;
        } 
      }
      }
if($you==0){
$this->ajaxReturn(array('status'=>2, 'msg'=>'你无法进行多国交易，请先开通当前国家交易权限'));
}

      //判断这个用户是否可以交易
      
       $level = M('bonus_level');
			$map1 = array('id'=>$userinfo['level']);
			$levelinfo = $level->where($map1)->find();
      $shouxufei=$levelinfo['rate']*0.01;
      if($userinfo['viptime']>time()){
      $shouxufei=0;
      }
      $shijinum=$data['shijinum']*(1+$shouxufei);
      
      if($userinfo['money']<$shijinum){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>"You don't have enough candy."));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的糖果不足'));
      }
     
     if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $return1 = addtangguo($userinfo['id'], 1, (-1)*$shijinum, 'Selling Candy Freeze');
     }else{
		  $return1 = addtangguo($userinfo['id'], 1, (-1)*$shijinum, '卖出糖果冻结');
	 }
  
     $return2= $market->save(array(
                      'id' => $data['id'],
               'status' => 2,
       'num' => $shijinum,
       's_user_id' => $userinfo['id'],
       'buy_date' => time(),
       'fuhao' => 0,
       'huilv' => 0,
				));
   
      if($return1&&$return2){
		  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>1, 'msg'=>'Successful sale, please wait for buyer to pay'));
     }
      	$this->ajaxReturn(array('status'=>1, 'msg'=>'卖出成功,请等待买家打款'));
      }else{
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
        	$this->ajaxReturn(array('status'=>0, 'msg'=>'操作失败'));
    
      }
	
	}
  
  // 确认该订单
	public function buyMarket() {
			$market = M('market');
			$post = $_REQUEST;
			$map = array('id'=>$post['id']);
			$data = $market->where($map)->find();
      
      $where['token']=$post['bUserId'];
      $userinfo = M('user')->where($where)->find();
        if($userinfo['status']!=1){
		  	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
      
      		
      if($userinfo['level']==0){
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Users with a user level of 0 cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'用户等级为0的用户无法操作'));
      }
      

	  $youjiaoyi = $market->where("(s_user_id='".$userinfo['id']."' or b_user_id='".$userinfo['id']."') and status=1")->find();
	  if(!$youjiaoyi){
	  	$buyminnum=$this->conf['more']['buyminnum'];//临界数量
	  	if($userinfo['money']<$buyminnum){
	  		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'New user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'新用户无法操作'));
	  	}
	  }
	  
      if($data['type']==0){
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
      }
      
        $where1['id']=$data['s_user_id'];
      $maiinfo = M('user')->where($where1)->find();
      if(empty($maiinfo)){
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
      }
       if($data['s_user_id']==$userinfo['id']){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'You cannot operate your order'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您不能操作自己的订单哦'));
      }
      $map = array('id'=>$post['id']);
		$data = $market->where($map)->find();
      if($data['status']==2){
			   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'The order has been operated on'));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'该订单已被操作'));
      exit;
      }
     
      //判断这个用户是否可以交易
        $shuzu=array();
      $you=0;
      $shuzu[]=$maiinfo['countryid'];
			$map1 = array('userid'=>$data['s_user_id']);
			$usercountry = M('usercountry')->where($map1)->order('id DESC')->select();
      foreach($usercountry as $key => $val){
      $shuzu[]=$val['countryid'];
      }
      if(in_array($userinfo['countryid'], $shuzu)){
      //有这个国家
        $you=1;
      }else{
      $mapuc['userid']  = $userinfo['id'];
			$datacountry = M('usercountry')->where($mapuc)->order('id ASC')->select();
      foreach($datacountry as $k => $v){
        
      if(in_array($v['countryid'], $shuzu)){
          //有这个国家
        $you=1;
        } 
      }
      }
if($you==0){
$this->ajaxReturn(array('status'=>2, 'msg'=>'你无法进行多国交易，请先开通当前国家交易权限'));
}

      //判断这个用户是否可以交易

     $return2= $market->save(array(
                      'id' => $data['id'],
               'status' => 2,
        'b_user_id' => $userinfo['id'],
       'buy_date' => time(),
				));
      if($return2){
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
    $this->ajaxReturn(array('status'=>1, 'msg'=>'Successful operation, please pay','data'=>$data['id']));
     }  
      	$this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功，请付款','data'=>$data['id']));
      }else{
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
    	$this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
     }  
        	$this->ajaxReturn(array('status'=>0, 'msg'=>'操作失败'));
      }
	
	}  
	
  //添加交易
  public function addMarket(){
  if (IS_POST) {
  //	$this->ajaxReturn(array('status'=>0, 'msg'=>'交易暂时停止'));	
  	$post = $_REQUEST;
  	$zuidijia=$this->conf['more']['min'];//最低价
  	$zuigaojia=$this->conf['more']['max'];//最高价
  	$minnum=$this->conf['more']['minnum'];//临界数量
  	$sellminnum=$this->conf['more']['sellminnum'];//卖临界数量
  		if($post['price']<$sellminnum) $this->ajaxReturn(array('status'=>0, 'msg'=>'发布价格不能低于'.$sellminnum));
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		//if (empty($post['deviceId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please update to the latest version'));
   if (empty($post['num'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please fill in the number of transactions'));
   if($post['num']<1) $this->ajaxReturn(array('status'=>0, 'msg'=>'The minimum number is 1'));
   if((intval($post['num'])- $post['num'])!== 0){
         $this->ajaxReturn(array('status'=>0, 'msg'=>'Transaction quantity must be an integer'));
         }
      if (empty($post['price'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please fill in the transaction unit price'));
      if(!is_numeric($post['price']))
      { 
    $this->ajaxReturn(array('status'=>0, 'msg'=>'Please fill in the transaction unit price correctly'));
     }
     if (strpos($post['price'], '.') !== false) {
$array=explode('.',$post['price']);
if($array[0]==''){
$this->ajaxReturn(array('status'=>0, 'msg'=>'Please fill in the transaction unit price correctly'));	
}
      }
     if($post['price']<$sellminnum) $this->ajaxReturn(array('status'=>0, 'msg'=>'Price cannot be lower than '.$sellminnum));
      if($post['type']==1){
      	if($post['num']<$minnum &&$post['price']>$zuidijia) $this->ajaxReturn(array('status'=>0, 'msg'=>'The minimum number is lower than'.$minnum.',Only the lowest price can be published'));
      		
      }

     }else{
     	 //if (empty($post['deviceId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请更新至最新版本'));
		 if (empty($post['num'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写交易数量'));
		 if($post['num']<1) $this->ajaxReturn(array('status'=>0, 'msg'=>'数量最少为1个'));
		 
		 if((intval($post['num'])- $post['num'])!== 0){
         $this->ajaxReturn(array('status'=>0, 'msg'=>'交易数量必须是整数'));
         }
      if (empty($post['price'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写交易单价'));
      if (strpos($post['price'], '.') !== false) {
$array=explode('.',$post['price']);
if($array[0]==''){
$this->ajaxReturn(array('status'=>0, 'msg'=>'请正确填写交易单价'));	
}
      }
      if(!is_numeric($post['price']))
      { 
    $this->ajaxReturn(array('status'=>0, 'msg'=>'请正确填写交易单价'));
     }
     
      if($post['type']==1){
      	if($post['num']<$minnum &&$post['price']>$zuidijia) $this->ajaxReturn(array('status'=>0, 'msg'=>'小于'.$minnum.'粒糖果只能发布最低价'));
      
      	//限制24小时内卖出的
      	$last24=time()-86400;
      	$market = M('market');
      	$youjiaoyi24 = $market->where("s_user_id='".$_user['id']."' and status=1 and confirm_date>'$last24'")->find();
      	if($youjiaoyi24){
      		$this->ajaxReturn(array('status'=>0, 'msg'=>'24小时内仅限一次挂卖'));
      	}
      }

	 }
    

			$market = M('market');
    if($post['type']==0){
    	//if($post['price']<=0.2) $this->ajaxReturn(array('status'=>0, 'msg'=>'求购价格最低0.2'));
    //if($post['price']<$zuidijia) $this->ajaxReturn(array('status'=>0, 'msg'=>'求购只能发布最低价或者以上'));
    if (empty($post['bUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
       $User = M('user');
			$map = array('token'=>$post['bUserId']);
			$_user = $User->where($map)->find();
			if($_user['changepass']==''){
					$this->ajaxReturn(array('status'=>0, 'msg'=>'请完善交易密码'));
			}
	
		if($post['deviceId']!=$_user['deviceid']){
		  // $this->ajaxReturn(array('status'=>0, 'msg'=>'请退出账号重新登录'));
		}

	  $youjiaoyi = $market->where("(s_user_id='".$_user['id']."' or b_user_id='".$_user['id']."') and status=1")->find();
	  if(!$youjiaoyi){
	  	$buyminnum=$this->conf['more']['buyminnum'];//临界数量
	  	if($_user['money']<$buyminnum){
	  		if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'New user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'新用户无法操作'));
	  	}
	  }
      
      if($_user['status']!=1){
		    	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
      if($_user['level']==0){
		   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Users with a user level of 0 cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'用户等级为0的用户无法操作'));
      }
      //人脸识别校验
      if($_user['mian']==0){
       $today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       	}
       }
      }
       //人脸识别校验
      $_result = $market->add(array(
				'b_user_id' => $_user['id'],
              'shijinum' => $post['num'],
              'num' => $post['num'],
              'price' => $post['price'],
              'status' => $post['status'],
              'type' => $post['type'],
               'create_date' => time(),
			));
       //$_result1 = addaccount($_user['id'], 1, (-1)*$_REQUEST['price']*$_REQUEST['num'], '购买糖果冻结');

    }else{
      if (empty($post['sUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
       $User = M('user');
			$map = array('token'=>$post['sUserId']);
			$_user = $User->where($map)->find();
       if($_user['status']!=1){
		   		    	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Unreal-name authenticated user or frozen user cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'未实名认证用户或冻结用户不能操作'));
      }
      	$map1 = array('user_id'=>$_user['id']);
       $tginfo = M('tangguo_log')->where($map1)->order('id DESC')->find();
       if($tginfo['create_time']>time()-2){
       		  	 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		  $this->ajaxReturn(array('status'=>0, 'msg'=>'Fail'));
	  }else{
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'操作错误'));
	  }
       }
        if($_user['level']==0){
			 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'Users with a user level of 0 cannot operate'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'用户等级为0的用户无法操作'));
      }
      //人脸识别校验
      if($_user['mian']==0){
       $today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	}
       }
      }
       //人脸识别校验
      //卖单不允许发布多个订单
	   $mapmk['s_user_id'] = $_user['id'];
	   $mapmk['type'] = 1;
	   $mapmk['status']  = array('neq',1);
			$smarketinfo = $market->where($mapmk)->find();
			if($smarketinfo){
				if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>"You still have unfinished sales order"));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您还有未完成的卖单'));
			}
	   //卖单不允许发布多个订单
      if($_user['money']<$post['num']){
		  	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>"You don't have enough candy"));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的糖果不足'));
      }
       $level = M('bonus_level');
			$map1 = array('id'=>$_user['level']);
			$levelinfo = $level->where($map1)->find();
          $shouxufei=$levelinfo['rate']*0.01;
      if($_user['viptime']>time()){
      $shouxufei=0;
      }
       if($_user['money']<$post['num']*(1+$shouxufei)){
		   	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>"Your candy is not enough to deduct the handling fee"));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'您的糖果不足以扣除手续费'));
      }
      
  
      $_result = $market->add(array(
				's_user_id' => $_user['id'],
              'num' => $post['num']*(1+$shouxufei),
              'shijinum' => $post['num'],
              'price' => $post['price'],
              'status' => $post['status'],
              'type' => $post['type'],
               'create_date' => time(),
			));
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $_result1 = addtangguo($_user['id'], 1, (-1)*$_REQUEST['num']*(1+$shouxufei), 'Selling Candy Freeze');
     }else{
	$_result1 = addtangguo($_user['id'], 1, (-1)*$_REQUEST['num']*(1+$shouxufei), '卖出糖果冻结');
	 }  
       
    }
			
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
// 获取yiwancheng
	public function orderDetail() {
			$market = M('market');
			$post = $_REQUEST;
			$map = array('id'=>$post['id']);
			$marketinfo = $market->where($map)->find();
			if($marketinfo['s_user_id']!=$post['Userid']&&$marketinfo['b_user_id']!=$post['Userid']){
			//	$this->ajaxReturn(array('status'=>0, 'msg'=>'订单不存在'));
			}
       $User = M('user');
			$map = array('id'=>$marketinfo['s_user_id']);
			$_user = $User->where($map)->find();
      $marketinfo['sUserName']=$_user['phone'];
       $marketinfo['bankName']=$_user['bankname'];
       $marketinfo['bankNo']=$_user['bankno'];
       $marketinfo['realname']=$_user['realname'];
       $marketinfo['wechat']=$_user['wechat'];
       if($marketinfo['pay_date']>0){
        $marketinfo['createDate']=date('Y-m-d H:i:s',$marketinfo['pay_date']);
       }else{
        $marketinfo['createDate']=date('Y-m-d H:i:s',$marketinfo['create_date']);
       }
      $map1 = array('id'=>$_user['countryid']);
			$_country = M('country')->where($map1)->find();
       $marketinfo['huilv']=$_country['huilv'];
      $marketinfo['fuhao']=$_country['name'].'汇款金额'.$_country['fuhao'];
			$map1 = array('userid'=>$marketinfo['s_user_id']);
			$mybanklist = M('usercountry')->where($map1)->select();

     $data['mybanklist']=$mybanklist;
         			$map1 = array('id'=>$marketinfo['b_user_id']);
			$_user1 = $User->where($map1)->find();
       $marketinfo['brealname']=$_user1['realname'];
      $marketinfo['bUserName']=$_user1['phone'];
      $marketinfo['bwechat']=$_user1['wechat'];
      //$marketinfo['img']='';
    $data['market']=$marketinfo;
		$this->ajaxReturn(array('status'=>1, 'data'=>$data,));
	}
 // 上传支付截图
	public function iPayed() {
		//	$this->ajaxReturn(array('status'=>0, 'msg'=>'交易暂时停止'));	
			$market = M('market');
            $post = $_REQUEST;
			$map = array('id'=>$post['id']);
			$marketinfo = $market->where($map)->find();
			 $User = M('user');
			 $map1 = array('token'=>$post['bUserId']);
			$_userinfo = $User->where($map1)->find();
			if($_userinfo['id']!=$marketinfo['b_user_id'] || $marketinfo['status']!=2){
				 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'The order has been overtime'));
     }
      $this->ajaxReturn(array('status'=>0, 'msg'=>'订单已超时'));
			}
      
			$map = array('id'=>$marketinfo['s_user_id']);
			$_user = $User->where($map)->find();
			//人脸识别校验
			/*
       if($_user['mian']==0){
       	$today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       	}
       }
       }
       */
       //人脸识别校验
      $img=explode('/',$post['img']);
    $image='/upload/image/'.$img[1];
          M('market')->save(array(
					'id' => $post['id'],
					'img' => $image,  
                    'status' => 3, 
                    'pay_date'=>time(),
				));
		 if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
     }
      $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
	}
  
   // 确认订单
	public function iGot() {
			//$this->ajaxReturn(array('status'=>0, 'msg'=>'交易暂时停止'));	
			$market = M('market');
			$post = $_REQUEST;
			$map = array('id'=>$post['id']);
			$marketinfo = $market->where($map)->find();
       if($marketinfo['status']!=3){
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Illegal operation'));
     }
          $this->ajaxReturn(array('status'=>0, 'msg'=>'非法操作'));
           exit;
          }
          
          if($marketinfo['status']==1){
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Illegal operation'));
     }
          $this->ajaxReturn(array('status'=>0, 'msg'=>'非法操作'));
          exit;
          }
       $User = M('user');
			$map = array('id'=>$marketinfo['s_user_id']);
			$_user = $User->where($map)->find();
//人脸识别校验
	
       if($_user['mian']==0){
       	$today = strtotime(date('Y-m-d'));
       if($_user['lastrztime']<$today){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }
       if(strlen($post['rzcode'])<10){
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       }else{
       	if($post['rzcode']!=$_user['rzcode']){
       		M('user')->save(array(
					'id' => $_user['id'],
                    'lastrztime' => 0,
				));
       	$this->ajaxReturn(array('status'=>0, 'msg'=>'请重新进行人脸识别'));
       	exit;
       	}
       }
       }
       //人脸识别校验
          $result=M('market')->save(array(
					'id' => $post['id'],
                    'status' => 1, 
                    'confirm_date' => time(),
				));
	if($result){
		sleep(2);
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      addtangguo($marketinfo['b_user_id'], 1, $marketinfo['shijinum'], '订单ID'.$marketinfo['id'].'Successful trading, Get candy');
     }else{
	  addtangguo($marketinfo['b_user_id'], 1, $marketinfo['shijinum'], '订单ID'.$marketinfo['id'].'交易成功，获得糖果');
	 }
	 //这里扣除手续费
      //手续费放入奖金池
      $money=$marketinfo['num']-$marketinfo['shijinum'];
      if($money>0){
      	 M('bonus_log')->add(array(
				'user_id' => $marketinfo['s_user_id'],
              'bonus_id' => $marketinfo['id'],
              'money' => $money,
              'create_time' => time(),
			));
      //获取今日时间
      $todaytime=strtotime(date('Y-m-d',time()));
      $bonus = M('bonus');
	  $map1 = array('create_time'=>$todaytime);
	  $bonusinfo = $bonus->where($map1)->find();
      if($bonusinfo){
       M("bonus")->where($map1)->setInc('money', $money);
      }else{
      M('bonus')->add(array(
              'money' => $money,
              'create_time' => $todaytime,
			));
      }
      }
      
	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
     }
      $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
				}else{
					$this->ajaxReturn(array('status'=>0, 'msg'=>'操作失败'));
				}

	}
}
