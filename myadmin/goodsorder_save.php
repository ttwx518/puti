<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('goodsorder');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 16:33:57
  person: Feng
 * *************************
 */

//初始化参数
$tbname = '#@__goodsorder';
$gourl = 'goodsorder.php';
$action = isset($action) ? $action : '';

//引入操作类
require_once(ADMIN_INC . '/action.class.php');

//修改订单信息
if ($action == 'update') {

    //是否星标
    if (!isset($core))
        $core = '';

    //时间戳格式
    $updatetime = time();

    //订单状态
    if (isset($checkinfo))
        $checkinfo = implode(',', $checkinfo);
    else
        $checkinfo = '';
    
    $orderInfo = $dosql->GetOne("SELECT * FROM `$tbname` WHERE id=$id");
    
    $areas = listarea(-1);
    $provInfo = isset($areas[$address_prov]['dataname']) ? $areas[$address_prov]['dataname'] : '';
    $cityInfo = isset($areas[$address_city]['dataname']) ? $areas[$address_city]['dataname'] : '';
    $countryInfo = isset($areas[$address_country]['dataname']) ? $areas[$address_country]['dataname'] : '';
    $pccinfo =  $provInfo.$cityInfo.$countryInfo;
    $sql = "UPDATE `$tbname` SET name='$name', mobile='$mobile', prov='$address_prov', city='$address_city', 
            country='$address_country', pccinfo='$pccinfo', address='$address', zipcode='$zipcode', 
            paymode='$paymode', postmode='$postmode', postid='$postid', weight='$weight', cost='$cost', 
            amount='$amount', buyremark='$buyremark', sendremark='$sendremark', updatetime='$updatetime', 
            checkinfo='$checkinfo', core='$core' WHERE id=$id";
    
    if ($dosql->ExecNoneQuery($sql)) {
        header("location:$gourl");
        exit();
    }
    
}

//无条件返回
else {
    header("location:$gourl");
    exit();
}

?>