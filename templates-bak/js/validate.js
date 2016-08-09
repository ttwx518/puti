var wait = 90;
//验证正则
var validateRegExp = {
    decmal: "^([+-]?)\\d*\\.\\d+$",
    // 浮点数
    decmal1: "^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*$",
    // 正浮点数
    decmal2: "^-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*)$",
    // 负浮点数
    decmal3: "^-?([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0)$",
    // 浮点数
    decmal4: "^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0$",
    // 非负浮点数（正浮点数 + 0）
    decmal5: "^(-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*))|0?.0+|0$",
    // 非正浮点数（负浮点数 +
    // 0）
    intege: "^-?[1-9]\\d*$",
    // 整数
    intege1: "^[1-9]\\d*$",
    // 正整数
    intege2: "^-[1-9]\\d*$",
    // 负整数
    num: "^([+-]?)\\d*\\.?\\d+$",
    // 数字
    num1: "^[1-9]\\d*|0$",
    // 正数（正整数 + 0）
    num2: "^-[1-9]\\d*|0$",
    // 负数（负整数 + 0）
    ascii: "^[\\x00-\\xFF]+$",
    // 仅ACSII字符
    chinese: "^[\\u4e00-\\u9fa5]+$",
    // 仅中文
    color: "^[a-fA-F0-9]{6}$",
    // 颜色
    date: "^\\d{4}(\\-|\\/|\.)\\d{1,2}\\1\\d{1,2}$",
    // 日期
    email: "^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$",
    // 邮件
    idcard: "^[1-9]([0-9]{14}|[0-9]{17})$",
    // 身份证
    ip4: "^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$",
    // ip地址
    letter: "^[A-Za-z]+$",
    // 字母
    letter_l: "^[a-z]+$",
    // 小写字母
    letter_u: "^[A-Z]+$",
    // 大写字母
    mobile: "^0?(13|15|18|14|17)[0-9]{9}$",
    // 手机
    notempty: "^\\S+$",
    // 非空
    password: "^.*[A-Za-z0-9\\w_-]+.*$",
    // 密码
    fullNumber: "^[0-9]+$",
    // 数字
    picture: "(.*)\\.(jpg|bmp|gif|ico|pcx|jpeg|tif|png|raw|tga)$",
    // 图片
    qq: "^[1-9]*[1-9][0-9]*$",
    // QQ号码
    rar: "(.*)\\.(rar|zip|7zip|tgz)$",
    // 压缩文件
    tel: "^[0-9\-()（）]{7,18}$",
    // 电话号码的函数(包括验证国内区号,国际区号,分机号)
    url: "^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&=]*)?$",
    // url
    username: "^[A-Za-z0-9_\\-\\u4e00-\\u9fa5]+$",
    // 户名
    deptname: "^[A-Za-z0-9_()（）\\-\\u4e00-\\u9fa5]+$",
    // 单位名
    zipcode: "^\\d{6}$",
    // 邮编
    realname: "^[A-Za-z\\u4e00-\\u9fa5]+$",
    // 真实姓名
    companyname: "^[A-Za-z0-9_()（）\\-\\u4e00-\\u9fa5]+$",
    companyaddr: "^[A-Za-z0-9_()（）\\#\\-\\u4e00-\\u9fa5]+$",
    companysite: "^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&#=]*)?$"
};

// 验证规则
var validateRules = {
    isNull: function(str) {
        return (str == "" || typeof str != "string");
    },
    isIntege: function(str){
        return new RegExp(validateRegExp.intege).test(str);
    },
    isNum1: function(str){
        return new RegExp(validateRegExp.num1).test(str);
    },
    betweenLength: function(str, _min, _max) {
        return (str.length >= _min && str.length <= _max);
    },
    isUid: function(str) {
        return new RegExp(validateRegExp.username).test(str);
    },
    fullNumberName: function(str) {
        return new RegExp(validateRegExp.fullNumber).test(str);
    },
    isPwd: function(str) {
        return /^.*([\W_a-zA-z0-9-])+.*$/i.test(str);
    },
    isPwdRepeat: function(str1, str2) {
        return (str1 == str2);
    },
    isEmail: function(str) {
        return new RegExp(validateRegExp.email).test(str);
    },
    isTel: function(str) {
        return new RegExp(validateRegExp.tel).test(str);
    },
    isMobile: function(str) {
        return new RegExp(validateRegExp.mobile).test(str);
    },
    checkType: function(element) {
        return (element.attr("type") == "checkbox" || element.attr("type") == "radio" || element.attr("rel") == "select");
    },
    isRealName: function(str) {
        return new RegExp(validateRegExp.realname).test(str);
    },
    isCompanyname: function(str) {
        return new RegExp(validateRegExp.companyname).test(str);
    },
    isCompanyaddr: function(str) {
        return new RegExp(validateRegExp.companyaddr).test(str);
    },
    isCompanysite: function(str) {
        return new RegExp(validateRegExp.companysite).test(str);
    },
    simplePwd: function(str) {
        return pwdLevel(str) == 1;
    },
    weakPwd: function(str) {
        for (var i = 0; i < weakPwdArray.length; i++) {
            if (weakPwdArray[i] == str) {
                return true;
            }
        }
        return false;
    }
};

var member = {
    /**
     * 验证收货地址
     * @returns {Boolean}
     */
    checkAddress: function(){
        var $name = $('#name'),
            name = $name.val();
        if(!name){
            $('.error').html('请填写收货人姓名');
            $name.focus();
            return false;
        }
        var $mobile = $('#mobile'),
            mobile = $mobile.val();
        if(!mobile){
            $('.error').html('请填写收货人手机号');
            $mobile.focus();
            return false;
        }
        if(!validateRules.isMobile(mobile)){
            $('.error').html('请填写正确的手机号');
            $mobile.focus();
            return false;
        }
        var $prov = $('#prov'),
            prov = $prov.val();
        if (prov == 0) {
            $('.error').html('请选择省份');
            $prov.focus();
            return false;
        }
        var $city = $('#city'),
            city = $city.val();
        if (city == 0) {
            $('.error').html('请选择城市');
            $city.focus();
            return false;
        }
        var $address = $('#address'),
            address = $address.val();
        if(!address){
            $('.error').html('请填写详细地址');
            $address.focus();
            return false;
        }
    },
    /**
     * 判断手机号码是否已注册
     * @param {string} mobile
     * @returns {status}
     */
    isReg: function(mobile) {
        var status;
        $.ajax({
            url: 'ajax.php?action=isReg&mobile=' + mobile,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                status = result;
            }
        });
        return status;
    },
    /*
     * 判断验证码
     * @param {string} type 验证码类型
     * @param {string} mobile 手机号码
     * @param {string} mobileCode 验证码
     * @returns {result}
     */
    mobileCodeChk: function(type,mobile,mobileCode) {
        var status;
        $.ajax({
            url: 'ajax.php?action=mobileCodeChk&type='+type+'&mobile='+mobile+'&mobileCode=' + mobileCode,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                status = result;
            }
        });
        return status;
    },
    /**
     * 完善资料验证
     * @returns {undefined}
     */
    checkImprove: function() {
        var $username = $('#username'),
            username = $username.val();
        if(!username){
            $('.error').html('请填写用户名(手机号)');
            $username.focus();
            return false;
        }
        if(!validateRules.isMobile(username)){
            $('.error').html('请填写正确的用户名(手机号)');
            $username.focus();
            return false;
        }
        var isExist = this.isReg(username);
        if (isExist == 2) {
            $('.error').html('请填写用户名(手机号)');
            $username.focus();
            return false;
        }
        if (isExist == 3) {
            $('.error').html('该用户名(手机号)已注册,换一个?');
            $username.focus();
            return false;
        }
        var $mobileCode = $('#mobileCode'),
            mobileCode = $mobileCode.val();
        if(!mobileCode){
            $('.error').html('请填写短信验证码');
            $mobileCode.focus();
            return false;
        }
        var mobileCodeChk = member.mobileCodeChk('reg',username,mobileCode);
        if (mobileCodeChk == 2) {
            $('.error').html('短信验证码错误');
            $mobileCode.focus();
            return false;
        }
        if (mobileCodeChk == 3) {
            $('.error').html('短信验证码超时');
            $mobileCode.focus();
            return false;
        }
        if (mobileCodeChk == 4) {
            $('.error').html('短信验证码错误');
            $mobileCode.focus();
            return false;
        }
        var $truename = $('#truename'),
            truename = $truename.val();
        if(!truename){
            $('.error').html('请填写真实姓名');
            $truename.focus();
            return false;
        }
        var $pwd = $('#pwd'),
            pwd = $pwd.val();
        if(!pwd){
            $('.error').html('请填写密码');
            $pwd.focus();
            return false;
        }
        if(!validateRules.betweenLength(pwd, 6, 20)){
            $('.error').html('请填写6~20位长度的密码');
            $pwd.focus();
            return false;
        }
        if(!validateRules.isPwd(pwd)){
            $('.error').html('密码只能由字母、数字、下划线组成');
            $pwd.focus();
            return false;
        }
        var $repwd = $('#repwd'),
            repwd = $repwd.val();
        if(!validateRules.isPwdRepeat(pwd, repwd)){
            $('.error').html('两次输入的密码不一致');
            $repwd.focus();
            return false;
        }
        var $wechat_account = $('#wechat_account'),
            wechat_account = $wechat_account.val();
        if(!wechat_account){
            $('.error').html('请填写微信号');
            $wechat_account.focus();
            return false;
        }
        var $alipay_account = $('#alipay_account'),
            alipay_account = $alipay_account.val();
        if(!alipay_account){
            $('.error').html('请填写支付宝账号');
            $alipay_account.focus();
            return false;
        }
    },
    /**
     * 修改资料验证
     * @returns {Boolean}
     */
    checkEdit: function(){
        var $truename = $('#truename'),
            truename = $truename.val();
        if(!truename){
            $('.error').html('请填写真实姓名');
            $truename.focus();
            return false;
        }
        var $email = $('#email'),
            email = $email.val();
        /*
        if(!email){
            $('.error').html('请填写电子邮箱');
            $email.focus();
            return false;
        }
        */
        if(email && !validateRules.isEmail(email)){
            $('.error').html('请填写正确的电子邮箱');
            $email.focus();
            return false;
        }
        /*
        var $qqnum = $('#qqnum'),
            qqnum = $qqnum.val();
        if(!qqnum){
            $('.error').html('请填写QQ号码');
            $qqnum.focus();
            return false;
        }
        var $address = $('#address'),
            address = $address.val();
        if(!address){
            $('.error').html('请填写联系地址');
            $address.focus();
            return false;
        }
        */
        var $wechat_account = $('#wechat_account'),
            wechat_account = $wechat_account.val();
        if(!wechat_account){
            $('.error').html('请填写微信号');
            $wechat_account.focus();
            return false;
        }
        var $alipay_account = $('#alipay_account'),
            alipay_account = $alipay_account.val();
        if(!alipay_account){
            $('.error').html('请填写支付宝账号');
            $alipay_account.focus();
            return false;
        }
    },
    /**
     * 取消订单
     * @param {int} id 订单id
     * @returns {undefined}
     */
    cancelOrder: function(id){
        if(!id)
            return;
        if(confirm('确认要取消该订单吗？')){
            $.ajax({
                url: 'ajax.php?action=cancelOrder&id='+id,
                async: false,
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    alert(result.msg);
                    if (result.status) {
                        location.reload();
                    }
                }
            });
        }
    },
    /**
     * 订单收货
     * @param {int} id 订单id
     * @returns {undefined}
     */
    getGoods: function(id){
        if(!id)
            return;
        if(confirm('确认要收货吗？')){
            $.ajax({
                url: 'ajax.php?action=getGoods&id='+id,
                async: false,
                type: 'post',
                dataType: 'json',
                success: function(result) {
                    alert(result.msg);
                    if (result.status) {
                        location.reload();
                    }
                }
            });
        }
    },
    /**
     * 
     * @returns {undefined}
     */
    checkTx: function(){
        var $alipayAccount = $('#alipayAccount'),
            alipayAccount = $alipayAccount.val();
        if(!alipayAccount){
            $('.error').html('请填写支付宝账号');
            $alipayAccount.focus();
            return false;
        }
        var $truename = $('#truename'),
            truename = $truename.val();
        if(!truename){
            $('.error').html('请填写真实姓名');
            $truename.focus();
            return false;
        }
        var $amount = $('#amount'),
            amount = $amount.val(),
            maxAmount = parseInt($amount.attr('maxAmount'));
        if(!amount){
            $('.error').html('请填写提现金额');
            $amount.focus();
            return false;
        }
        if(!validateRules.isIntege(amount)){
            $('.error').html('提现金额必须为1的整数倍');
            $amount.focus();
            return false;
        }
        if(amount < 200){
            $('.error').html('提现金额最少为200元');
            $amount.focus();
            return false;
        }
        if(amount > maxAmount){
            $('.error').html('提现金额必须小于可提现金额');
            $amount.focus();
            return false;
        }
    }
};

/**
 * 发送注册短信验证码
 * @param {string} type 短信类型
 * @returns {undefined}
 */
function sendMobileCode(type) {
    var $btn = $('#sendMobileCodeBtn');
    if ($btn.attr("disabled")) {
        return;
    }
    var $username = $("#username"),
        username = $username.val();
    if(!validateRules.isMobile(username)){
        $('.error').html('请填写正确的用户名(手机号)');
        $username.focus();
        return;
    }
    var isExist = member.isReg(username);
    if (isExist == 2) {
        $('.error').html('请填写用户名(手机号)');
        $username.focus();
        return;
    }
    if (isExist == 3) {
        $('.error').html('该用户名(手机号)已注册,换一个?');
        $username.focus();
        return;
    }
    //发送验证码
    $.ajax({
        url: 'ajax.php?action=sendMobileCode&type=' + type + '&mobile=' + username,
        async: false,
        type: 'post',
        dataType: 'json',
        success: function(result) {
            if (result.status) {
                time($btn);
            }else{
                alert(result.msg);
            }
        }
    });
}

/**
 * 验证码倒计时
 * @param {type} o
 * @returns {undefined}
 */
function time(o) {
    if (wait == 0) {
        o.removeAttr("disabled").val('获取验证码');
        wait = 90;
    } else {
        o.attr("disabled", true).val('重新发送(' + wait + ')');
        wait--;
        setTimeout(function() {
            time(o);
        },1000);
    }
}