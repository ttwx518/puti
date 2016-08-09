<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                地址管理
            </header>
            <section class="main p20">
                <?php if($success): ?>
                <div class="successMsg"><?php echo $success; ?></div>
                <?php endif; if($error): ?>
                <div class="errorMsg"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="index.php?c=member&a=editAddress" method="post">
                    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                    <ul class="addressForm">
                        <li><input type="text" class="input" placeholder="收货人姓名" name="name" id="name" value="<?php cecho($address, 'name'); ?>" /></li>
                        <li><input type="text" class="input" placeholder="收货人手机号" name="mobile" id='mobile' value="<?php cecho($address, 'mobile'); ?>" /></li>
                        <li>
                            <select class="select" name="prov" id="prov" rel="city">
                                <option value="0">--选择省份--</option>
                                <?php foreach ($provs as $v): ?>
                                <option value="<?php echo $v['datavalue']; ?>" <?php echo isset($address['prov']) && $v['datavalue'] == $address['prov'] ? 'selected="selected"' : '' ?>><?php echo $v['dataname']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </li>
                        <li>
                            <select class="select" name="city" id="city" rel="country">
                                <option value="0">--选择市--</option>
                                <?php if(!empty($cities)): foreach($cities as $c): ?>
                                <option value="<?php echo $c['datavalue']; ?>" <?php echo isset($address['city']) && $c['datavalue'] == $address['city'] ? 'selected="selected"' : ''; ?>><?php echo $c['dataname']; ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </li>
                        <li>
                            <select class="select" name="country" id="country" rel="">
                                <option value="0">--选择区--</option>
                                <?php if(!empty($countries)): foreach($countries as $c): ?>
                                <option value="<?php echo $c['datavalue']; ?>" <?php echo isset($address['country']) && $c['datavalue'] == $address['country'] ? 'selected="selected"' : ''; ?>><?php echo $c['dataname']; ?></option>
                                <?php endforeach;endif; ?>
                            </select>
                        </li>
                        <li><input type="text" class="input" placeholder="详细地址" name="address" id="address" value="<?php cecho($address, 'address'); ?>" /></li>
                        <li><input type="text" class="input" placeholder="邮编" name="zipcode" id="zipcode" value="<?php cecho($address, 'zipcode'); ?>" /></li>
                        <li><label><input type="checkbox" name="isDefault" value="1"<?php if(isset($address['isDefault']) && $address['isDefault'] == 1): echo ' checked="checked"'; endif; ?> /> 设为默认收货地址</label></li>
                    </ul>
                    <div class="error"></div>
                    <div class="mt10 c">
                        <input type="hidden" name="id" value="<?php echo isset($address['id']) ? $address['id'] : 0; ?>" />
                        <input type="submit" onclick="return member.checkAddress();" name="addressSub" class="buttons_a" style="width:100%;line-height:38px" value="保存" />
                    </div>
                </form>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            $(function() {
                $('.select').on('change',function() {
                    var $this = $(this),
                        rel = $this.attr('rel'),
                        val = $this.val(),
                        lev = 3,
                        tips = '';
                    if (rel == 'city') {
                        tips = '--选择市--';
                        lev = 1;
                    } else if (rel == 'country') {
                        tips = '--选择区--';
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