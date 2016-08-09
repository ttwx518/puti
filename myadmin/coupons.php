<?php require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('coupons'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>优惠券管理</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
    </head>
    <body>
        <div class="topToolbar">
            <span class="title">优惠券管理</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <tr align="left" class="head">
                    <td width="3%" align="center">ID</td>
                    <td width="5%" align="center">缩略图</td>
                    <td width="12%" align="center">优惠券名称</td>
                    <td width="10%" align="center">满金额</td>
                    <td width="10%" align="center">减金额</td>
                    <td width="10%" align="center">已领取</td>
                    <td width="15" align="center">发布时间</td>
                    <td width="25" align="center">有效期</td>
                    <td width="10%" class="endCol" align="center">操作</td>
                </tr>
                <?php
                $sql = "SELECT * FROM `#@__coupons`";

                $dopage->GetPage($sql);
                while ($row = $dosql->GetArray()) {
                    ?>
                    <tr align="left" class="dataTr">
                        <td align="center"><?php echo $row['id']; ?></td>
                        <td align="center"><img src="../<?php echo $row['picurl']; ?>" width="80" style="margin: 10px 0;" /></td>
                        <td align="center"><?php echo $row['title']; ?></td>
                        <td align="center"><?php echo $row['meet_money']; ?></td>
                        <td align="center"><?php echo $row['cut_money']; ?></td>
                        <td align="center"><?php echo $row['send']; ?></td>
                        <td class="number" align="center"><?php echo date('Y-m-d H:i', $row['createtime']); ?></td>
                        <td class="number" align="center"><?php echo GetDateTime($row['starttime']); ?>--<?php echo GetDateTime($row['endtime']); ?></td>
                        <td class="action endCol" align="center">
                            <span><a href="coupons_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | 
                            <span class="nb"><a href="coupons_save.php?action=del&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a></span>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </form>
        <?php
        //判断无记录样式
        if ($dosql->GetTotalRow() == 0) {
            echo '<div class="dataEmpty">暂时没有相关的记录</div>';
        }
        ?>
        <div class="bottomToolbar"> 
            <span class="selArea">
                <span>选择：</span>
                <a href="javascript:CheckAll(true);">全部</a> - 
                <a href="javascript:CheckAll(false);">无</a> - 
                <a href="javascript:DelAllNone('coupons_save.php');" onclick="return ConfDelAll(0);">删除</a>
            </span> 
            <a href="coupons_add.php" class="dataBtn">添加优惠券</a>
        </div>
        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
    </body>
</html>