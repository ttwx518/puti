<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                完善资料
            </header>
            <section class="main p20">
                <?php if($success): ?>
                <div class="successMsg"><?php echo $success; ?></div>
                <?php endif; if($error): ?>
                <div class="errorMsg"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="index.php?c=improve" method="post">
                    <ul class="addressForm">
                        <li>
                            <input type="text" name="username" id="username" value="<?php echo isset($username) ? $username : ''; ?>" placeholder="用户名(手机号)" class="input" />
                        </li>
                        <li>
                            <input type="text" name="mobileCode" id="mobileCode" value="<?php echo isset($mobileCode) ? $mobileCode : ''; ?>" class="input" placeholder="短信验证码" style="width:55%" />
                            <input type="button" onclick="sendMobileCode('reg');" id="sendMobileCodeBtn" class="buttons_e submit mkConfirm" style="width:34%;font-size:12px;line-height:32px;margin-left:2%;cursor:pointer;border:none" value="获取验证码" />
                        </li>
                        <li>
                            <input type="text" name="truename" id="truename" value="<?php echo isset($truename) ? $truename : ''; ?>" placeholder="真实姓名" class="input" />
                        </li>
                        <li>
                            <input type="password" name="pwd" id="pwd" value="<?php echo  isset($pwd) ? $pwd : ''; ?>" placeholder="密码" class="input" />
                        </li>
                        <li>
                            <input type="password" name="repwd" id="repwd" value="<?php echo  isset($repwd) ? $repwd : ''; ?>" placeholder="重复密码" class="input" />
                        </li>
                        <li>
                            <input type="text" name="wechat_account" id="wechat_account" value="<?php echo  isset($wechat_account) ? $wechat_account : ''; ?>" placeholder="微信号" class="input" />
                        </li>
                        <li>
                            <input type="text" name="alipay_account" id="alipay_account" value="<?php echo  isset($alipay_account) ? $alipay_account : ''; ?>" placeholder="支付宝账号" class="input" />
                        </li>
                    </ul>
                    <div class="error"></div>
                    <div class="mt10 c">
                        <input type="submit" onclick="return member.checkImprove();" name="improveSub" class="buttons_a" style="width:100%;line-height:38px" value="提 交" />
                    </div>
                </form>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
    </body>
</html>