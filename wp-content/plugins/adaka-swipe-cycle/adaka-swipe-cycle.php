<?php
/*

Plugin Name: Adaka swipe cycle
Version: 1.0
Author: Adaka
Author URI: http://www.adaka.fr
Plugin URI: http://www.adaka.fr/

*/


add_action('wp_footer', 'adaka_swipe_cycle_footer', 20);

function adaka_swipe_cycle_footer() {
	if(is_handheld() && is_ios()){
		$script = "hammer.min.js";
		$swipeModeUsed = "hammer";
	}
	else {
		$script = "jquery.touchSwipe.min.js";
		$swipeModeUsed = "swipe";
	}

	echo '<script>
		var adaka_swipe_cycle_mode = "'.$swipeModeUsed.'";
		var adaka_swipe_cycle_selectors = '.json_encode(adaka_swipe_cycle()).';
	</script>';
	echo '<script src="'.plugins_url( 'js/'.$script, __FILE__ ).'"></script>';
	echo '<script src="'.plugins_url( 'js/adaka_swipe_cycle.js', __FILE__ ).'?v=1.2"></script>';
}

function adaka_swipe_cycle($selector = false) {
	static $selectors = array(".cycle-slideshow", 'body.home #home_slider_accroche .slider', '#actualites .actualites-slider');

	if($selector == false)
		return $selectors;

	if(!empty($selector) && !in_array($selector, $selectors))
		$selectors[] = $selector;
}


add_filter('post_gallery','customFormatGallery',10,2);
function customFormatGallery($string,$attr){
    $posts = get_posts(array('include' => $attr['ids'],'post_type' => 'attachment'));
    $output = '<div class="cycle-slideshow">';

	// if(count($posts) <= 10)
		// $output .= '<div class="cycle-pager"></div>';
	// else
		$output .= '<div class="cycle-prev"><i class="icon-prev-simple"></i></div><div class="cycle-next"><i class="icon-next-simple"></i></div>';


    foreach($posts as $imagePost){
		$tmp = wp_get_attachment_image_src($imagePost->ID, 'gallery');
		$output .= '<img src="'.$tmp[0].'" alt="" />';
    }

    $output .= '</div>';

    return $output;
}
