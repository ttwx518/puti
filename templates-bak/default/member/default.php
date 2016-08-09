<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                会员中心
            </header>
            <section class="main">
                <div class="member_bg">
                    <div class="avator"><img src="<?php echo $userInfo['wechat_headimgurl'] ? $userInfo['wechat_headimgurl'] : STATIC_PATH.'images/avator.png'; ?>" alt="" style="border-radius:39px" /></div>
                    <div class="vip"><?php echo $userInfo['wechat_nickname']; ?><br/>等级：<?php echo $userInfo['groupname']; ?></div>
                    <div class="c member_bar">
                        <a href="index.php?c=member&a=commission">佣金：<?php echo $userInfo['yongjin']; ?></a>
                        <a href="javascript:void(0);" style="border:none">货主：<?php echo $recName; ?></a>
                    </div>
                </div>
                <div class="p10 bg_white line col_6"><?php if($recName): echo '您是由 '.$recName.' 推荐'; else: echo '您暂无推荐人,请联系货主.'; endif; ?></div>
                <ul class=" member_list no_last mt5">
                    <li><a href="index.php?c=member&a=order" class="fr col_9">查看全部订单<i class=" arrowR"></i></a><i class="icon_1"></i>我的订单</li>
                    <li class="member_navs c fs12">
                        <a href="index.php?c=member&a=order&flag=payment"><i class="icons icons_10"></i>待付款<?php if($ordersCount['payment'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['payment']; ?></i><?php endif; ?></a>
                        <a href="index.php?c=member&a=order&flag=postgoods"><i class="icons icons_11"></i>待发货<?php if($ordersCount['postgoods'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['postgoods']; ?></i><?php endif; ?></a>
                        <a href="index.php?c=member&a=order&flag=getgoods"><i class="icons icons_12"></i>待收货<?php if($ordersCount['getgoods'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['getgoods']; ?></i><?php endif; ?></a>
                        <a href="index.php?c=member&a=order&flag=complete"><i class="icons icons_14"></i>已完成<?php if($ordersCount['complete'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['complete']; ?></i><?php endif; ?></a>
                        <a href="index.php?c=member&a=order&flag=applyreturn"><i class="icons icons_13"></i>退货/换货<?php if($ordersCount['applyreturn'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['applyreturn']; ?></i><?php endif; ?></a>
                    </li>
                </ul>
                <ul class="member_list2 no_last mt5 fs14">
                    <li><a href="index.php?c=member&a=distributors"><i class="member_icons i1"></i> 我的分销商</a></li>
                    <li><a href="index.php?c=member&a=results"><i class="member_icons i2"></i> 业绩收入</a></li>
                    <li><a href="index.php?c=member&a=commission"><i class="member_icons i4"></i> 佣金管理</a></li>
                </ul>
                <ul class="member_list2 no_last mt5 fs14">
                    <li><a href="index.php?c=member&a=edit"><i class="member_icons i8"></i> 修改资料</a></li>
                    <li><a href="index.php?c=member&a=address"><i class="member_icons i9"></i> 地址管理</a></li>
                    <li><a href="index.php?c=member&a=logout"><i class="member_icons i10"></i> 注销登录</a></li>
                </ul>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>