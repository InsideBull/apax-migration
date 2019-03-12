<?php
	get_header();
	
	if (have_posts()) :
	while (have_posts()) : the_post();
	
	if(has_term( 52, 'expertise_cat' ) || has_term( 63, 'expertise_cat' ) || has_term( 200, 'expertise_cat' )){
		get_template_part('template/expertise-secteur');
	}else{
		get_template_part('template/expertise-exemple');
	}
	
	endwhile;
	endif;
	
	get_footer();
?>
