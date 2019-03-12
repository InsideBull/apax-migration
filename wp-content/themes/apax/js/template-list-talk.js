var req_numero = {};
var req_numero_loading = false;

jQuery(document).ready(function() {
	jQuery(window).resize(function() {
		jQuery("#about, #subscribe").css("height", "auto");
		jQuery("#about, #subscribe").css("height", Math.max(jQuery("#about").outerHeight(), jQuery("#subscribe").outerHeight())+"px");

	}).trigger("resize");

	$(window).scroll(function() {
		if($(window).scrollTop() > $("footer").offset().top -$(window).height()*2)
			load_more();
	}).trigger("scroll");
});

function load_more() {
	if(req_numero_loading || talks_issues.length == 0){
		var loader = document.getElementById('more-loader');
		if(!req_numero_loading && loader){
			loader.remove();
		}
		return;
	}
	req_numero_loading = true;
	date_counter = {};

	$('.issues-title').each(function(){
		if(typeof date_counter[$(this).data('date')] == "undefined"){
			date_counter[$(this).data('date')] = 1;
		}else{
			date_counter[$(this).data('date')] += 1;
		}
	});

	if(typeof req_numero.abort == "function")
		req_numero.abort();
	req_numero = jQuery.ajax({
		url : oJson.ajaxurl,
		method : "POST",
		data : {
			action : "load_more_numero",
			issue : talks_issues.shift(),
			date_counter : date_counter
		},
		success : function(data) {
			if(data.length !== 0) {
				$("#talks-list-current, .talks-list").last().after(data);
				req_numero_loading = false;
				$(window).trigger("scroll");
				fitImages($('.talks-list .item .image img'));
			}
		}
	});
}
