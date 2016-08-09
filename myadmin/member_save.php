<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('member');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 17:16:14
  person: Feng
 * *************************
 */

//初始化参数
$tbname = '#@__member';
$gourl = 'member.php';

//引入操作类
require_once(ADMIN_INC . '/action.class.php');

//添加会员
if ($action == 'add') {
    if (!isset($enteruser))
        $enteruser = '';
    
//    if(!$recUid){
//        ShowMsg('货主不能为空', '-1');
//        exit();
//    }
    
//    if($recUid != -1){
//        $m = $dosql->GetOne("SELECT username FROM `$tbname` WHERE id={$recUid}");
//        if (empty($m['username'])) {
//            ShowMsg('货主不存在！', '-1');
//            exit();
//        }
//    }
    
    if(!$username){
        ShowMsg('用户名不能为空', '-1');
        exit();
    }
    
    if(!isMobileFormat($username)){
        ShowMsg('用户名格式不正确', '-1');
        exit();
    }
    
    $r = $dosql->GetOne("SELECT username FROM `$tbname` WHERE username='{$username}'");
    if (!empty($r['username'])) {
        ShowMsg('用户名已存在！', '-1');
        exit();
    }

    if (preg_match("/[^0-9a-zA-Z_@!\.-]/", $password)) {
        ShowMsg('用户名或密码非法！请使用[0-9a-zA-Z_@!.-]内的字符！', '-1');
        exit();
    }
    
    if ($password != $repassword) {
        ShowMsg('两次输入的密码不一样！', '-1');
        exit();
    }
    
    if (!$truename) {
        ShowMsg('真实姓名不能为空！', '-1');
        exit();
    }
    
    if (!$wechat_account) {
        ShowMsg('微信号不能为空！', '-1');
        exit();
    }
    
    if (!$alipay_account) {
        ShowMsg('支付宝账号不能为空！', '-1');
        exit();
    }
    
    if(!$mobile){
        ShowMsg('手机号不能为空！', '-1');
        exit();
    }
    
    if(!isMobileFormat($mobile)){
        ShowMsg('手机号格式不正确', '-1');
        exit();
    }
    
    $password = md5(md5($password));
    $regtime = GetMkTime($regtime);
    $regip = GetIP();
    
    $recUserInfo2 = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUid}");
    $recUid2 = $recUserInfo2 ? $recUserInfo2['recUid'] : 0;
    
    $sql = "INSERT INTO `$tbname` (group_id, username, password, mobile, email, qqnum, address_prov, 
            address_city, address_country, address, regtime, regip, logintime, loginip, recUid, recUid2, isReced, 
            alipay_account, wechat_account, wechat_nickname, wechat_sex, wechat_country, wechat_province, 
            wechat_city) VALUES ('$group_id', '$username', '$password', '$mobile', '$email', '$qqnum', 
            '$address_prov', '$address_city', '$address_country', '$address', '$regtime', 
            '$regip', '$regtime', '$regip', '$recUid', '$recUid2', '0', '$alipay_account', '$wechat_account', 
            '$wechat_nickname', '$wechat_sex', '$wechat_country', '$wechat_province', '$wechat_city')";
    
    if ($dosql->ExecNoneQuery($sql)) {
        header("location:$gourl");
        exit();
    }
}


//修改会员信息
else if ($action == 'update') {
    
    $memberInfo = $dosql->GetOne("SELECT recUid,recUid2 FROM #@__member WHERE id={$id}");
    
    if (!isset($enteruser))
        $enteruser = '';
    
//    if(!$recUid){
//        ShowMsg('货主不能为空', '-1');
//        exit();
//    }
//    
//    if($recUid != -1){
//        $m = $dosql->GetOne("SELECT username FROM `$tbname` WHERE id={$recUid}");
//        if (empty($m['username'])) {
//            ShowMsg('货主不存在！', '-1');
//            exit();
//        }
//    }
    
    if ($password != $repassword) {
        ShowMsg('两次输入的密码不一样！', '-1');
        exit();
    }
    
    if (!$truename) {
        ShowMsg('真实姓名不能为空！', '-1');
        exit();
    }
    
    if (!$wechat_account) {
        ShowMsg('微信号不能为空！', '-1');
        exit();
    }
    
    if (!$alipay_account) {
        ShowMsg('支付宝账号不能为空！', '-1');
        exit();
    }
    
    if(!$mobile){
        ShowMsg('手机号不能为空！', '-1');
        exit();
    }
    
    if(!isMobileFormat($mobile)){
        ShowMsg('手机号格式不正确', '-1');
        exit();
    }

    //删除头像
    if (!empty($delavatar)) {
        $avatarsize = array(1 => 'big', 2 => 'middle', 3 => 'small');
        foreach ($avatarsize as $size) {
            file_exists(PHPMYWIND_DATA . '/avatar/' . get_avatar_filepath($id, $size)) && unlink(PHPMYWIND_DATA . '/avatar/' . get_avatar_filepath($id, $size));
        }
    }

    $sql = "UPDATE `$tbname` SET ";
    if ($password != '') {
        $password = md5(md5($password));
        $sql .= "password='$password', ";
    }
    
    $recUserInfo2 = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUid}");
    $recUid2 = $recUserInfo2 ? $recUserInfo2['recUid'] : 0;
    
    $sql .= "truename='$truename', mobile='$mobile', email='$email', 
            qqnum='$qqnum', address_prov='$address_prov', address_city='$address_city', 
            address_country='$address_country', address='$address', recUid='$recUid', recUid2='$recUid2', 
            alipay_account='$alipay_account', wechat_account='$wechat_account', 
            wechat_nickname='$wechat_nickname', wechat_sex='$wechat_sex', wechat_country='$wechat_country', 
            wechat_province='$wechat_province', wechat_city='$wechat_city' WHERE id=$id";
    
    if ($dosql->ExecNoneQuery($sql)) {
        $dosql->ExecNoneQuery("UPDATE `$tbname` SET recUid2={$recUid} WHERE recUid={$id}");
        header("location:$gourl");
        exit();
    }
}


//移除绑定QQ
else if ($action == 'removeoqq') {
    $dosql->ExecNoneQuery("UPDATE `#@__member` SET `qqid`='' WHERE `id`='$id'");
    ShowMsg('解除QQ绑定成功！', 'member_update.php?id=' . $id);
    exit();
}


//移除绑定微博
else if ($action == 'removeoweibo') {
    $dosql->ExecNoneQuery("UPDATE `#@__member` SET `weiboid`='' WHERE `id`='$id'");
    ShowMsg('解除微博绑定成功！', 'member_update.php?id=' . $id);
    exit();
}


//无条件返回
else {
    header("location:$gourl");
    exit();
}
?>