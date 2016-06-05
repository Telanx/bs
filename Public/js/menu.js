
(function(){window.onload=window.onresize=function(){

		var tH = $('#nav-top')?$('#nav-top').outerHeight():0;
		var de = document.documentElement;
		var sH = window.outerHeight||de.innerHeight||(de && de.clientHeight)||document.body.clientHeight;//��Ļ���ø߶�
		console.log(sH);
		var bH = $('#footer').outerHeight();//�ײ��߶�
		$('#content').css({'min-height':(sH-bH-tH)+'px'});	
	}
})();

(function(w){
	w.pop=function(mask,container,title,body){
	
	function setTitle(str){
		title.html(str);
		return this;
	}
	function setBody(str){
		body.html(str);return this;
	}
	function append(str){
		body.html(str);return this;
	}	
	function setCss(obj){
		container.css(obj);
		return this;
	}
	function setBodyCss(obj){
		body.css(obj);
		return this;
	}
	function show(){

		
		var sH = Number(window.outerHeight)-100;
		var cH = parseInt(container.css('height')||100);
		var mH = Math.abs(sH-100-cH);
		container.css({
			'margin':'auto',
			'margin-top':(mH/2)+'px'
		});
		container.show();
		mask.show();
		return this;
	}
	function hide(t){
		var delay = parseInt(t);
		mask.fadeOut();
		return this;
	}
	return {
		setTitle:setTitle,
		setBody:setBody,
		setCss:setCss,
		setBodyCss:setBodyCss,
		append:append,
		show:show,
		hide:hide
	}
};	
})(window);


$(function(){
	(function(d){
			var url = location.href;
			$.each(d,function(i,e){
				var link = $(e).attr('href');
				if(url.indexOf(link)+1){
				$(e).parent().addClass('selected');
					return false;
				}
			});
		})($('.menu a'));
	
})