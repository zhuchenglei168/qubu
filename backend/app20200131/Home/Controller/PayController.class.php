<?php
namespace Home\Controller;
use Think\Controller;
class PayController extends CommonController {

	// 支付订单
	public function index() {
		$trade_no = strip_tags(I('get.trade_no'));
		$map = array('trade_no'=>array('eq', $trade_no));
		$_order = M('order')->where($map)->order('id DESC')->find();
		// 产品信息
		$_product = M('product')->find($_order['product_id']);
		if (IS_POST) {
			if ($_product['remain'] <= 0) $this->ajaxReturn(array('status'=>0, 'msg'=>'今日已售罄'));
			if (empty($_order)) $this->ajaxReturn(array('status'=>0, 'msg'=>'不存在的订单'));
			if ($_order['status'] == 1) $this->ajaxReturn(array('status'=>0, 'msg'=>'订单已支付'));
			if ($_order['status'] == 2) $this->ajaxReturn(array('status'=>0, 'msg'=>'订单已取消'));
			// 微信内提示浏览器打开
			if (is_wechat()) $this->ajaxReturn(array('status'=>2, 'msg'=>'点击右上角，选择浏览器打开'));
			$form = '<form action="/pay/alipay" method="POST"><input type="hidden" name="trade_no" value="'.$_order['trade_no'].'"></form>';
			$this->ajaxReturn(array('status'=>1, 'msg'=>'即将跳转到支付宝...', 'form'=>$form));
		} else {
			if (empty($_order)) $this->error('不存在的订单');
			if ($_order['status'] == 1) $this->error('订单已支付');
			if ($_order['status'] == 2) $this->error('订单已取消');
			$this->assign('order', $_order);
			$_product['total_profit'] = $_product['profit'] * $_product['num'] - $_product['price'];
			$this->assign('product', $_product);
			$this->display();
		}
	}

	// 支付宝支付
	public function alipay() {

		if (IS_POST) {
			$trade_no = strip_tags(I('post.trade_no'));
			$map = array('trade_no'=>array('eq', $trade_no));
			$_order = M('order')->where($map)->order('id DESC')->find();
			if (empty($_order)) $this->error('不存在的订单');
			if ($_order['status'] == 1) $this->error('订单已支付');
			if ($_order['status'] == 2) $this->error('订单已取消');
			// 产品信息
			$_product = M('product')->find($_order['product_id']);
			// 支付流程
			$Alipay = new \Common\Util\Apppay();
			$_result = $Alipay->pay($_order);
			if (empty($_result))$this->error('系统繁忙，请稍后再试~');
		}
	}

	// 同步通知
	public function return() {
		// 验证
		$Alipay = new \Common\Util\Alipay();
		$_alipay = $_GET;
		$_result = $Alipay->check($_alipay);
		if (empty($_result)) $this->error('支付异常，若已支付请稍后~');

		$map = array('trade_no'=>array('eq', $_alipay['out_trade_no']));
		$_order = M('order')->where($map)->order('id DESC')->find();
		if (empty($_order)) $this->error('不存在的订单');
		if ($_order['status'] == 1) $this->error('订单已支付');
		if ($_order['status'] == 2) $this->error('订单已取消');
		if ($_order['money'] != $_alipay['total_amount']) $this->error('支付金额异常，异常信息已记录');
		if ($_result) {
			$this->success('支付成功', '/user/order');
		} else {
			$this->error('支付异常，若已支付请稍后~');
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
		$fp='/www/wwwroot/www.07rjm.cn/public/upload/image/face/'.$fn;
		$fi=1;
		while( file_exists($fp) ) {	// 当提交的文件已经存在时则重命名
			$fn=$fm.'['.$fi.']'.$fe;
			$fp='/www/wwwroot/www.07rjm.cn/public/upload/image/face/'.$fn;
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
  
    //提交认证
  public function identify(){
  if (IS_POST) {
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
$bodys = "{\"image\":\"".$shenghuozhao."\",\"image_type\":\"URL\",\"group_id_list\":\"newshiming\",\"quality_control\":\"LOW\",\"liveness_control\":\"NONE\"}";
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
$bodys = "{\"image\":\"".$shenghuozhao."\",\"image_type\":\"URL\",\"group_id\":\"newshiming\",\"user_id\":\"user".$_user['id']."\",\"user_info\":\"abc\",\"quality_control\":\"LOW\",\"liveness_control\":\"NONE\"}";
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
			$map4 = array('trade_no'=>$trade_no,'user_id'=>$_user['id']);
			$_order = M('order')->where($map4)->find();
			$this->pay_handle($_order);
     
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
  public function jiaoyan(){
  	
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
$bodys = "{\"image\":\"".$shenghuozhao."\",\"image_type\":\"URL\",\"group_id_list\":\"newshiming\",\"user_id\":\"user".$_REQUEST['appUserId']."\",\"quality_control\":\"LOW\",\"liveness_control\":\"NONE\"}";
$res = $this->request_post($url, $bodys);
// $this->ajaxReturn(array('status'=>0, 'msg'=>$res));
$data1=json_decode($res,true);
   if($data1['error_code']=='0'|| $data1['error_code']=='222207'){
    if($data1['result']['user_list'][0]['score']>70){
    		$User = M('user');
			$map = array('id'=>$_REQUEST['appUserId']);
			$_user = $User->where($map)->find();
            $rzcode=time().getrandomstring(64);
			 $User->save(array(
                    'id' => $_user['id'],
                    'lastrztime' => time(),
                    'rzcode' => $rzcode,
				));
   
     $this->ajaxReturn(array('status'=>1, 'msg'=>"识别成功",'data'=>$rzcode));
    }
  }else{
  	$this->ajaxReturn(array('status'=>0, 'msg'=>"该人脸不存在，无法登陆"));
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
	// 异步通知
	public function notify() {
		if (IS_POST) {
			// 验证
			exit;
			$Apppay = new \Common\Util\Apppay();
			$_alipay = $_POST;
			$_result = $Apppay->notify($_alipay);
			if (empty($_result)) die('fail');

			if ($_alipay['trade_status'] == 'TRADE_FINISHED' || $_alipay['trade_status'] == 'TRADE_SUCCESS') {
				$map = array('trade_no'=>array('eq', $_alipay['out_trade_no']));
				$_order = M('order')->where($map)->order('id DESC')->find();
				if (empty($_order)) die('fail');
				if ($_order['status'] == 1) die('success');
				if ($_order['status'] == 2) die('success');
				if ($_order['money'] != $_alipay['total_amount']) die('fail');
				// 支付成功处理
				$this->pay_handle($_order);
			} else {
				die('fail');
			}
		}
		die('success');
	}

  	// APP端支付确认成功
	public function updateorder() {
		exit;
		$map = array('id'=>array('eq', $_REQUEST['id']));
				$_order = M('order')->where($map)->order('id DESC')->find();
				if (empty($_order)) die('fail');
				if ($_order['status'] == 1) die('success');
				if ($_order['status'] == 2) die('success');
				//if ($_order['money'] != $_alipay['total_amount']) die('fail');
				// 支付成功处理
				$this->pay_handle($_order);
	}
	// 支付测试 开发完一定要关闭
	public function notify_balabala() {
		exit;
		$map = array('trade_no'=>array('eq', I('get.trade_no')));
		$_order = M('order')->where($map)->order('id DESC')->find();
		if (empty($_order)) die('fail');
		if ($_order['status'] == 1) die('success');
		if ($_order['status'] == 2) die('success');
		// 支付成功处理
		$this->pay_handle($_order);
		die('success');
	}

	// 支付返回处理
	private function pay_handle($order) {
		$_result = M('order')->save(array(
			'id' => $order['id'],
			'pay_time' => NOW_TIME,
			'status' => 1,
		));
		if ($_result) {
			// 减库存
			$Product = M('product');
			$map = array('id'=>array('eq', $order['product_id']));
          if($order['product_id']>0){
          $_remain = $Product->where($map)->getField('remain');
			if ($_remain) $Product->where($map)->setDec('remain', 1);
          }else{
          //上级会员增加经验，活跃度等
           
            $this->zhitui($order);
          }
		
			return true;
		}
		return false;
	}
//上级会员增加经验活跃度等等
	// 测试支付推掉
	public function ceshihuidiao() {
		exit;
		$map = array('status'=>array('eq', 0));
		$_order = M('order')->where($map)->order('id DESC')->find();
	
		$this->pay_handle($_order);
		die('success');
	}
	private function zhitui($order) {
		// 本人
		 $User = M('user');
			$_user = $User->find($order['user_id']);
			$User->save(array(
				'id' => $order['user_id'],
				'status' => 1,
			));
        $userid=$_user['id'];
        if($_user['level']==0){
        	$User->save(array(
				'id' => $order['user_id'],
              'level' => 1,
			));
        	$invite_id=$_user['invite_id'];
        if($this->conf['jiben']['regsonghyd']>0){
         $return1 = addhuoyuedu($userid, 1, $this->conf['jiben']['regsonghyd'], '实名赠送活跃度');
        }
      //赠送基础卷轴任务
       $Mession = M('mission')->where(array('id'=>1))->find();
       $_result = M('user_mission')->add(array(
				'app_user_id' => $_user['id'],
				'mission_id' => 1,
               'huoyue' => $Mession['huoyue'],
               'step' => $Mession['step'],
              'start_date' => time(),
              'end_date' => time()+($Mession['term']*86400),
              'status' => 0,
			));
        if($invite_id){
        //发放直推奖励
        if($this->conf['jiben']['tgsonghyd']>0){
         addhuoyuedu($invite_id, 2, $this->conf['jiben']['tgsonghyd'], '推荐会员ID'.$userid.'奖励活跃度');
        }
        if($this->conf['jiben']['tgsonggxz']>0){
         addgongxian($invite_id, 1, $this->conf['jiben']['tgsonggxz'], '推荐会员ID'.$userid.'奖励');
        }
        //增加英雄活跃度团队活跃度
        if(!empty($_user['invites'])){
        M("user")->where('id in('.$_user['invites'].')')->setInc('tdhyd', 1);
        
        }
        }
        
      }

	}
	// 分销收益结算
	private function distrib($order) {
		// 若是快返 秒返分销配置
      exit;
		$map = array('id'=>array('eq', $order['product_id']));
		$type = M('product')->where($map)->getField('type');
		if ($type) $this->conf = array_merge($this->conf, array('distrib'=>$this->conf['distrib_sec']));

		if ($this->conf['distrib']['status'] == 1) {
			$level = count($this->conf['distrib']['level']);
			if ($level) {
				$User = M('user');
				// 本人
				$_user = $User->find($order['user_id']);
				// 团队
				$_team = array();
				// 本人消费返
				if ($this->conf['distrib']['self'] > 0) $_team[] = array(
					'uid' => $_user['id'],
					'rate' => $this->conf['distrib']['self'],
					'level' => 0,
				);
				$invite_id = $_user['invite_id'];
				for ($i=0; $i<$level; $i++) {
					if ($invite_id) {
						$invite_user = $User->find($invite_id);
						$_team[] = array(
							'uid' => $invite_id,
							'rate' => $this->conf['distrib']['level'][$i],
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
					$Distrib = M('distrib');
					foreach ($_team as $v) {
						$change = $order['money'] * $v['rate'] / 100;
						if ($change < 0.01) continue;

						M()->startTrans();
						$map = array('user_id'=>array('eq', $v['uid']));
						$_account = $Account->lock(true)->where($map)->find();

						$data = change_account($_account, $change, 12);
						if (is_string($data)) $this->ajaxReturn(array('status'=>0, 'msg'=>$data));

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
						$res3 = $Distrib->add(array(
							'user_id' => $data['user_id'],
							'order_id' => $order['id'],
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

	// 分红奖池
	private function bonus($order) {
		// 若是快返 不参与分红
      exit;
		$map = array('id'=>array('eq', $order['product_id']));
		$type = M('product')->where($map)->getField('type');
		if ($type) return false;

		$map = array('status'=>array('eq', 1));
		$_rate = M('bonus_level')->where($map)->sum('rate');
		if ($_rate) {
			$Bonus = M('bonus');
			$map = array('create_time'=>array('egt', strtotime(date('Y-m-d'))));
			$_exist = $Bonus->where($map)->find();
			if ($_exist) {
				$Bonus->save(array(
					'id' => $_exist['id'],
					'money' => $_exist['money'] + $order['money'] * $_rate / 100,
				));
			} else {
				$Bonus->add(array(
					'money' => $order['money'] * $_rate / 100,
					'create_time' => NOW_TIME,
				));
			}
		}
	}

}
