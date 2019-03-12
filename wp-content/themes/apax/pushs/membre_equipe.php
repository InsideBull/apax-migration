<?php /*$args = array(
	"post_type" => "team",
	"posts_per_page" => -1,
	'meta_query'	=> array(
		array(
			'key'	 	=> 'entrepreneurs_membre_equipe',
			'value'	  	=> '"'.get_the_ID().'"',
			'compare' 	=> 'LIKE',
		),
	),
	'suppress_filters' => false,
	'tax_query' => array(
		array(
			'taxonomy' => 'post_tag',
			'field' => 'term_id',
			'terms' => array(29,30),
		)
	),
);
$team = new WP_Query($args);
// var_dump_pre($team);
$team = $team->posts;*/
$team = get_field("liste_membres_team");
if ($team && count($team)>0) {

	/*$ok_team = array();
	foreach ($team as $t) {
		if (strpos($t->post_title," ") !== false) {
			$firstSpace = strpos($t->post_title," ");
			$prenom = substr($t->post_title,0,$firstSpace);
			$nom = strtolower(substr($t->post_title,($firstSpace+1)));
			$ok_team[$nom] = $t;
		}
	}
	ksort($ok_team);*/

	foreach ($team as $t): ?>

		<?php if (has_term(array(51,30,186), "post_tag", $t->ID)): ?>

		<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($t->ID), 'image-push' ); ?>
		<?php $poste_membre_equipe = get_field("poste_membre_equipe",$t->ID); ?>
		<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
		<a href="<?php echo get_permalink($t->ID); ?>" class="bloc-ele-partenaire"><?php _e("Partner","apax"); ?></a>
		<a href="<?php echo get_permalink($t->ID); ?>" class="bloc-ele bloc-ele-equipe block-push block-push-membre-equipe" style="<?php echo $thumb ? 'background-image: url('.$thumb[0].');' : ''; ?>">
			<?php echo $thumb ? '<img src="'.$thumb[0].'" alt="" />' : ''; ?>
			<span class="title"><?php echo $t->post_title; ?></span>
			<?php if ($poste_membre_equipe != "" || $e->post_title != "") {
				echo '<span class="name"><span>';
				echo $t->post_title != "" ? $t->post_title.'<br/>' : '';
				echo $poste_membre_equipe != "" ? $poste_membre_equipe : '';
				echo '</span></span>';
			} ?>
		</a>
		<?php if ($isSidebar): ?></div><?php endif; ?>

		<?php endif; ?>
	<?php endforeach;
}
?>
