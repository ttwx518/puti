<?php
$id = isset($id) ? intval($id) : 0;

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

// 我的收藏 儿童
if(!empty($subfav)){
    $sql = "SELECT * FROM `#@__fav` WHERE uid={$userInfo['id']} and gid={$id} and type='3'";
    $fav = $dosql->GetOne($sql);
    if(!empty($fav)){
        $dosql->ExecNoneQuery("delete from `#@__fav` where id={$fav['id']}");
    } else{
        $createtime=time();
        $dosql->ExecNoneQuery("insert into `#@__fav` (uid,gid,type,createtime) values ({$userInfo['id']},{$id},'3',$createtime)");
    }
}

// 收藏
$fav = $dosql->GetOne("SELECT * FROM `#@__fav` WHERE uid={$userInfo['id']} and gid={$id} and type='3'");

//获取儿童信息
$children = $dosql->GetOne("SELECT cr.*,c.dataname FROM `#@__children` cr left join `#@__cascadedata` c on cr.address_prov=c.datavalue WHERE cr.checkinfo='true' AND cr.delstate='' AND cr.id={$id}");

if(!$children){
    redirect('index.php');
}

$prov = $dosql->GetOne("SELECT * FROM `#@__cascadedata` where datavalue='{$children['address_prov']}' ");
$city = $dosql->GetOne("SELECT * FROM `#@__cascadedata` where datavalue='{$children['address_city']}' ");
$children['name_prov'] = empty($prov)?'':$prov['dataname'];
$children['name_city'] = empty($city)?'':$city['dataname'];

//获取商品信息
$goods = $dosql->GetOne("SELECT id, title, picurl,salesprice FROM `#@__goods` WHERE id={$children['goodsid']}");

//更新产品点击数
$dosql->ExecNoneQuery("UPDATE `#@__children` SET hits=hits+1 WHERE id={$id}");

// $style = '';
// if($children['colorval'])
//     $style .= 'color:'.$children['colorval'].';';
// if($children['boldval'])
//     $style .= 'font-weight:'.$children['boldval'];

//seo
$seo = setSeo($children['title'], $cfg_keyword, $cfg_description);

?>