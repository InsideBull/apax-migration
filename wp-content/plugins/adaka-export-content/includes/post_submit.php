<?php
	
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

function render_post_template($postObj, $lang){
	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);

	global $post, $the_flex_content;
	setup_postdata($postObj);
	$post = $postObj;
	
	
	$the_flex_content = get_field("flex-content", $postObj->ID);
	$template = get_page_template_slug( $post->ID );
	$permalink = get_permalink($post);
	
	if($post->post_type == "page" && $template == "template-recherche.php"){return;}
	if(wpml_get_language_information($post->ID)['different_language']){return;}
	
	$child = get_posts("post_type=page&post_parent=".$post->ID."&orderby=menu_order&order=ASC&posts_per_page=1");
	// if(!is_search() && count($child) > 0 && get_current_page_depth() === 0){return;}
	// if(get_page_template_slug( $post->ID ) == "template-list-societe.php" ||
	// get_page_template_slug( $post->ID ) == "template-list-equipe.php" ||
		// get_page_template_slug( $post->ID ) == "template-live.php"){return;}
	// if($permalink == get_post_type_archive_link('post')){return;}

	echo '<a href="'.$permalink.'" target="_blank">'.$permalink.'</a>';
	if($post->post_type == "post" || $post->post_type == "page"){
		echo '<div class="col-lg-offset-1 col-lg-7 col-md-8">';
		$sous_titre = get_field("sous-titre_page");
			echo '<div class="post">
				<div class="post-content">
					<h1>'.((wp_get_post_parent_id($post->ID)!=$post->ID && wp_get_post_parent_id($post->ID)!=0)?get_the_title(wp_get_post_parent_id($post->ID)).' --> ': "").get_the_title().'</h1>';
					if ($sous_titre && $sous_titre != "") {
						echo '<div style="color:#0DA4B5">'.$sous_titre.'</div>';
					}
				echo '</div>
			</div>';
        
        $_yoast_wpseo_title = get_post_meta($post->ID, "_yoast_wpseo_title", true );
        if(!empty($_yoast_wpseo_title))
            echo '<blockquote style="border-left:2px solid #ddd;font-style:italic;padding-left:15px;">'.nl2br($_yoast_wpseo_title).'</blockquote>';
        $_yoast_wpseo_metadesc = get_post_meta($post->ID, "_yoast_wpseo_metadesc", true );
        if(!empty($_yoast_wpseo_metadesc))
            echo '<blockquote style="border-left:2px solid #ddd;font-style:italic;padding-left:15px;">'.nl2br($_yoast_wpseo_metadesc).'</blockquote>';
        $_yoast_wpseo_focuskw = get_post_meta($post->ID, "_yoast_wpseo_focuskw", true );
        if(!empty($_yoast_wpseo_focuskw))
            echo '<blockquote style="border-left:2px solid #ddd;font-style:italic;padding-left:15px;">'.nl2br($_yoast_wpseo_focuskw).'</blockquote>';

		$ancres = get_field("menu_dancre");
		if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>';
		
		get_template_part("flex","content");
		if($post->ID  ==  get_option( 'page_on_front' )) {
			if(file_exists(__DIR__.'/templates/home.php')) {
				include __DIR__.'/templates/home.php';
			}
		}
		
		elseif($post->post_type == "page" && !empty($template)) {
			if(file_exists(__DIR__.'/templates/'.$template)) {
				include __DIR__.'/templates/'.$template;
			}
		}
		
		echo '</div>';
	}else if($post->post_type == "societe"){ 
		include __DIR__.'/templates/single-societe.php';
	}else if($post->post_type == "team") {
		include __DIR__.'/templates/single-team.php';
	}else if($post->post_type == "expertise"){ ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="post">
						<h1 class="post-title"><?php the_title(); ?></h1>
						<?php $sous_titre = get_field("sous-titre_page"); ?>
						<?php if ($sous_titre && $sous_titre != "") {
							echo '<div class="baseline">'.$sous_titre.'</div>';
						} ?>	
						
                        <?php
        
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
					</div>
				</div>
			</div>
			
			<?php $ancres = get_field("menu_dancre");
			if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>'; ?>
			
			<?php
				get_template_part("flex","content");
				
				if(has_term( 52, 'expertise_cat', $post ) || has_term( 63, 'expertise_cat', $post )){
					// get_template_part('template/expertise-secteur');
					_e("Previous page","apax");
					echo '<br>';
					_e('Portfolio', 'apax');
					echo '<br>';
					_e('History of accompanied companies', 'apax');
					get_template_part("accordeon","content");
				}
			
				// @NEED SIDEBAR
			
			?>
		</div>
		<?php
	}else if($post->post_type == "blog"){ ?>
		<?php

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

		$related_meta_keys = [
			'entreprise_blog',
			'secteur_blog',
			'axe_blog',
			'associes_blog',
		];

		$post_list = null;
		foreach ($related_meta_keys as $meta_key) {
			$ids = wp_list_pluck( $post_list->posts, 'ID' );
			$ids[] = get_the_ID(); // Exclude current post
			if($post_list == null || count($post_list->posts) < 3){ // If not enough post add next meta_key's associated posts
				$add_post_list = new WP_Query([
					'post_type' => 'blog',
					'posts_per_page' => $count,
					'meta_key'=> $meta_key,
					'meta_value'=> get_post_meta(get_the_ID(), $meta_key, true),
					'post__not_in' => $ids,
					"post_status" => "publish"
				]);
				if($post_list->posts != null){ // If already initialised
					$post_list->posts = array_merge( $post_list->posts, $add_post_list->posts );// Merge results
				}else{
					$post_list = $add_post_list;
				}
			}
		}
		?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="post">
						<?php $sous_titre = get_field("sous-titre_page"); ?>
						<h1 class="post-title<?php echo $sous_titre && $sous_titre != "" ? '' : ' no-baseline'; ?>"><?php the_title(); ?></h1>
						<?php if ($sous_titre && $sous_titre != "") {
							echo '<div class="baseline">'.$sous_titre.'</div>';
						} ?>
                        <?php
        
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
					</div>
				</div>
			</div>

			<?php $ancres = get_field("menu_dancre");
			if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>'; ?>

			<div class="row">

				<?php if ($post_list->have_posts()): ?>
				<div class="col-lg-offset-1 col-lg-7 col-md-8">
				<?php else: ?>
				<div class="col-lg-offset-2 col-lg-8 col-md-8">
				<?php endif; ?>

					<?php get_template_part("flex","content"); ?>
					<div class="clear"></div><div class="separator"></div>
					<div class="badge-list">
						<a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=entreprise_blog&meta_value='.urlencode(get_field('entreprise_blog')->ID); ?>"><?= !empty(get_field('entreprise_blog')) ? get_field('entreprise_blog')->post_title : "" ?></a>
						<a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=secteur_blog&meta_value='.urlencode(get_field('secteur_blog')); ?>"><?= !empty(get_field('secteur_blog')) && get_field('secteur_blog') !== 1 ? get_cat_name(get_field('secteur_blog')) : "" ?></a>
						<a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=axe_blog&meta_value='.urlencode(get_field('axe_blog')); ?>"><?= !empty(get_field('axe_blog')) ? $translate_axe[ICL_LANGUAGE_CODE][get_field('axe_blog')] : "" ?></a>
						<a class="badge" href="<?php echo get_post_type_archive_link('blog').'?meta_key=associes_blog&meta_value='.urlencode(get_field('associes_blog')->ID); ?>"><?= !empty(get_field('associes_blog')) ? get_field('associes_blog')->post_title : "" ?></a>
					</div>
					<?php $associes = get_field('associes_blog'); ?>
					<div class="fiche-associes">
						<img src="<?= $thumb[0] ?>" alt="" />
						<div class="content">
							<a href="<?= get_permalink($associes->ID); ?>"><span class="name"><?php echo $associes->post_title; ?></span></a>
							<span class="post"><?= get_field("poste_membre_equipe", $associes->ID); ?></span>
							<span class="link_vcf"><a href="<?= get_field("vcard_membre_equipe", $associes->ID)['url']; ?>" title="VCard"><?= _e('Contact informations', 'apax') ?></a></span>
						</div>
					</div>
				</div>
				<?php get_sidebar("blog"); ?>
			</div>

		</div>

		<?php
		
	}
	include __DIR__.'/templates/sidebar.php';
	echo '<hr/>';
	
	
}

function post_action(){
	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);
	global $post,$sitepress;
	global $IS_EXPORT;
	$IS_EXPORT = 1;
	ob_start();
	get_header();
	get_footer();
	get_sidebar();
	ob_clean();
	ob_end_clean();
	
	$oldLang= ICL_LANGUAGE_CODE;
	$sitepress->switch_lang($_POST['lang']);

	// header('Content-Description: File Transfer');
	// header('Content-Type: application/octet-stream');
	// header('Content-Disposition: attachment; filename=export.doc');
	?><!DOCTYPE html>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>Export APAX - <?= strtoupper($_POST['lang']) ?> - <?= implode(", ", $_POST['types']) ?> - <?= date("d/m/Y") ?></title>
			<style>
				body {
					max-width: 960px;
					margin: 0 auto;
					padding: 15px;
				}
			</style>
		</head>
		<body>
			<?php
			
			ob_start();
			foreach($_POST['types'] as $type){
				$query = new WP_Query([
					'post_status' => 'publish',
					'post_type' => $type,
					"suppress_filters" => false,
					"post_parent" => 0,
					"posts_per_page" => -1,
					"orderby" => "menu_order title",
					"order" => "ASC",
				]);
				echo "<h1 style=\"border:1px solid black;text-align:center;padding:5px 0;\">Type : ".$type."</h1>";
				foreach($query->posts as $post){
					setup_postdata($post);
					render_post_template($post, $_POST['lang']);
					$child_query = new WP_Query([
						'post_status' => 'publish',
						'post_type' => $type,
						"suppress_filters" => false,
						"post_parent" => $post->ID,
						"posts_per_page" => -1,
						"orderby" => "menu_order title",
						"order" => "ASC",
					]);	
					if($child_query->have_posts()){
						foreach($child_query->posts as $child_post){
							setup_postdata($child_post);
							render_post_template($child_post, $_POST['lang']);
						}
					}
				}
			} 
			$content = ob_get_clean();
			$content = preg_replace('/<iframe.*?\/iframe>/i','', $content);
			$content = preg_replace('/<script.*?\/script>/i','', $content);
			$content = preg_replace('/<a href="https:\/\/twitter\.com\/share" .*?\/a>/i','', $content);
			$content = preg_replace('/<div class="flex-to_top">(.|\n|\t)*?<\/div>/i','', $content);
			
            preg_match_all("/<img[^>]src=\"([^\"]*)\"[^>]+\>/i", $content, $matches);
            for($i=0; $i<count($matches[0]); $i++) {
                if(pathinfo($matches[1][$i], PATHINFO_EXTENSION) == "svg") {
                    $content = str_replace($matches[0][$i], '<img src="'.$matches[1][$i].'" style="display:block;width:100%;height:auto;">', $content);
                }
                else {
                    $content = str_replace($matches[0][$i], '', $content);
                }
            }
            
			echo  $content;
			?>
			
		</body>
	</html>
	<?php
	$sitepress->switch_lang($oldLang);
	die();
}

if(isset($_POST, $_POST['lang'], $_POST['types']) && !empty($_POST['lang']) && is_array($_POST['types']) && !empty($_POST['types'])){
	add_action( 'wp_loaded', 'post_action');
}
