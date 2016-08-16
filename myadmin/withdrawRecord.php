<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('withdrawRecord');
$statusArr = array(0=>'待审核',1=>'审核失败',2=>'审核成功');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>提现记录管理</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/datepicker/WdatePicker.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
    </head>
    <body>
        <div class="topToolbar">
            <span class="title">提现记录管理</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        
        <?php
            //初始化参数
            $begintime = isset($begintime) ? strtotime($begintime) : '' ;
            $endtime = isset($endtime) ? strtotime($endtime) : '' ;
            $sql = "SELECT * FROM #@__withdraw_record WHERE 1 ";
            if ($begintime)
                $sql .= " AND createdate>={$begintime}";
            if ($endtime)
                $sql .= " AND createdate<={$endtime}";
            ?>
        <div class="toolbarTab" style="margin-top:25px">
            
            <form name="form" id="form" method="" action="" style="display:inline">
                <div class="orderSearchItem">
                    申请日期：
                    <input type="text" name="begintime" id="begintime" class="inputms" value="<?php if ($begintime):echo GetDateMk($begintime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});" readonly="readonly" />
                    ~
                    <input type="text" name="endtime" id="endtime" class="inputms" value="<?php if ($endtime):echo GetDateMk($endtime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});" readonly="readonly" />
                </div>
                <div class="orderSearchItem">
                    <input type="submit" class="selSysEventBtn" value="查询" />
                    &nbsp;&nbsp;
                    <input type="button" onclick="location.href = 'withdrawRecord.php'" class="selSysEventBtn" value="全部" />
                </div>
            </form>
            
        </div>
        
        <form name="form" id="form" method="post" action="withdrawRecord_save.php">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <tr align="left" class="head">
                    <td width="5%" height="36" class="firstCol">
                        <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                    </td>
                    <td width="5%">ID</td>
                    <td width="20%">收款账号</td>
                    <td width="15%">真实姓名</td>
                    <td width="10%">提现金额</td>
                    <td width="15%">申请时间</td>
                    <td width="10%">状态</td>
                    <td width="25%">失败原因</td>
                </tr>
                <?php
                $dopage->GetPage($sql);
                while ($row = $dosql->GetArray()) {
                    ?>
                    <tr align="left" class="dataTr">
                        <td height="60" class="firstCol">
                            <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" />
                        </td>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['alipayAccount']; ?></td>
                        <td><?php echo $row['truename']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td class="number"><?php echo GetDateTime($row['createtime']); ?></td>
                        <td><?php echo $statusArr[$row['status']]; ?></td>
                        <td><?php echo $row['reason']; ?></td>
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
            
        </div>
        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
        <?php
        //判断是否启用快捷工具栏
        if ($cfg_quicktool == 'Y') {
        ?>
        <div class="quickToolbar">
            <div class="qiuckWarp">
                <div class="quickArea">
                    <span class="pageSmall"> <?php echo $dopage->GetList(); ?> </span>
                </div>
                <div class="quickAreaBg"></div>
            </div>
        </div>
        <?php
        }
        ?>
    </body>
</html>