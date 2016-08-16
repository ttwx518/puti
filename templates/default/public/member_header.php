
<section class="user_header">
    <div class="table">
        <div class="table-cell v-t item_face">
            <div class="circle face"><img src="<?php echo $userInfo['wechat_headimgurl'] ? $userInfo['wechat_headimgurl'] : STATIC_PATH.'images/avator.png'; ?>"></div>
        </div>
        <div class="table-cell v-t item_con">
            <div class="fs36 user_name"><?php echo empty($userInfo['wechat_nickname'])?'无':$userInfo['wechat_nickname'];?></div>
            <div class="user_num"><span>会员编号：<i> <?php echo $userInfo['mem_number'];?></i></span><span>推荐人：<i><?php echo $recName; ?></i></span></div>
            <div class="user_has">拥有种子：<i><?php echo $userInfo['yongjin']; ?></i>颗</div>
        </div>
    </div>
    <ul class="has_seed">
        <li><i class="i1"></i>金种子<span><?php echo $userInfo['golden_seed'];?></span>颗</li>
        <li><i class="i2"></i>银种子<span><?php echo $userInfo['silver_seed'];?></span>颗</li>
        <li><i class="i3"></i>铜种子<span><?php echo $userInfo['copper_seed'];?></span>颗</li>
    </ul>
</section>
