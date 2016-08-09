$(document).ready(function() {
	//tab switcher
	$(".tab").click(function(){
		var e = $(this);
		var $t = $(this).attr("rel");
		
			e.parent().children(".tab").removeClass("selected");
			e.addClass("selected");
			e.parent().next(".box-content").children(".sub-content").hide();
			e.parent().next(".box-content").children("."+$t).show();
		
	})
	
	$(".cat_list2 li").click(function(){
		$(this).toggleClass("hover");	
		
	})
	
	
	$(".nav_2 a:last").addClass("nobg");
	
	$(".icons_pannel").click(function(){
		if($(this).hasClass("icons_pannel_open")){
			//$("header, .wrapper, footer").animate({"margin-left":"0"});
			$("header, .wrapper, footer").removeClass("wrapper_pannel");
			$(this).removeClass("icons_pannel_open");
			$(".pannel").removeClass("pannel_open");
		}else{
			//$("header, .wrapper, footer").animate({"margin-left":"-160px"});
			$(this).addClass("icons_pannel_open");
			$(".pannel").addClass("pannel_open");
			$("header, .wrapper, footer").addClass("wrapper_pannel");
			
		}
	})
	
	$("body").delegate(".wrapper.wrapper_pannel, footer.wrapper_pannel","click",function(){
		//$("header, .wrapper, footer").animate({"margin-left":"0"});
		$("header, .wrapper, footer").removeClass("wrapper_pannel");
		$(".icons_pannel").removeClass("icons_pannel_open");
		$(".pannel").removeClass("pannel_open");
	})
	
	
	$(".box_count .plus").click(function(){
		$this = $(this);
		v = parseFloat($this.prev().val());
		k = parseInt($this.prev().attr('id'));
		$this.prev().val(v+1);
		$.ajax({
	        url  : 'car.php?a=plus',
	        type : 'post',
	        data : {'key':k,'quantity':v+1},
	        dataType:'html',
	        //beforeSend:function(){},
	        success:function(data){
	        }
	    });
	})
	
	
	$(".box_count .minus").click(function(){
		$this = $(this);
		v = parseFloat($this.next().val());
		k = parseInt($this.next().attr('id'));
		if(v>1){
			$this.next().val(v-1);
			$.ajax({
		        url  : 'car.php?a=minus',
		        type : 'post',
		        data : {'key':k,'quantity':v-1},
		        dataType:'html',
		        //beforeSend:function(){},
		        success:function(data){
		        }
		    });
		}
	})
	
	$(".icons_delete").click(function(){
		$(this).parent("li").fadeOut();
		
	})
	
	$(".order_box .listview").each(function(){
		$(this).children("li:last").css({"border-bottom":'0'})	
		
	})
	
	$(document).on('click',"[data-href]",function(){
    	 var link = $(this).attr("data-href");
		 location.href = link;
    })
	
	
	$(".icons_search").click(function(){
		$(".search_box").slideToggle();	
	})
	
	$("ul.listview3").each(function(){
		$(this).find("li:last").css({'border-bottom':'0'});	
		
	})
	
	wrapper_h = $(window).height()-40;
	$(".wrapper").css({'min-height':wrapper_h});
	$(".home .wrapper").css({'min-height':wrapper_h-40});
});