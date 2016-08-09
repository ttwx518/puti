<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                商品档期
            </header>
            <section class="main">
                <?php if($cats): ?>
                <ul class="listivew3 lazy" id="list">
                    <?php foreach($cats as $v): ?>
                    <li><a href="index.php?c=list&id=<?php echo $v['id']; ?>" title="<?php echo $v['classname']; ?>" class="clearfix"><?php if($v['picurl']): ?><img data-src="<?php echo $v['picurl']; ?>" title="<?php echo $v['classname']; ?>" alt="<?php echo $v['classname']; ?>" class="img v mr10" /><?php endif; echo $v['classname']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="emptyMsg">暂无商品档期</div>
                <?php endif; ?>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>