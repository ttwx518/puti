<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
		<section class="main">
			<section class="goods-detail">
				<div class="goods-detail-photo">
					<img src="<?php echo $children['picurl']?>" style="width: 100%;color: #000;">
				</div>
				<div class="b-b  p10 goods-detail-info">
					<div class="fs18 col_y tit"><?php echo $children['title'];?>(<?php echo $children['dataname'];?>)</div>
					<div class="col_r price">
						<strong class="fs24"><a href="index.php?c=item&id=<?php echo $children['goodsid']?>" class="col_r">点击查看商品</a></strong>
					</div>
				</div>
				<div class="">
					<div class="b-d goods-detail-content goods-detail-content-1">
						<?php echo $children['content']?>
					</div>
				</div>
			</section>
		</section>
	</section>
	<?php require_once TMPL_DIR . 'public/footer.php'; ?>
</body>
</html>