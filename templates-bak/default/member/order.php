<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <style>
        .page_info{clear:both;margin:10px 0;text-align:center}
        .page_list{clear:both;margin:10px 0;text-align:center}
        .page_list a{width:18px;height:18px;line-height:18px;display:inline-block;border:1px solid #ccc;margin:0 2px;padding:1px}
        .page_list a.on{background-color:#f15157;color:#fff}
    </style>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                我的订单
            </header>
            <section class="main">
                <div class="member_navs c fs10" style="padding:5px 0;border-bottom:1px solid #dedede">
                    <a href="index.php?c=member&a=order&flag=payment"><i class="icons icons_10"></i>待付款<?php if($ordersCount['payment'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['payment']; ?></i><?php endif; ?></a>
                    <a href="index.php?c=member&a=order&flag=postgoods"><i class="icons icons_11"></i>待发货<?php if($ordersCount['postgoods'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['postgoods']; ?></i><?php endif; ?></a>
                    <a href="index.php?c=member&a=order&flag=getgoods"><i class="icons icons_12"></i>待收货<?php if($ordersCount['getgoods'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['getgoods']; ?></i><?php endif; ?></a>
                    <a href="index.php?c=member&a=order&flag=complete"><i class="icons icons_14"></i>已完成<?php if($ordersCount['complete'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['complete']; ?></i><?php endif; ?></a>
                    <a href="index.php?c=member&a=order&flag=applyreturn"><i class="icons icons_13"></i>退货/换货<?php if($ordersCount['applyreturn'] > 0): ?><i class="member_order_count"><?php echo $ordersCount['applyreturn']; ?></i><?php endif; ?></a>
                </div>
                <?php if(!$orders['data']): ?>
                <div class="emptyMsg"><?php echo $orders['emptyMsg']; ?></div>
                <?php else: ?>
                <div id="list">
                <?php echo $orders['data']; ?>
                </div>
                <?php if ($orders['hasMore']): ?>
                <section class="loadMore">加载更多</section>
                <?php endif; endif; ?>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            var page = 2;
            $(document).ready(function() {
                $('.loadMore').on('click',function(){
                    $.ajax({
                        type: "GET",
                        url: "ajax.php?action=getOrdersList&page=" + page + "&flag=<?php echo $flag; ?>",
                        dataType: "json",
                        success: function(result) {
                            $('#list').append(result.data);
                            page += 1;
                            if (!result.hasMore)
                                $('.loadMore').remove();
                        }, complete: function() {

                        }
                    });
                });
            });
        </script>
    </body>
</html>