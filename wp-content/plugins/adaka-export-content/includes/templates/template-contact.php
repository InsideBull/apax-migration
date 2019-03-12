<div class="container">
	<?php 
		$sous_titre = get_field("sous-titre_page");
		if ($sous_titre && $sous_titre != "") {
			echo '<div class="baseline">'.$sous_titre.'</div>';
		} 
		
		$list_membre = get_field("list_membres");
		if ($list_membre) {
			foreach ($list_membre as $lemembre) {
				if ($lemembre["type_membre"] == "equipe") {
					$membre = $lemembre["membre_existant"];
					if ($membre->post_status == "publish") {
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($membre->ID), 'contact-membre' );
						$nom = $membre->post_title;
						$poste_membre_equipe = get_field("poste_membre_equipe",$membre->ID);
						$mail = get_field("email_membre_equipe",$membre->ID);
					}
				} else {
					$thumb = array($lemembre["photo"]["sizes"]["contact-membre"]);
					$nom = $lemembre["nom"];
					$mail = $lemembre["email"];
					$poste_membre_equipe = $lemembre["fonction"];
				}

				if ($nom != "" || $poste_membre_equipe != "") {
					if ($nom != "") {
						echo $nom;
						
						if($poste_membre_equipe != "")
							echo '<br>'.$poste_membre_equipe;
					}
					else if($poste_membre_equipe != "") {
						echo $poste_membre_equipe;
					}
					echo '<br>';
					echo '<br>';
				}

			}
		}
	
		$titre_sous_carte = get_field("titre_sous_carte");
		$texte_sous_carte = get_field("texte_sous_carte");
		if ($titre_sous_carte != "" || $texte_sous_carte != "") {
			echo '<div class="row">
					'.($titre_sous_carte ? '<h2 class="underline">'.$titre_sous_carte.'</h2>' : '').'
					'.$texte_sous_carte.'
				</div>';
		} 
		
		$siege_social = get_field("siege_social_contact");
		if ($siege_social != "") {
			echo '<div class="row">
				<div class="col-md-10 col-md-offset-1" id="siege-contact">
					<h2 class="underline">'.__("Head Office","apax").'</h2>
					'.$siege_social.'
				</div>
			</div>';
		} 
	?>
</div>