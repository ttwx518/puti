<?php	require_once(dirname(__FILE__).'/inc/config.inc.php');IsModelPriv('lottery');

/*
**************************
(C)2010-2014 phpMyWind.com
update: 2014-6-8 10:44:13
person: Feng
**************************
*/


//初始化参数
$tbname = 'lottery';
$action  = isset($action)  ? $action  : '';
$keyword = isset($keyword) ? $keyword : '';

//删除单条记录
if($action == 'delone')
{
	if ($dosql->ExecNoneQuery("DELETE FROM `#@__goods` WHERE id=$id"))
		echo 1;
	else 
		echo 0;
	exit();
}

//删除单条记录
if($action == 'del')
{
    $dosql->ExecNoneQuery("delete from `#@__$tbname` WHERE id=$id");
}

//删除选中记录
if($action == 'delall')
{
    if($ids != '')
    {
        $dosql->ExecNoneQuery("delete from `#@__$tbname`  WHERE `id` IN ($ids)");
    }
}
?>
<div class="toolbarTab">
	<ul>
		<?php
		$goodscls = array();
		$dosql->Execute("SELECT * FROM `#@__infoclass` WHERE 1 ");
		while ($cls = $dosql->GetArray())
		{
			$goodscls[$cls['id']] = $cls['classname'];
		}
	
		$flagArr = array('all'=>'全部', 'notcheck'=>'未审', 'ischeck'=>'已审');
		$dosql->Execute("SELECT * FROM `#@__goodsflag` ORDER BY `orderid` ASC");
		while($row = $dosql->GetArray())
		{
			$flagArr[$row['flag']] = $row['flagname'];
		}
		
		
		$flagArrNum = count($flagArr);
	
		foreach($flagArr as $k => $v)
		{
// 			if($flag == $k)
// 				$flagOn = 'on';
// 			else
// 				$flagOn = '';
	
// 			echo '<li class="'.$flagOn.'"><a href="javascript:;" onclick="GetFlag(\''.$k.'\')">'.$v.'</a></li><li class="line">-</li>';
		}
	
		?>
	</ul>
	<div id="search" class="search"> <span class="s">
		<input name="keyword" id="keyword" type="text" title="输入标题名进行搜索" value="<?php echo $keyword; ?>" />
		</span> <span class="b"><a href="javascript:;" onclick="GetSearch();"></a></span></div>
	<div class="cl"></div>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="ajaxlist" class="dataTable">
	<tr align="left" class="head">
		<td width="5%"><input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);"></td>
		<td>ID</td>
		<td>姓名</td>
		<td>手机号码</td>
		<td>地址</td>
		<td>活动</td>
		<td>奖项</td>
		<td>奖品</td>
        <td>状态</td>
        <td>日期</td>
		<td class="noborder">操作</td>
	</tr>
	<?php

	//检查全局分页数
	if(empty($cfg_pagenum))  $cfg_pagenum = 20;


	//权限验证
	if($cfg_adminlevel != 1)
	{
		//初始化参数
		$catgoryListPriv   = '';
		$catgoryUpdatePriv = array();
		$catgoryDelPriv    = array();

		$dosql->Execute("SELECT * FROM `#@__adminprivacy` WHERE `groupid`=".$cfg_adminlevel." AND `model`='category' AND `action`<>'add'");
		while($row = $dosql->GetArray())
		{
			//查看权限
			if($row['action'] == 'list')
				$catgoryListPriv .= $row['classid'].',';

			//修改权限
			if($row['action'] == 'update')
				$catgoryUpdatePriv[] = $row['classid'];

			//删除权限
			if($row['action'] == 'del')
				$catgoryDelPriv[]    = $row['classid'];
			
		}

		$catgoryListPriv = trim($catgoryListPriv,',');
	}

	//设置sql
	$sql = "SELECT * FROM `#@__$tbname` WHERE grade <> 0 ";	

	if(!empty($catgoryListPriv)) $sql .= " AND classid IN ($catgoryListPriv)";

	if(!empty($cid))     $sql .= " AND (classid=$cid OR parentstr Like '%,$cid,%')";
	
	if(!empty($tid))     $sql .= " AND (typeid=$tid OR typepstr LIKE '%,$tid,%')";	

    /**
	 * 用户名
	 */
	if(!empty($keyword)) {
    	// $keyworduser=$dosql->getOne("SELECT * FROM `#@__member` where cnname like '%".$keyword."%' OR username like '%".$keyword."%'");
    	$sql .= " and username like '%".$keyword."%'";
	}

	if(!empty($flag))
	{
		if($flag == 'all')
			$sql .= 'AND id<>0';
		else if($flag == 'notcheck')
			$sql .= "AND checkinfo='false'";
		else if($flag == 'ischeck')
			$sql .= "AND checkinfo='true'";	
		else if($flag == 'author')
			$sql .= "AND author='".$_SESSION['admin']."'";
		else
		{
			$dosql->Execute("SELECT `flag` FROM `#@__infoflag`");
			while($row = $dosql->GetArray())
			{
				if($row['flag'] == $flag)
				{
					$sql .= "AND `flag` LIKE '%$flag%'";
				}
			}
		}
	}

	$dopage->GetPage($sql);
	while($row = $dosql->GetArray())
	{
	    //标记为处理
	    if ($row['checkinfo']=='0'){
	        $updateStr = '<a href="lottery_save.php?action=update&checkinfo=1&id='.$row['id'].'" >兑奖</a>';
	    } else {
	        $updateStr = '<a href="lottery_save.php?action=update&checkinfo=0&id='.$row['id'].'" >已兑奖</a>';
	    }
	    
	    //删除
	    $delStr = '<a href="javascript:void(0);" onclick="ClearInfo('.$row['id'].')">删除</a>';
	?>
	<tr align="left" class="dataTr" onmouseover="this.className='dataTrOn'" onmouseout="this.className='dataTr'">
		<td height="32"><input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" /></td>
		<td><?php echo $row['id']; ?></td>
		<?php 
		$order=$dosql->getOne("SELECT name,mobile,pccinfo,id,aid,address FROM `#@__goodsorder` where id=".$row['orderid']);
		$infolist=$dosql->getOne("SELECT title,id FROM `#@__infolist` where id=".$order['aid']);
		?>
		<td><?php echo $order['name']; ?></td>
		<td><?php echo $order['mobile']; ?></td>
        <td><?php echo $order['pccinfo'].$order['address']; ?></td>
        <td><?php echo $infolist['title']; ?></td>
		<td>
        	<?php 
        	if($row["grade"]==1){
        		echo "一等奖";
        	}elseif($row["grade"]==2){
        		echo "二等奖";
        	}elseif($row["grade"]==3){
        		echo "三等奖";
        	}elseif($row["grade"]==-1){
        		echo "礼品";
        	}else{
        		echo "未中奖";
        	}
        	?>
        </td>
        <td><?php echo $row['result_desc']; ?></td>
		<td><?php echo empty($row['checkinfo'])?"未兑奖":"已兑奖"; ?></td>
        <td><?php echo date("Y-m-d",$row['posttime']);?></td>
		<td class="action"><span>[<?php echo $updateStr; ?>][<?php echo $delStr; ?>]</span></td>
	</tr>
	<?php
	}	
	?>
</table>
<?php

//判断无记录样式
if($dosql->GetTotalRow() == 0)
{
	echo '<div class="dataEmpty">暂时没有相关的记录</div>';
}
?>
<div class="bottomToolbar"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:;" onclick="AjaxClearAll();">删除</a></span> </div>
<div class="page"> <?php echo $dopage->AjaxPage(); ?> </div>
<?php

//判断是否启用快捷工具栏
if($cfg_quicktool == 'Y')
{
?>
<div class="quickToolbar">
	<div class="qiuckWarp">
		<div class="quickArea"> <span class="selArea"><span>选择：</span> <a href="javascript:CheckAll(true);">全部</a> - <a href="javascript:CheckAll(false);">无</a> - <a href="javascript:;" onclick="AjaxClearAll();">删除</a></span><span class="pageSmall"><?php echo $dopage->AjaxPageSmall(); ?></span> </div>
		<div class="quickAreaBg"></div>
	</div>
</div>
<?php
}
?>
<script>
$(function(){
    $(".thumbs img").LoadImage();
});
</script>