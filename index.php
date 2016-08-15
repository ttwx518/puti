<?php

require_once(dirname(__FILE__) . '/include/config.inc.php');
$c = isset($c) ? $c : 'index';
// print_r($c);
// exit();

if (!file_exists(CONT_PATH . "{$c}.php")) {
    header("Location:index.php");
}

require_once CONT_PATH . "{$c}.php";

$tmplPath = TMPL_PATH;
$tmplFileName = $c;

if ($c == 'member') {
    $tmplPath .= 'member/';
    $tmplFileName = $a;
}
if ($c == 'activity') {
    $tmplPath .= 'activity/';
    $tmplFileName = $a;
}
if ($c == 'info') {
    $tmplPath .= 'info/';
    $tmplFileName = $a;
}
if (!file_exists($tmplPath . "{$tmplFileName}.php")) {
    header("Location:index.php");
}

//认购活动介绍
$activity_news = $dosql->GetOne("select * from `#@__infolist` where classid = '10' and id = '18' ");

//如果在微信中打开,加载微信分享
$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
if (strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false) {
    
} else {
    require_once(dirname(__FILE__) . '/include/wechat/jssdk.php');
    $jssdk = new JSSDK($cfg_wechat_appid, $cfg_wechat_appsecret);
    $signPackage = $jssdk->GetSignPackage();
    $shareInfo = array(
        'title' => $seo['pagetitle'],
        'desc' => $cfg_description ? $cfg_description : '',
        'link' => $cfg_weburl ? $cfg_weburl . 'index.php?c=member&a=qrcode&recUid=' . $userInfo['id'] : '',
        'imgUrl' => $cfg_weburl . 'html/images/logo.png',
        'type' => 'link'
    );
}

require_once $tmplPath . "{$tmplFileName}.php";

?>