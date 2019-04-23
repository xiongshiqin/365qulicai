(function($){	
	$.fn.tab=function(){		
			 $('.tab_menu li').click(function(){						
				$(this).addClass('selected_li');
				$(this).siblings().removeClass();
				$('.tab_content .test').eq($('.tab_menu li').index(this)).show().siblings().hide();			
			})				
		}	
	})(jQuery)