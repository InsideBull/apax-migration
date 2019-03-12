<div class="container">
	<?php _e("Previous page","apax"); ?><br>
	<h1 class="post-title"><?php the_title(); ?></h1>
	<?php 
		$poste_membre_equipe = get_field("poste_membre_equipe");
		if ($poste_membre_equipe && $poste_membre_equipe != "") {
			echo '<div class="baseline">'.$poste_membre_equipe.'</div>';
		}
		
		$_yoast_wpseo_title = get_post_meta($post->ID, "_yoast_wpseo_title", true );
		if(!empty($_yoast_wpseo_title))
			echo '<blockquote style="border-left:2px solid #ddd;font-style:italic;padding-left:15px;">'.nl2br($_yoast_wpseo_title).'</blockquote>';
		$_yoast_wpseo_metadesc = get_post_meta($post->ID, "_yoast_wpseo_metadesc", true );
		if(!empty($_yoast_wpseo_metadesc))
			echo '<blockquote style="border-left:2px solid #ddd;font-style:italic;padding-left:15px;">'.nl2br($_yoast_wpseo_metadesc).'</blockquote>';
		$_yoast_wpseo_focuskw = get_post_meta($post->ID, "_yoast_wpseo_focuskw", true );
		if(!empty($_yoast_wpseo_focuskw))
			echo '<blockquote style="border-left:2px solid #ddd;font-style:italic;padding-left:15px;">'.nl2br($_yoast_wpseo_focuskw).'</blockquote>';
	?>

	<div>
		<?php
			$presentation_membre_equipe = get_field("presentation_membre_equipe");
			$vcard_membre_equipe = get_field("vcard_membre_equipe");
			$linkedin_membre_equipe = get_field("linkedin_membre_equipe");
			if ($presentation_membre_equipe != "") {
				echo '<div class="presentation_membre_equipe">'.$presentation_membre_equipe.'</div>';
			}

			if ($vcard_membre_equipe) {
				echo '<p><a href="'.$vcard_membre_equipe["url"].'" target="_blank" class="link_vcf">'.__("Contact details","apax").'</a></p>';
			}

			if ($linkedin_membre_equipe) {
				echo '<p><a href="'.(substr($linkedin_membre_equipe,0,4) == "http" ? "" : "http://").$linkedin_membre_equipe.'" target="_blank" class="link_linkedin">'.__("Linkedin","apax").'</a></p>';
			}
		?>
	</div>

	<?php 
	$other_lang = $lang == 'fr'?'en':'fr';
	$old_lang = $lang;

	$blog_push = false;

	if (!$blog_push) {
		$blog_push = new WP_Query([
			'post_type' => 'blog',
			'meta_key'		=> 'associes_blog',
			'meta_value'	=> get_the_ID(),
			'post_limits' => 1,
			"post_status" => "publish"
		]);
		if(!$blog_push->have_posts()){
			$blog_push = new WP_Query([
				'post_type' => 'blog',
				'meta_key'		=> 'associes_blog',
				'meta_value'	=> intval(icl_object_id(get_the_ID(), 'post', true, $other_lang)),
				'post_limits' => 1,
				"post_status" => "publish"
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
			"post_status" => "publish",
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
			),
			"suppress_filters" => false,
			"posts_per_page" => 1
		]);

		if(!$presse_push->have_posts()){
			$presse_push = new WP_Query([
				'post_type' => 'post',
				"post_status" => "publish",
				'meta_query' => array(
					'relation' => 'OR',
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
			if ($presse_push->have_posts()) {
				$presse_push->posts[0] = get_post(icl_object_id($presse_push->posts[0]->ID));
			}
		}

	}


	$offset = "";
	$bloc = 0;
	if($blog_push->posts)		{ $bloc++; }
	if($presse_push->posts)	{ $bloc++; }
	if($bloc == 2){$offset="col-md-offset-2";}
	if($bloc == 1){$offset="col-md-offset-4";}

	?>


	<?php

	if((is_object($blog_push) && count($blog_push->posts)) || (is_object($presse_push) && count($presse_push->posts))) { ?>
		<div>
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
						<a href="<?= get_post_type_archive_link("blog"); ?>?meta_key=associes_blog&meta_value=<?= get_the_ID(); ?>" class="read-more text-blue"><?= __("See all","apax") ?><br><strong><?= __("posts","apax") ?></strong> <br><img src="<?= get_template_directory_uri() ?>/img/plus-blue.png" alt=""></a>
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
	<?php } ?>





	<?php


	$args = array(
		"post_type" => "societe",
		"post_status" => "publish",
		"posts_per_page" => -1,
		"orderby" => "title",
		"order" => "ASC",
		'meta_query'	=> array(
			'relation' => 'OR',
			array(
				'key'	 	=> 'liste_membres_team',
				'value'	  	=> '"'.get_the_ID().'"',
				'compare' 	=> 'LIKE',
			),
			array(
				'key'	 	=> 'liste_membres_team',
				'value'	  	=> '"'.icl_object_id(get_the_ID(), 'team', false, $other_lang).'"',
				'compare' 	=> 'LIKE',
			),
		),
		'suppress_filters' => false
	);
	$societe = new WP_Query($args);
	$ele = $societe->posts;
	// $ele = get_field("entrepreneurs_membre_equipe");
	if ($ele && count($ele)>0) { ?>
		<div>
			<h2><?php _e("Entrepreneurs currently supported","apax"); ?></h2>
		</div>
		<?php include "template/list-societe-no-gutters.php"; ?>
	<?php } ?>
</div>