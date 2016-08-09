<?php

//获取所有商品分类
$cats = array();
$pid=empty($pid)?4:intval($pid);
$dosql->Execute("SELECT * FROM `#@__goodstype` WHERE `checkinfo`='true' AND parentid = {$pid} ORDER BY orderid ASC", 'cat');
while ($row = $dosql->GetArray('cat')) {
    $cats[] = $row;
}
// 默认加载第一个父类下得分类（点击父类，显示对应的子类）
if (empty($tid)) {
    $tid = $cats[0]['id'];
}

$goods = array();
$dosql->Execute("SELECT * FROM `#@__goods` WHERE `checkinfo`='true' AND typeid = '{$tid}' order by orderid", 'goods');
while ($row = $dosql->GetArray('goods')) {
    $goods[] = $row;
}

$goodstype = $dosql->GetOne("SELECT * FROM `#@__goodstype` WHERE id = '{$pid}' ");
$seo = setSeo($goodstype['classname'], $cfg_keyword, $cfg_description);

?>