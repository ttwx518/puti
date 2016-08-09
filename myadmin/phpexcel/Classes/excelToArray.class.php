<?php

class ExcelToArrary{

    public function __construct() {
        //导入phpExcel核心类
        include_once('PHPExcel.php');
    }

    /**
     * 读取excel
     * @param string $filename 路径文件名
     * @param string $encode 返回数据的编码,默认为utf8
     * @return array
     */
    public function read($filename, $encode = 'utf-8') {
        if (!file_exists($filename)) {
            return false;
        }
        $reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
        $PHPExcel = $reader->load($filename); // 载入excel文件
        $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数
        $excelData = array();
        /** 循环读取每个单元格的数据 */
        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
            for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                $excelData[$row][] = $sheet->getCell($column.$row)->getValue();
            }
        }
        return $excelData;
    }

}

?>