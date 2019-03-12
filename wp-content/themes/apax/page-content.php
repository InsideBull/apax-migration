<?php get_header(); ?>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				
				<?php if (!post_password_required()): ?>
				
				<?php $sous_titre = get_field("sous-titre_page"); ?>
				<h1 class="post-title<?php echo $sous_titre && $sous_titre != "" ? '' : ' no-baseline'; ?>"><?php echo is_single() ? get_the_title(get_option("page_for_posts")) : get_the_title(); ?></h1>
				<?php if ($sous_titre && $sous_titre != "") {
					echo '<div class="baseline">'.$sous_titre.'</div>';
				} ?>
				
				<?php else: ?>
				
				<h1 class="post-title"><?php _e("Protected","apax"); ?></h1>
				
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php 
	
	if (!post_password_required()):
	
		$ancres = get_field("menu_dancre");
		if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>'; 
	
	endif; 
	?>
		

	<div class="row">
		<?php if (!post_password_required()): ?>
		
		
		<div class="col-lg-offset-1 col-lg-7 col-md-8">		
		
			<?php if (is_single()) {
				echo '<div class="post">
					<div class="post-content">
						<h2>'.get_the_title().'</h2>
					</div>
				</div>';
			} ?>

			<?php get_template_part("flex","content"); ?>

			<?php if (is_single()) {
				include "template/addthis.php";
			} ?>

			</div>

			<?php get_sidebar(); ?>
		
		<?php else: ?>
		
		<?php echo get_the_password_form(); ?>
		
		<?php endif; ?>
		
	</div>
</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
