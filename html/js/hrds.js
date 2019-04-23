(function($, b, c) {
	function d(b) {
		var g = $(this),
		h = g.closest(":data(" + f + ")");
		if (h.length) {
			var c = arguments,
			d = h.data(f).options;
			if (!d.disabled) {
				var h = g.attr(d.paramsAttr),
				o = b.type.substr(0, 1).toUpperCase() + b.type.substr(1),
				q = d.controller[d.actionPrefix + $.trim(g.attr(d.actionAttr)) + o],
				o = d.controller[d.actionPrefix + d.defaultAction + o],
				g = d.context ? "element" === d.context ? g[0] : d.context: d.controller;
				h ? (h = $.map(h.split(","),
				function(b) {
					return $.trim(b)
				}), h = n.call(c, 0).concat(h)) : h = c;
				if ("function" === typeof o && !1 === o.apply(g, h)) return ! 1;
				if ("function" === typeof q) return q.apply(g, h)
			}
		}
	}
	var f = "actionController",
	g = $(b),
	h = {},
	n = Array.prototype.slice,
	b = {
		controller: c,
		events: "click",
		context: "element",
		actionAttr: "data-action",
		paramsAttr: "data-params",
		actionPrefix: "",
		defaultAction: "action",
		disabled: !1
	};
	$.fn[f] = function(b, g) {
		"object" === typeof b && (g = b, b = null);
		var h;
		this.each(function() {
			var c = $.data(this, f) || $.data(this, f, new $[f](this, g));
			b && (h = c[b](g))
		});
		return h || this
	};
	$[f] = function(b, c) {
		var n = $.extend({},
		$[f].defaults, c),
		m = "";
		this.element = $(b);
		this.options = n;
		$.each(n.events.split(" "),
		function(a, b) {
			h[b] && 0 < h[b] ? h[b]++:(h[b] = 1, m += b + " ")
		});
		m && g.delegate("[" + n.actionAttr + "]", m, d)
	};
	$[f].defaults = b;
	$[f].prototype = {
		destroy: function() {
			var b = this.options;
			$.each(b.events.split(" "),
			function(a, c) {
				1 < h[c] ? h[c]--:g.undelegate("[" + b.actionAttr + "]", c, d)
			});
			this.element.removeData(f)
		},
		enable: function() {
			this.options.disabled = !1
		},
		disable: function() {
			this.options.disabled = !0
		}
	};
	$.expr[":"].data = function(b, g, h) {
		return !! $.data(b, h[3])
	}
})(jQuery, window.document);

/**
+-----------------------------------------------------
* 以上为核心代码 edit by porter
* 以下公共js代码快 例如弹窗，短消息提示 错误提示等等公共方法与事件
+-----------------------------------------------------
*/

/**
*ajaxpost请求
*@param url url
*@param data data
*@param succb 成功后回调函数
*@param errcb 失败后回调函数
*/
function ajaxpost(url, data, succb, errcb) {
    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        data: data
    }).error(function () {
        show_message("error", '请求失败!');
    }).success(function (result) {
        if(result.msg === 'needLogin') {
        	window.location.href = $('#datarbs').attr('login-url');
        }
        !0 === result.status ? succb.call(data, result) : errcb.call(data, result);
    });
}

/**
*ajaxget请求
*@param url url
*@param data data
*@param succb 成功后回调函数
*@param errcb 失败后回调函数
*/
function ajaxget(url, data, succb, errcb) {
    $.ajax({
        type: "get",
        url: url,
        dataType: "json",
        data: data
    }).error(function () {
       show_message("error", "请求失败!");
  }).success(function (result) {
     if(result.msg === 'needLogin') {
	window.location.href = $('#datarbs').attr('login-url');
     }
    !0 === result.status ? succb.call(data, result) : errcb.call(data, result)
})
}

// ajaxpost 的同步版本
function ajaxpostsync(url, data, succb, errcb) {
    $.ajax({
        type: "post",
        url: url,
        async: false,
        dataType: "json",
        data: data
    }).error(function () {
        show_message("error", '请求失败!');
    }).success(function (result) {
     if(result.msg === 'needLogin') {
	window.location.href = $('#datarbs').attr('login-url');
     }   	
        !0 === result.status ? succb.call(data, result) : errcb.call(data, result);
    });
}
// ajaxget 的同步版本
function ajaxgetsync(url, data, succb, errcb) {
    $.ajax({
        type: "get",
        url: url,
        async: false,
        dataType: "json",
        data: data
    }).error(function () {
       show_message("error", "请求失败!");
  }).success(function (result) {
     if(result.msg === 'needLogin') {
	window.location.href = $('#datarbs').attr('login-url');
     }
    !0 === result.status ? succb.call(data, result) : errcb.call(data, result)
})
}

// 提示信息
function show_message(status,msg){
	if(status == 'error'){
		msg = "<img src='/html/images/error.png'/>" + msg;
	} else {
		msg = "<img src='/html/images/succe.png'/>" + msg;
	}
	var height = document.body.scrollHeight; // 全文高
	var windowHeight = document.body.clientWidth; // 当前显示的高
	// var    s  =  "网页可见区域宽："+  document.body.clientWidth; 
	// s  +=  "\r\n网页可见区域高："+  document.body.clientHeight; 
	// s  +=  "\r\n网页可见区域高："+  document.body.offsetWeight  +"  (包括边线的宽)"; 
	// s  +=  "\r\n网页可见区域高："+  document.body.offsetHeight  +"  (包括边线的宽)"; 
	// s  +=  "\r\n网页正文全文宽："+  document.body.scrollWidth; 
	// s  +=  "\r\n网页正文全文高："+  document.body.scrollHeight; 
	// s  +=  "\r\n网页被卷去的高："+  document.body.scrollTop; 
	// s  +=  "\r\n网页被卷去的左："+  document.body.scrollLeft; 
	// s  +=  "\r\n网页正文部分上："+  window.screenTop; 
	// s  +=  "\r\n网页正文部分左："+  window.screenLeft; 
	// s  +=  "\r\n屏幕分辨率的高："+  window.screen.height; 
	// s  +=  "\r\n屏幕分辨率的宽："+  window.screen.width; 
	// s  +=  "\r\n屏幕可用工作区高度："+  window.screen.availHeight; 
	// s  +=  "\r\n屏幕可用工作区宽度："+  window.screen.availWidth; 
	// alert(s);  
	$('#show_message').css('top' , height-(windowHeight/2)-50);
	$('#show_message').html(msg);
	$('#show_message').show();
	setTimeout(function(){
		$('#show_message').hide();
		} , 2000); 
	
}

// 弹窗 
// tpl 模版名称
// data js数组，要传递过去的参数
function show_dialog(tpl , data){
	var data=arguments[1]?arguments[1]:{}; // data默认参数 
	if(!tpl){
		alert('tpl不存在！');
	}
	data['tpl'] = tpl;
	ajaxgetsync("/index.php?r=ajaxTpl/"+tpl , data , function(result){
		$('#inline_content').html(result.data);
		$('#inlineClick').click();
	},function(){
		show_message('error','服务器忙，请稍后重试!');
	});
}

// 关闭当前正在显示的弹出框
function hide_dialog(){
	$('#inline_content').empty(); //清空弹出框结构，防止id重复等
	 $('#inlineClick').colorbox.close();
}

// 获取当前窗口滚动条位置
function getScroll(){
		var bodyTop = 0;  
		if (typeof window.pageYOffset != 'undefined') {  
			bodyTop = window.pageYOffset;  
		} else if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {  
			bodyTop = document.documentElement.scrollTop;  
		}  
		else if (typeof document.body != 'undefined') {  
			bodyTop = document.body.scrollTop;  
		}  
		return bodyTop;
	}

//获取短信后倒计时函数
var yzm_time = 90;
var t;
function timeCount(){
	$('#getSMSCode').html(yzm_time + "秒后重新获取");
	if (yzm_time == 0){
		clearTimeout(t);
		$('#getSMSCode').attr('data-action','getSMSCode');
		$('#getSMSCode').html('获取短信');
		$('#getSMSCode').addClass('obtain');
		yzm_time = 90;
		return;
	}
	yzm_time--;
	t = setTimeout('timeCount()',1000);
}


$(document).ready(function() {
	//一些function可以写在这里
	function test(arg) {
		alert(arg);
	}
	var datarbs = $('#datarbs');
	$("#body").actionController({
		controller: {
			//这里写一些点击事件
			// 弹出框关闭事件
			mdialogCloseClick: function(a){
				hide_dialog();
			},
			// 取消关注用户
			remRelationshipClick: function(a , fuid) {
				ajaxget(datarbs.attr('remrelation-url'),{'fuid':fuid},function(result){
					show_message('success',result.msg);
					$('.relationship_'+fuid).html($(result.data).find('.relationship').html());
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 关注用户
			addRelationshipClick: function(a , fuid) {
				ajaxget(datarbs.attr('addrelation-url'),{'fuid':fuid},function(result){
					show_message('success',result.msg);
					// 更新html结构
					$('.relationship_'+fuid).parent().html($(result.data).find('.portlet-content').html());
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 关注用户2 独立的 添加关注
			addRelationship2Click: function(a , fuid) {
				ajaxget(datarbs.attr('addrelation-url'),{'fuid':fuid},function(result){
					show_message('success',result.msg);
					// 更新html结构
					$('.addRelation_' + fuid).html("<cite><img src='/html/images/gou1.png' />己关联</cite>").removeClass('attemtion');
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 关注平台
			addComRelationshipClick: function(a , cpid) {
				var data = {
					'cpid' : cpid,
				};
				ajaxpost(datarbs.attr('addcomrelation-url'),data,function(result){
					// $('.comRelation_'+cpid).html($(result.data).find('.companyRelationship').html());
					$('.companyRelationship_'+cpid).html($(result.data).find('.companyRelationship').html());
					$('.likenum').html(parseInt($('.likenum').html()) +1);
					show_message('success',result.msg);
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 关联平台
			relateComClick:function(a , cpid){
				show_dialog('followCom' , {'cpid' : cpid});
				$('#setp2pnamesub').click(function(){
					var data = {
						'p2pname' : $('#setp2pname').val(),
						'cpid' : cpid,
					};
					ajaxpost(datarbs.attr('relate-com-url'),data,function(result){
						hide_dialog();
						$('.companyRelationship_'+cpid).html($(result.data).find('.companyRelationship').html());
						show_message('success',result.msg);
					},function(result){
						show_message('error',result.msg);
					})
				});
			},
			// 关注公司2 独立的 添加关注
			addComRelationship2Click: function(a , cpid) {
				ajaxget(datarbs.attr('addcomrelation-url'),{'cpid':cpid},function(result){
					show_dialog('followCom');
					$('#setp2pnamesub').attr('data-params',cpid);
					$('.comRelation_'+cpid).find('cite').html("<img src='/html/images/gou1.png' />己关联");
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 取消关注公司 暂时不支持取消关注公司
			remComRelationshipClick: function(a , cpid) {
				ajaxget(datarbs.attr('remcomrelation-url'),{'cpid':cpid},function(result){
					show_message('success',result.msg);
					$('.comRelation_'+cpid).html(result.data);
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 标感兴趣
			addBiaoLikeClick:function(a , biaoid , cpid){
				var data = {
					'biaoid' : biaoid,
					'cpid' : cpid,
				};
				ajaxpost(datarbs.attr('add-biaolike'),data,function(result){
					// $('.biaolike_'+biaoid).html(result.data);
					show_message('success',result.msg);
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 取消标感兴趣
			remBiaoLikeClick: function(a , biaoid , cpid) {
				var data = {
					'biaoid' : biaoid,
					'cpid' : cpid,
				};
				ajaxget(datarbs.attr('rem-biaolike'),data,function(result){
					show_message('success',result.msg);
					$('.biaolike_' + biaoid).parent('tr').remove();
				},function(result){
					show_message('error',result.msg);
				})
			},
			// 活动点赞
			likeEventClick: function(a,eventid){
				var data = {
					'eventid' : eventid,
				};
				ajaxpost(datarbs.attr('like-event'),data,function(result){
					$('.event_'+eventid).html('已赞');
					//点赞数+1
					$('#liked').html(parseInt($('#liked').html())+1);
					$('.eventInvite').show();
				},function(result){
					show_message('error',result.msg);
				})
			},
			colorboxClick: function(a){
				show_dialog('followCom');
			},
			// 获得手机短信验证码
			getSMSCodeClick: function(a){
				if($("#getSMSCode").html().lastIndexOf("秒后重新获取") >=0 ){
			      		return;
			    	}
			 	// 发送手机验证码之前必须验证手机和验证码
			 	if(! $('#mobile').valid()) return;
			 	if(! $('#cap').valid()) return;
			    	var telephone = parseInt($('#mobile').val());
			    	if(!isNaN(telephone)){
			    		var data = {
			    			'telephone' : telephone,
			    		};
					$('#getSMSCode').html(yzm_time + "秒后重新获取");
					$('#getSMSCode').removeClass('obtain');
			    		 ajaxget(datarbs.attr('get-sms-code'), data,function (result){
						timeCount();
						$('#getSMSCode').attr({"data-action":"disabled"});
						$('#getSMSCode').removeClass('obtain');
					},function(result){
						show_message('error' , result.msg);
						$('#getSMSCode').attr('data-action','getSMSCode');
						$('#getSMSCode').html('获取短信');
						$('#getSMSCode').addClass('obtain');
					});
			    	}
			},
			// 小组帖子点赞
			praiseGroupClick:function(a , itemid , type){
				type=='tid' 
				var data = {'tid' : itemid};
				type=='pid' ? data={'pid':itemid} : '';
				ajaxpost(datarbs.attr('praise-group') , data , function(result){
					$('.praise_num').html(parseInt($('.praise_num').html())+1);
					$('.praise_' + itemid).html('已赞' + $('.praise_num').html());
				} , function(result){
					show_message('error' , result.msg);
				})
			},

		},
		events: "click"
	});
});
