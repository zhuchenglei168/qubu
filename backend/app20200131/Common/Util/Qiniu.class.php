<?php
namespace Common\Util;
require_once (__DIR__ . "/Qiniu/autoload.php");
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;



class Qiniu {

   /**
 * 发送短信
 */
public function upload($config) {

// 要上传图片的本地路径
$filePath = $_FILES['imgFile']['tmp_name'];

$ext=$_FILES['imgFile']['name'];
// 上传到七牛后保存的文件名

       
            $key = md5(time().rand(1111,9999)).'.'.$ext;



// 需要填写你的 Access Key 和 Secret Key
$accessKey = 'rayljvuTIxOshPfrdr5xK0Rz_hUfPl1Jc_JkML2o';
$secretKey = 'Jl3S2Yi9pgUUHLQ1Qv8lzSZswBA-U3GLV_EZMXLb';
// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);
// 要上传的空间
$bucket = 'qubuhaiwai';
$domain = 'haiwai.yunding03.com';
$token = $auth->uploadToken($bucket);
// 初始化 UploadManager 对象并进行文件的上传
$uploadMgr = new UploadManager();
// 调用 UploadManager 的 putFile 方法进行文件的上传
list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
if ($err !== null) {
    echo ["err"=>1,"msg"=>$err,"data"=>""];
} else {
    //返回图片的完整URL
    return 'http://'.$domain.'/'.$ret['key'];
}

}

   /**
 * 发送短信
 */
public function appupload($config) {
foreach ( $_FILES as $name=>$file ) {
// 要上传图片的本地路径
$filePath = $file['tmp_name'];

$ext=$file['name'];	
}

// 上传到七牛后保存的文件名

       
            $key = md5(time().rand(1111,9999)).'_'.$ext;



// 需要填写你的 Access Key 和 Secret Key
$accessKey = 'rayljvuTIxOshPfrdr5xK0Rz_hUfPl1Jc_JkML2o';
$secretKey = 'Jl3S2Yi9pgUUHLQ1Qv8lzSZswBA-U3GLV_EZMXLb';
// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);
// 要上传的空间
$bucket = 'qubuguoji';
$domain = 'guonei.yunding03.com';
$token = $auth->uploadToken($bucket);
// 初始化 UploadManager 对象并进行文件的上传
$uploadMgr = new UploadManager();
// 调用 UploadManager 的 putFile 方法进行文件的上传
list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
if ($err !== null) {
    echo ["err"=>1,"msg"=>$err,"data"=>""];
} else {
    //返回图片的完整URL
    return 'http://'.$domain.'/'.$ret['key'];
}

}
}
