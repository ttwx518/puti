<?php 
   $f1=$f2=$f3=$f4=$f5=0;
   $curl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	if(strpos($curl,'c=activity')){
	    $f2=1;
	}elseif(strpos($curl,'c=info')){
	    $f2=1;
	}elseif(strpos($curl,'c=cart')){
	    $f3=1;
	}elseif(strpos($curl,'c=member')){
	    $f4=1;
	}else{
	    $f1=1;
	}
?>

    <footer>
        <a href="index.php" <?php if($f1) { ?>class="on" <?php } ?> ><i class="icon"></i>商城首页</a>
        <a href="index.php?c=activity&a=default" <?php if($f2) { ?>class="on" <?php } ?> ><i class="icon"></i>种子活动</a>
        <a href="index.php?c=cart" <?php if($f3) { ?>class="on" <?php } ?> ><i class="icon"></i>购物车</a>
        <a href="index.php?c=member" <?php if($f4) { ?>class="on" <?php } ?> ><i class="icon"></i>个人中心</a>
    </footer>

<link rel="stylesheet" href="<?php echo STATIC_PATH; ?>css/flexslider.css" type="text/css" media="screen" />
<script src="<?php echo STATIC_PATH; ?>js/jquery.flexslider.js"></script>
<?php if(isset($signPackage) && isset($shareInfo)): ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    // 微信配置
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $signPackage["appId"]; ?>', // 必填，公众号的唯一标识
        timestamp: <?php echo $signPackage["timestamp"]; ?>, // 必填，生成签名的时间戳
        nonceStr: '<?php echo $signPackage["nonceStr"]; ?>', // 必填，生成签名的随机串
        signature: '<?php echo $signPackage["signature"]; ?>', // 必填，签名，见附录1
        jsApiList: [
            // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'previewImage'
        ]
    });
    // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
    wx.ready(function() {
        
        //获取“分享到朋友圈”按钮点击状态及自定义分享内容接口
        wx.onMenuShareTimeline({
            title: '<?php echo $shareInfo['title']; ?>', // 分享标题
            link: '<?php echo $shareInfo['link']; ?>', // 分享链接
            imgUrl: '<?php echo $shareInfo['imgUrl']; ?>', // 分享图标
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });

        //获取“分享给朋友”按钮点击状态及自定义分享内容接口
        wx.onMenuShareAppMessage({
            title: '<?php echo $shareInfo['title']; ?>', // 分享标题
            desc: '<?php echo $shareInfo['desc']; ?>', // 分享描述
            link: '<?php echo $shareInfo['link']; ?>', // 分享链接
            imgUrl: '<?php echo $shareInfo['imgUrl']; ?>', // 分享图标
            type: '<?php echo $shareInfo['type']; ?>', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });
        
        //获取“分享到QQ”按钮点击状态及自定义分享内容接口
        wx.onMenuShareQQ({
            title: '<?php echo $shareInfo['title']; ?>', // 分享标题
            desc: '<?php echo $shareInfo['desc']; ?>', // 分享描述
            link: '<?php echo $shareInfo['link']; ?>', // 分享链接
            imgUrl: '<?php echo $shareInfo['imgUrl']; ?>', // 分享图标
            success: function () { 
               // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
               // 用户取消分享后执行的回调函数
            }
        });
        
        //获取“分享到腾讯微博”按钮点击状态及自定义分享内容接口
        wx.onMenuShareWeibo({
            title: '<?php echo $shareInfo['title']; ?>', // 分享标题
            desc: '<?php echo $shareInfo['desc']; ?>', // 分享描述
            link: '<?php echo $shareInfo['link']; ?>', // 分享链接
            imgUrl: '<?php echo $shareInfo['imgUrl']; ?>', // 分享图标
            success: function () { 
               // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });
    });
</script>
<?php endif; ?>