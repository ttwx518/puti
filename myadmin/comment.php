<?php require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('comment'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品评价管理</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/js/jquery.min.js"></script>
<script type="text/javascript" src="templates/js/forms.func.js"></script>
</head>
<body>
<div class="topToolbar"> <span class="title">商品评价管理</span> <a href="javascript:location.reload();" class="reload">刷新</a></div>
<form name="form" id="form" method="post" action="comment_save.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
		<tr align="left" class="head">
			<td width="" height="36" class="firstCol"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
			<td width="">ID</td>
			<td width="">头像</td>
			<td width="">昵称</td>
			<td width="">商品名称</td>
			<td width="">评论内容</td>
			<td width="">时间</td>
			<td width="" class="endCol">操作</td>
		</tr>
		<?php
        $sql = "SELECT * FROM `#@__comment`";
		$dopage->GetPage($sql);
		while($row = $dosql->GetArray())
		{
			switch($row['checkinfo'])
			{
				case '1':
					$checkinfo = '已审核';
					$checkurl="comment_save.php?id=".$row['id']."&action=update&checkinfo=0";
					break;  
				case '':
					$checkinfo = '未审核';
					$checkurl="comment_save.php?id=".$row['id']."&action=update&checkinfo=1";
					break;
				default:
					$checkinfo = '没有获取到参数';
			}
		?>
		<tr align="left" class="dataTr">
		<?php $member = $dosql->GetOne("select * from `#@__member` where id={$row['uid']}")?>
		<?php $goods = $dosql->GetOne("select * from `#@__goods` where id={$row['gid']}")?>
			<td height="36" class="firstCol"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
			<td><?php echo $row['id']; ?></td>
			<td><img src="<?php echo $member['wechat_headimgurl']; ?>" style="width: 80px" alt="" /></td>
			<td><?php echo $member['wechat_nickname']; ?></td>
			<td><?php echo $goods['title']; ?></td>
			<td><?php echo $row['content']; ?></td>
			<td class="number"><?php echo GetDateTime($row['createtime']); ?></td>
			<td class="action endCol"><span><a href="<?php echo $checkurl?>" title="点击进行审核与未审操作"><?php echo $checkinfo; ?></a></span> | <span class="nb"><a href="comment_save.php?action=del2&id=<?php echo $row['id']; ?>" onclick="return ConfDel(0);">删除</a></span></td>
		</tr>
		<?php
		}
		?>
	</table>
</form>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('comment_save.php');" onclick="return ConfDelAll(0);">删除</a>-
          </span></div>
<div class="page"> <?php echo $dopage->GetList(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"><span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:DelAllNone('comment_save.php');" onclick="return ConfDelAll(0);">删除</a></span><span class="pageSmall"> <?php echo $dopage->GetList(); ?> </span></div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
</body>
</html>