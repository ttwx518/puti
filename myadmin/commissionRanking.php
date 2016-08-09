<?php 
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('commissionRanking');
//初始化查询参数
$begintime = isset($begintime) ? strtotime($begintime) : '';
$endtime = isset($endtime) ? strtotime($endtime) : '';
$where = "1=1";
if ($begintime)
    $where .= " AND c.createtime>={$begintime}";

if ($endtime)
    $where .= " AND c.createtime<={$endtime}";
    
$total = $dosql->GetOne("SELECT sum(amount) totalAmount FROM #@__commission_record c WHERE {$where}");
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>佣金排行统计</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/datepicker/WdatePicker.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
        <script type="text/javascript" src="plugin/calendar/calendar.js"></script>
        <style>
            .dataTr td,.dataTrOn td{padding:5px 0}
        </style>
    </head>
    <body>
        <div class="topToolbar" style="margin-bottom:0">
            <span class="title">佣金排行统计</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
            <tr align="left">
                <td height="60" colspan="5">
                    <ul class="tipsList">
                        <li class="nt">
                            <form name="forms" id="forms" method="" action="" style="display:inline">
                                <div class="orderSearchItem">
                                    佣金时间：
                                    <input type="text" name="begintime" id="begintime" class="inputms" value="<?php if ($begintime):echo GetDateTime($begintime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', alwaysUseStartDate: true});" readonly="readonly" />
                                    ~
                                    <input type="text" name="endtime" id="endtime" class="inputms" value="<?php if ($endtime):echo GetDateTime($endtime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss', alwaysUseStartDate: true});" readonly="readonly" />
                                </div>
                                <div class="orderSearchItem">
                                    <input type="submit" class="selSysEventBtn" value="查询" />
                                    &nbsp;&nbsp;
                                    <input type="button" onclick="location.href = 'commissionRanking.php'" class="selSysEventBtn" value="全部" />
                                </div>
                            </form>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td height="36">用户名</td>
                <td>总佣金</td>
                <td>操作</td>
            </tr>
            <?php
                $dopage->GetPage("SELECT c.uid,sum(c.amount) totalAmount,m.username FROM #@__commission_record c LEFT JOIN #@__member m ON c.uid=m.id WHERE {$where} GROUP BY uid",10,'totalAmount DESC');
                while ($row = $dosql->GetArray()): 
            ?>
            <tr class="dataTr">
                <td height="36"><a href="member_update.php?id=<?php echo $row['uid']; ?>"><?php echo $row['username']; ?></a></td>
                <td><span class="maroon2">￥<?php echo number_format($row['totalAmount'],2); ?></span></td>
                <td><a href="javascript:void(0);" onclick="showUserCommission(<?php echo $row['uid']; ?>);" title="点击查看佣金记录">佣金记录</a></td>
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
            合计:<span class='maroon2'>￥<?php echo number_format($total['totalAmount'],2); ?></span>
        </div>
        <script src="templates/js/artDialog/jquery.artDialog.js?skin=default"></script>
        <script src="templates/js/artDialog/artDialog.iframeTools.js"></script>
        <script>
            function showUserCommission(uid){
                art.dialog.open("statistics/userCommission.php?uid="+uid+"&begintime=<?php echo $begintime; ?>&endtime=<?php echo $endtime; ?>", {
                    id:'userCommission_'+uid,
                    title: '用户佣金记录',
                    width:980,
                    height:575,
                    lock:true,
                    resize:false,
                    drag:false
                });
            }
        </script>
    </body>
</html>