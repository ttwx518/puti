<?php require_once TMPL_DIR . 'public/new_header.php'; ?>

<body>
<?php require_once TMPL_DIR . 'public/new_header_back.php'; ?>

<section class="main">
    <form action="index.php?c=checkout" method="post" enctype="multipart/form-data">
        <input type="hidden" name="addressId" id='addressId' value="<?php echo isset($address['id']) ? $address['id'] : 0; ?>" />
        <input id="useintegral" name="useintegral" type="hidden" value="<?php echo $orderCart['maxconmision']?>" relvalue="<?php echo $orderCart['maxconmision']?>" />
        <input type="hidden" name="paymode" value="2" style="">

        <section class="order_confim">

            <?php foreach($orderCart['items'] as $val) { ?>
   		<div class="b_g plb32 b_tb table order_confim_num">
			<div class="table-cell v-t item_numpic">
                  <div class="br20 numpic"><img src="<?php echo $val['picurl'];  ; ?> "></div>
            </div>
            <div class="table-cell v-t item_con">
            	<p class="fs28 col_0 t1"><?php if($val['order_type'] == '2') {  ?> 活动认养总数量: <?php } elseif($val['order_type'] == '3') { ?>  活动认购总数量: <?php } ?> <i class="fs36 col_ff"> <?php echo $val['housenum'];?> </i>颗</p>
                <p class="col_80 t2"><span><?php if($val['order_type'] == '2') {  ?> 已认养: <?php } elseif($val['order_type'] == '3') { ?>  已认购: <?php } ?><i class="fs30 col_ff"> <?php echo $val['salenum'];?> </i>颗</span><span>剩余：<i class="fs30 col_ff"> <?php echo  $val['housenum'] - $val['salenum'] >= 0 ?  $val['housenum'] - $val['salenum'] : '0'  ;?> </i>颗</span></p>
            </div>
        </div>

            <?php } ?>


        <div class="b_g b_tb table order_confim_queren">
        	<ul>
                <li class="table">
                    地址:<?php  echo get_city_name($address['prov']);?> <?php  echo get_city_name($address['city']);?> <?php  echo get_city_name($address['country']);?> <?php  echo $address['address'];?>
                </li>
            	<li class="table">
                	<?php if($row['classid'] == 5) { ?>认养商品 <?php } elseif($row['classid'] == 6) { ?> 认购商品 <?php }?><div class="table-cell text-right order_confim_name"><?php echo $orderCart['shop_title'];?></div>
                </li>
                <li class="table">
                    <?php if($row['classid'] == 5) { ?>认养数量 <?php } elseif($row['classid'] == 6) { ?> 认购数量 <?php }?>
                    <div class="table-cell text-right order_confim_shuliang">
                    	<div class="buy_box">
                        	<i class="minus"></i>
                            <input type="text" value="<?php echo $orderCart['totalNum'];?>" class=" br40 value"/>
                            <i class="plus"></i>
                        </div>
                    </div>
                </li>
                <li class="table">
                    <?php if($row['classid'] == 5) { ?>认养编码 <?php } elseif($row['classid'] == 6) { ?> 认购编码 <?php }?><div class="table-cell text-right order_confim_bianma">3847328479</div>
                </li>
                 <li class="table">
                     <?php if($row['classid'] == 5) { ?>认养年限 <?php } elseif($row['classid'] == 6) { ?> 认购年限 <?php }?>
                    <div class="table-cell text-right order_confim_year">
                    	<select class="select">
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
        <div class="b_g plb32 b_tb order_confim_dikou">
        	<span class="col_0 fs32">种子抵扣</span>
            <i>可使用3200种子抵32元</i>
            <div class="switch">
            	<input type="checkbox">
            	<span></span>
            </div>
        </div>
        <div class="plb32 order_confim_btn">
        	 <div class="submit"><a href="index.php?c=activity&a=message&id=<?php echo $id;?>"> <button type="button" class="br5 b_g col_a2 b_d combtn ">留    言</button> </a> </div>
            <a href="index.php?c=children"> <div class="submit"><button type="button" class="br5 b_91 col_f combtn ">帮助儿童介绍详情</button></div></a>
             <div class="submit"><button type="button" class="br5 b_a2 col_f combtn ">我要捐赠</button></div>
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
              <div class="table-cell item_tit"><span class="fs32">合计：¥<em id="totalAmount"><?php echo number_format($orderCart['totalAmount'],2);?></em></span> </div>
              <div class="table-cell  item_btn">
                <button type="button">去支付</button>
              </div>
            </div>
  		</section>
   </section>

    </form>
</section>

</body>
</html>
