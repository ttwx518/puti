<?php 
require_once(dirname(dirname(__FILE__)) . '/inc/config.inc.php');
IsModelPriv('member');
$usergroup = getUserGroup();
//初始化查询参数
$type = isset($type) ? $type : 'fxs1';
$uid = isset($uid) ? $uid : '';
$groupid = isset($groupid) ? $groupid : '-1';
//$starttime = isset($starttime) ? strtotime($starttime) : '';
//$endtime = isset($endtime) ? strtotime($endtime) : '';
//变更货主
if(isset($changeHz)){
    $checkid = isset($checkid) ? $checkid : '';
    $recUid = isset($recUid) ? $recUid : '';
    if(!$checkid || !$recUid){
        ShowMsg('参数错误');
        exit();
    }
    foreach($checkid as $v){
        if($v != $recUid){
            $memberInfo = $dosql->GetOne("SELECT recUid,recUid2 FROM #@__member WHERE id={$v}");
            $recUserInfo2 = $dosql->GetOne("SELECT id,recUid FROM #@__member WHERE id={$recUid}");
            $recUid2 = $recUserInfo2 ? $recUserInfo2['recUid'] : 0;
            if ($dosql->ExecNoneQuery("UPDATE #@__member SET recUid={$recUid},recUid2={$recUid2} WHERE id={$v}")) {
                $dosql->ExecNoneQuery("UPDATE #@__member SET recUid2={$recUid} WHERE recUid={$v}");
                header("location:$gourl");
                exit();
            }
        }
    }
    ShowMsg("货主变更成功！");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>用户统计信息</title>
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
        
        <div class="toolbarTab">
            <div class="orderSearchItem">
                <input type="button" onclick="location.href='../statistics/userStatistics.php?type=fxs1&uid=<?php echo $uid; ?>';" class="changeBtn<?php if($type == 'fxs1'): echo ' cur'; endif; ?>" value="名下分销商" />
                <input type="button" onclick="location.href='../statistics/userStatistics.php?type=fxs2&uid=<?php echo $uid; ?>';" class="changeBtn<?php if($type == 'fxs2'): echo ' cur'; endif; ?>" value="二级分销商" />
                <input type="button" onclick="location.href='../statistics/userStatistics.php?type=yongjin&uid=<?php echo $uid; ?>';" class="changeBtn<?php if($type == 'yongjin'): echo ' cur'; endif; ?>" value="佣金记录" />
                <input type="button" onclick="location.href='../statistics/userStatistics.php?type=tixian&uid=<?php echo $uid; ?>';" class="changeBtn<?php if($type == 'tixian'): echo ' cur'; endif; ?>" value="提现记录" />
            </div>
        </div>
        
        <?php if($type == 'fxs1'): ?>
        
        <div class="toolbarTab">
            <form name="forms" id="forms" method="get" action="">
                <input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
                <input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>" />
                
                <div class="orderSearchItem">
                    用户组 : 
                    <select name="groupid" id="groupid">
                        <option value="-1"<?php if($groupid == -1): echo ' selected'; endif; ?>>不限</option>
                        <?php foreach($usergroup as $k => $v): ?>
                        <option value="<?php echo $k; ?>"<?php if ($k == $groupid):echo ' selected';endif; ?>><?php echo $v['groupname']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="orderSearchItem">
                    <input type="submit" class="selSysEventBtn" value="查询" />
                    &nbsp;&nbsp;
                    <input type="button" onclick="location.href = '../statistics/userStatistics.php?type=<?php echo $type; ?>&uid=<?php echo $uid; ?>'" class="selSysEventBtn" value="全部" />
                </div>
            </form>
        </div>
        
        <form name="form" id="form" method="post" action="" style="margin-top:5px" onsubmit="return checkChangeHz();">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <?php
                    $sql = "SELECT id,wechat_headimgurl,wechat_nickname,username,group_id,mobile FROM #@__member WHERE recUid={$uid}";
                    if($groupid != -1)
                        $sql .= " AND group_id={$groupid}";
                ?>
                <tr align="left" class="head">
                    <td width="50" height="36" class="firstCol">
                        <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                    </td>
                    <td width="50">ID</td>
                    <td width="110">头像</td>
                    <td width="150">微信昵称</td>
                    <td width="150">用户名</td>
                    <td width="150">用户组</td>
                    <td width="60">手机</td>
                </tr>
                <?php
                    $dopage->GetPage($sql,10);
                    while ($row = $dosql->GetArray()): 
                ?>
                <tr class="dataTr">
                    <td height="60" class="firstCol">
                        <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" />
                    </td>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <span class="thumbs" style="width:48px">
                            <img src="<?php echo $row['wechat_headimgurl']; ?>" width="48" height="48" />
                        </span>
                    </td>
                    <td><?php echo $row['wechat_nickname']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $usergroup[$row['group_id']]['groupname']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                </tr>
                <?php endwhile; $total = $dosql->GetTotalRow(); ?>
            </table>
            <!--变更货主-->
            <div style="margin-top:10px">
                变更货主 ：
                <select name="recUid" id="recUid">
                    <option value="-1">官方商城</option>
                    <?php
                    $dosql->Execute("SELECT * FROM `#@__member`");
                    while ($row = $dosql->GetArray()) {
                        echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                    }
                    ?>
                </select>
                <input type="text" name="searchName" id="searchName" value="" class="inputos" placeholder="输入用户名进行搜索" />
                <input type="button" name="searchBtn" id="searchBtn" value="搜索" style="width:80px;height:26px;cursor:pointer" />
                <input type="submit" name="changeHz" id="changeHz" value="确认变更" style="width:80px;height:26px;cursor:pointer" />
            </div>
        </form>
        
        <?php
        //判断无记录样式
        if ($total == 0) {
            echo '<div class="dataEmpty">暂时没有相关的记录</div>';
        }
        ?>
        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
        <div class="bottomToolbar" style="text-align:right">
            总数量 : <span class='maroon2'><?php echo $total; ?></span>
        </div>
        
        <?php elseif($type == 'fxs2'): ?>
        
        <div class="toolbarTab">
            <form name="forms" id="forms" method="get" action="">
                <input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
                <input type="hidden" name="uid" id="uid" value="<?php echo $uid; ?>" />
                
                <div class="orderSearchItem">
                    用户组 : 
                    <select name="groupid" id="groupid">
                        <option value="-1"<?php if($groupid == -1): echo ' selected'; endif; ?>>不限</option>
                        <?php foreach($usergroup as $k => $v): ?>
                        <option value="<?php echo $k; ?>"<?php if ($k == $groupid):echo ' selected';endif; ?>><?php echo $v['groupname']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="orderSearchItem">
                    <input type="submit" class="selSysEventBtn" value="查询" />
                    &nbsp;&nbsp;
                    <input type="button" onclick="location.href = '../statistics/userStatistics.php?type=<?php echo $type; ?>&uid=<?php echo $uid; ?>'" class="selSysEventBtn" value="全部" />
                </div>
            </form>
        </div>
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
            <?php
                $sql = "SELECT id,wechat_headimgurl,wechat_nickname,username,group_id,mobile FROM #@__member WHERE recUid2={$uid}";
                if($groupid != -1)
                    $sql .= " AND group_id={$groupid}";
            ?>
            <tr align="left" class="head">
                <td width="50" height="36" class="firstCol">
                    <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                </td>
                <td width="50">ID</td>
                <td width="110">头像</td>
                <td width="150">微信昵称</td>
                <td width="150">用户名</td>
                <td width="150">用户组</td>
                <td width="60">手机</td>
            </tr>
            <?php
                $dopage->GetPage($sql,10);
                while ($row = $dosql->GetArray()): 
            ?>
            <tr class="dataTr">
                <td height="60" class="firstCol">
                    <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" />
                </td>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <span class="thumbs" style="width:48px">
                        <img src="<?php echo $row['wechat_headimgurl']; ?>" width="48" height="48" />
                    </span>
                </td>
                <td><?php echo $row['wechat_nickname']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $usergroup[$row['group_id']]['groupname']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
            </tr>
            <?php endwhile; $total = $dosql->GetTotalRow(); ?>
        </table>
        <?php
        //判断无记录样式
        if ($total == 0) {
            echo '<div class="dataEmpty">暂时没有相关的记录</div>';
        }
        ?>
        <div class="page"> <?php echo $dopage->GetList(); ?> </div>
        <div class="bottomToolbar" style="text-align:right">
            总数量 : <span class='maroon2'><?php echo $total; ?></span>
        </div>
        
        <?php elseif($type == 'yongjin'): ?>
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
            <?php
            
                $where = "c.uid={$uid}";
                
                $sql = "SELECT * FROM #@__commission_record c WHERE {$where}";
                
                $records = $data = array();
                //获取我的分销业绩
                $dosql->Execute("SELECT * FROM #@__commission_record c WHERE {$where}");
                while ($row = $dosql->GetArray()) {
                    $records[$row['orderid']] = $row;
                }
                if ($records) {
                    $orderids = implode(',', array_keys($records));
                    $dosql->Execute("SELECT i.orderid,i.gid,i.title,i.picurl,i.goodsid,i.salesprice,i.directCommission,i.indirectCommission,i.buyNum,o.ordernum FROM `#@__goodsorderitem` i LEFT JOIN #@__goodsorder o ON i.orderid=o.id WHERE i.orderid IN ({$orderids})");
                    while ($row = $dosql->GetArray()) {
                        $type = $records[$row['orderid']]['type'];
                        if($type == 'direct'){
                            $yongjin = $row['directCommission'];
                        }elseif($type == 'indirect'){
                            $yongjin = $row['indirectCommission'];
                        }
                        if(!array_key_exists($row['gid'], $data)){
                            $data[$row['gid']] = array(
                                'ordernum' => $row['ordernum'],
                                'gid' => $row['gid'],
                                'goodsid' => $row['goodsid'],
                                'title' => $row['title'],
                                'picurl' => $row['picurl'],
                                'salesprice' => $row['salesprice'],
                                'saleNum' => $row['buyNum'],
                                'yongjin' => $yongjin
                            );
                        }else{
                            $data[$row['gid']]['saleNum'] += $row['buyNum'];
                            $data[$row['gid']]['yongjin'] += $yongjin;
                        }
                    }
                }
                $total = $dosql->GetOne("SELECT sum(c.amount) totalAmount FROM #@__commission_record c WHERE {$where}");
            ?>
            <tr align="left" class="head">
                <td width="200">订单号</td>
                <td width="100">商品图片</td>
                <td width="200">商品名称</td>
                <td width="80" align="center">售价</td>
                <td width="150" align="center">销量</td>
                <td width="150" align="center">佣金</td>
            </tr>
            
            <?php foreach($data as $k => $v): ?>
            <tr class="dataTr">
                <td height="60" class="firstCol"><?php echo $v['ordernum']; ?></td>
                <td>
                    <span class="thumbs" style="width:48px">
                        <img src="<?php echo $row['picurl']; ?>" width="48" height="48" />
                    </span>
                </td>
                <td>
                    <?php echo '【'.$v['gid'].'】'.$v['title'].'【'.$v['goodsid'].'】'; ?>
                </td>
                <td align="center">￥<?php echo number_format($v['salesprice'],2); ?></td>
                <td align="center"><?php echo $v['saleNum']; ?></td>
                <td align="center">￥<?php echo number_format($v['yongjin'],2); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div class="bottomToolbar" style="text-align:right">
            合计:<span class='maroon2'>￥<?php echo number_format($total['totalAmount'],2); ?></span>
        </div>
        
        <?php elseif($type == 'tixian'): ?>
        
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
            <?php
            
                $statusArr = array(0 => '未审核', 1 => '审核失败', 2 => '审核成功');
                
                $where = "w.uid={$uid}";
                
                $sql = "SELECT w.* FROM #@__withdraw_record w LEFT JOIN #@__member m ON w.uid=m.id WHERE {$where}";
                
                $total = $dosql->GetOne("SELECT sum(w.amount) totalAmount FROM #@__withdraw_record w LEFT JOIN #@__member m ON w.uid=m.id WHERE {$where}");
                    
            ?>
            <tr align="left" class="head">
                <td width="200">支付宝账号</td>
                <td width="120">真实姓名</td>
                <td width="80" align="center">提现金额</td>
                <td width="150" align="center">申请时间</td>
                <td width="80" align="center">状态</td>
                <td width="150">失败原因</td>
            </tr>
            
            <?php
                $dopage->GetPage($sql,11);
                while ($row = $dosql->GetArray()): 
            ?>
            <tr class="dataTr">
                <td height="30" class="firstCol"><?php echo $row['alipayAccount']; ?></td>
                <td><?php echo $row['truename']; ?></td>
                <td align="center">￥<?php echo number_format($row['amount'],2); ?></td>
                <td align="center"><?php echo GetDateTime($row['createtime']); ?></td>
                <td align="center"><?php echo $statusArr[$row['status']]; ?></td>
                <td><?php echo $row['reason']; ?></td>
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
        <?php endif; ?>
        
        <script>
            function checkChangeHz(){
                var $recUid = $('#recUid'),
                    recUid = $recUid.val(),
                    recUsername = $recUid.find("option:selected").text(),
                    checked = false;
                $("input[name='checkid[]']").each(function(){
                    if($(this).is(":checked")){
                        checked = true;
                    }
                });
                if(!checked){
                    alert('请选中需要变更货主的用户！');
                    return false;
                }
                if(!recUid){
                    alert('货主信息不能为空！');
                    return false;
                }
                if(!confirm('确认要将选中用户的货主设置为【'+recUsername+'】吗？')){
                    return false;
                }
                return true;
            }
            $(document).ready(function(){
                $('#searchBtn').on('click',function(){
                    var $searchName = $('#searchName'),
                        searchName = $searchName.val();
                    $.ajax({
                        url: '../ajax.php?action=getRecUid&id=0&searchName=' + searchName,
                        async: false,
                        type: 'post',
                        dataType: 'json',
                        success: function(result) {
                            if (result.status) {
                                $('#recUid').html(result.msg);
                            } else {
                                alert(result.msg);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>