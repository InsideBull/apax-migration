$(document).ready(function() {
	for(var i in adaka_swipe_cycle_selectors) {
		$(adaka_swipe_cycle_selectors[i]).each(function() {
			var $this = $(this);
			if(typeof $this == 'undefined')
				return;
			
			if(adaka_swipe_cycle_mode == "hammer") {
				var hammer = new Hammer(this);
				hammer.onswipe = function(ev) {
					if (ev.direction == 'left')
						$this.cycle("next");
					if (ev.direction == 'right')
						$this.cycle("prev");
				};
			}
			else if(adaka_swipe_cycle_mode == "swipe" && typeof $this.swipe != "undefined") {
				$this.swipe( {
					swipeLeft  		: function() { $this.cycle("next"); },
					swipeRight 		: function() { $this.cycle("prev"); },
					allowPageScroll : "vertical"
				});
			}
		});
	}
});