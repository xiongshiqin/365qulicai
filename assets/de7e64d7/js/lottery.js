// 转盘抽奖
function rotary(url, lotid) {
	var data = {
		'lotid': lotid,
	};
	$.ajax({
		type: 'POST',
		url: url,
		data: data,
		dataType: 'json',
		cache: false,
		error: function() {
			alert('服务器正忙,请稍后重试!');
			return false;
		},
		success: function(json) {
			if (json.status == false) {
				if (json.msg == 'needLogin') {
					window.location.href = json.data;
				} else {
					alert(json.msg);
				}
			} else {
				$("#startbtn").unbind('click').css("cursor", "default");
				var a = json.angle; //角度 
				var p = json.prize; //奖项 
				$("#startbtn").rotate({
					duration: 4000,
					//转动时间 
					angle: 0,
					animateTo: 3600 + a,
					//转动角度 10圈+角度
					easing: $.easing.easeOutSine,
					callback: function() {
						var str = '恭喜你，中得' + p + '\n还要再来一次吗？';
						if (json.hit == false) {
							str = '很遗憾,此次没中奖。';
						}
						// 记录下当前指针的角度,点击确认按钮后,指针归零
						var curAngle = json.angle % 360;
						var needAngle = 360 - curAngle;
						alert(str);
						window.location.reload();
						// $(this).rotate({
						//         angle:needAngle,
						//         animateTo:0,
						//         duration: 500,
						//         callback: function(){}, // 写callback防止没用上面的callback造成死循环
						//     });
						//  // 绑定开始按钮点击事件
						// $('#startbtn').click(function(){
						//     lottery(url,lotid);
						// });
					}
				});
			}
		}
	});
}

//砸金蛋
function eggClick(obj, url, lotid) {
	var data = {
		'lotid': lotid,
	};
	var _this = obj;
	$.getJSON(url, data,
	function(res) {
		if (_this.hasClass("curr")) {
			alert("蛋都碎了，别砸了！刷新再来.");
			return false;
		}
		//_this.unbind('click');
		$(".hammer").css({
			"top": _this.position().top - 55,
			"left": _this.position().left + 185
		});
		$(".hammer").animate({
			"top": _this.position().top - 25,
			"left": _this.position().left + 125
		},
		30,
		function() {
			if (res.status == false) {
				if (res.msg == 'needLogin') {
					window.location.href = res.data;
				} else {
					alert(res.msg);
				}
			} else {
				_this.children("span").hide()
				_this.addClass("curr"); //蛋碎效果
				_this.find("sup").show(); //金花四溅
				$(".hammer").hide();
				$('.resultTip').css({
					display: 'block',
					top: '100px',
					left: _this.position().left + 45,
					opacity: 0
				}).animate({
					top: '50px',
					opacity: 1
				},
				300,
				function() {
					var str = '恭喜你，中得' + res.prize + '\n还要再来一次吗？';
					if (res.hit == false) {
						str = '很遗憾,此次没中奖。';
					}
					$('#result').html(str);
				});
			}
		});
	});
}

// 翻板抽奖
function turnover(url , lotid){
	var data = {
		'lotid': lotid,
	};
	$("#prize_lottery li").each(function() {
		var p = $(this);
		var c = $(this).attr('class');
		p.css("background-color", c);
		p.click(function() {
			$.getJSON(url , data,
			function(res) {
				if (res.status == false) {
					if (res.msg == 'needLogin') {
						window.location.href = res.data;
					} else {
						alert(res.msg);
					}
				} else {
					$("#prize_lottery li").unbind('click');  //不可点击
					var prize = res.prize; //抽中的奖项 
					p.flip({
						direction: 'rl',
						//翻动的方向rl：right to left 
						content: prize,
						//翻转后显示的内容即奖品 
						color: c,
						//背景色 
						onEnd: function() { //翻转结束 
							p.css({
								"font-size": "22px",
								"line-height": "100px"
							});
							p.attr("id", "r"); //标记中奖方块的id 
							$("#viewother").show(); //显示查看其他按钮 
							$("#prize_lottery li").unbind('click').css("cursor", "default").removeAttr("title");
						}
					});
					$("#data").data("nolist", res.no); //保存未中奖信息 
				}
			});
		});
	});
}
