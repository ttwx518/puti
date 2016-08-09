<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

$tid = empty($tid)?1:intval($tid);

//BANNER
$banners = array();
$dosql->Execute("SELECT title,picurl,linkurl FROM `#@__admanage` WHERE classid=1 AND admode='image' AND checkinfo='true' ORDER BY orderid ASC");
while ($row = $dosql->GetArray()) {
    $banners[] = $row;
}

// 种子商城
$goods = array();
$dosql->Execute("SELECT weight,id,picurl,title,colorval,boldval,flag,salesprice,salesprice_dashi,salesprice_tianshi,salenum,starttime,endtime,typeid FROM `#@__goods` WHERE (typeid={$tid} or typepid={$tid}) AND checkinfo='true' AND delstate='' ORDER BY orderid DESC limit 0, 20","goods");
while ($row = $dosql->GetArray('goods')) {
    $price = calcPrice($row);
    if(!empty($price)){
        $row['salesprice'] = $price;
    }
    $goods[] = $row;
}
//秒杀 当前时间
$time = time();

//限时团购
// $time = time();
// $t_goods = array();
// $dosql->Execute("SELECT id,picurl,title,colorval,boldval,flag,salesprice,marketprice FROM `#@__goods` WHERE typeid={$cid} AND checkinfo='true' AND delstate='' ORDER BY orderid DESC limit 0, 10");
// while ($row = $dosql->GetArray()) {
//     $t_goods[] = $row;
// }
//积分商城
// $j_goods = array();
// $dosql->Execute("SELECT id,picurl,title,colorval,boldval,flag,salesprice,marketprice FROM `#@__goods` WHERE typeid={$cid} AND checkinfo='true' AND delstate='' ORDER BY orderid DESC limit 0, 10");
// while ($row = $dosql->GetArray()) {
//     $j_goods[] = $row;
// }

$seo = setSeo($cfg_webname, $cfg_keyword, $cfg_description);

?>