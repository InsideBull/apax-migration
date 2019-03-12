<form method="get" id="form" action="<?php bloginfo('url'); ?>/">
	<?php echo is_search() ? '<a href="#" id="resetSearch">'.__("Reset","apax").'</a>' : ''; ?>
	<input type="text" value="<?php the_search_query(); ?>" placeholder="<?php _e("Your research","apax"); ?>" name="s" id="s"<?php echo get_page_template_slug() == "template-recherche.php" ? ' autofocus' : ''; ?>>
	<input type="submit" id="submit">
</form>