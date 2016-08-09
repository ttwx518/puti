<?php

//定义入口常量
define('IN_MEMBER', TRUE);

//初始化参数
$a = isset($a) ? $a : 'default';

//检测是否启用会员
if ($cfg_member == 'N') {
    ShowMsg('抱歉，本站没有启用会员功能！', '-1');
    exit();
}

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

// //验证是否登录和用户合法
// if ($a == 'default' || $a == 'order' || $a == 'distributors' || $a == 'results' || $a == 'commission' || $a == 'edit' || $a == 'address' || $a == 'editAddress' || $a == 'setDefaultAddress' || $a == 'delAddress' || $a == 'paySuccess' || $a == 'applyReturn' || $a == 'logout') {
//     !$userInfo && redirectAuth('index.php?c=member&a=' . $a);
// }

//会员中心
if ($a == 'default') {
    $recUserInfo = $dosql->GetOne("SELECT id,recUid,username,truename,wechat_nickname FROM #@__member WHERE id={$userInfo['recUid']}");
    $recName = $recUserInfo ? $recUserInfo['wechat_nickname'] : '官方商城';
    
//     //获取各状态订单数量统计
//     //待付款
//     $payment = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%confirm' AND checkinfo NOT LIKE '%payment%' AND checkinfo NOT LIKE '%cancel%'");
//     //待发货
//     $postgoods = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%payment'");
//     //待收货
//     $getgoods = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%postgoods'");
//     //已完成
//     $complete = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND (checkinfo LIKE '%getgoods' OR checkinfo LIKE '%overorder%') AND checkinfo NOT LIKE '%applyreturn%' AND completedShow=1");
//     //退货换货
//     $applyreturn = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%applyreturn%'");

//     $ordersCount = array('payment' => $payment['num'], 'postgoods' => $postgoods['num'], 'getgoods' => $getgoods['num'], 'complete' => $complete['num'], 'applyreturn' => $applyreturn['num']);

    $seo = setSeo('种子会员', $cfg_keyword, $cfg_description);
}

//我的种子
elseif($a == 'my_seed'){
    $seo = setSeo('我的种子', $cfg_keyword, $cfg_description);
}

//我的订单
elseif ($a == 'order') {
    $flag = isset($flag) ? $flag : 'payment';
    $page = empty($page) ? 1 : intval($page);

    $records = getOrdersList($page, $flag, $userInfo['id']);
    //获取各状态订单数量统计
//     //待付款
//     $payment = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%confirm' AND checkinfo NOT LIKE '%payment%' AND checkinfo NOT LIKE '%cancel%'");
//     //待发货
//     $postgoods = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%payment'");
//     //待收货
//     $getgoods = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%postgoods'");
//     //已完成
//     $complete = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND (checkinfo LIKE '%getgoods' OR checkinfo LIKE '%overorder%') AND checkinfo NOT LIKE '%applyreturn%' AND completedShow=1");
//     //退货换货
//     $applyreturn = $dosql->GetOne("SELECT count(id) num FROM #@__goodsorder WHERE uid={$userInfo['id']} AND delstate='' AND checkinfo LIKE '%applyreturn%'");

//     $ordersCount = array('payment' => $payment['num'], 'postgoods' => $postgoods['num'], 'getgoods' => $getgoods['num'], 'complete' => $complete['num'], 'applyreturn' => $applyreturn['num']);

//     $postmode = getPostmode();

    $seo = setSeo('我的订单', $cfg_keyword, $cfg_description);
}

//我的分销商
else if ($a == 'distributors') {
    $page=empty($page)?1:intval($page);
    $records = getDistributorsList($page, $userInfo['id']);
    
    
//     if ($flag == 'default') {
//         $distributors = array();
//         $totalDcount = 0;
//         $dosql->Execute("SELECT id,username,truename,wechat_nickname,wechat_headimgurl FROM `#@__member` WHERE recUid={$userInfo['id']} AND isReced=1 ORDER BY id DESC");
//         while ($row = $dosql->GetArray()) {
//             $dCount = $dosql->GetOne("SELECT count(id) num FROM `#@__member` WHERE recUid={$row['id']} AND isReced=1");
//             $row['dCount'] = $dCount['num'];
//             $totalDcount += $dCount['num'];
//             $distributors[] = $row;
//         }
//     } elseif ($flag == 'detail') {
//         $id = isset($id) ? intval($id) : 0;
//         $distributor = $dosql->GetOne("SELECT * FROM #@__member WHERE id={$id} AND recUid={$userInfo['id']}");
//         if ($distributor) {
//             $data = getYjItemList($distributor['id']);
//         }
//     }
    $seo = setSeo('我的团队', $cfg_keyword, $cfg_description);
}

//业绩收入
else if ($a == 'results') {
    $type = empty($type)?1:intval($type);
    $page=empty($page)?1:intval($page);
    $records = getYjItemList($page, $userInfo['id'],$type);
    $seo = setSeo('种子业绩', $cfg_keyword, $cfg_description);
//     elseif ($flag == 'detail') {
//         $id = isset($id) ? intval($id) : 0;
//         $w = isset($w) ? $w : 'me';
//         $typeArr = array('me' => 'direct', 'fxs' => 'indirect');
//         $goodInfo = $dosql->GetOne("SELECT id,directCommission,indirectCommission FROM #@__goods WHERE id={$id} AND checkinfo='true' AND delstate=''");
//         if($goodInfo && ($w == 'me' || $w == 'fxs')){
//             $goodInfo['indirectCommission'] = unserialize($goodInfo['indirectCommission']);
//             $data = getUserYjList($userInfo['id'], $typeArr[$w], $goodInfo['id']);
//         }
//     }
}

// 我的种子
else if ($a == 'ytx') {
    $success = $error = '';
    $ktxAmount = $userInfo['yongjin'];
    if (isset($amount)) {
        $alipayAccount = isset($alipayAccount) ? trim($alipayAccount) : '';
        if (!$alipayAccount) {
            $error = '支付宝账号不能为空';
        }
        $truename = isset($truename) ? trim($truename) : '';
        if (!$error && !$truename) {
            $error = '真实姓名不能为空';
        }
        $amount = isset($amount) ? intval($amount) : 0;
        if (!$error && (!$amount || $amount <= 0)) {
            $error = '兑换数量必须为1的整数倍';
        }
        if (!$error && $amount < 200) {
            $error = '兑换数量最少为200元';
        }
        if (!$error && $amount > $userInfo['yongjin']) {
            $error = '兑换数量不能大于可种子数量';
        }
        if (!$error) {
            $nowTime = time();
            $nowDate = strtotime(date('Y-m-d'));
            $result = $dosql->ExecNoneQuery("INSERT INTO `#@__withdraw_record` (uid, alipayAccount, truename, amount, createtime, createdate) VALUES ('{$userInfo['id']}', '{$alipayAccount}', '{$truename}', '{$amount}', '{$nowTime}', '{$nowDate}')");
            if ($result) {
                $success = '成功: 兑换申请已提交,请等待审核.';
                $dosql->ExecNoneQuery("UPDATE #@__member SET yongjin=yongjin-{$amount} WHERE id={$userInfo['id']}");
                $ktxAmount -= $amount;
            } else {
                $error = '失败: 系统繁忙,请稍后重试.';
            }
        }
    }
    
    $page=empty($page)?1:intval($page);
    $records = getYtxList($page, $userInfo['id']);
//     $ytxTotal = $dosql->GetOne("SELECT sum(amount) ytxAmount FROM #@__withdraw_record WHERE uid={$userInfo['id']} AND status=2");
//     $ytxAmount = $ytxTotal['ytxAmount'] ? $ytxTotal['ytxAmount'] : 0;
    $seo = setSeo('我的种子', $cfg_keyword, $cfg_description);
}

//种子充值
else if($a == 'recharge'){

    $seo = setSeo('种子充值', $cfg_keyword, $cfg_description);
}

// 提现
else if ($a == 'ktx') {
    $seo = setSeo('种子兑换', $cfg_keyword, $cfg_description);
}

// 我的二维码
else if ($a == 'qrcode') {
    // 生成二维码
    addQrcodeToScenePic();
    // 判断是否分享
    if(!empty($recUid)){
        $userInfo = $dosql->GetOne("SELECT * FROM #@__member WHERE id={$recUid}");
    }
    $seo = setSeo('我的二维码', $cfg_keyword, $cfg_description);
}

//佣金管理
// else if ($a == 'commission') {

//     $flag = isset($flag) ? $flag : 'ktx';

//     //可提现
//     if ($flag == 'ktx') {

//         $success = $error = '';

//         $ktxAmount = $userInfo['yongjin'];

//         if (isset($txSub)) {
//             $alipayAccount = isset($alipayAccount) ? trim($alipayAccount) : '';
//             if (!$alipayAccount) {
//                 $error = '支付宝账号不能为空';
//             }
//             $truename = isset($truename) ? trim($truename) : '';
//             if (!$error && !$truename) {
//                 $error = '真实姓名不能为空';
//             }
//             $amount = isset($amount) ? intval($amount) : 0;
//             if (!$error && (!$amount || $amount <= 0)) {
//                 $error = '提现金额必须为1的整数倍';
//             }
//             if (!$error && $amount < 200) {
//                 $error = '提现金额最少为200元';
//             }
//             if (!$error && $amount > $userInfo['yongjin']) {
//                 $error = '提现金额不能大于可提现金额';
//             }
//             if (!$error) {
//                 $nowTime = time();
//                 $nowDate = strtotime(date('Y-m-d'));
//                 $result = $dosql->ExecNoneQuery("INSERT INTO `#@__withdraw_record` (uid, alipayAccount, truename, amount, createtime, createdate) VALUES ('{$userInfo['id']}', '{$alipayAccount}', '{$truename}', '{$amount}', '{$nowTime}', '{$nowDate}')");
//                 if ($result) {
//                     $success = '成功: 提现申请已提交,请等待审核.';
//                     $dosql->ExecNoneQuery("UPDATE #@__member SET yongjin=yongjin-{$amount} WHERE id={$userInfo['id']}");
//                     $ktxAmount -= $amount;
//                 } else {
//                     $error = '失败: 系统繁忙,请稍后重试.';
//                 }
//             }
//         }
//     }
//     //已提现
//     elseif ($flag == 'ytx') {
//         $page=empty($page)?1:intval($page);
//         $records = getYtxList($page, $userInfo['id']);
//         $ytxTotal = $dosql->GetOne("SELECT sum(amount) ytxAmount FROM #@__withdraw_record WHERE uid={$userInfo['id']} AND status=2");
//         $ytxAmount = $ytxTotal['ytxAmount'] ? $ytxTotal['ytxAmount'] : 0;
//         $seo = setSeo('我的种子', $cfg_keyword, $cfg_description);
//     }
//     //累计收入
//     elseif ($flag == 'ljsr') {
//         $records = getLjsrList(1, $userInfo['id']);
//         $ljsrTotal = $dosql->GetOne("SELECT sum(amount) ljsrAmount FROM #@__commission_record WHERE uid={$userInfo['id']}");
//         $ljsrAmount = $ljsrTotal['ljsrAmount'] ? $ljsrTotal['ljsrAmount'] : 0;
//     }
//     //退货换货明细
//     elseif ($flag == 'thmx') {
        
//     }

//     //$seo = setSeo('佣金管理', $cfg_keyword, $cfg_description);
// }

//修改资料
else if ($a == 'edit') {

    $success = $error = '';

    if (isset($editSub)) {
        $truename = isset($truename) ? trim($truename) : '';
        if (!$truename) {
            $error = '真实姓名不能为空';
        }
        $email = isset($email) ? trim($email) : '';
        /*
          if (!$error && !$email) {
          $error = '电子邮箱不能为空';
          }
         */
        if (!$error && $email && !isEmailFormat($email)) {
            $error = '电子邮箱格式错误';
        }
        $qqnum = isset($qqnum) ? trim($qqnum) : '';
        /*
          if (!$error && !$qqnum) {
          $error = 'QQ号码不能为空';
          }
         */
        $address = isset($address) ? trim($address) : '';
        /*
          if (!$error && !$address) {
          $error = '联系地址不能为空';
          }
         */
        $wechat_account = isset($wechat_account) ? trim($wechat_account) : '';
        if (!$error && !$wechat_account) {
            $error = '微信号不能为空';
        }
        $alipay_account = isset($alipay_account) ? trim($alipay_account) : '';
        if (!$error && !$alipay_account) {
            $error = '支付宝账号不能为空';
        }

        if (!$error) {
            $result = $dosql->ExecNoneQuery("UPDATE `#@__member` SET truename='{$truename}' ,email='{$email}', qqnum='{$qqnum}', address='{$address}', wechat_account='{$wechat_account}', alipay_account='{$alipay_account}' WHERE id={$userInfo['id']}");
            if ($result) {
                $success = '成功: 您的账号资料已更新.';
            } else {
                $error = '失败: 系统繁忙,请稍后重试.';
            }
        }
    }
    $seo = setSeo('修改资料', $cfg_keyword, $cfg_description);
}

//地址管理
else if ($a == 'address') {

    $redirect = isset($redirect) ? $redirect : '';

    $address = getAddressList(1, $userInfo['id'], $redirect);

    $seo = setSeo('地址管理', $cfg_keyword, $cfg_description);
}

//添加/编辑地址
else if ($a == 'editAddress') {
    $redirect = isset($redirect) ? $redirect : '';
    $redirect = $redirect ? $redirect : 'index.php?c=member&a=address';
    $provs = listarea(0);
    $id = isset($id) ? intval($id) : 0;
    $success = $error = '';
    if (isset($addressSub)) {
        $name = isset($name) ? trim($name) : '';
        if (!$name) {
            $error = '收货人姓名不能为空';
        }
        $mobile = isset($mobile) ? trim($mobile) : '';
        if (!$error && !$mobile) {
            $error = '收货人手机号不能为空';
        }
        if (!$error && !isMobileFormat($mobile)) {
            $error = '收货人手机号格式不正确';
        }
        $prov = isset($prov) ? $prov : 0;
        if (!$error && !$prov) {
            $error = '省份不能为空';
        }
        $city = isset($city) ? $city : 0;
        if (!$error && !$city) {
            $error = '市不能为空';
        }
        $country = isset($country) ? $country : 0;
        $address = isset($address) ? trim($address) : '';
        if (!$error && !$address) {
            $error = '详细地址不能为空';
        }
        $zipcode = isset($zipcode) ? trim($zipcode) : '';
        $isDefault = isset($isDefault) ? 1 : 0;
        if (!$error) {
            if ($id) {
                $sql = "UPDATE `#@__useraddress` SET name='{$name}', mobile='{$mobile}', prov='{$prov}', 
                        city='{$city}', country='{$country}', address='{$address}', zipcode='{$zipcode}', 
                        isDefault='{$isDefault}' WHERE id={$id}";
            } else {
                $sql = "INSERT INTO `#@__useraddress` (uid, name, mobile, prov, city, country, address, zipcode, 
                        isDefault) VALUES ('{$userInfo['id']}', '{$name}', '{$mobile}', '{$prov}', '{$city}', 
                        '{$country}', '{$address}', '{$zipcode}', '{$isDefault}')";
            }
            $result = $dosql->ExecNoneQuery($sql);
            if ($result) {
                $defId = $id ? $id : $dosql->GetLastID();
                if ($isDefault) {
                    $dosql->ExecNoneQuery("UPDATE `#@__useraddress` SET isDefault=0 WHERE uid={$userInfo['id']} AND id<>{$defId}");
                }
                $success = '成功: 您的收货地址已更新.';
            } else {
                $error = '失败: 系统繁忙,请稍后重试.';
            }
            redirect($redirect);
        }
    }
    $address = $dosql->GetOne("SELECT * FROM `#@__useraddress` WHERE id={$id} AND uid={$userInfo['id']}");
    if (!empty($address)) {
        if ($address['prov'] != '' || $address['prov'] != '0') {
            $cities = listarea(1, $address['prov']);
        }
        if ($address['city'] != '' || $address['city'] != '0') {
            $countries = listarea(2, $address['city']);
        }
    }
    $seo = setSeo('地址管理', $cfg_keyword, $cfg_description);
}

//设为默认收货地址
else if ($a == 'setDefaultAddress') {
    $redirect = isset($redirect) ? $redirect : '';
    $redirect = $redirect ? $redirect : 'index.php?c=member&a=address';
    $id = isset($id) ? intval($id) : 0;
    $r = $dosql->GetOne("SELECT * FROM `#@__useraddress` WHERE id={$id} AND uid={$userInfo['id']}");
    if (!empty($r)) {
        $result = $dosql->ExecNoneQuery("UPDATE `#@__useraddress` SET isDefault=1 WHERE id={$id}");
        if ($result) {
            $dosql->ExecNoneQuery("UPDATE `#@__useraddress` SET isDefault=0 WHERE uid={$userInfo['id']} AND id<>{$id}");
        }
    }
    redirect($redirect);
}

//我的收藏
else if ($a == 'fav') {
    $type = empty($type)?'1':$type;
    $favs=array();//g.id,g.picurl,g.salesprice,g.title
    $sql = "select id,gid,type from `#@__fav` where uid={$userInfo['id']} and type='{$type}'";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()){
        if($row['type']=='1'){
            $goods = $dosql->GetOne("SELECT id,picurl,title FROM `#@__goods` WHERE id={$row['gid']}");
            $goods['type']='商品';
            $goods['url']='index.php?c=item&id='.$goods['id'];
            $favs[]= $goods;
        }
        if($row['type']=='2'){
            $info = $dosql->GetOne("SELECT id,picurl,title FROM `#@__infolist` WHERE id={$row['gid']}");
            $info['type']='活动';
            $info['url']='index.php?c=info&a=activitydetails&id='.$info['id'];
            $favs[]= $info;
        }
        if($row['type']=='3'){
            $child = $dosql->GetOne("SELECT id,picurl,title FROM `#@__children` WHERE id={$row['gid']}");
            $child['type']='爱心儿童';
            $child['url']='index.php?c=citem&id='.$child['id'];
            $favs[]= $child;
        }
    }
    $seo = setSeo('我的收藏', $cfg_keyword, $cfg_description);
}
//商品评论
else if ($a == 'comment') {
    $id=empty($id)?0:intval($id);
    $goods = $dosql->GetOne("SELECT * FROM `#@__goods` WHERE id={$id}");
    $seo = setSeo('商品评论', $cfg_keyword, $cfg_description);
}

//删除收货地址
else if ($a == 'delAddress') {
    $redirect = isset($redirect) ? $redirect : '';
    $id = isset($id) ? intval($id) : 0;
    $dosql->ExecNoneQuery("DELETE FROM `#@__useraddress` WHERE id={$id} AND uid={$userInfo['id']}");
    redirect('index.php?c=member&a=address&redirect=' . $redirect);
}

//支付成功
else if ($a == 'paySuccess') {

    $ordernum = isset($ordernum) ? $ordernum : '';

    $orderInfo = $dosql->GetOne("SELECT o.*,m.openid FROM #@__goodsorder o LEFT JOIN #@__member m ON o.uid=m.id WHERE o.ordernum='{$ordernum}'");

    if (!$orderInfo) {
        ShowMsg("未查询到相关订单!", "index.php?c=member&a=order&flag=payment");
        exit();
    }

    $doorder->orderPaySuccess($orderInfo);
    generate_percentage($ordernum);

    redirect('index.php?c=member&a=order&flag=postgoods');
}

//申请退货换货
else if ($a == 'applyReturn') {
    
    $id = isset($id) ? intval($id) : 0;
    
    $orderInfo = $dosql->GetOne("SELECT * FROM `#@__goodsorder` WHERE delstate='' AND id={$id}");
    
    $checkinfo = explode(',', $orderInfo['checkinfo']);
    
    if(!$orderInfo || in_array('overorder', $checkinfo) || in_array('cancel', $checkinfo))
        ShowMsg('无效的订单!', '-1');
    
    if(in_array('applyreturn', $checkinfo))
        ShowMsg('该订单已申请退货/换货，请耐心等待!', '-1');
    
    //提交申请
    if(isset($returnSub)){
        $content = isset($content) ? htmlspecialchars($content) : '';
        $refundType = isset($refundType) ? $refundType : 1;
        if (!in_array('applyreturn', $checkinfo)) {
            $checkinfo[] = 'applyreturn';
            $tmp = implode(',', $checkinfo);
            $nowTime = time();
            $sql = "UPDATE `#@__goodsorder` SET checkinfo='{$tmp}',refundType={$refundType},refundReason='{$content}',refundTime={$nowTime} WHERE id={$id}";
            $dosql->ExecNoneQuery($sql);
        }
        ShowMsg('提交成功', 'index.php?c=member&a=order&flag=postgoods');
    }
    $seo = setSeo('申请退货/换货', $cfg_keyword, $cfg_description);
}

//升级
else if( $a == 'upgrade') {
    $seo = setSeo('升级', $cfg_keyword, $cfg_description);
}

//转让
else if( $a == 'transfer') {
    $seo = setSeo('转让', $cfg_keyword, $cfg_description);
}

//权限
else if( $a == 'competence') {
    $seo = setSeo('权限', $cfg_keyword, $cfg_description);
}

//查看爱心屋
else if( $a == 'check_house') {
    $seo = setSeo('查看爱心屋', $cfg_keyword, $cfg_description);
}

//申请爱心屋
else if( $a == 'apply_house') {
    $seo = setSeo('申请爱心屋', $cfg_keyword, $cfg_description);
}


//注销登录
else if ($a == 'logout') {
    delCookie('openid');
    redirect('index.php');
}