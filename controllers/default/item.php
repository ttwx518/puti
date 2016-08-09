<?php

$id = isset($id) ? intval($id) : 0;

// 我的收藏 商品
if(!empty($subfav)){
    $sql = "SELECT * FROM `#@__fav` WHERE uid={$userInfo['id']} and gid={$id} and type='1'";
    $fav = $dosql->GetOne($sql);
    if(!empty($fav)){
        $dosql->ExecNoneQuery("delete from `#@__fav` where id={$fav['id']}");
    } else{
        $createtime=time();
        $dosql->ExecNoneQuery("insert into `#@__fav` (uid,gid,type,createtime) values ({$userInfo['id']},{$id},'1',$createtime)");
    }
}
// 评价
if(!empty($savecomment)){
    $content=empty($content)?'':$content;
    $fav = $dosql->GetOne($sql);
    $createtime=time();
    $dosql->ExecNoneQuery("insert into `#@__comment` (uid,gid,content,checkinfo,createtime) values ({$userInfo['id']},{$id},'{$content}','1',$createtime)");
}

//获取产品信息
$goodInfo = $dosql->GetOne("SELECT * FROM `#@__goods` WHERE checkinfo='true' AND delstate='' AND id={$id}");
if(!$goodInfo){
    redirect('index.php?c=cat');
}

// 查询留言
$comments=array();
$sql = "select m.wechat_nickname,m.wechat_headimgurl,c.* from `#@__comment` as c left join  `#@__member` as m on c.uid=m.id where c.gid = {$goodInfo['id']} and checkinfo='1' order by id desc";
$dosql->Execute($sql);
while ($row = $dosql->GetArray()){
    $comments[]= $row;
}

$price = calcPrice($goodInfo);
if(!empty($price)){
    $goodInfo['salesprice'] = $price;
}

//!$userInfo && redirectAuth('index.php?c=item&id='.$id);
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

$goodInfo['indirectCommission'] = unserialize($goodInfo['indirectCommission']);

$usergroup = getUserGroup();

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

//获取产品货主
$transporter = getTransporter($id, $userInfo['id'], $userInfo['recUid']);

//更新产品点击数
$dosql->ExecNoneQuery("UPDATE `#@__goods` SET hits=hits+1 WHERE id={$id}");

// 收藏
$fav = $dosql->GetOne("SELECT * FROM `#@__fav` WHERE uid={$userInfo['id']} and gid={$id} and type='1'");

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