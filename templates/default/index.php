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
			<div class="flexslider banner">
				<ul class="slides">
			<?php foreach($banners as $v): ?>
			<li><a href="<?php echo empty($v['linkurl'])?'javascript:void(0);':$v['linkurl'];?>"><img src="<?php echo $v['picurl']?>" /></a></li>
            <?php endforeach; ?>
		</ul>
			</div>

			<div class="p10 home-pro">
				<div class="br5 home-pro-tab">
					<ul class="table">
						<li class="table-cell <?php echo $tid==1?'on':'';?>"><a
							href="index.php" class="fs12"><span>种子商城</span></a></li>
						<li class="table-cell <?php echo $tid==9?'on':'';?>"><a
							href="index.php?c=cat&pid=4" class="fs12"><span>种子兑换</span></a></li>
						<li class="table-cell <?php echo $tid==16?'on':'';?>"><a
							href="index.php?c=index&tid=16" class="fs12"><span>限时购买</span></a></li>
						<li class="table-cell <?php echo $tid==17?'on':'';?>"><a
							href="index.php?c=cat&pid=17" class="fs12"><span>礼品定制</span></a></li>
					</ul>
				</div>
				<div class="home-item">
					<div class="item-bd">
						<ul class="goodsul">
						<?php if ($tid !=1):?>
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
										<span class="col_r fs16 nomal-price">¥<?php echo number_format($v['salesprice'], 2); ?> </span>
										<span class="sale-price fr"><?php echo empty($v['weight'])?'':$v['weight']; ?></span>
									</div>
							</a></li>
						<?php endforeach;?>
						<?php endif;?>
						<?php if ($tid ==1):?>
						<li style="width: 100%; border-color: #000;"><a href="index.php?c=cat&pid=1">
								<div class="photo" style="border-color: #000">
									<img src="<?php echo STATIC_PATH; ?>images/url5.jpg" class='picurl'/>
								</div>
							</a>
						</li>
						<li style="border-color: #000;"><a href="index.php?c=cat">
								<div class="photo" style="border-color: #000">
									<img src="<?php echo STATIC_PATH; ?>images/url1.jpg" class='picurl'/>
								</div>
							</a>
						</li>
						<li style="border-color: #000;"><a href="index.php?c=index&tid=16">
								<div class="photo" style="border-color: #000">
									<img src="<?php echo STATIC_PATH; ?>images/url2.jpg" class='picurl'>
								</div>
							</a>
						</li>
						<li style="width: 100%; border-color: #000;"><a href="index.php?c=children">
								<div class="photo" style="border-color: #000">
									<img src="<?php echo STATIC_PATH; ?>images/url6.jpg" class='picurl'/>
								</div>
							</a>
						</li>
						<li style="border-color: #000;"><a href="index.php?c=cat&pid=17">
								<div class="photo" style="border-color: #000">
									<img src="<?php echo STATIC_PATH; ?>images/url3.jpg" class='picurl'>
								</div>
							</a>
						</li>
						<li style="border-color: #000;"><a href="index.php?c=cat&pid=20">
								<div class="photo" style="border-color: #000">
									<img src="<?php echo STATIC_PATH; ?>images/url4.jpg" class='picurl'>
								</div>
							</a>
						</li>
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
//         $('.picurl').height($('.goodsul li').eq(0).height());
    });
    $(function(){
//     	$(window).scroll(function () {
//         	if ($(window).scrollTop() > 0) {
//      		   $('.home-search').fadeIn(400);//当滑动栏向下滑动时，按钮渐现的时间 
//         	} else { 
//      		   $('.home-search').fadeOut(200);//当页面回到顶部第一屏时，按钮渐隐的时间 
//         	} 
//     	});
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