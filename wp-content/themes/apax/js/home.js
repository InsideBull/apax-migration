var isLoading = false, $container;

$(document).ready(function(){
	$("#wrap-list-article").on("click",".block-article",function(){
		window.location.href = $(this).find("a:first").attr("href");
	});

	var filterDefault = "*";
	$("#list-cat-element li:not(.cat-item-all)").each(function(){
		if ($(this).find("a").hasClass("active")) {
			filterDefault = $( this ).clone();
			filterDefault.removeClass("cat-item");
			filterDefault = "."+filterDefault.attr("class");
		}
	});

	$container = $('.grid').isotope({
		itemSelector: '.grid-item',
		filter: filterDefault
	});

	$("#list-cat-element").on( 'click', 'li a', function(e) {
		e.preventDefault();
	});

	$("#list-cat-element").on( 'click', 'li', function() {
		$("#list-cat-element li a").removeClass("active");
		$(this).find("a").addClass("active");

		var filterValue = "";
		if ($(this).hasClass("cat-item-all")) {
			filterValue = "*";
		} else {
			filterValue = $( this ).clone();
			filterValue.removeClass("cat-item");
			filterValue = "."+filterValue.attr("class");
		}
		$container.isotope({ filter: filterValue });
		appendToIsotope();
	});
	$(window).scroll(function(e) {
		appendToIsotope();
	});
});

function appendToIsotope() {
	var toTop = $(window).scrollTop() +$(window).height()+500;
	var lastEle = $("#wrap-list-article > .container > .row > div:last").offset().top;
	if (toTop>lastEle && !isLoading && oJson.actuoffset != -1){
		isLoading = true;
		var params = "nonce="+oJson.nonce+"&year="+oJson.actuyear+"&offset="+oJson.actuoffset+"&perpage="+oJson.actuperpage+"&action=load-last-actu";
		if(getUrlParam("meta_key") && getUrlParam("meta_value")){
			params += "meta_key="+getUrlParam("meta_key")+"&meta_value="+getUrlParam("meta_value");
		}
		$.post(oJson.ajaxurl, params, function(data) {
			var $data = $(data);
			var $resp = $data.find("#tmpActu");
			var elems = [];
			$resp.find(".grid-item").each(function(){
				elems.push( $(this)[0] );
			});
			// $("#wrap-list-article > .container > .row").append($resp);
			$container.isotope( 'insert', elems );
			oJson.actuoffset = parseInt(oJson.actuoffset) + parseInt(oJson.actuperpage);
			if (elems.length == 0)oJson.actuoffset = -1;
			isLoading = false;
			$(window).scroll();
		});
	}
}
