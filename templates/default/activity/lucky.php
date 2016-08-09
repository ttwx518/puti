<?php
$c_uid = $userInfo['id'];

$r_user = $userInfo;
  
$uid=$r_user["id"];
$username=$r_user["id"];
$today=strtotime(date("Y-m-d"));

$order=$dosql->GetOne("SELECT auid,id FROM `#@__goodsorder` WHERE id= ".$id);
if(empty($order) || empty($order['auid'])){
    return false;
}
$goodsitem = $dosql->GetOne("SELECT * FROM `#@__goodsorderitem` WHERE orderid={$id}");
$infolist = $dosql->GetOne("SELECT * FROM `#@__infolist` WHERE id={$goodsitem['gid']}");

// 判断是否抽奖
$tj=1;
$lottery = $dosql->GetOne("SELECT * FROM `#@__lottery` WHERE uid={$uid} and aid={$infolist['id']}");
if(!empty($lottery)){
    $tj=0;
}

$action = isset($action) ? $action : '';

if($action=='lucky'){
    $base=1;
    $one=2;
    $two=10;
    $three=30;
    
    $one_left = $infolist['one_left'];
    $two_left = $infolist['two_left'];
    $three_left = $infolist['three_left'];
    
    $one_probability=$base + $one;
    $two_probability=$base + $one + $two;
    $three_probability=$base + $one + $two + $three;
    $rand=rand(0, 60);

    // 0,2,4  表示1,2,3等奖
    $result='-1';
    $grade=0;
    if ($base<=$rand && $rand<$one_probability){
        // 判断是否超过
        $result = '0';
    }

    else if ($one_probability && $rand<$two_probability){
        $result = '2';
    }

    else if ($two_probability && $rand<$three_probability){
        $result = '4';
    }
    
    // 判断是否有奖 1
    $lottery = $dosql->GetOne("SELECT count(id) as count FROM `#@__lottery` WHERE aid={$infolist['id']} and grade=1");
    if($lottery['count'] >= $infolist['one_left']){
        $result='-1';
    }
    // 判断是否有奖 2
    $lottery = $dosql->GetOne("SELECT count(id) as count FROM `#@__lottery` WHERE aid={$infolist['id']} and grade=2");
    if($lottery['count'] >= $infolist['two_left']){
        $result='-1';
    }
    // 判断是否有奖 3
    $lottery = $dosql->GetOne("SELECT count(id) as count FROM `#@__lottery` WHERE aid={$infolist['id']} and grade=3");
    if($lottery['count'] >= $infolist['three_left']){
        $result='-1';
    }

    $list=array('1','3','5','6');
    if($result=='-1'){
        $result=$list[rand(0,3)];
    }
    
    $posttitme = time();
    if($result==='0'){
        $grade=1;
        $result_desc = $infolist['one_desc'];
    }else if ($result==='2') {
        $grade=2;
        $result_desc = $infolist['two_desc'];
    }else if ($result==='4') {
        $grade=3;
        $result_desc = $infolist['three_desc'];
    }else{
        $result_desc = '';
    }
    $sql = "INSERT INTO `#@__lottery` (`uid`, `aid`,`orderid`,`grade`,`posttime`,`result_desc`,`checkinfo`) VALUES ($uid, {$infolist['id']} ,{$order['id']},$grade,$posttitme,'{$result_desc}', '0')";
    $dosql->ExecNoneQuery($sql);
    
    echo $result;
    exit();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
    <title>活动抽奖</title>
    <link rel="stylesheet" href="<?php echo STATIC_PATH;?>css/lucky.css" type="text/css" media="all" />

    <script src="<?php echo STATIC_PATH;?>js/jquery.js"></script>

    <script src="<?php echo STATIC_PATH;?>js/lucky.js"></script>

</head>

<body>
    <section class="wrapper">
        <section class="lottery" >
            <div id="lottery">
                <img id="imgs" src="<?php echo STATIC_PATH;?>images/disc-rotate.gif" viewbox="0 0 352 30" style="position: absolute; left: 36px; top: 36px; width: 236px; height: 236px;" class="image" />
                <div class="arrow">
                </div>
                <div class="lot-btn first">
                    <span></span>
                </div>
            </div>
        </section>

        <section class="codeshow" style="margin: 20px 15px 0">
            <h2 class="border">参加活动[<?php echo $infolist['title']?>],即可参与抽奖
            <br><?php echo empty($tj)?"该活动中您已经参加过抽奖了！":"您还没有抽奖,赶紧去抽奖把！";?></h2>
            <input type="hidden" name="tj" id='tj' value="<?php echo $tj?>" autocomplete=off >
            <div class="mt10 win">
                <h3>抽奖说明：</h3>
                <p>一等奖：<?php echo $infolist['one_desc'];?></p>
                <p>二等奖：<?php echo $infolist['two_desc'];?></p>
                <p>三等奖：<?php echo $infolist['three_desc'];?></p>
            </div>
            <div class="mt10 win">
                <h3>活动内容：</h3>
                <?php echo $infolist['title'];?>
            </div>
            <div class="mt10 win" style="margin-bottom: 20px;">
                <h3>活动规则：</h3>
                <span>参加活动即可抽奖一次,中奖后我们会将礼品邮寄给你!</span>
            </div>
           <!--  <div class="mt10 win">
                <h3>中奖记录 <a href="index.php?c=activity&a=lucky_list"> [点击查看] </a></h3>
            </div> -->
        </section>

        <script type="text/javascript" src="<?php echo STATIC_PATH;?>js/jQueryRotate.2.2.js"></script>
        <script>$(function() {
                $(".lot-btn").click(function(){
                    var st ="";
                    var one_left = parseInt(<?php echo $infolist['one_left'];?>);
                    var two_left = parseInt(<?php echo $infolist['two_left'];?>);
                    var three_left = parseInt(<?php echo $infolist['three_left'];?>);
                    if($('#tj').val()<=0){
                        alert("该活动中您已经参加过抽奖了！");
                        return false;
                    }

                    if ($('#lock').val()==1){
                        return false;
                    }
                    $('#lock').val(1);
                    $.ajax({
                        url  : 'index.php?c=activity&a=lucky&id='+'<?php echo $id;?>',
                        type : 'post',
                        data : {'action':'lucky'},
                        dataType:'html',
                        success:function(data){
                            rand=data*1;
                            i = 0;
                            switch(rand)
                            {
                                case 0: g = "恭喜获得一等奖"; v=1;
                                    break;
                                case 1: g = "再接再励";  v=4;
                                    break;
                                case 2: g = "恭喜获二等奖";  v=2;
                                    break;
                                case 3: g = "要加油哦！";  v=4;
                                    break;
                                case 4: g = "恭喜获三等奖";  v=3;
                                    break;
                                case 5: g = "不要灰心！";  v=4;
                                    break;
                                case 6: g = "谢谢参与！";  v=4;
                                    break;
                                default: g='系统错误！'; v=0;
                            }

                            setTimeout("shows(g)",10000);
                            //if($("#hascode").val()==""){
                            //setTimeout("location.href='choujiang.php?cid=13&code="+rand+"'",12000);
                            //}
                            t = 2880 +rand*51;
                            for (var i = 0; i <= 10000; i++) {

                                $("#imgs").rotate({
                                    angle:0,
                                    animateTo: i,
                                    duration: 10000
                                });
                                if (i >= t) {
                                    break;
                                }
                            }
                        }
                    });



                })


            });

            function shows(g){
                var tj = $('#tj').val();
                tj--;
                $('#tj').val(tj);
                str = "剩余抽奖次数："+tj+" "+g;
                $('#lock').val(0);
                alert(g);
                $('.codeshow h2').html(str);
            }
        </script>

    </section>
</body>

</html>