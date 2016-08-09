<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
<section class="wrap">
  <section class="main">
    <section class="bg-w my-seed">
      <div class="myCode-show"> <img src="<?php echo $userInfo['wechat_qrurl'];?>"> </div>
      <div class="myCode-info">
        <div class="tit">二维码说明：</div>
        <div class="info">1, 每个人的二维码是唯一的<br>2, 用二维码来发展您的团队,为您创造收益</div>
      </div>
    </section>
  </section>
</section>
<?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>