<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head <?php language_attributes(); ?>>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo("template_url"); ?>/img/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="<?php bloginfo("template_url"); ?>/img/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo("template_url"); ?>/img/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php bloginfo("template_url"); ?>/img/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo("template_url"); ?>/img/favicon/favicon-16x16.png">
		<link rel="manifest" href="<?php bloginfo("template_url"); ?>/img/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php bloginfo("template_url"); ?>/img/favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<title><?php wp_title("",false,"none"); ?></title>
		<?php wp_head(); ?>
		<?php if ($post->post_parent): ?>
		<script type="text/javascript">document.location.href="<?php echo get_permalink($post->post_parent); ?>";</script>
		<?php endif; ?>
	</head>
	<body <?php body_class(ICL_LANGUAGE_CODE); ?>>

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<?php echo '<img src="'.$post->guid.'" alt="'.$post->post_title.'" title="'.$post->post_title.'" />'; ?>

<?php endwhile; ?>
<?php endif; ?>

<?php wp_footer(); ?>
	</body>
</html>