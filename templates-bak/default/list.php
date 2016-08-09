<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                <?php echo $catInfo['classname']; ?>
            </header>
            <section class="main">
                <?php if($goods['data']): ?>
                <ul class="listivew3 lazy" id="list">
                    <?php echo $goods['data']; ?>
                </ul>
                <?php if ($goods['hasMore']): ?>
                <section class="loadMore">加载更多</section>
                <?php endif; else: ?>
                <div class="emptyMsg">暂无商品信息</div>
                <?php endif; ?>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            var page = 2;
            $(document).ready(function() {
                $('.loadMore').on('click',function(){
                    $.ajax({
                        type: "GET",
                        url: "ajax.php?action=getGoodsList&page=" + page + "&id=<?php echo $catInfo['id']; ?>",
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