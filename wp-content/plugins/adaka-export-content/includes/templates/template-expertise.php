<?php

$secteur_sous_titre = get_field('secteur_sous_titre', $post->ID);
$exemple_sous_titre = get_field('exemple_sous_titre', $post->ID);
$secteurs = new WP_Query([
	'post_type' => 'expertise',
	'tax_query' => array(
		array(
			'taxonomy' => 'expertise_cat',
			'field'    => 'term_id',
			'terms'    => [52,63]
		)
	),
	'order' => 'ASC',
	'orderby' => 'date',
	"post_status" => "publish"
]);

$exemples = new WP_Query([
	'post_type' => 'expertise',
	'tax_query' => array(
		array(
			'taxonomy' => 'expertise_cat',
			'field'    => 'term_id',
			'terms'    => [57,109]
		)
	),
	'order' => 'ASC',
	'orderby' => 'date',
	"post_status" => "publish"
]);

?>
<div class="container">
	<h1 class="center_underline"><?php echo get_term_by("id", ($lang=="fr" ?63 :52), "expertise_cat")->name; ?></h1>
	<div class="baseline"><?= $secteur_sous_titre ?></div>
	
	<div class="taxonomy-list">
		<?php foreach ($secteurs->posts as $secteur):?>
			<h3 class="title"><?= $secteur->post_title ?></h3>
			<?php if (get_field('sous-titre_page', $secteur->ID)) { ?>
				<span class="subtitle"><?= get_field('sous-titre_page', $secteur->ID) ?></span>
			<?php } ?>
		<?php endforeach; ?>
	</div>

	<h2 class="center_underline"><?php echo get_term_by("id", ($lang=="fr" ?57 :109), "expertise_cat")->name; ?></h2>
	<div class="baseline"><?= $exemple_sous_titre ?></div>
	<div class="taxonomy-list">
		<?php foreach ($exemples->posts as $exemple):?>
			<h3 class="title"><?= $exemple->post_title ?></h3>
			<?php if (get_field('sous-titre_page', $exemple->ID)) { ?>
				<span class="subtitle"><?= get_field('sous-titre_page', $exemple->ID) ?></span>
			<?php } ?>
		<?php endforeach; ?>
	</div>
</div>
