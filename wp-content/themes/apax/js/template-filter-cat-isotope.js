$(document).ready(function(){
	
	var filterDefault = "*";
	$("#list-cat-element li:not(.cat-item-all)").each(function(){
		if ($(this).find("a").hasClass("active")) {
			filterDefault = $( this ).clone();
			filterDefault.removeClass("cat-item");
			filterDefault = "."+filterDefault.attr("class");
		}
	});
	
	var $container = $('.grid').isotope({
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
	});
});


$(window).resize(function(){
	heightGridItemName()
});