<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
<body>
	<section class="wrap">
		<section class="main">
			<section class="p10 b-b order-detail">
				<div class="bg-w myOrder-tab">
					<ul>
						<li class="<?php echo $flag=='payment' ?'on':'';?>"><a href="index.php?c=member&a=order&flag=payment">待付款</a></li>
						<li class="<?php echo $flag=='postgoods' ?'on':'';?>"><a href="index.php?c=member&a=order&flag=postgoods">待发货</a></li>
						<li class="<?php echo $flag=='getgoods' ?'on':'';?>"><a href="index.php?c=member&a=order&flag=getgoods">待收货</a></li>
						<li class="<?php echo $flag=='complete' ?'on':'';?>"><a href="index.php?c=member&a=order&flag=complete">已完成</a></li>
					</ul>
				</div>
				<div class="content">
				    <?php if(empty($records['data'])): ?>
					<div class="order-none">您还没有相关订单</div>
					<?php endif;?>
				</div>
				<?php foreach ($records['data'] as $k=> $v):?>
				<div class="myOrder-content">
					<div class="b-b order-detail-hd">
						<Span class="fl tit">订单号：＃<?php echo $v['ordernum']?> </Span><br /><span class="date"><?php echo '时间：'.date('Y-m-d H:i',$v['createtime'])?></span>
					</div>
					<?php foreach ($v['goodsList'] as $gk=> $gv):?>
					<?php $typepid = empty($gv['typepid'])?'':$gv['typepid'];?>
					<div class="table bg-w order-confim-item">
						<div class="table-cell item-photo">
							<img src="<?php echo $gv['picurl']?>">
						</div>
						<div class="table-cell item-con">
							<div class="fs16 tit"><?php echo $gv['title']?></div>
							<div class="num">数量×<?php echo $gv['buyNum']?></div>
							<div class="fs16 col_r price"><?php echo getTotalUnits2($typepid, $gv['salesprice']);?><?php if($v['status']=='4' && empty($v['auid'])):?><a href="index.php?c=member&a=comment&id=<?php echo $gv['gid']?>" class="fr" style="font-size: 14px; color: blue;">评论</a><?php endif;?></div>
						</div>
					</div>
					<?php endforeach;?>
					<div class="order-detail-info">
						<ul>
							<li><div class="table">
									<div class="table-cell item-tit">订单总价：</div>
									<div class="table-cell item-con"><?php echo getTotalUnits2($typepid, $gv['salesprice']);?></div>
								</div></li>
							<li><div class="table">
									<div class="table-cell item-tit">订单状态：</div>
									<div class="table-cell item-con"><?php echo $v['orderStatus']?></div>
								</div></li>
							<li><div class="table">
									<div class="table-cell item-tit">收货人：</div>
									<div class="table-cell item-con"><?php echo $v['name']?></div>
								</div></li>
							<li><div class="table">
									<div class="table-cell item-tit">收货地址：</div>
									<div class="table-cell item-con"><?php echo $v['pccinfo'].$v['address']?></div>
								</div></li>
							<li><div class="table">
									<div class="table-cell item-tit">联系电话：</div>
									<div class="table-cell item-con"><?php echo $v['mobile']?></div>
								</div></li>
						</ul>
					</div>
				<?php if($v['status']==='1'):?>
                <div class="order-detail-submit">
                    <button  type="button" onclick="location.href='topay/wechatpay/js_api_call.php?ordernum=<?php echo $v['ordernum']?>'" class="fr br5 combtn" >付款</button>
                    <button type="button" onclick="member.cancelOrder('<?php echo $v['id']?>');" class="fr br5 combtn" style="margin-right: 20px">取消</button></div>
                <?php endif;?>
                <?php if($v['status']==='2'): ?>
                <div class="order-detail-submit">
                    <?php if(empty($v['auid']) && $typepid!=4 &&$typepid != 20):?>
                    <button  type="button" onclick="location.href='index.php?c=member&a=applyReturn&id=<?php echo $v['id']?>'" style="margin-left: 20px" class="fr br5 combtn">申请退货</button>
                    <?php endif;?>
                    <?php if($gv['islucky']=='true'):?>
                    <button  type="button" onclick="location.href='index.php?c=activity&a=lucky&id=<?php echo $v['id']?>'" style="margin-left: 20px" class="fr br5 combtn">去抽奖</button>
                    <?php endif;?>
                    <?php if($gv['isgift']=='true'):?>
                    <button  type="button" onclick="location.href='index.php?c=cat&pid=20'"  style="margin-left: 20px" class="fr br5 combtn">积分兑换</button>
                    <?php endif;?>
                </div>
                <?php endif;?>
                <?php if($v['status']==='3'): ?>
                <div class="order-detail-submit">
                    <button  type="button" onclick="member.getGoods('<?php echo $v['id']?>');" class="fr br5 combtn">确认收货</button>
                    <button  type="button"  onclick="location.href='http://m.kuaidi100.com/index_all.html?type=<?php echo $v['postcode']?>&postid=<?php echo $v['postid']?>'" class="fr br5 combtn" style="margin-right: 20px">物流查询</button>
                </div>
                <?php endif;?>
                <?php if($v['status']==='4'):?>
                    <div class="order-detail-submit">
                    </div>
                <?php endif;?>
			</div>
				<?php endforeach;?>
		</section>
			<?php require_once TMPL_DIR . 'public/page.php'; ?>
		</section>
	</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
</body>
</html>