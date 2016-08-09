<?php

$id = isset($id) ? intval($id) : 0;

//获取产品信息
$goodInfo = $dosql->GetOne("SELECT * FROM `#@__goods` WHERE checkinfo='true' AND delstate='' AND id={$id}");
if(!$goodInfo){
    redirect('index.php?c=cat');
}

//!$userInfo && redirectAuth('index.php?c=bItem&id='.$id);
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

//判断是否可买
if(!$userInfo['recUid']){
    //ShowMsg('您未获得该商品分销权!!','-1');
}

if($userInfo['recUid'] != -1 && !hasBuyItem($id, $userInfo['recUid'])){
    //ShowMsg('请联系货主申请分销!','-1');
}

//产品图片
$picArr[] = array($goodInfo['picurl'],$goodInfo['title']);
if($goodInfo['picarr']){
    $goodInfo['picarr'] = unserialize($goodInfo['picarr']);
    foreach($goodInfo['picarr'] as $v){
        $picArr[] = explode(',', $v);
    }
}

//获取产品分类信息
$catInfo = $dosql->GetOne("SELECT id,classname FROM `#@__goodstype` WHERE checkinfo = 'true' AND id={$goodInfo['typeid']}");
$catName = isset($catInfo['classname']) ? $catInfo['classname'] : '';

//更新产品点击数
$dosql->ExecNoneQuery("UPDATE `#@__goods` SET hits=hits+1 WHERE id={$id}");

$style = '';
if($goodInfo['colorval'])
    $style .= 'color:'.$goodInfo['colorval'].';';
if($goodInfo['boldval'])
    $style .= 'font-weight:'.$goodInfo['boldval'];

//seo
$keyword = $goodInfo['keywords'] ? $goodInfo['keywords'] : $cfg_keyword;
$description = $goodInfo['description'] ? $goodInfo['description'] : $cfg_description;
$seo = setSeo($goodInfo['title'], $keyword, $description);

?>