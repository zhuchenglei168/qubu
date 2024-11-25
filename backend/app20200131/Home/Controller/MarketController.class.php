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
    //发布订单超时未购买取消
	$chaoshilimit=$this->conf['more']['chaoshilimit'];//超时时间限制
    $chaoshit=time()-$chaoshilimit;
    $smarketlist = $market->where("status=0 and create_date<'$chaoshit' and type=1")->order("id DESC")->select();
    foreach($smarketlist as $k => $v){
       $suserid=$v['s_user_id'];
       $num=$v['num'];
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      addtangguo($suserid, 1, $num, 'Failed to unfreeze the sales order due to timeout');
     }else{
	  addtangguo($suserid, 1, $num, '卖单ID'.$v['id'].'超时未成交解冻');
	 }
    }
  
    $market->where("status=0 and create_date<'$chaoshit' and type=1")->delete();
	//交易未付款取消
    $timelimit=$this->conf['more']['timelimit'];//超时时间限制
    $chaoshi=time()-$timelimit;
    $marketlist = $market->where("status=2 and buy_date<'$chaoshi' and type=0")->order("id DESC")->select();
    foreach($marketlist as $k => $v){
       $suserid=$v['s_user_id'];
       $num=$v['num'];
       if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $return1 = addtangguo($suserid, 1, $num, 'Buyer overtime unpaid lifts freeze');
     }else{
		  $return1 = addtangguo($suserid, 1, $num, '买家超时未付款解冻');
	 }
    }
    $updata = array(
            'status' => 0,
            'buy_date' => 0,
            's_user_id'=>0,
            'img'=>''
        );
    $market->where("status=2 and buy_date<'$chaoshi' and type=0")->setField($updata);
    
    $updata1 = array(
            'status' => 0,
            'buy_date' => 0,
            'b_user_id'=>0,
            'img'=>''
        );
    $market->where("status=2 and buy_date<'$chaoshi' and type=1")->setField($updata1);
			$marketinfo = $market->order("id DESC")->find();
    $data['b'] = $market->where("status=1 and type=0")->sum('num');
     $data['s'] = $market->where("status=1 and type=1")->sum('num');
     $data['b']=ceil($data['b']);
     $data['s']=ceil($data['s']);
     
     $data['day_now']=$marketinfo['price'];
    $data['min']=$this->conf['more']['min'];
    $data['max']=$this->conf['more']['max'];
        $data['day_min']=$this->conf['more']['min'];
    $data['day_max']=$this->conf['more']['max'];
     $this->ajaxReturn(array('status'=>1, 'data'=>$data));
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
			$post = I('get.');
			$map = array('type'=>0,'status'=>0,'b_user_id'=>$post['bUserId']);
			$data = $market->where($map)->select();
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
			$data = $market->where($map)->select();
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
			$post = I('get.');
			$map = array('status'=>1,'s_user_id'=>$post['sUserId']);
			$data = $market->where('status>1 and (s_user_id='.$post['sUserId'].' or b_user_id='.$post['sUserId'].')')->order('id ASC')->limit('100')->select();
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
			$post = I('get.');
			$data = $market->where('status>1 and (s_user_id='.$post['id'].' or b_user_id='.$post['id'].')')->count();
    
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
    // 获取yiwancheng
	public function getMyMarketDown() {
			$market = M('market');
			$post = I('get.');
			$map = array('status'=>1,'s_user_id'=>$post['sUserId']);
			$data = $market->where("status=1 and (s_user_id=".$post['sUserId']." or b_user_id=".$post['bUserId'].")")->select();
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
      $post = I('get.');
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
			 $post = I('get.');
			$map = array('status'=>0,'type'=>$post['type']);
			$data = $market->where($map)->order('id desc')->select();
       foreach($data as $k => $v){
        $User = M('user');
         if($v['type']==0){
         $uid=$v['b_user_id'];
           $map = array('id'=>$uid);
			$_user = $User->where($map)->find();
      $data[$k]['bUserName']=substr_replace($_user['phone'],'****',3,4);
      $data[$k]['bHead']=$_user['avatar'];
         }else{
          $uid=$v['s_user_id'];
           $map = array('id'=>$uid);
			$_user = $User->where($map)->find();
      $data[$k]['sUserName']=substr_replace($_user['phone'],'****',3,4);
       $data[$k]['sHead']=$_user['avatar'];
         }
			
        $data[$k]['createDate']=date('Y-m-d H:i:s',$v['create_date']);
      }
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
      // 确认该订单
	public function sellMarket() {
		$this->ajaxReturn(array('status'=>0, 'msg'=>'暂时无法交易'));
			$market = M('market');
			$post = I('get.');
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
       /*
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
       }*/
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
      if($data['status']==2){
			   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'The order has been operated on'));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'该订单已被操作'));
      }
       $level = M('bonus_level');
			$map1 = array('id'=>$userinfo['level']);
			$levelinfo = $level->where($map1)->find();
      $shouxufei=$levelinfo['rate']*0.01;
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
		$this->ajaxReturn(array('status'=>0, 'msg'=>'暂时无法交易'));
			$market = M('market');
			$post = I('get.');
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
      if($data['status']==2){
			   if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
     $this->ajaxReturn(array('status'=>0, 'msg'=>'The order has been operated on'));
     }  
      $this->ajaxReturn(array('status'=>0, 'msg'=>'该订单已被操作'));
      }
     
      
     // $return = addaccount($userinfo['id'], 1, (-1)*$data['price']*$data['num'], '购买糖果减少余额');
     // $return1 = addtangguo($userinfo['id'], 1, $data['num'], '购买糖果');
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
  	$this->ajaxReturn(array('status'=>0, 'msg'=>'暂时无法交易'));
  	$post = I('get.');
  	$zuidijia=$this->conf['more']['min'];//最低价
  	$zuigaojia=$this->conf['more']['max'];//最高价
  	$minnum=$this->conf['more']['minnum'];//临界数量
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
		if (empty($post['deviceId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please update to the latest version'));
   if (empty($post['num'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please fill in the number of transactions'));
   if($post['num']<1) $this->ajaxReturn(array('status'=>0, 'msg'=>'The minimum number is 1'));
      if (empty($post['price'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'Please fill in the transaction unit price'));
      if($post['type']==1){
      	if($post['num']<$minnum &&$post['price']>$zuidijia) $this->ajaxReturn(array('status'=>0, 'msg'=>'The minimum number is lower than'.$minnum.',Only the lowest price can be published'));
      }
      
     }else{
     	 if (empty($post['deviceId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请更新至最新版本'));
		 if (empty($post['num'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写交易数量'));
		 if($post['num']<1) $this->ajaxReturn(array('status'=>0, 'msg'=>'数量最少为1个'));
      if (empty($post['price'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写交易单价'));
      if($post['type']==1){
      	if($post['num']<$minnum &&$post['price']>$zuidijia) $this->ajaxReturn(array('status'=>0, 'msg'=>'小于'.$minnum.'粒糖果只能发布最低价'));
      }
      
	 }
    

			$market = M('market');
    if($post['type']==0){
    if (empty($post['bUserId'])) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的用户'));
       $User = M('user');
			$map = array('token'=>$post['bUserId']);
			$_user = $User->where($map)->find();
			if($_user['changepass']==''){
					$this->ajaxReturn(array('status'=>0, 'msg'=>'请完善交易密码'));
			}
	
		if($post['deviceId']!=$_user['deviceid']){
		   $this->ajaxReturn(array('status'=>0, 'msg'=>'请退出账号重新登录'));
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
			$post = I('get.');
			$map = array('id'=>$post['id']);
			$marketinfo = $market->where($map)->find();
       $User = M('user');
			$map = array('id'=>$marketinfo['s_user_id']);
			$_user = $User->where($map)->find();
      $marketinfo['sUserName']=$_user['phone'];
       $marketinfo['bankName']=$_user['bankname'];
       $marketinfo['bankNo']=$_user['bankno'];
       $marketinfo['realname']=$_user['realname'];
       if($marketinfo['pay_date']>0){
        $marketinfo['createDate']=date('Y-m-d H:i:s',$marketinfo['pay_date']);
       }else{
        $marketinfo['createDate']=date('Y-m-d H:i:s',$marketinfo['create_date']);
       }
     
     
         			$map1 = array('id'=>$marketinfo['b_user_id']);
			$_user1 = $User->where($map1)->find();
       $marketinfo['brealname']=$_user1['realname'];
      $marketinfo['bUserName']=$_user1['phone'];
    $data['market']=$marketinfo;
		$this->ajaxReturn(array('status'=>1, 'data'=>$data));
	}
 // 上传支付截图
	public function iPayed() {
			$market = M('market');
            $post = I('get.');
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
			$market = M('market');
			$post = I('get.');
			$map = array('id'=>$post['id']);
			$marketinfo = $market->where($map)->find();
       if($marketinfo['status']!=3){
		    if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>0, 'msg'=>'Illegal operation'));
     }
          $this->ajaxReturn(array('status'=>0, 'msg'=>'非法操作'));
          }
       $User = M('user');
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
       }*/
       //人脸识别校验
          M('market')->save(array(
					'id' => $post['id'],
                    'status' => 1, 
                    'confirm_date' => time(),
				));
	if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      addtangguo($marketinfo['b_user_id'], 1, $marketinfo['shijinum'], '订单ID'.$marketinfo['id'].'Successful trading, Get candy');
     }else{
	  addtangguo($marketinfo['b_user_id'], 1, $marketinfo['shijinum'], '订单ID'.$marketinfo['id'].'交易成功，获得糖果');
	 }
      
      //这里扣除手续费
      //手续费放入奖金池
      $money=$marketinfo['num']-$marketinfo['shijinum'];
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
	  if($_SERVER['HTTP_HOST']==$this->conf['jiben']['enurl']){
      $this->ajaxReturn(array('status'=>1, 'msg'=>'Success'));
     }
      $this->ajaxReturn(array('status'=>1, 'msg'=>'操作成功'));
	}
}
