<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
    <body>
	<section class="wrap">
<section class="main">
    <form action="index.php?c=children" method="post">
	<div class="bg-w p10 shopping_search">
		<div class="table">
			<div class="table-cell item-hd">
				<input name="keywords" type="text" value="<?php echo $keywords;?>" placeholder="姓名或编码或爱心屋名称">
			</div>
			<div class="table-cell item-sub">
				<input type="submit" class="br3 c" value="查找">
				<input type="hidden" name="key_prov" id="key_prov" value="<?php echo $key_prov;?>">
				<input type="hidden" name="key_city" id="key_city" value="<?php echo $key_city;?>">
				<input type="hidden" name="name_prov" id="name_prov" value="<?php echo $name_prov;?>">
				<input type="hidden" name="name_city" id="name_city" value="<?php echo $name_city;?>">
			</div>
		</div>
	</div>
    </form>
	<div class="bg-w shopping_city">
		<div class="ptb10 c item-hd">
			<ul class="table fs14 col_3">
				<li class="table-cell" id="t_prov"><?php echo empty($name_prov)?'选择省份':$name_prov?></li>
				<li class="table-cell" id="t_city"><?php echo empty($name_city)?'选择城市':$name_city?></li>
			</ul>
		</div>
		<div class="item-bd">
			<div class="item-bg"></div>
			<ul class="" id="c_prov">
				<li value='0'>选择省份</li>
				<?php foreach ($provs as $prov):?>
				<li value="<?php echo $prov['datavalue'];?>"><?php echo $prov['dataname'];?></li>
				<?php endforeach;?>
			</ul>
			<ul class="" id="c_city">
				<li value='0'>选择城市</li>
				<?php foreach ($citys as $city):?>
				<li value="<?php echo $city['datavalue'];?>"><?php echo $city['dataname'];?></li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>

	<div class="shopping_list">
		<ul class="bg-w">
		    <?php foreach ($childrens as $v):?>
			<li class="p10">
			<a href="index.php?c=citem&id=<?php echo $v['id']; ?>">
				<div class="table">
					<div class="table-cell v-t item-img">
						<img src="<?php echo $v['picurl']; ?>" alt="" class="br5 imgm">
						<p class="mt10 c col_3"><?php echo $v['title']; ?></p>
					</div>
					<div class="table-cell v-t item-right">
						<h2 class="fs14 col_3"><?php echo $v['title2']; ?><em class="br3 <?php echo empty($v['sex'])?"woman":'man'?>"><?php echo $v['age']; ?>岁</em></h2>
						<p class="col_9 ico1"><?php echo $v['id']; ?></p>
						<p class="col_9 ico2"><?php echo $v['name_prov']; ?>  <?php echo $v['name_city']; ?></p>
						<div class="mt5 con">
							<span class="fl br3 c">语录</span>
							<article class="col_3"><?php echo $v['slogan']; ?></article>
						</div>
						<div class="star star-<?php $hot=ceil($v['hot']/20); echo empty($v['hot'])?'1':(min(5,$hot));?>"></div>
						<span class="hot">热度：<?php echo empty($v['hot'])?'0':$v['hot'];?></span>
					</div>
				</div>
			</a>
			</li>
		    <?php endforeach;?>
		    <?php if(empty($childrens)):?>
		    <li style="text-align: center;margin: 5px;padding: 10px">无结果</li>
		    <?php endif;?>
		</ul>
	</div>
	<div class="returnTop"></div>

</section>
</section>
<?php require_once TMPL_DIR . 'public/footer.php'; ?>
<script type="text/javascript" charset="utf-8" src="<?php echo STATIC_PATH; ?>js/jquery.raty.min.js"></script> 
<script type="text/javascript">
function SelProv(val, input)
{
    //$("#" + input + "_country").html("<option>--</option>");
    $.ajax({
        url: "ajax.php?action=getarea&datagroup=area&level=1&areaval=" + val,
        type: 'get',
        dataType: 'html',
        success: function(data) {
            $("#" + input + "_city").html(data);
        }
    });
}
$(function() {
	$('.star-1').raty({ readOnly: true, score: 1 ,size:15,});
	$('.star-2').raty({ readOnly: true, score: 2 ,size:15,});
	$('.star-3').raty({ readOnly: true, score: 3 ,size:15,});
	$('.star-4').raty({ readOnly: true, score: 4 ,size:15,});
	$('.star-5').raty({ readOnly: true, score: 5 ,size:15,});
	$('.star').find('img').each(function(){
	    $(this).attr('src', 'html/'+$(this).attr('src'));
	});

	$('#c_prov li').each(function(k,v){
		$(this).click(function(){
			$('#t_prov').text($(this).text());
			$('#key_prov').val($(this).val());
			$('#name_prov').val($(this).text());
			$(".shopping_city .item-bd ul").slideUp();
			$(".shopping_city .item-bd .item-bg").parent().hide();
			$('#t_city').text("选择城市");
			$('#key_city').val('');
			$('#name_city').val('');
			SelProv($(this).val(), 'c');
		});
	});

	$('#c_city').on('click','li',function(){
		$('#t_city').text($(this).text());
		$('#key_city').val($(this).val());
		$('#name_city').val($(this).text());
		$(".shopping_city .item-bd ul").slideUp();
		$(".shopping_city .item-bd .item-bg").parent().hide();
	});
});
</script>
</body>
</html>