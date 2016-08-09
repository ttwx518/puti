<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                我的分销商
            </header>
            <section class="main">
                <!--我的分销商默认页面-->
                <?php if($flag == 'default'): ?>
                <div class="member_tab bg_white line c noLast">
                    <a href="javascript:void(0);">我的分销商 <i class="red"><?php echo count($distributors); ?></i></a>
                    <a href="javascript:void(0);">名下分销商 <i class="red"><?php echo $totalDcount; ?></i></a>
                </div>
                <?php if($distributors): ?>
                <ul class="listview2 no_last" style="margin:5px 0 0">
                    <?php foreach($distributors as $v): ?>
                    <li class="clearfix">
                        <i class="arrowR fr"></i>
                        <a href="index.php?c=member&a=distributors&flag=detail&id=<?php echo $v['id']; ?>" class="block col_9"><span class="fr mr40 col_6"><?php echo $v['dCount']; ?></span> <img src="<?php echo $v['wechat_headimgurl']; ?>" alt="" class="avator mr10 v" /> <?php echo $v['wechat_nickname']; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="emptyMsg">暂无分销商</div>
                <?php endif; ?>
                <!--我的分销商业绩详情-->
                <?php elseif($flag == 'detail'): if(!$distributor): ?>
                <div class="emptyMsg">该分销商不存在或已被删除</div>
                <?php else: ?>
                <div class="p10 bg_white line"><?php echo $distributor['wechat_nickname']; ?> 业绩收入</div>
                <div class="p10 bg_white line">所有商品累计贡献佣金：<i class="fs14 red"><?php echo number_format($data['totalYongjin'], 2); ?></i></div>
                <dl class="orderDetails mt5">
                    <?php foreach($data['data'] as $k => $v): ?>
                    <dd class="clearfix member_order_goods_box">
                        <a href="index.php?c=item&id=<?php echo $k; ?>" title="<?php echo $v['title']; ?>"><img src="<?php echo $v['picurl']; ?>" title="<?php echo $v['title']; ?>" alt="<?php echo $v['title']; ?>" class="img fl" height="60" width="60" /></a>
                        <div class="fl div" style="min-width:120px;width:75%">
                            <div class="member_order_title">商品名称：<a href="index.php?c=item&id=<?php echo $k; ?>" title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></a></div>
                            总销量：<i class="red"><?php echo $v['mySaleNum'] + $v['fxsSaleNum']; ?></i> <br>
                            总贡献佣金：<i class="red">￥<?php echo number_format($v['myyongjin'] + $v['fxsyongjin'], 2); ?></i>
                        </div>
                    </dd>
                    <?php endforeach; ?>
                </dl>
                <?php endif; endif; ?>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>