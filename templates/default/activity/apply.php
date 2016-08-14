<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">种子活动申请</span></header>
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
                <div class="fs36 col_78 contit">上海爱心认购活动介绍</div>
                <div class="p30 fs28 info">
                    <p>2010年6月1日“关注孤儿，呼唤爱——中国品牌童装爱心之旅”更名为“关注儿童，呼唤爱”。“关注儿童，呼唤爱”是由中国品牌童装网主办，中国品牌服装网和时尚126商城承办，于2007年11月1日起开展的，一次大规模、大范围、众多品牌企业联手参与，以改善全国57.3万贫困儿童的生活和学习条件，让贫困儿童健康快乐成长的大型慈善爱心活动。</p>
                </div>
            </div>
   		</section>

    <script type="text/javascript">
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
