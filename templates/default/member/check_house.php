<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR. 'public/new_header_back.php';?>
<section class="main">
	<section class="look">
    	<section class="com_top">
        	<section class="b_g look_hd">
                <div class="table">
                    <div class="table-cell v-t choose">
                        <select name="prov" id="prov" class="select">
                                    <option value="">请选择</option>
                                    <?php foreach($area as $key => $val) { ?>
                                    <option value="<?php echo $val['datavalue'];?>"><?php echo $val['dataname'];?></option>
                                    <?php }?>

                        </select>
                    </div>
                    <div class="table-cell v-t btn">
                        <button type="button" id="check" class="br40">查询</button>
                    </div>
                </div>	
    		</section>
        </section>
        <section class="b_g look_list">
        	<ul>
                <?php if(!empty($list)) { ?>
                    <?php foreach($list as $val) {?>
                    <li><a href="index.php?c=citem&id=<?php echo $val['id'];?>"><?php echo $val['title2'];?></a></li>
                        <?php }?>
                <?php } else { ?>
            	<li><a href="javascript:void(0);">暂无数据</a></li>
                <?php }?>
            </ul>
        </section>
    </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

<script type="application/javascript">
    $("#check").on('click',function(){
        var prov = $("#prov").val();
        if(prov == ''){
            alert('请选择');
            return flse;
        }
        window.location.href = "index.php?c=member&a=check_house&select=select&prov="+prov;
    });
</script>

</body>
</html>
