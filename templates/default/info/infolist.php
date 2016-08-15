<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
<section class="wrap">
  <section class="main">

      <div class="bg-w myOrder-tab">
          <ul>
              <li <?php if( $clsid == 9) { ?> class="on" <?php } ?> style=" width: 33.3%;"><a href="index.php?c=info&a=infolist&clsid=9">活动新闻</a></li>
              <li <?php if( $clsid == 10) { ?> class="on" <?php } ?>  style=" width: 33.3%;"><a href="index.php?c=info&a=infolist&clsid=10">爱心新闻</a></li>
              <li <?php if( $clsid == 11) { ?> class="on" <?php } ?>  style=" width: 33.3%;"><a href="index.php?c=info&a=infolist&clsid=11">其他新闻</a></li>
          </ul>
      </div>


    <section class="bg-w inner-active-dyanmic">
      <ul>
      <?php foreach ($records['data'] as $k=>$v):?>
        <li> <a href="index.php?c=info&a=infodetails&id=<?php echo $v['id']?>">
          <div class="table">
            <div class="table-cell item-photo"><img src="<?php echo $v['picurl']?>"></div>
            <div class="table-cell item-con">
              <div class="fs16 col_y tit"><?php echo $v['title']?></div>
              <div class="info"><?php echo $v['description']?></div>
              <div class="date"><?php echo date('Y-m-d H:i',$v['posttime'])?></div>
            </div>
          </div>
          </a> </li>
          <?php endforeach;?>
      </ul>
    </section>
      <?php require_once TMPL_DIR . 'public/page.php'; ?>
  </section>
</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>