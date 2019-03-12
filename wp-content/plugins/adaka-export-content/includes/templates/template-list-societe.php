<div class="container">
	<div>
		<?php 
			$sous_titre = get_field("sous-titre_page");
			if ($sous_titre && $sous_titre != "") {
				echo '<div class="baseline">'.$sous_titre.'</div>';
			}
			echo '<div>';
			echo __("Activities", "apax").'<br>';
			foreach(get_field_object('field_5a310c19d7303')['choices'] as $v) {
				echo __($v, "apax").'<br>';
			}
			echo '</div>';

			$current = isset($_GET['cat']) ?$_GET['cat'] :-1;
			$categories = get_terms('category','hide_empty=0&exclude=1,3,33,34');
			if ($categories && count($categories) > 0) {
				echo '<div>';
				echo __("Sectors", "apax").'<br>';
				foreach ($categories as $categorie){
					echo $categorie->name.'<br>';
				}
				echo '</div>';
			}
		?>
	</div>

	<?= __("BUDGET", "apax") ?><br>
	<?= __("REVENUE", "apax") ?>

	<div class="row">
		<div class="col-md-offset-4 col-md-4">
			<?php if ($lang == "en"): ?>
				<?php _e("Previously","apax"); ?>
				<span><?php _e("supported","apax"); ?></span><br/>
				<?php _e("companies","apax"); ?>
			<?php else: ?>
				<?php _e("Voir l'","apax"); ?><span><?php _e("historique","apax"); ?></span><br/>
				<?php _e("des sociétés accompagnées","apax"); ?>
			<?php endif; ?>
		</div>
	</div>

</div>