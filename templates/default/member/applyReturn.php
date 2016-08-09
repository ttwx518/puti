<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
		<section class="main">
			<section class="love-message">
				<form action="index.php?c=member&a=applyReturn" method="post" style="padding: 10px" onsubmit="return checkReturn();">
					<div style="padding: 2px">订单编号 : <?php echo $orderInfo['ordernum']; ?></div>
					<div style="padding: 3px">
						<label><input type="radio" name="refundType" value="1"
							checked="checked" />换货</label>&nbsp;&nbsp;&nbsp; <label><input
							type="radio" name="refundType" value="2" />退货</label>
					</div>
					<div class="p10 b-b textarea">
						<textarea name="content" id="content" placeholder="请输入您的退货/换货理由"></textarea>
					</div>
					<input type="submit" name="returnSub" value="提 交" class="buttons_a mt20" style="width:100%" />
                    <input type="hidden" name="id" id="id" value="<?php echo $orderInfo['id']; ?>" />
				</form>
			</section>
		</section>
	</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            function checkReturn(){
                var $content = $('#content'),
                    content = $content.val();
                if(!content){
                    ShowMessage('请输入退货/退款理由');
                    $content.focus();
                    return false;
                }
            }
        </script>
</body>
</html>