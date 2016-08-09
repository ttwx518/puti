<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                业绩收入
            </header>
            <section class="main">
                <!--业绩收入默认页面-->
                <?php if($flag == 'default'): ?>
                <div class="p10 bg_white line">所有商品累计佣金收入：<i class="fs14 red"><?php echo number_format($data['totalYongjin'], 2); ?></i></div>
                <dl class="orderDetails mt5">
                    <?php foreach($data['data'] as $k => $v): ?>
                    <dd class="clearfix member_order_goods_box">
                        <a href="index.php?c=member&a=results&flag=detail&id=<?php echo $k; ?>" title="<?php echo $v['title']; ?>">
                            <img src="<?php echo $v['picurl']; ?>" title="<?php echo $v['title']; ?>" alt="<?php echo $v['title']; ?>" class="img fl" height="60" width="60" />
                            <div class="fl div" style="min-width:120px;width:75%">
                                <div class="member_order_title">
                                    <?php echo $v['title']; ?>
                                </div>
                                <div class="col_9 fs10 mt5">
                                    我的分销业绩：<i class="red">￥<?php echo number_format($v['myyongjin'], 2); ?></i><br> 
                                    我的分销商总业绩：<i class="red">￥<?php echo number_format($v['fxsyongjin'], 2); ?></i> <br> 
                                    累计佣金收入：<i class="red">￥<?php echo number_format($v['myyongjin']+$v['fxsyongjin'], 2); ?></i>
                                </div>
                            </div>
                        </a>
                    </dd>
                    <?php endforeach; ?>
                </dl>
                <!--业绩收入详情-->
                <?php elseif($flag == 'detail'): ?>
                <div class="member_tab bg_white line c noLast">
                    <a href="index.php?c=member&a=results&flag=detail&id=<?php echo $goodInfo['id']; ?>&w=me"<?php if($w == 'me'): echo ' class="red"'; endif; ?>>我的分销业绩</a>
                    <a href="index.php?c=member&a=results&flag=detail&id=<?php echo $goodInfo['id']; ?>&w=fxs"<?php if($w == 'fxs'): echo ' class="red"'; endif; ?>>我的分销商业绩</a>
                </div>
                <?php if($goodInfo): if($w == 'me'): ?>
                <div class="p10 bg_white line">
                    <p>最终可得合计佣金：<i class="red">￥<?php echo number_format($goodInfo['directCommission'] + $goodInfo['indirectCommission'][$userInfo['group_id']], 2); ?></i></p>
                    <div class="col_9 fs10">货主奖励佣金：￥<?php echo $goodInfo['directCommission']; ?> <span class="red">+</span> 平台奖励佣金：￥<?php echo $goodInfo['indirectCommission'][$userInfo['group_id']]; ?></div>
                </div>
                <?php elseif($w == 'fxs'): ?>
                <div class="p10 bg_white line">
                    <p>最终可得合计佣金：<i class="red">￥<?php echo number_format($goodInfo['indirectCommission'][$userInfo['group_id']], 2); ?></i></p>
                    <div class="col_9 fs10">平台奖励佣金：￥<?php echo $goodInfo['indirectCommission'][$userInfo['group_id']]; ?></div>
                </div>
                <?php endif; if($data['data']): ?>
                <table class="table table2 bg_white mt5 c">
                    <tr>
                        <th height="24">客户 <i class="red"><?php echo $data['totalC']; ?></i></th>
                        <th>销量 <i class="red"><?php echo $data['totalS']; ?></i></th>
                        <th>佣金 <i class="red"><?php echo $data['totalY']; ?></i></th>
                    </tr>
                    <?php foreach($data['data'] as $v): ?>
                    <tr>
                        <td class="l">
                            <img src="<?php echo $v['avator']; ?>" alt="" class="v avator" /> <?php echo $v['name']; ?>
                        </td>
                        <td><?php echo $v['saleNum']; ?></td>
                        <td><?php echo $v['yongjin']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; endif; endif; ?>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>