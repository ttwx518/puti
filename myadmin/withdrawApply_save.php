<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('withdrawApply');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 17:16:14
  person: Feng
 * *************************
 */

//初始化参数
$tbname = '#@__withdraw_record';
$gourl = 'withdrawApply.php';

//引入操作类
require_once(ADMIN_INC . '/action.class.php');

//添加提现记录
if ($action == 'add') {
    
}


//修改提现记录
else if ($action == 'update') {
    
    $withdraw = $dosql->GetOne("SELECT * FROM #@__withdraw_record WHERE id={$id}");
    
    /*
    if(!$alipayAccount){
        ShowMsg('支付宝账号不能为空', '-1');
        exit();
    }
    
    if (!$truename) {
        ShowMsg('真实姓名不能为空！', '-1');
        exit();
    }
    
    if (!$amount) {
        ShowMsg('提现金额不能为空！', '-1');
        exit();
    }
    */
    
    $sql = "UPDATE #@__withdraw_record SET reason='{$reason}'";
    
    if(!$withdraw['status'] && isset($status)){
        $sql .= ",status='{$status}'";
    }
    
    $sql .= " WHERE id={$id}";
    
    if ($dosql->ExecNoneQuery($sql)) {
        header("location:$gourl");
        exit();
    }
}

//批量审核
else if ($action == 'upall2'){
    $checkid = isset($checkid) ? $checkid : '';
    $status = isset($status) ? $status : '';
    if(!$checkid){
        ShowMsg('没有选中任何信息');
        exit();
    }
    if($status != 1 && $status != 2){
        ShowMsg('参数错误');
        exit();
    }
    $checkid = implode(',', $checkid);
    if($dosql->ExecNoneQuery("UPDATE #@__withdraw_record SET status={$status} WHERE id IN ({$checkid})")){
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