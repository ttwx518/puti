<?php

//定义入口常量
define('IN_MEMBER', TRUE);

//初始化参数
$a = isset($a) ? $a : 'activitylist';

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

// 活动动态列表
if ($a == 'activitylist') {
    // 1为开始  3进行中  2已结束
    $type = empty($type)?3:intval($type);
    $page = empty($page)?1:intval($page);
    $clsid = isset($clsid) ? intval($clsid) : 0;
    
    $records = getInfoList($page, $clsid, $a, $type);
    
    $infoclass = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id={$clsid}");
    $seo = setSeo($infoclass['classname'], $cfg_keyword, $cfg_description);
}

// 活动 详情
elseif ($a == 'activitydetails'){
    $id = isset($id) ? intval($id) : 0;
    // 我的收藏 活动
    if(!empty($subfav)){
        $sql = "SELECT * FROM `#@__fav` WHERE uid={$userInfo['id']} and gid={$id} and type='2'";
        $fav = $dosql->GetOne($sql);
        if(!empty($fav)){
            $dosql->ExecNoneQuery("delete from `#@__fav` where id={$fav['id']}");
        } else{
            $createtime=time();
            $dosql->ExecNoneQuery("insert into `#@__fav` (uid,gid,type,createtime) values ({$userInfo['id']},{$id},'2',$createtime)");
        }
    }
    
    $sql = "SELECT * FROM `#@__infolist` WHERE delstate='' AND checkinfo='true' AND id= ".$id;
    
    // 收藏
    $fav = $dosql->GetOne("SELECT * FROM `#@__fav` WHERE uid={$userInfo['id']} and gid={$id} and type='2'");
    
    $info=$dosql->GetOne($sql);
    $info['url']="index.php?c=activity&a=activitybuy&clsid=".$info['classid']."&id=".$info['id'];
    $info['btntext']='立即参加';
    if(time() > $info['endtime']){
        $info['url']=empty($info['videourl'])?'javascript:void(0);':"{$info['videourl']}";
        $info['btntext']=empty($info['videourl'])?'已结束(不能参加)':'点击播放视频';
    }
    
    $seo = setSeo($info['title'], $cfg_keyword, $cfg_description);
}

// 庙宇列表
if ($a == 'infolist') {
    $page = empty($page)?1:intval($page);
    $clsid = isset($clsid) ? intval($clsid) : 0;
    $records = getInfoList($page, $clsid, $a);

    $infoclass = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id={$clsid}");
    $seo = setSeo($infoclass['classname'], $cfg_keyword, $cfg_description);
}

// 庙宇介绍 详情
elseif ($a == 'infodetails'){
    $id = isset($id) ? intval($id) : 0;
    
    $sql = "SELECT * FROM `#@__infolist` WHERE delstate='' AND checkinfo='true' AND id= ".$id;
    
    $info=$dosql->GetOne($sql);
    
    $seo = setSeo($info['title'], $cfg_keyword, $cfg_description);
}


