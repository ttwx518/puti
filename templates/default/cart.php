<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap" style="padding-bottom: 100px">
		<section class="main">
			<section class="bg-w buycart">
    	    <form action="index.php?c=cart" method="post">
				<section class="buycart-list">
				<?php $typepid = 0;?>
				<?php if($cart['items']): foreach($cart['items'] as $v): ?>
				<?php $typepid = empty($v['typepid'])?0:$v['typepid']?>
					<div class="table item on">
						<div class="table-cell item-check">
							<div class="check cartIds" price="<?php echo $v['salesprice']; ?>"></div>
							<input type="hidden" name="items[<?php echo $v['id']; ?>]" value="<?php echo $v['id']; ?>" relvalue="<?php echo $v['id']; ?>" />
						</div>
						<div class="table-cell item-photo">
							<img src="<?php echo $v['picurl']; ?>">
						</div>
<!-- 						<div class="fl"> -->
<!--     						<a href="#">删除</a> -->
<!-- 						</div> -->
						<div class="table-cell item-con">
							<div class="fs16 tit">
								<a href="javascript:void(0)"><?php echo $v['title']; ?></a>
							</div>
						<!--<div class="info"><?php //echo $v['description']; ?></div>-->
							<div class="price">
								<span class="br5 fr box_count buy-box"><i class="minus">-</i>
								<input type="text" name="buynums[<?php echo $v['id']; ?>]" class="value buyNum" dataId="<?php echo $v['id']; ?>" value="<?php echo $v['buyNum'];?>"> <i class="plus">+</i></span><strong style="font-size: 14px;height: 30px;line-height: 30px;"><?php echo getTotalUnits2($v['typepid'], $v['salesprice']);?></strong>
							</div>
							<a href="javascript:void(0);" dataId="<?php echo $v['id']; ?>" class="red delete mr20 fs16">删除</a>
						</div>
					</div>
				<?php endforeach; ?>
				<?php else: ?>
                    <div class="emptyMsg">购物车空空如也，快去<a href="index.php" style="color:#ffb12f">购物</a>吧!</div>
                <?php endif; ?>
				</section>
				<section class="cart-submit">
					<div class="table">
						<div class="table-cell item-check  on">
							<div class="check"></div>
						</div>
						<div class="table-cell item-tit">
							全选&nbsp;&nbsp;&nbsp;&nbsp;<span class="fs16" id="totalAmount">合计：<?php echo getTotalUnits2($typepid, $cart['totalAmount']); ?></span>
						</div>
						<div class="table-cell  item-btn">
							<input type="hidden" name="cartSub" value="1" />
							<button type="submit" onclick="return chkCart();" ><?php echo isDuiHuanOrGift($typepid)?'去兑换':'去结算'?></button>
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
function chkCart(){
    var hasItems = false;
    $('.cartIds').each(function(){
        if($(this).parent().parent().hasClass('on')){
            hasItems = true;
        }
    });
    if(!hasItems){
        alert('请选择您需要结算的商品!');
    }
    return hasItems;
}
/**
 * 获取所有勾选商品总价
 * @returns {undefined}
 */
function getCheckedAmount() {
    var amount = 0;
    $('.cartIds').each(function() {
        var $this = $(this);
        if ($(this).parent().parent().hasClass('on')) {
            var price = $this.attr('price'),
                num = $this.parent().parent().find('.buyNum').val();
            amount += price * num;
        }
    });
    if(<?php echo empty(isDuiHuan($typepid))?0:1; ?>){
        $("#totalAmount").html('合计：'+amount+' 粒');
    }else{
    	$("#totalAmount").html('合计：￥'+amount);
    }
}
$(document).ready(function(){
    $('.minus').on('click',function(){
        var $this = $(this),
            $buyNum = $this.next(),
            buyNum = $buyNum.val(),
            id = $buyNum.attr('dataId'),
            hBuyNum = $buyNum.attr('hBuyNum');
        if(!buyNum || !validateRules.isIntege(buyNum)){
            $buyNum.val(hBuyNum);
            return;
        }
        buyNum = parseInt(buyNum);
        if(buyNum<=1){
        	ShowMessage('购买数量最小为1');
        	return false;
        }
        buyNum -= 1;
        if(buyNum <= 0){
            $buyNum.val(hBuyNum);
            return;
        }
        var ret = cart.editCart(id, buyNum);
        if(ret.status){
            $buyNum.val(buyNum);
            $buyNum.attr('hBuyNum', buyNum);
            getCheckedAmount();
        }else{
            ShowMessage(ret.msg);
            location.reload();
        }
    });
    $('.plus').on('click',function(){
        var $this = $(this),
            $buyNum = $this.prev(),
            buyNum = $buyNum.val(),
            id = $buyNum.attr('dataId'),
            hBuyNum = $buyNum.attr('hBuyNum');
        if(!buyNum || !validateRules.isIntege(buyNum)){
            $buyNum.val(hBuyNum);
            return;
        }
        buyNum = parseInt(buyNum);
        buyNum += 1;
        if(buyNum <= 0){
            $buyNum.val(hBuyNum);
            return;
        }
        var ret = cart.editCart(id, buyNum);
        if(ret.status){
            $buyNum.val(buyNum);
            $buyNum.attr('hBuyNum', buyNum);
            getCheckedAmount();
        }else{
        	ShowMessage(ret.msg);
          //  location.reload();
        }
    });
    $('.delete').on('click',function(){
        var $this = $(this),
            id = $this.attr('dataId');
        if(confirm('确认从购物车中删除该商品吗?')){
            if(!id){
                return;
            }
            var ret = cart.editCart(id, 0);
            if(ret.status){
                location.reload();
            }else{
                alert(ret.msg);
                location.reload();
            }
        }
    });

    $(".buycart .item").each(function(){
		$(this).find(".cartIds").click(function(){
			if(!$(this).parent().parent().hasClass('on')){
				$(this).parent().parent().addClass("on");
				$(this).next().val($(this).next().attr("relvalue"));
			}else{
				$(this).parent().parent().removeClass("on");
				$(this).next().val(0);
			}
    		getCheckedAmount();
		});
	});
	
	$(".cart-submit .check").click(function(){
    	if(!$(this).parent().hasClass('on')){
    		$(this).parent().addClass("on");
    	    $($(".buycart-list .item")).addClass("on");
    	}else{
    		$(this).parent().removeClass("on");
    		$($(".buycart-list .item")).removeClass("on");
    	}
    	getCheckedAmount();
	});

	$(".value").on('input',function(){
    	$this = $(this);
        var v = $this.val();
        if(isNaN(v) != false){
        	$this.val(0);
            return false;
        }

        v = parseInt(v);
        if(v<0){
        	$this.val(0);
            return false;
        }
        
        //cart(typeid, goodsid, $this.val());
        //var ret = 
        id = $this.attr('dataId');
        var ret = cart.editCart(id, v);
        getCheckedAmount();
        if(!ret.status) {
         ShowMessage(ret.msg);
        }
    })

});
</script>
</body>
</html>