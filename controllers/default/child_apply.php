<?php

//定义入口常量
define('IN_MEMBER', TRUE);

//初始化参数
$a = isset($a) ? $a : 'default';

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}


    $seo = setSeo('智残儿童申请', $cfg_keyword, $cfg_description);



