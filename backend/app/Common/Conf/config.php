<?php
return array(

/**************************** 初始化配置 ****************************/

	'SHOW_PAGE_TRACE'		=> false,
	'MODULE_ALLOW_LIST'		=> array('Home', 'Pyztgp'),
	'URL_MODULE_MAP'		=> array('pyztgp'=>'admin'),
	'URL_MODEL'				=> 2,
	'URL_HTML_SUFFIX'		=> '',

/**************************** 数据库配置

	'DB_TYPE'				=> 'mysql',
	'DB_DSN'				=> 'mysql:host=rm-rj9y1ao1j2jemuowvdo.mysql.rds.aliyuncs.com:3306;dbname=qubugj;charset=utf8mb4',
	'DB_PREFIX'				=> 'm_',
	'DB_USER'				=> 'qubu_07rjm_1109',
	'DB_PWD'				=> 'f6XJ2z3pMMadJM4i!@#$%^&*()_+-=',

 ****************************/
 
 	'DB_TYPE'				=> 'mysql',
	'DB_DSN'				=> 'mysql:host=localhost;dbname=www_07rjm_cn;charset=utf8mb4',
	'DB_PREFIX'				=> 'm_',
	'DB_USER'				=> 'www_07rjm_cn',
	'DB_PWD'				=> 'EdKrsTcT3RpWScMZ',
/**************************** Session配置 ****************************/

	'SESSION_AUTO_START'	=> false,
	'SESSION_TYPE'			=> 'Memcache',
	'SESSION_OPTIONS'		=> array(
		'name'				=> 'user_session',
		'prefix'			=> 'sess_',
		'expire'			=> '86400',
		// 'domain'			=> '.demo.com'
	),

/**************************** 缓存配置 ****************************/

	'MEMCACHE_HOST'			=> '127.0.0.1',
	'MEMCACHE_PORT'			=> '11211',

/**************************** 子域名配置 ****************************/

	'APP_SUB_DOMAIN_DEPLOY'	=> false,
	'APP_SUB_DOMAIN_RULES'	=> array(
		'api.demo.com'		=> 'Api'
	),

/**************************** 业务配置 ****************************/

	// HASH密钥
	'HASHKEY'				=> 'tF6omtfh5khILqhJ',
	// 微信授权
	'WECHAT_AUTH'			=> false,
	// CDN前缀
	'CDN_PREFIX'			=> '',
	// 二维码前缀
	'CODE_PREFIX'			=> 'http://www.demo.com',
	// 超级提现用户
	'ADMIN_CASH'			=> '',
	// 支付宝
	'ALIPAY'				=> array(
		// 支付宝网关
		'gatewayUrl' => 'https://openapi.alipay.com/gateway.do',
		// 编码格式
		'charset' => 'UTF-8',
		// 签名方式
		'sign_type' => 'RSA2',
		// 同步跳转地址
		'return_url' => 'http://www.demo.com/pay/return',
		// 异步通知地址
		'notify_url' => 'http://www.demo.com/pay/notify',
	),

);
