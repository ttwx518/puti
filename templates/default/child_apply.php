<?php require_once TMPL_DIR . 'public/new_header.php'; ?>
<script src="<?php echo STATIC_PATH; ?>/new_html/js/ajaxupload.3.5.js"></script>
<body>

<header><a href="javascript:history.back();" class="back"></a><span class="title">种子活动申请</span></header>
<section class="main">
    <section class="b_g p20 application chilid_shenqing">
    	<form action="index.php?c=child_apply&a=save_apply" method="post" onsubmit=" return check_data(); " id="my_forms">
    		<ul>
                <li>
                    <div class="item_tit">儿童姓名：</div>
                    <div class="item_con"><input name="title" id="title" type="text" placeholder="请输入儿童姓名"/></div>
                </li>
                <li>
                    <div class="item_tit">性      别：</div>
                    <div class="item_con">
                        <select name="sex"  id="sex">
                            <option value="">请选择</option>
                            <option value="0">男</option>
                            <option value="1">女</option>
                        </select>
                    </div>
                </li>
                <li>
                    <div class="item_tit">儿童年龄：</div>
                    <div class="item_con"><input name="age" id="age" type="text" placeholder="请输入儿童年龄"/></div>
                </li>
                <li>
                    <div class="item_tit">身份证号：</div>
                    <div class="item_con"><input name="id_no" id="id_no" type="text" placeholder="请输入身份证号"/></div>
                </li>
                <li>
                    <div class="item_tit">地      址：</div>
                    <div class="item_con"><input name="address" id="address" type="text" placeholder="请输入地址"/></div>
                </li>
                <li>
                    <div class="item_tit">监护人姓名：</div>
                    <div class="item_con"><input name="guardian_name" id="guardian_name" type="text" placeholder="请输入监护人姓名"/></div>
                </li>
                <li>
                    <div class="item_tit">监护人联系方式：</div>
                    <div class="item_con"><input type="text" name="guardian_mobile" id="guardian_mobile" placeholder="请输入监护人联系方式"/></div>
                </li>
                <li>
                    <div class="item_tit">监督机构：</div>
                    <div class="item_con"><input type="text" name="oversight_bodies" id="oversight_bodies" placeholder="请输入监督机构"/></div>
                </li>
                <li>
                    <div class="item_tit">监护人联系地址：</div>
                    <div class="item_con"><input type="text" name="guardian_address" id="guardian_address" placeholder="请输入监护人联系地址"/></div>
                </li>
                 <li>
                    <div class="item_tit">联系方式：</div>
                    <div class="item_con"><input type="text" name="mobile" id="mobile"  placeholder="请输入联系方式"/></div>
                </li>
                <li>
                    <div class="item_tit">贫困儿童介绍：</div>
                    <div class="item_con"><textarea name="description" id="description" placeholder="请输入贫困儿童介绍"></textarea></div>
                </li>
                <li class="item_pic">
                    <div class="item_tit">上传照片：</div>
                    <input type="hidden" name="picurl" value="" id="picurl"/>
                    <div class="item_con"  id="upload2" ><a href="javascript:void(0);"></a></div>
                </li>
        	</ul>
        	<div class="submit"><button type="button" id="submit" class="br5 b_a2 col_f combtn ">申请提交</button></div>
       	</form>
    </section>	
    <section class="article shenqing">
            <div class="br20 b_d inner_active_intro">
                <div class="fs36 col_78 contit">上海爱心认购活动介绍</div>
                <div class="p30 fs28 info">
                    <p>2010年6月1日“关注孤儿，呼唤爱——中国品牌童装爱心之旅”更名为“关注儿童，呼唤爱”。“关注儿童，呼唤爱”是由中国品牌童装网主办，中国品牌服装网和时尚126商城承办，于2007年11月1日起开展的，一次大规模、大范围、众多品牌企业联手参与，以改善全国57.3万贫困儿童的生活和学习条件，让贫困儿童健康快乐成长的大型慈善爱心活动。</p>
                </div>
            </div>
   		</section>
</section>

<script type="text/javascript">

    var btnUpload = $('#upload2');

    new AjaxUpload(btnUpload, {
        action: 'index.php?c=child_apply&a=child_upload',
        name: 'uploadfile',
        responseType: 'json',

        onSubmit: function(file, ext) {

            if (ext && /^(jpg|png|jpeg|gif|bmp)$/.test(ext)) {
                this.setData({
                    'info': '文件类型为图片'
                });
            } else {
                alert('非图片类型文件，请重传');
                return false;
            }
            // $('#divpicview2').html('<font class="red">文件上传中...</font>');

        },
        onComplete: function(file, response) {

            if (response.success) {
                var img_path = "<img src='" +  response.imgpath + "' />";
                $("#upload2").html(img_path);
                $('#picurl').val(response.imgpath);

            } else {
                alert(response.message);
            }
            // this.disable();
        }
    });


    function check_data() {
        var title = $("#title").val();
        var sex = $("#sex").val();
        var age = $("#age").val();
        var id_no = $("#id_no").val();
        var address = $("#address").val();
        var guardian_name = $("#guardian_name").val();
        var guardian_mobile = $("#guardian_mobile").val();
        var oversight_bodies = $("#oversight_bodies").val();
        var guardian_address = $("#guardian_address").val();
        var mobile = $("#mobile").val();
        var description = $("#description").val();
        var picurl = $("#picurl").val();

        if(title == ''){
            alert("请输入儿童姓名");
            return false;
        } else if(sex == ''){
            alert(" 请选择性别");
            return false;
        } else if(age == ''){
            alert(" 请输入年龄");
            return false;
        } else if(id_no == ''){
            alert(" 请输入身份证号");
            return false;
        } else if(address == ''){
            alert(" 请输入地址");
            return false;
        } else if(guardian_name == ''){
            alert(" 请输入监护人姓名");
            return false;
        } else if(guardian_mobile == ''){
            alert(" 请输入监护人联系方式");
            return false;
        } else if(oversight_bodies == ''){
            alert(" 请输入监督机构");
            return false;
        } else if(guardian_address == ''){
            alert(" 请输入监护人联系地址");
            return false;
        } else if(mobile == ''){
            alert(" 请输入联系方式");
            return false;
        } else if(description == ''){
            alert(" 请输入贫困儿童介绍");
            return false;
        } else if(picurl == ''){
            alert(" 请上传照片");
            return false;
        } else {
            return true;
        }

    }

$(".submit").click(function(){
    $("#my_forms").submit();
});


</script>



</body>
</html>
