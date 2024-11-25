<?php
namespace Common\Util;
require_once (__DIR__ . "/qcloudsms_php/src/index.php");


use Qcloud\Sms\SmsSingleSender;



class Alisms {

   /**
 * 发送短信
 */
public function sendSms($smscon) {

try {
  $ssender = new SmsSingleSender($smscon['username'], $smscon['password']);
  $result = $ssender->send(0, $smscon['quhao'], $smscon['phone'],
      "[QuBu]Your verification code is ".$smscon['code']."(valid for 5 minutes). For account safety, don't forward the code to others.", "", "");
  $rsp = json_decode($result);

   return true;
} catch(\Exception $e) {
  return false;
}
/*
    $params = array ();

    // *** 需用户填写部分 ***
    // fixme 必填：是否启用https
    $security = false;

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    $accessKeyId = $smscon['username'];
    $accessKeySecret = $smscon['password'];

    // fixme 必填: 短信接收号码
    $params["PhoneNumbers"] = $smscon['phone'];

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = $smscon['SignName'];

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = $smscon['TemplateCode'];

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
    $params['TemplateParam'] = Array (
        "code" => $smscon['code']
    );

    // fixme 可选: 设置发送短信流水号
   // $params['OutId'] = "12345";

    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
  //  $params['SmsUpExtendCode'] = "1234567";


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        )),
        $security
    );

    return $content;
    */
}

}
