<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
<section class="wrap">
  <section class="main">
    <section class="love-message">
    <div class="my-seed-banner"><div class="price">我的团队共 <strong><i class="fs24"><?php echo $records['totalnum']?></i></strong> 人</div></div>
      <div class="b-bt love-message-list">
      <div class="user-comment">
            <ul class="no_last">
            <?php if(empty($records['data'])):?>
              <li style="text-align: center;">无数据</li>
            <?php endif;?>
            <?php foreach ($records['data'] as $k=> $v):?>
              <li>
                <div class="table">
                  <div class="table-cell v-t item-face">
                    <div class="circle face"><img src="<?php echo $v['wechat_headimgurl']?>"></div>
                  </div>
                  <div class="table-cell v-t item-con">
                    <div class="fs16 col_y t1"><?php echo $v['wechat_nickname']?></div>
                    <div class="t3"><?php echo $v['rec']?></div>
                    <div class="t2"><?php echo date('Y-m-d H:i',$v['regtime'])?></div>
                  </div>
                </div>
              </li>
              <?php endforeach;?>
            </ul>
          </div>
      </div>
          <?php require_once TMPL_DIR . 'public/page.php'; ?>
    </section>
  </section>
</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
        <script>
    $(document).on('click', '.circle img',function(event) {
        var imgArray = [];
        var curImageSrc = $(this).attr('src');
        $('.circle img').each(function(index, el) {
            var itemSrc = $(this).attr('src');
            imgArray.push(itemSrc);
        });
        wx.previewImage({
            current: curImageSrc,
            urls: imgArray
        });
    });
</script>
</html>