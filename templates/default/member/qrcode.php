<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
	<section class="wrap" style="padding-top: 0; padding-bottom: 0">
		<section class="main">
			<div class="share-page">
				<div class="p10 share-hd">
					<img src="<?php echo $userInfo['wechat_headimgurl'];?>" class="fl br5" width="60" height="60">
					<div class="con">
						<div class="br5 bg-f bd con-bd">
							<p>
								我是 <span class="tit"><?php echo $userInfo['wechat_nickname'];?></span>
							</p>
							<p>
								我为 <span class="tit"> 《种子梦》 </span> 代言
							</p>
						</div>
					</div>
				</div>
				<div class="share-banner">
					<img src="<?php echo STATIC_PATH; ?>images/share-banner.jpg">
				</div>
				<div class="bg-f p10 mt10 share-info" style="margin-bottom: 60px;">
					<div class="fs16 share-info-tit">关注奕生缘&nbsp;&nbsp;传递种子力量&nbsp;&nbsp;实现种子梦想</div>
					<div class="pt10 share-info-bd">
						<div class="ewm-scan">
							<img src="uploads/qrcode/<?php echo $userInfo['openid']?>.jpg">
						</div>
					</div>
					<div class="fs16 pt10  share-info-ft">长按指纹 识别图中二维码</div>
				</div>
			</div>
		</section>
	</section>
<?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>