<?php
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
 */
include_once("../../include/config.inc.php");
include_once("./WxPayPubHelper/WxPayPubHelper.php");

//使用jsapi接口
$jsApi = new JsApi_pub();

$ordernum = isset($ordernum) ? $ordernum : '';

//查询订单信息
$orderInfo = $dosql->GetOne("SELECT o.*,m.openid FROM #@__goodsorder o LEFT JOIN #@__member m ON o.uid=m.id WHERE o.ordernum='{$ordernum}'");

if (!isset($orderInfo) || !is_array($orderInfo) || empty($orderInfo)) {
    ShowMsg("未查询到相关订单!", $cfg_weburl . "index.php?c=member");
    exit();
}

$checkinfo = explode(',', $orderInfo['checkinfo']);
if(in_array('payment', $checkinfo)){
    ShowMsg("订单已支付,请勿重复支付!", $cfg_weburl . "index.php?c=member");
    exit();
}

if(in_array('cancel', $checkinfo)){
    ShowMsg("订单已取消,不可支付!", $cfg_weburl . "index.php?c=member");
    exit();
}

//=========步骤1：网页授权获取用户openid============
//通过code获得openid
if (!isset($_GET['code'])) {
    //触发微信返回code码
    $url = $jsApi->createOauthUrlForCode(WxPayConf_pub::JS_API_CALL_URL . "?ordernum=" . $ordernum);
    Header("Location: $url");
} else {
    //获取code码，以获取openid
    $code = $_GET['code'];
    $jsApi->setCode($code);
    $openid = $jsApi->getOpenId();
}

//=========步骤2：使用统一支付接口，获取prepay_id============
//使用统一支付接口
$unifiedOrder = new UnifiedOrder_pub();

//设置统一支付接口参数
//设置必填参数
//appid已填,商户无需重复填写
//mch_id已填,商户无需重复填写
//noncestr已填,商户无需重复填写
//spbill_create_ip已填,商户无需重复填写
//sign已填,商户无需重复填写
$unifiedOrder->setParameter("openid", "$openid"); //商品描述
$unifiedOrder->setParameter("body", "$cfg_webname"); //商品描述
//自定义订单号，此处仅作举例
$timeStamp = time();
$totalFee = $orderInfo['amount'] * 100;//$orderInfo['amount'] * 100;
$unifiedOrder->setParameter("out_trade_no", $orderInfo['ordernum']); //商户订单号 
$unifiedOrder->setParameter("total_fee", $totalFee); //总金额
$unifiedOrder->setParameter("notify_url", WxPayConf_pub::NOTIFY_URL); //通知地址 
$unifiedOrder->setParameter("trade_type", "JSAPI"); //交易类型
//非必填参数，商户可根据实际情况选填
//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
//$unifiedOrder->setParameter("device_info","XXXX");//设备号 
//$unifiedOrder->setParameter("attach","XXXX");//附加数据 
//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
//$unifiedOrder->setParameter("openid","XXXX");//用户标识
//$unifiedOrder->setParameter("product_id","XXXX");//商品ID

$prepay_id = $unifiedOrder->getPrepayId();

//=========步骤3：使用jsapi调起支付============
$jsApi->setPrepayId($prepay_id);

$jsApiParameters = $jsApi->getParameters();

?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
        <title>微信安全支付</title>
        <script type="text/javascript">
            callpay();
            //调用微信JS api 支付
            function jsApiCall() {
                WeixinJSBridge.invoke(
                        'getBrandWCPayRequest',
                        <?php echo $jsApiParameters; ?>,
                        function(res) {
                            //WeixinJSBridge.log(res.err_msg);
                            //alert(res.err_code+res.err_desc+res.err_msg);
                            if (res.err_msg == "get_brand_wcpay_request:ok") {
                                location.href = "<?php echo $cfg_weburl; ?>index.php?c=member&a=paySuccess&ordernum=<?php echo $orderInfo['ordernum']; ?>";
                            } else {
                                location.href = "<?php echo $cfg_weburl; ?>index.php?c=member&a=order&flag=payment";
                            }
                        });
            }
            function callpay(){
                if (typeof WeixinJSBridge == "undefined") {
                    if (document.addEventListener) {
                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                    } else if (document.attachEvent) {
                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                    }
                } else {
                    jsApiCall();
                }
            }
        </script>
    </head>
    <body>
    </body>
</html>