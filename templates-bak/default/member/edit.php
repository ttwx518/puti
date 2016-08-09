<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                修改资料
            </header>
            <section class="main p20">
                <?php if($success): ?>
                <div class="successMsg"><?php echo $success; ?></div>
                <?php endif; if($error): ?>
                <div class="errorMsg"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="index.php?c=member&a=edit" method="post">
                    <ul class="addressForm">
                        <li>
                            <input type="text" name="truename" id="truename" value="<?php echo isset($truename) ? $truename : $userInfo['truename']; ?>" placeholder="真实姓名" class="input" />
                        </li>
                        <li>
                            <input type="text" name="mobile" id="mobile" value="<?php echo  isset($mobile) ? $mobile : $userInfo['mobile']; ?>" placeholder="手机号" class="input" readonly="readonly" />
                        </li>
                        <li>
                            <input type="text" name="email" id="email" value="<?php echo  isset($email) ? $email : $userInfo['email']; ?>" placeholder="电子邮箱" class="input" />
                        </li>
                        <li>
                            <input type="text" name="qqnum" id="qqnum" value="<?php echo  isset($qqnum) ? $qqnum : $userInfo['qqnum']; ?>" placeholder="QQ" class="input" />
                        </li>
                        <li>
                            <input type="text" name="address" id="address" value="<?php echo  isset($address) ? $address : $userInfo['address']; ?>" placeholder="联系地址" class="input" />
                        </li>
                        <li>
                            <input type="text" name="wechat_account" id="wechat_account" value="<?php echo  isset($wechat_account) ? $wechat_account : $userInfo['wechat_account']; ?>" placeholder="微信号" class="input" />
                        </li>
                        <li>
                            <input type="text" name="alipay_account" id="alipay_account" value="<?php echo  isset($alipay_account) ? $alipay_account : $userInfo['alipay_account']; ?>" placeholder="支付宝账号" class="input" />
                        </li>
                    </ul>
                    <div class="error"></div>
                    <div class="mt10 c">
                        <input type="submit" onclick="return member.checkEdit();" name="editSub" class="buttons_a" style="width:100%;line-height:38px" value="确认修改" />
                    </div>
                </form>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>