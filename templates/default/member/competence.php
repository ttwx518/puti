<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">种子会员</span></header>
<section class="main">
	<section class="jieshao">
    	<section class="user_header">
    	<div class="table">
        	<div class="table-cell v-t item_face">
                  <div class="circle face"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/face.jpg"></div>
             </div>
             <div class="table-cell v-t item_con">
					<div class="fs36 user_name">小鬼不会飞</div>
                    <div class="user_num"><span>会员编号：<i>000000001</i></span><span>推荐人：<i>萌萌哒</i></span></div>
                    <div class="user_has">拥有种子：<i>3000</i>颗</div>
             </div>
        </div>
        <ul class="has_seed">
        	<li><i class="i1"></i>金种子<span>110</span>颗</li>
            <li><i class="i2"></i>银种子<span>110</span>颗</li>
            <li><i class="i3"></i>铜种子<span>110</span>颗</li>
        </ul>
    </section>
    	<section class="b_g inner_jieshao">
        	<div class="jieshao_hd">
            	<ul>
                	<li>
                    	<div class="table order_confim_num">
                            <div class="table-cell v-t item_numpic">
                                  <div class="br10 numpic"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_jin.png"/></div>
                            </div>
                            <div class="table-cell v-t item_con">
                                <p class="fs28 col_0">金种子</p>
                                <p class="fs24 col_80">金种金种金种</p>
                            </div>
                        </div>
                    </li>
                    <li>
                    	<div class="table order_confim_num">
                            <div class="table-cell v-t item_numpic">
                                  <div class="br10 numpic"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_yin.png"/></div>
                            </div>
                            <div class="table-cell v-t item_con">
                                <p class="fs28 col_0">银种子</p>
                                <p class="fs24 col_80">金种金种金种</p>
                            </div>
                        </div>
                    </li>   
                </ul>
            </div>
        </section>
        <section class="p20 jieshao_btn">
        	<a href="index.php?c=member&a=check_house" class="br10 b_e2">查看爱心屋</a>
            <a href="index.php?c=member&a=apply_house" class="br10 b_df">申请爱心屋</a>
            <a href="#" class="br10 b_a2">查看红利</a>
        </section>
    </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
</body>
</html>
