<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
	<section class="wrap">
    		<form action="index.php?c=search" method="post" id="search">
			<div class="b-d home-search" style="display: block;">
    			<button type="button" class="br5 btn" onclick="javascript:$('#search').submit();">搜索</button>
    			<input name="keyword" type="text" class="inp" value="<?php echo $keyword;?>" placeholder="搜索您想要的商品" />
    		</div>
    		</form>
		<section class="main">
			<div class="home-item">
				<div class="p5 item-bd">
					<ul>
					<?php if(empty($s_goods)):?>
					<li style="text-align: center; width: 100%">无结果</li>
					<?php endif;?>
				    <?php foreach($s_goods as $v):?>
					<li><a href="index.php?c=item&id=<?php echo $v['id']; ?>">
								<div class="photo">
									<img src="<?php echo $v['picurl']; ?>"><span class="sale">已售：<?php echo $v['salenum']; ?>件</span>
								</div>
								<div class="p5 tit"><?php echo $v['title']; ?></div>
								<div class="price">
									<span class="col_r fs16 nomal-price">¥<?php echo $v['salesprice']; ?> </span>
									<span class="sale-price">克重:<?php echo empty($v['weight'])?'':$v['weight'].'g'; ?></span>
								</div>
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