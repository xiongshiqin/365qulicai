$(function(){
	/* 后台ajax提交 */
	$('.submit-btn').click(function(){
		var query=$('.form-horizontal').serialize();  //请求序列号内容
		var url=$('.form-horizontal').attr('action');  //请求URL
		$.post(url,query,function(data){
			var obj=eval("("+data+")");  //js对象转换
			if(obj.status==1){  //成功执行
				$('#top-alert').css({'display':'block'})
				$('#top-alert').addClass('alert-success')
				$('.alert-content').text(obj.info+'，页面即将跳转~~~')
				$(document).scrollTop(0);
				setTimeout(function(){
					if (obj.url) {							
						location.href=obj.url;
					}
				},1500);
			}else{   //失败执行
				$('#top-alert').css({'display':'block'})
				$('.alert-content').text(obj.info+'，页面即将跳转~~~')
				$(document).scrollTop(0);
				setTimeout(function(){
					if (obj.url) {							
						location.href=obj.url;
					}
				},1500);
			}			
		})
	})
		
	
})