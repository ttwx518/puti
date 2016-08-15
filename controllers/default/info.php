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
    $activity_type = isset($activity_type) ? $activity_type : 'adopt'; //认养 adopt  认购 subscription
    $now_time = time();

    if($activity_type == 'adopt'){
        $clsid = 5 ; //认养
    } elseif($activity_type == 'subscription') {
        $clsid = 8 ; // 认购
    } else {
        $clsid = isset($clsid) ? intval($clsid) : 0;
    }
    $sql = "select * from `#@__infolist` where classid={$clsid} AND delstate='' AND checkinfo='true' ";

    if($type == 1){
        $sql .= " and $now_time < starttime ";
    } elseif($type == 2) {
        $sql .= " and $now_time > endtime";
    } elseif($type == 3) {
        $sql .=" and starttime <= $now_time and $now_time <= endtime";
    }

    if(!empty($keywords)) {
        $sql .= " and title like '%$keywords%' ";
    }



    $dosql->Execute($sql);
    while($row = $dosql->GetArray()){
       $list[] = $row;
    }

  //  $records = getInfoList($page, $clsid, $a, $type);
    
    $infoclass = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id={$clsid}");
    $seo = setSeo($infoclass['classname'], $cfg_keyword, $cfg_description);
}

// 活动 详情
elseif ($a == 'activitydetails'){
    $id = isset($id) ? intval($id) : 0;
    $type = isset($type) ? $type : '';
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
    $info['btntext']='我要参加';
    if(time() > $info['endtime']){
        $info['url']=empty($info['videourl'])?'javascript:void(0);':"{$info['videourl']}";
        $info['btntext']=empty($info['videourl'])?'已结束(不能参加)':'点击播放视频';
    }

    //留言
    $msql = "select m.*,u.wechat_headimgurl,u.wechat_nickname from `#@__message` m LEFT JOIN `#@__member` u ON m.uid = u.id  where m.uid = '{$userInfo['id']}' and m.activity_id = $id and m.checkinfo = 1 ";
    $dosql->Execute($msql);
    while($mrow = $dosql->GetArray()) {
        $message[] = $mrow;
    }


    $seo = setSeo($info['title'], $cfg_keyword, $cfg_description);
}

// 庙宇列表
if ($a == 'infolist') {
    $page = empty($page)?1:intval($page);
    $clsid = isset($clsid) ? intval($clsid) : 9;
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


