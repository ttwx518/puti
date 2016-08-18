<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('seed_water');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>种子明细</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/datepicker/WdatePicker.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
    </head>
    <body>
        <div class="topToolbar">
            <span class="title">种子明细管理</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        
        <?php
            //初始化参数
            $begintime = isset($begintime) ? strtotime($begintime) : '' ;
            $endtime = isset($endtime) ? strtotime($endtime) : '' ;
            $seed_type = isset($seed_type) ? $seed_type : '';
            $sql = "SELECT s.*, m.wechat_nickname FROM `#@__seed_water` s LEFT  JOIN `#@__member` m ON m.id = s.uid WHERE 1 ";
            if ($begintime)
                $sql .= " AND s.posttime>={$begintime}";
            if ($endtime)
                $sql .= " AND s.posttime<={$endtime}";
            if($seed_type)
                $sql .= " AND s.seed_type = '$seed_type' ";
            ?>
        <div class="toolbarTab" style="margin-top:25px">
            
            <form name="forms" id="forms" method="" action="" style="display:inline">

                <div class="orderSearchItem">
                    申请日期：
                    <select name="seed_type">
                        <option value="">请选择</option>
                        <option value="1">金种子</option>
                        <option value="2">银种子</option>
                        <option value="3">铜种子</option>
                    </select>
                </div>

                <div class="orderSearchItem">
                    申请日期：
                    <input type="text" name="begintime" id="begintime" class="inputms" value="<?php if ($begintime):echo GetDateMk($begintime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});" readonly="readonly" />
                    ~
                    <input type="text" name="endtime" id="endtime" class="inputms" value="<?php if ($endtime):echo GetDateMk($endtime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});" readonly="readonly" />
                </div>
                <div class="orderSearchItem">
                    <input type="submit" class="selSysEventBtn" value="查询" />
                    &nbsp;&nbsp;
                    <input type="button" onclick="location.href = 'seed_water.php'" class="selSysEventBtn" value="全部" />

                    <input type="button" class="selSysEventBtn" id="seed_count" onclick="show_seed();" value="种子统计" />

                </div>
            </form>
            
        </div>
        
        <form name="form" id="form" method="post" action="">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <tr align="left" class="head">
                    <td width="5%" height="36" class="firstCol">
                        <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                    </td>
                    <td width="5%">ID</td>
                    <td width="18%">UID</td>
                    <td width="18%">真实姓名</td>
                    <td width="18">数量</td>
                    <td width="18%">类型</td>
                    <td width="18%" class="endCol">时间</td>
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
<!--                        <td>--><?php //echo $row['alipayAccount']; ?><!--</td>-->
                        <td><?php echo $row['uid']; ?></td>
                        <td><?php echo $row['wechat_nickname']; ?></td>
                        <td class="number"> <?php echo $row['num']; ?> </td>
                        <td>
                            <?php if($row['seed_type'] == 1) { ?>
                                金种子
                            <?php } elseif($row['seed_type'] == 2) { ?>
                                银种子
                            <?php } elseif($row['seed_type'] == 3) { ?>
                                铜种子
                            <?php }?>
                        </td>
                        <td class="action endCol">
                            <?php echo date("Y-m-d H:m:s",$row['posttime']); ?>
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

        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
        <?php
        //判断是否启用快捷工具栏
        if ($cfg_quicktool == 'Y') {
        ?>
        <div class="quickToolbar">
            <div class="qiuckWarp">
                <div class="quickArea">
<!--                    <span class="selArea">-->
<!--                        <span>选择：</span>-->
<!--                        <a href="javascript:CheckAll(true);">全部</a> - -->
<!--                        <a href="javascript:CheckAll(false);">无</a> - -->
<!--                        <a href="javascript:UpAllNone('withdrawApply_save.php',1);" onclick="return ConfreviewAll(1);">审核失败</a> - -->
<!--                        <a href="javascript:UpAllNone('withdrawApply_save.php',2);" onclick="return ConfreviewAll(2);">审核成功</a>-->
<!--                    </span>-->
                    <span class="pageSmall"> <?php echo $dopage->GetList(); ?> </span>
                </div>
                <div class="quickAreaBg"></div>
            </div>
        </div>
        <?php
        }
        ?>
        <script src="templates/js/artDialog/jquery.artDialog.js?skin=default"></script>
        <script src="templates/js/artDialog/artDialog.iframeTools.js"></script>
        <script>
            function show_seed(){
                art.dialog.open("statistics/show_seed.php", {
                    id:'show_seed',
                    title: '种子统计',
                    width:980,
                    height:300,
                    lock:true,
                    resize:false,
                    drag:false
                });
            }
        </script>
    </body>
</html>