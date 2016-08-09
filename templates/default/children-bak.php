<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="main">
		<div class="inner-cate-nav">
			<ul>
			<?php foreach ($areas as $v):?>
				<li class="<?php echo $areaid==$v['areaid']?'active':'';?>">
				<a href="index.php?c=children&aid=<?php echo $v['areaid'];?>" style="font-size: 11px; <?php echo $aid==$v['areaid']?'color: red; font-weight: bold ;':'';?>"><?php echo $v['dataname']?></a></li>
			<?php endforeach;?>
			</ul>
		</div>
		<div class="bg-w inner-cate-list" style="margin-top: 44px">
			<ul>
			<?php if(empty($childrens)):?>
			无结果
			<?php endif;?>
			<?php foreach ($childrens as $v):?>
				<li><a href="index.php?c=citem&id=<?php echo $v['id']; ?>">
						<div class="photo">
							<img src="<?php echo $v['picurl']; ?>">
						</div>
						<div class="p5 item-con">
							<div class="col_0 fs12 tit c"><?php echo $v['title']; ?></div>
						</div>
				</a></li>
			<?php endforeach;?>
			</ul>
		</div>
	</section>
	</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>