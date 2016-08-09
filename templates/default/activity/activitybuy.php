<!doctype html>
<html>
<?php require_once TMPL_DIR . 'public/header.php'; ?>
<?php require_once TMPL_DIR . 'public/header_back.php'; ?>
<body>
<section class="wrap">
  <section class="main">
    <section class="inner-renyang">
      <div class="b-b p10 inner-renyang-hd"><span class="fl col_0 tit goodstitle"></span><span class="fr col_r price">¥<strong class="fs24 goodsprice"></strong>/<strong class="fs24 goodsunit"></strong></span></div>
      <div class="p10 inner-renyang-bd">
        <div class="comform">
          <form id="dataform" action="index.php?c=checkout" method="post" enctype="multipart/form-data">
            <ul>
              <li>
                <div class="table">
                  <div class="table-cell item-tit">活动名称：</div>
                  <div class="table-cell item-con">
                    <div class="select-txt" id="select-txt"></div>
                    <div class="icon-dot select">
                      <select id="activityid" name="activityid">
                        <!-- <option value='0'>请选择您要参加的活动</option> -->
                        <?php foreach ($infolist as $k=>$v):?>
                        <option goodstitle="<?php echo $v['goodstitle']?>" aid="<?php echo $v['id']?>" goodsprice="<?php echo $v['goodsprice']?>"  goodsunit="<?php echo $v['goodsunit']?>" <?php echo empty($id)?(empty($k)?"selected='selected'":''):($v['id']==$id?"selected='selected'":'')?> value='<?php echo $v['id']?>'><?php echo $v['title']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="table">
                  <div class="table-cell item-tit">认养数量：</div>
                  <div class="table-cell item-con">
                    <div class="select-txt">1</div>
                    <div class="icon-dot select">
                      <select name="buynum" id="buynum">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="20">30</option>
                        <option value="35">35</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                        <option value="60">60</option>
                        <option value="70">70</option>
                        <option value="80">80</option>
                        <option value="90">90</option>
                        <option value="100">100</option>
                        <option value="120">120</option>
                        <option value="140">140</option>
                        <option value="160">160</option>
                        <option value="180">180</option>
                        <option value="200">200</option>
                        <option value="250">250</option>
                        <option value="300">300</option>
                        <option value="350">350</option>
                        <option value="400">400</option>
                        <option value="500">500</option>
                        <option value="600">600</option>
                        <option value="700">700</option>
                        <option value="800">800</option>
                        <option value="900">900</option>
                        <option value="1000">1000</option>
                        <option value="1200">1200</option>
                        <option value="1400">1400</option>
                        <option value="1600">1600</option>
                        <option value="1800">1800</option>
                        <option value="2000">2000</option>
                      </select>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <div class="price"><span class="col_y">认养费用：</span><span class="col_r">¥<strong class="fs20" id="total"></strong></span></div>
            <button class="br5 combtn">认    养</button>
            <input type="hidden" name="checkoutactivity" value="1" />
            <input type="hidden" name="aid" id="aid" value="" />
            <input type="hidden" name="id" value="<?php echo $id?>"/>
          </form>
        </div>
      </div>
    </section>
  </section>
</section>
<?php require_once TMPL_DIR . 'public/footer.php'; ?>
</body>
<script type="text/javascript">
function counttotal(){
	var price = $('#activityid option:selected').attr('goodsprice');
	var num = $('#buynum option:selected').val();
	var total = price*num;
	$('#total').text(total.toFixed(2));
}
$(function(){
    $("#select-txt").text($('#activityid option:selected').text());
	$(".goodstitle").text($('#activityid option:selected').attr('goodstitle'));
	$(".goodsprice").text(parseInt($('#activityid option:selected').attr('goodsprice')).toFixed(2));
	$(".goodsunit").text($('#activityid option:selected').attr('goodsunit'));
	$("#aid").val($('#activityid option:selected').attr('aid'));
	$("#total").text(parseInt($('#activityid option:selected').attr('goodsprice')).toFixed(2));

	$('#activityid').change(function(){
		$("#select-txt").text($('#activityid option:selected').text());
		$(".goodstitle").text($('#activityid option:selected').attr('goodstitle'));
		$(".goodsprice").text($('#activityid option:selected').attr('goodsprice'));
		$(".goodsunit").text($('#activityid option:selected').attr('goodsunit'));
		$("#aid").val($('#activityid option:selected').attr('aid'));
		counttotal();
	});

	$('#buynum').change(function(){
		counttotal();
	});

	$("#sub_btn").click(function(){
		var cname = $("#cname");
		var uname = $("#uname");
		var mobile = $("#mobile");
		var address = $("#address");
		if($.trim(cname.val()) == ''){
			ShowMessage("请填写企业名称");
			cname.focus();
			return false;
		}else if($.trim(uname.val()) == ''){
			ShowMessage("请填写联系人");
			uname.focus();
			return false;
		}else if($.trim(mobile.val()) == ''){
			ShowMessage("请填写联系方式");
			mobile.focus();
			return false;
		}

		$('#dataform').submit();
	});
});
</script>
</html>