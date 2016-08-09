<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
<section class="wrap">
  <section class="main">
    <section class="bg-w my-seed">
  <div class="bg-w myOrder-tab">
		<ul>
			<li class="<?php echo $type=='1' ?'on':'';?>" style="width: 33%"><a href="index.php?c=member&a=fav&type=1" style="color: red;">商品</a></li>
			<li class="<?php echo $type=='2' ?'on':'';?>" style="width: 33%"><a href="index.php?c=member&a=fav&type=2" style="color: red;">活动</a></li>
			<li class="<?php echo $type=='3' ?'on':'';?>" style="width: 33%"><a href="index.php?c=member&a=fav&type=3" style="color: red;">爱心儿童</a></li>
		</ul>
	</div>
      <div class="myOrder-content">
        <div class="bg-w content content-1">
          <ul>
          <?php if (empty($favs)):?>
          <li style="text-align: center;">暂无收藏</li>
          <?php endif;?>
          <?php foreach ($favs as $k=>$v):?>
            <li><a href="<?php echo $v['url']?>">
              <div class="table item">
                <div class="table-cell item-photo"><img src="<?php echo $v['picurl']?>"></div>
                <div class="table-cell item-con"> <?php echo "[<span style='color: red;'>".$v['type']."</span>]".$v['title']?> </div>
                <!-- <div class="table-cell item-con"> ￥<?php //echo $v['salesprice']?> </div> -->
              </div>
              </a>
            </li>
            <?php endforeach;?>
          </ul>
        </div>
      </div>
    </section>
  </section>
</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>

    </body>
</html>