<?php

require_once(dirname(__FILE__) . '/inc/config.inc.php');
IsModelPriv('withdrawApply');

/*
 * *************************
  (C)2010-2014 weixin66.net
  update: 2014-5-30 17:16:14
  person: Feng
 * *************************
 */

//初始化参数
$tbname = '#@__withdraw_record';
$gourl = 'withdrawApply.php';
$wechat_options = [
    'appid' => 'wxb82a5dbccfcd523e',
    'appsecret' => '65fddaa4d166932481c1d27c832b9b05'
];

/**
 * XML编码
 * @param mixed $data 数据
 * @param string $root 根节点名
 * @param string $item 数字索引的子节点名
 * @param string $attr 根节点属性
 * @param string $id   数字索引子节点key转换的属性名
 * @param string $encoding 数据编码
 * @return string
 */
function xml_encode($data, $root = 'xml', $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8') {
    if (is_array($attr)) {
        $_attr = array();
        foreach ($attr as $key => $value) {
            $_attr[] = "{$key}=\"{$value}\"";
        }
        $attr = implode(' ', $_attr);
    }
    $attr = trim($attr);
    $attr = empty($attr) ? '' : " {$attr}";
    $xml = "<{$root}{$attr}>";
    $xml .= data_to_xml($data, $item, $id);
    $xml .= "</{$root}>";
    return $xml;
}
/**
 * 数据XML编码
 * @param mixed $data 数据
 * @return string
 */
function data_to_xml($data) {
    $xml = '';
    foreach ($data as $key => $val) {
        is_numeric($key) && $key = "item id=\"$key\"";
        $xml .= "<$key>";
        $xml .= ( is_array($val) || is_object($val)) ? data_to_xml($val) : xmlSafeStr($val);
        list($key, ) = explode(' ', $key);
        $xml .= "</$key>";
    }
    return $xml;
}

function xmlSafeStr($str) {
    return '<![CDATA[' . preg_replace("/[\\x00-\\x08\\x0b-\\x0c\\x0e-\\x1f]/", '', $str) . ']]>';
}

function xmlToArray($xml) {
    //将XML转为array
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}

function curl_post_ssl($url, $vars, $second=30,$aHeader=array())
{

    $ch = curl_init();
    //超时时间
    curl_setopt($ch,CURLOPT_TIMEOUT,$second);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);


    //第一种方法，cert 与 key 分别属于两个.pem文件
    //默认格式为PEM，可以注释
    curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
    curl_setopt($ch,CURLOPT_SSLCERT,PHPMYWIND_ROOT.'/topay/wechatpay/WxPayPubHelper/cacert/apiclient_cert.pem');
    //默认格式为PEM，可以注释
    curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
    curl_setopt($ch,CURLOPT_SSLKEY, PHPMYWIND_ROOT.'/topay/wechatpay/WxPayPubHelper/cacert/apiclient_key.pem');
//	echo '<a href="'.PHPMYWIND_DATA.'/wxpay/WxPayPubHelper/cacert/apiclient_cert.pem'.'"> 11111</a>';exit;
    curl_setopt($ch,CURLOPT_CAINFO,'PEM');
    curl_setopt($ch,CURLOPT_CAINFO,PHPMYWIND_ROOT.'/topay/wechatpay/WxPayPubHelper/cacert/rootca.pem');
    //第二种方式，两个文件合成一个.pem文件
    // curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

    if( count($aHeader) >= 1 ){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    }

    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
    $data = curl_exec($ch);
    if($data){
        curl_close($ch);
        return $data;
    }
    else {
        $error = curl_errno($ch);
        echo "call faild, errorCode:$error\n";
        curl_close($ch);
        return false;
    }
}



//引入操作类
require_once(ADMIN_INC . '/action.class.php');

//添加提现记录
if ($action == 'add') {
    
}

//同意
elseif($action == 'agree') {

    $info = $dosql->GetOne("select * from `{$tbname}` where id = '$id'");
    $userInfo = $dosql->GetOne("select * from `#@__member` where id = '{$info['uid']}'");
    if($info['status'] != 0) {
        ShowMsg('你已处理过了');
        exit;
    }

    //调用微信零钱接口 处理用户冻结佣金 增加已提佣金
    include_once "../topay/wechatpay/WxPayPubHelper/WxPayPubHelper.php";
    $Common_util = new Common_util_pub();

    $desc = "提现成功".$cfg_webname;
    $data = array(
        'mch_appid' => "wxb82a5dbccfcd523e",
        'mchid' =>"1259643301",
        'nonce_str' => '1234567',
        'partner_trade_no' => $info['ordernum'],//商户订单号
        'openid' => $userInfo['openid'],
        'check_name' => 'NO_CHECK',
        'amount' => $info['amount']*100,
        'desc' => $desc,
        'spbill_create_ip' => GetIP()
    );
    $sign = $Common_util->getSign($data);
    $data['sign'] = $sign;
    $data = xml_encode($data);
    $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    $data = curl_post_ssl($url,$data);
    $result =xmlToArray($data);

    if($result['result_code'] == 'SUCCESS'){
        //提现状态改变
        $sql = "update `{$tbname}` set status = 2 where id = '$id'";
        $dosql->ExecNoneQuery($sql);

        ShowMsg('同意成功');exit;
    } else {

        ShowMsg('同意失败');

    }

}

//拒绝
elseif($action == 'refuse') {

    $info = $dosql->GetOne("select * from `{$tbname}` where id = '$id'");
    if($info['status'] != 0) {
        ShowMsg('你已处理过了');
        exit;
    }
    $sql = "update `{$tbname}` set status = 1 where id = '$id'";
    if($dosql->ExecNoneQuery($sql)) {
        $yongjin = $info['amount'] * 100;
        $tsql = "update `#@__member` set yongjin = yongjin + '$yongjin' where id = '{$info['uid']}'";
        $dosql->ExecNoneQuery($tsql);
        ShowMsg('拒绝成功');
        exit;
    }

}



//修改提现记录
else if ($action == 'update') {
    
    $withdraw = $dosql->GetOne("SELECT * FROM #@__withdraw_record WHERE id={$id}");
    
    /*
    if(!$alipayAccount){
        ShowMsg('支付宝账号不能为空', '-1');
        exit();
    }
    
    if (!$truename) {
        ShowMsg('真实姓名不能为空！', '-1');
        exit();
    }
    
    if (!$amount) {
        ShowMsg('提现金额不能为空！', '-1');
        exit();
    }
    */
    
    $sql = "UPDATE #@__withdraw_record SET reason='{$reason}'";
    
    if(!$withdraw['status'] && isset($status)){
        $sql .= ",status='{$status}'";
    }
    
    $sql .= " WHERE id={$id}";
    
    if ($dosql->ExecNoneQuery($sql)) {
        header("location:$gourl");
        exit();
    }
}

//批量审核
else if ($action == 'upall2'){
    $checkid = isset($checkid) ? $checkid : '';
    $status = isset($status) ? $status : '';
    if(!$checkid){
        ShowMsg('没有选中任何信息');
        exit();
    }
    if($status != 1 && $status != 2){
        ShowMsg('参数错误');
        exit();
    }
    $checkid = implode(',', $checkid);
    if($dosql->ExecNoneQuery("UPDATE #@__withdraw_record SET status={$status} WHERE id IN ({$checkid})")){
        header("location:$gourl");
        exit();
    }
}
//

//无条件返回
else {
    header("location:$gourl");
    exit();
}
?>