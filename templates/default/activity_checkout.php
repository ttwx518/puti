<?php require_once TMPL_DIR . 'public/new_header.php'; ?>

<body>
<?php require_once TMPL_DIR . 'public/new_header_back.php'; ?>

<section class="main">
    <form action="index.php?c=activity_checkout&action=check_order" method="post" id="forms" enctype="multipart/form-data">

        <input type="hidden" name="paymode" value="1" >
        <input type="hidden" name="buy_code" value="<?php echo $activity_info['buy_code'];?>"/>
        <input type="hidden" name="aid" value="<?php echo $id; ?>" >
        <?php if($userInfo['yongjin'] > 0 ) { ?>
            <input type="hidden" name="useintegral" value="<?php echo number_format($userInfo['yongjin']/100,2)?>">
        <?php }?>
        <input type="hidden" name="yunfei" value="<?php echo $activity_info['yunfei']; ?>" >
        <section class="order_confim">

   		<div class="b_g plb32 b_tb table order_confim_num">
			<div class="table-cell v-t item_numpic">
                  <div class="br20 numpic"><img src="<?php echo $activity_info['picurl'];  ; ?> "></div>
            </div>
            <div class="table-cell v-t item_con">
            	<p class="fs28 col_0 t1"><?php if($activity_info['order_type'] == 2) {  ?> 活动认养总数量: <?php } elseif($activity_info['order_type'] == 3) { ?>  活动认购总数量: <?php } ?> <i class="fs36 col_ff"> <?php echo $activity_info['housenum'] +  $activity_info['salenum'];?> </i>颗</p>
                <p class="col_80 t2"><span><?php if($activity_info['order_type'] == 2) {  ?> 已认养: <?php } elseif($activity_info['order_type'] == 3) { ?>  已认购: <?php } ?><i class="fs30 col_ff"> <?php echo $activity_info['salenum'];?> </i>颗</span><span>剩余：<i class="fs30 col_ff"> <?php echo  $activity_info['housenum'] > 0 ?  $activity_info['housenum'] : '0'  ;?> </i>颗</span></p>
            </div>
        </div>

        <div class="b_g b_tb table order_confim_queren">
        	<ul>
                <li class="table">
                        姓名: <input type="text" name="name" id="name" value="" style=" width: 5.5rem; height: 0.74rem; border: 1px solid #dce1e3; -webkit-border-radius: .4rem; text-indent: 10px;" />
                </li>
                <li class="table">
                    手机号: <input type="text" name="mobile" id="mobile" value="" style=" width: 5.5rem; height: 0.74rem; border: 1px solid #dce1e3; -webkit-border-radius: .4rem; text-indent: 10px; "/>
                </li>

                <li class="table">
                      地址: <input type="text" name="address" id="address" value=""  style=" width: 5.5rem; height: 0.74rem; border: 1px solid #dce1e3; -webkit-border-radius: .4rem; text-indent: 10px;" />
                </li>
            	<li class="table">
                	<?php if($activity_info['classid'] == 5) { ?>认养商品 <?php } elseif($activity_info['classid'] == 8) { ?> 认购商品 <?php }?><div class="table-cell text-right order_confim_name"><?php echo $activity_info['title'];?></div>
                </li>
                <li class="table">
                    <?php if($activity_info['classid'] == 5) { ?>认养数量 <?php } elseif($activity_info['classid'] == 8) { ?> 认购数量 <?php }?>
                    <div class="table-cell text-right order_confim_shuliang">
                    	<div class="buy_box">
                        	<i class="minus"></i>
                            <input type="text" name="totalNum" value="<?php echo $activity_info['total_num'];?>" class=" br40 value"/>
                            <i class="plus"></i>
                        </div>
                    </div>
                </li>
                <li class="table">
                    <?php if($activity_info['classid'] == 5) { ?>认养编码 <?php }
                    elseif($activity_info['classid'] == 8) { ?> 认购编码 <?php }?>
                    <div class="table-cell text-right order_confim_bianma"><?php echo $activity_info['buy_code'];?></div>
                </li>
                 <li class="table">
                     <?php if($activity_info['classid'] == 5) { ?>认养年限 <?php } elseif($activity_info['classid'] == 8) { ?> 认购年限 <?php }?>
                    <div class="table-cell text-right order_confim_year">
                    	<select name="buy_year" class="select">
                        	<option value="1">1年</option>
                            <option value="2">2年</option>
                            <option value="3">3年</option>
                            <option value="4">4年</option>
                            <option value="5">5年</option>
                            <option value="6">6年</option>
                            <option value="7">7年</option>
                            <option value="8">8年</option>
                            <option value="9">9年</option>
                            <option value="10">10年</option>

                        </select>
                    </div>
                </li>
            </ul>
        </div>
            <?php if($userInfo['yongjin'] > 0 ) { ?>
        <div class="b_g plb32 b_tb order_confim_dikou">
        	<span class="col_0 fs32">种子抵扣</span>
            <i>可使用<?php echo $userInfo['yongjin'];?>种子抵<?php echo number_format($userInfo['yongjin']/100,2)?>元</i>
            <div class="switch">
            	<input type="checkbox">
            	<span></span>
            </div>
        </div>
　　　　　<?php }?>
        <div class="plb32 order_confim_btn">
        	 <div class="submit"><a href="index.php?c=activity&a=message&id=<?php echo $id;?>"> <button type="button" class="br5 b_g col_a2 b_d combtn ">留    言</button> </a> </div>
            <a href="index.php?c=children"> <div class="submit"><button type="button" class="br5 b_91 col_f combtn ">帮助儿童介绍详情</button></div></a>
            <a href="index.php?c=activity&a=donate&id=<?php echo $id; ?>"> <div class="submit"><button type="button" class="br5 b_a2 col_f combtn ">我要捐赠</button></div> </a>
        </div>
        <section class="article aixin">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit"><?php echo $activity_news['title'];?></div>
                <div class="p30 fs28 info">
                    <?php echo $activity_news['content'];?>
                </div>
            </div>
   		</section>

        <section class="cart_submit">
            <div class="table">
              <div class="table-cell item_tit"><span class="fs32">合计：¥<em id="totalAmount"><?php echo number_format($activity_info['totalAmount'],2);?></em></span> </div>
              <div class="table-cell  item_btn">
                <button type="button" id="check_order">去支付</button>
              </div>
            </div>
  		</section>
   </section>

    </form>
</section>

<script type="application/javascript">

 $(".plus").on('click',function(){
    var num = parseInt($(this).prev().val());
    var price = "<?php echo $activity_info['goodsprice']; ?>";
     $(this).prev().val(num+1);
     var amount = price* (num+1);
     $("#totalAmount").html(amount.toFixed(2));
 });

 $(".minus").on('click',function(){
     var num = parseInt($(this).next().val());
     var price = "<?php echo $activity_info['goodsprice']; ?>";
     if(num != 1){
         $(this).next().val(num-1);
         var amount = price* (num-1);
         $("#totalAmount").html(amount.toFixed(2));
     }
 });
    $("#check_order").on('click',function(){
        var name = $("#name").val();
        var mobile = $("#mobile").val();
        var address = $("#mobile").val();
        if(name == ''){
            alert("请填写姓名");
            return false;
        } else if(mobile == '') {
            alert("请填写手机号");
            return false;
        }else if(address == '') {
            alert("请填写地址");
            return false;
        } else {
            if(confirm('确认要去支付么')){
                $("#forms").submit();
            }

        }

    });


</script>

</body>
</html>
