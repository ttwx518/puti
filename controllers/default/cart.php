<?php

//!$userInfo && redirectAuth('index.php?c=cart');
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(empty($userInfo)){
    redirectAuth($url);
}

// if(!$userInfo['recUid']){
//     ShowMsg('您未获得商品分销权!','-1');
// }

//获取购物车信息
$cookieCart = $docart->getCookieCart();
$cart = $docart->getCart($cookieCart);

//购物车提交
if(isset($cartSub)){
    $items = isset($items) ? $items : array();
    $buynums = isset($buynums) ? $buynums : array();
    $cart_type =  isset($cart_type) ? $cart_type : array();
    if(!$items || !$buynums){
        ShowMsg('请选择您需要结算的商品!');
    }

    $orderCart = array();
    foreach($items as $k => $v){
        if(empty($v)){
            unset($cookieCart[$k]);
        }else {
            $orderCart[$k] = array('num' => $buynums[$k], 'cart_type' =>$cart_type[$k] );
        }
    }
    setcookie('cart', AuthCode(serialize($cookieCart), 'ENCODE'));
    setcookie('orderCart', AuthCode(serialize($orderCart), 'ENCODE'));
    redirect('index.php?c=checkout');
}

$seo = setSeo('我的购物车', $cfg_keyword, $cfg_description);

?>