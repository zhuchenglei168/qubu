<?php
/**
 * AOP SDK 入口文件
 * 请不要修改这个文件，除非你知道怎样修改以及怎样恢复
 * @author wuxiao
 */

/**
 * 定义常量开始
 * 在include("AopSdk.php")之前定义这些常量，不要直接修改本文件，以利于升级覆盖
 */
/**
 * SDK工作目录
 * 存放日志，AOP缓存数据
 */
if (!defined("AOP_SDK_WORK_DIR"))
{
	define("AOP_SDK_WORK_DIR", "/tmp/");
}
/**
 * 是否处于开发模式
 * 在你自己电脑上开发程序的时候千万不要设为false，以免缓存造成你的代码修改了不生效
 * 部署到生产环境正式运营后，如果性能压力大，可以把此常量设定为false，能提高运行速度（对应的代价就是你下次升级程序时要清一下缓存）
 */
if (!defined("AOP_SDK_DEV_MODE"))
{
	define("AOP_SDK_DEV_MODE", true);
}
/**
 * 定义常量结束
 */

/**
 * 去除lotusphp框架
 */
define('AOP_HOME', dirname(__FILE__) . DIRECTORY_SEPARATOR . "aop" . DIRECTORY_SEPARATOR);
include(AOP_HOME . "AlipayMobilePublicMultiMediaClient.php");
include(AOP_HOME . "AopClient.php");
include(AOP_HOME . "EncryptParseItem.php");
include(AOP_HOME . "EncryptResponseData.php");
include(AOP_HOME . "SignData.php");
include(AOP_HOME . "LtLogger.php");
function loadClass($class) {
	include(AOP_HOME . "request/".$class.".php");
}
spl_autoload_register("loadClass");