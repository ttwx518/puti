<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR. 'public/new_header_back.php';?>
<section class="main">
	<section class="jieshao">
        <?php require_once TMPL_DIR. 'public/member_header.php';?>
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
                                <p class="fs24 col_80"><?php echo $cfg_golden_description; ?></p>
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
                                <p class="fs24 col_80"><?php echo $cfg_silver_description; ?></p>
                            </div>
                        </div>
                    </li>   
                </ul>
            </div>
        </section>
        <section class="p20 jieshao_btn">
        	<a href="index.php?c=member&a=check_house" class="br10 b_e2">查看爱心屋</a>
            <a href="index.php?c=member&a=apply_house" class="br10 b_df">申请爱心屋</a>
        </section>
    </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
</body>
</html>
