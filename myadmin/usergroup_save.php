<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('usergroup');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 18:06:17
  person: Feng
 * *************************
 */


//初始化参数
$tbname = '#@__usergroup';
$gourl = 'usergroup.php';
$action = isset($action) ? $action : '';


//引入操作类
require_once(ADMIN_INC . '/action.class.php');


//保存操作
if ($action == 'save') {
    if ($groupname_add != '') {
        $dosql->ExecNoneQuery("INSERT INTO `$tbname` (groupname, dqa, dqb, stars, commission) VALUES ('$groupname_add', '$dqa_add', '$dqb_add', '$stars_add', '$commission_add')");
    }

    if (isset($id)) {
        $ids = count($id);
        for ($i = 0; $i < $ids; $i++) {
            $dosql->ExecNoneQuery("UPDATE `$tbname` SET groupname='$groupname[$i]', dqa='$dqa[$i]', dqb='$dqb[$i]', stars='$stars[$i]', commission='$commission[$i]' WHERE id=$id[$i]");
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