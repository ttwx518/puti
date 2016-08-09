<?php
//获取所有商品分类
$provs = array();
//$pid=empty($pid)?4:intval($pid);
$keywords=empty($keywords)?'':trim($keywords);
$key_prov=empty($key_prov)?'':trim($key_prov);
$key_city=empty($key_city)?'':trim($key_city);
$name_prov=empty($name_prov)?'':trim($name_prov);
$name_city=empty($name_city)?'':trim($name_city);
$keywords_int=empty($keywords)?'':intval($keywords);

$dosql->Execute("SELECT cr.address_prov,c.dataname,c.datavalue FROM `#@__children` cr left join `#@__cascadedata` c on cr.address_prov=c.datavalue where cr.checkinfo='true' AND cr.delstate='' group by address_prov", 'areaid'); /* group by areaid */
while ($row = $dosql->GetArray('areaid')) {
    $provs[] = $row;
}

// 默认加载第一个父类下得分类（点击父类，显示对应的子类）
// if (empty($aid)) {
//     $aid = $areas[0]['address_prov'];
// }

$childrens = array();
$sql = "SELECT * FROM `#@__children` where checkinfo='true' AND delstate='' ";
if(!empty($keywords)){
    $sql .= " AND (title like '%$keywords%' or title2 like '%$keywords%' or id = $keywords_int)";
}
$citys = array();
if(!empty($key_prov)){
    $sql .= " AND address_prov = '$key_prov'";
    $dosql->Execute("SELECT c.* FROM `#@__children` cr left join `#@__cascadedata` c on cr.address_city=c.datavalue WHERE c.`datagroup`='area' AND c.level=1 AND c.datavalue>" . $key_prov . " AND c.datavalue<" . ($key_prov + 500) . " and cr.address_prov='$key_prov' group by cr.address_city ORDER BY c.orderid ASC, c.datavalue ASC",'citys');
    while ($city = $dosql->GetArray('citys')) {
        $citys[] = $city;
    }
}
if(!empty($key_city)){
    $sql .= " AND address_city = '$key_city'";
}
$dosql->Execute($sql, 'children');//AND cr.areaid=$aid order by cr.orderid
while ($row = $dosql->GetArray('children')) {
    $prov = $dosql->GetOne("SELECT * FROM `#@__cascadedata` where datavalue='{$row['address_prov']}' ");
    $city = $dosql->GetOne("SELECT * FROM `#@__cascadedata` where datavalue='{$row['address_city']}' ");
    $row['name_prov'] = empty($prov)?'':$prov['dataname'];
    $row['name_city'] = empty($city)?'':$city['dataname'];
    $childrens[] = $row;
}

$seo = setSeo("爱心儿童", $cfg_keyword, $cfg_description);
?>