<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                购物车
            </header>
            <section class="main">
                <form action="index.php?c=cart" method="post">
                    <dl class="orderDetails bd">
                        <!--<dt class="col_3">购物车列表</dt>-->
                        <?php if($cart['items']): foreach($cart['items'] as $v): ?>
                        <dd class="clearfix">
                            <input type="checkbox" name="items[<?php echo $v['id']; ?>]" value="1" checked="checked" class="fl cartIds" style="margin:20px 5px;width:18px;height:18px">
                            <a href="index.php?c=bItem&id=<?php echo $v['id']; ?>" title="<?php echo $v['title']; ?>"><img src="<?php echo $v['picurl']; ?>" title="<?php echo $v['title']; ?>" alt="<?php echo $v['title']; ?>" class="img fl" width="90"></a>
                            <div class="mr10">
                                <div class="desc">
                                    <a href="index.php?c=bItem&id=<?php echo $v['id']; ?>" title="<?php echo $v['title']; ?>"><?php echo $v['title']; ?></a>
                                </div>
                                <p class=""></p>
                                <div class="fr">
                                    <a href="javascript:;" dataId="<?php echo $v['id']; ?>" class="yellow delete mr20">删除</a>
                                    <span class="box_count">
                                        <i class="minus2">-</i>
                                        <input type="text" name="buynums[<?php echo $v['id']; ?>]" dataId="<?php echo $v['id']; ?>" value="<?php echo $v['buyNum']; ?>" hBuyNum="<?php echo $v['buyNum']; ?>" class="value buyNum" readonly="readonly" />
                                        <i class="plus">+</i>
                                    </span>
                                </div>
                                <span class="red">￥<i class="price"><?php echo $v['salesprice']; ?></i></span>
                                <p></p>
                            </div>
                        </dd>
                        <?php endforeach; ?>
                        <dd>
                            <div class="total fs14 ml10 clearfix">
                                <input type="submit" onclick="return chkCart();" name="cartSub" value="去结算>" class="fr buttons_a mr10 v" />
                                总计：<i class="red" id="totalAmount">￥<?php echo number_format($cart['totalAmount'],2); ?></i> 元
                            </div>
                        </dd>
                        <?php else: ?>
                        <div class="emptyMsg">购物车空空如也，快去<a href="index.php?c=cat" style="color:#ffb12f">购物</a>吧!</div>
                        <?php endif; ?>
                    </dl>
                </form>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script src="<?php echo STATIC_PATH; ?>js/cart.js"></script>
        <script>
            function chkCart(){
                var hasItems = false;
                $('.cartIds').each(function(){
                    if($(this).is(':checked')){
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
                    if ($(this).is(":checked")) {
                        var price = $this.parent().find('.price').html(),
                            num = $this.parent().find('.buyNum').val();
                        amount += price * num;
                    }
                });
                $("#totalAmount").html(amount.toFixed(2));
            }
            $(document).ready(function(){
                $('.minus2').on('click',function(){
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
                    buyNum -= 1;
                    if(buyNum <= 0){
                        $buyNum.val(hBuyNum);
                        return;
                    }
                    var ret = cart.editCart(id, buyNum);
                    if(ret.status){
                        $buyNum.val(buyNum);
                        $buyNum.attr('hBuyNum', buyNum);
                        $('#totalAmount').html('￥' + ret.data.totalAmount.toFixed(2));
                    }else{
                        alert(ret.msg);
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
                        $('#totalAmount').html('￥' + ret.data.totalAmount.toFixed(2));
                    }else{
                        alert(ret.msg);
                        location.reload();
                    }
                });
                /*
                $('.buyNum').on('keyup',function(){
                    var $this = $(this),
                        buyNum = $this.val(),
                        id = $this.attr('dataId'),
                        hBuyNum = $this.attr('hBuyNum');
                    if(!buyNum || !validateRules.isIntege(buyNum)){
                        $this.val(hBuyNum);
                        return;
                    }
                    buyNum = parseInt(buyNum);
                    if(buyNum <= 0){
                        $this.val(hBuyNum);
                        return;
                    }
                    var ret = cart.editCart(id, buyNum);
                    if(ret.status){
                        $this.val(buyNum).attr('hBuyNum', buyNum);
                        $('#totalAmount').html('￥' + ret.data.totalAmount.toFixed(2));
                    }else{
                        alert(ret.msg);
                        location.reload();
                    }
                });
                $('#checkAll').on('click',function(){
                    if($(this).is(':checked')){
                        $('.cartIds').prop('checked',true);
                    }else{
                        $('.cartIds').prop('checked',false);
                    }
                    getCheckedAmount();
                });
                */
                $('.cartIds').on('click',function(){
                    /*
                    var allCheck = true;
                    $('.cartIds').each(function(){
                        if(!$(this).is(':checked')){
                            allCheck = false;
                        }
                    });
                    $('#checkAll').prop('checked',allCheck);
                    */
                    getCheckedAmount();
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
            });
        </script>
    </body>
</html>