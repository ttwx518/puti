<!doctype html>
<html>
<?php require_once TMPL_DIR . 'public/header.php'; ?>
<?php require_once TMPL_DIR . 'public/header_back.php'; ?>
<body>
	<section class="wrap">
		<section class="main">
			<section class="love-message">
			    <form action="index.php?c=item&flag=comment&id=<?php echo $id?>" method="post" style="padding: 10px" onsubmit="return checkReturn();">
			    <div style="padding: 10px">商品名称 : <?php echo $goods['title']; ?></div>
				<div class="p10 b-b textarea">
					<textarea name="content" id="content" placeholder="请在这里留下您对该商品的评价"></textarea>
				</div>
				<input type="hidden" name="savecomment" value='1'/>
				<div class="p10 b-b textarea">
				<button type="submit" name="returnSub" class="br5 combtn fr" style="width: 20%; right: 20px">提 交</button>
				</div>
				</form>
			</section>
		</section>
	</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
    <script>
            function checkReturn(){
                var $content = $('#content'),
                    content = $content.val();
                if(!content){
                    ShowMessage('评价不能为空');
                    $content.focus();
                    return false;
                }
            }
        </script>
</html>