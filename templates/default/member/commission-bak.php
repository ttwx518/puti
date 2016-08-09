<!doctype html>
<html>
    <?php require_once TMPL_DIR . 'public/header.php'; ?>
    <body>
        <section class="wrap">
            <header class="header c">
                <a href="javascript:history.go(-1)" class="back"></a>
                佣金管理
            </header>
            <section class="main">
                <div class="member_bg">
                    <div class="avator"><img src="<?php echo $userInfo['wechat_headimgurl'] ? $userInfo['wechat_headimgurl'] : STATIC_PATH.'images/avator.png'; ?>" alt="" style="border-radius:39px" /></div>
                    <div class="vip fs10"><?php echo $userInfo['wechat_nickname']; ?><br/>等级：<?php echo $userInfo['groupname']; ?></div>
                </div>
                <div class="member_info c noLast fs10">
                    <a href="index.php?c=member&a=commission&flag=ktx"<?php if($flag=='ktx'): echo ' class="red"'; endif; ?>>可提现</a>
                    <a href="index.php?c=member&a=commission&flag=ytx"<?php if($flag=='ytx'): echo ' class="red"'; endif; ?>>已提现</a>
                    <a href="index.php?c=member&a=commission&flag=ljsr"<?php if($flag=='ljsr'): echo ' class="red"'; endif; ?>>累计收入</a>
                    <a href="index.php?c=member&a=commission&flag=thmx"<?php if($flag=='thmx'): echo ' class="red"'; endif; ?>>退货明细</a>
                </div>
                <!--可提现-->
                <?php if($flag == 'ktx'): ?>
                <div class="p10 bg_white line">可提现佣金余额：<i class="red f16fzb"><?php echo number_format($ktxAmount, 2); ?></i></div>
                <div class="mt10 form p10">
                    <?php if($success): ?>
                    <div class="successMsg"><?php echo $success; ?></div>
                    <?php endif; if($error): ?>
                    <div class="errorMsg"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form action="index.php?c=member&a=commission&flag=ktx" method="post">
                        <input type="text" name="alipayAccount" id="alipayAccount" value="<?php echo isset($alipayAccount) ? $alipayAccount : $userInfo['alipay_account']; ?>" class="input mt10" placeholder="支付宝账号" />
                        <input type="text" name="truename" id="truename" value="<?php echo isset($truename) ? $truename : $userInfo['truename']; ?>" class="input mt10" placeholder="真实姓名" />
                        <input type="text" name="amount" id="amount" value="" maxAmount="<?php echo $ktxAmount; ?>" class="input mt10" placeholder="提现金额" />
                        <div class="error"></div>
                        <div class="mt20 c">
                            <input type="submit" name="txSub" onclick="return member.checkTx();" value="申请提现" class="buttons_a" style="width:100%" />
                        </div>
                    </form>
                </div>
                <!--已提现-->
                <?php elseif($flag == 'ytx'): ?>
                <div class="p10 bg_white line">已提现金额：<i class="red f16fzb"><?php echo number_format($ytxAmount, 2); ?></i></div>
                <?php if($records['data']): ?>
                <table class="table bg_white mt5 c fs10">
                    <tr class="fs12">
                        <th>金额</th>
                        <th>日期</th>
                        <th>状态</th>
                    </tr>
                    <tbody id="list">
                    <?php echo $records['data']; ?>
                    </tbody>
                </table>
                <?php if($records['hasMore']): ?>
                <section class="loadMore">加载更多</section>
                <?php endif; else: ?>
                <div class="emptyMsg">暂无提现记录</div>
                <?php endif; ?>
                <!--累计收入-->
                <?php elseif($flag == 'ljsr'): ?>
                <div class="p10 bg_white line">累计收入：<i class="red f16fzb"><?php echo number_format($ljsrAmount, 2); ?></i></div>
                <?php if($records['data']): ?>
                <table class="table bg_white mt5 c fs10">
                    <tr class="fs12">
                        <th>金额</th>
                        <th>日期</th>
                        <th>状态</th>
                    </tr>
                    <tbody id="list">
                    <?php echo $records['data']; ?>
                    </tbody>
                </table>
                <?php if($records['hasMore']): ?>
                <section class="loadMore">加载更多</section>
                <?php endif; else: ?>
                <div class="emptyMsg">暂无收入记录</div>
                <?php endif; ?>
                <!--退货明细-->
                <?php elseif($flag == 'thmx'): ?>
                <div class="p10 bg_white line">累计退货：<i class="red f16fzb">100.00</i></div>
                <table class="table bg_white mt5 c fs10">
                    <tr class="fs12">
                        <th>单号</th>
                        <th>金额</th>
                        <th>日期</th>
                        <th>状态</th>
                    </tr>
                    <tr>
                        <td>xxxxx</td>
                        <td>21.00</td>
                        <td>2015-01-01 12：00</td>
                        <td>申请中</td>
                    </tr>
                </table>
                <?php endif; ?>
            </section>
        </section>
        <?php require_once TMPL_DIR . 'public/footer.php'; ?>
        <script>
            <?php if($flag == 'ytx'): ?>
            var page = 2;
            $(document).ready(function() {
                $('.loadMore').on('click',function(){
                    $.ajax({
                        type: "GET",
                        url: "ajax.php?action=getYtxList&page=" + page,
                        dataType: "json",
                        success: function(result) {
                            $('#list').append(result.data);
                            page += 1;
                            if (!result.hasMore)
                                $('.loadMore').remove();
                        }, complete: function() {

                        }
                    });
                });
            });
            <?php elseif($flag == 'ljsr'): ?>
            var page = 2;
            $(document).ready(function() {
                $('.loadMore').on('click',function(){
                    $.ajax({
                        type: "GET",
                        url: "ajax.php?action=getLjsrList&page=" + page,
                        dataType: "json",
                        success: function(result) {
                            $('#list').append(result.data);
                            page += 1;
                            if (!result.hasMore)
                                $('.loadMore').remove();
                        }, complete: function() {

                        }
                    });
                });
            });
            <?php endif; ?>
        </script>
    </body>
</html>