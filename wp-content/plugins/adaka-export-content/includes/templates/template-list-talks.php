<div class="container">
	<?php
		$sous_titre = get_field("sous-titre_page");
		if ($sous_titre && $sous_titre != "")
			echo '<div class="baseline">'.$sous_titre.'</div>';
	?>
</div>

<div class="post-content">
	<?php the_field("contenu_a_propos"); ?>
</div>
<h3><?php _e("Subscribe", "apax"); ?></h3>

<div class="container-fluid">
	<?php _e("Loading...", "apax"); ?>
</div>