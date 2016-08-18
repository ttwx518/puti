<?php 
require_once(dirname(dirname(__FILE__)) . '/inc/config.inc.php');
IsModelPriv('integral');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>种子统计</title>
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

        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
            <?php
            global 	$cfg_golden_seed,$cfg_silver_seed,$cfg_copper_seed;
            $send_golden_seed = $dosql->GetOne("select sum(num) as num from `#@__seed_water` where seed_type = 1");
            $send_silver_seed = $dosql->GetOne("select sum(num) as num from `#@__seed_water` where seed_type = 2");
            $send_copper_seed = $dosql->GetOne("select sum(num) as num from `#@__seed_water` where seed_type = 3");

            $send_golden_seed = $send_golden_seed['num'] > 0 ?  $send_golden_seed['num'] : 0;
            $send_silver_seed = $send_silver_seed['num'] > 0 ?  $send_silver_seed['num'] : 0;
            $send_copper_seed = $send_copper_seed['num'] > 0 ?  $send_copper_seed['num'] : 0;

            ?>
            <tr align="left" class="head">
                <td width="">种子名称</td>
                <td width="">种子数量</td>
                <td width="">已发放</td>
                <td width="">剩余</td>
            </tr>
            

            <tr class="dataTr">
                <td height="30" class="firstCol">金种子</td>
                <td><?php echo $cfg_golden_seed;?> 粒</td>
                <td><?php echo $send_golden_seed;?> 粒</td>
                <td><?php echo $cfg_golden_seed - $send_golden_seed;?> 粒</td>
            </tr>

            <tr class="dataTr">
                <td height="30" class="firstCol">银种子</td>
                <td><?php echo $cfg_silver_seed;?> 粒</td>
                <td><?php echo $send_silver_seed;?> 粒</td>
                <td><?php echo $cfg_silver_seed - $send_silver_seed;?> 粒</td>
            </tr>

            <tr class="dataTr">
                <td height="30" class="firstCol">铜种子</td>
                <td><?php echo $cfg_copper_seed;?> 粒</td>
                <td><?php echo $send_copper_seed;?> 粒</td>
                <td><?php echo $cfg_copper_seed - $send_copper_seed;?> 粒</td>
            </tr>

        </table>


    </body>
</html>