<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                地址管理
            </header>
            <section class="main">
                <?php if(!$address['data']): ?>
                <div class="emptyMsg">暂无收货地址</div>
                <?php else: ?>
                <div id="list">
                <?php echo $address['data']; ?>
                </div>
                <?php if ($address['hasMore']): ?>
                <section class="loadMore">加载更多</section>
                <?php endif; endif; ?>
                <div class="mt10 c">
                    <a href="index.php?c=member&a=editAddress&redirect=<?php echo $redirect; ?>" class="buttons_a" style="width:80%;line-height:38px">添加收货地址</a>
                </div>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            var page = 2;
            $(document).ready(function() {
                $('.loadMore').on('click',function(){
                    $.ajax({
                        type: "GET",
                        url: "ajax.php?action=getAddressList&page=" + page + "&redirect=<?php echo $redirect; ?>",
                        dataType: "json",
                        success: function(result) {
                            $('#list').append(result.data);
                            page += 1;
                            if (!result.hasMore)
                                $('.loadMore').remove();
                        }, complete: function() {

                        }
                    });
                });
            });
        </script>
    </body>
</html>