<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('integralrule');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 14:00:14
  person: Feng
 * *************************
 */


//初始化参数
$tbname = '#@__integralrule';
$gourl = 'integralrule.php';


//引入操作类
require_once(ADMIN_INC . '/action.class.php');


//保存货到方式
if ($action == 'save') {
    if ($classnameadd != '') {
        $dosql->ExecNoneQuery("INSERT INTO `$tbname` (classname, identify, integral, limits, orderid, checkinfo) VALUES ('$classnameadd', '$identifyadd', '$integraladd', '$limitsadd', '$orderidadd', '$checkinfoadd')");
    }

    if (isset($id)) {
        $ids = count($id);
        for ($i = 0; $i < $ids; $i++) {
            $dosql->ExecNoneQuery("UPDATE `$tbname` SET orderid='$orderid[$i]', classname='$classname[$i]', identify='$identify[$i]', integral='$integral[$i]', limits='$limits[$i]' WHERE `id`=$id[$i]");
        }
    }

    header("location:$gourl");
    exit();
}


//无条件返回
else {
    header("location:$gourl");
    exit();
}
?>