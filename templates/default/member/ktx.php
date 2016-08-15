<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR. 'public/new_header_back.php';?>
<section class="main">
	<section class="inner_cash">
    	<section class="inner_recharge">
            <?php require_once TMPL_DIR. 'public/member_header.php';?>
    </section>
    	<section class= "b_d icon recharge tixian">
            <div class="table">
                <div class="table-cell v-t tit"><p class="fs24 col_80">可提现种子</p><p class="fs24 col_80"><i class="fs32 col_93"><?php echo $userInfo['yongjin'];?></i>粒</p></div>
                <div class="table-cell v-t choose">
                    <select class="select">
                                <option>100</option>
                                <option>100</option>
                                <option>100</option>
                    </select>
                </div>
                <div class="table-cell v-t btn">
                    <button type="button" class="br10">提现</button>
                </div>
            </div>	
    	</section>
        <section class="b_d icon com_bi tixian_list">
        	<div class="item_hd">
            	<div class="table">
                	<div class="table-cell"><i class="i1"></i><?php echo $userInfo['golden_seed'];?>颗</div>
                    <div class="table-cell"><i class="i2"></i><?php echo $userInfo['silver_seed'];?>颗</div>
                    <div class="table-cell"><i class="i3"></i><?php echo $userInfo['copper_seed'];?>颗</div>
                </div>
            </div>
            <div class="tixian_bd">
                	<div class="table-cell v-t text"><input type="text" value="1"/></div>
                    <div class="table-cell v-t choose">
                        <select class="select">
                                <option>金</option>
                                <option>银</option>
                                <option>铜</option>
                        </select>
                    </div>
                    <div class="table-cell v-t btn">
                    	<button type="button" class="br10">充值</button>
                    </div>
                    <div class="table-cell v-t btn_duihuan">
                    	<button type="button" class="br10">会员兑换</button>
                    </div>
            </div>
        </section>
        <section class="b_d icon inner_tixian">
        	<div class="time_set">
            	<div class="fs30 col_33 tixian_tit">提现明细查询</div>
                <div class="tixian_time table">
                	<div class="table-cell time">
                    	<input type="text" placeholder="开始" class="text br40"/><span class="span"></span>
                        <input type="text" placeholder="结束" class="text br40"/>
                    </div>
                    <div class="table-cell btn">
                    	<button type="button" class="br40">查询</button>
                    </div>
                </div>
            </div>
            <div class="inner_tixian_list">
            	<ul>
                	<li><span class="fl col_50 fs28">2015.11.11</span><span class="fr col_e2 fs28">¥100.0</span></li>
                    <li><span class="fl col_50 fs28">2015.11.11</span><span class="fr col_e2 fs28">¥100.0</span></li>
                    <li><span class="fl col_50 fs28">2015.11.11</span><span class="fr col_e2 fs28">¥100.0</span></li>
                </ul>
            </div>
        </section>
    </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
</body>
</html>
