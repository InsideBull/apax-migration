<?php
	global $the_flex_content;
	if(isset($the_flex_content))
		$content = $the_flex_content;
	else
		$content = get_field("flex-content");
	if ($content): ?>

			<div class="post">
				<div class="post-content">
					<?php foreach ($content as $cont) {
						switch ($cont["acf_fc_layout"]) {
							case "texte":
								$texte = addAutoPlay($cont["texte"]);
								if ($texte) {
									echo '<div class="flex-bloc_texte">
										<div class="row">
											<div class="col-md-12">
												<div class="flex-simple-text">'.$texte.'</div>
											</div>
										</div>
									</div>';
								}
								break;

							case "bloc_2_images":
								$gauche = $cont["gauche"];
								$share_twitter_gauche = is_array(get_field("partage_twitter_media",$gauche["ID"]));
								$droite = $cont["droite"];
								$share_twitter_droite = is_array(get_field("partage_twitter_media",$droite["ID"]));
								if ($gauche || $droite) {
									echo '<div class="flex-bloc_2_images">
										<div class="row">';

									if ($gauche) {
										$caption = $gauche["caption"];
										echo '

										<div class="col-sm-6">
											'.($caption != "" ? '<div class="caption">'.$caption.'</div>':'').'
											'.($share_twitter_gauche ? '<a href="https://twitter.com/share" class="twitter-share-button twitter-share-button-content" data-url="'.make_bitly_url(get_permalink($gauche["ID"])).'" data-text="'.str_replace("'","\'",$gauche["description"]).'" data-via="ApaxPartners_FR">Tweet</a>': '').'
											<img src="'.$gauche["sizes"]["bloc-2-image"].'" title="'.$gauche["title"].'" alt="'.$gauche["alt"].'" />
										</div>';
									}
									if ($droite) {
										$caption = $droite["caption"];
										echo '<div class="col-sm-6">
											'.($caption != "" ? '<div class="caption">'.$caption.'</div>':'').'
											'.($share_twitter_droite ? '<a href="https://twitter.com/share" class="twitter-share-button twitter-share-button-content" data-url="'.make_bitly_url(get_permalink($droite["ID"])).'" data-text="'.str_replace("'","\'",$droite["description"]).'" data-via="ApaxPartners_FR">Tweet</a>': '').'
											<img src="'.$droite["sizes"]["bloc-2-image"].'" title="'.$droite["title"].'" alt="'.$droite["alt"].'" />
										</div>';
									}

									echo '</div>
									</div>';
								}
								break;
							case "bloc_2_chiffres_cles":
								$gauche = $cont["chiffre_cle_gauche"];
								$share_twitter_gauche = isset($gauche["ID"]) && is_array(get_field("partage_twitter_media",$gauche["ID"]));
								$droite = $cont["chiffre_cle_droite"];
								$share_twitter_droite = isset($droite["ID"]) && is_array(get_field("partage_twitter_media",$droite["ID"]));
								if ($gauche || $droite) {
									echo '<div class="flex-bloc_2_images">
										<div class="row">';

									if ($gauche) {
										$chiffre_cle = $gauche;
										echo '<div class="col-sm-6">';
											include get_template_directory().'/template/chiffre-cle.php';
										echo '</div>';
									}
									if ($droite) {
										$chiffre_cle = $droite;
										echo '<div class="col-sm-6">';
											include get_template_directory().'/template/chiffre-cle.php';
										echo '</div>';
									}

									echo '</div>
									</div>';
								}
								break;

							case "bloc_mise_avant_image":
								$titre = $cont["titre"];
								$image = $cont["image"];
								$texte_a_droite = $cont["texte_a_droite"];
								$texte_en_dessous = $cont["texte_en_dessous"];
								echo '<div class="flex-bloc_mise_avant_image">';
								if ($titre) {
									echo '<div class="row">
										<div class="col-md-12"><h2>'.$titre.'</h2></div>
									</div>';
								}
								if ($image || $texte_a_droite) {
									echo '<div class="row row-flex-bloc_mise_avant_image-img">';
									if ($image) {
										echo '<div class="col-sm-4"><img src="'.$image["sizes"]["bloc_mise_avant_image"].'" alt="'.$image["alt"].'" title="'.$image["title"].'" /></div>';
									}
									if ($texte_a_droite) {
										echo '<div class="col-sm-8">'.$texte_a_droite.'</div>';
									}
									echo '</div>';
								}
								if ($texte_en_dessous) {
									echo '<div class="row">
										<div class="col-md-12">'.$texte_en_dessous.'</div>
									</div>';
								}
								echo '</div>';
								break;

							case "bloc_image_texte":
								$image = $cont["image"];
								$texte = $cont["texte"];
								if ($image || $texte) {
									echo '<div class="flex-bloc_image_texte">
										<div class="row">';

									if ($image) {
										echo '<div class="col-sm-4"><img src="'.$image["sizes"]["bloc_image_texte"].'" alt="'.$image["alt"].'" title="'.$image["title"].'" /></div>';
									}
									if ($texte) {
										echo '<div class="col-sm-8">'.$texte.'</div>';
									}

									echo '</div>
									</div>';
								}
								break;

							case "bloc_image_full":
								$image = $cont["image"];
								$share_twitter = is_array(get_field("partage_twitter_media",$image["ID"]));
								if ($image) {
									$caption = $image["caption"];
									echo '<div class="flex-bloc_image_full">
										<div class="row">
											'.($caption != "" ? '<div class="col-md-12"><div class="caption">'.$caption.'</div></div>':'').'
											'.($share_twitter ? '<a href="https://twitter.com/share" class="twitter-share-button twitter-share-button-content" data-url="'.make_bitly_url(get_permalink($image["ID"])).'" data-text="'.str_replace("'","\'",$image["description"]).'" data-via="ApaxPartners_FR">Tweet</a>': '').'
											<div class="col-md-12">
												<img src="'.$image["sizes"]["bloc_image_full"].'" alt="'.$image["alt"].'" title="'.$image["title"].'" />
											</div>
										</div>
									</div>';
								}
								break;

							case "bloc_sur_fond_gris":
								$texte = $cont["texte"];
								if ($texte) {
									echo '<div class="flex-bloc_texte_fond_gris">
										<div class="row">
											<div class="col-md-12">
												<div class="flex-texte_fond_gris">'.$texte.'</div>
											</div>
										</div>
									</div>';
								}
								break;

							case "retour_en_haut_de_page":
								echo '<div class="flex-to_top">
									<a href="#" title="'.__("Top of page","apax").'">'.__("Top of page","apax").'</a>
								</div>';
								break;
						}
					} ?>
				</div>
			</div>
			<?php if(!isset($removeScriptTags) ||(isset($removeScriptTags) && $removeScriptTags == false)): ?>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			<?php endif; ?>

	<?php endif; ?>
