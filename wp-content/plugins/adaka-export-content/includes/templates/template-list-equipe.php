<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<h1 class="post-title"><?php the_title(); ?></h1>
				<?php $sous_titre = get_field("sous-titre_page");
				if ($sous_titre && $sous_titre != "") {
					echo '<div class="baseline">'.$sous_titre.'</div>';
				} ?>

				<?php
					echo '<div>';
					echo __("Activities", "apax").'<br>';
					foreach(get_field_object('field_5a3141f504b2c')['choices'] as $v) {
						echo __($v, "apax").'<br>';
					}
					echo '</div>';

					$current = isset($_GET['cat']) ?$_GET['cat'] :-1;
					$categories = get_terms('category','hide_empty=0&exclude=1,3');
					if ($categories && count($categories) > 0) {
						echo '<div>';
						echo __("Sectors", "apax").'<br>';
						foreach ($categories as $categorie){
							echo $categorie->name.'<br>';
						}
						echo '</div>';
					}
					
					echo '<div>';
					echo __("Functions", "apax").'<br>';
					foreach(get_field_object('field_5a3144b7507c5')['choices'] as $v) {
						echo __($v, "apax").'<br>';
					}
					echo '</div>';
				?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-offset-3 col-md-3">
			<?php _e("All companies","apax"); ?>
			<?php _e("of our","apax"); ?>
			<span><?php _e("portfolio","apax"); ?></span><br/>
		</div>
		<div class="col-md-3">
			<?php _e("See ","apax"); ?><span><?php _e("history","apax"); ?></span>
			<?php _e("of companies currently supported","apax"); ?><br/>
		</div>
	</div>
</div>