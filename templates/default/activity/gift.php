<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
	<section class="wrap" style="padding-top: 0">
		<div class="b-d home-search">
			<form action="index.php?c=search" method="post" id="search">
				<button type="button" class="br5 btn"
					onclick="javascript:$('#search').submit();">搜索</button>
				<input name="keyword" type="text" class="inp" value=""
					placeholder="搜索您想要的商品" />
			</form>
		</div>
		<section class="main">

			<div class="p10 home-pro">
				<div class="home-item">
					<div class="item-bd">
						<ul class="goodsul">
						<?php if(empty($goods)):?>
    					<li style="text-align: center; width: 100%">无结果</li>
    					<?php endif;?>
						<?php foreach ($goods as $k=>$v):?>
						<li>
							<?php //if($v['typeid'] == 16) : ?>
    							<?php //if($time >= $v['starttime'] && $time <= $v['endtime']) : ?>
    							<a href="index.php?c=item&id=<?php echo $v['id']; ?>">
								<?php //endif; ?>
							<?php //else: ?>
								<!-- <a href="index.php?c=item&id=<?php //echo $v['id']; ?>"> -->
							<?php //endif; ?>
									<div class="photo">
										<img src="<?php echo $v['picurl']; ?>" />
										<?php if($v['typeid'] == 16):?>
										<span class="sale times" style="color: red" endtime="<?php echo $v['endtime'];?>" starttime="<?php echo $v['starttime'];?>"> </span>
										<?php else:?>
										<span class="sale">已售：<?php echo $v['salenum']; ?>件</span>
										<?php endif; ?>
									</div>
									<div class="p5 tit"><?php echo $v['title']; ?></div>
									<div class="price">
										<span class="col_r fs16 nomal-price"><?php echo number_format($v['salesprice'], 2); ?>积分</span>
										<span class="sale-price fr"><?php echo empty($v['weight'])?'':$v['weight']; ?></span>
									</div>
							</a></li>
						<?php endforeach;?>
						<?php if ($tid ==1):?>
						<li><a href="index.php?c=cat">
									<div class="photo">
										<img src="<?php echo STATIC_PATH; ?>images/url1.jpg" style="height: 270px" class='picurl'/>
									</div>
							</a></li>
							<li><a href="index.php?c=index&tid=16">
									<div class="photo">
										<img src="<?php echo STATIC_PATH; ?>images/url2.jpg" style="height: 270px" class='picurl'>
									</div>
							</a></li>
							<li><a href="index.php?c=index&tid=17">
									<div class="photo">
										<img src="<?php echo STATIC_PATH; ?>images/url3.jpg" style="height: 270px" class='picurl'>
									</div>
							</a></li>
							<li><a href="index.php?c=index&tid=20">
									<div class="photo">
										<img src="<?php echo STATIC_PATH; ?>images/url4.jpg" style="height: 270px" class='picurl'>
									</div>
							</a></li>
							<?php endif;?>
						</ul>
					</div>
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
        $('.picurl').height($('.goodsul li').eq(0).height());
    });
    $(function(){
    	$(window).scroll(function () {
        	if ($(window).scrollTop() > 0) {
     		   $('.home-search').fadeIn(400);//当滑动栏向下滑动时，按钮渐现的时间 
        	} else { 
     		   $('.home-search').fadeOut(200);//当页面回到顶部第一屏时，按钮渐隐的时间 
        	} 
    	});
    });
</script>


<script type="text/javascript">

	function lxfEndtime() {

		$(".times").each(function() {
			var lxfday = $(this).attr("lxfday");//用来判断是否显示天数的变量
			var endtime = $(this).attr("endtime") * 1000;
			var starttime = $(this).attr("starttime") * 1000;
			var nowtime = new Date().getTime(); //今天的日期(毫秒值)
			
// 			var youtime = endtime - nowtime;//还有多久(毫秒值)
// 			var seconds = youtime / 1000;
// 			var minutes = Math.floor(seconds / 60);
// 			var hours = Math.floor(minutes / 60);
// 			var days = Math.floor(hours / 24);
// 			var CDay = days;
// 			var CHour = DD(hours % 24);
// 			var AHour = DD(hours % 24);
// 			var CMinute = DD(minutes % 60);
// 			var CSecond = DD(Math.floor(seconds % 60));//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。

			if(starttime > nowtime){
				var youtime = starttime - nowtime;//还有多久(毫秒值)
				var seconds = youtime / 1000;
				var minutes = Math.floor(seconds / 60);
				var hours = Math.floor(minutes / 60);
				var days = Math.floor(hours / 24);
				var CDay = days;
				var CHour = DD(hours % 24);
				var AHour = DD(hours % 24);
				var CMinute = DD(minutes % 60);
				var CSecond = DD(Math.floor(seconds % 60));//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。
				
				if (days < 1) {
					$(this).html( '还有' + AHour + ":" + CMinute + ":" + CSecond + ' 限购开始');   //输出没有天数的数据
				} else {
					$(this).html( '还有 ' + days + "天" + CHour + ":" + CMinute + ":" + CSecond + ' 限购开始');   //输出有天数的数据
				}
				console.log(1);
			}
			else if (nowtime >= endtime) {
				$(this).html("限购已结束");//如果结束日期小于当前日期就提示过期啦
				return false;
			} else if (endtime >= nowtime && nowtime >= starttime) {
				var youtime = endtime - nowtime;//还有多久(毫秒值)
				var seconds = youtime / 1000;
				var minutes = Math.floor(seconds / 60);
				var hours = Math.floor(minutes / 60);
				var days = Math.floor(hours / 24);
				var CDay = days;
				var CHour = DD(hours % 24);
				var AHour = DD(hours % 24);
				var CMinute = DD(minutes % 60);
				var CSecond = DD(Math.floor(seconds % 60));//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。
				
				if (days < 1) {
					$(this).html( '限购开始：' + AHour + ":" + CMinute + ":" + CSecond);   //输出没有天数的数据
				} else {
					$(this).html( '限购开始：' + days + "天" + CHour + ":" + CMinute + ":" + CSecond);   //输出有天数的数据
				}
			}
			else{
				$(this).html('无状态');
			}
		});
		setTimeout("lxfEndtime()", 1000);
	}

	function DD(i) {
		if (i < 10) {
			i = '0' + i;
		}
		return i;
	}

	$(function() {
		lxfEndtime();
	});
</script>

</body>
</html>