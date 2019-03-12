<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head <?php language_attributes(); ?>>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title><?php wp_title("",false,"none"); ?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(ICL_LANGUAGE_CODE); ?>>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<?php $sous_titre = get_field("sous-titre_page"); ?>
				<h1 class="post-title<?php echo $sous_titre && $sous_titre != "" ? '' : ' no-baseline'; ?>"><?php echo is_single() ? get_the_title(get_option("page_for_posts")) : get_the_title(); ?></h1>
				<?php if ($sous_titre && $sous_titre != "") {
					echo '<div class="baseline">'.$sous_titre.'</div>';
				} ?>
			</div>
		</div>
	</div>
	
	<?php $ancres = get_field("menu_dancre");
	if ($ancres) echo '<div class="row" id="lstancres"><div class="col-lg-offset-1 col-md-7"><div class="post"><div class="post-content">'.$ancres.'</div></div></div></div>'; ?>
	
	<div class="row">
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
	</div>
</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>