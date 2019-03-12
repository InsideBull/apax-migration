<?php /* Template name: Expertise */ ?>
<?php
$secteur_sous_titre = get_field('secteur_sous_titre');
$exemple_sous_titre = get_field('exemple_sous_titre');
$secteurs = new WP_Query([
	'post_type' => 'expertise',
	'tax_query' => array(
		array(
			'taxonomy' => 'expertise_cat',
			'field'    => 'term_id',
			'terms'    => [52,63,200]
		)
	),
	'order' => 'ASC',
	'orderby' => 'date'
]);

$exemples = new WP_Query([
	'post_type' => 'expertise',
	'tax_query' => array(
		array(
			'taxonomy' => 'expertise_cat',
			'field'    => 'term_id',
			'terms'    => [57,109,201]
		)
	),
	'order' => 'ASC',
	'orderby' => 'date'
]);

get_header();

?>
<div class="container">
	<div class="flex-simple-text">
		<h1 class="center_underline"><?php echo get_term_by("id", 52, "expertise_cat")->name; ?></h1>
	</div>
	<div class="baseline"><?= $secteur_sous_titre ?></div>
	<div class="taxonomy-list">
		<div class="row">
			<?php foreach ($secteurs->posts as $secteur):?>
				<div class="col-md-3 col-xs-12">
					<div class="taxonomy-bloc taxonomy-blue">
						<div class="taxonomy-body">
							<h3 class="title"><?= $secteur->post_title ?></h3>
							<?php if (get_field('sous-titre_page', $secteur->ID)) { ?>
								<span class="subtitle"><?= get_field('sous-titre_page', $secteur->ID) ?></span>
							<?php } ?>
						</div>
						<div class="more-link"></div>
						<a href="<?= get_permalink($secteur->ID) ?>" class="hover-link"></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="flex-simple-text">
		<h2 class="center_underline"><?php echo get_term_by("id", 57, "expertise_cat")->name; ?></h2>
	</div>
	<div class="baseline"><?= $exemple_sous_titre ?></div>
	<div class="taxonomy-list">
		<div class="row">
			<?php foreach ($exemples->posts as $exemple):?>
				<div class="col-md-3 col-xs-12">
					<div class="taxonomy-bloc taxonomy-red">
						<div class="taxonomy-body">
							<h3 class="title"><?= $exemple->post_title ?></h3>
							<?php if (get_field('sous-titre_page', $exemple->ID)) { ?>
								<span class="subtitle"><?= get_field('sous-titre_page', $exemple->ID) ?></span>
							<?php } ?>
						</div>
						<div class="more-link"></div>
						<a href="<?= get_permalink($exemple->ID) ?>" class="hover-link"></a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
