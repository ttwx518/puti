<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('withdrawApply');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>修改提现申请</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/checkf.func.js"></script>
    </head>
    <body>
        <?php
        $row = $dosql->GetOne("SELECT * FROM `#@__withdraw_record` WHERE id={$id}");
        ?>
        <div class="formHeader">
            <span class="title">修改提现申请</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="withdrawApply_save.php">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
<!--                <tr>-->
<!--                    <td height="40" align="right">收款账号：</td>-->
<!--                    <td width="75%">-->
<!--                        <strong>--><?php //echo $row['alipayAccount']; ?><!--</strong>-->
<!--                    </td>-->
<!--                </tr>-->
                <tr>
                    <td width="25%" height="40" align="right">真实姓名：</td>
                    <td>
                        <strong><?php echo $row['truename']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">提现金额：</td>
                    <td>
                        <strong><?php echo $row['amount']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">申请时间： </td>
                    <td><strong><?php echo GetDateTime($row['createtime']); ?></strong></td>
                </tr>
                <tr>
                    <td height="40" align="right">审核状态： </td>
                    <td>
                        <?php if(!$row['status']): ?>
                        <label><input type="radio" name="status" value="1"<?php if($row['status']==1): echo ' checked="checked"'; endif; ?> /> 审核失败</label>
                        <label><input type="radio" name="status" value="2"<?php if($row['status']==2): echo ' checked="checked"'; endif; ?> /> 审核成功</label>
                        <?php else: if($row['status']==1): echo '审核失败'; elseif($row['status']==2): echo '审核成功'; endif; endif; ?>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">失败原因： </td>
                    <td><textarea name="reason" id="reason" class="textarea"><?php echo $row['reason']; ?></textarea></td>
                </tr>
            </table>
            <div class="formSubBtn">
                <input type="submit" class="submit" value="提交" />
                <input type="button" class="back" value="返回" onclick="history.go(-1);" />
                <input type="hidden" name="action" id="action" value="update" />
                <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
            </div>
        </form>
    </body>
</html>