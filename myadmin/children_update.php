<?php
require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('children');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>修改列表信息</title>
        <link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="templates/js/getuploadify.js"></script>
        <script type="text/javascript" src="templates/js/checkf.func.js"></script>
        <script type="text/javascript" src="templates/js/getjcrop.js"></script>
        <script type="text/javascript" src="templates/js/getinfosrc.js"></script>
        <script type="text/javascript" src="plugin/colorpicker/colorpicker.js"></script>
        <script type="text/javascript" src="plugin/calendar/calendar.js"></script>
        <script type="text/javascript" src="editor/kindeditor-min.js"></script>
        <script type="text/javascript" src="editor/lang/zh_CN.js"></script>
        <script type="text/javascript" src="templates/js/getarea.js"></script>
    </head>
    <body>
        <?php
        $row = $dosql->GetOne("SELECT * FROM `#@__children` WHERE `id`=$id");
        ?>
        <div class="formHeader">
            <span class="title">修改列表信息</span>
            <a href="javascript:location.reload();" class="reload">刷新</a>
        </div>
        <form name="form" id="form" method="post" action="children_save.php" onsubmit="return cfm_infolm();">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formTable">
                <tr>
                    <td width="25%" height="40" align="right">栏　目：</td>
                    <td width="75%">
                        <select name="classid" id="classid">
                            <option value="-1">请选择所属栏目</option>
                            <?php CategoryType(5); ?>
                        </select>
                        <span class="maroon">*</span>
                        <span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
                    </td>
                </tr>
                <?php
                if ($cfg_maintype == 'Y') {
                ?>
                <tr>
                    <td height="40" align="right">类　别：</td>
                    <td>
                        <select name="mainid" id="mainid">
                            <option value="-1">请选择所属类别</option>
                            <?php GetAllType('#@__maintype', '#@__children', 'mainid'); ?>
                        </select>
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <?php
                }
                ?>
                <tr>
                    <td height="40" align="right">儿童姓名：</td>
                    <td>
                        <input type="text" name="title" id="title" class="input" value="<?php echo $row['title']; ?>" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">爱心屋名称：</td>
                    <td>
                        <input type="text" name="title2" id="title2" class="input" value="<?php echo $row['title2']; ?>" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">年龄：</td>
                    <td>
                        <input type="text" name="age" id="age" value="<?php echo $row['age']; ?>"  class="input" />
                        <span class="maroon">*</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">性别：</td>
                    <td>
                        <label><input name="sex" type="radio" value="1" <?php if ($row['sex'] == '1') echo 'checked="checked"'; ?> /> 男&nbsp;</label>
                        <label><input name="sex" type="radio" value="0" <?php if ($row['sex'] == '0') echo 'checked="checked"'; ?> /> 女</label>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">地址：</td>
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
                <tr class="nb" style="display: none">
                    <td height="40" align="right">属　性：</td>
                    <td class="attrArea">
                        <?php
                        $flagarr = explode(',', $row['flag']);
                        $dosql->Execute("SELECT * FROM `#@__infoflag` ORDER BY orderid ASC");
                        while ($r = $dosql->GetArray()) {
                            echo '<span><label><input type="checkbox" name="flag[]" id="flag[]" value="' . $r['flag'] . '"';
                            if (in_array($r['flag'], $flagarr)) {
                                echo 'checked="checked"';
                            }
                            echo ' />' . $r['flagname'] . '[' . $r['flag'] . ']</label></span>';
                        }
                        ?>
                    </td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="0" id="df">
                        <?php echo GetDiyField('1', $row['classid'], $row); ?>
                    </td>
                </tr>
                <tr  style="display: none">
                    <td height="40" align="right">文章来源：</td>
                    <td>
                        <input type="text" name="source" id="source" class="input" value="<?php echo $row['source']; ?>" />
                        <span class="srcArea">
                            <span class="infosrc">选择
                                <ul>
                                    <?php
                                    $dosql->Execute("SELECT * FROM `#@__infosrc` ORDER BY `orderid` ASC");
                                    if ($dosql->GetTotalRow() > 0) {
                                        while ($row2 = $dosql->GetArray()) {
                                            ?>
                                            <li><a href="javascript:;" title="<?php echo $row2['linkurl']; ?>" onclick="GetSrcName('<?php echo $row2['srcname']; ?>');"><?php echo $row2['srcname']; ?></a></li>
                                            <?php
                                        }
                                    } else {
                                        echo '<li>暂无来源 <a href="infosrc.php">[添加]</a></li>';
                                    }
                                    ?>
                                </ul>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">作者编辑：</td>
                    <td><input type="text" name="author" id="author" class="input" value="<?php echo $row['author']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">缩略图片：</td>
                    <td>
                        <input type="text" name="picurl" id="picurl" class="input" value="<?php echo $row['picurl']; ?>" />
                        <span class="cnote">
                            <span class="grayBtn" onclick="GetUploadify('uploadify', '缩略图上传', 'image', 'image', 1,<?php echo $cfg_max_file_size; ?>, 'picurl')">上 传</span>
                            <span class="rePicTxt">
                                <label><input type="checkbox" name="rempic" id="rempic" value="true" /> 远程</label>
                            </span>
                            <span class="cutPicTxt">
                                <a href="javascript:;" onclick="GetJcrop('jcrop', 'picurl');return false;">裁剪</a>
                            </span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td height="104" align="right">语　录：</td>
                    <td>
                        <textarea name="slogan" id="slogan" class="textdesc"><?php echo $row['slogan']; ?></textarea>
                        <div class="hr_5"></div>
                    </td>
                </tr>
                <tr>
                    <td height="340" align="right">爱的小屋活动场景介绍：</td>
                    <td>
                        <textarea name="changjing" id="changjing" class="kindeditor"><?php echo $row['changjing']?></textarea>
                        <script>
                            var editor;
                            KindEditor.ready(function(K) {
                                editor = K.create('textarea[name="changjing"]', {
                                    allowFileManager: true,
                                    width: '667px',
                                    height: '280px',
                                    extraFileUploadParams: {
                                        sessionid: '<?php echo session_id(); ?>'
                                    }
                                });
                            });
                        </script>
                        <div class="editToolbar" style="display: none">
                            <label><input type="checkbox" name="remote" id="remote" value="true" /> 下载远程图片和资源&nbsp;</label>
                            <label><input type="checkbox" name="autothumb" id="autothumb" value="true" /> 提取第一个图片为缩略图&nbsp;</label>
                            <label><input type="checkbox" name="autodesc" id="autodesc" value="true" /> 提取</label>
                            <label><input type="text" name="autodescsize" id="autodescsize" value="200" size="3" class="inputls" /> 字到摘要&nbsp;</label>
                            <label><input type="checkbox" name="autopage" id="autopage" value="true" /> 自动分页</label>
                            <input type="text" name="autopagesize" id="autopagesize" value="5" size="6" class="inputls" /> KB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="340" align="right">智残小孩个人介绍：</td>
                    <td>
                        <textarea name="description" id="description" class="kindeditor"><?php echo $row['description']?></textarea>
                        <script>
                            var editor;
                            KindEditor.ready(function(K) {
                                editor = K.create('textarea[name="description"]', {
                                    allowFileManager: true,
                                    width: '667px',
                                    height: '280px',
                                    extraFileUploadParams: {
                                        sessionid: '<?php echo session_id(); ?>'
                                    }
                                });
                            });
                        </script>
                        <div class="editToolbar" style="display: none">
                            <label><input type="checkbox" name="remote" id="remote" value="true" /> 下载远程图片和资源&nbsp;</label>
                            <label><input type="checkbox" name="autothumb" id="autothumb" value="true" /> 提取第一个图片为缩略图&nbsp;</label>
                            <label><input type="checkbox" name="autodesc" id="autodesc" value="true" /> 提取</label>
                            <label><input type="text" name="autodescsize" id="autodescsize" value="200" size="3" class="inputls" /> 字到摘要&nbsp;</label>
                            <label><input type="checkbox" name="autopage" id="autopage" value="true" /> 自动分页</label>
                            <input type="text" name="autopagesize" id="autopagesize" value="5" size="6" class="inputls" /> KB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td height="340" align="right">我的梦想介绍：</td>
                    <td>
                        <textarea name="mengxiang" id="mengxiang" class="kindeditor"><?php echo $row['mengxiang']?></textarea>
                        <script>
                            var editor;
                            KindEditor.ready(function(K) {
                                editor = K.create('textarea[name="mengxiang"]', {
                                    allowFileManager: true,
                                    width: '667px',
                                    height: '280px',
                                    extraFileUploadParams: {
                                        sessionid: '<?php echo session_id(); ?>'
                                    }
                                });
                            });
                        </script>
                        <div class="editToolbar" style="display: none">
                            <label><input type="checkbox" name="remote" id="remote" value="true" /> 下载远程图片和资源&nbsp;</label>
                            <label><input type="checkbox" name="autothumb" id="autothumb" value="true" /> 提取第一个图片为缩略图&nbsp;</label>
                            <label><input type="checkbox" name="autodesc" id="autodesc" value="true" /> 提取</label>
                            <label><input type="text" name="autodescsize" id="autodescsize" value="200" size="3" class="inputls" /> 字到摘要&nbsp;</label>
                            <label><input type="checkbox" name="autopage" id="autopage" value="true" /> 自动分页</label>
                            <input type="text" name="autopagesize" id="autopagesize" value="5" size="6" class="inputls" /> KB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="25%" height="40" align="right">对应商品：</td>
                    <?php $dosql->Execute("select id,title from `#@__goods` where typepid=1", 'goods'); ?>
                    <td width="75%">
                        <select name="goodsid" id="goodsid">
                            <option value="0">请选对应商品</option>
                            <?php while ($good=$dosql->GetArray('goods')):?>
                            <option value="<?php echo $good['id'];?>" <?php echo $good['id']==$row['goodsid']?'selected="selected"':'';?>><?php echo $good['title'];?></option>
                            <?php endwhile;?>
                        </select>
                        <span class="maroon">*</span>
                        <span class="cnote">带<span class="maroon">*</span>号表示为必填项</span>
                    </td>
                </tr>
                <tr>
                    <td height="40" align="right">视频链接：</td>
                    <td><input type="text" name="linkurl" id="linkurl" class="input" value="<?php echo $row['linkurl']; ?>" /></td>
                </tr>
                <tr  style="display: none">
                    <td height="40" align="right">关键词：</td>
                    <td>
                        <input type="text" name="keywords" id="keywords" class="input" value="<?php echo $row['keywords']; ?>" />
                        <span class="cnote">多关键词之间用空格或者“,”隔开</span>
                    </td>
                </tr>
                <tr style="display: none">
                    <td height="340" align="right">详细内容：</td>
                    <td>
                        <textarea name="content" id="content" class="kindeditor"><?php echo $row['content']; ?></textarea>
                        <script>
                            var editor;
                            KindEditor.ready(function(K) {
                                editor = K.create('textarea[name="content"]', {
                                    allowFileManager: true,
                                    width: '667px',
                                    height: '280px',
                                    extraFileUploadParams: {
                                        sessionid: '<?php echo session_id(); ?>'
                                    }
                                });
                            });
                        </script>
                        <div class="editToolbar">
                            <label><input type="checkbox" name="remote" id="remote" value="true" /> 下载远程图片和资源&nbsp;</label>
                            <label><input type="checkbox" name="autothumb" id="autothumb" value="true" /> 提取第一个图片为缩略图&nbsp;</label>
                            <label><input type="checkbox" name="autodesc" id="autodesc" value="true" /> 提取</label>
                            <label><input type="text" name="autodescsize" id="autodescsize" value="200" size="3" class="inputls" /> 字到摘要&nbsp;</label>
                            <label><input type="checkbox" name="autopage" id="autopage" value="true" /> 自动分页</label>
                            <input type="text" name="autopagesize" id="autopagesize" value="5" size="6" class="inputls" /> KB
                        </div>
                    </td>
                </tr>
                <tr class="nb"  style="display: none">
                    <td height="124" align="right">组　图：</td>
                    <td>
                        <fieldset class="picarr">
                            <legend>列表</legend>
                            <div>最多可以上传<strong>50</strong>张图片<span onclick="GetUploadify('uploadify2', '组图上传', 'image', 'image', 50,<?php echo $cfg_max_file_size; ?>, 'picarr', 'picarr_area')">开始上传</span></div>
                            <ul id="picarr_area">
                                <?php
                                if ($row['picarr'] != '') {
                                    $picarr = unserialize($row['picarr']);
                                    foreach ($picarr as $v) {
                                        $v = explode(',', $v);
                                        echo '<li rel="' . $v[0] . '"><input type="text" name="picarr[]" value="' . $v[0] . '"><a href="javascript:void(0);" onclick="ClearPicArr(\'' . $v[0] . '\')">删除</a><br /><input type="text" name="picarr_txt[]" value="' . $v[1] . '"><span>描述</span></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </fieldset>
                    </td>
                </tr>
                <tr class="nb"  style="display: none">
                    <td colspan="2" height="26"><div class="line"> </div></td>
                </tr>
                <tr class="nb">
                    <td colspan="2" height="26"><div class="line"> </div></td>
                </tr>
                <tr>
                        <td height="40" align="right">热度：</td>
                        <td><input type="text" name="hot" id="hot" class="inputos" value="<?php echo $row['hot']; ?>" /></td>
                    </tr>
                <tr>
                    <td height="40" align="right">点击次数：</td>
                    <td><input type="text" name="hits" id="hits" class="inputos" value="<?php echo $row['hits']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">排列排序：</td>
                    <td><input type="text" name="orderid" id="orderid" class="inputos" value="<?php echo $row['orderid']; ?>" /></td>
                </tr>
                <tr>
                    <td height="40" align="right">更新时间：</td>
                    <td>
                        <input name="posttime" type="text" id="posttime" class="inputms" value="<?php echo GetDateTime($row['posttime']); ?>" readonly="readonly" />
                        <script type="text/javascript">
                            date = new Date();
                            Calendar.setup({
                                inputField: "posttime",
                                ifFormat: "%Y-%m-%d %H:%M:%S",
                                showsTime: true,
                                timeFormat: "24"
                            });
                        </script>
                    </td>
                </tr>
                <tr class="nb">
                    <td height="40" align="right">审　核：</td>
                    <td>
                        <label><input type="radio" name="checkinfo" value="true" <?php if ($row['checkinfo'] == 'true') echo 'checked="checked"'; ?> /> 是 &nbsp;</label>
                        <label><input type="radio" name="checkinfo" value="false" <?php if ($row['checkinfo'] == 'false') echo 'checked="checked"'; ?> /> 否</label>
                        <span class="cnote">选择“否”则该信息暂时不显示在前台</span>
                    </td>
                </tr>
            </table>
            <div class="formSubBtn">
                <input type="submit" class="submit" value="提交" />
                <input type="button" class="back" value="返回" onclick="history.go(-1);" />
                <input type="hidden" name="action" id="action" value="update" />
                <input type="hidden" name="classid" id="classid" value="<?php echo $row['classid']; ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
            </div>
        </form>
    </body>
</html>