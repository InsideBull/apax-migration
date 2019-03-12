jQuery(document).ready(function() {
	var $ = jQuery;

	$.fn.cycle.transitions.scrollHorz_apax = {
		before: function( opts, curr, next, fwd ) {
			opts.API.stackSlides( curr, next, fwd );
			//var w = opts.container.css('overflow','hidden').width();
			var w = 100;
			opts.cssBefore = { left: fwd ? w : - w, top: 0, visibility: 'visible', display: 'block', opacity: 0 };
			opts.cssAfter = { zIndex: opts._maxZ - 2, left: 0};
			opts.animIn = { left: 0, opacity: 1};
			opts.animOut = { left: fwd ? -w : w, opacity: 0};
		},
		transition: function (slideOpts, currEl, nextEl, fwd, callback) {
            var opts = slideOpts;
            var curr = $(currEl),
                next = $(nextEl);

            opts.sync = false;
			var fn = function() {
				next.css('visibility','visible');
				next.css('opacity',0);
				next.css('left',fwd ? 100 : - 100);
	            next.animate({
					left: 0,
	                opacity:1
	            }, {
	                duration: opts.speed / 2,
	                easing: opts.easeOut || opts.easing,
	                complete: callback
	            });
			};

            curr.animate({
				opacity:0,
				left: fwd ? -100 : 100,
            }, {
                duration: opts.speed / 2,
                easing: opts.easeOut || opts.easing,
				complete: function() {
                    //css after transition //curr.css(opts.cssAfter || {});
                    curr.css('visibility','hidden'); // hide curr slide for second half of the transition
                    if (!opts.sync) {
                            fn();
                    }
                }
            });

			if (opts.sync) {
                    fn();
            }
        }
	};

	$("body.home #home_slider_accroche .slider").cycle({
		'slides' : "> div",
		"fx" : "scrollHorz_apax",
		"timeout" : 4000,
		"pager" : "body.home #home_slider_accroche .pager"
	});

	$("#actualites .actualites-slider").cycle({
		'slides' : "> div.item",
		"fx" : "scrollHorz",
		"timeout" : 0,
		"pause-on-hover" : true,
		"pager" : "#actualites .pager",
		"prev" : "#actualites .prev",
		"next" : "#actualites .next"
	});

});
$(window).on("load", set_actu_slider_height);
$(window).on("load", set_first_blocks_height);

function set_actu_slider_height(){
	if(!set_actu_slider_height.initialized){
		set_actu_slider_height.initialized = true;
		$(window).resize( set_actu_slider_height );
	}
	if(window.matchMedia("(max-width:992px)").matches){

		var max = 0;
		$('#actualites .item').each(function(){
			max = $(this).outerHeight(true) > max ? $(this).outerHeight(true) : max;
		});
		$('#actualites .actualites-slider').css('height', (max+15)+'px');
	}else{
		$('#actualites .actualites-slider').prop('style', '');

	}
}


function set_first_blocks_height() {
	$('.talks-list .item .wrap-content p').dotdotdot();
	if(!set_first_blocks_height.initialized){
		set_first_blocks_height.initialized = true;
		$(window).resize( set_first_blocks_height );
	}
	// First row
	$items = $('#home_first_blocks_left .item');
	$items_sidebar = $('#actualites, #home-twitter');

	$items.css('height', 'auto');
	$items_sidebar.css('height', 'auto');
	$items.find('.bg').css('height', 'auto');

	if(window.matchMedia("(max-width:992px)").matches){
		$('#home-twitter').css('height', '450px');
	}else{
		var counter = 0;
		$items_sidebar.each(function(){
			//var max = Math.max($items.eq(counter).outerHeight(), $items.eq(counter+1).outerHeight(), $(this).outerHeight());
			var max = Math.max($items.eq(0).outerHeight(), $items.eq(1).outerHeight(), $items_sidebar.first().outerHeight());
			$items.eq(counter).css('height', max+'px');
			$items.eq(counter+1).css('height', max+'px');
			$(this).css('height', max+'px');
			counter += 2;
		});
		$items.each(function(){
			$(this).children('.bg').css('height', ($(this).outerHeight() - $(this).children('.image, .wrap-image').outerHeight()) + 'px')
		});
		// Same height wrap content
		var $wrapContentFirst = $items.eq(0).find('.wrap-content');
		var $wrapContentStatic = $items.eq(1).find('.wrap-content');
		if($wrapContentFirst.length > 0 && $wrapContentStatic.length > 0){
			$wrapContentStatic.css('height', $wrapContentFirst.outerHeight()+'px');
			var avalableHeight = $wrapContentFirst.height();
			$wrapContentStatic.children('.title, h3, svg, img').each(function(){
				avalableHeight -= $(this).outerHeight(true);
			});
			$wrapContentStatic.find('.content-min p').dotdotdot({
				height: parseInt(avalableHeight),
				tolerance: 5,
			});
		}
	}
}
