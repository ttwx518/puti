<?php

if (!defined('IN_PHPMYWIND'))
    exit('Request Error!');

$docart = new cart();

class cart {

    function __construct() {
        $this->Init();
    }

    function cart() {
        $this->__construct();
    }

    function Init() {

        //初始化类
    }

    /**
     * 加入购物车
     * @param int $gid 商品id
     * @param int $num 商品数量
     * @return int $totalNum 购物车商品总数
     */
    public function addCart($gid, $num,$type = '-1') {
        global $dosql;
        $addgoods = $dosql->GetOne("SELECT id,typepid FROM #@__goods WHERE id={$gid}");
        $cart = $this->getCookieCart();
        if (!$cart) {
          //  $cart = array($gid => $num);
            $cart = array($gid => array('num' => $num, 'type' => $type )); //$type 普通商品 -1  爱心购 1  认养 2 认购 3
        } else {
            if (array_key_exists($gid, $cart)) {
              //  $cart[$gid] += $num;
                $cart[$gid]['num'] += $num;
            } else {
                $cart[$gid]['num'] = $num;
            }
        }
        $totalNum = 0;
        foreach ($cart as $k=>$v) {
            // $totalNum += $v;
            $totalNum += $v['num'];
            $goods = $dosql->GetOne("SELECT id,typepid FROM #@__goods WHERE id={$k}");
            if(isDuiHuanOrGift($addgoods['typepid']) && $goods['typepid'] != $addgoods['typepid']){ //4 或 20
                unset($cart[$k]);
            }elseif(!isDuiHuanOrGift($addgoods['typepid']) && isDuiHuanOrGift($goods['typepid'])){// 否则
                unset($cart[$k]);
            }
        }

        setcookie('cart', AuthCode(serialize($cart), 'ENCODE'));
        return $totalNum;
    }
    
    /**
     * 立即购买
     * @param int $gid 商品id
     * @param int $num 商品数量
     * @return int $totalNum 购物车商品总数
     */
    public function buyNow($gid, $num,$type = '-1') {
        global $dosql;
        $addgoods = $dosql->GetOne("SELECT id,typepid FROM #@__goods WHERE id={$gid}");
        $totalNum = 0;
        $cart = $this->getCookieCart();
        foreach ($cart as $k=>$v) {
          //  $totalNum += $v;
            $totalNum += $v['num'];
            $goods = $dosql->GetOne("SELECT id,typepid FROM #@__goods WHERE id={$k}");
            if(isDuiHuanOrGift($addgoods['typepid']) && $goods['typepid'] != $addgoods['typepid']){ //4 或 20
                unset($cart[$k]);
            }elseif(!isDuiHuanOrGift($addgoods['typepid']) && isDuiHuanOrGift($goods['typepid'])){// 否则
                unset($cart[$k]);
            }
        }
        
        if ($num == 0) {
            unset($cart[$gid]);
        }else{
           // $cart[$gid] = $num;
            $cart[$gid]['num'] = $num;
            $cart[$gid]['type'] = $type;
        }
        setcookie('cart', AuthCode(serialize($cart), 'ENCODE'));
        
        return $totalNum;
    }
    
    /**
     * 编辑购物车
     * @param int $gid 商品id
     * @param int $num 商品数量
     * @return array $cart 购物车明细
     */
    public function editCart($gid, $num) {
        global $dosql;
        $cart = $this->getCookieCart();
        if ($num == 0) {
            unset($cart[$gid]);
        }else{
           // $cart[$gid] = $num;
            $cart[$gid]['num'] = $num;
        }
        setcookie('cart', AuthCode(serialize($cart), 'ENCODE'));
        return $this->getCart($cart);
    }

    /**
     * 获取购物车
     * @return array $cart COOKIE购物车
     */
    public function getCookieCart() {
        return unserialize(getCookie('cart'));
    }

    /**
     * 获取购物车明细与统计信息
     * @global object $dosql
     * @param int $uid
     * @return array
     */
    public function getCart($cart) {
        global $dosql,$cfg_freight_free,$cfg_freight,$userInfo;
        $returnArr = array('items' => array(), 'totalNum' => 0, 'totalAmount' => 0, 'totalWeight' => 0, 'totalFreight' => 0,'minYongjin'=>0,'minJifen'=>0);

        if (!empty($cart)) {
            $cart_goodIds = implode(',', array_keys($cart));
            $dosql->Execute("SELECT typepid,typeid,id,picurl,title,goodsid,flag,salesprice,salesprice_dashi,salesprice_tianshi,payfreight,freight,weight,directCommission,indirectCommission,description,housenum,salenum,seed_number FROM `#@__goods` WHERE id IN ({$cart_goodIds}) AND checkinfo='true' AND delstate=''");
            while ($row = $dosql->GetArray()) {
                $price = calcPrice($row);
                if(!empty($price)){
                    $row['salesprice'] = $price;
                }
                $row['flag'] = explode(',', $row['flag']);
                $row['indirectCommission'] = unserialize($row['indirectCommission']);

               // $buyNum = $cart[$row['id']];
                $buyNum = $cart[$row['id']]['num'];
                $returnArr['items'][$row['id']] = $row;
                $returnArr['items'][$row['id']]['cart_type'] = $cart[$row['id']]['type']!='undefined' ? $cart[$row['id']]['type'] : '-1';
                $returnArr['items'][$row['id']]['buyNum'] = $buyNum;
                $returnArr['totalNum'] += $buyNum;
                if($row['typepid'] == 4 ){
                    $returnArr['totalAmount'] += ($row['seed_number'] * $buyNum);
                }else {
                    $returnArr['totalAmount'] += ($row['salesprice'] * $buyNum);
                }

                $returnArr['order_type'] = $cart[$row['id']]['type']!='undefined' ? $cart[$row['id']]['type'] : '-1';

                // 运费计算
                if($returnArr['totalAmount'] >= $cfg_freight_free){
                    $returnArr['yunfei'] = 0;//'免运费';
                }else{
                    $returnArr['yunfei'] = $cfg_freight;
                }
                // 计算使用的种子数量
                $returnArr['maxconmision'] = min($userInfo['yongjin'], ($returnArr['totalAmount']+$returnArr['yunfei']));

                // 判断积分商城的商品, 需要单独计算, 需要足够的积分才能购买
                if($row['typepid']==4){
                    $returnArr['minYongjin'] += ($row['salesprice'] * $buyNum);
                }
                if($row['typepid']==20){
                    $returnArr['minJifen'] += ($row['salesprice'] * $buyNum);
                    $returnArr['maxconmision'] = min($userInfo['jifen'], ($returnArr['totalAmount']+$returnArr['yunfei']));
                }
//                 $returnArr['totalWeight'] += ($row['weight'] * $buyNum);
//                 if($row['payfreight'] == '0'){
//                     $returnArr['totalFreight'] += $row['freight'];
//                 }
            }
        }
        return $returnArr;
    }

}
