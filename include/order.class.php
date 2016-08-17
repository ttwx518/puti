<?php

if (!defined('IN_PHPMYWIND'))
    exit('Request Error!');

$doorder = new order();

class order {

    function __construct() {
        $this->Init();
    }

    function order() {
        $this->__construct();
    }

    function Init() {

        //初始化类
    }
    
    /**
     * 取消订单
     * @global object $dosql
     * @param int $id 订单id
     * @return array $result
     */
    public function cancelOrder($id){
        global $dosql;
        $orderInfo = $dosql->GetOne("SELECT * FROM `#@__goodsorder` WHERE delstate='' AND id={$id}");
        if (!$orderInfo) {
            $result = array('status' => false, 'msg' => '无效的订单');
        } else {
            $checkinfo = explode(',', $orderInfo['checkinfo']);
            if (!in_array('cancel', $checkinfo)) {
                $checkinfo[] = 'cancel';
                $checkinfo = implode(',', $checkinfo);
                $dosql->ExecNoneQuery("UPDATE `#@__goodsorder` SET checkinfo='{$checkinfo}' WHERE id={$id}");
            }
            $result = array('status' => true, 'msg' => '订单取消成功');
        }
        return $result;
    }
    
    /**
     * 订单收货
     * @global object $dosql
     * @param int $id 订单id
     * @return array $result
     */
    public function getGoods($id){
        global $dosql;
        $orderInfo = $dosql->GetOne("SELECT * FROM `#@__goodsorder` WHERE delstate='' AND id={$id}");
        if(!$orderInfo){
            $result = array('status' => false, 'msg' => '无效的订单');
        }else{
            $checkinfo = explode(',', $orderInfo['checkinfo']);
            if(!in_array('getgoods', $checkinfo)){
                $checkinfo[] = 'getgoods';
                $checkinfo[] = 'overorder';
                $checkinfo = implode(',', $checkinfo);
                $dosql->ExecNoneQuery("UPDATE `#@__goodsorder` SET checkinfo='{$checkinfo}' WHERE id={$id}");
            }
            $result = array('status' => true, 'msg' => '订单收货成功');
        }
        return $result;
    }
    
    /**
     * 订单支付成功
     * @global object $dosql
     * @param array $orderInfo 订单信息
     */
    public function orderPaySuccess($orderInfo){
        global $dosql,$cfg_wechat_token,$cfg_wechat_appid,$cfg_wechat_appsecret;
        $nowTime = time();
        $checkinfo = explode(',', $orderInfo['checkinfo']);
        if (!in_array('payment', $checkinfo)) {
            //上家
            $recUserInfo1 = $dosql->GetOne("SELECT m.id,m.group_id,m.username,m.truename,m.wechat_nickname,m.openid,g.stars FROM #@__member m LEFT JOIN #@__usergroup g ON m.group_id=g.id WHERE m.id={$orderInfo['recUid']}");
            //上上家
            $recUserInfo2 = $dosql->GetOne("SELECT m.id,m.group_id,m.username,m.truename,m.wechat_nickname,m.openid,g.stars FROM #@__member m LEFT JOIN #@__usergroup g ON m.group_id=g.id WHERE m.id={$orderInfo['recUid2']}");
            //更新订单状态
            $checkinfo[] = 'payment';
            $tmp = implode(',', $checkinfo);
            $dosql->ExecNoneQuery("UPDATE `#@__goodsorder` SET checkinfo='{$tmp}' WHERE id={$orderInfo['id']}");
            //更新商品销量 实际销量 库存减少
            $dosql->Execute("SELECT * FROM `#@__goodsorderitem` WHERE orderid={$orderInfo['id']}");
            while ($row = $dosql->GetArray()) {
                $dosql->ExecNoneQuery("UPDATE `#@__goods` SET salenum=salenum+{$row['buyNum']} WHERE id={$row['gid']}");
                $dosql->ExecNoneQuery("UPDATE `#@__goods` SET actualsales=actualsales+{$row['buyNum']} WHERE id={$row['gid']}");
                //减少库存
                if($row['housenum'] > 0 ) {
                    $dosql->ExecNoneQuery("UPDATE `#@__goods` SET housenum=housenum-{$row['buyNum']} WHERE id={$row['gid']}");
                }

            }
            $userInfo = $dosql->GetOne("SELECT * FROM #@__member WHERE id={$orderInfo['uid']}");
            //更新活动库存
            if($orderInfo['aid'] > 0 ){
                $dosql->Execute("select * from `#@__goodsorderitem` where orderid = '{$orderInfo['id']}' ");
                while($rrow = $dosql->GetArray()){
                    $dosql->ExecNoneQuery("update `#@__infolist` set housenum = housenum- '{$rrow['buyNum']}',salenum = salenum + '{$rrow['buyNum']}' where id = '{$rrow['gid']}' ");
                }
            }

            //如果用户未确认上家则更新
            if(!$userInfo['isReced']){
                $dosql->ExecNoneQuery("UPDATE `#@__member` SET isReced=1 WHERE id={$userInfo['id']}");
            }
            //发送微信通知
//             require_once('wechat.class.php');
//             $wechatConfig = array(
//                 'token' => $cfg_wechat_token,
//                 'appid' => $cfg_wechat_appid,
//                 'appsecret' => $cfg_wechat_appsecret,
//                 'debug' => false
//             );
//             $wechat = new wechat($wechatConfig);
            //向上家发送微信通知
//             if($recUserInfo1){
//                 //获取上家分销商数量,更新上家用户等级(一星级和二星级是按照名下分销商数量来决定的，三星级是按照名下二星级分销商的数量来决定)
//                 if($recUserInfo1['stars'] < 2){
//                     $sjfxs = $dosql->GetOne("SELECT count(id) num FROM #@__member WHERE recUid={$recUserInfo1['id']} AND isReced=1");
//                 }else{
//                     $sjfxs = $dosql->GetOne("SELECT count(m.id) num FROM #@__member m LEFT JOIN #@__usergroup g ON m.group_id=g.id WHERE m.recUid={$recUserInfo1['id']} AND m.isReced=1 AND g.stars=2");
//                 }
//                 $usergroup = $dosql->GetOne("SELECT * FROM #@__usergroup WHERE {$sjfxs['num']}>=dqa AND {$sjfxs['num']}<=dqb");
//                 if($usergroup && $usergroup['stars'] > $recUserInfo1['stars']){
//                     $dosql->ExecNoneQuery("UPDATE `#@__member` SET group_id={$usergroup['id']} WHERE id={$recUserInfo1['id']}");
//                 }
//                 //添加佣金记录
//                 $dosql->ExecNoneQuery("INSERT INTO `#@__commission_record` (orderid, uid, type, amount, createtime) VALUES ('{$orderInfo['id']}', '{$recUserInfo1['id']}', 'direct', '{$orderInfo['directCommission']}', '{$nowTime}')");
//                 //给用户账户添加佣金
//                 $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin+{$orderInfo['directCommission']},totalYongjin=totalYongjin+{$orderInfo['directCommission']} WHERE id={$recUserInfo1['id']}");
//                 $messageData = array(
//                     'touser' => $recUserInfo1['openid'],
//                     'msgtype' => 'text',
//                     'text' => array('content' => '您的客户【' . $userInfo['wechat_nickname'] . '】在' . date('Y-m-d H:i:s', $nowTime) . '成功购买'.$orderInfo['goodsNames'].'商品，已付款，订单号为：' . $orderInfo['ordernum'] . '；订单金额为：' . $orderInfo['amount'] . '元；您已获得的佣金为：' . $orderInfo['directCommission'] . '元。')
//                 );
//                 $wechat->sendCustomMessage($messageData);
//             }
            //向上上家发送微信通知
//             if($recUserInfo2){
//                 //添加佣金记录
//                 $dosql->ExecNoneQuery("INSERT INTO `#@__commission_record` (orderid, uid, type, amount, createtime) VALUES ('{$orderInfo['id']}', '{$recUserInfo2['id']}', 'indirect', '{$orderInfo['indirectCommission']}', '{$nowTime}')");
//                 //给用户账户添加佣金
//                 $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin+{$orderInfo['indirectCommission']},totalYongjin=totalYongjin+{$orderInfo['indirectCommission']} WHERE id={$recUserInfo2['id']}");
//                 $messageData = array(
//                     'touser' => $recUserInfo2['openid'],
//                     'msgtype' => 'text',
//                     'text' => array('content' => '您的分销商【' . $recUserInfo1['wechat_nickname'] . '】在' . date('Y-m-d H:i:s', $nowTime) . '成功销售'.$orderInfo['goodsNames'].'商品，已付款，订单号为：' . $orderInfo['ordernum'] . '；订单金额为：' . $orderInfo['amount'] . '元；您已获得的佣金为：' . $orderInfo['indirectCommission'] . '元。')
//                 );
//                 $wechat->sendCustomMessage($messageData);
//             }
        }
    }
}
