<?php 
require_once(dirname(dirname(__FILE__)) . '/inc/config.inc.php');
IsModelPriv('integral');
//初始化查询参数
$uid = isset($uid) ? $uid : 0;
// $begintime = isset($begintime) ? $begintime : '';
// $endtime = isset($endtime) ? $endtime : '';
// $where = "c.uid={$uid}";
// if ($begintime)
//     $where .= " AND c.createtime>={$begintime}";
// if ($endtime)
//     $where .= " AND c.createtime<={$endtime}";
// $commissionTypes = array('direct' => '货主+平台佣金', 'indirect' => '平台奖励佣金');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>用户佣金记录</title>
        <link href="../templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="../templates/js/datepicker/WdatePicker.js"></script>
        <script type="text/javascript" src="../templates/js/forms.func.js"></script>
        <style>
            .changeBtn{width:80px;height:30px;border:none;border-radius:5px;cursor:pointer}
            .changeBtn:hover{background-color:blue;color:#fff}
            .cur{background-color:blue;color:#fff}
        </style>
    </head>
    <body>
        <?php $member = $dosql->GetOne("SELECT id,yongjin,wechat_nickname FROM #@__member WHERE id={$uid}") ;?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
            <?php
                $sql = "SELECT i.*,m.wechat_nickname FROM #@__integral i LEFT JOIN #@__member m ON i.fuid=m.id WHERE uid={$uid}";
            ?>
            <tr align="left" class="head">
                <td width="">购买者</td>
                <td width="">订单号</td>
                <td width="">种子类型</td>
                <td width="" align="center">种子数量</td>
                <td width="" align="center">产生时间</td>
            </tr>
            
            <?php
                $dopage->GetPage($sql,20);
                while ($row = $dosql->GetArray()): 
            ?>
            <tr class="dataTr">
                <td height="30" class="firstCol"><?php echo empty($row['ordernum'])?'--':$row['ordernum']; ?></td>
                <td><?php echo $row['wechat_nickname']; ?></td>
                <td><?php echo $row['content']; ?></td>
                <td align="center">￥<?php echo $row['integral']; ?></td>
                <td align="center"><?php echo GetDateTime($row['posttime']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php
        //判断无记录样式
        if ($dosql->GetTotalRow() == 0) {
            echo '<div class="dataEmpty">暂时没有相关的记录</div>';
        }
        ?>
        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
        <div class="bottomToolbar" style="text-align:right">
            可提现金额:<span class='maroon2'>￥<?php echo $member['yongjin']; ?></span>
        </div>
    </body>
</html>