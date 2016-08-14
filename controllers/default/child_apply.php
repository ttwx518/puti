<?php

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}





    $seo = setSeo('智残儿童申请', $cfg_keyword, $cfg_description);



