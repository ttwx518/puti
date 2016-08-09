<!doctype html>
<html>
<?php require_once TMPL_DIR . 'public/header.php'; ?>
<body>
<section class="wrap">
<?php require_once TMPL_DIR . 'public/header_back.php'; ?>
  <section class="main">
    <section class="inner-renyang inner-withdraw">
    <form id="dataform" action="index.php?c=activity&a=donate" method="post" enctype="multipart/form-data">
      <div class="b-b p10 inner-renyang-hd"><span class="fl col_0 tit">您可以对众筹活动进行种子捐赠</span><a href="index.php?c=member&a=results&type=3" class="fr col_y link">捐赠记录</a></div>
      <div class="p10 inner-renyang-bd">
        <div class="comform">
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
                        <option <?php echo empty($k)?"selected='selected'":''?> value='<?php echo $v['id']?>'><?php echo $v['title']?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
              </li>
              <li>
                <div class="table">
                  <div class="table-cell item-tit">种子数量：</div>
                  <div class="table-cell item-con">
                    <input name="jine" id="jine" type="text" placeholder="请填写整数">
                    <input name="id" id="id" type="hidden" value="">
                    <input name="savedonate" id="savedonate" type="hidden" value="1" />
                  </div>
                </div>
              </li>
              <li>
                <div class="table">
                  <div class="table-cell item-tit" style="width: 120px;">可使用捐赠种子：</div>
                  <div class="table-cell item-con">
                    <input name="total" id="total" type="text" value="<?php echo $userInfo['yongjin'].'粒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'; ?>" disabled="disabled" style="text-align: right; color: red; font-weight: bold;">
                  </div>
                </div>
              </li>
            </ul>
            <div>最多可捐赠 <font style="color: red"><?php echo $userInfo['yongjin']?> </font>粒种子</div>
            <button class="br5 combtn" id="sub_btn" type="button">捐    赠</button>
        </div>
      </div>
      </form>
    </section>
  </section>
</section>
<?php require_once TMPL_DIR . 'public/footer.php'; ?>
</body>
<script type="text/javascript">
$(function(){
    $("#select-txt").text($('#activityid option:selected').text());
    $("#id").val($('#activityid option:selected').val());

	$('#activityid').change(function(){
		$("#select-txt").text($('#activityid option:selected').text());
		$("#id").val($('#activityid option:selected').val());
	});

	$("#sub_btn").click(function(){
		var jine = $("#jine");
		if($.trim(jine.val()) == ''){
			ShowMessage("请填写捐赠种子数量");
			jine.focus();
			return false;
		}
		else if(isNaN(jine.val())){
			ShowMessage("请填写数字");
			jine.focus();
			return false;
		}
		else if(jine.val() <= 0){
			ShowMessage("种子数量需大于0");
			jine.focus();
			return false;
		}
		else if(parseInt(jine.val()) > parseInt("<?php echo $userInfo['yongjin']?>")){
			ShowMessage("没有足够的种子");
			jine.focus();
			return false;
		}

		$('#dataform').submit();
	});
});
</script>
</html>