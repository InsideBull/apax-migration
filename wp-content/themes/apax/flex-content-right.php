<?php
if ($list_bloc) {

	foreach ($list_bloc as $blocs) {
		switch ($blocs["acf_fc_layout"]) {

			case "bloc_du_blog":
				// Ancien code blog interne
				// $list_id_blog = array();
				// $lst_art = wp_query_link_api([
				// 	"p" => $blocs["article_talks"]->ID
				// ]);
				// if ($lst_art) {
				// 	foreach ($lst_art as $la) {
				// 		$list_id_blog[$la["id"]] = $la;
				// 	}
				// }
				// foreach ($list_id_blog as $id_blog=>$blog)
				// 	include 'pushs/blog.php';
				if(!empty($blocs['article_talks']) && isset($blocs['article_talks']->ID)){
					$id_blog_interne = $blocs['article_talks']->ID;
					include 'pushs/blog-same-issue.php';
				}
				break;

			case "last_actu_blog":
				$list_id_blog = array();
				$lst_art = wp_query_link_api([
					"posts_per_page" => $blocs["nb_actu"] && $blocs["nb_actu"] != "" ? $blocs["nb_actu"] : 1,
					"post_type" => "blog"
				]);
				if ($lst_art) {
					foreach ($lst_art as $la) {
						$list_id_blog[$la["id"]] = $la;
					}
				}
				foreach ($list_id_blog as $id_blog=>$blog)
					include 'pushs/blog.php';
				break;

			case "categorie_du_blog":
				$list_id_blog = array();
				$lst_art = wp_query_link_api([
					"posts_per_page" => $blocs["nb_article_blog"] && $blocs["nb_article_blog"] != "" ? $blocs["nb_article_blog"] : 3,
					"post_type" => "blog",
					'tax_query' => [[
						'taxonomy' => 'talks_cat',
						'field'    => 'term_id',
						'terms'    => $blocs["categorie"]
					]]
				]);
				if ($lst_art) {
					foreach ($lst_art as $la) {
						$list_id_blog[$la["id"]] = $la;
					}
				}
				foreach ($list_id_blog as $id_blog=>$blog)
					include 'pushs/blog.php';
				break;

			case "dernier_article_blog_societe":
				$list_id_blog = array();
				$id_categorie = $blocs["id_tag_article"];
				$lst_art = wp_query_link_api([
					"posts_per_page" => $blocs["nb_article_blog"] && $blocs["nb_article_blog"] != "" ? $blocs["nb_article_blog"] : 3,
					"post_type" => "blog",
					'meta_query' => [
						"relation" => "OR",
						[
							'key' => 'entreprise_blog',
							'value' => $id_categorie,
							'compare' => "="
						],
						[
							'key' => 'entreprise_blog',
							'value' => '%"'.$id_categorie.'"%',
							'compare' => "LIKE"
						]
					]
				]);
				if ($lst_art) {
					foreach ($lst_art as $la) {
						$list_id_blog[$la["id"]] = $la;
					}
				}
				foreach ($list_id_blog as $id_blog=>$blog)
					//include 'pushs/blog.php';
				break;

			case "tag_du_blog":
				$list_id_blog = array();
				// $id_tag = $blocs["id_tag"];
				// $nb_article = $blocs["nb_article_blog"] && $blocs["nb_article_blog"] != "" ? $blocs["nb_article_blog"] : 3;

				$lst_art = wp_query_link_api([
					"posts_per_page" => $blocs["nb_article_blog"] && $blocs["nb_article_blog"] != "" ? $blocs["nb_article_blog"] : 3,
					"post_type" => "blog",
					'tax_query' => [[
						'taxonomy' => 'talks_cat',
						'field'    => 'term_id',
						'terms'    => $blocs["id_tag"]
					]]
				]);
				// $lst_art = json_decode(file_get_contents(URL_WP_API_BLOG_ARTICLE.'?tags-api='.$id_tag.'&per_page='.$nb_article.'&lang='.ICL_LANGUAGE_CODE),true);
				if ($lst_art) {
					foreach ($lst_art as $la) {
						$list_id_blog[$la["id"]] = $la;
					}
				}
				foreach ($list_id_blog as $id_blog=>$blog)
					include 'pushs/blog.php';
				break;

			case "bloc_image_texte":
				$image = $blocs["image"] ? $blocs["image"]["sizes"]["image-push"] : false;
				$blank = array_key_exists('blank', $blocs) && is_array($blocs["blank"]) && count($blocs["blank"])>0;
				$alt_image = $blocs["image"] ? $blocs["image"]["alt"] : '';
				$title = $blocs["titre"];
				$text = $blocs["texte"];
				$link = $blocs["lien"];
				include 'pushs/image-text.php';
				break;

			case "bloc_secteur_spe":
				include 'pushs/secteur_spe.php';
				break;

			case "bloc_document":
				$image = $blocs["image"] ? $blocs["image"]["sizes"]["image-push"] : false;
				$document = $blocs["document"];
				if ($document) {
					$filetype = wp_check_filetype($document["filename"]);
					$extension = $filetype["ext"];
				}
				include 'pushs/document.php';
				break;

			case "bloc_image":
				$image = $blocs["image"] ? $blocs["image"]["sizes"]["image-push-full"] : false;
				$alt_image = $blocs["image"] ? $blocs["image"]["alt"] : '';
				$link = $blocs["lien"];
				$blank = is_array($blocs["blank"]);
				include 'pushs/image.php';
				break;

			case "bloc_du_blog_interne":
				$id_blog_interne = $blocs["id_blog_interne"];
				if(is_front_page()){
					include 'pushs/blog-apax-home.php';
				}else{
					include 'pushs/blog-same-issue.php';
				}
				break;

			case "bloc_dernier_blog_interne":
				$last_post = get_posts("post_type=blog&posts_per_page=1");
				if (count($last_post)==1) {
					$id_blog_interne = get_the_id_wpml($last_post[0]->ID);
					if(is_front_page()){
						include 'pushs/blog-apax-home.php';
					}else{
						include 'pushs/blog-same-issue.php';
					}
				}
				break;
		}
	}
} ?>
