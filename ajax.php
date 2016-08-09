<?php

require_once(dirname(__FILE__) . '/include/config.inc.php');
//添加购物车
if ($action == 'addCart') {
    $id = isset($id) ? intval($id) : 0;
    $num = isset($num) ? intval($num) : 0;
    if (!$id || $num < 0) {
        echo json_encode(array('status' => false, 'msg' => '参数错误'));
        exit();
    }
    $goodInfo = $dosql->GetOne("SELECT salesprice,typeid FROM `#@__goods` WHERE checkinfo='true' AND delstate='' AND id={$id}");
    if (!$goodInfo) {
        echo json_encode(array('status' => false, 'msg' => '商品不存在或已下架'));
        exit();
    }
    if (!$userInfo) {
        echo json_encode(array('status' => false, 'msg' => '请授权登录后再购买'));
        exit();
    }
    if ($goodInfo['typeid']==16 && $userInfo['grade'] =='1') {
        echo json_encode(array('status' => false, 'msg' => '需要种子大使以上级别才能购买'));
        exit();
    }
    if (!$userInfo['recUid']) {
//         echo json_encode(array('status' => false, 'msg' => '您未获得该商品分销权'));
//         exit();
    }
    if ($userInfo['recUid'] != -1 && !hasBuyItem($id, $userInfo['recUid'])) {
//         echo json_encode(array('status' => false, 'msg' => '请联系货主申请分销'));
//         exit();
    }
    $totalNum = $docart->addCart($id, $num);
    echo json_encode(array('status' => true, 'msg' => '加入购物车成功', 'totalNum' => $totalNum));
    exit();
}

//立即购买
elseif ($action == 'buyNow') {
    $id = isset($id) ? intval($id) : 0;
    $num = isset($num) ? intval($num) : 0;
    if (!$id || $num < 0) {
        echo json_encode(array('status' => false, 'msg' => '参数错误'));
        exit();
    }
    $goodInfo = $dosql->GetOne("SELECT salesprice,typeid,ordernums FROM `#@__goods` WHERE checkinfo='true' AND delstate='' AND id={$id}");

    if (!$goodInfo) {
        echo json_encode(array('status' => false, 'msg' => '商品不存在或已下架'));
        exit();
    }
    if (!$userInfo) {
        echo json_encode(array('status' => false, 'msg' => '请授权登录后再购买'));
        exit();
    }
    if ($goodInfo['typeid']==16 && $userInfo['grade'] =='1') {
        echo json_encode(array('status' => false, 'msg' => '需要种子大使以上级别才能购买'));
        exit();
    }

    if (!$userInfo['recUid']) {
//         echo json_encode(array('status' => false, 'msg' => '您未获得该商品分销权'));
//         exit();
    }
    if ($userInfo['recUid'] != -1 && !hasBuyItem($id, $userInfo['recUid'])) {
//         echo json_encode(array('status' => false, 'msg' => '请联系货主申请分销'));
//         exit();
    }
    $totalNum = $docart->buyNow($id, $num);
    echo json_encode(array('status' => true, 'msg' => '立即购买成功', 'totalNum' => $totalNum));
    exit();
}

//编辑购物车
elseif ($action == 'editCart') {
    $id = isset($id) ? intval($id) : 0;
    $num = isset($num) ? intval($num) : 0;
    if (!$id || $num < 0) {
        echo json_encode(array('status' => false, 'msg' => '参数错误'));
        exit();
    }
    $goodInfo = $dosql->GetOne("SELECT salesprice,ordernums,housenum FROM `#@__goods` WHERE checkinfo='true' AND delstate='' AND id={$id}");

    if(!empty($goodInfo['ordernums']) && $num > $goodInfo['ordernums']){
        echo json_encode(array('status' => false, 'msg' => '您购买的数量已达到上线'));
        exit();
    }

    if($num > $goodInfo['housenum']){
        echo json_encode(array('status' => false, 'msg' => '库存不足'));
        exit();
    }

    if (!$goodInfo) {
        echo json_encode(array('status' => false, 'msg' => '商品不存在或已下架'));
        exit();
    }
    if (!$userInfo) {
        echo json_encode(array('status' => false, 'msg' => '请授权登录后再购买'));
        exit();
    }
    if (!$userInfo['recUid']) {
//         echo json_encode(array('status' => false, 'msg' => '您未获得该商品分销权'));
//         exit();
    }
    if ($userInfo['recUid'] != -1 && !hasBuyItem($id, $userInfo['recUid'])) {
//         echo json_encode(array('status' => false, 'msg' => '请联系货主申请分销'));
//         exit();
    }

    $data = $docart->editCart($id, $num);

    echo json_encode(array('status' => true, 'msg' => '操作成功', 'data' => $data));

    exit();
}

//获取省市区
elseif ($action == 'getArea') {
    $datagroup = 'area';
    $level = isset($level) ? $level : '0';
    $v = isset($areaval) ? $areaval : '0';
    $tips = isset($tips) ? $tips : '--';
    $str = '<option value="0">' . $tips . '</option>';
    $sql = "SELECT * FROM `#@__cascadedata` WHERE level=$level AND ";
    if ($v == 0)
        $sql .= "datagroup='$datagroup'";
    else if ($v % 500 == 0)
        $sql .= "datagroup='$datagroup' AND datavalue>$v AND datavalue<" . ($v + 500);
    else
        $sql .= "datavalue LIKE '$v.%%%' AND datagroup='$datagroup'";

    $sql .= " ORDER BY orderid ASC, datavalue ASC";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $str .= '<option value="' . $row['datavalue'] . '">' . $row['dataname'] . '</option>';
    }
    echo json_encode(array('status' => true, 'data' => $str));
    exit();
}

//订单编辑
elseif ($action == 'orderChange') {
    $postmodeId = isset($postmodeId) ? intval($postmodeId) : 0; //配送方式id
    if (!$userInfo) {
        echo json_encode(array('status' => false, 'msg' => '请授权登录后再购买', 'refresh' => TRUE));
        exit();
    }
    $cookieCart = unserialize(getCookie('orderCart'));
    $orderCart = $docart->getCart($cookieCart);
    if (!$orderCart['items']) {
        echo json_encode(array('status' => false, 'msg' => '购物车还是空的', 'refresh' => TRUE));
        exit();
    }
    if ($postmodeId == 0) {
        echo json_encode(array('status' => true, 'msg' => '', 'totalFreight' => 0, 'totalAmount' => $orderCart['totalAmount']));
        exit();
    }
    $paymode = $dosql->GetOne("SELECT postprice FROM #@__postmode WHERE id={$postmodeId} AND checkinfo='true'");
    if (!$paymode) {
        echo json_encode(array('status' => false, 'msg' => '配送方式不存在', 'refresh' => TRUE));
        exit();
    } else {
        echo json_encode(array('status' => true, 'msg' => '', 'totalFreight' => $paymode['postprice'] + 0, 'totalAmount' => $orderCart['totalAmount'] + $paymode['postprice']));
        exit();
    }
}

//验证账号是否已注册
elseif ($action == 'isReg') {
    $mobile = isset($mobile) ? trim($mobile) : '';
    $status = 1;
    if (!$mobile) {
        $status = 2; //参数错误
    } else {
        $mobileExist = $dosql->GetOne("SELECT count(id) num FROM #@__member WHERE username='{$mobile}'");
        if ($mobileExist['num'] > 0) {
            $status = 3; //已注册
        }
    }
    echo json_encode($status);
    exit();
}

//发送短信验证码
elseif ($action == 'sendMobileCode') {
    $type = isset($type) ? $type : '';
    $mobile = isset($mobile) ? $mobile : '';
    if (!$type || !$mobile || !isMobileFormat($mobile)) {
        $result = array('status' => false, 'msg' => '发送失败,请稍后重试');
    } else {
        //发送短信验证码
        $datas = array(randStr(6, 'NUMBER'), '10');
        $smsResult = $dosms->mSendSms($type, $mobile, $datas);
        if ($smsResult) {
            $result = array('status' => true, 'msg' => '发送成功');
        } else {
            $result = array('status' => false, 'msg' => '发送失败,请稍后重试');
        }
    }
    echo json_encode($result);
    exit();
}


//短信验证码验证
elseif ($action == 'mobileCodeChk') {
    $type = isset($type) ? $type : '';
    $mobile = isset($mobile) ? $mobile : '';
    $mobileCode = isset($mobileCode) ? $mobileCode : '';
    $status = 1;
    if (!$type || !$mobile || !$mobileCode) {
        $status = 2; //参数错误
    } else {
        $lastMobileCode = $dosql->GetOne("SELECT * FROM #@__sms_record WHERE type='{$type}' AND mobile='{$mobile}' ORDER BY sendtime DESC");
        if (empty($lastMobileCode)) {
            $status = 3; //验证码超时
        } else {
            $nowTime = time();
            if ($nowTime > $lastMobileCode['validtime']) {
                $status = 3; //验证码超时
            }
            if ($mobileCode != $lastMobileCode['code']) {
                $status = 4; //验证码错误
            }
        }
    }
    echo json_encode($status);
    exit();
}

//用户取消订单操作
elseif ($action == 'cancelOrder') {
    $id = isset($id) ? intval($id) : 0;
    $result = $doorder->cancelOrder($id);
    echo json_encode($result);
    exit();
}

//用户确认收货操作
elseif ($action == 'getGoods') {
    $id = isset($id) ? intval($id) : 0;
    $result = $doorder->getGoods($id);
    echo json_encode($result);
    exit();
}

//加载商品列表
elseif ($action == 'getGoodsList') {
    $page = isset($page) ? intval($page) : 1;
    $id = isset($id) ? intval($id) : 0;
    $list = getGoodsList($page);
    echo json_encode($list);
    exit();
}

//加载我的订单列表
elseif ($action == 'getOrdersList') {
    $page = isset($page) ? intval($page) : 1;
    $flag = isset($flag) ? $flag : '';
    $list = getOrdersList($page, $flag, $userInfo['id']);
    echo json_encode($list);
    exit();
}

//加载我的地址列表
elseif ($action == 'getAddressList') {
    $page = isset($page) ? intval($page) : 1;
    $redirect = isset($redirect) ? $redirect : '';
    $list = getAddressList($page, $userInfo['id'], $redirect);
    echo json_encode($list);
    exit();
}

//加载已提现记录列表
elseif ($action == 'getYtxList') {
    $page = isset($page) ? intval($page) : 1;
    $list = getYtxList($page, $userInfo['id']);
    echo json_encode($list);
    exit();
}

//加载累计收入列表
elseif ($action == 'getLjsrList') {
    $page = isset($page) ? intval($page) : 1;
    $list = getLjsrList($page, $userInfo['id']);
    echo json_encode($list);
    exit();
}

//获取级联
if ($action == 'getarea') {
    $datagroup = isset($datagroup) ? $datagroup : '';
    $level = isset($level) ? $level : '';
    $v = isset($areaval) ? $areaval : '0';


    $str = '<li value="0">选择城市</li>';
    $sql = "SELECT c.* FROM `#@__children` cr left join `#@__cascadedata` c on cr.address_city=c.datavalue WHERE c.level=$level And ";

    if ($v == 0)
        $sql .= "c.datagroup='$datagroup'";
    else if ($v % 500 == 0)
        $sql .= "c.datagroup='$datagroup' AND c.datavalue>$v AND c.datavalue<" . ($v + 500);
    else
        $sql .= "c.datavalue LIKE '$v.%%%' AND c.datagroup='$datagroup'";

    $sql .= " and cr.address_prov='$v' group by cr.address_city ORDER BY c.orderid ASC, c.datavalue ASC";


    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $str .= '<li value="' . $row['datavalue'] . '">' . $row['dataname'] . '</li>';
    }

    if ($str == '')
        $str .= '<li value="0">选择城市</li>';
    echo $str;
    exit();
}