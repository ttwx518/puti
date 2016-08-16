<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<?php require_once TMPL_DIR . 'public/new_header_back.php'; ?>
<section class="main">
   <form action="" method="get">
       <input type="hidden" name="c" value="info" />
       <input type="hidden" name="a" value="activitylist" />
       <input type="hidden" name="activity_type" value="<?php echo $activity_type; ?>" />
   <div class="seed_search"><input type="text" name="keywords" placeholder="搜索您想要的活动" class="search br40"/></div>
   </form>
   <div class="b_g choose_text seed_text">
   		<div class="hd">
        	 <span <?php if($type == 1) { ?> class="on" <?php } ?> ><a href="index.php?c=info&a=activitylist&activity_type=<?php echo $activity_type; ?>&type=1"> 未开始</a> </span>
            <span <?php if($type == 3) { ?> class="on" <?php } ?> ><a href="index.php?c=info&a=activitylist&activity_type=<?php echo $activity_type; ?>&type=3">  进行中</a> </span>
           <span <?php if($type == 2) { ?> class="on" <?php } ?> ><a href="index.php?c=info&a=activitylist&activity_type=<?php echo $activity_type; ?>&type=2">  已结束  </a> </span>
        </div>
        <div class="bd pl20">
        	<div class="list">
            	<ul>
                    <?php foreach($list as $val) { ?>
                	<li><a href="index.php?c=info&a=activitydetails&id=<?php echo $val['id'];?>&type=<?php echo $type; ?>"><?php echo $val['title'];?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
   </div>
</section>

<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

</body>
</html>
