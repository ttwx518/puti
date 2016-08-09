<?php

//!$userInfo && redirectAuth('index.php?c=improve');
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

$success = $error = '';

if (isset($improveSub)) {
    
    $username = isset($username) ? trim($username) : '';
    if(!$username){
        $error = '用户名(手机号)不能为空';
    }
    if(!$error && !isMobileFormat($username)){
        $error = '用户名(手机号)格式错误';
    }
    $usernameExist = $dosql->GetOne("SELECT count(id) num FROM #@__member WHERE username='{$username}'");
    if(!$error && $usernameExist['num'] > 0){
        $error = '该用户名(手机号)已被注册,换一个?';
    }
    
    $mobileCode = isset($mobileCode) ? trim($mobileCode) : '';
    
    $lastMobileCode = $dosql->GetOne("SELECT * FROM #@__sms_record WHERE type='reg' AND mobile='{$username}' ORDER BY sendtime DESC");
    
    $nowTime = time();
    
    if(!$error && empty($lastMobileCode)){
        $error = '验证码超时';
    }else{
        if(!$error && !$mobileCodeError && $nowTime > $lastMobileCode['validtime']){
            $error = '验证码超时';
        }
        if(!$error && !$mobileCodeError && $mobileCode != $lastMobileCode['code']){
            $error = '验证码错误';
        }
    }
    
    $truename = isset($truename) ? trim($truename) : '';
    if(!$error && !$truename){
        $error = '真实姓名不能为空';
    }
    
    $pwd = isset($pwd) ? trim($pwd) : '';
    if(!$error && !$pwd){
        $error = '密码不能为空';
    }
    $pwdLen = strlen($pwd);
    if(!$error && ($pwdLen < 6 || $pwdLen > 20)){
        $error = '密码长度只能在6-20位字符之间';
    }
    
    $repwd = isset($repwd) ? trim($repwd) : '';
    if(!$error && $pwd != $repwd){
        $error = '两次输入的密码不一致';
    }
    
    $wechat_account = isset($wechat_account) ? trim($wechat_account) : '';
    if (!$error && !$wechat_account) {
        $error = '微信号不能为空';
    }
    
    $alipay_account = isset($alipay_account) ? trim($alipay_account) : '';
    if (!$error && !$alipay_account) {
        $error = '支付宝账号不能为空';
    }
    
    if (!$error) {
        $md5Pwd = md5(md5($pwd));
        $result = $dosql->ExecNoneQuery("UPDATE `#@__member` SET username='{$username}' ,truename='{$truename}', password='{$md5Pwd}', mobile='{$username}', wechat_account='{$wechat_account}', alipay_account='{$alipay_account}', isImprove=1 WHERE id={$userInfo['id']}");
        if ($result) {
            $success = '成功: 您的账号资料已完善.';
            $backUrl = getCookie('backUrl');
            redirect($backUrl);
        } else {
            $error = '失败: 系统繁忙,请稍后重试.';
        }
    }
}

$seo = setSeo('完善资料', $cfg_keyword, $cfg_description);
