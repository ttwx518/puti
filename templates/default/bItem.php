<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                商品详情
            </header>
            <section class="main">
                <div class="flexslider banner">
                    <ul class="slides">
                        <?php foreach($picArr as $v): ?>
                        <li><img src="<?php echo $v[0]; ?>" title="<?php echo $v[1]; ?>" alt="<?php echo $v[1]; ?>" /></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="p10 line">
                    <div class="fs14 col_3"<?php echo $style ? ' style="'.$style.'"' : '';?>><?php echo $goodInfo['title']; ?></div>
                    <div class="mt10 clearfix">
                        <a href="javascript:cart.buyNow(<?php echo $goodInfo['id']; ?>, 1);" class="buttons_a fr">立即购买</a>
                        <b class="fs24 col1">¥<?php echo $goodInfo['salesprice']; ?></b>
                    </div>
                    <p class="col_9">运费：<?php echo $goodInfo['payfreight'] == '0' ? number_format($goodInfo['freight'], 2) : '0.00'; ?> 元</p>
                </div>
                <div class="content_t relative mt5">
                    <span class="content_title">产品信息</span>
                    <div class="bar"></div>
                </div>
                <div class="text bg_white p10 fs14"><?php echo $goodInfo['content']; ?></div>

                <div class="content_t relative mt10">
                    <span class="content_title">产品特色</span>
                    <div class="bar"></div>
                </div>
                <div class="text bg_white p10 fs14"><?php echo $goodInfo['pcharacteristic']; ?></div>
                <div class="content_t relative mt10">
                    <span class="content_title">品牌介绍</span>
                    <div class="bar"></div>
                </div>
                <div class="text bg_white p10 fs14"><?php echo $goodInfo['bcharacteristic']; ?></div>
            </section>
        </section>
        <div class="cars_bg">
            <div class="cars_box c">
                <h3 class="p10"><img src="<?php echo STATIC_PATH; ?>images/yes.png" width="20" class="v mr10"/>加入购物车成功</h3>
                <div class="clearfix mt20">
                    <a href="javascript:void(0);" class="buttons_a again">继续购物</a>
                    <a href="index.php?c=cart" class="buttons_a" style="margin-left:30px">去结算</a>
                </div>
                <!--<div class="close"></div>-->
            </div>
        </div>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script src="<?php echo STATIC_PATH; ?>js/cart.js"></script>
        <script>
            $(window).load(function() {
                $('.flexslider').flexslider({
                    animation: "slide",
                    directionNav: false,
                    start: function(slider) {
                        //$('body').removeClass('loading');
                    }
                });
            });
        </script>
    </body>
</html>