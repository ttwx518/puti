<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR. 'public/new_header_back.php';?>
<section class="main">
	<section class="inner_sale">
        <?php require_once TMPL_DIR. 'public/member_header.php';?>
    	<section class="sale_text">
        	<div class="b_g fs32 clo_0 sale_tit">种子转让</div>
            <div class="b_g p20 sale_list">
            	<form>
                    <ul class="com_text">
                        <li>
                        	<div class="table">
                            	<div class="table-cell item_tit">金种子：</div>
                                <div class="table-cell item_con"><input name="golden_seed" id="golden_seed" type="text" placeholder="请输入您的金种子数量"></div>
                            </div>
                        </li>
                        <li>
                        	<div class="table">
                            	<div class="table-cell item_tit">银种子：</div>
                                <div class="table-cell item_con"><input name="silver_seed" id="silver_seed" type="text" placeholder="请输入您的银种子数量"></div>
                            </div>
                        </li>
                        <li>
                        	<div class="table">
                            	<div class="table-cell item_tit">会员编号：</div>
                                <div class="table-cell item_con"><input name="member_no" id="member_no" type="text" placeholder="请输入对方的会员编号"></div>
                            </div>
                        </li>
                    </ul> 
                </form>
            </div>
		<div class="p20 zhuanran_btn">
             <div class="submit"><button type="button" class="br10 b_df col_f combtn ensure ">确    认</button></div>
             <div class="submit"><button type="button" class="br10 b_a2 col_f combtn confirm">提    交</button></div>
        </div>
        </section>
    </section>
</section>

<script type="application/javascript">

    function ckeck_data(){
        var golden_seed = $("#golden_seed").val();
        var silver_seed = $("#silver_seed").val();
        var member_no = $("#member_no").val();
        if(golden_seed == '' && silver_seed ==''){
            alert('请填写转让的种子数量');
            return false;
        }
        if(member_no == ''){
            alert('请输入会员编号');
            return false;
        }
        return true;
    }


    $(".confirm").on('click',function(){
        var golden_seed = $("#golden_seed").val();
        var silver_seed = $("#silver_seed").val();
        var member_no = $("#member_no").val();
        if(ckeck_data()){
            $.post('index.php?c=member&a=transfer&type=confirm',{member_no : member_no,golden_seed:golden_seed,silver_seed:silver_seed},function(ret){
                alert(ret);
            });
        }
    });

    $(".ensure").on('click',function(){
        var golden_seed = $("#golden_seed").val();
        var silver_seed = $("#silver_seed").val();
        var member_no = $("#member_no").val();

        if(ckeck_data()){
            $.post('index.php?c=member&a=transfer&type=ensure',{member_no : member_no},function(ret){
                alert(ret);
            });
        }
    });



</script>



</body>
</html>
