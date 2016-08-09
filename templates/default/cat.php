<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="main">
		<div class="inner-cate-nav">
			<ul>
			<?php foreach ($cats as $v):?>
				<li class="<?php echo $tid==$v['id']?'active':'';?>">
				<a href="index.php?c=cat&pid=<?php echo $pid?>&tid=<?php echo $v['id']; ?>" style="font-size: 11px; <?php echo $tid==$v['id']?'color: red; font-weight: bold ;':'';?>"><?php echo $v['classname']?></a></li>
			<?php endforeach;?>
			</ul>
		</div>
		<div class="bg-w inner-cate-list" style="margin-top: 44px">
			<ul>
			<?php if(empty($goods)):?>
			无结果
			<?php endif;?>
			<?php foreach ($goods as $g):?>
				<li><a href="index.php?c=item&id=<?php echo $g['id']; ?>">
						<div class="photo">
							<img src="<?php echo $g['picurl']; ?>">
						</div>
						<div class="p5 item-con">
							<div class="col_0 fs12 tit c"><?php echo $g['title']; ?></div>
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