<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR. 'public/new_header_back.php';?>
<section class="main">
	<section class="shenqin">
    	<section class="choose_text">
            <div class="hd">
               <span <?php if($type == 'prov') { ?> class="on" <?php } ?> ><a href="index.php?c=member&a=apply_house&type=prov"> 省代理</a></span>
                <span <?php if($type == 'city') { ?> class="on" <?php } ?> ><a href="index.php?c=member&a=apply_house&type=city"> 市代理</a></span>
                <span <?php if($type == 'area') { ?> class="on" <?php } ?> ><a href="index.php?c=member&a=apply_house&type=area"> 区代理</a></span>
                <span <?php if($type == 'country') { ?> class="on" <?php } ?> ><a href="index.php?c=member&a=apply_house&type=country"> 县代理</a></span>
            </div>
        </section>
        <section class="b_g com_bi">
                <div class="item_hd">
                    <div class="table">
                        <div class="table-cell"><i class="i1"></i>金种子<?php echo $userInfo['golden_seed'];?>颗</div>
                        <div class="table-cell"><i class="i2"></i>银种子<?php echo $userInfo['silver_seed'];?>颗</div>
                        <div class="table-cell"><i class="i3"></i>铜钟子<?php echo $userInfo['copper_seed'];?>颗</div>
                    </div>
                </div>
        </section>
        <section class="b_d p20 application aixin_shenqing">
            <form action="index.php?c=member&a=apply_house" method="post" onsubmit="return check_data();" id="forms">
                <input type="hidden" name="type" value="<?php echo $type; ?>" />
                <input type="hidden" name="save_action" value="save" />
                <ul>
                    <li>
                        <div class="item_tit">申请人地址</div>
                        <div class="item_con"><input type="text" name="address" id="address" placeholder="请输入申请人地址"/></div>
                    </li>
                    <li>
                        <div class="item_tit">申请人姓名</div>
                        <div class="item_con"><input type="text" name="username" id="username" placeholder="请输入申请人姓名"/></div>
                    </li>
                    <li>
                        <div class="item_tit">申请人会员编号</div>
                        <div class="item_con"><input type="text" name="member_no" id="member_no" placeholder="请输入会员编号"/></div>
                    </li>
                    <li>
                        <div class="item_tit">申请人身份证号</div>
                        <div class="item_con"><input type="text" name="id_no" id="id_no" placeholder="请输入身份证号"/></div>
                    </li>
                    <li>
                        <div class="item_tit">申请人联系方式</div>
                        <div class="item_con"><input type="text" name="mobile" id="mobile" placeholder="请输入联系方式"/></div>
                    </li>
                </ul>
                <div class="submit"><button type="submit" id="submit" class="br10 b_a2 col_f combtn ">确    认</button></div>
            </form>
    	</section>
	</section>
    <section class="article shenqin_wen">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit"><?php echo $activity_news['title'];?></div>
                <div class="p30 fs28 info">
                    <?php echo $activity_news['content'];?>
                </div>
            </div>
   		</section>
</section>
<script type="application/javascript">
    function check_data() {
        var address = $("#address").val();
        var username = $("#username").val();
        var member_no = $("#member_no").val();
        var id_no = $("#id_no").val();
        var mobile = $("#mobile").val();
        var pattern = /^1[23456789]\d{9}$/;
        if(address == ''){
            alert('请输入申请人地址');
            return false;
        } else if(username == '') {
            alert('请输入申请人姓名');
            return false;
        } else if(member_no == '') {
            alert('请输入会员编号');
            return false;
        } else if(id_no == '') {
            alert('请输入身份证号');
            return false;
        } else if(mobile == '') {
            alert('请输入联系方式');
            return false;
        }else {
            return true;
        }
    }



</script>
</body>
</html>
