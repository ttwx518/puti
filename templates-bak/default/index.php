<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header>
                <div class="flexslider banner">
                    <ul class="slides">
                        <?php foreach($banners as $v): ?>
                        <li><a href="<?php echo $v['linkurl'] ? $v['linkurl'] : 'javascript:;'; ?>"><img src="<?php echo $v['picurl']; ?>" alt="<?php echo $v['title']; ?>" /></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </header>
            <section class="main p5">
            	<div class="p5"><img src="<?php echo STATIC_PATH; ?>images/nav.png" width="100%" /></div>
                <div class="title_bar c"><span class="title fs15">商品展示</span></div>
                <ul class="listview fs0 lazy">
                    <?php 
                    foreach($goods as $v):
                        $style = '';
                        if($v['colorval'])
                            $style .= 'color:'.$v['colorval'].';';
                        if($v['boldval'])
                            $style .= 'font-weight:'.$v['boldval'];
                    ?>
                    <li>
                        <a href="index.php?c=item&id=<?php echo $v['id']; ?>" title="<?php echo $v['title']; ?>"><img data-src="<?php echo $v['picurl']; ?>" title="<?php echo $v['title']; ?>" alt="<?php echo $v['title']; ?>" class="img" width="100%" /><div class="p5 fs12"<?php echo $style ? ' style="'.$style.'"' : ''; ?>><?php echo $v['title']; ?></div></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
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