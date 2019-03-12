<?php get_header(); ?>

<section id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="post">
					<?php $sous_titre = get_field("sous-titre_page",get_option("page_for_posts")); ?>
					<h1 class="post-title<?php echo $sous_titre && $sous_titre != "" ? '' : ' no-baseline'; ?>"><?php echo get_the_title(get_option("page_for_posts")); ?></h1>
					<?php if ($sous_titre && $sous_titre != "") {
						echo '<div class="baseline">'.$sous_titre.'</div>';
					} ?>
				</div>
			</div>
		</div>
	</div>

	<?php if (have_posts()) : $show = array(); ?>
	<div id="wrap-list-article">
		<div class="container">
			<div class="row row-mini">
				<?php global $wpdb;
				$query = "SELECT DISTINCT YEAR(wposts.post_date) as year FROM $wpdb->posts wposts, ".$wpdb->prefix."icl_translations wicl_translations WHERE wposts.post_type = 'post' AND wposts.post_status = 'publish' AND wicl_translations.element_id = wposts.ID AND wicl_translations.language_code = '".ICL_LANGUAGE_CODE."' ORDER BY year DESC";
				$years = $wpdb->get_results($query);
				$active = false;
				if (isset($_GET["year"]) && $_GET["year"] != "" && $_GET["year"] != "all") $active = $_GET["year"];
				if ($years && count($years) > 0) {
					echo '<ul id="list-cat-element" class="list-year">
						<li class="cat-item-all"><a href="'.get_permalink(get_option("page_for_posts")).'?year=all"'.($active === false ? ' class="active"':'').'>'.__("ALL","apax").'</a></li>';
					foreach ($years as $year){
						echo '<li class="cat-item cat-item-'.$year->year.'"><a href="'.get_permalink(get_option("page_for_posts")).'?year='.$year->year.'"'.($active !== false && $year->year == $active ? ' class="active"':'').'>'.$year->year.'</a></li>';
					}
					echo '</ul>';
				}
				?>

				<div class="grid">

					<?php while (have_posts()) : the_post();
					if (!in_array(icl_object_id(get_the_ID(), 'post'),$show)) : $show[] = icl_object_id(get_the_ID(), 'post'); ?>

					<div class="grid-item col-md-4 col-lg-3 col-sm-6 col-xs-12 <?php echo "cat-item-".get_the_date("Y"); ?>">
						<article>
							<div class="block-article">
								<a href="<?php echo get_permalink(icl_object_id(get_the_ID(), 'post')); ?>"><span class="date"><?php echo str_replace(" ","<br/>",get_the_date()); ?></span></a>
								<?php $origine = get_the_title(icl_object_id(get_the_ID(), 'post'));
								$cut = substr($origine,0,120);
								if ($cut < $origine) $cut .= "..."; ?>
								<h2><a href="<?php echo get_permalink(icl_object_id(get_the_ID(), 'post')); ?>"><?php echo $cut; ?></a></h2>
								<a class="plus" href="<?php echo get_permalink(icl_object_id(get_the_ID(), 'post')); ?>"><?php _e("Read more","apax"); ?></a>
							</div>
						</article>
					</div>

					<?php endif; ?>
					<?php endwhile; ?>

				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

</section>

<?php get_footer(); ?>
