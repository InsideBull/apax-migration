<?php

get_header();
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

global $post_list;

/*$related_meta_keys = [
	'entreprise_blog',
	'secteur_blog',
	'axe_blog',
	'associes_blog',
];

//$post_list = null;
foreach ($related_meta_keys as $meta_key) {
	if($post_list!=null){
		$ids = wp_list_pluck( $post_list->posts, 'ID' );
	}
	$ids[] = get_the_ID(); // Exclude current post
	if($post_list == null || count($post_list->posts) < 3){ // If not enough post add next meta_key's associated posts
		$add_post_list = new WP_Query([
			'post_type' => 'blog',
			'posts_per_page' => $count,
			'meta_key'=> $meta_key,
			'meta_value'=> get_post_meta(get_the_ID(), $meta_key, true),
			'post__not_in' => $ids,
		]);
		if($post_list->posts != null){ // If already initialised
			$post_list->posts = array_merge( $post_list->posts, $add_post_list->posts );// Merge results
		}else{
			$post_list = $add_post_list;
		}
	}
}*/

$cats = wp_get_post_terms( get_the_ID(), "issues");
$talks_cat = wp_get_post_terms( get_the_ID(), "talks_cat");
$is_dirigeant = count(array_filter($talks_cat, function($a) { return $a->term_id == 47; })) > 0;

if(!empty($cats) || count($cats)<1) {
	$post_list = new WP_Query([
		'post_type' => 'blog',
		'post__not_in' => [get_the_ID()],
		'posts_per_page' => -1,
		'tax_query' => [[
			'taxonomy' => 'issues',
			'field'    => 'term_id',
			'terms'    => $cats[0]->term_id
		]],
		'order' => "DESC",
		'orderby' => "date"
	]);
	if(!$post_list->have_posts())
		$post_list = false;
}
else {
	$post_list = false;
}

?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post();
$societe = get_attached_society(get_the_ID());
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<button type="button" onclick="window.history.back()" class="col-lg-offset-1" title="<?php _e("Back to blogs list","apax"); ?>" id="link_back"></button>
				<?php $sous_titre = get_field("sous-titre_page"); ?>
				<div id="logo-talks"></div>
			</div>
		</div>
	</div>

	<?php $ancres = get_field("menu_dancre");
	if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>'; ?>

	<div class="row">

		<?php if ($post_list !== false): ?>
		<div class="col-lg-offset-1 col-lg-7 col-md-8">
		<?php else: ?>
		<div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8">
		<?php endif; ?>

			<?php include "template/addthis-blog.php"; ?>
			<?php if (is_single()) {
				echo '<div class="post">
					<div class="post-content">
						<h1>'.get_the_title().'</h1>
					</div>
				</div>';
			} ?>

			<?php get_template_part("flex","content"); ?>
			<div class="clear"></div><div class="separator"></div>

			<?php if($is_dirigeant) { ?>
				<?php $associes = get_field('associes_blog'); ?>
				<?php $entreprise = get_field('entreprise_blog'); ?>

				<div class="row" id="row_dirigeant_footer">
					<?php $e = $entreprise; ?>
					<?php $e = get_field("entreprise_blog"); ?>
					<?php if(!empty($e) && isset($e[0])) { ?>
						<?php $e = $e[0]; ?>
						<?php $cat = get_the_terms($e->ID, "category");
						if ($cat) {
							$strCat = '';
							foreach ($cat as $c) {
								$strCat .= ($strCat==""?"":" ").'cat-item-'.$c->term_id;
							}
						} ?>

						<div class="col-md-5 col-sm-6 col-xs-12">
							<h3 class="blog_dirigeant_footer">
								<?php _e("Company", "apax"); ?>
							</h3>

							<div class="grid-item <?php echo $strCat; ?> pole-item-<?php the_field("pole", $e->ID); ?>">
								<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($e->ID), 'image-push' ); ?>
								<?php $nom_entrepreneur_societe = get_field("nom_entrepreneur_societe",$e->ID);
								$statut_entrepreneur_societe = get_field("statut_entrepreneur_societe",$e->ID);
								$expl_nom = explode("<br />", $nom_entrepreneur_societe);
								$expl_statut = explode("<br />", $statut_entrepreneur_societe);	?>
								<a href="<?php echo get_permalink($e->ID); ?>" class="bloc-ele" style="<?php echo $thumb ? 'background-image: url('.$thumb[0].');' : ''; ?>">
									<?php echo $thumb ? '<img src="'.$thumb[0].'" alt="" />' : ''; ?>
									<span class="title"><?php echo $e->post_title; ?></span>
									<?php if ($statut_entrepreneur_societe != "" || $nom_entrepreneur_societe != "") {
										echo '<span class="name"><span>';
										if ($nom_entrepreneur_societe != "") {
											foreach ($expl_nom as $k=>$en) {
												echo $en.'<br/>';
												if (isset($expl_statut[$k]));
												echo $expl_statut[$k].'<br/>';
											}
										}
										/*echo $nom_entrepreneur_societe != "" ? $nom_entrepreneur_societe.'<br/>' : '';
										echo $statut_entrepreneur_societe != "" ? $statut_entrepreneur_societe : '';*/
										echo '</span></span>';
									} ?>
									<?php if(get_field("chiffre_affaires",$e->ID) ): ?>
										<div class="chiffre-affaires">
											<?php if (in_array($e->ID, array(2601, 2476))): //Groupe INSEEC ?>
											<?= __("BUDGET", "apax") ?>
											<?php else: ?>
											<?= __("REVENUE", "apax") ?>
											<?php endif; ?>
											<?= get_field('chiffre_affaires_prefixe',$e->ID) ?><?= get_field("chiffre_affaires",$e->ID) ?><?= get_field('chiffre_affaires_suffixe',$e->ID) ?>
										</div>
									<?php endif;?>
								</a>
							</div>
						</div>
					<?php } ?>

					<?php $e = $associes; ?>
					<?php if(!empty($e)) { ?>
						<?php $cat = get_the_terms($e->ID, "category");
						if ($cat) {
							$strCat = '';
							foreach ($cat as $c) {
								$strCat .= ($strCat==""?"":" ").'cat-item-'.$c->term_id;
							}
						} ?>

						<div class="col-md-offset-2 col-md-5 col-sm-6 col-xs-12">
							<h3 class="blog_dirigeant_footer">
								<?php _e("Supported by", "apax"); ?>
							</h3>

							<div class="grid-item <?php echo $strCat; ?> pole-item-<?php the_field("pole", $e->ID); ?> function-item-<?php
								$function = get_field("function", $e->ID);
								if(in_array($function, $functions))
									echo array_search($function, $functions);
							?>">
								<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($e->ID), 'image-push' ); ?>
								<?php $poste_membre_equipe = get_field("poste_membre_equipe",$e->ID); ?>
								<a href="<?php echo get_permalink($e->ID); ?>" class="bloc-ele bloc-ele-equipe" style="<?php echo $thumb ? 'background-image: url('.$thumb[0].');' : ''; ?>">
									<?php echo $thumb ? '<img src="'.$thumb[0].'" alt="" />' : ''; ?>
									<span class="title"><?php echo $e->post_title; ?></span>
									<?php if ($poste_membre_equipe != "" || $e->post_title != "") {
										echo '<span class="name"><span>';
										echo $e->post_title != "" ? $e->post_title.'<br/>' : '';
										echo $poste_membre_equipe != "" ? $poste_membre_equipe : '';
										echo '</span></span>';
									} ?>
								</a>
							</div>
						</div>
					<?php } ?>
				</div>
			<?php } else { ?>

				<div class="badge-list">
					<?php
					$talks_cat = wp_get_post_terms(get_the_ID(), 'talks_cat');
					$is_valeur_ajoutee = false;
					foreach ($talks_cat as $cat) {
						if($cat->term_id == 59){
							$is_valeur_ajoutee = true;
						}
					}
					?>

					<a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=entreprise_blog&meta_value='.urlencode((is_object($societe)?$societe->ID:null)); ?>"><?= !empty($societe) ? $societe->post_title : "" ?></a>
					<!-- <a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=secteur_blog&meta_value='.urlencode(get_field('secteur_blog')); ?>"><?= !empty(get_field('secteur_blog')) && get_field('secteur_blog') !== 1 ? get_cat_name(get_field('secteur_blog')) : "" ?></a> -->
					<!-- <a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=axe_blog&meta_value='.urlencode(get_field('axe_blog')); ?>"><?= !empty(get_field('axe_blog')) ? $translate_axe[ICL_LANGUAGE_CODE][get_field('axe_blog')] : "" ?></a> -->
					<?php if (!$is_valeur_ajoutee): ?>
						<a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=associes_blog&meta_value='.urlencode(is_object(get_field('associes_blog'))?get_field('associes_blog')->ID:''); ?>"><?= !empty(get_field('associes_blog')) ? get_field('associes_blog')->post_title : "" ?></a>
					<?php endif; ?>
				</div>

				<?php
					$associes = get_field('associes_blog');
					if(!empty($associes)) :
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($associes->ID), 'bloc_image_full' );
					?>
					<div class="fiche-associes">
						<img src="<?= $thumb[0] ?>" alt="" />
						<div class="content">
							<a href="<?= get_permalink($associes->ID); ?>"><span class="name"><?php echo $associes->post_title; ?></span></a>
							<span class="post"><?= get_field("poste_membre_equipe", $associes->ID); ?></span>
							<span class="link_vcf"><a href="<?= get_field("vcard_membre_equipe", $associes->ID)['url']; ?>" title="VCard"><?= _e('Contact informations', 'apax') ?></a></span>
						</div>
					</div>
				<?php endif; ?>
			<?php } ?>

			<div id="subscribe-talks">
				<h3><?php _e("Subscribe", "apax"); ?></h3>
				<div class="mailchimp_forms">
					<?php print_mailchimp_form(); ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<?php if($post_list !== false) { ?>
			<?php get_sidebar("blog"); ?>
		<?php } ?>
	</div>

</div>

<?php endwhile; ?>
<?php endif; ?>


<?php get_footer(); ?>
