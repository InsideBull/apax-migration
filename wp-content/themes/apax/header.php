<?php
if (get_the_ID() !== false) {
	$child = get_posts("post_type=page&post_parent=".get_the_ID()."&orderby=menu_order&order=ASC&posts_per_page=1");
	if (!is_search() && count($child) > 0 && get_current_page_depth() === 0) header("Location: ".get_permalink($child[0]->ID));
} ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head <?php language_attributes(); ?>>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
		
		<?php if (get_the_ID() == 7197 || is_post_type_archive('blog') || is_singular('blog') || is_tax('talks_cat') || is_tax('issues')): ?>
		<meta name="google-site-verification" content="6Z9UUlYs5T_sqJJSxMw7qhMs9nO1pzJGUZj_NXyrzOE" />
		<?php endif; ?>
		
		<title><?php wp_title("",false,"none"); ?></title>
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(ICL_LANGUAGE_CODE); ?>>
		<header>
			<div id="header">
				<div id="bg-mobile-header"><a href="<?php bloginfo("home"); ?>"><img src="<?php bloginfo("template_url"); ?>/img/logo-white.png" alt="" /></a></div>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<a href="<?php bloginfo("home"); ?>" id="logo"><?php _e("Home","apax"); ?><span></span></a>
							<nav class="wrap_search">
								<div id="search">
									<a href="<?php echo get_permalink(get_the_id_wpml(255)); ?>" id="show_search"><?php _e("Search","apax"); ?></a>
									<a href="https://investors-extranet.apax.fr/extranet/" target="_blank" id="bt-invest">
										<span class="hidden-sm hidden-xs"><?php _e("Investors access","apax"); ?></span>
										<span class="hidden-md hidden-lg"><?php _e("Investors","apax"); ?></span>
									</a>
									<?php //get_search_form(); ?>
									<div class="clear"></div>
								</div>

								<?php wp_nav_menu( array(
									'theme_location' => 'menu_principal',
									'items_wrap' => main_menu_wrap(),
									'walker' => new themeslug_walker_nav_menu
								)); ?>

								<div id="header-social">
									<?php $cpl = is_front_page() ?'_home' :''; ?>
									<a id="header-newsletter" href="#"><img src="<?php bloginfo("template_url"); ?>/img/social/newsletter_header<?= $cpl ?>.svg" alt="NewsLetter" /></a>
									<a id="header-linkedin" href="https://www.linkedin.com/company/apax-partners-sas" target="_blank"><img src="<?php bloginfo("template_url"); ?>/img/social/linkedin_header<?= $cpl ?>.svg" alt="LinkedIn" /></a>
									<a id="header-twitter" href="https://twitter.com/ApaxPartners_FR" target="_blank"><img src="<?php bloginfo("template_url"); ?>/img/social/twitter_header<?= $cpl ?>.svg" alt="Twitter" /></a>
								</div>
							</nav>
							<div class="clear"></div>
						</div>
					</div>
				</div>
				<a href="#" id="menu_oc_min">
					<span><?php _e("Menu","apax"); ?></span>
					<span></span>
					<span></span>
					<span></span>
				</a>
			</div>
		</header>
