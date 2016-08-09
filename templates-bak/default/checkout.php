<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                订单结算
            </header>
            <section class="main">
                <?php if($error): ?>
                <div class="errorMsg mt10"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="index.php?c=checkout" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="addressId" id='addressId' value="<?php echo isset($address['id']) ? $address['id'] : 0; ?>" />
                    <div class="mt10 fs14 addressBox" onclick="location.href='index.php?c=member&a=address&redirect=index.php?c=checkout'">
                        <?php if(!empty($address) && is_array($address)): ?>
                        <p><i class="address_name"></i> <?php echo $address['name']; ?>    <i class="address_iphone ml20"></i> <?php echo $address['mobile']; ?></p>
                        <div class="col_9 fs12"><?php cecho($areas, $address['prov'], 'dataname'); ?> <?php cecho($areas, $address['city'], 'dataname'); ?> <?php cecho($areas, $address['country'], 'dataname'); ?>  <?php echo $address['address']; ?></div>
                        <i class="arrowR"></i>
                        <?php else: ?>
                        <div class="c"><a href="index.php?c=member&a=editAddress&redirect=index.php?c=checkout">+新增收货地址</a></div>
                        <?php endif; ?>
                    </div>
                    <dl class="orderDetails fs10 mt10">
                        <?php foreach($orderCart['items'] as $v): ?>
                        <dd style="border:0;padding:5px" class="clearfix">
                            <img src="<?php echo $v['picurl']; ?>" title="<?php echo $v['title']; ?>" alt="<?php echo $v['title']; ?>" class="img fl" width="80">
                            <div class="col_6">
                                <div class="col_3 fs12"><?php echo $v['title']; ?></div>
                                编码：<?php echo $v['goodsid']; ?><br> 
                                单价：<i class="red">￥<?php echo $v['salesprice']; ?></i> 数量：<?php echo $v['buyNum']; ?> <br>
                            </div>
                        </dd>
                        <?php endforeach; ?>
                        <dd style="padding:5px" class="r">
                            <div class="mt10 r fs12 mr10">
                                运费：<i id="totalFreight" class="red">￥<?php echo number_format($orderCart['totalFreight'], 2); ?></i><br>
                                合计：<i id="totalAmount" class="red">￥<?php echo number_format($orderCart['totalAmount'] + $orderCart['totalFreight'], 2); ?></i>
                            </div>
                        </dd>
                    </dl>
                    <div class="mt10">
                        <div class="bg_white bd clearfix p10 mt5">
                            支付方式
                            <label class="fr" for="paymode1"><input type="radio" name="paymode" id="paymode1" value="1" checked="checked"> 微信支付</label>
                            <!--<label for="paymode2" class="ml20"><input type="radio" name="paymode" id="paymode2" value="2" /> 货到付款</label>-->
                        </div>
                    </div>
                    <div class="mt5">
                        <div class="bg_white bd p10 clearfix">
                            配送方式
                            <span class="fr">快递</span>
                            <select name='postmode' id='postmode' class='fr hide'>
                                <?php foreach($postmodeArr as $v): ?>
                                <option value='<?php echo $v['id']; ?>'><?php echo $v['classname']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="mt5 bg_white bd p10 clearfix hide">
                        发票信息
                        <div class="fr">
                            <label><input type="radio" name="isTax" value="1" /> 需要发票</label>
                            <label class="ml20"><input type="radio" name="isTax" value="0" checked="checked" /> 不需要发票</label>
                        </div>
                    </div>
                    <div class="mt5 hide" id="taxBox">
                        <div class="box-content bd p10 fapiao radius4" style="margin-top:-1px;background-color:#fff;border-top-left-radius:0">
                            <ul>
                                <li>发票抬头：<input type="text" name="taxHead" id='taxHead' class="input" /></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt5">
                        <div class="bg_white bd p10 mt5 ">
                            <textarea placeholder="买家留言" name="buyremark" class="liuyan"></textarea>
                        </div>
                    </div>
                    <div class="mt10 c mb20">
                        <input type='submit' name='checkoutSub' onclick='return cart.checkCheckout();' value='提交订单' class="buttons_a" style="width:80%;line-height:38px" />
                    </div>
                </form>
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
                /*
                $('#postmode').on('change',function(){
                    var postmodeId = $(this).val();
                    cart.orderChange(postmodeId);
                });
                */
            });
        </script>
    </body>
</html>