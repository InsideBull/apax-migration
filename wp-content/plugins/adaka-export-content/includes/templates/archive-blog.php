<?php /* Template name: Live ! */
 	global $wp_query;
	$translate_axe = [
		'en' => [
			1 => 'International',
			2 => 'External growth',
			3 => 'Digital transformation ',
		],
		'fr' => [
			1 => 'International',
			2 => 'Croissance externe',
			3 => 'Transformation digitale',
		],
	];
	// If it's a sort request
	$title = null;
	if (isset($_GET['meta_value']) && !empty($_GET['meta_value']) && isset($_GET['meta_key']) && !empty($_GET['meta_key'])){
		if($_GET['meta_key'] == 'entreprise_blog'){
			$title = get_the_title($_GET['meta_value']);
		}else if($_GET['meta_key'] == 'associes_blog'){
			$title = get_the_title($_GET['meta_value']);
		}else if($_GET['meta_key'] == 'axe_blog'){
			$title = $translate_axe[$lang][$_GET['meta_value']];
		}else if($_GET['meta_key'] == 'secteur_blog'){
			$title = get_cat_name($_GET['meta_value']);
		}
	}
?>

<h1>
	<?php if (!empty($title)){
		echo $title;
	} ?>
</h1>

<div class="blog-list container">
	<?php 
		echo '<div class="col-md-3 col-sm-6 col-xs-12">';
		echo '<span>Blog</span>';
		echo '</div>';
	?>
	</div>
</div>