<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
    <section class="wrap">
      <section class="main">
        <section class="br10 b-d inner-active-intro">
          <!-- <div class="fs16 col_y tit"><?php //echo $info['title']?></div> -->
          <div class="p10 info">
            <?php echo $info['content']?>
          </div>
        </section>
      </section>
    </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>