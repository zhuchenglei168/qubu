$.sitebar = function(){
	// 侧边栏滚动条
	$('#sitebar').mCustomScrollbar({theme:'minimal-dark'});

	// 导航样式切换
	$('#menu').click(function(){
		if ($('.minibar').length > 0) {
			$('.container').removeClass('minibar');
		} else {
			$('.container').addClass('minibar');
		}
		return false;
	});

	// 用户组下拉框
	$('#sitebar .user .info .role').click(function(e){
		var obj = $(this).parent();
		if (obj.hasClass('dropdown')) {
			obj.removeClass('dropdown');
		} else {
			obj.addClass('dropdown');
		}
		e.stopPropagation();
	});

	// 下拉框防穿透
	$('#sitebar .user .info ul').click(function(e){
		e.stopPropagation();
	});

	// 导航状态
	$('#sitebar .nav ul h3 a').click(function(e){
		$('#sitebar .nav ul').removeClass('on');
		$(this).parents('ul').addClass('on');
		e.preventDefault();
	});

	// 导航iframe打开
	$('#sitebar .user .info ul a.iframe, #sitebar .nav ul ol a').click(function(e){
		$('#main iframe').attr('src', $(this).attr('href'));
		e.preventDefault();
	});

	// 小导航 二级导航显示
	$(document).on('mouseenter mouseleave', '.minibar #sitebar .nav ul', function(e){
		if (e.type == 'mouseenter') {
			$(this).find('ul').css('display', 'block');
		} else if (e.type == 'mouseleave') {
			$(this).find('ul').css('display', '');
		}
	});
}

// Ajax请求
$.tip = function(url, data, iframe){
	$.ajax({
		type:'POST',
		url:url,
		data:data,
		beforeSend:function(){
			parent.layer.load(1);
		},
		success:function(data){
			parent.layer.closeAll('loading');
			parent.layer.msg(data.msg, {
				time:data.wait ? data.wait * 1000 : 1000,
				anim:data.status == 1 ? 0 : 6
			}, function(){
				if (data.status != 1 && $('form .vcode').length) $('form .vcode img').click();
				if (iframe) {
					if (data.status == 1) {
						parent.layer.closeAll('iframe');
						if (data.url) {
							top.iframe.window.location.href = data.url;
						} else {
							top.iframe.window.location.reload();
						}
					}
				} else {
					if (data.url) window.location.href = data.url;
				}
			});
		},
		dataType:'json'
	});
};

// iframe打开
$.iframe = function(url, area){
	url += url.indexOf('?') > -1 ? '&iframe=1' : '?iframe=1';
	parent.layer.open({
		type:2,
		title:false,
		closeBtn:false,
		shadeClose:true,
		shade:0.15,
		anim:9,
		area:area,
		content:url
	});
}

$(function(){
	// 点击空白关闭下拉框
	$(document).click(function(){
		if ($('.dropdown', window.top.document).length > 0) $('.dropdown', window.top.document).removeClass('dropdown');
	});

	// esc关闭提示框
	$(document).keyup(function(e){
		if (e.keyCode == 27) parent.layer.closeAll('loading');
	});

	// 全局layer取消按钮
	$('a.cancel').click(function(){
		parent.layer.closeAll('iframe');
	});

	// panel收缩展开
	$('.panel-heading').click(function(){
		var obj = $(this).parent().find('.panel-body');
		obj.is(':visible') ? obj.stop(true, true).slideUp('fast') : obj.stop(true, true).slideDown('fast');
	});

});
