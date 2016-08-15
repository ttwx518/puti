<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR . 'public/new_header_back.php'; ?>
<section class="main">
	<section class="inner_recharge">
        <?php require_once TMPL_DIR . 'public/member_header.php'; ?>
    </section>
    <section class= "b_d icon recharge chongzhi">
		<div class="table">
        	<div class="table-cell v-t tit"><p class="fs32">种子充值</p><p class="fs24 col_80">1元＝1粒种子</p></div>
            <div class="table-cell v-t choose">
            	<select class="select" name="seed_num" id="seed_num">
                    <?php foreach($option as $key => $val) {?>
                        	<option value="<?php echo $val;?>">￥<?php echo $val;?></option>
                                <?php } ?>
				</select>
            </div>
            <div class="table-cell v-t btn">
            	<button type="button" id="recharge" class="br10">充值</button>
            </div>
        </div>	
    </section>
    <section class="article guize">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit"><?php echo $activity_news['title'];?></div>
                <div class="p30 fs28 info">
                    <?php echo $activity_news['content'];?>
                </div>
            </div>
   		</section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

<script type="application/javascript">
    $("#recharge").on('click',function(){
        if(confirm('确定要充值吗?')){
            var seed_num = $("#seed_num").val();
            if(seed_num == ''){
                alert('请选择充值金额');
                return false;
            } else {

                window.location.href="index.php?c=member&a=recharge&save=save&seed_num="+seed_num;

            }

        }
    });
</script>

</body>
</html>
