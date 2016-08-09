<?php
require_once(dirname(dirname(__FILE__)) . '/inc/config.inc.php');
IsModelPriv('goodsorder');
$operateResult = array('status'=>'','msg'=>'');
//执行批量发货操作
if(isset($deliverySub)){
    
    if(!empty($_FILES['deliveryFile']['name'])){
        
        $tmpFile = $_FILES['deliveryFile']['tmp_name'];
        $fileTypes = explode(".", $_FILES['deliveryFile']['name']);
        $fileType = $fileTypes[count($fileTypes) - 1];

        /*判别是不是.xls文件，判别是不是excel文件*/
        if (strtolower($fileType) != "xls"){
            $operateResult = array('status'=>'error','msg'=>'你上传的不是Excel文件，请重新上传');
        }else{
            /*设置上传路径*/
            $savePath = PHPMYWIND_UPLOAD . '/excel/';
            /*以时间来命名上传的文件*/
            $str = date('Ymdhis');
            $fileName = $str . "." . $fileType;
            
            /*是否上传成功*/
            if(!copy($tmpFile, $savePath . $fileName)){
                $operateResult = array('status'=>'error','msg'=>'上传失败，请重新上传');
            }else{
                include '../phpexcel/Classes/excelToArray.class.php';
                $excelToArray = new ExcelToArrary();
                $excelData = $excelToArray->read($savePath . $fileName);
                if(!$excelData){
                    $operateResult = array('status'=>'error','msg'=>'上传数据为空，请重新上传');
                }else{
                    /* 对生成的数组进行操作 */
                    foreach ($excelData as $k => $v) {
                        if ($k > 1) {
                            $checkinfo = explode(',', $v[4]);
                            if(!in_array('postgoods',$checkinfo)){
                                $checkinfo[] = 'postgoods';
                                $checkinfo = implode(',', $checkinfo);
                                $dosql->ExecNoneQuery("UPDATE #@__goodsorder SET checkinfo='{$checkinfo}',postmode={$v[5]},postid='{$v[6]}' WHERE ordernum='{$v[0]}'");
                            }
                        }
                    }
                    $operateResult = array('status'=>'succeed','msg'=>'发货操作成功');
                }
            }
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>订单批量发货</title>
        <link href="../templates/style/admin.css" rel="stylesheet" type="text/css" />
        <link href="../templates/js/jPages/css/jPages.css" rel="stylesheet" type="text/css" />
        <link href="../templates/js/jPages/css/animate.css" rel="stylesheet" type="text/css" />
        <link href="../templates/js/jPages/css/github.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../templates/js/jquery.min.js"></script>
        <script type="text/javascript" src="../templates/js/forms.func.js"></script>
        <script type="text/javascript" src="../templates/js/datepicker/WdatePicker.js"></script>
        <script type="text/javascript" src="../templates/js/jPages/js/highlight.pack.js"></script>
        <script type="text/javascript" src="../templates/js/jPages/js/tabifier.js"></script>
        <script type="text/javascript" src="../templates/js/jPages/js/js.js"></script>
        <script type="text/javascript" src="../templates/js/jPages/js/jPages.js"></script>
        <script type="text/javascript" src="../templates/js/artDialog/jquery.artDialog.js?skin=default"></script>
        <script type="text/javascript" src="../templates/js/artDialog/artDialog.iframeTools.js"></script>
        <style>
            .OperateBtn{cursor:pointer;width:80px;height:25px;border-radius:5px;border:none;margin-left:5px}
        </style>
    </head>
    <body>
        <div style="padding:5px 0">
            <p>操作提示：导出需要发货的订单，填写快递公司ID与运单号，选择填写好的文件再次导入。</p>
        </div>
        <!--订单筛选-->
        <div class="toolbarTab" style="margin-bottom:0">
            <?php if($operateResult['status']): ?>
            <div class="operateTips <?php echo $operateResult['status']; ?>">
                <?php echo $operateResult['msg']; ?>
            </div>
            <?php endif; ?>
            <?php
            //初始化参数
            $goodsNames = isset($goodsNames) ? $goodsNames : '';
            $keyword = isset($keyword) ? $keyword : '';
            $sql = "SELECT o.*,m.username FROM `#@__goodsorder` o LEFT JOIN `#@__member` m ON o.uid=m.id WHERE o.delstate='' AND o.checkinfo LIKE '%payment%' AND o.checkinfo NOT LIKE '%postgoods%'";
            if ($goodsNames != '')
                $sql .= " AND (o.goodsNames LIKE '%{$goodsNames}%')";
            if ($keyword != '')
                $sql .= " AND (o.ordernum LIKE '%$keyword%' OR m.username LIKE '%$keyword%')";
            ?>
            <form name="forms" id="forms" method="get" action="">
                <div class="orderSearchItem">
                    <input name="goodsNames" id="goodsNames" type="text" class="inputos" placeholder="商品名称..." value="<?php echo $goodsNames; ?>" />
                </div>
                <div class="search fl">
                    <span class="s">
                        <input name="keyword" id="keyword" type="text" placeholder="订单号,用户名..." value="<?php echo $keyword; ?>" />
                    </span>
                    <span class="b"><a href="javascript:;" onclick="$('#forms').submit();"></a></span>
                </div>
                <input type="button" onclick="location.href='../export.php?type=delivery&sql=<?php echo urlencode($sql); ?>'" class="OperateBtn" value="导出发货订单" />
            </form>
        </div>
        <div class="clear"></div>
        <div class="toolbarTab" style="margin:10px 0 0 0">
            <form name="forms" id="forms" method="post" action="" enctype="multipart/form-data">
                <input type="file" name="deliveryFile" id="deliveryFile" />
                <input type="submit" name="deliverySub" value="确认上传发货" />
            </form>
        </div>
        <div class="clear"></div>
        <form name="form" method="post" action="" id="deliveryForm">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="dataTable">
                <tr align="left" class="head">
                    <!--
                    <td width="5%" height="36" class="firstCol">
                        <input type="checkbox" name="checkid" id="checkid" onclick="CheckAll(this.checked);">
                    </td>
                    -->
                    <td width="5%" height="36" class="firstCol">ID</td>
                    <td width="10%">用户名</td>
                    <td width="15%">订单编号</td>
                    <td width="20%">商品名称</td>
                    <td width="20%">联系人/电话</td>
                    <td width="10%">金额</td>
                    <td width="15%">订单时间</td>
                </tr>
                <?php
                
                $orders = array();
                
                $dosql->Execute($sql);
                
                while ($row = $dosql->GetArray()) {
                    $orders[] = $row;
                }
                
                ?>
                <tbody id="orders">
                <?php 
                foreach($orders as $v): 
                ?>
                <tr align="left" class="dataTr">
                    <!--
                    <td height="36" class="firstCol">
                        <input type="checkbox" name="checkid[]" id="checkid[]" value="<?php echo $v['id']; ?>" />
                    </td>
                    -->
                    <td height="36" class="firstCol"><?php echo $v['id']; ?></td>
                    <td><?php echo $v['username']; ?></td>
                    <td><?php echo $v['ordernum']; ?></td>
                    <td><?php echo $v['goodsNames']; ?></td>
                    <td><?php echo $v['name'] . '/' . $v['mobile']; ?></td>
                    <td><?php echo $v['amount']; ?></td>
                    <td class="number"><?php echo GetDateTime($v['createtime']); ?></td>
                </tr>
                <?php
                endforeach;
                ?>
                </tbody>
            </table>
            <?php
            if (empty($orders)) {
                echo '<div class="dataEmpty">暂时没有相关的记录</div>';
            }
            ?>
            <div class="page fl"></div>
        </form>
        <script>
            $(document).ready(function() {
                $("div.page").jPages({
                    containerID : "orders",
                    previous : "←",
                    next : "→",
                    perPage : 10,
                    delay : 10
                });
            });
        </script>
    </body>
</html>