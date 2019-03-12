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
			$title = $translate_axe[ICL_LANGUAGE_CODE][$_GET['meta_value']];
		}else if($_GET['meta_key'] == 'secteur_blog'){
			$title = get_cat_name($_GET['meta_value']);
		}
	}
?>
<?php get_header(); ?>


<h1>
	<?php if (!empty($title)){
		echo $title;
	}else { ?>
		<img src="<?= get_template_directory_uri() ?>/img/apax-blog-logo.svg" alt="Apax Blog">
	<?php } ?>
</h1>

<?php if (have_posts()) : ?>

	<div class="blog-list container">
		<div class="row<?php echo $wp_query->post_count < 4 ? ' table' : ''; ?>">
		<?php while (have_posts()) : the_post();
			echo '<div class="col-md-3 col-sm-6 col-xs-12 '.($wp_query->post_count < 4 ? ' table-cell' : '').'">';
			$id_blog_interne = get_the_ID();
			include 'pushs/blog-interne.php';
			echo '</div>';
		endwhile; ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
