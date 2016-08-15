<?php

//定义入口常量
define('IN_MEMBER', TRUE);

//初始化参数
$a = isset($a) ? $a : 'default';

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

//种子活动首页
if ($a == 'default') {
    //BANNER
    $banners = $goods = array();
    $dosql->Execute("SELECT title,picurl,linkurl FROM `#@__admanage` WHERE classid=2 AND admode='image' AND checkinfo='true' ORDER BY orderid ASC");
    while ($row = $dosql->GetArray()) {
        $banners[] = $row;
    }

    $seo = setSeo('种子活动', $cfg_keyword, $cfg_description);
}
//种子活动
elseif($a == 'activity'){

    $seo = setSeo('种子活动', $cfg_keyword, $cfg_description);
}



// 活动申请
elseif ($a == 'apply'){
    $seo = setSeo('种子活动申请', $cfg_keyword, $cfg_description);
}


// 领取礼品
// elseif ($a == 'gift'){
//     $flag = empty($flag)?'':$flag;
//     $order=$dosql->GetOne("SELECT auid,id FROM `#@__goodsorder` WHERE id= ".$id);
//     if(empty($order) || empty($order['auid'])){
//         exit('订单错误!');
//     }
//     $goodsitem = $dosql->GetOne("SELECT * FROM `#@__goodsorderitem` WHERE orderid={$id}");
//     $infolist = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE id={$goodsitem['gid']}");
    
//     // 判断是否已经领取
//     $lottery = $dosql->GetOne("SELECT id FROM `#@__lottery` WHERE aid={$infolist['id']} and grade='-1'");
//     if($flag == 'get'){
//         $posttitme = time();
//         $sql = "INSERT INTO `#@__lottery` (`uid`, `aid`,`orderid`,`grade`,`posttime`,`result_desc`,`checkinfo`) 
//         VALUES ({$userInfo['id']}, {$infolist['id']} ,{$order['id']},'-1',$posttitme,'{$infolist['giftname']}', '0')";
//         $dosql->ExecNoneQuery($sql);
//         $lottery = $dosql->GetOne("SELECT id FROM `#@__lottery` WHERE aid={$infolist['id']} and grade='-1'");
//     }
//     $ret['btnurl']='javascript:void(0);';
//     $ret['btntext']='已领取';
//     if(empty($lottery)){
//         $ret['btnurl'] = "index.php?c=activity&a=gift&flag=get&id=".$id;
//         $ret['btntext'] = '我要领取';
//     }
//     $seo = setSeo('领取礼品', $cfg_keyword, $cfg_description);
// }

// 保存活动
elseif ($a == 'saveapply'){
    if(empty($cname) || empty($uname) || empty($mobile) || empty($address)  || empty($posttime)){
        ShowMsg('请填写完整资料');
        exit;
    }
    $posttime = strtotime($posttime);
    $sql = "insert into `#@__apply` (cname, uname, mobile, address, checkinfo, posttime,activity_type) values ('$cname','$uname','$mobile','$address','','$posttime','$activity_type')";
    if($dosql->ExecNoneQuery($sql)){
        ShowMsg('申请成功,我们将尽快和您联系');exit;
       // $ret = array('flag'=>true, 'msg'=>'申请成功,我们将尽快和您联系');
    }else{
        ShowMsg('申请失败');exit;
       // $ret = array('flag'=>false, 'msg'=>'申请失败');
    }

    exit();
}

// 种子认养
elseif ($a == 'activitybuy'){
    $id = empty($id)?0:intval($id);
    $clsid = empty($clsid)?5:intval($clsid);
    $infolist = array();
    $time = time();
    $dosql->Execute("SELECT * FROM `#@__infolist` WHERE delstate='' AND checkinfo='true' AND starttime<{$time} and endtime>{$time} and classid= {$clsid} order by id desc");
    while ($row=$dosql->GetArray()){
        $infolist[]=$row;
    }
    $info=$dosql->GetOne("SELECT * FROM `#@__infolist` WHERE delstate='' AND checkinfo='true' AND id= ".$id);


    //$infoclass = $dosql->GetOne("SELECT * FROM `#@__infoclass` WHERE id={$clsid}");
    if($clsid == 5) {
        $seo = setSeo('种子爱心认养', $cfg_keyword, $cfg_description);
    } else{
        $seo = setSeo('帮困活动认购', $cfg_keyword, $cfg_description);
    }

}

//抽奖
if ($a == 'lucky') {
    $seo = setSeo('抽奖', $cfg_keyword, $cfg_description);
}

//礼品兑换
if ($a == 'gift') {
    $tid = empty($tid)?1:intval($tid);
    
    // 种子商城
    $goods = array();
    $dosql->Execute("SELECT weight,id,picurl,title,colorval,boldval,flag,salesprice,salesprice_dashi,salesprice_tianshi,salenum,starttime,endtime,typeid FROM `#@__goods` WHERE (typeid={$tid} or typepid={$tid}) AND checkinfo='true' AND delstate='' ORDER BY orderid DESC limit 0, 20","goods");
    while ($row = $dosql->GetArray('goods')) {
        $price = calcPrice($row);
        if(!empty($price)){
            $row['salesprice'] = $price;
        }
        $goods[] = $row;
    }
    
    $seo = setSeo('积分兑换', $cfg_keyword, $cfg_description);
}

//抽奖列表
if ($a == 'lucky_list') {
    $seo = setSeo('抽奖列表', $cfg_keyword, $cfg_description);
}

// 爱心留言
elseif ($a == 'message'){
    if(!empty($savemessage)){
        $createtime = time();
        $sql = "insert into `#@__message` (uid, content, createtime, checkinfo,activity_id) values ({$userInfo['id']},'$content',$createtime,'1','$id')";
        if($dosql->ExecNoneQuery($sql)){
            ShowMsg('留言成功');
        } else {
            ShowMsg('留言失败');
        }
    }

    $id = isset($id) ? $id : 0; //活动商品的id
    $messages=array();
    $sql = "select m.wechat_nickname,m.wechat_headimgurl,msg.* from `#@__message` as msg left join  `#@__member` as m on msg.uid=m.id where msg.uid={$userInfo['id']} and checkinfo='1' order by id desc";
    $dosql->Execute($sql);
    while ($row = $dosql->GetArray()){
        $messages[]= $row;
    }


    $seo = setSeo('爱心留言', $cfg_keyword, $cfg_description);
}

// 种子捐赠
elseif ($a == 'donate'){
    $time = time();
    if(!empty($savedonate) && $jine>0){
        $id=empty($id)?0:intval($id);
        $jine=empty($jine)?0:intval($jine);
        $createtime = time();
        $info=$dosql->GetOne("SELECT id,title,auid from `#@__infolist` WHERE id={$id}");
        $auser=$dosql->GetOne("SELECT openid from `#@__member` WHERE id={$info['auid']}");
        
        // 扣种子
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin - {$jine} where id={$userInfo['id']}");
        $integral = '-'.$jine;
        $content = "爱心捐赠";
        $dosql->ExecNoneQuery("INSERT INTO `#@__integral`(uid,ordernum,integral,posttime,content,fuid,type)
            VALUES ({$userInfo['id']},'','{$integral}',{$time},'{$content}',{$userInfo['id']},3)");
        sendwechat($userInfo['openid'],'您在“'.$info['title'].'”种子活动中捐赠'.$jine.'粒爱心种子，为此活动奉献爱心。');
        
        // 加种子
        $dosql->ExecNoneQuery("UPDATE `#@__member` SET yongjin=yongjin + {$jine}, totalyongjin=totalyongjin + {$jine} where id={$info['auid']}");
        $integral = '+'.$jine;
        $content = "爱心种子";
        $dosql->ExecNoneQuery("INSERT INTO `#@__integral`(uid,ordernum,integral,posttime,content,fuid,type)
            VALUES ({$info['auid']},'','{$integral}',{$time},'{$content}',{$userInfo['id']},3)");
            sendwechat(empty($auser['openid'])?'':$auser['openid'],'种子使者【'.$userInfo['wechat_nickname'].'】在“'.$info['title'].'”种子活动中捐赠'.$jine.'粒爱心种子，为此活动奉献爱心。');
    }
    
    $clsid = empty($clsid)?5:intval($clsid);
    $infolist = array();
    $dosql->Execute("SELECT * FROM `#@__infolist` WHERE delstate='' AND checkinfo='true' AND starttime<{$time} and endtime>{$time} and classid= {$clsid} order by id desc");
    while ($row=$dosql->GetArray()){
        $infolist[]=$row;
    }
    $userInfo = $dosql->GetOne("SELECT * from `#@__member` WHERE id={$userInfo['id']}");

    $seo = setSeo('种子捐赠', $cfg_keyword, $cfg_description);
}

