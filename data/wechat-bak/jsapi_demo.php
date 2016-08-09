<?php
include "wechat.class.php";
include 'errCode.php';

$opt = array(
        'appid'=>'wxb82a5dbccfcd523e',	//填写高级调用功能的appid
        'appsecret'=>'65fddaa4d166932481c1d27c832b9b05',//填写高级调用功能的密钥
);

$we = new Wechat($opt);
//$auth = $we->checkAuth();
// $js_ticket = $we->getJsTicket();
// if (!$js_ticket) {
// 	echo "获取js_ticket失败！<br>";
//     echo '错误码：'.$we->errCode;
//     echo ' 错误原因：'.ErrCode::getErrText($weObj->errCode);
//     exit;
// }
// $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
// $js_sign = $we->getJsSign($url);


// 生成菜单
$newmenu =  array (
         'button' => array (
//            0 => array (
//              'name' => '种子活动',
//                'sub_button' => array (
//                    0 => array (
//                        'type' => 'view',
//                        'name' => '种子活动',
//                        'url' => 'http://new.weixin66.net/puti/index.php?c=activity',
//                    ),
//                    1 => array (
//                        'type' => 'view',
//                        'name' => '活动概括',
//                        'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=infodetails&id=1',
//                    ),
//                    2 => array (
//                        'type' => 'view',
//                        'name' => '活动规则',
//                        'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=infodetails&id=2',
//                    ),
//                    3 => array (
//                        'type' => 'view',
//                        'name' => '活动动态',
//                        'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=activitylist&clsid=5',
//                    ),
//                    4 => array (
//                        'type' => 'view',
//                        'name' => '活动申请',
//                        'url' => 'http://new.weixin66.net/puti/index.php?c=activity&a=apply',
//                    )
//                )
//            ),
         0 => array (
             'type' => 'view',
             'name' => '种子活动 ',
             'url' => 'http://new.weixin66.net/puti/index.php?c=activity',
         ),
           1 => array (
             'name' => '种子商城',
               'sub_button' => array (
                   0 => array (
                       'type' => 'view',
                       'name' => '种子商城',
                       'url' => 'http://new.weixin66.net/puti/index.php',
                   ),
                   1 => array (
                       'type' => 'view',
                       'name' => '企业简介',
                       'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=infodetails&id=3',
                   ),
                   2 => array (
                       'type' => 'view',
                       'name' => '文化理念',
                       'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=infodetails&id=5',
                   ),
                   3 => array (
                       'type' => 'view',
                       'name' => '会员须知',
                       'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=infodetails&id=4',
                   ),
                   4 => array (
                       'type' => 'view',
                       'name' => '联系客服',
                       'url' => 'http://new.weixin66.net/puti/index.php?c=info&a=infodetails&id=6',
                   ),
               )
           ),
         2 => array (
             'type' => 'view',
             'name' => '种子会员 ',
             'url' => 'http://new.weixin66.net/puti/index.php?c=member',
         ),
          ),
     );
$we->createMenu($newmenu);
exit();

echo "------start------";
echo "<br>";
// print_r($js_ticket);
// echo "<br>";
// $qr_ticket = $we->getQRCode("1111111111111111");
// print_r($qr_ticket);
// echo "<br>";
// $qr_url = $we->getQRUrl($qr_ticket['ticket']);
// print_r($qr_url);
echo "<br>";
echo "------end------";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>JS-SDK</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" href="style.css?ts=1420775603">
</head>
<body ontouchstart="">
<div class="wxapi_container">
</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<script>
  wx.config({
      debug: false,
      appId: '<?php echo $js_sign['appid']; ?>', // 必填，公众号的唯一标识
      timestamp: <?php echo $js_sign['timestamp']; ?>, // 必填，生成签名的时间戳，切记时间戳是整数型，别加引号
      nonceStr: '<?php echo $js_sign['noncestr']; ?>', // 必填，生成签名的随机串
      signature: '<?php echo $js_sign['signature']; ?>', // 必填，签名，见附录1
      jsApiList: [
        'checkJsApi',
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onRecordEnd',
        'playVoice',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
      ]
  });
</script>
<script src="jsapi-demo-6.1.js?ts=<?php echo $timestamp; ?>"> </script>
</html>