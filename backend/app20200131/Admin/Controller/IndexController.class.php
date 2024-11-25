<?php
namespace Admin\Controller;
// 首页控制器
class IndexController extends CommonController {

	// 入口
	public function index() {
		$this->display();
	}

	// demo
	public function demo() {
		$this->display();
	}

	// 系统信息
	public function main(){
		$data = array(
			'server_name' => I('server.SERVER_NAME'),
			'server_addr' => I('server.SERVER_ADDR'),
			'server_os' => PHP_OS,
			'server_software' => I('server.SERVER_SOFTWARE'),
			'php_sapi_name' => php_sapi_name(),
			'framework_version' => '<a class="btn btn-xs btn-info" href="http://thinkphp.cn" target="_blank">V'.THINK_VERSION.'</a> <a class="btn btn-xs btn-danger" href="http://document.thinkphp.cn/manual_3_2.html" target="_blank">开发手册</a>',
			'upload_limit' => ini_get('upload_max_filesize'),
			'execution_limit' => ini_get('max_execution_time').'秒',
			'server_time' => date('Y年n月j日 H:i:s'),
			'now_time' => gmdate('Y年n月j日 H:i:s', time() + 8 * 3600),
			'disk_free_space' => round((@disk_free_space('.') / (1024*1024)), 2).'M',
			'register_globals' => get_cfg_var('register_globals')=='1' ? 'ON' : 'OFF',
			'magic_quotes_gpc' => (1===get_magic_quotes_gpc()) ? 'YES' : 'NO',
			'magic_quotes_runtime' => (1===get_magic_quotes_runtime()) ? 'YES' : 'NO',
		);
		$this->assign('data', $data);

      $count['fk'] = M('fk')->count();
		$today = strtotime(date('Y-m-d'));
		$yestoday = $today - 86400;
		// 新增人数
		$map = array();
		$count['tgzs'] = M('user')->where($map)->sum('money');
		$count['hyzs'] = M('user')->where($map)->count();
		$map[] = array('status'=>array('eq', 1));
		$count['smzs'] = M('user')->where($map)->count();
		$map[] = array('create_time'=>array('between', array($yestoday, $today)));
		$count['user']['yestoday'] = M('user')->where($map)->count();
		// 入账
		$map = array('status'=>array('eq', 1));
		$count['income']['all'] = M('order')->where($map)->sum('money');
		$map[] = array('pay_time'=>array('egt', $today));
		$count['income']['today'] = M('order')->where($map)->sum('money');
		$map[] = array('pay_time'=>array('between', array($yestoday, $today)));
		$count['income']['yestoday'] = M('order')->where($map)->sum('money');
		// 提现
		$map = array('status'=>array('eq', 1));
		$count['cash']['all'] = M('cash')->where($map)->sum('money_real');
		$map[] = array('create_time'=>array('egt', $today));
		$count['cash']['today'] = M('cash')->where($map)->sum('money_real');
		$map[] = array('create_time'=>array('between', array($yestoday, $today)));
		$count['cash']['yestoday'] = M('cash')->where($map)->sum('money_real');
		// 分润
		$map = array('status'=>array('eq', 1));
		$count['profit']['all'] = M('profit')->where($map)->sum('money');
		$map = array('freeze_time'=>array('between', array($today, $today + 86400)));
		$count['profit']['today'] = M('profit')->where($map)->sum('money');
		$map = array('freeze_time'=>array('between', array($yestoday, $today)));
		$count['profit']['yestoday'] = M('profit')->where($map)->sum('money');

		$this->assign('count', $count);

		$this->display();
	}

}