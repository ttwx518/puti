<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}
$action = isset($action) ? $action : 'checkout';

if($action == 'checkout') {

    $id  = isset($id) ? $id : 0;
    $buynum = isset($buynum) ? $buynum : 1;
    $activity_info = $dosql->GetOne("select * from `#@__infolist` where id = '$id'");
    if($activity_info['classid'] == 5) {
        $activity_info['order_type'] = 2; //认养
    } elseif($activity_info['classid'] == 8) {
        $activity_info['order_type'] = 3; //认购
    }
    $activity_info['total_num'] = $buynum;
    $activity_info['totalAmount'] = $activity_info['goodsprice'] * $buynum;
    if($activity_info['totalAmount'] >= $cfg_freight_free){
        $activity_info['yunfei'] = 0;
    } else {
        $activity_info['yunfei'] = $cfg_freight;
    }
    $activity_info['buy_code'] = rand(1,9).date("md",time()).rand(time(),-5);

}
//结算
elseif($action == 'check_order') {
    $param = $_POST;
    $nowTime = time();
    //订单号
    $ordernum = MyDate('YmdHis', $nowTime) . mt_rand(10000, 99999);
    //订单状态
    $checkinfo[] = 'confirm';
    $useintegral = isset($param['useintegral']) ? $param['useintegral'] : 0;
    // 活动发起者ID
    $aid=empty($param['aid'])?0:intval($param['aid']);
    // 查找活动
    $infolist = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE id={$aid}");
    $goods_amount = round($infolist['goodsprice'] * $param['totalNum'],2);
    $checkinfoStr = implode(',', $checkinfo);
    if($goods_amount + $param['yunfei'] > $useintegral){
        $amount = $goods_amount + $param['yunfei'] - $useintegral;
    } else {
        $amount = 0;
        $useintegral = $goods_amount + $param['yunfei'];
    }

    $order_type = -1;
    if($infolist['classid'] == 5){
        $order_type = 2; //认养
    } elseif($infolist['classid'] == 8) {
        $order_type = 3; //认养
    }

    $orderSql = "INSERT INTO `#@__goodsorder`
                    (uid, recUid, recUid2, ordernum, `name`, mobile, address,
                     paymode, cost, goodsAmount, amount, goodsNames, checkinfo,createtime, updatetime, useintegral,auid,aid,order_type,buy_year,buy_code)
                    VALUES
                    ('{$userInfo['id']}', '{$userInfo['recUid']}', '{$userInfo['recUid2']}', '{$ordernum}',  '{$param['name']}',
                     '{$param['mobile']}', '{$param['address']}','{$param['paymode']}',  '{$param['yunfei']}',
                     '$goods_amount', '{$amount}','{$infolist['title']}', '{$checkinfoStr}', '{$nowTime}', '{$nowTime}', '$useintegral',{$infolist['auid']},$aid,'$order_type',
                     '{$param['buy_year']}','{$param['buy_code']}')";

    $orderInsertResult = $dosql->ExecNoneQuery($orderSql);
    if($orderInsertResult){
        //订单提交成功
        $insertId = $dosql->GetLastID();
        $dosql->ExecNoneQuery("INSERT INTO `#@__goodsorderitem`
                                          (orderid, gid, picurl, title, salesprice, directCommission,
                                          indirectCommission, buyNum) VALUES ('{$insertId}', '{$aid}',
                                          '{$infolist['picurl']}', '{$infolist['title']}',
                                          '{$infolist['goodsprice']}', '0', '0', '{$param['totalNum']}')");

        if($amount > 0){
            redirect('topay/wechatpay/js_api_call.php?ordernum='.$ordernum);
            exit;
        } else {
            $checkinfo[] = 'payment'; //抵扣支付
            $checkinfoStr = implode(',',$checkinfo);
            $dosql->ExecNoneQuery("update `#@__goodsorder` set checkinfo = '$checkinfoStr' where id = '$insertId' ");
            redirect('index.php?c=member&a=paySuccess&ordernum='.$ordernum);
            exit;
        }



    }


}



$seo = setSeo('订单结算', $cfg_keyword, $cfg_description);

?>