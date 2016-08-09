<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">种子活动</span></header>
<section class="main">
   <section class="com_top">
       <section class="inner_hd">
        	<div class="time_set">
                <div class="tixian_time table">
                	<div class="table-cell time">
                    	<input type="text" placeholder="开始" class="text br40"><span class="span"></span>
                        <input type="text" placeholder="结束" class="text br40">
                    </div>
                    <div class="table-cell btn">
                    	<button type="button" class="br40">查询</button>
                    </div>
                </div>
            </div>
        </section>
   </section>
   <div class="seed_search"><input type="text" placeholder="搜索您想要的商品" class="search br40"/></div>
   <div class="b_g choose_text seed_text">
   		<div class="hd">
        	<span >未开始</span>
            <span class="on">进行中</span>
            <span>已结束</span>
        </div>
        <div class="bd pl20">
        	<div class="list">
            	<ul>
                	<li><a href="index.php?c=info&a=activitydetails&id=11">山东xx活动认购</a></li>
                    <li><a href="index.php?c=info&a=activitydetails&id=11">山东xx活动认购</a></li>
                    <li><a href="index.php?c=info&a=activitydetails&id=11">山东xx活动认购</a></li>
                    <li><a href="#">山东xx活动认购</a></li>
                    <li><a href="#">山东xx活动认购</a></li>
                </ul>
            </div>
        </div>
   </div>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>

</body>
</html>
