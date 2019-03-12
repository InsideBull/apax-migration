<div class="container">

	<?php

		echo get_field("slider_txt_fixe");

		echo '<br>';

		foreach(get_field("slider_txt_move") as $m) {

			echo '&nbsp;&nbsp;&nbsp;'.$m['texte'].'<br>';

		}

		

		$lien = get_field("lien");

		$texte_lien = get_field("texte_lien");

		if(!empty($lien) && !empty($texte_lien)) {

			echo '<br>'.$texte_lien;

		}

	?>

</div>

	

<div class="wrap-container wrap-container-first" id="apax-pres">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<?php $titre_sous_video = get_field("titre_sous_video");

				$sous_titre_sous_video = get_field("sous-titre_sous_video");

				if ($titre_sous_video != "" || $sous_titre_sous_video != ""): ?>



				<?php echo $titre_sous_video != "" ? '<h2>'.$titre_sous_video.'</h2>' : ''; ?>

				<?php echo $sous_titre_sous_video != "" ? '<div class="baseline">'.$sous_titre_sous_video.'</div>' : ''; ?>



				<?php endif; ?>



				<?php $list_bloc = get_field("list_bloc_sous_video");

				if ($list_bloc): ?>

				<div class="wrap-block">

					<?php include get_template_directory()."/flex-content-right.php"; ?>

					<div class="clear"></div>

				</div>

				<?php endif; ?>



				<?php $lien_sous_video = get_field("lien_sous_video");

				$titre_lien_sous_video = get_field("titre_lien_sous_video");

				if ($lien_sous_video != "" && $titre_lien_sous_video != ""): ?>

				<div class="center">

					<a href="<?php echo $lien_sous_video; ?>" class="link-arrow"><?php echo $titre_lien_sous_video; ?></a>

				</div>

				<?php endif; ?>

			</div>

		</div>

	</div>

</div>



<div class="wrap-container wrap-container-grey">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<h2 class="blue"><?php _e("ENTREPRENEURS CURRENTLY SUPPORTED","apax"); ?></h2>

				<div class="baseline baseline-short-margin"><?php _e("4 areas of specialisation","apax"); ?></div>

			</div>

		</div>

	</div>

</div>



<?php $args = array(

	"hide_empty" => 0,

	"title_li" => "",

	"exclude" => array(1)

);

$category = get_categories($args);

if ($category && count($category)>0): ?>

<div class="wrap-list-click">

	<div class="container">

		<div class="row">

			<div class="col-md-offset-1 col-md-10">

				<ul class="bt-click">

					<?php $randomEntr = array(); foreach ($category as $k=>$c){



						$tmpEntr = get_posts("post_type=societe&posts_per_page=1&orderby=rand&category=".$c->term_id);

						if (count($tmpEntr) > 0) {

							$randomEntr[$c->term_id] = $tmpEntr[0];

							echo '<li><a href="'.get_permalink(get_the_id_wpml(139)).'?cat='.$c->term_id.'"'.($k==0?' class="active"':'').' id="bt-click-entre'.$c->term_id.'">'.str_replace("&amp;","&amp;<br/>",$c->name).'</a></li>';

						}

					} ?>

				</ul>



				<div id="slide-entrepreneur">

					<?php foreach ($randomEntr as $idcat=>$r) {

						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($r->ID), 'home-secteur-spe' );

						$nom_entrepreneur_societe = get_field("nom_entrepreneur_societe",$r->ID);

						$statut_entrepreneur_societe = get_field("statut_entrepreneur_societe",$r->ID);

						if ($thumb) {

							echo '<div class="block-entrepreneur" data-click="entre'.$idcat.'">

									<span class="title">'.$r->post_title.'</span>';

									if ($statut_entrepreneur_societe != "" || $nom_entrepreneur_societe != "") {

										echo $nom_entrepreneur_societe != "" ? $nom_entrepreneur_societe.'<br/>' : '';

										echo $statut_entrepreneur_societe != "" ? $statut_entrepreneur_societe : '';

										echo '</span></span>';

									}

							echo '

							</div>';

						}

					} ?>

					<div id="pager-cycle-entrepreneur"></div>

				</div>



				<div class="clear"></div>

			</div>

		</div>

	</div>

</div>

<?php endif; ?>



<div class="wrap-container wrap-container-grey">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<div class="center center-padding">

					<a href="<?php echo get_permalink(get_the_id_wpml(139)); ?>" class="link-arrow"><?php _e("All entrepreneurs","apax"); ?></a>

				</div>

			</div>

		</div>

	</div>

</div>





<?php $titre_val = get_field("titre_list_images_home");

$sous_titre_val = get_field("sous-titre_list_images_home");

if ($titre_val != "" || $sous_titre_val != ""): ?>

<div class="wrap-container">

	<div class="container">

		<div class="row">

			<div class="col-md-12">

				<?php echo $titre_val != "" ? '<h2 class="blue2 blue-text">'.$titre_val.'</h2>' : ''; ?>

				<?php echo $sous_titre_val != "" ? '<div class="baseline baseline-short-margin">'.$sous_titre_val.'</div>' : ''; ?>

			</div>

		</div>

	</div>

</div>

<?php endif; ?>







<?php $list_3images = get_field("list_images_home");

if ($list_3images): ?>

<div class="wrap-container wrap-container-grey wrap-container-nopadding">

	<div class="container">

		<div class="wrap-block wrap-block-little">

			<div class="row">

				<?php foreach ($list_3images as $l3i){

					$image = $l3i["image"];

					$link = $l3i["lien"];

					$blank = is_array($l3i["blank"]);

					if ($image) {



						echo '

						<div class="col-md-4 col-xs-12">

						<a'.($link != "" ? ' href="'.$link.'"'.($blank ? ' target="_blank"' : '') : '').' class="block-push">

						<span class="wrap-content-full-img" style="background-image: url('.$image["sizes"]["bloc-3-home"].');">

						<img src="'.$image["sizes"]["bloc-3-home"].'" alt="'.$image["alt"].'" />

						</span>

						</a>

						</div>';

					}

				} ?>

			</div>

		</div>

	</div>

</div>

<?php endif;