<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');

if ($action == 'replyEvaluate') {
    $id = isset($id) ? intval($id) : 0;
    $replyContent = isset($replyContent) ? trim($replyContent) : '';
    if (!$replyContent) {
        echo json_encode(array('status' => false, 'msg' => '请填写回复内容'));
        exit();
    }
    $replyInfo = $dosql->GetOne("SELECT * FROM `#@__usercomment` WHERE id={$id}");
    if (!$replyInfo) {
        echo json_encode(array('status' => false, 'msg' => '未查询到相关评价信息'));
        exit();
    }
    $nowTime = time();
    if ($dosql->ExecNoneQuery("UPDATE `#@__usercomment` SET reply='{$replyContent}',replyTime={$nowTime} WHERE id={$id}")) {
        echo json_encode(array('status' => true, 'msg' => '回复成功'));
        exit();
    } else {
        echo json_encode(array('status' => false, 'msg' => '回复失败,请稍后重试'));
        exit();
    }
} else if ($action == 'getRecUid') {
    $id = isset($id) ? intval($id) : 0;
    $searchName = isset($searchName) ? $searchName : '';
    $list = array();
    $dosql->Execute("SELECT id,username FROM `#@__member` WHERE username LIKE '%$searchName%' AND id<>{$id}");
    while ($row = $dosql->GetArray()) {
        $list[] = $row;
    }
    $html = "<option value='0'>无</option><option value='-1'>官方商城</option>";
    foreach($list as $v){
        $html .= "<option value='".$v['id']."'>".$v['username']."</option>";
    }
    echo json_encode(array('status' => true, 'msg' => $html));
    exit();
}