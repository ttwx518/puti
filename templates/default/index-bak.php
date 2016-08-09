<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
	<section class="wrap">
		<header>
			<div class="logo">
				<img src="<?php echo STATIC_PATH; ?>images/logo.png">
			</div>
			<span class="tit"><?php echo $seo['title']?></span>
		</header>
		<section class="main">
			<div class="flexslider banner">
				<ul class="slides">
					<?php foreach($banners as $v): ?>
					<li><img src="<?php echo $v['picurl']?>" /></li>
                    <?php endforeach; ?>
				</ul>
			</div>
			<div class="br30 b-d home-search">
    			<form action="index.php" method="get" id="search">
    				<button type="button" class="btn" onclick="javascript:$('#search').submit();"></button>
    				<input name="keyword" type="text" class="inp" value="" placeholder="搜索您想要的商品">
    				<input name="c" type="hidden" value="search">
				</form>
			</div>
			<div class="home-item home-item-1">
				<div class="b-bt p10 item-hd">
					<span class="fl col_0 tit">种子商城</span><a href="index.php?c=search&flag=c" class="fr more">更多&nbsp;&nbsp;&gt;&gt;</a>
				</div>
				<div class="p5 item-bd">
					<ul>
					    <?php foreach($c_goods as $v):?>
						<li><a href="index.php?c=item&id=<?php echo $v['id']; ?>">
								<div class="photo">
									<img src="<?php echo $v['picurl']; ?>">
								</div>
								<div class="table other">
									<div class="table-cell item-tit"><?php echo $v['title']; ?></div>
									<div class="table-cell item-price">¥<?php echo $v['salesprice']; ?></div>
								</div>
								<div class="sale-price">市场价：¥<?php echo $v['marketprice']; ?></div>
						</a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			<div class="home-item home-item-5">
				<div class="b-bt p10 item-hd">
					<span class="fl col_0 tit">积分商城</span><a href="index.php?c=cat" class="fr more">更多&nbsp;&nbsp;&gt;&gt;</a>
				</div>
				<div class="p5 item-bd">
					<ul>
						<?php foreach($j_goods as $v):?>
						<li><a href="index.php?c=item&id=<?php echo $v['id']; ?>">
								<div class="photo">
									<img src="<?php echo $v['picurl']; ?>">
								</div>
								<div class="table other">
									<div class="table-cell item-tit"><?php echo $v['title']; ?></div>
									<div class="table-cell item-price">¥<?php echo $v['salesprice']; ?></div>
								</div>
								<div class="sale-price">市场价：¥<?php echo $v['marketprice']; ?></div>
						</a></li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
						<div class="home-item home-item-3">
				<div class="b-bt p10 item-hd">
					<span class="fl col_0 tit">限时团购</span><a href="index.php?c=search&flag=t" class="fr more">更多&nbsp;&nbsp;&gt;&gt;</a>
				</div>
				<div class="p5 item-bd">
					<ul>
						<?php foreach($t_goods as $v):?>
						<li><a href="index.php?c=item&id=<?php echo $v['id']; ?>">
								<div class="photo">
									<img src="<?php echo $v['picurl']; ?>">
								</div>
								<div class="table other">
									<div class="table-cell item-tit"><?php echo $v['title']; ?></div>
									<div class="table-cell item-price">¥<?php echo $v['salesprice']; ?></div>
								</div>
								<div class="sale-price">市场价：¥<?php echo $v['marketprice']; ?></div>
						</a></li>
						<?php endforeach;?>
						
					</ul>
				</div>
			</div>
			
		</section>
	</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            $(window).load(function() {
                $('.flexslider').flexslider({
                    animation: "slide",
                    directionNav: false,
                    start: function(slider) {
                        //$('body').removeClass('loading');
                    }
                });
            });
        </script>
</body>
</html>