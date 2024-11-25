<?php

// 打印函数
function p($var) {
	dump($var, 1, '<pre>', 0);
	die;
}

// 生成配置文件
function conf($name, $value, $path=CONF_PATH) {
	$filename = $path . $name . '.php';
	return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
}

// CDN支持
function cdn($path) {
	if (C('CDN_PREFIX') && strpos($path, '//') === false) $path = C('CDN_PREFIX') . $path;
	return $path;
}

// 增强加密函数
function get_sha($str) {
	return sha1(strrev(md5($str) . C('HASHKEY')));
}

// 随机获取指定位数字验证码
function get_vcode($length) {
	while(($code = mt_rand() % pow(10, $length)) < pow(10, $length-1));
	return $code;
}
//获取随机个数的字符串
function getrandomstring($len,$chars=null){
if(is_null($chars)){
$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
}
mt_srand(1000*(double)time());
$str = '';
for($i = 0,$lc = strlen($chars)-1;$i<$len;$i++){
$str.= $chars[mt_rand(0,$lc)];
}
return $str;
}
// 获取指定范围指定个数的随机数
function get_num($min, $max, $length) {
	$nums = array();
	$flag = true;
	while ($flag) {
		$num = mt_rand($min, $max);
		if (!in_array($num, $nums)) $nums[] = $num;
		if (count($nums) == $length) $flag = false;
	}
	return $nums;
}

// 隐藏字符
function get_hide($string, $start, $end) {
	for ($i=$start; $i<=$end; $i++) { 
		$string[$i] = '*';
	}
	return $string;
}

// 获取目录列表
function get_dirs($dir) {
	$dirs = array();
	if (false != ($handle = opendir($dir))) {
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..' && strpos($file, '.') === false) {
				$dirs[] = $file;
			}
		}
	}
	closedir($handle);
	return $dirs;
}

// 获取文件列表
function get_files($dir) {
	$files = array();
	if (false != ($handle = opendir($dir))) {
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..' && strpos($file, '.')) {
				$files[] = $file;
			}
		}
	}
	closedir($handle);
	return $files;
}

// 获取替换值
function get_stead($var, $stead=array()) {
	if ($stead) {
		return $stead[$var];
	} else {
		switch ($var) {
			case 0: return '<i class="fa fa-fw fa-close text-danger"></i>';
			case 1: return '<i class="fa fa-fw fa-check text-success"></i>';
			default: return '';
		}
	}
}
// 百度API报错
function baiduapierr($code) {

		switch ($code) {
			case 222201: return '服务端请求失败';
			case 222202: return '图片中没有人脸';
            case 222203: return '无法解析人脸';
            case 222204: return '系统繁忙 稍后再试';
            case 222205: return '服务端请求失败';
            case 222206: return '服务端请求失败';
            case 222207: return '未找到匹配的用户';
            case 222208: return '图片的数量错误';
            case 222209: return 'face token不存在';
            case 222300: return '人脸图片添加失败';
            case 222301: return '获取人脸图片失败';
            case 222302: return '服务端请求失败';
            case 222303: return '获取人脸图片失败';
            case 223100: return '操作的用户组不存在';
            case 223101: return '该用户组已存在';
            case 223102: return '该用户已存在';
            case 223103: return '找不到该用户';
            case 223104: return 'group_list包含组数量过多';
            case 223105: return '该人脸已存在';
            case 223106: return '该人脸不存在';
            case 223110: return 'uid_list包含数量过多';
            case 223111: return '目标用户组不存在';
            case 223112: return 'quality_conf格式不正确';
            case 223113: return '人脸有被遮挡';
            case 223114: return '人脸模糊';
            case 223115: return '人脸光照不好';
            case 223116: return '人脸不完整';
            case 223117: return 'app_list包含app数量过多';
            case 223118: return '质量控制项错误';
            case 223120: return '活体检测未通过';
            case 223121: return '质量检测未通过 左眼遮挡程度过高';
            case 223122: return '质量检测未通过 右眼遮挡程度过高';
            case 223123: return '质量检测未通过 左脸遮挡程度过高';
            case 223124: return '质量检测未通过 右脸遮挡程度过高';
            case 223125: return '质量检测未通过 下巴遮挡程度过高';
            case 223126: return '质量检测未通过 鼻子遮挡程度过高';
            case 223127: return '质量检测未通过 嘴巴遮挡程度过高';
            case 222304: return '图片尺寸太大';
            case 222307: return '图片非法 鉴黄未通过';
            case 222308: return '图片非法 含有政治敏感人物';
            case 222211: return '人脸融合失败 模板图质量不合格';
            case 223129: return '人脸未面向正前方（人脸的角度信息大于30度）';
			default: return '参数格式错误，请再次点击提交认证信息';
		}

}
// 中文截取
function get_substr($string, $length, $dot='...') {
	$charset = 'utf8';
	if(strlen($string) <= $length) { return $string; }
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf8') {
		$n = $tn = $noc = 0;
		while ($n < strlen($string)) {
			$t = ord($string[$n]);
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif (194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif (224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif (240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif (248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif ($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if ($noc >= $length) {
				break;
			}
		}
		if ($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
	} else {
		for ($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}

// 时间友好显示
function get_formattime($time) {
	$now = time();
	$day = date('Y-m-d',$time);
	$today = date('Y-m-d');
	
	$dayArr = explode('-',$day);
	$todayArr = explode('-',$today);
	
	//距离的天数，这种方法超过30天则不一定准确，但是30天内是准确的，因为一个月可能是30天也可能是31天
	$days = ($todayArr[0]-$dayArr[0])*365+(($todayArr[1]-$dayArr[1])*30)+($todayArr[2]-$dayArr[2]);
	//距离的秒数
	$secs = $now-$time;
	
	if ($todayArr[0]-$dayArr[0]>0 && $days>3) {//跨年且超过3天
		return date('Y-m-d', $time);
	} else {
		if ($days<1) {//今天
			if ($secs<60)
				return $secs.'秒前';
			elseif ($secs<3600)
				return floor($secs/60)."分钟前";
			else
				return floor($secs/3600)."小时前";
		} elseif ($days<2){//昨天
			$hour = date('h',$time);
			return "昨天".$hour.'点';
		} elseif ($days<3){//前天
			$hour = date('h',$time);
			return "前天".$hour.'点';
		} else {//三天前
			return date('m月d号',$time);
		}
	}
}

// 是否是用户名---数字、26个英文字母或者下划线组成，长度在5~16之间
function is_username($str) {
	return preg_match('/^\w{4,15}$/smi', $str);
}

// 是否是密码---字母开头，长度在6~18之间，只能包含字符、数字和下划线
function is_password($str) {
	return preg_match('/^[a-zA-Z]\w{5,17}$/smi', $str);
}

// 是否是汉字---utf8
function is_chinese($str) {
	return preg_match('/^[\u4e00-\u9fa5]{0,}$/smi', $str);
}

// 是否是邮箱地址
function is_email($str) {
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}

// 是否是手机号码
function is_phone($phone) {
	if (!is_numeric($phone)) return false;
	return preg_match('/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,3,5,6,7,8]{1}\d{8}$|^18[\d]{9}$/', $phone) ? true : false;
}

// 是否是url
function is_url($str) {
	return filter_var($str, FILTER_VALIDATE_URL);
}

// 是否是http_url
function is_http_url($str) {
	return (filter_var($str, FILTER_VALIDATE_URL) && substr($str, 0, 7) == 'http://') ? true : false;
}

// 是否是https_url
function is_https_url($str) {
	return (filter_var($str, FILTER_VALIDATE_URL) && substr($str, 0, 8) == 'https://') ? true : false;
}

// 是否微信浏览器打开
function is_wechat() {
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) return true;
	return false;
}

// 价格去0
function trim_price($price) {
  if (strpos($price, '.')) {
    $price = rtrim(rtrim($price, '0'), '.');
  }
  return $price;
}

// 生成订单号
function trade_no() {
	return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 12);
}

// 余额变动
function change_account($account, $change, $type) {
	if (empty($account)) return '系统繁忙，请稍后再试~';
	switch ($type) {
		case 1://申请提现
			if ($change > $account['used']) return '可提现金额不足';
			$data = array(
				'id' => $account['id'],
				'user_id' => $account['user_id'],
				'total' => $account['total'] - $change,
				'freeze' => $account['freeze'] + $change,
				'used' => $account['used'] - $change,
			);
			break;
		case 2://提现成功
			$data = array(
				'id' => $account['id'],
				'user_id' => $account['user_id'],
				'total' => $account['total'],
				'freeze' => $account['freeze'] - $change,
				'used' => $account['used'],
			);
			break;
		case 3://提现取消
			if ($account['freeze'] < $change) return '账户异常，请联系客服';
			$data = array(
				'id' => $account['id'],
				'user_id' => $account['user_id'],
				'total' => $account['total'] + $change,
				'freeze' => $account['freeze'] - $change,
				'used' => $account['used'] + $change,
			);
			break;
		case 4://余额支付
			$data = array(
				'id' => $account['id'],
				'user_id' => $account['user_id'],
				'total' => $account['total'] - $change,
				'freeze' => $account['freeze'],
				'used' => $account['used'] - $change,
			);
			break;
		case 11://分润收益
		case 12://分销收益
		case 13://分红收益
		case 14://分润返点
			$data = array(
				'id' => $account['id'],
				'user_id' => $account['user_id'],
				'total' => $account['total'] + $change,
				'freeze' => $account['freeze'],
				'used' => $account['used'] + $change,
			);
			break;
	}
	$data['type'] = $type;

	return $data;
}
// 资金变动明细
function addaccount($uid, $type, $change, $brief) {
   // die();
	$accountlog = M('account_log');
	$User = M('user');
  	$map = array('id'=>$uid);
  $_user = $User->where($map)->find();
     $res1=$User->save(array(
                      'id' => $_user['id'],
               'wallet' => $_user['wallet']+$change,
				));

  $res2 = $accountlog->add(array(
				'user_id' => $_user['id'],
				'change' => $change,
				'total' => $_user['wallet']+$change,
				'type' => $type,
				'brief' => $brief,
				'create_time' => time(),
			));
  if($res1&&$res2){
  return true;
  }else{
  return false;
  }
	
}

// 糖果变动明细
function addtangguo($uid, $type, $change, $brief) {
   // die();
	$accountlog = M('tangguo_log');
	$User = M('user');
  	$map = array('id'=>$uid);
  $_user = $User->where($map)->find();
  if($_user['id']>0){
  	     $res1=$User->save(array(
                      'id' => $_user['id'],
               'money' => $_user['money']+$change,
				));

  $res2 = $accountlog->add(array(
				'user_id' => $_user['id'],
				'change' => $change,
				'total' => $_user['money']+$change,
				'type' => $type,
				'brief' => $brief,
				'create_time' => time(),
			));
  if($res1&&$res2){
  return true;
  }else{
  return false;
  }
	
  }

}
// 贡献变动明细
function addgongxian($uid, $type, $change, $brief) {
   // die();
	$accountlog = M('gongxian_log');
	$User = M('user');
  	$map = array('id'=>$uid);
  $_user = $User->where($map)->find();
   if($_user['id']>0){
  	 $res1=$User->save(array(
                      'id' => $_user['id'],
               'gongxian' => $_user['gongxian']+$change,
				));
 $nextdengji=$_user['level']+1;
  if($nextdengji<=5&&$nextdengji>=2){
  $level= M('bonus_level');
  	$map1 = array('id'=>$nextdengji);
  $levelinfo = $level->where($map1)->find();
    if($_user['gongxian']+$change>=$levelinfo['num']){
      $User->save(array(
                      'id' => $_user['id'],
               'level' => $nextdengji,
				));
    }
  }
  $res2 = $accountlog->add(array(
				'user_id' => $_user['id'],
				'change' => $change,
				'total' => $_user['gongxian']+$change,
				'type' => $type,
				'brief' => $brief,
				'create_time' => time(),
			));
  if($res2){
  return true;
  }else{
  return false;
  }
  }
 
	
}

// 活跃度变动明细
function addhuoyuedu($uid, $type, $change, $brief) {
   // die();
	$accountlog = M('huoyuedu_log');
	$User = M('user');
  	$map = array('id'=>$uid);
  $_user = $User->where($map)->find();
if($_user['id']>0){
 $res1=$User->save(array(
                      'id' => $uid,
               'huoyuedu' => $_user['huoyuedu']+$change,
				));

  $res2 = $accountlog->add(array(
				'user_id' => $_user['id'],
				'change' => $change,
				'total' => $_user['huoyuedu']+$change,
				'type' => $type,
				'brief' => $brief,
				'create_time' => time(),
			));
  if($res2){
  return true;
  }else{
  return false;
  }
}	
}
// 获取团队
function get_team($uid, $level, $consume=false, $field=false) {
	$User = M('user');
	$team = array();
	if ($level > 0) {
		$ids = array($uid);
		for ($i=0; $i < $level; $i++) {
			$map = array('invite_id'=>array('in', $ids));
			// 有消费
			$ids = $User->where($map)->getField('id', true);
			if ($ids) {
				$team[] = $field ? $User->field("$field")->where($map)->select() : $ids;
			} else {
				break;
			}
		}
	}
	return $team;
}

// 各级别奖池金额
function level_bonus($level, $bonus) {
	$total = 0;
	foreach ($level as $v) {
		$total += $v['rate'];
	}
	foreach ($level as $k=>$v) {
		$level_bonus[$v['id']] = round($bonus * $v['rate'] / $total, 2);
	}
	return $level_bonus;
}

// 获取用户本次分红信息
function user_level($level, $num) {
	foreach ($level as $v) {
		if ($num >= $v['num']) {
			$user_level = $v['id'];
		} else {
			break;
		}
	}
	return $user_level;
}


