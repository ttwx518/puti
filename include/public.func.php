<?php

/**
 * 
 * @global object $dosql
 * @return array $userInfo 用户信息
 */
function isLogin(){
    global $dosql;
    //-----BEGIN 解决cookie问题------
    $clean = 26;
    $c_clean = getCookie('clean');
    if($c_clean != $clean){
        $cookie_time = time()+365*24*60*60;
        $_COOKIE['clean'] = AuthCode($clean,'ENCODE');
        setcookie('clean', AuthCode($clean  ,'ENCODE'), $cookie_time);
    
        delcookie('openid');
        return false;
    }
    //-----END 解决cookie问题------
    
    //获取登录用户信息
    $openid = getCookie('openid');
    $openid = 'oeOj8v5w1sDAZenkLbQawegNsFe4';
    $userInfo = array();
    if($openid){
        $userInfo = $dosql->GetOne("SELECT m.*,g.groupname FROM `#@__member` m LEFT JOIN #@__usergroup g ON m.group_id=g.id WHERE openid='{$openid}'");
        
        // 称号
        $rec=$dosql->GetOne("SELECT count(id) AS num FROM  #@__member where recUid={$userInfo['id']}");// or recUid2={$userInfo['id']}
        if($rec['num']>=200){
            $userInfo['desc']='种子尊者';
            $userInfo['grade']='3';
        }elseif (100<=$rec['num'] && $rec['num']<=199){
            $userInfo['desc']='种子大使';
            $userInfo['grade']='2';
        }else{
            $userInfo['desc']='种子使者';
            $userInfo['grade']='1';
        }
        
        if($userInfo['openid']=='oeOj8v6EUY93W_lJf1-A42bV6c9Y'){
            $userInfo['desc']='种子尊者';
            $userInfo['grade']='3';
        }
        
        !$userInfo && delCookie('openid');
    }
    return $userInfo;
}

// 设置cookies
function setCookies($key, $value){
    $cookie_time = time()+2*24*60*60;
    if(empty($value)){
        $value = "index.php";
    }
    $_COOKIE[$key] = AuthCode($value,'ENCODE');
    setcookie($key,           AuthCode($key  ,'ENCODE'), $cookie_time);
}

/**
 * 授权跳转
 * @global string $cfg_wechat_token
 * @global string $cfg_wechat_appid
 * @global string $cfg_wechat_appsecret
 * @param string $backUrl
 */
function redirectAuth($backUrl){
    global $cfg_wechat_token,$cfg_wechat_appid,$cfg_wechat_appsecret;
    setcookie('backUrl', AuthCode($backUrl, 'ENCODE'));
    require_once('wechat.class.php');
    $wechatConfig = array(
        'token' => $cfg_wechat_token,
        'appid' => $cfg_wechat_appid,
        'appsecret' => $cfg_wechat_appsecret,
        'debug' => false
    );
    $wechat = new wechat($wechatConfig);
    $oauthUrl = $wechat->get_oauth_url();
    redirect($oauthUrl);
}

/**
 * 验证手机格式
 * @param string $subject
 * @return boolean
 */
function isMobileFormat($subject) {
    $pattern = '/^(0|86|17951)?(13[0-9]|15[012356789]|1[78][0-9]|14[57])[0-9]{8}$/';
    return preg_match($pattern, $subject);
}

/**
 * 验证邮箱格式
 * @param string $subject
 * @return boolean
 */
function isEmailFormat($subject) {
    $pattern = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
    return preg_match($pattern, $subject);
}

function replace_specialChar($strParam){
    $regex = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
    return preg_replace($regex,"",$strParam);
}

/**
 * 获取所有用户组
 * @global object $dosql
 * @return array
 */
function getUserGroup(){
    global $dosql;
    $usergroup = array();
    $sql = "SELECT * FROM #@__usergroup";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $usergroup[$row['id']] = $row;
    }
    return $usergroup;
}

/**
 * 获取所有配送方式
 * @global object $dosql
 * @return array
 */
function getPostmode(){
    global $dosql;
    $postmode = array();
    $dosql->Execute("SELECT * FROM `#@__postmode` WHERE checkinfo='true' ORDER BY orderid ASC");
    while ($row = $dosql->GetArray()) {
        $postmode[$row['id']] = $row;
    }
    return $postmode;
}

/**
 * 保存推荐用户id
 * @param int $recUid
 */
function saveRecUser($recUid) {
    global $dosql;
    $historyRecUid = isset($_COOKIE['recUid']) ? $_COOKIE['recUid'] : 0;
    $userExist = $dosql->GetOne("SELECT id FROM #@__member WHERE id={$recUid}");
    if($userExist){
        setcookie('recUid', $userExist['id'], time() + 86400 * 365);
    }else{
        $historyUserExist = $dosql->GetOne("SELECT id FROM #@__member WHERE id={$historyRecUid}");
        if($historyUserExist){
            setcookie('recUid', $historyUserExist['id'], time() + 86400 * 365);
        }
    }
}

/**
 * 获取产品货主
 * @param int $gid 商品id
 * @param int $uid 用户id
 * @param int $recUid 推荐用户id
 */
function getTransporter($gid, $uid, $recUid){
    global $dosql;
    if(!hasBuyItem($gid, $uid)){
        return '';
    }
    $transporter = $dosql->GetOne("SELECT username FROM #@__member WHERE id={$recUid}");
    return $transporter ? $transporter['username'] : '官方商城';
}

/**
 * 判断用户是否购买过某款商品
 * @param int $gid 商品id
 * @param int $uid 用户id
 */
function hasBuyItem($gid, $uid){
    global $dosql;
    $orders = array();
    $dosql->Execute("SELECT id FROM #@__goodsorder WHERE uid={$uid} AND delstate='' AND checkinfo LIKE '%payment%'");
    while ($row = $dosql->GetArray()) {
        $orders[] = $row['id'];
    }
    if(!$orders){
        return false;
    }
    $orderItems = array();
    $dosql->Execute("SELECT * FROM #@__goodsorderitem WHERE orderid IN (".  implode(',', $orders).")");
    while ($row = $dosql->GetArray()) {
        $orderItems[$row['gid']] = $row;
    }
    if(!array_key_exists($gid, $orderItems)){
        return false;
    }
    return true;
}

function listarea($level = 0, $dataval = '', $debug = 0) {
    global $dosql;
    $areas = array();
    $v = isset($dataval) ? $dataval : '0';
    $sql = "SELECT * FROM `#@__cascadedata` WHERE datagroup='area' ";
    if ($level >= 0) {
        if ($v == 0) {
            $sql .= " AND level='{$level}' ";
        } else if ($v % 500 == 0) {
            $sql .= " AND level='{$level}' AND datavalue>'$v' AND datavalue<" . ($v + 500);
        } else {
            $sql .= " AND level='{$level}' AND datavalue LIKE '$v.%%%'";
        }
    }
    $sql .= " ORDER BY orderid ASC, datavalue ASC ";
    if ($debug)
        echo $sql;
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $areas[$row['datavalue']] = $row;
    }
    return $areas;
}

function cecho($arr, $key, $key2 = '', $default = '') {
    if ($key2 == '')
        echo isset($arr[$key]) ? $arr[$key] : $default;
    else
        echo isset($arr[$key][$key2]) ? $arr[$key][$key2] : $default;
}

/**
 * 获取商品列表
 * @param int $page 当前页数
 * @param int $id 商品分类ID
 * @return array 
 */
function getGoodsList($page, $id) {
    global $dosql;
    $id = $id ? intval($id) : 0;
    $return = array('data' => '', 'hasMore' => false);
    $limit = 10;
    $start = ($page - 1) * $limit;
    $where = "checkinfo='true' AND delstate='' AND (typeid={$id} OR typepstr LIKE '%,{$id},%')";
    $total = $dosql->GetOne("SELECT count(id) num FROM `#@__goods` WHERE $where");
    if ($total['num'] > ($page * $limit)){
        $return['hasMore'] = true;
    }
    $sql = "SELECT id,picurl,title,colorval,boldval,flag,marketprice,salesprice FROM `#@__goods` WHERE {$where} ORDER BY orderid ASC LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $style = '';
        if($row['colorval'])
            $style .= 'color:'.$row['colorval'].';';
        if($row['boldval'])
            $style .= 'font-weight:'.$row['boldval'];
        $return['data'] .= '<li><a href="index.php?c=item&id='.$row['id'].'" title="'.$row['title'].'" class="clearfix"';
        if($style)
            $return['data'] .= ' style="'.$style.'"';
        $return['data'] .= '><img data-src="'.$row['picurl'].'" title="'.$row['title'].'" alt="'.$row['title'].'" class="img v mr10" />'.$row['title'].'</a></li>';
    }
    return $return;
}

/**
 * 获取我的订单列表
 * @param string $page 当前页数
 * @param string $flag 订单状态
 * @param ing $uid 用户Id
 */
function getOrdersList($page, $flag, $uid){
    global $dosql;
    $prevurl = 'index.php?c=member&a=order&flag='.$flag.'&page='.($page-1);
    $nexturl = 'index.php?c=member&a=order&flag='.$flag.'&page='.($page+1);
    $return = array('data' => array(), 'hasMore' => false, 'page'=>$page, 'pagesum'=>0, 'prevurl'=>$prevurl,'nexturl'=>$nexturl);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = "uid={$uid} AND `delstate`=''";
    
    if ($flag == 'payment') {  //待付款
        $return['emptyMsg'] = '暂无待付款订单!';
        $where .= " AND checkinfo LIKE '%confirm' AND checkinfo NOT LIKE '%payment%' AND checkinfo NOT LIKE '%cancel%'";
    } else if ($flag == 'postgoods') { //待发货
        $return['emptyMsg'] = '暂无待发货订单!';
        $where .= " AND checkinfo LIKE '%payment'";
    } else if ($flag == 'getgoods') {  //待收货
        $return['emptyMsg'] = '暂无待收货订单!';
        $where .= " AND checkinfo LIKE '%postgoods'";
    } else if ($flag == 'complete') {  //已完成
        $return['emptyMsg'] = '暂无已完成订单!';
        $where .= " AND (checkinfo LIKE '%getgoods' OR checkinfo LIKE '%overorder%') AND checkinfo NOT LIKE '%applyreturn%'";
    } else if ($flag == 'applyreturn') {  //退货/换货
        $return['emptyMsg'] = '暂无退货/换货订单!';
        $where .= " AND checkinfo LIKE '%applyreturn%'";
    }
    $postmode = getPostmode();
    $total = $dosql->GetOne("SELECT count(id) num FROM `#@__goodsorder` WHERE $where");
    $sql = "SELECT * FROM `#@__goodsorder` WHERE {$where} ORDER BY createtime DESC LIMIT $start,$limit";
    $return['pagesum'] = ceil($total['num']/$limit);
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $row['checkinfo'] = explode(',', $row['checkinfo']);
        $row['orderStatus'] = '';
        if (!in_array('applyreturn', $row['checkinfo']) && !in_array('agreedreturn', $row['checkinfo']) && !in_array('goodsback', $row['checkinfo']) && !in_array('moneyback', $row['checkinfo']) && !in_array('overorder', $row['checkinfo']) && !in_array('cancel', $row['checkinfo'])) {
            if ($row['checkinfo'] == '' or !in_array('confirm', $row['checkinfo']))
                $row['orderStatus'] = '待确认';
            else if (!in_array('payment', $row['checkinfo'])){
                $row['orderStatus'] = '待付款';
                $row['status'] = '1';
            }
            else if (!in_array('postgoods', $row['checkinfo'])){
                $row['orderStatus'] = '待发货';
                $row['status'] = '2';
            }
            else if (!in_array('getgoods', $row['checkinfo'])){
                $row['orderStatus'] = '待收货';
                $row['status'] = '3';
            }
            else if (!in_array('overorder', $row['checkinfo']))
                $row['orderStatus'] = '待完成';
            else
                $row['orderStatus'] = '无状态';
        }
        else {
            if (in_array('overorder', $row['checkinfo'])){
                $row['orderStatus'] = '已完成';
                $row['status'] = '4';
            }
            else if (in_array('moneyback', $row['checkinfo']))
                $row['orderStatus'] = '待完成';
            else if (in_array('goodsback', $row['checkinfo']))
                $row['orderStatus'] = '待退款';
            else if (in_array('agreedreturn', $row['checkinfo']))
                $row['orderStatus'] = '待返货';
            else if (in_array('applyreturn', $row['checkinfo']))
                $row['orderStatus'] = '申请退货/换货';
            else if (in_array('cancel', $row['checkinfo']))
                $row['orderStatus'] = '已取消';
            else
                $row['orderStatus'] = '无状态';
        }
        $dosql->Execute("SELECT * FROM `#@__goodsorderitem` WHERE orderid={$row['id']}", 'items');
        while ($row2 = $dosql->GetArray('items')) {
            $infolist=$dosql->GetOne("SELECT * FROM `#@__infolist` WHERE delstate='' AND checkinfo='true' AND id= ".$row2['gid']);
            $row2['islucky'] = empty($infolist['islucky'])?'':$infolist['islucky'];
            $row2['isgift'] = empty($infolist['isgift'])?'':$infolist['isgift'];
            $goods=$dosql->GetOne("SELECT * FROM `#@__goods` WHERE id= ".$row2['gid']);
            $row2['typepid'] = empty($goods['typepid'])?'':$goods['typepid'];
            $row['goodsList'][]=$row2;
        }
        $row['postname'] = $postmode[$row['postmode']]['classname'];
        $row['postcode'] = $postmode[$row['postmode']]['postcode'];
        $return['data'][] = $row;
        
        
        if($flag == 'complete'){
            $dosql->ExecNoneQuery("UPDATE #@__goodsorder SET completedShow=0 WHERE id={$row['id']}");
        }
    }
    return $return;
}

/**
 * 获取我的地址列表
 * @param string $page 当前页数
 * @param ing $uid 用户Id
 * @param string $redirect 跳转地址
 */
function getAddressList($page, $uid, $redirect){
    global $dosql;
    $return = array('data' => '', 'hasMore' => false);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = "uid={$uid}";
    $areas = listarea(-1);
    $total = $dosql->GetOne("SELECT count(id) num FROM `#@__useraddress` WHERE $where");
    if ($total['num'] > ($page * $limit)){
        $return['hasMore'] = true;
    }
    $sql = "SELECT * FROM `#@__useraddress` WHERE {$where} ORDER BY isDefault DESC,id DESC LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $prov = isset($areas[$row['prov']]) ? $areas[$row['prov']]['dataname'] : '';
        $city = isset($areas[$row['city']]) ? $areas[$row['city']]['dataname'] : '';
        $country = isset($areas[$row['country']]) ? $areas[$row['country']]['dataname'] : '';
        $editUrl = 'index.php?c=member&a=editAddress&id='.$row['id'].'&redirect='.$redirect;
        $defUrl = 'index.php?c=member&a=setDefaultAddress&id='.$row['id'].'&redirect='.$redirect;
        $delUrl = 'index.php?c=member&a=delAddress&id='.$row['id'].'&redirect='.$redirect;
        
        if($row['isDefault']){
            $return['data'] .= '<li class="on hasdot"> <span class="br5 status">默认地址</span>
                          <div class="item">
                            <div class="item-hd"><span class="user">'.$row['name'].'</span><span class="tel">'.$row['mobile'].'</span></div>
                            <div class="item-bd">'.$prov.' '.$city.' '.$country.'  '.$row['address'].'</div>
                            <div class="item-ft"><span class="fr link"><a href="'.$editUrl.'" class="edit">编辑</a><a href="'.$delUrl.'" class="del" onclick="return confirm(\'确认删除该收货地址吗?\')">删除</a></span></div>
                          </div>
                        </li>';
        }else{
            $return['data'] .= '<li>
                      <div class="item">
                        <div class="item-hd"><span class="user">'.$row['name'].'</span><span class="tel">'.$row['mobile'].'</span></div>
                        <div class="item-bd">'.$prov.' '.$city.' '.$country.'  '.$row['address'].'</div>
                        <div class="item-ft"><a href="'.$defUrl.'" class="fl br5 set">设为默认地址</a><span class="fr link"><a href="'.$editUrl.'" class="edit">编辑</a><a href="'.$delUrl.'" class="del" onclick="return confirm(\'确认删除该收货地址吗?\')">删除</a></span></div>
                      </div>
                    </li>';
        }
        
    }
    return $return;
}

/**
 * 获取我的佣金可提现记录列表
 * @param string $page 当前页数
 * @param ing $uid 用户Id
 */
function getYtxList($page, $uid){
    global $dosql;
    $prevurl = 'index.php?c=member&a=ytx&page='.($page-1);
    $nexturl = 'index.php?c=member&a=ytx&page='.($page+1);
    $return = array('data' => array(), 'hasMore' => false, 'page'=>$page, 'pagesum'=>0, 'prevurl'=>$prevurl,'nexturl'=>$nexturl);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = "uid={$uid}";
    $status = array(0=>'待审核',1=>'提现失败',2=>'提现成功');
    $total = $dosql->GetOne("SELECT count(id) num FROM `#@__withdraw_record` WHERE $where");
    $return['pagesum'] = ceil($total['num']/$limit);
    $sql = "SELECT * FROM `#@__withdraw_record` WHERE {$where} ORDER BY createtime DESC LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $row['status'] = $status[$row['status']];
        $return['data'][]=$row;
    }
    
    return $return;
}

/**
 * 获取我的佣金累计收入记录列表
 * @param string $page 当前页数
 * @param ing $uid 用户Id
 */
function getLjsrList($page, $uid){
    global $dosql;
    $return = array('data' => '', 'hasMore' => false);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = "c.uid={$uid}";
    $total = $dosql->GetOne("SELECT count(id) num FROM `#@__commission_record` c WHERE $where");
    if ($total['num'] > ($page * $limit)){
        $return['hasMore'] = true;
    }
    $sql = "SELECT c.*,o.checkinfo FROM `#@__commission_record` c LEFT JOIN #@__goodsorder o ON c.orderid=o.id WHERE {$where} ORDER BY c.createtime DESC LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $row['checkinfo'] = explode(',', $row['checkinfo']);
        $row['orderStatus'] = '';
        if (!in_array('applyreturn', $row['checkinfo']) && !in_array('agreedreturn', $row['checkinfo']) && !in_array('goodsback', $row['checkinfo']) && !in_array('moneyback', $row['checkinfo']) && !in_array('overorder', $row['checkinfo']) && !in_array('cancel', $row['checkinfo'])) {
            if ($row['checkinfo'] == '' or !in_array('confirm', $row['checkinfo']))
                $row['orderStatus'] = '待确认';
            else if (!in_array('payment', $row['checkinfo']))
                $row['orderStatus'] = '待付款';
            else if (!in_array('postgoods', $row['checkinfo']))
                $row['orderStatus'] = '待发货';
            else if (!in_array('getgoods', $row['checkinfo']))
                $row['orderStatus'] = '待收货';
            else if (!in_array('overorder', $row['checkinfo']))
                $row['orderStatus'] = '待完成';
            else
                $row['orderStatus'] = '无状态';
        }
        else {
            if (in_array('overorder', $row['checkinfo']))
                $row['orderStatus'] = '已完成';
            else if (in_array('moneyback', $row['checkinfo']))
                $row['orderStatus'] = '待完成';
            else if (in_array('goodsback', $row['checkinfo']))
                $row['orderStatus'] = '待退款';
            else if (in_array('agreedreturn', $row['checkinfo']))
                $row['orderStatus'] = '待返货';
            else if (in_array('applyreturn', $row['checkinfo']))
                $row['orderStatus'] = '申请退货/换货';
            else if (in_array('cancel', $row['checkinfo']))
                $row['orderStatus'] = '已取消';
            else
                $row['orderStatus'] = '无状态';
        }
        $return['data'] .= '<tr><td>'.$row['amount'].'</td>
                            <td>'.date('Y-m-d H:i',$row['createtime']).'</td>
                            <td>已发放</td></tr>';//'.$row['orderStatus'].'
    }
    return $return;
}

/**
 * 获取佣金商品明细记录
 * @param int $uid 用户id
 * @return array
 */
function getYjItemList($page, $uid, $type=1){
    global $dosql;

    $prevurl = 'index.php?c=member&a=results&page='.($page-1);
    $nexturl = 'index.php?c=member&a=results&page='.($page+1);
    $return = array('data' => array(), 'hasMore' => false, 'page'=>$page, 'pagesum'=>0, 'prevurl'=>$prevurl,'nexturl'=>$nexturl);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = " i.type={$type} and i.uid={$uid}";
    $total = $dosql->GetOne("SELECT count(i.id) num FROM `#@__integral` as i left join `#@__member` as m on i.fuid=m.id WHERE $where");
    $return['pagesum'] = ceil($total['num']/$limit);
    $sql = "SELECT m.wechat_nickname, i.* FROM `#@__integral` as i left join `#@__member` as m on i.fuid=m.id WHERE {$where} ORDER BY posttime DESC LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $return['data'][]=$row;
    }
    
    return $return;
}

/**
 * 获取文章列表(活动动态和庙宇介绍)
 * @param int $uid 用户id
 * @return array
 */
function getInfoList($page, $clsid, $a, $type=3){
    global $dosql;

    $prevurl = 'index.php?c=info&a='.$a.'&clsid='.$clsid.'&page='.($page-1);
    $nexturl = 'index.php?c=info&a='.$a.'&clsid='.$clsid.'&page='.($page+1);
    $return = array('data' => array(), 'hasMore' => false, 'page'=>$page, 'pagesum'=>0, 'prevurl'=>$prevurl,'nexturl'=>$nexturl);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = " classid={$clsid} AND delstate='' AND checkinfo='true'";
    $total = $dosql->GetOne("SELECT count(id) as num FROM `#@__infolist` WHERE {$where}");
    $return['pagesum'] = ceil($total['num']/$limit);

    $sql = "SELECT * FROM `#@__infolist` WHERE {$where} ORDER BY orderid desc LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        $row['btnurl']='';
        $row['btntext']='';
        $row['css']='';
        //status-3
        $curtime = time();
        if($curtime<$row['starttime'] && $type == 1){
            $row['css']='status-1';
            $row['btntext']='未开始';
            $return['data'][]=$row;
        }
        else if($row['starttime']<$curtime && $curtime<$row['endtime'] && $type == 3){
            $row['css']='status-3';
            $row['btntext']='进行中';
            $return['data'][]=$row;
        }
        else if($curtime>$row['endtime'] && $type == 2){
            $row['css']='status-2';
            if(!empty($row['videourl'])){
                $row['btnurl']=$row['videourl'];
            }
            $row['btntext']='已结束';
            $return['data'][]=$row;
        }
    }

    return $return;
}

/**
 * 我的团队记录
 * @param int $uid 用户id
 * @return array
 */
function getDistributorsList($page, $uid){
    global $dosql;
    $prevurl = 'index.php?c=member&a=distributors&page='.($page-1);
    $nexturl = 'index.php?c=member&a=distributors&page='.($page+1);
    $return = array('data' => array(), 'hasMore' => false, 'page'=>$page, 'pagesum'=>0, 'prevurl'=>$prevurl,'nexturl'=>$nexturl,'totalnum'=>0);
    $limit = MOBILE_LIMIT;
    $start = ($page - 1) * $limit;
    $where = " recUid={$uid} or recUid2={$uid}";
    $total = $dosql->GetOne("SELECT count(id) num FROM `#@__member` WHERE $where");
    $return['pagesum'] = ceil($total['num']/$limit);
    $return['totalnum'] = $total['num'];
    $sql = "SELECT wechat_nickname,wechat_headimgurl, regtime, recUid, recUid2 FROM `#@__member` WHERE {$where} ORDER BY regtime DESC LIMIT $start,$limit";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()) {
        if($row['recUid']==$uid){
            $row['rec']='种子天使';
        }
        if($row['recUid2']==$uid){
            $row['rec']='种子宝贝';
        }
        $return['data'][]=$row;
    }

    return $return;
}

/**
 * 获取佣金商品明细记录
 * @param int $uid 用户id
 * @param string $type 佣金类型
 * @param int $id 商品id
 * @return array
 */
function getUserYjList($uid, $type, $id){
    global $dosql;
    $records = $data = array();
    $totalC = $totalS = $totalY = 0;
    //获取我的分销业绩
    $dosql->Execute("SELECT * FROM `#@__commission_record` WHERE uid={$uid} AND type='{$type}' ORDER BY createtime DESC");
    while ($row = $dosql->GetArray()) {
        $records[$row['orderid']] = $row;
    }
    if ($records) {
        $orderids = implode(',', array_keys($records));
        $dosql->Execute("SELECT i.orderid,i.directCommission,i.indirectCommission,i.buyNum,m.id,m.wechat_nickname,m.wechat_headimgurl FROM `#@__goodsorderitem` i LEFT JOIN #@__goodsorder o ON i.orderid=o.id LEFT JOIN #@__member m ON o.uid=m.id WHERE i.orderid IN ({$orderids}) AND i.gid={$id}");
        while ($row = $dosql->GetArray()) {
            $type = $records[$row['orderid']]['type'];
            if($type == 'direct'){
                $yongjin = $row['directCommission'];
            }elseif($type == 'indirect'){
                $yongjin = $row['indirectCommission'];
            }
            if(!array_key_exists($row['id'].$yongjin, $data)){
                $data[$row['id'].$yongjin] = array(
                    'avator' => $row['wechat_headimgurl'],
                    'name' => $row['wechat_nickname'],
                    'saleNum' => $row['buyNum'],
                    'yongjin' => $yongjin
                );
            }else{
                $data[$row['id'].$yongjin]['saleNum'] += $row['buyNum'];
            }
            $totalC += 1;
            $totalS += $row['buyNum'];
            $totalY += $yongjin;
        }
    }
    return array('data' => $data, 'totalC' => $totalC, 'totalS' => $totalS, 'totalY' => $totalY);
}


/**
 * 种子分成 & 种子抵扣  计算
 * @param $orderid 订单编号
 * @return boolean
 */
function generate_percentage($ordernum){
    global $dosql, $cfg_commission_self, $cfg_commission_parent, $cfg_commission_gparent, $cfg_webname;
    $order = $dosql->GetOne("SELECT * FROM `#@__goodsorder` WHERE ordernum='{$ordernum}'");
    if(empty($order) || $order['yongji_status'] == '1'){
        return false;
    }

    // 购物者自己的积分和现金抵扣 计算
    $user = $dosql->GetOne("SELECT * FROM `#@__member` WHERE id={$order['uid']}");
    if(empty($user)){
        return false;
    }
    
    /*
     * 先判断是否为活动,
     * 如果为活动,走活动的分成
     * 计算完成直接return rue
     * 结束返利
     */
    if(!empty($order['auid'])){
        // 活动发起人
        $auser = $dosql->GetOne("SELECT * FROM `#@__member` WHERE id={$order['auid']}");
        if(empty($auser)){
            return false;
        }
        // 查找活动
        $infolist = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE id={$order['aid']}");
        if(empty($infolist)){
            return false;
        }
        $diff_fee = ceil($order['goodsAmount'] * intval($infolist['commission_percent']) / 100);
        $wxmsg = "种子使者【".$user['wechat_nickname']."】在“".$infolist['title']."”活动参与爱心认养，认养金额为：".$order['goodsAmount']."元，您获得由“".$cfg_webname."”赠送的".$diff_fee."粒种子作为种子活动爱心推广。";
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin + {$diff_fee}, totalyongjin=totalyongjin + {$diff_fee} where id={$auser['id']}");
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET jifen=jifen + {$order['goodsAmount']} where id={$user['id']}");
        // 活动购买者
        operate_commision($user['id'], 0, '+', '', $order['ordernum'], $user['id'],'您在“'.$infolist['title'].'”活动认养已成功。',1);
        // 活动发起人
        operate_commision($auser['id'], $diff_fee, '+', '活动奖励', $order['ordernum'], $user['id'],$wxmsg,1);
        return true;
    }
    
    // 种子抵现
    if(!empty($order['useintegral']) && !empty($user)){
        $diff_fee = $order['useintegral'];
        $wxmsg = "您在【".$cfg_webname."】种子商城认购部分商品，认购金额为：".$order['goodsAmount']."元，使用爱心种子抵现".$diff_fee."粒种子。";
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin - {$diff_fee} where id={$user['id']}");
        operate_commision($user['id'], $diff_fee, '-', '种子抵扣', $order['ordernum'], $user['id'], $wxmsg,2);
    }
    
    
    // 购物返现
    if(!empty($user)){
        $diff_fee = ceil($order['goodsAmount'] * $cfg_commission_self / 100);
        $wxmsg = "您在【".$cfg_webname."】种子商城认购部分商品，认购金额为：".$order['goodsAmount']."元，您获得由“".$cfg_webname."”赠送的".$diff_fee."粒种子作为爱心种子奖励。";
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin + {$diff_fee}, totalyongjin=totalyongjin + {$diff_fee} where id={$user['id']}");
        operate_commision($user['id'], $diff_fee, '+', '购物奖励', $order['ordernum'], $user['id'],$wxmsg,1);
    }
    
    // 上1 直接上级
    $recUser = $dosql->GetOne("SELECT * FROM `#@__member` WHERE id={$user['recUid']}");
    if(!empty($recUser) && !empty($user)) {
        $diff_fee = ceil($order['goodsAmount'] * $cfg_commission_parent / 100);
        $wxmsg = "种子使者【".$user['wechat_nickname']."】在“".$cfg_webname."”种子商城认购部分商品，认购金额为：".$order['goodsAmount']."元，您获得由“".$cfg_webname."”赠送的".$diff_fee."粒种子作为爱心种子推广奖励。";
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin + {$diff_fee}, totalyongjin=totalyongjin + {$diff_fee} where id={$recUser['id']}");
        operate_commision($recUser['id'], $diff_fee, '+', '团队奖励', $order['ordernum'], $user['id'],$wxmsg,1);
    }

    // 上2 隔代上级
    if(!empty($recUser)){
        $recUser2 = $dosql->GetOne("SELECT * FROM `#@__member` WHERE id={$user['recUid2']}");
    }
    if(!empty($recUser2)){
        $diff_fee = ceil($order['goodsAmount'] * $cfg_commission_gparent / 100);
        $wxmsg = "种子使者【".$user['wechat_nickname']."】在“".$cfg_webname."”种子商城认购部分商品，认购金额为：".$order['goodsAmount']."元，您获得由“".$cfg_webname."”赠送的".$diff_fee."粒种子作为爱心种子推广奖励。";
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin + {$diff_fee}, totalyongjin=totalyongjin + {$diff_fee} where id={$recUser2['id']}");
        operate_commision($recUser2['id'], $diff_fee, '+', '团队奖励', $order['ordernum'], $user['id'],$wxmsg,1);
    }

    // 修改订单分成状态，防止重复分成
    $dosql->ExecNoneQuery("UPDATE `#@__goodsorder` SET yongji_status='1' where ordernum='{$ordernum}'");
    return true;
}

/**
* 佣金记录
* @param string $username
* @param string $integral
* @param string $type + or -
* @param string $content 事由： 推广费。。。
* @param string $ordernum
* @return boolean
*/
function operate_commision($uid, $integral, $type, $content, $ordernum='', $fuid, $wxmsg,$type=1){
    global $dosql;

    // 微信提示到账
    $member = $dosql->GetOne("SELECT * FROM `#@__member` WHERE id=$uid");
    sendwechat($member['openid'],$wxmsg);

    $time = time();
    if($integral > 0){
        $integral = $type.$integral;
        $ret = $dosql->ExecNoneQuery("INSERT INTO `#@__integral`(uid,ordernum,integral,posttime,content,fuid,type)
            VALUES ({$uid},'{$ordernum}','{$integral}',{$time},'{$content}',{$fuid},$type)");
        return $ret;
    }
}

/**
 * 下单发送提醒
 * @param string $orderunm 订单号
 * @param string $posttime 下单时间
 */
function sendwechat($openid,$wxmsg=''){
    global $dosql,$cfg_wechat_token,$cfg_wechat_appid,$cfg_wechat_appsecret;
    //发送微信通知
    if(!empty($wxmsg)){
        require_once('wechat.class.php');
        $wechatConfig = array(
            'token' => $cfg_wechat_token,
            'appid' => $cfg_wechat_appid,
            'appsecret' => $cfg_wechat_appsecret,
            'debug' => false
        );
        $wechat = new wechat($wechatConfig);
        $data = array(
            'touser' => $openid,
            'msgtype' => 'text',
            'text'=>array("content"=>$wxmsg)
        );
        $wechat->sendCustomMessage($data);
    }
}


/**
 * 生成二维码
 * @param unknown $_member_id
 */
function addQrcodeToScenePic() {
    global $userInfo;
    // 判断是否存在
    if(file_exists("uploads/qrcode/" . $userInfo['openid'] . '.jpg')){
        return false;
    }
    $dst = STATIC_PATH."images/ewm.jpg";
    //得到原始图片信息
    $dst_im = imagecreatefromjpeg($dst);
    //水印图像
    $src = $userInfo['wechat_qrurl'];
    $src_im = imagecreatefromjpeg($src);
    $thumb = imagecreatetruecolor(272, 272);
    // Resize
    imagecopyresized($thumb, $src_im, 0, 0, 0, 0, 272, 272, 430, 430);
    //水印透明度
    $alpha = 100;
    //合并水印图片
    //imagecopymerge(原圖Resource, 浮水印圖Resource, 浮水印要放的目標位置x, 浮水印要放的目標位置y, 0, 0, 浮水印圖的寬度, 浮水印圖的高度, alpha transparency);
    imagecopymerge($dst_im, $thumb, 0, 0, 0, 0, 272, 272, $alpha);
    //输出合并后水印图片
    imagejpeg($dst_im, "uploads/qrcode/" . $userInfo['openid'] . '.jpg');//
}

/**
 * 判断是否种子兑换
 * @param unknown $tid 商品类别ID
 */
function isDuiHuan($typepid){
    if($typepid == 4)
        return true;
    return false;
}

/**
 * 判断是否种子兑换或认养积分兑换
 * @param unknown $tid 商品类别ID
 */
function isDuiHuanOrGift($typepid){
    if($typepid == 4)
        return true;
    if($typepid == 20)
        return true;
    return false;
}

/**
 * 根据种类 显示售卖单位
 * @param unknown $tid 商品类别ID
 */
function getUnits($typepid){
    if($typepid == 4)
        return '粒';
    if($typepid == 20)
        return '积分';
    return '元';
}

/**
 * 根据种类 显示商品详情价格 格式1
 * @param unknown $tid 
 */
function getTotalUnits($typepid,$val){
    if($typepid == 4)
        return '种子:'.number_format($val, 0).'粒';
    if($typepid == 20)
        return '积分:'.number_format($val, 0);
    return '￥'.number_format($val, 2).'元';
}

/**
 * 根据种类 显示商品详情价格 格式2
 * @param unknown $tid
 */
function getTotalUnits2($typepid,$val){
    if($typepid == 4)
        return number_format($val, 0).'粒';
    if($typepid == 20)
        return number_format($val, 0).'积分';
    return '￥'.number_format($val, 0);
}

/**
 * 计算价格
 * 根据会员级别来计算价格
 * @param unknown $goods
 * @return Ambigous <number, unknown>
 */
function calcPrice($goods){
    global $userInfo;
    $price = 0;
    // 大使
    if($userInfo['grade']=='2'){
        $price = $goods['salesprice_dashi'];
    }
    // 天使
    elseif($userInfo['grade']=='3'){
        $price = $goods['salesprice_tianshi'];
    }else{
        $price = $goods['salesprice'];
    }
    if(empty($price)){
        $price = $goods['salesprice'];
    }
    return $price;
}