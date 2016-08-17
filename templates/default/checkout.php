<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
		<section class="main">
			<section class="order-confim">
			<form action="index.php?c=checkout" method="post" enctype="multipart/form-data">
			<input type="hidden" name="addressId" id='addressId' value="<?php echo isset($address['id']) ? $address['id'] : 0; ?>" />
				<input type="hidden" name="order_type" value="<?php echo $orderCart['order_type'];?>" />
				<div class="arrow-icon hasdot bg-f order-confim-address">
				<?php if(!empty($address) && is_array($address)): ?>
				<?php $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>
					<a href="javascript:void(0);" onclick="location.href='index.php?c=member&a=address&redirect=<?php echo $url?>'">
						<div class="item-hd">
							<span class="user"><?php echo $address['name']; ?></span><span class="tel"><?php echo $address['mobile']; ?></span>
						</div>
						<div class="item-bd"><?php cecho($areas, $address['prov'], 'dataname'); ?> <?php cecho($areas, $address['city'], 'dataname'); ?> <?php cecho($areas, $address['country'], 'dataname'); ?>  <?php echo $address['address']; ?></div>
					</a>
				<?php else: ?>
                    <div class="c"><a href="index.php?c=member&a=editAddress&redirect=<?php echo $url?>" class="fs18 red">+新增收货地址</a></div>
                <?php endif; ?>
				</div>
				<?php foreach($orderCart['items'] as $v): ?>
				<?php $typepid = empty($v['typepid'])?0:$v['typepid']?>
				<div class="table bg-w order-confim-item">
					<div class="table-cell item-photo">
						<img src="<?php echo $v['picurl']; ?>">
					</div>
					<div class="table-cell item-con">
						<div class="fs16 tit"><?php echo $v['title']; ?></div>
						<div class="num">数量×<?php echo $v['buyNum']; ?></div>
						<div class="fs16 col_r price"><?php $typepid = empty($v['typepid'])?0:$v['typepid']; echo getTotalUnits2($typepid, $v['salesprice']);?></div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php if($typepid==4):?>
				<div class="bg-w order-confim-payment">
				    <div class="item-hd">
						<span class="col_0">支付方式</span>
					</div>
					<div class="item-bd">
						<span class="col_0 fs15">种子抵扣</span><i>需要<?php echo $orderCart['totalAmount']+$orderCart['yunfei']?>粒种子(<font class="red">【可使用种子<?php echo $userInfo['yongjin']; ?>粒】</font>)</i>
					    <input id="useintegral" name="useintegral" type="hidden" value="<?php echo $orderCart['maxconmision']?>" relvalue="<?php echo $orderCart['maxconmision']?>" />
					    <input type="hidden" name="paymode" value="2" style="">
						<!-- <div class="switch active">
							<input type="checkbox"> <span></span>
						</div> -->
					</div>
				</div>
				<?php elseif ($typepid==20):?>
				<div class="bg-w order-confim-payment">
				    <div class="item-hd">
						<span class="col_0">支付方式</span>
					</div>
					<div class="item-bd">
						<span class="col_0 fs15">认养积分抵扣</span><i>需要<?php echo $orderCart['totalAmount']+$orderCart['yunfei']?>积分(<font class="red">【可使用积分<?php echo $userInfo['jifen']; ?>】</font>)</i>
					    <input id="useintegral" name="useintegral" type="hidden" value="<?php echo $orderCart['maxconmision']?>" relvalue="<?php echo $orderCart['maxconmision']?>" />
					    <input type="hidden" name="paymode" value="2" style="">
						<!-- <div class="switch active">
							<input type="checkbox"> <span></span>
						</div> -->
					</div>
				</div>
				<?php else:?>
				<div class="bg-w  order-confim-payment">
					<div class="item-hd">
						<span class="col_0">支付方式</span>
					</div>
					<div class="item-bd">
						<label class="check-label on"> <input type="hidden" name="paymode" value="1" style=""> &nbsp;
						  <span class="col_0 fs15">微信支付</span><i>使用微信支付</i>
						</label>
					</div>
				</div>
    				<?php if(empty($v['auid'])):?>
        				<div class="bg-w order-confim-balance order-confim-payment">
        				    <div class="item-hd">
        						<span class="col_0">种子抵扣</span>
        					</div>
        					<div class="item-bd">
        						<span class="col_0 fs15">种子共计</span><i><font class="red"><?php echo $userInfo['yongjin']?></font>粒<font class="red">【可抵扣<?php echo $userInfo['yongjin'];//$orderCart['maxconmision']; ?>元】</font></i>
        						<div class="switch" style="margin-top: 2px;">
        							<input type="checkbox"> <span></span>
        						</div>
        					    <input id="useintegral" name="useintegral" type="hidden" value="<?php echo $orderCart['maxconmision']?>" relvalue="<?php echo $orderCart['maxconmision']?>" />
        					</div>
        				</div>
        			<?php else:?>
        			<input id="useintegral" name="useintegral" type="hidden" value="<?php echo $orderCart['maxconmision']?>" relvalue="<?php echo $orderCart['maxconmision']?>" />
    				<?php endif;?>
				<?php endif;?>
				<div class="bg-w  order-confim-payment">
					<div class="item-hd">
						<span class="col_0">配送方式</span>
					</div>
					<div class="item-bd">
						<label class=""><select name='postmode' id='postmode' class='fr' style="width: 30%; margin-right: 10px;">
                                <?php foreach($postmodeArr as $v): ?>
                                <option value='<?php echo $v['id']; ?>'><?php echo $v['classname']; ?></option>
                                <?php endforeach; ?>
                            </select><span class="col_0 fs15"><?php echo empty($orderCart['yunfei'])?'免运费':'运费 <font style="color: red">'.$cfg_freight . '</font> 元'?></span><i>满<?php echo $cfg_freight_free?>包邮</i></label>
					</div>
				</div>
				<div class="bg-w order-confim-message">
					<div class="fbox item-bd">
						<div class="fs16 col_0 tit">买家留言</div>
						<div class="flex textarea">
							<textarea name="" cols="" rows="" placeholder="请将信息备注在这里" name="buyremark"></textarea>
						</div>
					</div>
				</div>
				<section class="cart-submit">
					<div class="table">
						<div class="table-cell item-tit">
						<?php 
						if($typepid == 4){
						    $totalAmount = $orderCart['totalAmount']+$orderCart['yunfei']-$orderCart['minYongjin'];
						}elseif($typepid == 20){
						    $totalAmount = $orderCart['totalAmount']+$orderCart['yunfei']-$orderCart['minJifen'];
						}else{
						    $totalAmount = $orderCart['totalAmount']+$orderCart['yunfei']-$orderCart['maxconmision'];
						}
						?>
							<span class="fs16 totalAmount">合计：<?php echo getTotalUnits2($typepid, $totalAmount); ?></span>
						</div>
						<div class="table-cell  item-btn">
						    <input type="hidden" name='checkoutSub' value="1"/>
						    <input type="hidden" id="typepid" name='typepid' value="<?php echo $typepid;?>"/>
						    <input type="hidden" name='checkoutactivity' value="<?php echo empty($checkoutactivity)?0:$checkoutactivity?>"/>
						    <input type="hidden" name='id' value="<?php echo empty($id)?0:$id?>"/>
						    <input type="hidden" name='buynum' value="<?php echo empty($buynum)?0:$buynum?>"/>
						    <input type="hidden" name="aid" value="<?php echo empty($aid)?0:$aid?>" />
						    <input type="hidden" id="minyongjin" name="minyongjin" value="<?php echo $orderCart['minYongjin']?>" />
						    <input type="hidden" id="minjifen" name="minjifen" value="<?php echo $orderCart['minJifen']?>" />
							<button type="submit" onclick='return cart.checkCheckout();'><?php echo isDuiHuanOrGift($typepid)?'去兑换':'去支付'?></button>
						</div>
					</div>
				</section>
				</form>
			</section>
		</section>
	</section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script src="<?php echo STATIC_PATH; ?>js/cart.js"></script>
<script>
$(document).ready(function(){
    $("input[name='isTax']").on('click', function() {
        var isTax = $(this).val();
        if (isTax == 1) {
            $('#taxBox').fadeIn();
        } else {
            $('#taxBox').fadeOut();
            $('#taxHead').val('');
        }
    });

    $('#postmode').on('change',function(){
        var postmodeId = $(this).val();
        cart.orderChange(postmodeId);
    });

    $(".switch span").click(function(){
    	if(!$(this).parent().hasClass("active")){
 		    $(this).parent().addClass("active");
    	    $("#useintegral").val('0');
    	    $(".totalAmount").text('合计：¥'+(<?php echo $orderCart['totalAmount']+$orderCart['yunfei']; ?>));
    	}else{
    		$(this).parent().removeClass("active");
 		    $("#useintegral").val($("#useintegral").attr('relvalue'));
  		    $(".totalAmount").text('合计：¥'+(<?php echo $orderCart['totalAmount']+$orderCart['yunfei']-$orderCart['maxconmision']; ?>));
    	}
    })	
});
</script>
</body>
</html>