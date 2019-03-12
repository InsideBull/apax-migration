<?php /* Template name: Liste société */ ?>
<?php
	// wp_enqueue_style('adakaListMultiple', get_template_directory_uri() . '/css/adakaListMultiple.min.css' );
	// wp_enqueue_script('adakaListMultiple', get_template_directory_uri() . '/js/jquery.adakaListMultiple.js', ["jquery"] );
	wp_enqueue_script('list-filters', get_template_directory_uri() . '/js/list-filters.js', ["jquery", "adakaListMultiple"] );
	get_header();
?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<h1 class="post-title"><?php the_title(); ?></h1>
				<?php $sous_titre = get_field("sous-titre_page");
				if ($sous_titre && $sous_titre != "") {
					echo '<div class="baseline">'.$sous_titre.'</div>';
				} ?>

				<?php
					// echo get_custom_categories('33,34');
					echo '<div id="filter_wrap">';

					echo '<div id="filter_pole_wrap">';
					echo '<select id="filter_pole" data-placeholder="'.htmlentities(__("Activities", "apax")).'">';
					echo '<option value="">'.__("Activities", "apax").'</option>';
					foreach(get_field_object('field_5a310c19d7303')['choices'] as $v) {
						echo '<option value="'.htmlentities($v).'">'.__($v, "apax").'</option>';
					}
					echo '</select>';
					echo '</div>';

					$current = isset($_GET['cat']) ?$_GET['cat'] :-1;
					$categories = get_terms('category','hide_empty=0&exclude=1,3,33,34');
					if ($categories && count($categories) > 0) {
						echo '<div id="filter_secteur_wrap">';
						echo '<select id="filter_secteur" data-placeholder="'.htmlentities(__("Sectors", "apax")).'">';
						echo 	'<option value="">'.__("Sectors", "apax").'</option>';
						foreach ($categories as $categorie){
							echo 	'<option value="cat-item-'.$categorie->term_id.'" '.($current==$categorie->term_id ?'selected' :'').'>'.$categorie->name.'</option>';
						}
						echo '</select>';
						echo '</div>';
					}

					echo '</div>';
				?>
			</div>
		</div>
	</div>

	<?php
		if(isset($_GET['adaka']))
			echo "@@@";
		$ele = get_posts("post_type=societe&posts_per_page=-1&orderby=title&order=ASC&suppress_filters=0");
		include get_template_directory()."/template/list-societe-no-gutters.php";
	?>

	<div class="row">
		<div class="col-md-offset-4 col-md-4">
			<a href="<?php echo get_permalink(get_the_id_wpml(5143)); ?>" class="show_all_list">
				<?php if (ICL_LANGUAGE_CODE == "en"): ?>
					<?php _e("Previously","apax"); ?>
					<span><?php _e("supported","apax"); ?></span><br/>
					<?php _e("companies","apax"); ?>
				<?php else: ?>
					<?php if (ICL_LANGUAGE_CODE != "it"): ?>
						<?php _e("Voir l'","apax"); ?>
					<?php endif; ?>
					<span><?php _e("historique","apax"); ?></span><br/>
					<?php _e("des sociétés accompagnées","apax"); ?>
				<?php endif; ?>
			</a>
		</div>
	</div>

</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
