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
                <div class="table-cell v-t tit"><p class="fs24 col_80">可提现种子</p><p class="fs24 col_80"><i class="fs32 col_93"><?php echo $seed_widthdraw;?></i>粒=<?php echo $seed_money; ?> 元</p></div>
                <div class="table-cell v-t choose">
                    <input type="hidden" name="seed_widthdraw" value="<?php echo $seed_widthdraw; ?>" id="seed_widthdraw" />
                    <input type="hidden" name="seed_money" value="<?php echo $seed_money; ?>" id="seed_money" />
                    <select class="select">
                        <?php foreach($withdraw as $v) { ?>
                                <option value="<?php echo $v;?>" ><?php echo $v;?>元</option>
                        <?php } ?>

                    </select>
                </div>
                <div class="table-cell v-t btn">
                    <button type="button" class="br10" id="tixian">提现</button>
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
                	<div class="table-cell v-t text"><input name="number" id="number" type="text" value="1"/></div>
                    <div class="table-cell v-t choose">
                        <select class="select" name="seed_type" id="seed_type">
                                <option value="1">金</option>
                                <option value="2">银</option>
                                <option value="3">铜</option>
                        </select>
                    </div>
<!--                    <div class="table-cell v-t btn">-->
<!--                    	<button type="button" class="br10">充值</button>-->
<!--                    </div>-->
                    <div class="table-cell v-t btn_duihuan">
                    	<button type="button" class="br10" id="duihuang">会员兑换</button>
                    </div>
            </div>
        </section>
        <section class="b_d icon inner_tixian">
        	<div class="time_set">
            	<div class="fs30 col_33 tixian_tit">提现明细查询</div>

                <div class="tixian_time table">
                	<div class="table-cell time">
                    	<input type="text" placeholder="开始" name="starttime" id="starttime" value="" class="text br40"/><span class="span"></span>
                        <input type="text" placeholder="结束" name="endtime" id="endtime" value=""  class="text br40"/>
                    </div>
                    <div class="table-cell btn">
                    	<button type="button" id="submit" class="br40">查询</button>
                    </div>
                </div>

            </div>
            <div class="inner_tixian_list">
            	<ul>
                    <?php if(!empty($list)) { ?>
                    <?php foreach($list as $val ) { ?>
                	<li><span class="fl col_50 fs28"><?php echo date("Y.m.d",$val['createtime']);?></span><span class="fr col_e2 fs28">¥<?php echo number_format($val['amount'],2);?></span></li>
                    <?php } ?>
                    <?php } else { ?>
                        <li><span class="fl col_50 fs28">暂无数据</span></li>
                    <?php } ?>
                </ul>
            </div>
        </section>
    </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

<script src="<?php echo STATIC_PATH; ?>new_html/js/dev/js/mobiscroll.core-2.5.2.js" type="text/javascript"></script>
<script src="<?php echo STATIC_PATH; ?>new_html/js/dev/js/mobiscroll.core-2.5.2-zh.js" type="text/javascript"></script>
<link href="<?php echo STATIC_PATH; ?>new_html/js/dev/css/mobiscroll.core-2.5.2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_PATH; ?>new_html/js/dev/css/mobiscroll.animation-2.5.2.css" rel="stylesheet" type="text/css" />
<script src="<?php echo STATIC_PATH; ?>new_html/js/dev/js/mobiscroll.datetime-2.5.1.js" type="text/javascript"></script>
<script src="<?php echo STATIC_PATH; ?>new_html/js/dev/js/mobiscroll.datetime-2.5.1-zh.js" type="text/javascript"></script>
<!-- S 可根据自己喜好引入样式风格文件 -->
<script src="<?php echo STATIC_PATH; ?>new_html/js/dev/js/mobiscroll.android-ics-2.5.2.js" type="text/javascript"></script>
<link href="<?php echo STATIC_PATH; ?>new_html/js/dev/css/mobiscroll.android-ics-2.5.2.css" rel="stylesheet" type="text/css" />
<!-- E 可根据自己喜好引入样式风格文件 -->
<!-- 时间end -->


<script type="application/javascript">
    $("#tixian").on('click',function(){
        var seed_widthdraw = $("#seed_widthdraw").val();
        var seed_money = $("#seed_money").val();
        $.post("index.php?c=member&a=ktx", {seed_widthdraw : seed_widthdraw, seed_money :　seed_money, type: 'tixian'　}, function(ret){
           alert(ret);
            window.location.reload();
        });
    });

    $("#duihuang").on('click',function(){
        var seed_type = $("#seed_type").val();
        var number = $("#number").val();
        $.post("index.php?c=member&a=ktx", {number : number, seed_type :　seed_type, type: 'duihuang'　}, function(ret){
            alert(ret);
            window.location.reload();
        });
    });

    $(function () {
        var currYear = (new Date()).getFullYear();
        var opt={};
        opt.date = {preset : 'date'};
        //opt.datetime = { preset : 'datetime', minDate: new Date(2012,3,10,9,22), maxDate: new Date(2014,7,30,15,44), stepMinute: 5  };
        opt.datetime = {preset : 'datetime'};
        opt.time = {preset : 'time'};
        opt.default = {
            theme: 'android-ics light', //皮肤样式
            display: 'modal', //显示方式
            mode: 'scroller', //日期选择模式
            lang:'zh',
            startYear:currYear-3, //开始年份
            endYear:currYear + 50 //结束年份
        };
        $("#starttime").scroller('destroy').scroller($.extend(opt['date'], opt['default']));
        $("#endtime").scroller('destroy').scroller($.extend(opt['date'], opt['default']));

    });

    $("#submit").on('click',function(){
        var starttime = $("#starttime").val();
        var endtime = $("#endtime").val();
        if(starttime == '' && endtime == ''){
            alert('请选择时间');
            return false;
        }
        window.location.href="index.php?c=member&a=ktx&starttime="+starttime+"&endtime="+endtime;

    });

</script>

</body>
</html>
