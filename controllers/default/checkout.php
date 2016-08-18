<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}
/************************种子认养***************************/
if (!empty($checkoutactivity)) {
    global $dosql,$cfg_freight_free,$cfg_freight,$userInfo;
    $orderCart  = array('items' => array(), 'totalNum' => 0, 'totalAmount' => 0, 'totalWeight' => 0, 'totalFreight' => 0,'minYongjin'=>0,'minJifen'=>0);
    
    $row = $dosql->GetOne("select * from #@__infolist where id={$id}");
    $row['salesprice'] = $row['goodsprice'];
    $orderCart['items'][$row['id']] = $row;
    $orderCart['items'][$row['id']]['buyNum'] = $buynum;
    $orderCart['totalNum'] = $buynum;
    $orderCart['totalAmount'] = $row['salesprice'] * $buynum;
    if($orderCart['totalAmount']>=$cfg_freight_free){
        $orderCart['yunfei'] = 0;// '免运费';
    }else{
        $orderCart['yunfei'] = $cfg_freight;//'运费 <font style="color: red">'.$cfg_freight . '</font> 元';
    }
    $orderCart['maxconmision'] = 0; //认养不能抵扣 //min($userInfo['yongjin'], ($orderCart['totalAmount']+$orderCart['yunfei']));
}
/************************种子认养***************************/
else{
/************************正常购买***************************/
    //获取订单结算购物车信息
    $cookieCart = unserialize(getCookie('cart'));
    $orderCart = $docart->getCart($cookieCart);
    //判断购物车是否为空
    if (!$orderCart['items']) {
        redirect('index.php?c=cart');
    }

/************************正常购买***************************/
}

$areas = listarea(-1);
$orderCart['order_type'] = isset($orderCart['order_type']) ? $orderCart['order_type'] : '-1';
//订单提交错误信息
$error = ''; 

//订单提交
if (!empty($checkoutSub)) {
    //收货地址
    $addressId = isset($addressId) ? intval($addressId) : 0;
    if(!$addressId){
        $error = '收货地址不能为空';
    }
    $addressInfo = $dosql->GetOne("SELECT * FROM #@__useraddress WHERE id={$addressId} AND uid={$userInfo['id']}");
    if(!$error && !$addressInfo){
        $error = '收货地址信息错误';
    }
    //支付方式
    $paymode = isset($paymode) ? intval($paymode) : 0;
    if (!$error && !$paymode) {
        $error = '请选择支付方式';
    }
    $postmode = isset($postmode) ? intval($postmode) : 0;
    if (!$error && !$postmode) {
        $error = '请选择配送方式';
    }
    $postmodeInfo = $dosql->GetOne("SELECT * FROM `#@__postmode` WHERE checkinfo='true' AND id={$postmode}");
    if(!$error && !$postmodeInfo){
        $error = '配送方式信息错误';
    }
    //发票信息
//     $isTax = isset($isTax) ? intval($isTax) : 0;
//     $taxHead = isset($taxHead) ? trim($taxHead) : '';
//     if(!$error && $isTax == 1 && !$taxHead){
//         $error = '请填写发票抬头';
//     }
    $isTax=0;
    $taxHead='';
    //买家留言
    $buyremark = isset($buyremark) ? trim($buyremark) : '';
    
    if(!$error){
        $provInfo = isset($areas[$addressInfo['prov']]['dataname']) ? $areas[$addressInfo['prov']]['dataname'] : '';
        $cityInfo = isset($areas[$addressInfo['city']]['dataname']) ? $areas[$addressInfo['city']]['dataname'] : '';
        $countryInfo = isset($areas[$addressInfo['country']]['dataname']) ? $areas[$addressInfo['country']]['dataname'] : '';
        $pccinfo =  $provInfo.$cityInfo.$countryInfo;
        $nowTime = time();
        //订单号
        $ordernum = MyDate('YmdHis', $nowTime) . mt_rand(10000, 99999);
        //订单状态
        $checkinfo[] = 'confirm';
        // 活动发起者ID
        $aid=empty($aid)?0:intval($aid);
        // 查找活动
        $infolist = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE id={$aid}");
        $suid = empty($infolist['auid'])?0:$infolist['auid'];
        if($order_type == 1){
            $useintegral = ($orderCart['totalAmount'] + $orderCart['yunfei'])*0.9; //爱心 抵扣9 折
        }

        $checkinfoStr = implode(',', $checkinfo);
        if($userInfo['yongjin'] >= $amount){
            $amount = 0;
        } else {
            if($typepid == 4 ){
                $amount = $orderCart['totalAmount']*0.9; //兑换9折优惠
            } else {
                $amount = $orderCart['totalAmount'] + $orderCart['yunfei']-$useintegral;
            }

        }


        $orderSql = "INSERT INTO `#@__goodsorder`
                    (uid, recUid, recUid2, ordernum, addressId, name, mobile, prov, city, country, pccinfo, address, zipcode, 
                     paymode, postmode, isTax, taxHead, buyremark, weight, cost, goodsAmount, amount, checkinfo, 
                     createtime, updatetime, useintegral,auid,aid,order_type)
                    VALUES
                    ('{$userInfo['id']}', '{$userInfo['recUid']}', '{$userInfo['recUid2']}', '{$ordernum}', '{$addressInfo['id']}', '{$addressInfo['name']}', 
                     '{$addressInfo['mobile']}', '{$addressInfo['prov']}', '{$addressInfo['city']}', 
                     '{$addressInfo['country']}', '{$pccinfo}', '{$addressInfo['address']}', 
                     '{$addressInfo['zipcode']}', '{$paymode}', '{$postmode}', '{$isTax}', '{$taxHead}', 
                     '{$buyremark}', '{$orderCart['totalWeight']}', '{$orderCart['totalFreight']}', 
                     '{$orderCart['totalAmount']}', '{$amount}', '{$checkinfoStr}', '{$nowTime}', '{$nowTime}', '$useintegral',{$suid},$aid,'$order_type')";

        $orderInsertResult = $dosql->ExecNoneQuery($orderSql);
        
        if ($orderInsertResult) {
            //订单提交成功
            $insertId = $dosql->GetLastID();
            //处理商品信息
            $cart = $docart->getCookieCart();
            $totalDirectCommission = $totalIndirectCommission = 0;
            $goodsNames = array();
            if(is_array($orderCart['items']) && count($orderCart['items']) > 0){
                foreach($orderCart['items'] as $v){
                    $goodsNames[] = $v['title'];
                    if(array_key_exists($v['id'], $cart)){
                        unset($cart[$v['id']]);
                    }
                    $dosql->ExecNoneQuery("INSERT INTO `#@__goodsorderitem` 
                                          (orderid, gid, picurl, title, goodsid, salesprice, directCommission, 
                                          indirectCommission, buyNum) VALUES ('{$insertId}', '{$v['id']}', 
                                          '{$v['picurl']}', '{$v['title']}', '{$v['goodsid']}', 
                                          '{$v['salesprice']}', '0', '0', '{$v['buyNum']}')");
                }
            }
            $goodsNames = implode(',', $goodsNames);
            //更新订单货主奖励佣金与订单平台奖励佣金
            $dosql->ExecNoneQuery("UPDATE `#@__goodsorder` SET directCommission={$totalDirectCommission},indirectCommission={$totalIndirectCommission},goodsNames='{$goodsNames}' WHERE id={$insertId}");
            
            //删除购物车
            delCookie('orderCart');
            setcookie('cart', AuthCode(serialize($cart), 'ENCODE'));
            //跳转支付
            if($typepid == 4 && $userInfo['yongjin'] >= ($useintegral*0.9) ) {// 种子兑换
                $tmp = 'confirm,payment';
                $sql = "UPDATE `#@__goodsorder` SET checkinfo='$tmp' WHERE `ordernum`='{$ordernum}'";
                $dosql->ExecNoneQuery($sql);
                $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin - {$useintegral} where id={$userInfo['id']}");
                //返利给自己 15%
                $return_yongjin = $useintegral*0.9*0.15;
                $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin + {$return_yongjin}, totalYongjin = totalYongjin + '$return_yongjin' where id={$userInfo['id']}");
                operate_commision($userInfo['id'], $useintegral, '-', '种子兑换', $ordernum, $userInfo['id'],'您在种子商城已兑换成功。',2);

                operate_commision($userInfo['id'], $return_yongjin, '+', '种子兑换返利', $ordernum, $userInfo['id'],'您在种子商城已兑换商品所得返利成功。',2);

                redirect('index.php?c=member&a=order&flag=postgoods');
            }elseif ($typepid == 20 && $userInfo['jifen'] >= $useintegral){// 积分兑换
                $tmp = 'confirm,payment';
                $sql = "UPDATE `#@__goodsorder` SET checkinfo='$tmp' WHERE `ordernum`='{$ordernum}'";
                $dosql->ExecNoneQuery($sql);
                $dosql->ExecNoneQuery("UPDATE `#@__member` SET jifen=jifen - {$useintegral} where id={$userInfo['id']}");
                operate_commision($userInfo['id'], $useintegral, '-', '积分兑换', $ordernum, $userInfo['id'],'您在活动积分商城已兑换成功。',2);
                redirect('index.php?c=member&a=order&flag=postgoods');
            }elseif ($paymode==1 && $amount==0){// 正常购买 全额抵扣
                $tmp = 'confirm,payment';
                $sql = "UPDATE `#@__goodsorder` SET checkinfo='$tmp' WHERE `ordernum`='{$ordernum}'";
                $dosql->ExecNoneQuery($sql);
                $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin - {$useintegral} where id={$userInfo['id']}");
                operate_commision($userInfo['id'], $useintegral, '-', '种子抵现', $ordernum, $userInfo['id'],'您在种子商城认购已支付成功。',2);
                redirect('index.php?c=member&a=order&flag=postgoods');
            }elseif($paymode==1 && $amount > 0){// 正常购买 微信支付
                if($typepid == 4){

                    ShowMsg("您的种子数量不足，无法兑换");
                    exit;

                }else {
                    redirect('topay/wechatpay/js_api_call.php?ordernum='.$ordernum);
                }

            }else{
                echo '参数错误!';
            }
//             if(($paymode==2 && $minyongjin <= $useintegral) || ($paymode==1 && $userInfo['yongjin'] >= $useintegral)){
//                 $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin - {$useintegral} where id={$userInfo['id']}");
//                 $tmp = 'confirm,payment';
//                 $sql = "UPDATE `#@__goodsorder` SET checkinfo='$tmp' WHERE `ordernum`='{$ordernum}'";
//                 $dosql->ExecNoneQuery($sql);
//                 // 积分商城
//                 if($paymode==2){
//                     operate_commision($userInfo['id'], 0, '+', '', $ordernum, $userInfo['id'],'您在积分商城兑换商品已成功。',1);
//                 }elseif ($paymode==1){
//                     operate_commision($userInfo['id'], 0, '+', '', $ordernum, $userInfo['id'],'您在种子商城认养的种子已支付成功。',1);
//                 }
//                 redirect('index.php?c=member&a=order&flag=postgoods');
//             }elseif($paymode==1 && $amount>0){
//                 redirect('topay/wechatpay/js_api_call.php?ordernum='.$ordernum);
//             }else{
//                 echo '参数错误!';
//             }
        }else{
            $error = '系统繁忙,请稍后重试!';
        }
    }
}

//获取默认收货地址
$address = $dosql->GetOne("SELECT * FROM #@__useraddress WHERE uid={$userInfo['id']} ORDER BY isDefault DESC,id DESC");

//获取配送方式
$postmodeArr = getPostmode();

$seo = setSeo('订单结算', $cfg_keyword, $cfg_description);

?>