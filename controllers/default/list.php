<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

$id = isset($id) ? intval($id) : 0;    
$catInfo = $dosql->GetOne("SELECT id,classname FROM `#@__goodstype` WHERE checkinfo = 'true' AND id={$id}");
if(!$catInfo){
    ShowMsg("该商品档期不存在噢");exit();
}

$goods = getGoodsList(1, $id);

$seo = setSeo($catInfo['classname'], $cfg_keyword, $cfg_description);

?>