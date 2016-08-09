<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('member');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>会员注册</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/checkf.func.js"></script>
        <script type="text/javascript" src="templates/js/getarea.js"></script>
        <script type="text/javascript">
            var xmlHttp;
            function xmlhttprequest() {
                if (window.ActiveXObject) {
                    xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
                }
                else if (window.XMLHttpRequest) {
                    xmlHttp = new XMLHttpRequest();
                }
                else {
                    alert('您的浏览器不支持Ajax技术！');
                }
            }
            //用户名检测
            function CheckUser() {
                if (document.form.username.value == '') {
                    document.getElementById('usernote').innerHTML = '　';
                }
                else {
                    if (document.form.username.value.length != 11) {
                        document.getElementById('usernote').innerHTML = '<span class="regnotenok">用户名为手机号</span>';
                        return;
                    }
                    xmlhttprequest();
                    var username = document.getElementById('username').value;
                    var url = "ajax_do.php?" + parseInt(Math.random() * (15271) + 1) + '&action=checkuser&username=' + username;
                    xmlHttp.open("GET", url, true);
                    xmlHttp.onreadystatechange = check_done;
                    xmlHttp.send(null);
                }
            }
            function check_done() {
                if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                    document.getElementById('usernote').innerHTML = xmlHttp.responseText;
                    if ('<span class="regnotenok">用户名已存在</span>' == xmlHttp.responseText) {
                        document.getElementById('isuser').value = '0';
                    }
                    else {
                        document.getElementById('isuser').value = '';
                    }
                }
            }
        </script>
    </head>
    <body>
        <div class="formHeader">
            <span class="title">注册会员</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_member();">
            <input type="hidden" name="group_id" id="group_id" value="1" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
                <tr>
                    <td width="25%" height="40" align="right">用户名(手机号)：</td>
                    <td width="75%">
                        <input type="text" name="username" id="username" class="input" onblur="CheckUser();" />
                        <span class="maroon">*</span>
                        <span id="usernote"></span>
                        <input type="hidden" id="isuser" name="isuser" value="" />
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">货主：</td>
                    <td>
                        <select name="recUid" id="recUid">
                            <option value="0">无</option>
                            <option value="-1">官方商城</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__member`");
                            while ($row = $dosql->GetArray()) {
                                echo '<option value="' . $row['id'] . '">' . $row['username'] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="text" name="searchName" id="searchName" value="" class="inputos" placeholder="输入用户名进行搜索" />
                        <input type="button" name="searchBtn" id="searchBtn" value="搜索" style="width:80px;height:26px;cursor:pointer" />
                        <span class="maroon">*</span>
                        <span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">密　码：</td>
                    <td>
                        <input name="password" type="password" id="password" class="input" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">确　认： </td>
                    <td>
                        <input name="repassword" type="password" id="repassword" class="input" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"></div></td>
                </tr>
                <tr>
                    <td height="40" align="right">真实姓名：</td>
                    <td>
                        <input type="text" name="truename" id="truename" class="input" />
                        <span class="maroon">*</span>
                        <span class="cnote">用户头像在前台编辑</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">微信号：</td>
                    <td>
                        <input type="text" name="wechat_account" id="wechat_account" class="input" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">支付宝账号：</td>
                    <td>
                        <input type="text" name="alipay_account" id="alipay_account" class="input" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">手　机：</td>
                    <td>
                        <input type="text" name="mobile" id="mobile" class="input" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">E-mail：</td>
                    <td><input type="text" name="email" id="email" class="input" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">QQ号码：</td>
                    <td><input type="text" name="qqnum" id="qqnum" class="input" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">通信地址：</td>
                    <td>
                        <select name="address_prov" id="address_prov" onchange="SelProv(this.value, 'address');">
                            <option value="-1">请选择</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
                            while ($row = $dosql->GetArray()) {
                                echo '<option value="' . $row['datavalue'] . '">' . $row['dataname'] . '</option>';
                            }
                            ?>
                        </select>
                        <select name="address_city" id="address_city" onchange="SelCity(this.value, 'address');">
                            <option value="-1">--</option>
                        </select>
                        <select name="address_country" id="address_country">
                            <option value="-1">--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">&nbsp;</td>
                    <td><input type="text" name="address" id="address" class="input" /></td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"></div></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信昵称：</td>
                    <td><input type="text" name="wechat_nickname" id="wechat_nickname" class="input" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信性别：</td>
                    <td>
                        <label><input name="wechat_sex" type="radio" value="0" checked="checked" /> 未知&nbsp;</label>
                        <label><input name="wechat_sex" type="radio" value="1" /> 男&nbsp;</label>
                        <label><input name="wechat_sex" type="radio" value="2" /> 女</label>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">微信国家：</td>
                    <td><input type="text" name="wechat_country" id="wechat_country" class="input" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信省份：</td>
                    <td><input type="text" name="wechat_province" id="wechat_province" class="input" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信城市：</td>
                    <td><input type="text" name="wechat_city" id="wechat_city" class="input" /></td>
                </tr>
                <tr class="nb">
                    <td height="40" align="right">注册时间：</td>
                    <td>
                        <input type="text" name="regtime" id="regtime" class="inputms" value="<?php echo GetDateTime(time()); ?>" readonly="readonly" />
                        <script type="text/javascript" src="plugin/calendar/calendar.js"></script> 
                        <script type="text/javascript">
                            Calendar.setup({
                                inputField: "regtime",
                                ifFormat: "%Y-%m-%d %H:%M:%S",
                                showsTime: true,
                                timeFormat: "24"
                            });
                        </script>
                    </td>
                </tr>
            </table>
            <div class="formSubBtn">
                <input type="submit" class="submit" value="提交" />
                <input type="button" class="back" value="返回" onclick="history.go(-1);" />
                <input type="hidden" name="action" id="action" value="add" />
            </div>
        </form>
        <script>
            $(document).ready(function(){
                $('#searchBtn').on('click',function(){
                    var $searchName = $('#searchName'),
                        searchName = $searchName.val();
                    $.ajax({
                        url: 'ajax.php?action=getRecUid&id=0&searchName=' + searchName,
                        async: false,
                        type: 'post',
                        dataType: 'json',
                        success: function(result) {
                            if (result.status) {
                                $('#recUid').html(result.msg);
                            } else {
                                alert(result.msg);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>