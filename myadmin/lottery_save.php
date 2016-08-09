<?php	require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('lottery');

/*
**************************
(C)2010-2013 phpMyWind.com
update: 2011-1-20 10:12:28
person: Feng
**************************
*/


//初始化参数
$tbname = '#@__lottery';
$gourl  = 'lottery.php';
$action = isset($action) ? $action : '';


//添加商品信息
if($action == 'add')
{
	//栏目权限验证
	//IsCategoryPriv($classid,'add');
	$one_desc = addslashes($one_desc);
    $two_desc = addslashes($two_desc);
    $three_desc = addslashes($three_desc);
    $one = addslashes($one);
    $two = addslashes($two);
    $three = addslashes($three);
    $type = addslashes($type);
    $checkinfo = addslashes($checkinfo);
    //$score = $type == 1 ? $score : 0;
    $sql = "INSERT INTO `$tbname` (`one_desc`, `two_desc`, `three_desc`, `one`, `two`, `three`, `one_left`, `two_left`, `three_left`, `type`, `checkinfo`) VALUES ('$one_desc', '$two_desc', '$three_desc', $one, $two, $three, $one, $two, $three, $type, $checkinfo)";
    $dosql->ExecNoneQuery($sql);
    header("location:$gourl?type=$type");
	exit();
}

// //修改商品信息
// else if($action == 'update')
// {
// 	$one_desc = addslashes($one_desc);
//     $two_desc = addslashes($two_desc);
//     $three_desc = addslashes($three_desc);
//     $one = addslashes($one);
//     $two = addslashes($two);
//     $three = addslashes($three);
//     $type = addslashes($type);
//     $checkinfo = addslashes($checkinfo);
//     //$score = $type == 1 ? $score : 0;
//     $sql = "UPDATE `$tbname` SET `one_desc`='$one_desc', `two_desc`='$two_desc', `three_desc`='$three_desc', `one`=$one, `two`=$two, `three`=$three, `checkinfo`=$checkinfo WHERE `type`=$type";
//     $dosql->ExecNoneQuery($sql);
//     header("location:$gourl?type=$type");
// 	exit();
// }

//兑奖
else if($action == 'update')
{
    $checkinfo = empty($checkinfo)?0:$checkinfo;
    $sql = "UPDATE `$tbname` SET  checkinfo='{$checkinfo}' WHERE id={$id}";
    if($dosql->ExecNoneQuery($sql))
    {
        header("location:$gourl");
        exit();
    }
}

else if($action == 'check')
{
	$sql = "UPDATE `$tbname` SET `status`=1 WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}
else if($action == 'uncheck')
{
	$sql = "UPDATE `$tbname` SET `status`=0 WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}
else if($action == 'del')
{
	$sql = "UPDATE `$tbname` SET `status`=2 WHERE id=$id";
	if($dosql->ExecNoneQuery($sql))
	{
		header("location:$gourl");
		exit();
	}
}
else if($action == 'use')
{
	$row = $dosql->GetOne("SELECT * FROM `#@__couponrel` WHERE ticket_num='$ticket_num' ");
	if(empty($row)){
		ShowMsg('优惠券号输入有误！','coupon.php');
		exit();
	}else if($row['status']==1){
		ShowMsg('该优惠券已被使用！','coupon.php');
		exit();
	}else if($row['status']==0){
		$sql = "UPDATE `#@__couponrel` SET `status`=1 WHERE ticket_num='$ticket_num'";
		if($dosql->ExecNoneQuery($sql))
		{
			ShowMsg('该优惠券有效，使用成功！','coupon.php');
			exit();
		}
	}
}
//无状态返回
else
{
	header("location:$gourl");
	exit();
}
?>