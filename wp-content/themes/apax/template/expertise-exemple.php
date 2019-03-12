<?php get_header(); ?>

<div class="container">

	<div class="row">
		<div class="col-md-12">
			<div class="post">				
				<a href="<?= get_permalink(get_the_id_wpml(7310)) ?>" class="col-lg-offset-1" id="link_back"><?php _e("Previous page","apax"); ?></a>
				<?php $sous_titre = get_field("sous-titre_page"); ?>
				<h1 class="post-title<?php echo $sous_titre && $sous_titre != "" ? '' : ' no-baseline'; ?>"><?php echo get_the_title(); ?></h1>
				<?php if ($sous_titre && $sous_titre != "") {
					echo '<div class="baseline">'.$sous_titre.'</div>';
				} ?>				
			</div>
		</div>
	</div>
	
	<?php
		$ancres = get_field("menu_dancre");
		if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>'; 
	?>
	
	<div class="row">
	
		<?php ob_start();
		get_sidebar();
		$sidebar = ob_get_clean();
		?>
		
		<?php echo empty($sidebar) ?
		'<div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8">'
		:
		'<div class="col-lg-offset-1 col-lg-7 col-md-8">'; ?>
		
		
			<?php get_template_part("flex","content"); ?>

		</div>
			
		<?php 
		if (!empty($sidebar)) echo $sidebar; 
		?>
		
	</div>
</div>

<?php get_footer(); ?>
