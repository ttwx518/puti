$(document).ready(function() {

    $(document).on('click', "[data-href]", function() {
        var link = $(this).attr("data-href");
        location.href = link;
    });

    $(".lazy .img").lazyload({//图片延迟加载
        placeholder: "images/loading.gif",
        effect: "fadeIn",
        threshold: 200
    });

    //tab switcher
    $(".box .tab").click(function() {
        var e = $(this);
        var $t = $(this).attr("rel");
        e.parent().children(".tab").removeClass("selected");
        e.addClass("selected");
        e.parent().next(".box-content").children(".sub-content").hide();
        e.parent().next(".box-content").children("." + $t).show();
    });
    
    $(".no_last").each(function() {
        $(this).find("li:last").css({'border': '0'});
    });
    
    $(".noLast").each(function() {
        $(this).find("a:last").css({'border': '0'});
    });

    $("input[type='password'],input[type='text'],input[type='number'],textarea").focus(function() {
        $(".footer").hide();
    });

    $("input[type='password'],input[type='text'],input[type='number'],textarea").blur(function() {
        $(".footer").fadeIn();
    });
    
    $(".again, .cars_bg .close").click(function() {
        $(".cars_bg").fadeOut();
    });

});

/**
 * 计算预期收益
 * @returns {undefined}
 */
function calculate(){
    var $dc = $('#dcNum'),
        $ic = $('#icNum'),
        dcNum = $dc.val(),
        icNum = $ic.val(),
        dc = $dc.attr('data-dc'),
        ic = $ic.attr('dc-ic');
    if(!validateRules.isIntege(dcNum)){
        alert('我的直销数量必须为大于零的整数');
        $dc.focus();
        return;
    }
    if(!validateRules.isNum1(icNum)){
        alert('平均每个分销商销量必须为大于等于零的整数');
        $ic.focus();
        return;
    }
    $('#yqsy').html((dcNum * dc + icNum * ic).toFixed(2));
}

function alert_Show(a, b, c, d) {
    var html = '<div class="alert_bg" onClick="alert_close(this)"><div class="alert"><div class="title c">' + a + '</div><div class="alert_content">' + b + '</div><div class="bar"><a href="javascript:void(0);" class="bar_bt bar_a">' + c + '</a> <a href="javascript:void(0);" class="bar_bt">' + d + '</a></div></div></div>';
    $(".alert_bg").remove();
    $("body").append(html);
}

function alert_close(t) {
    $(t).fadeOut();
}

function ShowMessage(c) {
    var content = "<div class='showmessage'>" + c + "</div>"
    $("body").append(content);
    $(".showmessage").fadeIn();
    setTimeout("HideMessage()", 2000);
}

function HideMessage() {
    $(".showmessage").fadeOut().remove();
}

