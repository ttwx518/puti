<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
        <section class="wrap">
  <section class="main">
    <section class="bg-w my-seed">
    <?php if(empty($lottery)):?>
      <div class="my-seed-banner"><div class="price" style="padding: 5px">您参加活动
      <strong> <i class="fs16">[<?php echo $infolist['title']?>]</i></strong>可领取小礼品
      <strong> <i class="fs16">[<?php echo $infolist['giftname']?>]</i></strong>一份</div>
      <a href="<?php echo $ret['btnurl']?>" class="br5 link" style="top: 60px"><?php echo $ret['btntext']?></a></div>
    <?php else :?>
      <div class="my-seed-banner"><div class="price" style="padding: 5px">您已经领取了物品
      <strong> <i class="fs16">[<?php echo $infolist['giftname']?>]</i></strong>一份</div>
      <a href="<?php echo $ret['btnurl']?>" class="br5 link" style="top: 60px"><?php echo $ret['btntext']?></a></div>
    <?php endif;?>
    </section>
  </section>
</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>