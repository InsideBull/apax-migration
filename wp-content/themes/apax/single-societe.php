<?php get_header();
global $IS_EXPORT;
global $sitepress;?>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/js/single-societe.js"></script>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<a href="javascript:window.history.back();" class="col-lg-offset-1" id="link_back"><?php _e("Previous page","apax"); ?></a>
				<?php $logo_societe = get_field("logo_societe"); ?>
				<h1 class="post-title<?php echo $logo_societe ? ' post-title-has-logo' : ''; ?>"><span class="title"><?php the_title(); ?></span><?php echo $logo_societe ? '<span class="logo"><span><img src="'.$logo_societe["sizes"]["logo-societe"].'" alt="'.get_the_title().'" /></span></span>' : '' ?></h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-offset-1 col-lg-7 col-md-8">
			<div class="post" id="content-societe">
				<div class="post-content">
					<div id="info_societe">
						<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'image-push' );
						$nom_entrepreneur_societe = get_field("nom_entrepreneur_societe");
						$statut_entrepreneur_societe = get_field("statut_entrepreneur_societe");
						$profil_societe = get_field("profil_societe");
						$site_internet_societe = get_field("site_internet_societe");
						$compte_twitter_societe = get_field("compte_twitter_societe");
						$compte_linkedin_societe = get_field("compte_linkedin_societe");
						$date_dinvestissement_societe = get_field("date_dinvestissement_societe");
						$position_societe = get_field("position_societe");
						$chiffre_cle_1 = get_field("chiffre_cle_1_societe");
						$chiffre_cle_2 = get_field("chiffre_cle_2_societe");
						$chiffre_cle_3 = get_field("chiffre_cle_3_societe");
						$chiffre_affaires = get_field("chiffre_affaires");
						$majoritaire = get_field("majoritaire_societe");
						$these_investissement = get_field("these_investissement");
						$these_investissement_choice = get_field("these_investissement_choice");
						$video_societe = get_field("video_societe");
						$poles = get_field("pole");

						if(is_string($poles) && !empty($poles)){ // Transform poles in array for backward compatibility with old single élément system
							$poles = [$poles];
						}

						// Get youtube video id
						if (!empty($video_societe)) {
							parse_str( parse_url( $video_societe, PHP_URL_QUERY ), $url_args );
							$video_societe =  'https://www.youtube.com/embed/'.$url_args['v'];
						}

						$expl_nom = explode("<br />", $nom_entrepreneur_societe);
						$expl_statut = explode("<br />", $statut_entrepreneur_societe);

						echo '<div class="entrepreneur-wrapper clearfix">';
							echo $thumb ? '<img src="'.$thumb[0].'" class="photo-entrepreneur" alt="" />' : '';
							echo '<div class="right pull-left content">';
							if ($nom_entrepreneur_societe != "" || $statut_entrepreneur_societe != "") {
								echo '<div class="subtitle-societe">'.__("Entrepreneur","apax").(count($expl_nom)>1?'s':'').'</div>';
								foreach ($expl_nom as $k=>$en) {
									echo '<div class="nom_entrepreneur_societe">'.$en.'</div>';
									if (isset($expl_statut[$k]));
									echo '<div class="statut_entrepreneur_societe">'.$expl_statut[$k].'</div>';
								}
								echo '<a href="" class="profile-btn collapse-btn" data-toggle="adaka-collapse" data-target="#profile-collapse">'.__("Profile","apax").'</a>';
							}
							echo '</div>';
						echo '</div>';
						echo '<div class="adaka-collapse content" id="profile-collapse">';

						// Profile part
						if ($profil_societe != "") {
							echo '<div class="profil_societe">'.$profil_societe.'</div>';
						}

						// Online part
						if ($site_internet_societe != "" || $compte_twitter_societe != "" || $compte_linkedin_societe != "") {
							echo '<div class="subtitle-societe">'.__("Online","apax").'</div><br/><div class="online-societe">';
							if ($site_internet_societe != "") {
								$sites = explode("\n",$site_internet_societe);
								foreach ($sites as $site){
									echo '<a target="_blank" href="'.(substr($site,0,4) != "http" ? "http://" : "").$site.'" class="site_internet_societe">'.str_replace("www.","",$site).'</a>';
								}
							}
							echo $compte_twitter_societe != "" ? '<a target="_blank" href="https://twitter.com/'.(substr($compte_twitter_societe,0,1) != "@" ? "@" : "").$compte_twitter_societe.'" class="compte_twitter_societe">'.$compte_twitter_societe.'</a>' : '';
							if ($compte_linkedin_societe != "") {
								$lstLinkedIn = array();
								$expl = explode("\n",$compte_linkedin_societe);
								foreach ($expl as $ex){
									$tmp = explode("|",$ex);
									if (count($tmp) == 1) {
										$lstLinkedIn[] = array(
											"title"=>get_the_title(),
											"url"=>trim($tmp[0])
										);
									} else {
										$lstLinkedIn[] = array(
											"title"=>trim($tmp[0]),
											"url"=>trim($tmp[1])
										);
									}
								}
								foreach ($lstLinkedIn as $lst){
									echo  '<a target="_blank" href="'.(substr($lst["url"],0,4) != "http" ? "http://" : "").$lst["url"].'" class="compte_linkedin_societe">'.$lst["title"].'</a>';
								}
							}
							echo '</div>';
						} // End online condition
						echo '</div>'; //End collapse dive

						?>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
					</div>

					<div class="chiffres-societe">
						<?php if(get_field('chiffre_affaires') && get_field('show_in_historical')[0] != 'Oui'): ?>
							<div class="chiffre-affaires">
									<?= get_field('chiffre_affaires_prefixe') ?><span class="num animated-number" <?= (!$IS_EXPORT?'data-stats="'.str_replace('&nbsp;', ' ',$chiffre_affaires).'"':"") ?>><?= (!$IS_EXPORT?"0":$chiffre_affaires) ?></span><?= get_field('chiffre_affaires_suffixe') ?><br>
								<span class="text">
									<?php if (in_array(get_the_ID(), array(2601, 2476))): //Groupe INSEEC ?>
									<?= __("Budget", "apax") ?>
									<?php else: ?>
									<?= __("Revenue", "apax") ?>
									<?php endif; ?>
								</span>
							</div>
						<?php endif; ?>
						<div class="small">
							<span class="secteur"><?= __("Sector","apax") ?><?= ICL_LANGUAGE_CODE == "fr" ? ' ' : '' ?>: <?= get_the_category()[0]->name; ?></span>
							<span class="date_investissement"><?= __("Investment date","apax") ?><?= ICL_LANGUAGE_CODE == "fr" ? ' ' : '' ?>: <?= $date_dinvestissement_societe ?></span>
							<?= $majoritaire != "" && $majoritaire ? '<span class="majoritaire">'.__("Apax position","apax").(ICL_LANGUAGE_CODE == "fr" ? ' ' : '').': '.$majoritaire.'</span>' : ''; ?>
							<?= !empty($poles) && $poles ? '<span class="activities">'.__((count($poles)>1?"Activities":"Activity"),"apax").(ICL_LANGUAGE_CODE == "fr" ? ' ' : '').': '.implode(', ', $poles).'</span>' : ''; ?>
						</div>
					</div>
					<?php if(!empty($video_societe)){ ?>
						<iframe class="youtube-video" src="<?= $video_societe ?>"></iframe>
					<?php } ?>
					<?php if($these_investissement_choice){ ?>
						<div class="these-investissement">
							<div class="subtitle-societe"><?= __("Why did we invest?","apax") ?></div>
							<?= $these_investissement_choice ?>
						</div>
					<?php } ?>
					<?php if($these_investissement){ ?>
						<div class="these-investissement">
							<div class="subtitle-societe"><?= __("How do we intend to create value?","apax") ?></div>
							<?= $these_investissement ?>
						</div>
					<?php } ?>

					<?php $history = get_field("liste_blocs_history_societe");
					if ($history && count($history)>0) {
						echo '<div class="content_history">';
							echo '<h2>'.$history[0]["annee"].'</h2>';
							// echo '<div class="subtitle-societe">'.__("Value creation","apax").'</div>
							echo '<div class="online-societe">';
								echo $history[0]["texte"];

								if ($history[0]["txt_internationalisation"] != "" || $history[0]["txt_build-ups"] != "" || $history[0]["txt_digitial"] != ""){
									echo '<ul class="nav nav-tabs" role="tablist">';
										echo $history[0]["txt_internationalisation"] != "" ? '<li role="presentation" class="col-xs-4 active"><a href="#internationalisation'.$history[0]["annee"].'" aria-controls="internationalisation'.$history[0]["annee"].'" role="tab" data-toggle="tab">'.__("International","apax").'</a></li>' : '';
										echo $history[0]["txt_build-ups"] != "" ? '<li role="presentation" class="col-xs-4'.($history[0]["txt_internationalisation"] == "" ? ' active' : '').'"><a href="#build-ups'.$history[0]["annee"].'" aria-controls="build-ups'.$history[0]["annee"].'" role="tab" data-toggle="tab">'.__("Build-ups","apax").'</a></li>' : '';
										echo $history[0]["txt_digitial"] != "" ? '<li role="presentation" class="col-xs-4'.($history[0]["txt_build-ups"] == "" && $history[0]["txt_internationalisation"] == "" ? ' active' : '').'"><a href="#digitial'.$history[0]["annee"].'" aria-controls="digitial'.$history[0]["annee"].'" role="tab" data-toggle="tab">'.__("Digital Transformation","apax").'</a></li>' : '';
									echo '</ul>
									<div class="tab-content">';

									echo $history[0]["txt_internationalisation"] != "" ? '<div role="tabpanel" class="tab-pane active" id="internationalisation'.$history[0]["annee"].'"><div class="table"><div class="ico"><img src="'.get_bloginfo("template_url").'/img/ico-internationnal.png" alt="" /></div><div>'.$history[0]["txt_internationalisation"].'</div></div></div>' : '';
									echo $history[0]["txt_build-ups"] != "" ? '<div role="tabpanel" class="tab-pane'.($history[0]["txt_internationalisation"] == "" ? ' active' : '').'" id="build-ups'.$history[0]["annee"].'"><div class="table"><div class="ico"><img src="'.get_bloginfo("template_url").'/img/ico-buildups.png" alt="" /></div><div>'.$history[0]["txt_build-ups"].'</div></div></div>' : '';
									echo $history[0]["txt_digitial"] != "" ? '<div role="tabpanel" class="tab-pane'.($history[0]["txt_build-ups"] == "" && $history[0]["txt_internationalisation"] == "" ? ' active' : '').'" id="digitial'.$history[0]["annee"].'"><div class="table"><div class="ico"><img src="'.get_bloginfo("template_url").'/img/ico-digital.png" alt="" /></div><div>'.$history[0]["txt_digitial"].'</div></div></div>' : '';

									echo '</div>';
								}
								$chiffre_cle_1=$history[0]["chiffre_cle_1_societe_manuel"];
								$chiffre_cle_2=$history[0]["chiffre_cle_2_societe_manuel"];
								$chiffre_cle_3=$history[0]["chiffre_cle_3_societe_manuel"];
								if ($chiffre_cle_1["chiffre_cle_text"] || $chiffre_cle_2["chiffre_cle_text"] || $chiffre_cle_3["chiffre_cle_text"]) {
									echo '<div class="chiffres-cles row">';
									if ($chiffre_cle_1["chiffre_cle_text"]) {
										//$share_twitter = is_array(get_field("partage_twitter_media",$chiffre_cle_1["ID"]));
										$chiffre_cle = $chiffre_cle_1;
										echo '<div class="col-sm-4">';
											include get_template_directory().'/template/chiffre-cle.php';
										echo '</div>';
									}
									if ($chiffre_cle_2["chiffre_cle_text"]) {
										//$share_twitter = is_array(get_field("partage_twitter_media",$chiffre_cle_2["ID"]));
										$chiffre_cle = $chiffre_cle_2;
										echo '<div class="col-sm-4">';
											include get_template_directory().'/template/chiffre-cle.php';
										echo '</div>';
									}
									if ($chiffre_cle_3["chiffre_cle_text"]) {
										//$share_twitter = is_array(get_field("partage_twitter_media",$chiffre_cle_3["ID"]));
										$chiffre_cle = $chiffre_cle_3;
										echo '<div class="col-sm-4">';
											include get_template_directory().'/template/chiffre-cle.php';
										echo '</div>';
									}
									echo '</div>';
								}
							echo $history[0]["texte_dessous_onglet"];
							echo '</div>';
							if(count($history)>1){
								echo '<a href="" class="read-more collapse-btn" data-toggle="adaka-collapse" data-target="#history-collapse">'.__("Previously","apax").'</a>';
							}
						echo '</div>';
							if(count($history)>1){
								echo '<div class="content_history adaka-collapse" id="history-collapse">';
								for($i=1; $i<count($history); $i++){
									echo '<div class="online-societe">';
									echo '<h2>'.$history[$i]["annee"].'</h2>';
									echo $history[$i]["texte"];
									if ($history[$i]["txt_internationalisation"] != "" || $history[$i]["txt_build-ups"] != "" || $history[$i]["txt_digitial"] != ""){
										echo '<ul class="nav nav-tabs" role="tablist">';
											echo $history[$i]["txt_internationalisation"] != "" ? '<li role="presentation" class="col-xs-4 active"><a href="#internationalisation'.$history[$i]["annee"].'" aria-controls="internationalisation'.$history[$i]["annee"].'" role="tab" data-toggle="tab">'.__("International","apax").'</a></li>' : '';
											echo $history[$i]["txt_build-ups"] != "" ? '<li role="presentation" class="col-xs-4'.($history[$i]["txt_internationalisation"] == "" ? ' active' : '').'"><a href="#build-ups'.$history[$i]["annee"].'" aria-controls="build-ups'.$history[$i]["annee"].'" role="tab" data-toggle="tab">'.__("Build-ups","apax").'</a></li>' : '';
											echo $history[$i]["txt_digitial"] != "" ? '<li role="presentation" class="col-xs-4'.($history[$i]["txt_build-ups"] == "" && $history[$i]["txt_internationalisation"] == "" ? ' active' : '').'"><a href="#digitial'.$history[$i]["annee"].'" aria-controls="digitial'.$history[$i]["annee"].'" role="tab" data-toggle="tab">'.__("Digital Transformation","apax").'</a></li>' : '';
										echo '</ul>
										<div class="tab-content">';

										echo $history[$i]["txt_internationalisation"] != "" ? '<div role="tabpanel" class="tab-pane active" id="internationalisation'.$history[$i]["annee"].'"><div class="table"><div class="ico"><img src="'.get_bloginfo("template_url").'/img/ico-internationnal.png" alt="" /></div><div>'.$history[$i]["txt_internationalisation"].'</div></div></div>' : '';
										echo $history[$i]["txt_build-ups"] != "" ? '<div role="tabpanel" class="tab-pane'.($history[$i]["txt_internationalisation"] == "" ? ' active' : '').'" id="build-ups'.$history[$i]["annee"].'"><div class="table"><div class="ico"><img src="'.get_bloginfo("template_url").'/img/ico-buildups.png" alt="" /></div><div>'.$history[$i]["txt_build-ups"].'</div></div></div>' : '';
										echo $history[$i]["txt_digitial"] != "" ? '<div role="tabpanel" class="tab-pane'.($history[$i]["txt_build-ups"] == "" && $history[$i]["txt_internationalisation"] == "" ? ' active' : '').'" id="digitial'.$history[$i]["annee"].'"><div class="table"><div class="ico"><img src="'.get_bloginfo("template_url").'/img/ico-digital.png" alt="" /></div><div>'.$history[$i]["txt_digitial"].'</div></div></div>' : '';

										echo '</div>';
									};
									$chiffre_cle_1=$history[$i]["chiffre_cle_1_societe_manuel"];
									$chiffre_cle_2=$history[$i]["chiffre_cle_2_societe_manuel"];
									$chiffre_cle_3=$history[$i]["chiffre_cle_3_societe_manuel"];
									if ($chiffre_cle_1["chiffre_cle_text"] || $chiffre_cle_2["chiffre_cle_text"] || $chiffre_cle_3["chiffre_cle_text"]) {
										echo '<div class="chiffres-cles">';
										if ($chiffre_cle_1["chiffre_cle_text"]) {
											$chiffre_cle = $chiffre_cle_1;
											echo '<div class="col-sm-4">';
												include get_template_directory().'/template/chiffre-cle.php';
											echo '</div>';
										}
										if ($chiffre_cle_2["chiffre_cle_text"]) {
											$chiffre_cle = $chiffre_cle_2;
											echo '<div class="col-sm-4">';
												include get_template_directory().'/template/chiffre-cle.php';
											echo '</div>';
										}
										if ($chiffre_cle_3["chiffre_cle_text"]) {
											$chiffre_cle = $chiffre_cle_3;
											echo '<div class="col-sm-4">';
												include get_template_directory().'/template/chiffre-cle.php';
											echo '</div>';
										}
										echo '</div>';
									}
									echo $history[$i]["texte_dessous_onglet"];
									echo '</div>';
								}
								echo '</div>';
							}
					} ?>

				</div>
			</div>
		</div>
		<div id="sidebar">
			<div class="col-lg-3 col-md-4">
				<div class="row">
				<?php global $isSidebar; $isSidebar = true; ?>

				<?php $list_bloc = get_field("list_bloc"); ?>
				<?php include "flex-content-right.php"; ?>

				<?php include 'pushs/membre_equipe.php'; ?>

				<?php include 'pushs/same_secteur.php'; ?>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<?php
			$other_lang = ICL_LANGUAGE_CODE == 'fr'?'en':'fr';
			$old_lang = ICL_LANGUAGE_CODE;

			$blog_push = false;

			$identifiant_dun_article_du_blog_interne = get_field("identifiant_dun_article_du_blog_interne");
			if ($identifiant_dun_article_du_blog_interne && $identifiant_dun_article_du_blog_interne != "") {
				$blog_push->posts = array(get_post(icl_object_id($identifiant_dun_article_du_blog_interne, 'post')));
			}

			if (!$blog_push) {
				$blog_push = new WP_Query([
					'post_type' => 'blog',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'entreprise_blog',
							'value' => get_the_ID(),
							'compare' => '='
						),
						array(
							'key' => 'entreprise_blog',
							'value' => '"'.get_the_ID().'"',
							'compare' => 'LIKE'
						),
					),
					'posts_per_page' => 1
				]);
				if(!$blog_push->have_posts()){
					$blog_push = new WP_Query([
						'post_type' => 'blog',
						'meta_query' => array(
							'relation' => 'OR',
							array(
								'key' => 'entreprise_blog',
								'value' => intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)),
								'compare' => '='
							),
							array(
								'key' => 'entreprise_blog',
								'value' => '"'.intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)).'"',
								'compare' => 'LIKE'
							),
						),
						'posts_per_page' => 1,
					]);
				}
			}

			$presse_push = false;

			$identifiant_dun_article_de_presse = get_field("identifiant_dun_article_de_presse");
			if ($identifiant_dun_article_de_presse && $identifiant_dun_article_de_presse != "") {
				$presse_push->posts = array(get_post(icl_object_id($identifiant_dun_article_de_presse, 'post')));
			}


			if (!$presse_push) {
				$presse_push = new WP_Query([
					'post_type' => 'post',
					'meta_query' => array(
						'relation' => 'OR',
						array(
							'key' => 'societe_presse',
							'value' => get_the_ID(),
							'compare' => '='
						),
						array(
							'key' => 'societe_presse',
							'value' => '"'.get_the_ID().'"',
							'compare' => 'LIKE'
						),
						array(
							'key' => 'societe_presse',
							'value' => intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)),
							'compare' => '='
						),
						array(
							'key' => 'societe_presse',
							'value' => '"'.intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)).'"',
							'compare' => 'LIKE'
						),
					),
					"suppress_filters" => true,
					"posts_per_page" => 1
				]);

				// if(!$presse_push->have_posts()){
				// 	$presse_push = new WP_Query([
				// 		'post_type' => 'post',
				// 		'meta_query' => array(
				// 			'relation' => 'OR',
				// 			array(
				// 				'key' => 'societe_presse',
				// 				'value' => intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)),
				// 				'compare' => '='
				// 			),
				// 			array(
				// 				'key' => 'societe_presse',
				// 				'value' => '"'.intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)).'"',
				// 				'compare' => 'LIKE'
				// 			),
				// 		),
				// 		"suppress_filters" => true,
				// 		"posts_per_page" => 1
				// 	]);
				//
				// }
				if ($presse_push->have_posts()) {
					$presse_push->posts[0] = get_post(icl_object_id($presse_push->posts[0]->ID));
				}

			}

			/* Count to center with offset*/
			$offset = "";
			$bloc = 0;
			if(count($blog_push->posts))		{ $bloc++; }
			if(count($presse_push->posts))	{ $bloc++; }
			// if($magazine_push)	{ $bloc++; }
			if($bloc == 2){$offset="col-md-offset-2";}
			if($bloc == 1){$offset="col-md-offset-4";}
		?>
		<div class="col-lg-offset-1 col-lg-10 col-md-12 related">
			<div class="row">
				<?php if($blog_push && count($blog_push->posts)){
					$blog = $blog_push->posts[0];
					?>
					<div class="<?= (!empty($offset)?$offset." ":"" )?>col-md-4 col-sm-6">
						<h2 class="center_underline text-blue">Apax Talks</h2>
						<?php
							$id_blog_interne = get_the_id_wpml($blog->ID);
							$isSidebar = false;
							include 'pushs/blog-same-issue.php';
						?>
						<div class="text-center">
							<a href="<?= get_post_type_archive_link("blog"); ?>?meta_key=entreprise_blog&meta_value=<?= get_the_ID(); ?>" class="read-more text-blue"><?= __("See all","apax") ?><br><strong><?= __("posts","apax") ?></strong> <br><img src="<?= get_template_directory_uri() ?>/img/plus-blue.png" alt=""></a>
						</div>
					</div>

				<?php } ?>
				<?php if($presse_push && count($presse_push->posts)){
					$press = $presse_push->posts[0];

					?>
					<div class="col-md-4 col-sm-6">
						<h2 class="center_underline"><?= __("Press","apax") ?></h2>
						<div class="block-push-presse">
							<a href="<?= get_permalink($press->ID) ?>"><span class="date"><?php echo str_replace(" ","<br/>",get_the_date(null,$press->ID)); ?></span></a>
							<?php $origine = $press->post_title;
							$cut = substr($origine,0,120);
							if ($cut < $origine) $cut .= "..."; ?>
							<h2><a href="<?php echo get_permalink($press->ID); ?>"><?php echo $cut; ?></a></h2>
							<a class="link" href="<?= get_permalink($press->ID) ?>">
								<span><?= __("Press release","apax") ?></span>
							</a>
						</div>
						<div class="text-center">
							<a href="<?= get_post_type_archive_link("post") ?>?meta_key=societe_presse&meta_value=<?= get_the_ID(); ?>" class="read-more text-red"><?= __("See all","apax") ?><br><strong><?= __("press releases","apax") ?></strong> <br><img src="<?= get_template_directory_uri() ?>/img/plus-orange.png" alt=""></a>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
