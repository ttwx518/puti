<?php require_once TMPL_DIR . 'public/new_header.php'; ?>

<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">留言</span></header>
<section class="main">
	<section class="liuyan">
          <div class="tit text-center">山东爱心种子认购活动</div>
          <div class="form">
                <form action="index.php?c=activity&a=message" method="post" onsubmit="return checkReturn();" >
                    <input type="hidden" name="savemessage" value='1'/>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <textarea name="content" id="content" class="br10" placeholder="输入留言内容"></textarea>

                    <div class="submit"><button type="submit" class="br10 b_a2 col_f combtn ">留    言</button></div>
                </form>
          </div>
     </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
</body>

<script>
    function checkReturn(){
        var $content = $('#content'),
            content = $content.val();
        if(!content){
            alert('请填写留言内容');
            $content.focus();
            return false;
        }
    }
</script>
</html>
