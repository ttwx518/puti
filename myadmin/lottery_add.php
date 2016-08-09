<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('lottery'); 
$type = isset($type) ? $type : 0;
$action = isset($action) ? $action : 'add';
if($action=='update'){
	$row = $dosql->GetOne("SELECT * FROM `#@__lottery` WHERE type=$type");
}
if($type==0){
	$title = '大转盘';
}else{
	$title = '刮刮卡';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加<?php echo $title;?></title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/getuploadify.js"></script>
<script type="text/javascript" src="templates/js/checkf.func.js"></script>
<script type="text/javascript" src="templates/js/getjcrop.js"></script>
<script type="text/javascript" src="templates/js/getinfosrc.js"></script>
<script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="plugin/calendar/calendar.js"></script>
<script type="text/javascript" src="editor/kindeditor-min.js"></script>
<script type="text/javascript" src="editor/lang/zh_CN.js"></script>
<script type="text/javascript">
//验证优惠券添加
function cfm_coupon()
{
	if($("#one_desc").val() == "")
	{
		alert("请填写一等奖！");
		$("#one_desc").focus();
		return false;
	}
	if($("#one").val() == "")
	{
		alert("请填写一等奖数量！");
		$("#one").focus();
		return false;
	}
	if($("#two_desc").val() == "")
	{
		alert("请填写二等奖！");
		$("#two_desc").focus();
		return false;
	}
	if($("#two").val() == "")
	{
		alert("请填写二等奖数量！");
		$("#two").focus();
		return false;
	}
	if($("#three_desc").val() == "")
	{
		alert("请填写三等奖！");
		$("#three_desc").focus();
		return false;
	}
	if($("#three").val() == "")
	{
		alert("请填写三等奖数量！");
		$("#three").focus();
		return false;
	}
    return true;
}
</script>
</head>
<body>
<div class="gray_header"> <span class="title">添加<?php echo $title;?></span> <span class="reload"><a href="javascript:location.reload();">刷新</a></span> </div>
<form name="form" id="form" method="post" action="lottery_save.php" onsubmit="return cfm_coupon();">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
		<?php
		if($action=='update'){
		?>
		<tr>
			<td height="35" align="right">一等奖：</td>
			<td width="250"><input name="one_desc" type="text" id="one_desc" class="input_title" value="<?php echo $row['one_desc'];?>" />
			<td height="35" align="right">数量：</td>
			<td><input name="one" type="text" id="one" class="input_short" value="<?php echo $row['one'];?>" />
            <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">二等奖：</td>
			<td width="250"><input name="two_desc" type="text" id="two_desc" class="input_title" value="<?php echo $row['two_desc'];?>" />
			<td height="35" align="right">数量：</td>
			<td><input name="two" type="text" id="two" class="input_short" value="<?php echo $row['two'];?>" />
            <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">三等奖：</td>
			<td width="250"><input name="three_desc" type="text" id="three_desc" class="input_title" value="<?php echo $row['three_desc'];?>" />
			<td height="35" align="right">数量：</td>
			<td><input name="three" type="text" id="three" class="input_short" value="<?php echo $row['three'];?>" />
            <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td width="25%" height="35" align="right">审核状态：</td>
			<td colspan="3"><input type="radio" name="checkinfo" id="checkinfo1" value="1" <?php if($row['checkinfo']==1){ ?> checked="checked"<?php } ?> />
				直接发布&nbsp;&nbsp;
				<input type="radio" name="checkinfo" id="checkinfo2" value="0" <?php if($row['checkinfo']==0){ ?> checked="checked"<?php } ?> />
                暂不发布</td>
		</tr>
		<?php
		}else{
		?>
		<tr>
			<td height="35" align="right">一等奖：</td>
			<td width="250"><input name="one_desc" type="text" id="one_desc" class="input_title" />
			<td height="35" align="right">数量：</td>
			<td><input name="one" type="text" id="one" class="input_short" />
            <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">二等奖：</td>
			<td width="250"><input name="two_desc" type="text" id="two_desc" class="input_title" />
			<td height="35" align="right">数量：</td>
			<td><input name="two" type="text" id="two" class="input_short" />
            <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">三等奖：</td>
			<td width="250"><input name="three_desc" type="text" id="three_desc" class="input_title" />
			<td height="35" align="right">数量：</td>
			<td><input name="three" type="text" id="three" class="input_short" />
            <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td width="25%" height="35" align="right">审核状态：</td>
			<td colspan="3"><input type="radio" name="checkinfo" id="checkinfo1" value="1" checked="checked" />
				直接发布&nbsp;&nbsp;
				<input type="radio" name="checkinfo" id="checkinfo2" value="0" />
                暂不发布</td>
		</tr>
		<?php
		}
		?>
	</table>
	<div class="subbtn_area">
		<input type="submit" class="blue_submit_btn" value="" />
		<input type="button" class="blue_back_btn" value="" onclick="history.go(-1)"  />
		<input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
		<input type="hidden" name="type" id="type" value="<?php echo $type;?>" />
	</div>
</form>
</body>
</html>