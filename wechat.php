<?php

require_once(dirname(__FILE__) . '/include/config.inc.php');
require_once(PHPMYWIND_INC . '/wechat.class.php');

$wechatConfig = array(
    'token' => $cfg_wechat_token,
    'appid' => $cfg_wechat_appid,
    'appsecret' => $cfg_wechat_appsecret,
    'debug' => false
);

$wechat = new wechat($wechatConfig);

$wechat->responseMsg();
