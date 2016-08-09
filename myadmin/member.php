<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('member');
$usergroup = getUserGroup();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>会员管理</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
    </head>
    <body>
        <div class="topToolbar">
            <span class="title">会员管理</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        
        <?php
            //初始化参数
            $groupid = isset($groupid) ? $groupid : '-1';
            $keyword = isset($keyword) ? $keyword : '';
            $orderBy = isset($orderBy) ? $orderBy : 'id DESC';
            $sql = "SELECT * FROM `#@__member` WHERE 1=1";
            if($groupid != -1)
                $sql .= " AND group_id={$groupid}";
            if ($keyword != '')
                $sql .= " AND (username LIKE '%{$keyword}%' OR wechat_nickname LIKE '%{$keyword}%')";
            ?>
        <!--用户筛选-->
        <div class="toolbarTab" style="margin-top:25px">
            <form name="forms" id="forms" method="get" action="">
                
                <div class="orderSearchItem">
                    用户组 : 
                    <select name="groupid" id="groupid">
                        <option value="-1"<?php if($groupid == -1): echo ' selected'; endif; ?>>不限</option>
                        <?php foreach($usergroup as $k => $v): ?>
                        <option value="<?php echo $k; ?>"<?php if ($k == $groupid):echo ' selected';endif; ?>><?php echo $v['groupname']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    排序 : 
                    <select name="orderBy" id="orderBy">
                        <option value="id DESC"<?php if($orderBy == "id DESC"): echo ' selected'; endif; ?>>默认排序</option>
                        <!--
                        <option value="totalU1 ASC"<?php if($orderBy == "totalU1 ASC"): echo ' selected'; endif; ?>>按名下分销商数量升序</option>
                        <option value="totalU1 DESC"<?php if($orderBy == "totalU1 DESC"): echo ' selected'; endif; ?>>按名下分销商数量倒序</option>
                        <option value="totalU2 ASC"<?php if($orderBy == "totalU2 ASC"): echo ' selected'; endif; ?>>按二级分销商数量升序</option>
                        <option value="totalU2 DESC"<?php if($orderBy == "totalU2 DESC"): echo ' selected'; endif; ?>>按二级分销商数量倒序</option>
                        -->
                        <option value="totalYongjin ASC"<?php if($orderBy == "totalYongjin ASC"): echo ' selected'; endif; ?>>按佣金总额升序</option>
                        <option value="totalYongjin DESC"<?php if($orderBy == "totalYongjin DESC"): echo ' selected'; endif; ?>>按佣金总额倒序</option>
                    </select>
                    
                </div>
                <div class="search fl">
                    <span class="s">
                        <input name="keyword" id="keyword" type="text" placeholder="手机号,微信昵称..." value="<?php echo $keyword; ?>" />
                    </span>
                    <span class="b"><a href="javascript:;" onclick="$('#forms').submit();"></a></span>
                </div>
                
            </form>
        </div>
        
        <form name="form" id="form" method="post" action="member_save.php">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <tr align="left" class="head">
                    <td width="5%" height="36" class="firstCol">
                        <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                    </td>
                    <td width="5%">ID</td>
                    <td width="10%">头像</td>
                    <td width="10%">用户名</td>
                    <td width="5%">OPENID</td>
                    <td width="10%" align="center">名下分销商数量</td>
                    <td width="10%" align="center">二级分销商数量</td>
                    <td width="10%" align="center">佣金总额</td>
                    <td width="10%">手机</td>
                    <td width="10%">登录时间</td>
                    <td width="15%" class="endCol">操作</td>
                </tr>
                <?php
                $dopage->GetPage($sql, 20, $orderBy);
                while ($row = $dosql->GetArray()) {
                    $totalU1 = $dosql->GetOne("SELECT count(id) num FROM #@__member WHERE recUid={$row['id']}");
                    $totalU2 = $dosql->GetOne("SELECT count(id) num FROM #@__member WHERE recUid2={$row['id']}");
                ?>
                <tr align="left" class="dataTr">
                    <td height="60" class="firstCol">
                        <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" />
                    </td>
                    <td><?php echo $row['id']; ?></td><!--../data/avatar/index.php?uid=<?php echo $row['id']; ?>&size=small&rnd=<?php echo GetRandStr(); ?>-->
                    <td>
                        <span class="thumbs" style="width:48px">
                            <a href="javascript:void(0);" onclick="showUserStatistics(<?php echo $row['id']; ?>,'fxs1');" title="点击查看统计信息"><img src="<?php echo $row['wechat_headimgurl']; ?>" width="48" height="48" /></a>
                        </span>
                    </td>
                    <td><?php echo $row['wechat_nickname']; ?></td>
                    <td>
                        <?php echo $row['openid']; ?>
                    </td>
                    <td align="center"><?php echo $totalU1['num']; ?></td>
                    <td align="center"><?php echo $totalU2['num']; ?></td>
                    <td align="center">￥<?php echo $row['totalYongjin'] ? $row['totalYongjin'] : '0.00'; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td class="number">
                        <?php echo GetDateMk($row['logintime']); ?><br />
                        <?php echo MyDate('H:i:s', $row['logintime']); ?>
                    </td>
                    <td class="action endCol">
                        <span><a href="member_update.php?id=<?php echo $row['id']; ?>">修改</a></span> | 
                        <span class="nb"><a href="member_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0)">删除</a></span>
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
                <a href="javascript:DelAllNone('member_save.php');" onclick="return ConfDelAll(0);">删除</a>
            </span>
            <a href="member_add.php" class="dataBtn">注册新会员</a>
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
                        <a href="javascript:DelAllNone('member_save.php');" onclick="return ConfDelAll(0);">删除</a>
                    </span>
                    <a href="member_add.php" class="dataBtn">注册新会员</a>
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
            function showUserStatistics(uid, type){
                art.dialog.open("statistics/userStatistics.php?uid="+uid+"&type="+type, {
                    id:'userStatistics_'+uid,
                    title: '用户统计信息',
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