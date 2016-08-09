<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
		<section class="main">
			<section class="user-header">
				<div class="table">
					<div class="table-cell item-photo">
						<div class="circle face">
							<img src="<?php echo $userInfo['wechat_headimgurl'] ? $userInfo['wechat_headimgurl'] : STATIC_PATH.'images/avator.png'; ?>" class="circle">
						</div>
					</div>
					<div class="table-cell v-m item-con">
						<div class="name fs18"><?php echo empty($userInfo['wechat_nickname'])?'无':$userInfo['wechat_nickname'];?> </div>
						<div class="level fs18"><?php echo $rec['grand']?></div>
					</div>
				</div>
				<ul>
					<li><a href="index.php?c=member&a=ytx" style="color: #fff">种子：<?php echo $userInfo['yongjin']; ?></a></li>
					<li>由 <?php echo $recName; ?> 推荐</li>
				</ul>
			</section>
			<section class="bg-w user-nav">
				<ul>
					<li class="arrow-icon"><a href="index.php?c=member&a=ytx">我的种子</a></li>
					<li class="arrow-icon"><a href="index.php?c=member&a=qrcode">我的二维码</a></li>
					<li class="arrow-icon"><a href="index.php?c=member&a=order">我的订单</a></li>
					<li class="arrow-icon"><a href="index.php?c=member&a=results">种子业绩</a></li>
					<li class="arrow-icon"><a href="index.php?c=member&a=distributors">我的团队</a></li>
					<li class="arrow-icon"><a href="index.php?c=member&a=address">地址管理</a></li>
					<li class="arrow-icon"><a href="index.php?c=member&a=fav">我的收藏</a></li>
				</ul>
			</section>
		</section>
	</section>
	
	
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>