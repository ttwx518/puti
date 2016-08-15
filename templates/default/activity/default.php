<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<header><a href="javascript:window.history.back()" class="back"></a><span class="title">种子活动</span></header>
<section class="main">
	<section class="active_box">
    	<div class="flexslider banner">
          <ul class="slides">
              <?php foreach($banners as $val) { ?>
            <li><a href="<?php echo $val['linkurl'];?>"> <img src="<?php echo $val['picurl'];?>" /></a></li>
              <?php } ?>

          </ul>
        </div>
        <div class="active_list">
        	<div class="active_big">
            	<ul class="clearfix">
                	<li><a href="index.php?c=info&a=infodetails&id=1">种子活动概况</a></li>
                    <li><a href="index.php?c=info&a=activitylist&activity_type=adopt">植树活动认养</a></li>
                    <li><a href="index.php?c=info&a=activitylist&activity_type=subscription">帮困活动认购</a></li>
                    <li><a href="index.php?c=activity&a=apply">种子活动申请</a></li>
                    <li><a href="index.php?c=child_apply">智残儿童申请</a></li>
                    <li><a href="index.php?c=info&a=infolist&clsid=9">种子新闻动态</a></li>
                    <li><a href="#">种子活动交友</a></li>
                </ul>
            </div>
        </div>
    </section>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_PATH ; ?>/new_html/css/flexslider.css">
<script src="<?php echo STATIC_PATH ; ?>/new_html/js/jquery.flexslider.js"></script>
<script type="text/javascript">
		$(window).load(function(){
		  $('.flexslider').flexslider({
			animation: "slide",
			directionNav: false,   
			start: function(slider){
			  //$('body').removeClass('loading');
			}
		  });
		
		}); 
		
</script>
</body>
</html>
