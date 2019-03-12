<div class="container">
	<?php 
		$sous_titre = get_field("sous-titre_page");
		if ($sous_titre && $sous_titre != "") {
			echo '<div class="baseline">'.$sous_titre.'</div>';
		} 
		$args = array(
			"show_option_all" => __("ALL","apax"),
			"hide_empty" => 0,
			"title_li" => "",
			"exclude" => array(1,33,34)
		);
				
		echo '<ul id="list-cat-element">';
		wp_list_categories($args);
		echo '</ul>'; 
	?>
</div>