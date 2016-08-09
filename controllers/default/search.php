<?php
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

// 新品推荐
$flag = empty($flag)?'':$flag;
$keyword = empty($keyword)?'':$keyword;
$search = '';
if(!empty($keyword)){
    $search .= " and title LIKE '%{$keyword}%'";
}

if(!empty($flag)){
    $search .= " and flag LIKE '%{$flag}%'";
}
$s_goods = array();
$dosql->Execute("SELECT weight,id,picurl,title,colorval,boldval,flag,salesprice,marketprice,salenum FROM `#@__goods` WHERE typeid=1 AND checkinfo='true' AND delstate='' {$search} ORDER BY orderid DESC");
while ($row = $dosql->GetArray()) {
    $s_goods[] = $row;
}

$seo = setSeo('搜索结果', $cfg_keyword, $cfg_description);

?>