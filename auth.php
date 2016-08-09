<?php

require_once (dirname(__FILE__) . '/include/config.inc.php');
require_once (dirname(__FILE__) . '/include/wechat.class.php');
$wechatConfig = array(
    'token' => $cfg_wechat_token,
    'appid' => $cfg_wechat_appid,
    'appsecret' => $cfg_wechat_appsecret,
    'debug' => false
);
$wechat = new wechat($wechatConfig);

//网页授权获取access_token
$code = $_GET['code'];

if (empty($code)) {
    exit();
}

$time = time();

$access_token = $wechat->get_oauth_access_token($code);

if (!$access_token || !empty($access_token['errcode'])) {
    echo "access_token error";
    exit();
}

//网页授权获取用户信息
$wechat_userinfo = $wechat->get_userinfo($access_token['access_token'], $access_token['openid']);

if (!$wechat_userinfo || !empty($wechat_userinfo['errcode'])) {
    echo "access_token error";
    exit();
}

$user_sql = "SELECT * FROM `#@__member` WHERE openid='{$access_token['openid']}'";

$ret = $dosql->GetOne($user_sql);

$privilege = unserialize($wechat_userinfo['privilege']);

$expires_in = $time + $access_token['expires_in'];

$regtime = $logintime = time();

$regip = $logip = GetIP();
Writef(PHPMYWIND_ROOT . '/auth.log', $wechat_userinfo['nickname']);
$wechat_userinfo['nickname'] = htmlspecialchars($wechat_userinfo['nickname']);
$wechat_userinfo['nickname'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $wechat_userinfo['nickname']);
$wechat_userinfo['nickname'] = replace_specialChar($wechat_userinfo['nickname']);
$wechat_userinfo['city'] = str_replace("'", "\'", $wechat_userinfo['city']);
Writef(PHPMYWIND_ROOT . '/auth.log', $wechat_userinfo['nickname']);

// 获取二维码
/* ------------------qrcode start------------------- */
$sceneid = $access_token['openid'];
$qrcode = $wechat->getQRCode($sceneid, 2);
$ticket = $qrcode['ticket'];
$qrurl = $wechat->getQRUrl($qrcode['ticket']);
/* ------------------qrcode end------------------- */

if (!empty($ret)) {
    $sql = "UPDATE `#@__member` SET 
            logintime='{$logintime}',
            loginip='{$logip}',
            wechat_nickname='{$wechat_userinfo['nickname']}',
            wechat_sex='{$wechat_userinfo['sex']}',
            wechat_province='{$wechat_userinfo['province']}',
            wechat_city='{$wechat_userinfo['city']}',
            wechat_country='{$wechat_userinfo['country']}',
            wechat_headimgurl='{$wechat_userinfo['headimgurl']}',
            wechat_privilege='{$privilege}',
            wechat_unionid='{$wechat_userinfo['unionid']}',
            wechat_expires_in='{$expires_in}',
            wechat_qrurl='{$qrurl}',
            wechat_ticket='{$ticket}'
            WHERE openid='{$access_token['openid']}'";
} else {
    $recUid = isset($_COOKIE['recUid']) ? $_COOKIE['recUid'] : 0;
    $recUid2 = 0;
    $recUserExist = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUid}");
    if ($recUserExist) {
        $recUser2Exist = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUserExist['recUid']}");
        if ($recUser2Exist) {
            $recUid2 = $recUser2Exist['id'];
        }
    } else {
        $recUid = 0;
    }
    $sql = "INSERT INTO `#@__member` 
            (group_id,recUid,recUid2,regtime,regip,logintime,loginip,openid,wechat_nickname,wechat_sex,wechat_province,wechat_city,
            wechat_country,wechat_headimgurl,wechat_privilege,wechat_unionid,wechat_expires_in,wechat_qrurl,wechat_ticket) 
            VALUES 
            (1,$recUid,$recUid2,$regtime,'$regip',$logintime,'$logip','{$access_token['openid']}','{$wechat_userinfo['nickname']}','{$wechat_userinfo['sex']}',
            '{$wechat_userinfo['province']}','{$wechat_userinfo['city']}','{$wechat_userinfo['country']}',
            '{$wechat_userinfo['headimgurl']}','{$privilege}','{$wechat_userinfo['unionid']}',$expires_in,'{$qrurl}','{$ticket}')";
}

$dosql->ExecNoneQuery($sql);

$cookie_time = time() + 86400 * 7; //记住登录一周
setcookie('openid', AuthCode($access_token['openid'], 'ENCODE'), $cookie_time);
//if(!$userInfo || !$userInfo['isImprove']){
//    redirect('index.php?c=improve');
//}
$backUrl = getCookie('backUrl');
redirect($backUrl);
?>