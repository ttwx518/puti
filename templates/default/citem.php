<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
    <section class="main">
	
	<div class="shopping_ban">
		<div class="item-img">
			<img src="<?php echo $children['picurl'];?>" alt="" class="imgm">
		</div>
		<div class="bg-w p10 item-info">
			<h2 class="fs14 col_3"><?php echo $children['title'].'&nbsp;&nbsp;&nbsp;'.$children['title2'];?><em class="br3 <?php echo empty($children['sex'])?"woman":'man'?>"><?php echo $children['age'];?>岁</em></h2>
			<div class="clearfix">
				<p class="col_9 ico1"><?php echo $children['id']; ?></p>
				<p class="col_9 ico2"><?php echo $children['name_prov']; ?>  <?php echo $children['name_city']; ?></p>
			</div>
			<div class="mt5 con">
				<span class="fl br3 c">语录</span>
				<article class="col_3"><?php echo empty($children['slogan'])?'&nbsp;':$children['slogan'];?></article>
			</div>
		</div>
	</div>

	<div class="mt10 bg-w btb shopping_art">
		<div class="plr10 fs14 col_3 item-hd">爱的小屋活动场景介绍</div>
		<article class="p10 col_3">
			<p>
			<?php 
// 			$space = '&nbsp;&nbsp;&nbsp;';
// 			$changjing = $space.$children['changjing']; 
// 			$changjing=str_replace("\r\n", '<br>'.$space, $changjing);
			echo $children['changjing'];
			?></p>
		</article>
	</div>
	<div class="mt10 bg-w btb shopping_art">
		<div class="plr10 fs14 col_3 item-hd">智残小孩个人介绍</div>
		<article class="p10 col_3">
			<p>
			<?php 
			$description = $children['description']; 
			$description=str_replace("\r\n", '<br>&nbsp;&nbsp;&nbsp;', $description);
			echo $children['description'];
			?>
			</p>
		</article>
	</div>
	<div class="mt10 bg-w btb shopping_art">
		<div class="plr10 fs14 col_3 item-hd">我的梦想介绍</div>
		<article class="p10 col_3">
			<p>
			<?php 
			$mengxiang = $children['mengxiang']; 
			$mengxiang=str_replace("\r\n", '<br>&nbsp;&nbsp;&nbsp;', $mengxiang);
			echo $children['mengxiang'];
			?>
			</p>
		</article>
	</div>

	<?php if(!empty($goods)):?>
	<div class="mt10 bg-w btb shopping_art">
		<div class="plr10 fs14 col_3 item-hd">我的爱心产品</div>
		<div class="p10 item-con">
			<dl class="table">
				<dt class="table-cell v-t">
					<img src="<?php echo $goods['picurl']?>" alt="" class="br5 imgm">
				</dt>
				<dd class="table-cell v-t">
					<p class="fs14 col_3"><?php echo $goods['title']?></p>
					<div class="mt10">
						<span class="fs15 mr10">¥ <?php echo $goods['salesprice']?></span><!-- <s class="col_9"> ¥68.0</s> -->
						<a href="javascript:cart.buyNow(<?php echo $goods['id']; ?>, 1);" class="fr br5">立刻购买</a>
					</div>
				</dd>
			</dl>
		</div>
	</div>
    <?php endif;?>
	<div class="mt10 bg-w btb shopping_art">
		<div class="plr10 fs14 col_3 item-hd">我的视频介绍</div>
		<div class="p10 col_3 item-video">
			<p>观看孩子视频，了解他们的梦想</p>
			<a href="<?php echo $children['linkurl']?>" class="br5">观看视频</a>
		</div>
	</div>

	<div class="mt10 mb10 bg-w btb shopping_art">
		<div class="plr10 fs14 col_3 item-hd">
			<span class="mr10 col_9">注册时间</span><?php echo MyDate('Y-m-d', $children['posttime']);?>
			<form id="favform" action="index.php?c=citem&id=<?php echo $children['id']?>" method="post" enctype="multipart/form-data">
				<input value="1" name="subfav" type="hidden" /> 
    			<a href="javascript:void(0);" onclick="javascript:$('#favform').submit()"
    			class="fr br5" style="margin-top: -30px; display: inline-block; padding: 0 10px; color: #f53f3f; border: 1px #f53f3f solid; line-height: 24px;"><?php echo empty($fav)?'立刻关注':'已关注';?></a>
			</form>
		</div>
	</div>

</section>
</section>
	</section>
	<?php require_once TMPL_DIR . 'public/footer.php'; ?>
</body>
</html>