<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR. 'public/new_header_back.php';?>
<section class="main">
	<section class="inner_leave">
        <?php require_once TMPL_DIR. 'public/member_header.php';?>
    	<section class= "b_d recharge shengji">
            <div class="table">
                <div class="table-cell v-t tit"><p class="fs32 col_0">种子升级</p></div>
                <div class="table-cell v-t choose">

                    <select class="select" name="seed" id="seed">
                        <?php foreach($options as $key => $val) {?>
                                <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                        <?php } ?>
                    </select>

                </div>
                <div class="table-cell v-t btn">
                    <button type="button" id="upgrade" class="br10">升级</button>
                </div>
            </div>
    	</section> 
        <section class="shengji_list">
        	<ul>
            	<li class="item1">
                	<div class="table">
                    	<div class="table-cell t1"><?php echo $cfg_common_copper; ?>粒普通种子</div>
                        <div class="table-cell t1">=</div>
                        <div class="table-cell t1"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_tong.png"/>铜种子1颗</div>
                    </div>
                </li>
                <li class="item1">
                	<div class="table">
                    	<div class="table-cell t1"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_tong.png"/>铜种子<?php echo $cfg_copper_silver; ?>颗</div>
                        <div class="table-cell t1">=</div>
                        <div class="table-cell t1"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_yin.png"/>银种子1颗</div>
                    </div>
                </li>
                <li class="item1">
                	<div class="table">
                    	<div class="table-cell t1"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_yin.png"/>银种子<?php echo $cfg_silver_golden; ?>颗 </div>
                        <div class="table-cell t1">=</div>
                        <div class="table-cell t1"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/icon_jin.png"/>金种子1颗</div>
                    </div>
                </li>
            </ul>  
        </section>
        <section class="article aixin">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit"><?php echo $activity_news['title'];?></div>
                <div class="p30 fs28 info">
                    <?php echo $activity_news['content'];?>
                </div>
            </div>
   		</section>
    </section>
</section>
<script type="application/javascript">
    $("#upgrade").on('click',function(){
        var seed = $("#seed").val();
        if(seed == ''){
            alert('请选择');
            return false;
        }
        $.post("index.php?c=member&a=upgrade&type=upgrade",{seed : seed}, function(ret){
            if(ret.status){
                alert('升级成功');
            } else{
                alert(ret.msg);
            }

        });

    });
</script>

<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
</body>
</html>
