<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
        <section class="wrap">
  <section class="main">
    <section class="bg-w my-seed">
      <div class="my-seed-banner"><div class="price" style="color: red; font-size: 16px;">累计种子数量<strong>¥ <i class="fs24"><?php echo number_format($userInfo['totalYongjin'], 2); ?></i></strong></div><a href="index.php?c=member&a=ktx" class="br5 link" style="color: red">我要兑换</a></div>
      <div class="my-seed-bd">
        <div class="p10 b-b item-hd">
          <div class="table">
            <div class="table-cell t1">兑换数量</div>
            <div class="table-cell t2">时间</div>
            <div class="table-cell t3">状态</div>
          </div>
        </div>
        <div class="item-bd">
          <ul>
          <?php if(empty($records['data'])):?>
          <li style="text-align: center;">无数据</li>
          <?php endif;?>
          <?php foreach ($records['data'] as $k=> $v):?>
          <li>
              <div class="table">
                <div class="table-cell t1"><?php echo $v['amount']?></div>
                <div class="table-cell t2"><?php echo date('Y-m-d H:i',$v['createtime'])?></div>
                <div class="table-cell t3"><?php echo $v['status']?></div>
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
</html>