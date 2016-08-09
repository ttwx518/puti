<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
		<section class="main">
			<section class="goods-detail">
				<div class="goods-detail-photo">
					<img src="<?php echo $goodInfo['picurl']?>" style="width: 100%;color: #000;">
				</div>
				<div class="b-b  p10 goods-detail-info">
				
				<?php if($goodInfo['typeid'] == 16):?>
				<table border='2' cellspacing="0" style="border-color: #000; width: 100%; font-size: 16px; font-weight: bold;">
					<tr style="height: 30px; text-align: center;">
						<td id="status">Month</td>
						<td colspan="2" class="times" style="color: red;" endtime="<?php echo $goodInfo['endtime'];?>" starttime="<?php echo $goodInfo['starttime'];?>">&nbsp;</td>
					</tr>
					<tr style="height: 30px; text-align: center;">
						<td>限购商品</td>
						<td>共计：<?php echo $goodInfo['housenum']?>件</td>
						<td>已售：<?php echo $goodInfo['actualsales']?>件</td>
					</tr>
				</table>
				<?php endif; ?>
				
					<div class="fs18 col_y tit"><?php echo $goodInfo['title']?></div>
					<div class="info" <?php echo $goodInfo['typepid']==17?"style='color: red'":'' ?>><?php echo str_replace("\r\n", '<br>', $goodInfo['description'])?></div>
					<div class="col_r price">
						<strong class="fs24"><?php echo getTotalUnits($goodInfo['typepid'], $goodInfo['salesprice']);?><?php echo $goodInfo['typepid']==17?'定金':''?></strong>
					</div>
				</div>
				<div class="goods-detail-tab">
					<ul>
						<li>商品详情</li>
						<li id="comment">用户评价</li>
					</ul>
				</div>
				<div class="p10 goods-detail-con">
					<div class="b-d goods-detail-content goods-detail-content-1">
						<?php echo $goodInfo['content']?>
					</div>
					<div class="b-d goods-detail-content goods-detail-content-2">
						<div class="user-comment">
							<ul class="no_last">
								<?php foreach ($comments as $k=>$v):?>
								<li>
									<div class="table">
										<div class="table-cell v-t item-face">
											<div class="circle face">
												<img src="<?php echo $v['wechat_headimgurl']?>">
											</div>
										</div>
										<div class="table-cell v-t item-con">
											<div class="fs16 col_0 t1"><?php echo $v['wechat_nickname']?></div>
											<div class="t2"><?php echo date('Y-m-d H:i',$v['createtime'])?></div>
											<div class="t3"><?php echo $v['content']?></div>
										</div>
										<div class="table-cell v-t item-star">
											<div class="star star-4"></div>
										</div>
									</div>
								</li>
								<?php endforeach;?>
								<?php if(empty($comments)):?>
								<li style="text-align: center;">无评论!</li>
								<?php endif;?>
							</ul>
						</div>
					</div>
				</div>
				<div class="goods-buy-bar">
					<div class="table">
						<div class="table-cell item-fav">
							<form id="favform"
								action="index.php?c=item&id=<?php echo $goodInfo['id']?>"
								method="post" enctype="multipart/form-data">
								<input value="1" name="subfav" type="hidden" /> <a
									href="javascript:void(0);"
									onclick="javascript:$('#favform').submit()"
									class="<?php echo empty($fav)?'fav':'faved';?>"
									style="color: #000"><?php echo empty($fav)?'未收藏':'已收藏';?></a>
							</form>
						</div>
						<div class="table-cell item-cart">
							<a href="javascript:cart.addCart(<?php echo $goodInfo['id']; ?>, 1);"><i>加入购物车</i></a>
						</div>
						<div class="table-cell item-buy">
							<a href="javascript:cart.buyNow(<?php echo $goodInfo['id']; ?>, 1);"><i><?php echo isDuiHuanOrGift($goodInfo['typepid'])?'立刻兑换':'立刻购买'?></i></a>
						</div>
					</div>
				</div>
			</section>
		</section>
	</section>
</body>
<script type="text/javascript">
var content_index=0;
if("<?php echo empty($flag)?'':$flag;?>"=='comment'){
	content_index = 1;
}
jQuery(function(){

	//tab
	function Tab(args){
		var tabMenu = args.tabMenu;
		var tabCont = args.tabCont;
		var evt = args.evt || 'click'
		tabMenu.eq(content_index).addClass('on');
		tabCont.eq(content_index).show().siblings().hide();
		tabMenu[evt](function(){
			var _this = jQuery(this);
			var _index = tabMenu.index(_this);
			_this.addClass('on').siblings().removeClass('on');
			tabCont.eq(_index).show().siblings().hide();
			return false;
		});
	}
		
// 	new Tab({
// 			tabMenu : jQuery('.myOrder-tab li'),
// 			tabCont : jQuery('.myOrder-content  .content '),
// 			evt     : 'click'
// 	});
	
	new Tab({
			tabMenu : jQuery('.goods-detail-tab li'),
			tabCont : jQuery('.goods-detail-con .goods-detail-content'),
			evt     : 'click'
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
				$('#status').html("限购等待");
				if (days < 1) {
					$(this).html( AHour + ":" + CMinute + ":" + CSecond);   //输出没有天数的数据
				} else {
					$(this).html(days + "天" + CHour + ":" + CMinute + ":" + CSecond);   //输出有天数的数据
				}

				setTimeout("lxfEndtime()", 1000);
			}

			if (endtime <= nowtime) {
				var youtime = nowtime - endtime;//结束(毫秒值)
				var seconds = youtime / 1000;
				var minutes = Math.floor(seconds / 60);
				var hours = Math.floor(minutes / 60);
				var days = Math.floor(hours / 24);
				var CDay = days;
				var CHour = DD(hours % 24);
				var AHour = DD(hours % 24);
				var CMinute = DD(minutes % 60);
				var CSecond = DD(Math.floor(seconds % 60));//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。
				$('#status').html("限购结束");
				if (days < 1) {
					$(this).html( AHour + ":" + CMinute + ":" + CSecond);   //输出没有天数的数据
				} else {
					$(this).html(days + "天" + CHour + ":" + CMinute + ":" + CSecond);   //输出有天数的数据
				}
				
				return false;
			} else {
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
				$('#status').html("限购开始");
				if (days < 1) {
					$(this).html(AHour + ":" + CMinute + ":" + CSecond+'结束');   //输出没有天数的数据
				} else {
					$(this).html(days + "天" + CHour + ":" + CMinute + ":" + CSecond+'结束');   //输出有天数的数据
				}
				
				setTimeout("lxfEndtime()", 1000);
			}
		});
		// setTimeout("lxfEndtime()", 1000);
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
</html>