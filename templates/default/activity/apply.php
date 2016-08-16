<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR . 'public/new_header_back.php'; ?>
<section class="main">
	<section class="b_g p20 application shenqing">
    	<form action="index.php?c=activity&a=saveapply" method="post" onsubmit=" return check_data();">
    		<ul>
                <li>
                    <div class="item_tit">企业名称：</div>
                    <div class="item_con"><input type="text" name="cname" id="cname" placeholder="请输入企业的名称"/></div>
                </li>
                <li>
                    <div class="item_tit">活动类别：</div>
                    <div class="item_con">
                        <div class="table">
                            <div class="table-cell"><input type="radio" class="item_check" name="activity_type" id="checkbox_a1" value="1" checked><label for="checkbox_a1"></label>植树认购活动</div>
                            <div class="table-cell"><input type="radio" class="item_check" name="activity_type" id="checkbox_a2" value="2" ><label for="checkbox_a2"></label>爱心认养活动</div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="item_tit">活动时间：</div>
                    <div class="item_con"><input type="text" name="posttime" id="posttime" placeholder="请输入活动时间"/></div>
                </li>
                <li>
                    <div class="item_tit">联系地址：</div>
                    <div class="item_con"><input type="text" name="address" id="address" placeholder="请输入联系人的地址"/></div>
                </li>
                <li>
                    <div class="item_tit">联  系  人：</div>
                    <div class="item_con"><input type="text" name="uname" id="uname" placeholder="请输入联系人"/></div>
                </li>
                <li>
                    <div class="item_tit">联系方式：</div>
                    <div class="item_con"><input type="text" name="mobile" id="mobile" placeholder="请输入联系方式"/></div>
                </li>
        	</ul>
        	<div class="submit"><button type="submit" class="br10 b_a2 col_f combtn ">申请提交</button></div>
       	</form>
    </section>	
    <section class="article shenqing">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit"><?php echo $activity_news['title'];?></div>
                <div class="p30 fs28 info">
                    <?php echo $activity_news['content'];?>
                </div>
            </div>
   		</section>


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
            $("#posttime").scroller('destroy').scroller($.extend(opt['datetime'], opt['default']));

        });



        function check_data() {

            var cnname = $("#cname").val();
            var posttime = $("#posttime").val();
            var address = $("#address").val();
            var uname = $("#uname").val();
            var mobile = $("#mobile").val();
            var mobile_preg = "/^1[23456789]\d{9}/";

            if(cnname == ''){
                alert('请填写企业名称');
                return false;
            } else if(posttime == '' ) {
                alert('请填写活动时间');
                return false;
            } else if(address == '' ) {
                alert('请输入联系人的地址');
                return false;
            } else if(uname == '' ) {
                alert('请输入联系人');
                return false;
            }else if(mobile == '' ) {
                alert('请输入联系方式');
                return false;
            }else if(!mobile_preg.test(mobile)) {
                alert('请输入正确的联系方式');
                return false;
            } else {
                return true;
            }


        }


    </script>

</section>
</body>
</html>
