$(document).ready(function(){
	
	$("#list-cat-element .cat-item-all a").addClass("active");
	
	$("#list-cat-element").on( 'click', 'li a', function(e) {
		e.preventDefault();
	});
	
	$("#list-cat-element").on( 'click', 'li', function() {
		if (!$(this).find("a").hasClass("active")) {
			$("#list-cat-element li a").removeClass("active");
			$(this).find("a").addClass("active");
			
			var filterValue = "";
			$("#accordeon-list h3, #accordeon-list h2").slideDown(200);
			if ($(this).hasClass("cat-item-all")) {
			} else {
				filterValue = $( this ).clone();
				filterValue.removeClass("cat-item");
				$("#accordeon-list h3:not(."+filterValue.attr("class")+")").slideUp(200,function(){
					var $this = $(this);
					if ($(this).next().css != "none") $(this).next().slideUp(200,function() {
						if ($this.parents(".list-societe").height() < 1) {
							$this.parents(".list-societe").prev().slideUp(200);
						}
					});
				});
			}
		}
	});
	
	$("#accordeon-list h3").click(function(){
		$(this).toggleClass("active");
		var txt = $(this).next();
		if (txt.css("display") == "none") {
			txt.slideDown(200);
		} else {
			txt.slideUp(200);			
		}
	});
});