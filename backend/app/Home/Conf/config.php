<?php
return array(

	// 主题配置
	'VIEW_PATH'					=> './themes/',
	'DEFAULT_THEME'				=> 'default',
	'TMPL_LOAD_DEFAULTTHEME'	=> true,
	'TMPL_FILE_DEPR'			=> '_',
	'TMPL_ACTION_SUCCESS'		=> 'Public:jump',
	'TMPL_ACTION_ERROR'			=> 'Public:jump',

	// 开启路由
	'URL_ROUTER_ON'				=> true,
	'URL_ROUTE_RULES'			=> array(
		'/^invest$/'			=> 'index/invest',
		'/^buy\/(\d+)$/'		=> 'user/buy?id=:1',
		'/^help\/(\w+)$/'		=> 'help/detail?slug=:1',
	),

);
