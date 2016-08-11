<?php require_once TMPL_DIR . 'public/new_header.php'; ?>

<body>
<header><a href="javascript:history.back();" class="back"></a><span class="title"><?php echo $info['title']; ?></span><a href="javascript:void(0)" class="share"></a></header>
<section class="main">
	<section class="hdshenqin">
        <section class="com_top">
           <p class="col_80 fs28">
               <?php if($type == 1) { ?>
               未开始，活动倒计时
               <?php } elseif($type == 2) { ?>
                   已结束
               <?php } elseif($type == 3) { ?>
                   进行中，活动倒计时
               <?php } ?>
           </p>
           <p class="col_a2 time" endtime="<?php echo $info['endtime'];?>" starttime="<?php echo $info['starttime'];?>" >15:34:49</p>
        </section>
        <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit"><?php echo $info['title']; ?></div>
                <div class="p30 fs28 info">
                    <?php echo $info['content']; ?>
                </div>

        </div>
        <div class="br20 b_d user_words">
            <div class="worder_com fs30 hd"><span>用户留言</span></div>
            <div class="bd">
                <div class="user_comment">
                    <ul>
                        <?php if(!empty($message)) { ?>
                            <?php foreach($message as $val) { ?>
                        <li class="worder_com">
                            <div class="table">
                                <div class="table-cell v-t item_face">
                                    <div class="circle face"><img src="<?php echo $val['wechat_headimgurl'];?>"></div>
                                </div>
                                <div class="table-cell v-t item_con">
                                    <div class="fs30 col_0 t1"><?php echo $val['wechat_nickname'];?></div>
                                    <div class="col_50 t2"><?php echo date("Y.m.d",$val['createtime']);?></div>
                                    <div class="col_50 t3"><?php echo $val['content'];?></div>
                                </div>
                            </div>
                        </li>
                                <?php }?>
                        <?php } else { ?>
                        <li class="worder_com">
                            <div class="table">
                                暂无
                                </div>
                            </li>

                        <?php }?>

                    </ul>
                 </div>
            </div>
        </div>
        <div class="later">
            <form id="favform"
                  action="index.php?c=info&a=activitydetails&id=<?php echo $info['id']?>"
                  method="post" enctype="multipart/form-data">
                <input value="1" name="subfav" type="hidden" />
            <div class="later_com shoucang "    onclick="javascript:$('#favform').submit()" ><i></i> <?php if(!empty($fav)) { ?> 已收藏<?php } else { ?>收藏 <?php } ?></div>
           </form>
            <a href="<?php echo $info['url']?>"> <div class="later_com iwant"><i></i><?php echo $info['btntext']?></div> </a>
        </div> 
    </section> 
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

<script type="text/javascript">

    function lxfEndtime() {

        $(".time").each(function() {
            var endtime = $(this).attr("endtime") * 1000;
            var starttime = $(this).attr("starttime") * 1000;
            var nowtime = new Date().getTime(); //今天的日期(毫秒值)

            if(starttime > nowtime){
                var youtime = starttime - nowtime;//还有多久(毫秒值)
                var seconds = youtime / 1000;
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                var days = Math.floor(hours / 24);
                var CDay = days;
                var CHour = DD(hours % 24);
                var AHour = DD(hours % 24);
                var CMinute = DD(minutes % 60);
                var CSecond = DD(Math.floor(seconds % 60));//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。
                if (days < 1) {
                    $(this).html(AHour + ":" + CMinute + ":" + CSecond);   //输出没有天数的数据
                } else {
                    $(this).html( days + "天" + CHour + ":" + CMinute + ":" + CSecond );   //输出有天数的数据
                }
            }
            else if (nowtime >= endtime) {
                $(this).html("");//如果结束日期小于当前日期就提示过期啦
                return false;
            } else if (endtime >= nowtime && nowtime >= starttime) {
                var youtime = endtime - nowtime;//还有多久(毫秒值)
                var seconds = youtime / 1000;
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                var days = Math.floor(hours / 24);
                var CDay = days;
                var CHour = DD(hours % 24);
                var AHour = DD(hours % 24);
                var CMinute = DD(minutes % 60);
                var CSecond = DD(Math.floor(seconds % 60));//"%"是取余运算，可以理解为60进一后取余数，然后只要余数。

                if (days < 1) {
                    $(this).html(  + AHour + ":" + CMinute + ":" + CSecond);   //输出没有天数的数据
                } else {
                    $(this).html(days + "天" + CHour + ":" + CMinute + ":" + CSecond);   //输出有天数的数据
                }
            }
            else{
                $(this).html('');
            }
        });
        setTimeout("lxfEndtime()", 1000);
    }

    function DD(i) {
        if (i < 10) {
            i = '0' + i;
        }
        return i;
    }

    $(function() {
        lxfEndtime();
    });
</script>

</body>
</html>
