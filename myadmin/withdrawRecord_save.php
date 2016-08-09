<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('withdrawRecord');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 17:16:14
  person: Feng
 * *************************
 */

//初始化参数
$tbname = '#@__withdraw_record';
$gourl = 'withdrawRecord.php';

//引入操作类
require_once(ADMIN_INC . '/action.class.php');

//添加提现记录
if ($action == 'add') {
    
}


//修改提现记录
else if ($action == 'update') {
    
}

//无条件返回
else {
    header("location:$gourl");
    exit();
}
?>