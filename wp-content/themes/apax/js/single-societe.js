$(document).ready(function(){
	$("[data-toggle=\"adaka-collapse\"][data-target]").click(function(e){
		e.preventDefault();
		$target = $($(this).data('target'));
		$target.toggleClass('active');
		$(this).toggleClass('active');
		if($target.hasClass('active')){
			$target.slideDown(300).show();
		}else{
			$target.slideUp(300, function(){
				$(this).hide();
			});
		}
	});


	var current_li = $(".menu li ul li.current-menu-item");
	current_li.parents("li:first").addClass("current-menu-item");

	$(window).resize();
});

$(window).resize(function(){
	if ($(".nav-tabs").length > 0 && $(".wrap-mobile-tabs").length == 0){

		$(".nav-tabs").each(function(){
			var nav = $(this);
			var wrap_mobile_tabs = $('<div class="wrap-mobile-tabs"></div>');
			nav.find("li").each(function(){
				wrap_mobile_tabs.append('<div class="title-tabs-mobile">'+$(this).text()+'</div>');
				var id = $(this).find("a").attr("aria-controls");
				wrap_mobile_tabs.append('<div class="content-tabs-mobile">'+$("#"+id).html()+'</div>');
			});
			wrap_mobile_tabs.insertBefore(nav);
		});
	}
});
