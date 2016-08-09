<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
	<section class="wrap">
    <?php require_once TMPL_DIR . 'public/header_back.php'; ?>
		<section class="main">
			<section class="order-confim">
                <?php if($success): ?>
                <div class="successMsg"><?php echo $success; ?></div>
                <?php endif; if($error): ?>
                <div class="errorMsg"><?php echo $error; ?></div>
                <?php endif; ?>
                <div class="p10 inner-renyang-bd">
                <div class="addressForm">
                <form action="index.php?c=member&a=editAddress" method="post">
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                    <ul>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">姓<i></i><i></i>名：</div>
                              <div class="table-cell item-con">
                                <input name="name" id="name" value="<?php cecho($address, 'name'); ?>" type="text" placeholder="请输入收货人姓名">
                              </div>
                            </div>
                        </li>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">手机号：</div>
                              <div class="table-cell item-con">
                                <input name="mobile" id="mobile" value="<?php cecho($address, 'mobile'); ?>" type="text" placeholder="请输入收货人手机号">
                              </div>
                            </div>
                        </li>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">省份：</div>
                              <div class="table-cell item-con">
                                <div class="select-txt">--选择省份--</div>
                                <div class="icon-dot select">
                                  <select class="selectc" name="prov" id="prov" rel="city">
                                    <option value="0">--选择省份--</option>
                                    <?php foreach ($provs as $v): ?>
                                    <option value="<?php echo $v['datavalue']; ?>" <?php echo isset($address['prov']) && $v['datavalue'] == $address['prov'] ? 'selected="selected"' : '' ?>><?php echo $v['dataname']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </li>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">城市：</div>
                              <div class="table-cell item-con">
                                <div class="select-txt">--选择城市--</div>
                                <div class="icon-dot select">
                                  <select class="selectc" name="city" id="city" rel="country">
                                    <option value="0">--选择城市--</option>
                                    <?php if(!empty($cities)): foreach($cities as $c): ?>
                                    <option value="<?php echo $c['datavalue']; ?>" <?php echo isset($address['city']) && $c['datavalue'] == $address['city'] ? 'selected="selected"' : ''; ?>><?php echo $c['dataname']; ?></option>
                                    <?php endforeach; endif; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </li>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">区县：</div>
                              <div class="table-cell item-con">
                                <div class="select-txt">--选择区县--</div>
                                <div class="icon-dot select">
                                  <select class="selectc" name="country" id="country" rel="">
                                    <option value="0">--选择区县--</option>
                                    <?php if(!empty($countries)): foreach($countries as $c): ?>
                                    <option value="<?php echo $c['datavalue']; ?>" <?php echo isset($address['country']) && $c['datavalue'] == $address['country'] ? 'selected="selected"' : ''; ?>><?php echo $c['dataname']; ?></option>
                                    <?php endforeach;endif; ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </li>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">详细地址：</div>
                              <div class="table-cell item-con">
                                <input name="address" id="address" value="<?php cecho($address, 'address'); ?>" type="text" placeholder="请输入详细地址">
                              </div>
                            </div>
                        </li>
                        <li>
                            <div class="table">
                              <div class="table-cell item-tit">邮<i></i><i></i>编：</div>
                              <div class="table-cell item-con">
                                <input name="zipcode" id="zipcode" value="<?php cecho($address, 'zipcode'); ?>" type="text" placeholder="请输入邮编">
                              </div>
                            </div>
                        </li>
                        <li style="border: 0px;"><label><input type="checkbox" name="isDefault" value="1" <?php echo isset($address['isDefault'])?($address['isDefault']==1?'checked="checked"':''):'checked="checked"'?> /> 设为默认收货地址</label></li>
                    </ul>
                    <div class="error"></div>
                    <div class="mt10 c">
                        <input type="hidden" name="id" value="<?php echo isset($address['id']) ? $address['id'] : 0; ?>" />
                        <button type="submit" onclick="return member.checkAddress();" name="addressSub" class="br5 combtn" style="width:96%; line-height:38px" value="保存" >保存</button>
                    </div>
                </form>
                </div>
                </div>
            </section>
        </section>
    </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            $(function() {
                $prov = $('select[name="prov"]');
                $city = $('select[name="city"]');
                $country = $('select[name="country"]');
                $prov.parent().prev().text($prov.find("option:selected").text());
                $city.parent().prev().text($city.find("option:selected").text());
                $country.parent().prev().text($country.find("option:selected").text());
                $('.selectc').on('change',function() {
                //console.log($(this).find("option:selected").text());
                    var $this = $(this),
                        rel = $this.attr('rel'),
                        val = $this.val(),
                        lev = 3,
                        tips = '';
                    if (rel == 'city') {
                        tips = '--选择城市--';
                        lev = 1;
                    } else if (rel == 'country') {
                        tips = '--选择区县--';
                        lev = 2;
                    }
                    if (rel != '' && val > 0) {
                        $.ajax({
                            url: 'ajax.php?action=getArea&areaval=' + val + '&level=' + lev + '&tips=' + tips,
                            async: false,
                            type: 'post',
                            dataType: 'json',
                            success: function(result) {
                                if (result.status) {
                                    var $sel = $('select[name="' + rel + '"]');
                                    $('select[name="' + rel + '"] option').remove();
                                    //console.log($('select[name="' + rel + '"]').find("option:selected").text());
                                    text = '--选择省份--';
                                    if(rel=='city'){
                                        text = '--选择城市--';
                                    }
                                    if(rel=='country'){
                                        text = '--选择区县--';
                                    }
                                    $('select[name="' + rel + '"]').parent().prev().text(text);
                                    $sel.append(result.data);
                                } else {
                                    alert(result.msg);
                                }
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>