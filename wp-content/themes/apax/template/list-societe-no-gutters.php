<?php if (count($ele)): ?>

	<div class="grid row no-gutters list-no-gutters">

		<?php foreach ($ele as $e): ?>

		<?php $historical = get_field("show_in_historical",$e->ID);
		if (isset($historical) && is_array($historical) && $historical[0] == "Oui") continue; ?>

		<?php $cat = get_the_terms($e->ID, "category");
		if ($cat) {
			$strCat = '';
			foreach ($cat as $c) {
				$strCat .= ($strCat==""?"":" ").'cat-item-'.$c->term_id;
			}
		} ?>

		<div class="col-md-3 col-sm-6 col-xs-12 grid-item <?php echo $strCat; ?>"
			data-poles="<?php implode(',', the_field("pole", $e->ID)); ?>">
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
		<?php endforeach; ?>
	</div>

	<?php endif; ?>
