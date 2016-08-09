<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('goodsorder');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>编辑订单</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/checkf.func.js"></script>
        <script type="text/javascript" src="templates/js/getarea.js"></script>
    </head>
    <body>
        <?php
        $row = $dosql->GetOne("SELECT o.*,m.username FROM `#@__goodsorder` o LEFT JOIN `#@__member` m ON o.uid=m.id WHERE o.id=$id");
        ?>
        <div class="formHeader">
            <span class="title">编辑订单</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="goodsorder_save.php" onsubmit="return cfm_goodsorder();">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
                <tr>
                    <td height="40" align="right">订单号：</td>
                    <td>
                        <strong class="maroon2"><?php echo $row['ordernum']; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td width="25%" height="40" align="right">会员用户名：</td>
                    <td width="75%">
                        <?php echo $row['username']; ?>
                    </td>
                </tr>
                <tr>
                    <td height="120" align="right">商品列表：</td>
                    <td>
                        <div class="orderList">
                            <table width="99%" border="0" align="right" cellpadding="0" cellspacing="0">
                                <tr class="head">
                                    <td width="40" height="25">ID</td>
                                    <td>商品名称</td>
                                    <td width="80">单价</td>
                                    <td width="80">货主奖励佣金</td>
                                    <td width="80">平台奖励佣金</td>
                                    <td width="80">数量</td>
                                    <td width="80">小计</td>
                                    <td width="80">商品编号</td>
                                </tr>
                                <?php
                                $shoppingcart = array();
                                $totalAmount = 0;
                                $dosql->Execute("SELECT * FROM `#@__goodsorderitem` WHERE orderid=$id", $id);
                                while ($row2 = $dosql->GetArray($id)) {
                                    $shoppingcart[] = $row2;
                                }
                                //显示订单列表
                                foreach ($shoppingcart as $k => $v) {
                                    $totalAmount += $v['salesprice'] * $v['buyNum'];
                                ?>
                                <tr class="listItem nb">
                                    <td height="30"><?php echo $v['gid']; ?></td>
                                    <td><?php echo $v['title']; ?></td>
                                    <td><?php echo $v['salesprice']; ?></td>
                                    <td><?php echo $v['directCommission']; ?></td>
                                    <td><?php echo $v['indirectCommission']; ?></td>
                                    <td><?php echo $v['buyNum']; ?></td>
                                    <td><?php echo number_format($v['salesprice'] * $v['buyNum'], 2); ?></td>
                                    <td><?php echo $v['goodsid']; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">订单金额： </td>
                    <td>
                        <?php echo '￥'.number_format($row['goodsAmount'], 2); ?> (商品总额) +  
                        <?php echo '￥'.number_format($row['cost'], 2); ?> (运费) = 
                        <?php echo '￥'.number_format(($row['amount']), 2); ?>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">货主奖励佣金： </td>
                    <td>
                        <?php echo '￥'.number_format($row['directCommission'], 2); ?>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">平台奖励佣金： </td>
                    <td>
                        <?php echo '￥'.number_format($row['indirectCommission'], 2); ?>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">订单状态：</td>
                    <td class="blue">
                        <?php
                        $checkinfo = explode(',', $row['checkinfo']);
                        if (!in_array('applyreturn', $checkinfo) &&
                            !in_array('agreedreturn', $checkinfo) &&
                            !in_array('goodsback', $checkinfo) &&
                            !in_array('moneyback', $checkinfo) &&
                            !in_array('overorder', $checkinfo) &&
                            !in_array('cancel', $checkinfo)
                            ) {
                                if ($row['checkinfo'] == '' or !in_array('confirm', $checkinfo))
                                    echo '等待确认';
                                else if (!in_array('payment', $checkinfo))
                                    echo '等待付款';
                                else if (!in_array('postgoods', $checkinfo))
                                    echo '等待发货';
                                else if (!in_array('getgoods', $checkinfo))
                                    echo '等待收货';
                                else if (!in_array('overorder', $checkinfo))
                                    echo '等待归档';
                                else
                                    echo '参数错误，没有获取到订单状态';
                            }
                            else {
                                if (in_array('overorder', $checkinfo))
                                    echo '已归档';
                                else if (in_array('moneyback', $checkinfo))
                                    echo '等待归档';
                                else if (in_array('goodsback', $checkinfo))
                                    echo '等待退款';
                                else if (in_array('agreedreturn', $checkinfo))
                                    echo '等待返货';
                                else if (in_array('applyreturn', $checkinfo))
                                    echo '申请退货';
                                else if (in_array('cancel', $checkinfo))
                                    echo '已取消';
                                else
                                    echo '参数错误，没有获取到订单状态';
                            }
                        ?>
                    </td>
                </tr>
                <?php if($row['refundType']): ?>
                <tr>
                    <td height="40" align="right">退货/换货：</td>
                    <td>
                        类型 : <?php if($row['refundType'] == 1): echo '换货';elseif($row['refundType'] == 2): echo '退货'; endif; ?><br/>
                        理由 : <?php echo nl2br($row['refundReason']); ?><br/>
                        时间 : <?php echo GetDateTime($row['refundTime']); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <tr class="nb">
                    <td height="80" align="right">订单操作：</td>
                    <td style="line-height:22px;">
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="confirm" <?php if (in_array('confirm', $checkinfo)) echo 'checked="checked"'; ?> />确认订单&nbsp;</label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="payment" <?php if (in_array('payment', $checkinfo)) echo 'checked="checked"'; ?> />确认付款&nbsp;</label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="postgoods" <?php if (in_array('postgoods', $checkinfo)) echo 'checked="checked"'; ?> />商品发货&nbsp;</label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="getgoods" <?php if (in_array('getgoods', $checkinfo)) echo 'checked="checked"'; ?> />已收货 </label><br />
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="applyreturn" <?php if (in_array('applyreturn', $checkinfo)) echo 'checked="checked"'; ?> />申请退货&nbsp;</label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="agreedreturn" <?php if (in_array('agreedreturn', $checkinfo)) echo 'checked="checked"'; ?> />同意退货&nbsp;</label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="goodsback" <?php if (in_array('goodsback', $checkinfo)) echo 'checked="checked"'; ?> />收到返货&nbsp;</label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="moneyback" <?php if (in_array('moneyback', $checkinfo)) echo 'checked="checked"'; ?> />已退款 </label><br />
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="overorder" <?php if (in_array('overorder', $checkinfo)) echo 'checked="checked"'; ?> />已归档 </label>
                        <label><input name="checkinfo[]" type="checkbox" id="checkinfo[]" value="cancel" <?php if (in_array('cancel', $checkinfo)) echo 'checked="checked"'; ?> />已取消 </label>
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"></div></td>
                </tr>
                <tr>
                    <td height="40" align="right">收货人姓名： </td>
                    <td>
                        <input name="name" type="text" class="input" id="name" value="<?php echo $row['name']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">收货人手机号：</td>
                    <td>
                        <input name="mobile" type="text" class="input" id="mobile" value="<?php echo $row['mobile']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">收货地址：</td>
                    <td>
                        <select name="address_prov" id="address_prov" onchange="SelProv(this.value, 'address');">
                            <option value="-1">请选择</option>
                            <?php
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=0 ORDER BY orderid ASC, datavalue ASC");
                            while ($row2 = $dosql->GetArray()) {
                                if ($row['prov'] === $row2['datavalue'])
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
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=1 AND datavalue>" . $row['prov'] . " AND datavalue<" . ($row['prov'] + 500) . " ORDER BY orderid ASC, datavalue ASC");
                            while ($row2 = $dosql->GetArray()) {
                                if ($row['city'] === $row2['datavalue'])
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
                            $dosql->Execute("SELECT * FROM `#@__cascadedata` WHERE `datagroup`='area' AND level=2 AND datavalue LIKE '" . $row['city'] . ".%%%' ORDER BY orderid ASC, datavalue ASC");
                            while ($row2 = $dosql->GetArray()) {
                                if ($row['country'] === $row2['datavalue'])
                                    $selected = 'selected="selected"';
                                else
                                    $selected = '';

                                echo '<option value="' . $row2['datavalue'] . '" ' . $selected . '>' . $row2['dataname'] . '</option>';
                            }
                            ?>
                        </select>
                        <input name="address" type="text" class="input" id="address" value="<?php echo $row['address']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">收货人邮编：</td>
                    <td>
                        <input name="zipcode" type="text" class="input" id="zipcode" value="<?php echo $row['zipcode']; ?>" />
                    </td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"></div></td>
                </tr>
                <tr>
                    <td height="40" align="right">支付方式：</td>
                    <td>
                        <select name="paymode" id="paymode">
                            <option value="-1">请选择支付方式</option>
                            <?php GetTopType('#@__paymode', '#@__goodsorder', 'paymode'); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">配送方式：</td>
                    <td>
                        <select name="postmode" id="postmode">
                            <option value="-1">请选择配送方式</option>
                            <?php GetTopType('#@__postmode', '#@__goodsorder', 'postmode'); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">运单号：</td>
                    <td>
                        <input name="postid" type="text" class="input" id="postid" value="<?php echo $row['postid']; ?>" />
                    </td>
                </tr>
                <!--
                <tr>
                    <td height="40" align="right">货到方式：</td>
                    <td>
                        <select name="getmode" id="getmode">
                            <option value="-1">请选择货到方式</option>
                            <?php GetTopType('#@__getmode', '#@__goodsorder', 'getmode'); ?>
                        </select>
                    </td>
                </tr>
                -->
                <tr>
                    <td height="40" align="right">订单重量：</td>
                    <td>
                        <input name="weight" type="text" class="input" id="weight" value="<?php echo $row['weight']; ?>" /> g
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">商品运费：</td>
                    <td>
                        <input name="cost" type="text" class="input" id="cost" value="<?php echo $row['cost']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">订单金额：</td>
                    <td>
                        <input name="amount" type="text" id="amount" class="input" value="<?php echo $row['amount']; ?>" />
                    </td>
                </tr>
                <tr>
                    <td height="118" align="right">购物备注：</td>
                    <td><textarea name="buyremark" id="buyremark" class="textarea"><?php echo $row['buyremark']; ?></textarea></td>
                </tr>
                <tr>
                    <td height="118" align="right">发货方备注：</td>
                    <td><textarea name="sendremark" id="sendremark" class="textarea"><?php echo $row['sendremark']; ?></textarea></td>
                </tr>
                <tr>
                    <td height="40" align="right">订单时间：</td>
                    <td><?php echo GetDateTime($row['createtime']); ?></td>
                </tr>
                <tr class="nb">
                    <td height="40" align="right">加星标注：</td>
                    <td>
                        <label><input name="core" type="checkbox" id="core" value="true" <?php if ($row['core'] == 'true') echo 'checked="checked"'; ?> /> 标注</label>
                    </td>
                </tr>
            </table>
            <div class="formSubBtn">
                <input type="submit" class="submit" value="提交" />
                <input type="button" class="back" value="返回" onclick="history.go(-1);" />
                <input type="hidden" name="action" id="action" value="update" />
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
            </div>
        </form>
    </body>
</html>