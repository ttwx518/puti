<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');

require_once(dirname(__FILE__) . "/phpexcel/Classes/PHPExcel/IOFactory.php");

ini_set('memory_limit', '128M');

$type = isset($type) ? $type : '';
$sql = isset($sql) ? stripslashes($sql) : '';

!$sql && exit();

$data = array();

$dosql->Execute($sql);

while ($row = $dosql->GetArray()) {
    $data[] = $row;
}

$line = 2;

//订单导出
if ($type == 'order') {
    
    if (!file_exists(dirname(__FILE__) . "/phpexcel/order_demo.xls")) {
        exit("Can not find Excel template!");
    } else {
        $objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__) . "/phpexcel/order_demo.xls");
    }

    $objPHPExcel->getSheet(0)->setTitle('订单列表');
    
    $goodsName = isset($goodsName) ? $goodsName : '';
    $itemWhere = '';
    if($goodsName)
        $itemWhere = " AND title LIKE '%{$goodsName}%'";

    foreach ($data as $v) {
        
        $checkinfo = explode(',', $v['checkinfo']);
        $status = '';
        if (!in_array('applyreturn', $checkinfo) && !in_array('agreedreturn', $checkinfo) && !in_array('goodsback', $checkinfo) && !in_array('moneyback', $checkinfo) && !in_array('overorder', $checkinfo) && !in_array('cancel', $checkinfo)) {
            if ($v['checkinfo'] == '' || !in_array('confirm', $checkinfo))
                $status = '等待确认';
            else if (!in_array('payment', $checkinfo))
                $status = '等待付款';
            else if (!in_array('postgoods', $checkinfo))
                $status = '等待发货';
            else if (!in_array('getgoods', $checkinfo))
                $status = '等待收货';
            else if (!in_array('overorder', $checkinfo))
                $status = '等待归档';
            else
                $status = '参数错误，没有获取到订单状态';
        }else {
            if (in_array('overorder', $checkinfo))
                $status = '已归档';
            else if (in_array('moneyback', $checkinfo))
                $status = '等待归档';
            else if (in_array('goodsback', $checkinfo))
                $status = '等待退款';
            else if (in_array('agreedreturn', $checkinfo))
                $status = '等待返货';
            else if (in_array('applyreturn', $checkinfo))
                $status = '申请退货';
            else if (in_array('cancel', $checkinfo))
                $status = '已取消';
            else
                $status = '参数错误，没有获取到订单状态';
        }
        
        $dosql->Execute("SELECT * FROM #@__goodsorderitem WHERE orderid={$v['id']}{$itemWhere}",$v['id']);

        while ($row = $dosql->GetArray($v['id'])) {
            
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A" . "$line", $v['id'])//订单ID
                        ->setCellValueExplicit("B" . "$line", $row['title'].'【'.$row['goodsid'].'】 ￥'.$row['salesprice'].' * '.$row['buyNum'], PHPExcel_Cell_DataType::TYPE_STRING)//商品信息
                        ->setCellValueExplicit("C" . "$line", $v['username'], PHPExcel_Cell_DataType::TYPE_STRING)//用户名
                        ->setCellValueExplicit("D" . "$line", $v['ordernum'], PHPExcel_Cell_DataType::TYPE_STRING)//订单编号
                        ->setCellValueExplicit("E" . "$line", $v['name'], PHPExcel_Cell_DataType::TYPE_STRING)//联系人
                        ->setCellValueExplicit("F" . "$line", $v['mobile'], PHPExcel_Cell_DataType::TYPE_STRING)//电话
                        ->setCellValueExplicit("G" . "$line", $v['pccinfo'].$v['address'], PHPExcel_Cell_DataType::TYPE_STRING)//收货地址
                        ->setCellValueExplicit("H" . "$line", number_format($v['amount'],2), PHPExcel_Cell_DataType::TYPE_STRING)//金额
                        ->setCellValueExplicit("I" . "$line", GetDateTime($v['createtime']), PHPExcel_Cell_DataType::TYPE_STRING)//订单时间
                        ->setCellValueExplicit("J" . "$line", $status, PHPExcel_Cell_DataType::TYPE_STRING);//订单状态
            
            $line++;
            
        }
        
    }
    //设置导出文件名
    $filename = '订单列表' . date('YmdHi');
    
}
//发货订单导出
elseif($type == 'delivery'){
    if (!file_exists(dirname(__FILE__) . "/phpexcel/delivery_demo.xls")) {
        exit("Can not find Excel template!");
    } else {
        $objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__) . "/phpexcel/delivery_demo.xls");
    }

    $objPHPExcel->getSheet(0)->setTitle('发货订单列表');

    foreach ($data as $v) {
        
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueExplicit("A" . "$line", $v['ordernum'], PHPExcel_Cell_DataType::TYPE_STRING)//订单号
                    ->setCellValueExplicit("B" . "$line", $v['name'], PHPExcel_Cell_DataType::TYPE_STRING)//收货人
                    ->setCellValueExplicit("C" . "$line", $v['mobile'], PHPExcel_Cell_DataType::TYPE_STRING)//联系电话
                    ->setCellValueExplicit("D" . "$line", $v['pccinfo'].$v['address'], PHPExcel_Cell_DataType::TYPE_STRING)//收货地址
                    ->setCellValueExplicit("E" . "$line", $v['checkinfo'], PHPExcel_Cell_DataType::TYPE_STRING)//订单状态
                    ->setCellValueExplicit("F" . "$line", $v['postmode'], PHPExcel_Cell_DataType::TYPE_STRING);//快递公司
        
        $line++;
        
    }
    //设置导出文件名
    $filename = '发货订单列表' . date('YmdHi');
}
//提现申请导出
elseif($type == 'withdrawApply'){
    
    if (!file_exists(dirname(__FILE__) . "/phpexcel/withdrawApply_demo.xls")) {
        exit("Can not find Excel template!");
    } else {
        $objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__) . "/phpexcel/withdrawApply_demo.xls");
    }
    
    $begintime = isset($begintime) ? $begintime ? date('Y-m-d', $begintime) : '' : '';
    $endtime = isset($endtime) ? $endtime ? date('Y-m-d', $endtime) : '' : '';

    $objPHPExcel->getSheet(0)->setTitle('提现申请列表');
    
    $statusArr = array(0=>'待审核',1=>'审核失败',2=>'审核成功');

    foreach ($data as $v) {
        
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A" . "$line", $v['id'])//ID
                    ->setCellValueExplicit("B" . "$line", $v['alipayAccount'], PHPExcel_Cell_DataType::TYPE_STRING)//支付宝账号
                    ->setCellValueExplicit("C" . "$line", $v['truename'], PHPExcel_Cell_DataType::TYPE_STRING)//真实姓名
                    ->setCellValueExplicit("D" . "$line", $v['amount'], PHPExcel_Cell_DataType::TYPE_STRING)//金额
                    ->setCellValueExplicit("E" . "$line", GetDateTime($v['createtime']), PHPExcel_Cell_DataType::TYPE_STRING)//申请时间
                    ->setCellValueExplicit("F" . "$line", $statusArr[$v['status']], PHPExcel_Cell_DataType::TYPE_STRING);//状态
        
        $line++;
        
    }
    
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$line.':F'.$line);//合并单元格  
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$line, '导出时间段: '.$begintime.' ~ '.$endtime);  
    
    //设置导出文件名
    $filename = '提现申请列表' . date('YmdHi');
}

header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $filename . '.xls');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;