<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">种子活动</span></header>
<section class="main">
   <section class="com_top">
       <section class="inner_hd">
        	<div class="time_set">
                <div class="tixian_time table">
                	<div class="table-cell time">
                    	<input type="text" placeholder="开始" id="start_time" class="text br40"><span class="span"></span>
                        <input type="text" placeholder="结束" id="end_time" class="text br40">
                    </div>
                    <div class="table-cell btn">
                    	<button type="button" class="br40">查询</button>
                    </div>
                </div>
            </div>
        </section>
   </section>
   <div class="seed_search"><input type="text" placeholder="搜索您想要的商品" class="search br40"/></div>
   <div class="b_g choose_text seed_text">
   		<div class="hd">
        	<span >未开始</span>
            <span class="on">进行中</span>
            <span>已结束</span>
        </div>
        <div class="bd pl20">
        	<div class="list">
            	<ul>
                	<li><a href="index.php?c=info&a=activitydetails&id=11">山东xx活动认购</a></li>
                    <li><a href="index.php?c=info&a=activitydetails&id=11">山东xx活动认购</a></li>
                    <li><a href="index.php?c=info&a=activitydetails&id=11">山东xx活动认购</a></li>
                    <li><a href="#">山东xx活动认购</a></li>
                    <li><a href="#">山东xx活动认购</a></li>
                </ul>
            </div>
        </div>
   </div>
</section>



<script src="<?php echo STATIC_PATH; ?>/new_html/js/dev/js/mobiscroll.core-2.5.2.js" type="text/javascript"></script>
<script src="<?php echo STATIC_PATH; ?>/new_html/js/dev/js/mobiscroll.core-2.5.2-zh.js" type="text/javascript"></script>
<link href="<?php echo STATIC_PATH; ?>/new_html/js/dev/css/mobiscroll.core-2.5.2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo STATIC_PATH; ?>/new_html/js/dev/css/mobiscroll.animation-2.5.2.css" rel="stylesheet" type="text/css" />
<script src="<?php echo STATIC_PATH; ?>/new_html/js/dev/js/mobiscroll.datetime-2.5.1.js" type="text/javascript"></script>
<script src="<?php echo STATIC_PATH; ?>/new_html/js/dev/js/mobiscroll.datetime-2.5.1-zh.js" type="text/javascript"></script>
<!-- S 可根据自己喜好引入样式风格文件 -->
<script src="<?php echo STATIC_PATH; ?>/new_html/js/dev/js/mobiscroll.android-ics-2.5.2.js" type="text/javascript"></script>
<link href="<?php echo STATIC_PATH; ?>/new_html/js/dev/css/mobiscroll.android-ics-2.5.2.css" rel="stylesheet" type="text/css" />
<!-- E 可根据自己喜好引入样式风格文件 -->
<!-- 时间end -->

<script type="text/javascript">
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
            startYear:currYear, //开始年份
            endYear:currYear + 50 //结束年份
        };
        $("#start_time").scroller('destroy').scroller($.extend(opt['datetime'], opt['default']));
        $("#end_time").scroller('destroy').scroller($.extend(opt['datetime'], opt['default']));
    });
</script>


<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

</body>
</html>
