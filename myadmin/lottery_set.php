<?php require(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('infoimg'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大转盘设置</title>
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
		alert("请填写一等奖奖励积分！");
		$("#one").focus();
		return false;
	}

    if($("#one_left").val() == "")
    {
        alert("请填写一等奖中奖概率！");
        $("#one_left").focus();
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
		alert("请填写二等奖奖励积分！");
		$("#two").focus();
		return false;
	}
    if($("#two_left").val() == "")
    {
        alert("请填写二等奖中奖概率！");
        $("#two_left").focus();
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
		alert("请填写三等奖奖励积分！");
		$("#three").focus();
		return false;
	}
    if($("#three_left").val() == "")
    {
        alert("请填写三等奖中奖概率！");
        $("#three_left").focus();
        return false;
    }
    return true;
}
</script>
</head>
<body>
<?php
$row = $dosql->GetOne("SELECT * FROM `#@__lottery` WHERE id='1'");
?>
<div class="topToolbar"> <span class="title">大转盘设置</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="lucky_set_save.php" onsubmit="return cfm_coupon();">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
        <tr>
			<td height="35" align="right">大转盘地址：</td>
			<td width="250"><?php echo $cfg_weburl."wx/lucky.php"?></td>
			<td height="35" align="right"></td>
            <td></td>
		</tr>
		<tr>
			<td height="35" align="right">一等奖：</td>
			<td width="250"><input name="one_desc" type="text" id="one_desc" class="input" value="<?php echo $row['one_desc'];?>" /></td>
			<td height="35" align="right">预期数量：</td>
            <td><input name="one_left" type="text" id="one_left" class="input" value="<?php echo $row['one_left'];?>" />
                <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">二等奖：</td>
			<td width="250"><input name="two_desc" type="text" id="two_desc" class="input" value="<?php echo $row['two_desc'];?>" /></td>
			<td height="35" align="right">预期数量：</td>
            <td><input name="two_left" type="text" id="two_left" class="input" value="<?php echo $row['two_left'];?>" />
                <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">三等奖：</td>
			<td width="250"><input name="three_desc" type="text" id="three_desc" class="input" value="<?php echo $row['three_desc'];?>" /></td>
			<td height="35" align="right">预期数量：</td>
            <td><input name="three_left" type="text" id="three_left" class="input" value="<?php echo $row['three_left'];?>" />
                <span class="maroon">*</span> </td>
		</tr>
		<tr>
			<td height="35" align="right">每天抽奖次数：</td>
			<td width="250"><input name="chance" type="text" id="chance" class="inputs" value="<?php echo $row['chance'];?>" /></td>
            <td height="35" align="right">预计参与人数：</td>
            <td><input name="budget" type="text" id="budget" class="inputs" value="<?php echo $row['budget'];?>" /></td>
		</tr>
            <tr>
                <td  align="right">活动内容：</td>
                <td colspan="3"><textarea name="content" id="content" class="kindeditor"><?php echo $row['content'];?></textarea>
                    <script>
                        var editor;
                        KindEditor.ready(function(K) {
                            editor = K.create('textarea[name="content"]', {allowFileManager : true,width:'667px',height:'280px'});
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td  align="right">活动规则：</td>
                <td colspan="3"><textarea name="rule" id="rule" class="kindeditor"><?php echo $row['rule'];?></textarea>
                    <script>
                        var editor;
                        KindEditor.ready(function(K) {
                            editor = K.create('textarea[name="rule"]', {allowFileManager : true,width:'667px',height:'280px'});
                        });
                    </script>
                </td>
            </tr>
	</table>
	<div class="" style="text-align: center; margin-top: 20px;">
		<input type="submit" class="blue_submit_btn" value="提交" style="height: 28px; width: 80px;" />
		<input type="button" class="blue_back_btn" value="返回" onclick="history.go(-1)" style="height: 28px; width: 80px;" />
		<input type="hidden" name="action" id="action" value="update" />
	</div>
</form>
</body>
</html>