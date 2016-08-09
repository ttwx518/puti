<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
<section class="wrap">
  <section class="main">
    <section class="bg-w address-admin">
      <ul>
            <?php if(!$address['data']): ?>
            <li style="text-align: center;">暂无收货地址</li>
            <?php else: ?>
            <?php echo $address['data']; ?>
            <?php endif;?>
      </ul>
         <div class="address-admin-submit"> <a href="index.php?c=member&a=editAddress&redirect=<?php echo $redirect; ?>" class="br5 btn"><span>新增地址</span></a></div> </section>
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