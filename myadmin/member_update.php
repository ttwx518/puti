<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('member');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>修改会员</title>
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
                    if (document.form.username.value.length < 4) {
                        document.getElementById('usernote').innerHTML = '<span class="regnotenok">用户名小于4位</span>';
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
        <?php
        $row = $dosql->GetOne("SELECT m.*,g.groupname FROM `#@__member` m LEFT JOIN `#@__usergroup` g ON m.group_id=g.id WHERE m.id={$id}");
        ?>
        <div class="formHeader">
            <span class="title">修改会员</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="member_save.php" onsubmit="return cfm_upmember();">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
                <tr>
                    <td width="25%" height="40" align="right">用户组：</td>
                    <td width="75%">
                        <strong><?php echo $row['groupname']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">用户名(手机号)：</td>
                    <td><strong><?php echo $row['username']; ?></strong></td>
                </tr>
                <tr>
                    <td height="40" align="right">货主：</td>
                    <td>
                        <select name="recUid" id="recUid">
                            <option value="0"<?php if(!$row['recUid']): echo " selected"; endif; ?>>无</option>
                            <option value="-1"<?php if($row['recUid'] == -1): echo " selected"; endif; ?>>官方商城</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__member` WHERE id<>{$row['id']}");
                            while ($row2 = $dosql->GetArray()) {
                                $selected = $row['recUid'] == $row2['id'] ? ' selected' : '';
                                echo '<option value="' . $row2['id'] . '"'.$selected.'>' . $row2['username'] . '</option>';
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
                        <input name="password" type="password" id="password" class="input" value="" />
                        <span class="maroon">*</span><span class="cnote">若不修改密码请留空</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">确　认： </td>
                    <td>
                        <input name="repassword" type="password" id="repassword" class="input" value="" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"></div></td>
                </tr>
                <tr>
                    <td height="40" align="right">真实姓名：</td>
                    <td><input type="text" name="truename" id="truename" class="input" value="<?php echo $row['truename']; ?>" /></td>
                </tr>
                <tr>
                    <td height="165" align="right">头　像：</td>
                    <td>
                        <img src="<?php echo $row['wechat_headimgurl']; ?>" width="50" height="50" />
                        <span class="maroon">&nbsp;</span><span class="cnote">用户头像在前台编辑</span>
                        <!--
                        <img src="../data/avatar/index.php?uid=<?php echo $row['id']; ?>&size=middle&rnd=<?php echo GetRandStr(); ?>" />
                        <div class="hr_10"></div>
                        <input name="delavatar" type="checkbox" value="1" />
                        删除头像 (会员头像在前台编辑)
                        -->
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">支付宝账号：</td>
                    <td><input type="text" name="alipay_account" id="alipay_account" class="input" value="<?php echo $row['alipay_account']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">手　机：</td>
                    <td><input type="text" name="mobile" id="mobile" class="input" value="<?php echo $row['mobile']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">E-mail：</td>
                    <td><input type="text" name="email" id="email" class="input" value="<?php echo $row['email']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">QQ号码：</td>
                    <td><input type="text" name="qqnum" id="qqnum" class="input" value="<?php echo $row['qqnum']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">通信地址：</td>
                    <td>
                        <select name="address_prov" id="address_prov" onchange="SelProv(this.value, 'address');">
                            <option value="-1">请选择</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
                            while ($row2 = $dosql->GetArray()) {
                                if ($row['address_prov'] === $row2['datavalue'])
                                    $selected = 'selected="selected"';
                                else
                                    $selected = '';

                                echo '<option value="' . $row2['datavalue'] . '" ' . $selected . '>' . $row2['dataname'] . '</option>';
                            }
                            ?>
                        </select>
                        <select name="address_city" id="address_city" onchange="SelCity(this.value, 'address');">
                            <option value="-1">--</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>" . $row['address_prov'] . " AND datavalue<" . ($row['address_prov'] + 500) . " ORDER BY orderid ASC, datavalue ASC");
                            while ($row2 = $dosql->GetArray()) {
                                if ($row['address_city'] === $row2['datavalue'])
                                    $selected = 'selected="selected"';
                                else
                                    $selected = '';

                                echo '<option value="' . $row2['datavalue'] . '" ' . $selected . '>' . $row2['dataname'] . '</option>';
                            }
                            ?>
                        </select>
                        <select name="address_country" id="address_country">
                            <option value="-1">--</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=2 AND datavalue LIKE '" . $row['address_city'] . ".%%%' ORDER BY orderid ASC, datavalue ASC");
                            while ($row2 = $dosql->GetArray()) {
                                if ($row['address_country'] === $row2['datavalue'])
                                    $selected = 'selected="selected"';
                                else
                                    $selected = '';

                                echo '<option value="' . $row2['datavalue'] . '" ' . $selected . '>' . $row2['dataname'] . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">&nbsp;</td>
                    <td><input type="text" name="address" id="address" class="input" value="<?php echo $row['address']; ?>" /></td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"></div></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信号：</td>
                    <td><input type="text" name="wechat_account" id="wechat_account" class="input" value="<?php echo $row['wechat_account']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信昵称：</td>
                    <td><input type="text" name="wechat_nickname" id="wechat_nickname" class="input" value="<?php echo $row['wechat_nickname']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信性别：</td>
                    <td>
                        <label><input name="wechat_sex" type="radio" value="0" <?php if ($row['wechat_sex'] == '0') echo 'checked="checked"'; ?> /> 未知&nbsp;</label>
                        <label><input name="wechat_sex" type="radio" value="1" <?php if ($row['wechat_sex'] == '1') echo 'checked="checked"'; ?> /> 男&nbsp;</label>
                        <label><input name="wechat_sex" type="radio" value="2" <?php if ($row['wechat_sex'] == '2') echo 'checked="checked"'; ?> /> 女</label>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">微信国家：</td>
                    <td><input type="text" name="wechat_country" id="wechat_country" class="input" value="<?php echo $row['wechat_country']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信省份：</td>
                    <td><input type="text" name="wechat_province" id="wechat_province" class="input" value="<?php echo $row['wechat_province']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">微信城市：</td>
                    <td><input type="text" name="wechat_city" id="wechat_city" class="input" value="<?php echo $row['wechat_city']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">登录信息：</td>
                    <td>TIME <?php echo GetDateTime($row['logintime']); ?>&nbsp;-&nbsp;IP <?php echo $row['loginip']; ?></td>
                </tr>
                <tr class="nb">
                    <td height="40" align="right">注册信息：</td>
                    <td>TIME <?php echo GetDateTime($row['regtime']); ?>&nbsp;-&nbsp;IP <?php echo $row['regip']; ?></td>
                </tr>
            </table>
            <div class="formSubBtn">
                <input type="submit" class="submit" value="提交" />
                <input type="button" class="back" value="返回" onclick="history.go(-1);" />
                <input type="hidden" name="action" id="action" value="update" />
                <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />
            </div>
        </form>
        <script>
            $(document).ready(function(){
                $('#searchBtn').on('click',function(){
                    var $searchName = $('#searchName'),
                        searchName = $searchName.val(),
                        id = $('#id').val();
                    $.ajax({
                        url: 'ajax.php?action=getRecUid&id='+ id +'&searchName=' + searchName,
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