<?php
/**
 * @param string $string 待防止XSS攻击的输入内容
 * @return string 处理后的输入内容
 */
function fangXSS($string)
{
    vendor('htmlpurifier.HTMLPurifier#auto');
    //生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    //以下就是配置
    $cfg->set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg->set('HTML.Allowed', 'div,b,strong,i,em,a[href|title],ul,ol,li,br,span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg->set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj->purify($string);
}

/******************递归方式获取上下级权限信息*************************/
function generateTree($data)
{
    $items = array();
    foreach ($data as $v) {
        $items[$v['auth_id']] = $v;
    }
    $tree = array();
    foreach ($items as $k => $item) {
        if (isset($items[$item['auth_pid']])) {
            $items[$item['auth_pid']]['son'][] =& $items[$k];
        } else {
            $tree[] =& $items[$k];
        }
    }
    return getTreeData($tree);
}

function getTreeData($tree, $level = 0)
{
    static $arr = array();
    foreach ($tree as $t) {
        $tmp = $t;
        unset($tmp['son']);
        $tmp['level'] = $level;
        $arr[] = $tmp;
        if(isset($t['son'])){
            getTreeData($t['son'],$level+1);
        }
    }
    return $arr;
}
/******************递归方式获取上下级权限信息*************************/

/****************************发送短信验证码*************************************/
function sendTemplateSMS($to,$datas,$tempId='1')
{
     // 初始化REST SDK
     global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;

     //主帐号,对应开官网发者主账号下的 ACCOUNT SID
     $accountSid= C('ACCOUNT_SID');

     //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
     $accountToken= C('ACCOUNT_TOKEN');

     //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
     //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
     $appId=C('APP_ID');

     //请求地址
     //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
     //生产环境（用户应用上线使用）：app.cloopen.com
     $serverIP='app.cloopen.com';


     //请求端口，生产环境和沙盒环境一致
     $serverPort='8883';

     //REST版本号，在官网文档REST介绍中获得。
     $softVersion='2013-12-26';
     include_once("./Application/Common/Plugin/sms/CCPRestSmsSDK.php");

     $rest = new REST($serverIP,$serverPort,$softVersion);
     $rest->setAccount($accountSid,$accountToken);
     $rest->setAppId($appId);
     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
     if($result == NULL ) {
         return false;
     }
     if($result->statusCode!=0) {
         return false;
     }else{
         return true;
     }
}
/****************************发送短信验证码*************************************/

/********************发送邮件*************************/
//mail发送方法
function sendMail( $sendAddress,$title, $msghtml) {
    //引入发送类phpmailer.php
    //include('.\ThinkPHP\Library\Vendor\PHPMailer\class.phpmailer.php');
    Vendor('PHPMailer.class#phpmailer');
    //实列化对象
    $mail = new PHPMailer();
    /*服务器相关信息*/
    $mail->IsSMTP(); //设置使用SMTP服务器发送
    $mail->SMTPAuth = true; //开启SMTP认证
    $mail->Host = 'smtp.163.com'; //设置 SMTP 服务器,自己注册邮箱服务器地址
    $mail->Username = 'phpztrtest'; //发信人的邮箱用户名
    $mail->Password = 'ztr2012dl'; //发信人的邮箱密码
    /*内容信息*/
    $mail->IsHTML(true); //指定邮件内容格式为：html
    $mail->CharSet = "UTF-8"; //编码
    $mail->From = 'phpztrtest@163.com'; //发件人完整的邮箱名称
    $mail->FromName = "php_ztr"; //发信人署名
    $mail->Subject = $title; //信的标题
    $mail->MsgHTML($msghtml); //发信主体内容
    // $mail->AddAttachment("fish.jpg");      //附件
    /*发送邮件*/
    $mail->AddAddress($sendAddress); //收件人地址
    //使用send函数进行发送
    if ($mail->Send()) {
        //发送成功返回真
        return true;
        // echo '您的邮件已经发送成功！！！';
    } else {
        return $mail->ErrorInfo; //如果发送失败，则返回错误提示
    }
}
/********************发送邮件*************************/

function request($url,$https=true,$method='get',$data=null){
    //1、初始化url
    $ch = curl_init($url);
    //2、设置相关参数
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    //判断是否为https请求
    if($https===true){
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    }
    //判断是否为post请求
    if($method=="post"){
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    //3、发送请求
    $str = curl_exec($ch);
    //4、关闭连接
    curl_close($ch);
    return $str;
}