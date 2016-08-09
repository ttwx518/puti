<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('goodsorder');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>商品订单管理</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
        <script type="text/javascript" src="templates/js/datepicker/WdatePicker.js"></script>
        <script type="text/javascript" src="templates/js/artDialog/jquery.artDialog.js?skin=default"></script>
        <script type="text/javascript" src="templates/js/artDialog/artDialog.iframeTools.js"></script>
        <style>
            .OperateBtn{cursor:pointer;width:80px;height:25px;border-radius:5px;border:none}
        </style>
    </head>
    <body>
        <div class="topToolbar">
            <span class="title">商品订单管理</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>

        <?php
            //初始化参数
            $flag = isset($flag) ? $flag : 'all';
            $goodsNames = isset($goodsNames) ? $goodsNames : '';
            $keyword = isset($keyword) ? $keyword : '';
            $flagArr = array(
                'all' => '全部',
//                 'core' => '星标',
//                 'empty' => '未审',
//                 'confirm' => '确认',
                'payment' => '等待发货',
//                 'postgoods' => '等待收货',
//                 'getgoods' => '已收货',
//                 'applyreturn' => '申退',
//                 'agreedreturn' => '退货',
//                 'goodsback' => '返货',
//                 'moneyback' => '退款',
//                 'overorder' => '归档',
//                 'cancel' => '取消'
            );
            
            $sql = "SELECT o.*,m.username FROM `#@__goodsorder` o LEFT JOIN `#@__member` m ON o.uid=m.id WHERE o.delstate=''";
            $begintime = isset($begintime) ? strtotime($begintime) : '' ;
            $endtime = isset($endtime) ? strtotime($endtime) : '' ;
            if ($begintime)
                $sql .= " AND o.createtime>={$begintime}";
            if ($endtime)
                $sql .= " AND o.createtime<={$endtime}";

            if ($flag == 'core')
                $sql .= " AND o.core='true'";

            if ($flag == 'empty')
                $sql .= " AND o.checkinfo=''";
            // 待发货
            if ($flag == 'payment')
                $sql .= " AND o.checkinfo='confirm,payment'";
//             if ($flag != 'all' && $flag != 'core' && $flag != 'empty')
//                 $sql .= " AND o.checkinfo LIKE '%$flag%'";
            
            if ($keyword != '')
                $sql .= " AND (o.ordernum LIKE '%{$keyword}%' OR m.username LIKE '%{$keyword}%')";
            
            if ($goodsNames != '')
                $sql .= " AND (o.goodsNames LIKE '%{$goodsNames}%')";
            
            ?>
        <!--订单筛选-->
        <div class="toolbarTab" style="margin-top:25px">
            <form name="forms" id="forms" method="get" action="">
                <div class="orderSearchItem">订单状态 : 
                    <select name="flag" id="flag">
                        <?php foreach($flagArr as $k => $v): ?>
                        <option value="<?php echo $k; ?>"<?php if ($k == $flag):echo ' selected';endif; ?>><?php echo $v; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" name="begintime" id="begintime" class="inputms" value="<?php if ($begintime):echo GetDateMk($begintime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});" readonly="readonly" />
                    ~
                    <input type="text" name="endtime" id="endtime" class="inputms" value="<?php if ($endtime):echo GetDateMk($endtime);endif; ?>" onclick="WdatePicker({dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});" readonly="readonly" />
                    <input name="goodsNames" id="goodsNames" type="text" class="inputos" placeholder="商品名称..." value="<?php echo $goodsNames; ?>" />
                </div>
                <div class="search fl">
                    <span class="s">
                        <input name="keyword" id="keyword" type="text" placeholder="订单号,用户名..." value="<?php echo $keyword; ?>" />
                    </span>
                    <span class="b"><a href="javascript:;" onclick="$('#forms').submit();"></a></span>
                </div>
                
                <div class="orderSearchItem" style="margin:-2px 0 0 10px">
                    <input type="button" onclick="location.href='export.php?type=order&goodsName=<?php echo $goodsNames; ?>&sql=<?php echo urlencode($sql); ?>';" class="OperateBtn" value="订单导出" />
<!--                     <input type="button" id="batchDelivery" class="OperateBtn" value="批量发货" /> -->
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
                    <td width="12%">用户名</td>
                    <td width="12%">订单编号</td>
                    <td width="15%">商品名称</td>
                    <td width="12%">联系人/电话</td>
                    <td width="7%">金额</td>
                    <td width="12%">订单时间</td>
                    <td width="8%">订单状态</td>
                    <td width="10%" class="endCol">操作</td>
                </tr>
                <?php
                $dopage->GetPage($sql);
                while ($row = $dosql->GetArray()) {
                ?>
                <tr align="left" class="dataTr">
                    <td height="36" class="firstCol">
                        <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" />
                    </td>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['ordernum']; ?></td>
                    <td><a href="goodsorder.php?goodsNames=<?php echo $row['goodsNames']; ?>"><?php echo $row['goodsNames']; ?></a></td>
                    <td><?php echo $row['name'] . '/' . $row['mobile']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td class="number"><?php echo GetDateTime($row['createtime']); ?></td>
                    <td class="blue">
                        <?php
                        $checkinfo = explode(',', $row['checkinfo']);
                        if (!in_array('applyreturn', $checkinfo) &&
                                !in_array('agreedreturn', $checkinfo) &&
                                !in_array('goodsback', $checkinfo) &&
                                !in_array('moneyback', $checkinfo) &&
                                !in_array('overorder', $checkinfo) &&
                                !in_array('cancel', $checkinfo)
                        ) {
                            if ($row['checkinfo'] == '' or !in_array('confirm', $checkinfo))
                                echo '等待确认';
                            else if (!in_array('payment', $checkinfo))
                                echo '等待付款';
                            else if (!in_array('postgoods', $checkinfo))
                                echo '等待发货';
                            else if (!in_array('getgoods', $checkinfo))
                                echo '等待收货';
                            else if (!in_array('overorder', $checkinfo))
                                echo '等待归档';
                            else
                                echo '参数错误，没有获取到订单状态';
                        }
                        else {
                            if (in_array('overorder', $checkinfo))
                                echo '已归档';
                            else if (in_array('moneyback', $checkinfo))
                                echo '等待归档';
                            else if (in_array('goodsback', $checkinfo))
                                echo '等待退款';
                            else if (in_array('agreedreturn', $checkinfo))
                                echo '等待返货';
                            else if (in_array('applyreturn', $checkinfo))
                                echo '申请退货';
                            else if (in_array('cancel', $checkinfo))
                                echo '已取消';
                            else
                                echo '参数错误，没有获取到订单状态';
                        }
                        ?>
                    </td>
                    <td class="action endCol">
                        <span><a href="goodsorder_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | 
                        <span class="nb"><a href="goodsorder_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a></span>
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
                <a href="javascript:DelAllNone('goodsorder_save.php');" onclick="return ConfDelAll(0);">删除</a>
            </span>
        </div>
        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
        <?php
        //判断是否启用快捷工具栏
        if ($cfg_quicktool == 'Y') {
        ?>
        <div class="quickToolbar">
            <div class="qiuckWarp">
                <div class="quickArea">
                    <span class="selArea">
                        <span>选择：</span>
                        <a href="javascript:CheckAll(true);">全部</a> - 
                        <a href="javascript:CheckAll(false);">无</a> - 
                        <a href="javascript:DelAllNone('goodsorder_save.php');" onclick="return ConfDelAll(0);">删除</a>
                    </span>
                    <span class="pageSmall">
                        <div class="pageText"><?php echo $dopage->GetList(); ?></div>
                    </span>
                </div>
                <div class="quickAreaBg"></div>
            </div>
        </div>
        <?php
        }
        ?>
        <script>
            $(document).ready(function() {
                /**
                 * 批量发货
                 */
                $('#batchDelivery').on('click', function() {
                    art.dialog.open("orderOperate/batchDelivery.php?goodsNames=<?php echo $goodsNames; ?>&keyword=<?php echo $keyword; ?>", {
                        id:'batchDelivery',
                        title: '批量发货',
                        width:1180,
                        height:575,
                        lock:true,
                        resize:false,
                        drag:false
                    });
                });
            });
        </script>
    </body>
</html>