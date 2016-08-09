$(document).ready(function() {
	
	$(".loadMore").click(function(){
		location.href=$(this).find('a').attr('href');
	});
	
	$(document).on('click',"[data-href]",function(){
    	 var link = $(this).attr("data-href");
		 location.href = link;
    })
	
	//tab switcher
	$(".box .tab").click(function(){
		var e = $(this);
		var $t = $(this).attr("rel");
			e.parent().children(".tab").removeClass("selected");
			e.addClass("selected");
			e.parent().next(".box-content").children(".sub-content").hide();
			e.parent().next(".box-content").children("."+$t).show();
		
	})
	
	
	
//	$(".box_count .plus").click(function(){
//		$this = $(this);
//		v = parseFloat($this.prev().val());
//		$this.prev().val(v+1);
//	})
//	
//	
//	$(".box_count .minus").click(function(){
//		$this = $(this);
//		v = parseInt($this.next().val());
//		if(v>1){
//			$this.next().val(v-1);
//		}
//	})
	
	
	
	$(".no_last").each(function(){
		$(this).find("li:last").css({'border':'0'});
	})
	
	$("input[type='password'],input[type='text'],input[type='number'],textarea").focus(function(){
		$(".footer").hide();
		}
	)
	$("input[type='password'],input[type='text'],input[type='number'],textarea").blur(function(){
		$(".footer").fadeIn();
		}
	)

	
$(".select select").on('change',function() {
	var v = $(this).find("option:selected").text();
	$(this).parent().prev().html(v)
	})
	


//	$(".inner-cate-nav li").click(function(){
//		$(this).addClass("active").siblings().removeClass("active")
//		})
		

//	$(".buycart .item").each(function(){
//		$(this).find(".item-check .check").click(function(){
//			if(!$(this).parent().parent().hasClass('on')){
//				$(this).parent().parent().addClass("on");
//			}else{
//				$(this).parent().parent().removeClass("on");
//			}
//		})
//	})	
//	
//	
//	$(".cart-submit .check").click(function(){
//	if(!$(this).parent().hasClass('on')){
//		$(this).parent().addClass("on");
//		$($(".buycart-list .item")).addClass("on");
//		}else{
//			$(this).parent().removeClass("on");
//		$($(".buycart-list .item")).removeClass("on");
//			}
//	})
		
//$(".check-label input").each(function(){
//	var _this = $(this).parent();
//$(this).on("click",function(){
//if(!_this.hasClass("on")){
//		_this.addClass("on");
//		_this.find("input[type=check]").attr("checked",true)
//		_this.find("input[type=check]").prop("checked",true)
//				}
//			else {
//				_this.removeClass("on");
//				_this.find("input[type=check]").removeAttr("checked")
//				}
//}); 
//	})


$(".radio-label input").each(function(){
	var _this = $(this).parent();
$(this).on("click",function(){
if(!_this.hasClass("on")){
		_this.addClass("on");
		_this.find("input[type=radio]").attr("checked",true)
		_this.find("input[type=radio]").prop("checked",true)
				}
			else {
				_this.removeClass("on");
				_this.find("input[type=radio]").removeAttr("checked")
				}
}); 
	}) 
	

$(".order-confim-method .radio-label,.edit-address .radio-label,.deliver-goods-hd .radio-label,.choose-sex dd .radio-label").on("click",function(){
	$(this).addClass("on").parent().siblings().find(".radio-label").removeClass("on");
	})

$(".shop-byself-bd li").click(function(){
$(this).addClass("on").siblings().removeClass("on");
		})	

	// 精准购物
	$(".shopping_city .item-hd li").each(function (index) {
		$(this).click(function () {
			$(this).addClass("on").siblings().removeClass("on");
			$(".shopping_city .item-bd").show();
			$(".shopping_city .item-bd ul").slideUp().eq(index).slideDown();
		});
	});
	$(".shopping_city .item-bd .item-bg").click(function(){
		$(".shopping_city .item-bd ul").slideUp();
		$(this).parent().hide();
		$(".shopping_city .item-hd li").removeClass("on");
		$(".shopping_city .item-bd ul li").removeClass("on");
	});
	$(".shopping_city .item-bd ul li").click(function(){
		$(this).addClass("on").siblings().removeClass("on");
	});

	$(".returnTop").click(function(){
        var speed=200;//滑动的速度
        $('body,html').animate({ scrollTop: 0 }, speed);
        return false;
 	});
	
});




//jQuery(function(){
//
////tab
//function Tab(args){
//	var tabMenu = args.tabMenu;
//	var tabCont = args.tabCont;
//	var evt = args.evt || 'click'
//	tabMenu.eq(0).addClass('on');
//	tabCont.eq(0).show().siblings().hide();
//	tabMenu[evt](function(){
//		var _this = jQuery(this);
//		var _index = tabMenu.index(_this);
//		_this.addClass('on').siblings().removeClass('on');
//		tabCont.eq(_index).show().siblings().hide();
//		return false;
//	});
//}
//
//	
//	new Tab({
//			tabMenu : jQuery('.myOrder-tab li'),
//			tabCont : jQuery('.myOrder-content  .content '),
//			evt     : 'click'
//	});
//	
//	
//	new Tab({
//			tabMenu : jQuery('.goods-detail-tab li'),
//			tabCont : jQuery('.goods-detail-con  .goods-detail-content'),
//			evt     : 'click'
//	});
//	
//	 });  
function alert_Show(a,b,c,d){
	html = '<div class="alert_bg" onClick="alert_close(this)"><div class="alert"><div class="title c">'+a+'</div><div class="alert_content">'+b+'</div><div class="bar"><a href="javascript:void(0);" class="bar_bt bar_a">'+c+'</a> <a href="javascript:void(0);" class="bar_bt">'+d+'</a></div></div></div>';
	$(".alert_bg").remove();
	$("body").append(html);
}

function alert_close(t){
	$(t).fadeOut();
}


function ShowMessage(c){
	content =  "<div class='showmessage'>"+c+"</div>"
	$("body").append(content);
	$(".showmessage").fadeIn();
	setTimeout("HideMessage()", 2000);
}
function HideMessage(){
	$(".showmessage").fadeOut().remove();
}

