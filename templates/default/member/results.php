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
			<li class="<?php echo $type==3 ?'on':'';?>" style="width: 33%"><a href="index.php?c=member&a=results&type=3" style="color: red;">种子捐赠</a></li>
			<li class="<?php echo $type==2 ?'on':'';?>" style="width: 33%"><a href="index.php?c=member&a=results&type=2" style="color: red;">种子抵扣</a></li>
			<li class="<?php echo $type==1 ?'on':'';?>" style="width: 33%"><a href="index.php?c=member&a=results&type=1" style="color: red;">种子奖励</a></li>
		</ul>
	</div>
      <div class="my-seed-bd">
        <div class="p10 b-b item-hd">
          <div class="table">
            <div class="table-cell">姓名</div>
            <div class="table-cell">种子积分</div>
            <div class="table-cell">种子明细</div>
            <div class="table-cell">时间</div>
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
                <div class="table-cell"><?php echo $v['wechat_nickname']?></div>
                <div class="table-cell"><?php echo $v['integral']?></div>
                <div class="table-cell"><?php echo $v['content']?></div>
                <div class="table-cell"><?php echo date('Y-m-d',$v['posttime'])?></div>
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