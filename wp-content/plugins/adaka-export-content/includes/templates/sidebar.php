<?php
	
$list_bloc = get_field("list_bloc", $post->ID);
if ($list_bloc) {
	foreach ($list_bloc as $blocs) {
		switch ($blocs["acf_fc_layout"]) {
			case "bloc_image_texte":
				$image = $blocs["image"] ? $blocs["image"]["sizes"]["image-push"] : false;
				$blank = array_key_exists('blank', $blocs) && is_array($blocs["blank"]) && count($blocs["blank"])>0;
				$alt_image = $blocs["image"] ? $blocs["image"]["alt"] : '';
				$title = $blocs["titre"];
				$text = $blocs["texte"];
				$link = $blocs["lien"];
				
				echo $title != "" ? '<span class="title">'.$title.'</span>' : '';
				echo $text != "" ? '<span class="content-min">'.$text.'</span>' : '';
				_e('Read more','apax');
					
				break;

			case "bloc_secteur_spe":
				?><div class="title"><?php _e("4 sectors","apax"); ?><br/><?php _e("of specialisation","apax"); ?></div><?php
				break;
		}
	}
}