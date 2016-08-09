<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('integralrule');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>积分规则管理</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/forms.func.js"></script>
    </head>
    <body>
        <div class="topToolbar">
            <span class="title">积分规则管理</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="integralrule_save.php?action=save">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <tr align="left" class="head">
                    <td width="5%" height="36" class="firstCol">
                        <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                    </td>
                    <td width="5%">ID</td>
                    <td width="15%">积分缘由</td>
                    <td width="10%">调用标识</td>
                    <td width="10%">积分值</td>
                    <td width="10%">每日次数限制</td>
                    <td width="20%" align="center">排序</td>
                    <td width="25%" class="endCol">操作</td>
                </tr>
                <?php
                $dosql->Execute("SELECT * FROM `#@__integralrule` ORDER BY `orderid` ASC");
                if ($dosql->GetTotalRow() > 0) {
                    while ($row = $dosql->GetArray()) {
                        switch ($row['checkinfo']) {
                            case 'true':
                                $checkinfo = '开启';
                                break;
                            case 'false':
                                $checkinfo = '关闭';
                                break;
                            default:
                                $checkinfo = '没有获取到参数';
                        }
                ?>
                <tr align="left" class="dataTr">
                    <td height="36" class="firstCol">
                        <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $row['id']; ?>" />
                    </td>
                    <td>
                        <?php echo $row['id']; ?>
                        <input type="hidden" name="id[]" id="id[]" value="<?php echo $row['id']; ?>" />
                    </td>
                    <td align="left"><input type="text" name="classname[]" id="classname[]" class="inputd" value="<?php echo $row['classname']; ?>" /></td>
                    <td align="left"><input type="text" name="identify[]" id="identify[]" class="inputd" value="<?php echo $row['identify']; ?>" readonly /></td>
                    <td align="left"><input type="text" name="integral[]" id="integral[]" class="inputd" style="width:150px" value="<?php echo $row['integral']; ?>" /></td>
                    <td align="left"><input type="text" name="limits[]" id="limits[]" class="inputd" style="width:150px" value="<?php echo $row['limits']; ?>" /></td>
                    <td align="center">
                        <a href="integralrule_save.php?action=up&id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>" class="leftArrow" title="提升排序"></a>
                        <input type="text" name="orderid[]" id="orderid[]" class="inputls" value="<?php echo $row['orderid']; ?>" />
                        <a href="integralrule_save.php?action=down&id=<?php echo $row['id']; ?>&orderid=<?php echo $row['orderid']; ?>" class="rightArrow" title="下降排序"></a>
                    </td>
                    <td class="action endCol">
                        <span><a href="integralrule_save.php?action=check&id=<?php echo $row['id']; ?>&checkinfo=<?php echo $row['checkinfo']; ?>"><?php echo $checkinfo; ?></a></span> | 
                        <span class="nb"><a href="integralrule_save.php?action=del2&id=<?php echo $row['id'] ?>" onclick="return ConfDel(0);">删除</a></span>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    ?>
                    <tr align="center">
                        <td colspan="7" class="dataEmpty">暂时没有相关的记录</td>
                    </tr>
                    <?php
                }
                ?>
                <tr align="center">
                    <td height="36" colspan="7"><strong>新增一个规则</strong></td>
                </tr>
                <tr align="left" class="dataTrOn">
                    <td height="36">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><input type="text" name="classnameadd" id="classnameadd" class="input" /></td>
                    <td><input type="text" name="identifyadd" id="identifyadd" class="input" /></td>
                    <td><input type="text" name="integraladd" id="integraladd" class="inputos" style="width:150px" /></td>
                    <td><input type="text" name="limitsadd" id="limitsadd" class="inputos" style="width:150px" /></td>
                    <td align="center"><input type="text" name="orderidadd" id="orderidadd" class="inputls" value="<?php echo GetOrderID('#@__integralrule'); ?>" /></td>
                    <td class="endCol">
                        <label><input type="radio" name="checkinfoadd" value="true" checked="checked"  /> 开启&nbsp;</label>
                        <label><input type="radio" name="checkinfoadd" value="false" /> 关闭</label>
                    </td>
                </tr>
            </table>
        </form>
        <div class="bottomToolbar">
            <span class="selArea">
                <span>选择：</span>
                <a href="javascript:CheckAll(true);">全部</a> - 
                <a href="javascript:CheckAll(false);">无</a> - 
                <a href="javascript:DelAllNone('integralrule_save.php');" onclick="return ConfDelAll(0);">删除</a>
                <span>操作：</span>
                <a href="javascript:UpOrderID('integralrule_save.php');">更新排序</a>
            </span>
            <a href="#" onclick="form.submit();" class="dataBtn">更新全部</a>
        </div>
        <ul class="tipsList">
            <li>超过每日次数限制,则不再产生记录</li>
            <li>删除积分规则或更改调用标识会造成系统不能自动记录用户积分</li>
        </ul>
        <div class="page">
            <div class="pageText">共有<span><?php echo $dosql->GetTableRow('#@__integralrule'); ?></span>条记录</div>
        </div>
        <?php
        //判断是否启用快捷工具栏
        if ($cfg_quicktool == 'Y') {
        ?>
        <div class="quickToolbar">
            <div class="qiuckWarp">
                <div class="quickArea">
                    <span class="selArea">
                        <span>选择：</span>
                        <a href="javascript:CheckAll(true);">全部</a> - 
                        <a href="javascript:CheckAll(false);">无</a> - 
                        <a href="javascript:DelAllNone('integralrule_save.php');" onclick="return ConfDelAll(0);">删除</a>
                        <span>操作：</span>
                        <a href="javascript:UpOrderID('integralrule_save.php');">更新排序</a>
                    </span>
                    <a href="#" onclick="form.submit();" class="dataBtn">更新全部</a>
                    <span class="pageSmall">
                        <div class="pageText">共有<span><?php echo $dosql->GetTableRow('#@__integralrule'); ?></span>条记录</div>
                    </span>
                </div>
                <div class="quickAreaBg"></div>
            </div>
        </div>
        <?php
        }
        ?>
    </body>
</html>