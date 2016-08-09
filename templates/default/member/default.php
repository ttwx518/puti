<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<body>
<header><a href="javascript:void(0)" class="back"></a><span class="title">种子会员</span></header>
<section class="main">
	<section class="user_header">
    	<div class="table">
        	<div class="table-cell v-t item_face">
                  <div class="circle face"><img src="<?php echo STATIC_PATH ; ?>/new_html/images/face.jpg"></div>
             </div>
             <div class="table-cell v-t item_con">
					<div class="fs36 user_name">小鬼不会飞</div>
                    <div class="user_num"><span>会员编号：<i>000000001</i></span><span>推荐人：<i>萌萌哒</i></span></div>
                    <div class="user_has">拥有种子：<i>3000</i>颗</div>
             </div>
        </div>
        <ul class="has_seed">
        	<li><i class="i1"></i>金种子<span>110</span>颗</li>
            <li><i class="i2"></i>银种子<span>110</span>颗</li>
            <li><i class="i3"></i>铜种子<span>110</span>颗</li>
        </ul>
    </section>
    <div class="active_list">
        	<div class="active_big">
            	<ul class="clearfix">
                	<li><a href="index.php?c=member&a=my_seed">我的种子</a></li>
                    <li><a href="index.php?c=member&a=distributors">我的团队</a></li>
                    <li><a href="index.php?c=member&a=results">种子业绩</a></li>
                    <li><a href="index.php?c=member&a=qrcode">我的二维码</a></li>
                    <li><a href="index.php?c=member&a=order">我的订单</a></li>
                    <li><a href="index.php?c=member&a=address">地址管理</a></li>
                    <li><a href="index.php?c=member&a=fav">我的收藏</a></li>
                </ul>
            </div>
        </div>
</section>
<?php require_once TMPL_DIR . 'public/new_footer.php'; ?>
</body>
</html>
