<?php

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}
$a = isset($a) ? $a : '';

if($a == 'save_apply') {
    $param = $_POST;
    if(empty($param)){
        ShowMsg('请填写信息内容');
        exit;
    }

    $child_info = $dosql->GetOne("select * from `#@__children` where title = '{$param['title']}' and mobile = '{$param['mobile']}' ");
    if(!empty($child_info)){
        ShowMsg('儿童姓名和联系方式已存在');
        exit;
    }
    $time = time();

    $sql = "insert into `#@__children` (`title`, `sex`, `age`, `id_no`, `address`, `guardian_name`, `guardian_mobile`, `oversight_bodies`,
    `guardian_address`, `mobile`, `description`, `picurl`, `classid`, `posttime`) VALUES ('{$param['title']}', '{$param['sex']}', '{$param['age']}','{$param['id_no']}', '{$param['address']}',
     '{$param['guardian_name']}', '{$param['guardian_mobile']}', '{$param['oversight_bodies']}', '{$param['guardian_address']}',  '{$param['mobile']}', '{$param['description']}', '{$param['picurl']}',
      '7', '$time')";
    if( $dosql->ExecNoneQuery($sql) ) {
        ShowMsg('申请成功');
        exit;
    } else {
        ShowMsg('申请失败');
    }


} elseif($a == 'child_upload') {

        $file_name = "uploadfile";
        $path = dmkdir('uploads/avatar');
        $path_arr = upload($path, $file_name);
        $return=$path_arr;
        if($path_arr['success']){
            $return['imgpath'] = $path_arr['path'] . $path_arr['name'];
            $return['real_name']=$path_arr['real_name'];
            $path2 = "uploads/avatar"  . $path_arr['name'];
            @copy($path, $path2);
            echo json_encode($return);
            exit;
        }else{
            echo json_encode($return);
            exit;
        }

}


    $seo = setSeo('智残儿童申请', $cfg_keyword, $cfg_description);



