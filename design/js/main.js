$(function(){
	$('.niceCheck').mousedown(function(){
		var el = $(this), input = el.find("input").eq(0);
		if (!input.attr("checked")) {
			el.css("background-position", "0 -13px");
			input.attr("checked", true)
		}
		else {
			el.css("background-position", "0 0");
			input.attr("checked", false)
		}
		return true;
	}).each(function(idx, el){
		var el = $(el), input = el.find("input").eq(0);
		if (input.attr("checked")) {
			el.css("background-position", "0 -13px");
		}
		return true;
	});
	
	with (window.location) {
		$('a[href~="' + pathname + search + '"]').addClass('active');
	}
	$('.zoom, a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".gif"]').fancybox();
	
});
