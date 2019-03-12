<?php
wp_enqueue_script( 'template-filter-cat-accordeon', get_template_directory_uri() . '/js/template-filter-cat-accordeon.js');
 get_header();?>

<div class="container">
	<div class="row">
		<div class="col-lg-offset-1 col-lg-10 col-md-12 ">
			<div class="post" id="content-societe">
				<a href="<?= get_permalink(get_the_id_wpml(7310)) ?>" class="col-lg-offset-1" id="link_back"><?php _e("Previous page","apax"); ?></a>
				<h1 class="center_underline"><?= get_the_title() ?></h1>

				<?php
					$sous_titre = get_field("sous-titre_page");
					if ($sous_titre && $sous_titre != "") {
						echo '<div class="baseline">'.$sous_titre.'</div>';
					}
				?>

				<div class="post-content">

					<?php get_template_part("flex","content"); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 post-content">
			<?php
			$ele = new WP_Query([
				"post_type"=>"team",
				"posts_per_page"=>-1,
				"orderby"=>"menu_order",
				"order"=>"ASC",
				"suppress_filters"=> 0,
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => get_field('categorie_lie'),
					)
				),
			]);
			if (count($ele)): ?>
				<h2 class="center"><?php _e('Team', 'apax') ?></h2>
				<div class="grid row no-gutters list-no-gutters">

					<?php foreach ($ele->posts as $e): ?>

					<?php $cat = get_the_terms($e->ID, "category");
					if ($cat) {
						$strCat = '';
						foreach ($cat as $c) {
							$strCat .= ($strCat==""?"":" ").'cat-item-'.$c->term_id;
						}
					} ?>

					<div class="col-md-3 col-sm-6 col-xs-12 grid-item <?php echo $strCat; ?> pole-item-<?php the_field("pole", $e->ID); ?> function-item-<?php
						$function = get_field("function", $e->ID);
						// if(in_array($function, $functions))
						// 	echo array_search($function, $functions);
					?>">
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($e->ID), 'image-push' ); ?>
						<?php $poste_membre_equipe = get_field("poste_membre_equipe",$e->ID); ?>
						<a href="<?php echo get_permalink($e->ID); ?>" class="bloc-ele bloc-ele-equipe" style="<?php echo $thumb ? 'background-image: url('.$thumb[0].');' : ''; ?>">
							<?php echo $thumb ? '<img src="'.$thumb[0].'" alt="" />' : ''; ?>
							<span class="title">
								<?php if ($poste_membre_equipe != "" || $e->post_title != "") {
									// echo '<span class="name"><span>';
									echo $e->post_title != "" ? $e->post_title.'<br/>' : '';
									echo $poste_membre_equipe != "" ? $poste_membre_equipe : '';
									// echo '</span></span>';
								} ?>
							</span>
						</a>
					</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<h2 class="center"><?php _e('Portfolio', 'apax') ?></h2>

			<?php
			$ele = new WP_Query([
				"post_type"=>"societe",
				"posts_per_page"=>-1,
				"orderby"=>"title",
				"order"=>"ASC",
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => get_field('categorie_lie'),
					)
				),
			]);

			$ele = $ele->posts;

			include get_template_directory()."/template/list-societe-no-gutters.php"; ?>

			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<h2 class="center"><?php _e('History of accompanied companies', 'apax') ?></h2>
					<?php
						global $accordeon_post_id;
						global $accordeon_filters;
						$accordeon_post_id = get_the_id_wpml(5143);
						$accordeon_filters = [
							'term_ids' => [get_field('categorie_lie')],
						];
						get_template_part("accordeon","content");
					?>
				</div>
			</div>

		</div>
	</div>
</div>

<?php get_footer(); ?>
