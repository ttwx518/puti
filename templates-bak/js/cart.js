var cart = {
    /**
     * 加入购物车
     * @param {int} id 商品id
     * @param {int} num 商品数量
     * @returns {undefined}
     */
    addCart: function(id, num) {
        if (!id){
            ShowMessage('参数错误');
            return;
        }
        if(!num){
            ShowMessage('请输入购买数量');
            return;
        }
        if(!validateRules.isIntege(num)){
            ShowMessage('购买数量必须为大于0的整数');
            return;
        }
        $.ajax({
            url: 'ajax.php?action=addCart&id=' + id + "&num=" + num,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                if (result.status) {
                    $(".cars_bg").fadeIn();
                    //ShowMessage('加入购物车成功');
                } else {
                    alert(result.msg);
                }
            }
        });
    },
    /**
     * 立即购买
     * @param {int} id 商品id
     * @param {int} num 商品数量
     * @returns {undefined}
     */
    buyNow: function(id, num){
        if (!id){
            ShowMessage('参数错误');
            return;
        }
        if(!num){
            ShowMessage('请输入购买数量');
            return;
        }
        if(!validateRules.isIntege(num)){
            ShowMessage('购买数量必须为大于0的整数');
            return;
        }
        $.ajax({
            url: 'ajax.php?action=buyNow&id=' + id + "&num=" + num,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                if (result.status) {
                    location.href='index.php?c=cart';
                } else {
                    alert(result.msg);
                }
            }
        });
    },
    /**
     * 编辑购物车
     * @param {int} id 商品id
     * @param {int} num 商品数量
     * @returns {undefined}
     */
    editCart: function(id, num) {
        var ret;
        $.ajax({
            url: 'ajax.php?action=editCart&id=' + id + '&num=' + num,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                ret = result;
            }
        });
        return ret;
    },
    /**
     * 订单信息变更
     * @param {int} postmodeId 配送方式id
     * @returns {undefined}
     */
    orderChange: function(postmodeId) {
        $.ajax({
            url: 'ajax.php?action=orderChange&postmodeId=' + postmodeId,
            async: false,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                if (result.status) {
                    $('#totalFreight').html('￥' + result.totalFreight.toFixed(2));
                    $('#totalAmount').html('￥' + result.totalAmount.toFixed(2));
                } else {
                    if (result.refresh) {
                        location.reload();
                    }
                }
            }
        });
    },
    /**
     * 订单提交验证
     * @returns {undefined}
     */
    checkCheckout: function() {
        var addressId = $('#addressId').val();
        if(addressId == 0){
            alert('请添加收货地址');
            return false;
        }
        var paymode = $("input[name='paymode']:checked").val();
        if(!paymode){
            alert('请选择支付方式');
            return false;
        }
        var postmode = $('#postmode').val();
        if(postmode == 0){
            alert('请选择配送方式');
            return false;
        }
        var isTax = $("input[name='isTax']:checked").val(),
            taxHead = $('#taxHead').val();
        if(isTax == 1 && !taxHead){
            alert('请填写发票抬头');
            return false;
        }
    }

}