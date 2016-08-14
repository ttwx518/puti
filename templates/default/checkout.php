<?php require_once TMPL_DIR . 'public/new_header.php'; ?>

<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">订单确认</span></header>
<section class="main">
   <section class="order_confim">
   		<div class="b_g plb32 b_tb table order_confim_num">
			<div class="table-cell v-t item_numpic">
                  <div class="br20 numpic"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/face2.jpg"></div>
            </div>
            <div class="table-cell v-t item_con">
            	<p class="fs28 col_0 t1">活动认购总数量<i class="fs36 col_ff"> 10000 </i>颗</p>
                <p class="col_80 t2"><span>已认购：<i class="fs30 col_ff"> 5000 </i>颗</span><span>剩余：<i class="fs30 col_ff"> 5000 </i>颗</span></p>
            </div>
        </div>
        <div class="b_g b_tb table order_confim_queren">
        	<ul>
            	<li class="table">
                	认购商品<div class="table-cell text-right order_confim_name">树苗</div>
                </li>
                <li class="table">
                	认购数量
                    <div class="table-cell text-right order_confim_shuliang">
                    	<div class="buy_box">
                        	<i class="minus"></i>
                            <input type="text" value="1" class=" br40 value"/>
                            <i class="plus"></i>
                        </div>
                    </div>
                </li>
                <li class="table">
                	认购编码<div class="table-cell text-right order_confim_bianma">3847328479</div>
                </li>
                 <li class="table">
                	认购年限
                    <div class="table-cell text-right order_confim_year">
                    	<select class="select">
                        	<option>1年</option>
                            <option>1年</option>
                            <option>1年</option>
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
        	 <div class="submit"><a href="index.php?c=activity&a=message&id=<?php echo $param['id'];?>"> <button type="button" class="br5 b_g col_a2 b_d combtn ">留    言</button> </a> </div>
            <a href="index.php?c=children"> <div class="submit"><button type="button" class="br5 b_91 col_f combtn ">帮助儿童介绍详情</button></div></a>
             <div class="submit"><button type="button" class="br5 b_a2 col_f combtn ">我要捐赠</button></div>
        </div>
        <section class="article aixin">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit">上海爱心认购活动介绍</div>
                <div class="p30 fs28 info">
                    <p>2010年6月1日“关注孤儿，呼唤爱——中国品牌童装爱心之旅”更名为“关注儿童，呼唤爱”。“关注儿童，呼唤爱”是由中国品牌童装网主办，中国品牌服装网和时尚126商城承办，于2007年11月1日起开展的，一次大规模、大范围、众多品牌企业联手参与，以改善全国57.3万贫困儿童的生活和学习条件，让贫困儿童健康快乐成长的大型慈善爱心活动。</p>
                </div>
            </div>
   		</section>
        <section class="cart_submit">
            <div class="table">
              <div class="table-cell item_tit"><span class="fs32">合计：¥198.0</span> </div>
              <div class="table-cell  item_btn">
                <button type="button">去支付</button>
              </div>
            </div>
  		</section>
   </section>
</section>

</body>
</html>
