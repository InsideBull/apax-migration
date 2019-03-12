<?php /* Template name: Historique */ ?>
<?php get_header(); ?>

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
				
				<?php $args = array(
					"show_option_all" => __("ALL","apax"),
					"hide_empty" => 0,
					"title_li" => "",
					"exclude" => array(1,33,34)
				);
				
				echo '<ul id="list-cat-element">';
				wp_list_categories($args);
				echo '</ul>'; ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-offset-1 col-md-10">
	
		<?php get_template_part("accordeon","content"); ?>
	
		</div>
	</div>
</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>