<?php
/*

You can set the variable $accordeon_post_id to get an accordeon from an other page/post

Filters has been implemented for the sector template.

Filters availables :
	term_ids : array if term ids.


*/
global $accordeon_post_id;
global $accordeon_filters;
$content = get_field("liste_accordeon");
if(empty($content) && isset($accordeon_post_id)){
	$content = get_field("liste_accordeon", $accordeon_post_id);
}
if ($content && count($content)>0) {
	echo '<div id="accordeon-list">';
	foreach ($content as $cont){
		$accordeon_counter = 0;
		if(isset($accordeon_filters)){
			foreach ($cont["liste_societes"] as $ls) {
				$cat = $ls["categorie"];
				if(!in_array($cat->term_id, $accordeon_filters['term_ids'])){ // Filter by term_ids
					continue;
				}
				$accordeon_counter++;
			}
		}
		if(!isset($accordeon_filters) || $accordeon_counter > 0){
			echo '<h2>'.$cont["titre"].'</h2>';
			if ($cont["liste_societes"]) {
				echo '<div class="list-societe">';
				foreach ($cont["liste_societes"] as $ls) {
					$cat = $ls["categorie"];
					if(isset($accordeon_filters) && !in_array($cat->term_id, $accordeon_filters['term_ids'])){ // Filter by term_ids
						continue;
					}
					// if (in_array($cat->term_id, array(18,21,22))) $cat->description = $cat->name;
					$cat->description = $cat->name;
					echo '<h3 class="title_societe'.($cat ? ' cat-item-'.$cat->term_id : '').'"><span>'.$ls["nom_societe"].($cat ? ' <span class="cat"> - '.$cat->description.'</span>': '').'</span></h3>';
					echo '<div class="content_societe"><div class="wrap-info">'
					.($ls["logo"] ? '<div class="logo"><img src="'.$ls["logo"]["sizes"]["chiffre-cle-societe"].'" alt="'.$ls["logo"]["alt"].'" /></div>' : '')
					.'<div class="info_societe">'
					.($ls["date_dinvestissement"] != "" ? '<div class="date_invest">'.__("Investment date:","apax").' '.$ls["date_dinvestissement"].'</div>' : '')
					.($ls["description"] != "" ? '<div class="description">'.$ls["description"].'</div>' : '')
					.'</div>'
					.'</div></div>';
				}
				echo '</div>';
			}
		}
		// var_dump_pre($cont);
		// echo '<div class="content_history">'.$h["texte"].'</div>';
	}
	echo '</div>';
} ?>
