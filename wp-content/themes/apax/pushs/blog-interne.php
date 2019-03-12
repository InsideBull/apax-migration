<?php
/**
 * ===== Update 25/01/2017 =====
 * Implementation de l'element "bloc du blog interne"
 * @subject Forfait d'evolution du site
 * @author Anthony DUPLAT
 */

$blog = get_post($id_blog_interne); ?>
<?php if ($blog): ?>
<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
<a href="<?= get_permalink(get_the_id_wpml($blog->ID)) ?>" class="blog-list-item block-push block-push-blog-interne">
	<span class="wrap-image"><span><?= get_the_post_thumbnail($blog->ID,"image-push") ?></span></span>
	<div class="wrap-content">
		<div class="content hidden-sm hidden-md"><?php echo wp_trim_words($blog->post_title,23); ?></div>
		<div class="content hidden-xs hidden-sm hidden-lg"><?php echo wp_trim_words($blog->post_title,8); ?></div>
		<div class="content hidden-xs hidden-md hidden-lg"><?php echo wp_trim_words($blog->post_title,15); ?></div>
		<div class="associes"><?php if(get_field("associes_blog",$blog->ID)){echo get_field("associes_blog",$blog->ID)->post_title;} ?></div>
	</div>
	<?php $temps = get_field('temps_lecture_blog',$blog->ID);
	if ($temps && $temps != "0" && $temps != ""): ?>
	<span class="time"><?php echo $temps ?>MN</span>
	<?php endif; ?>
	<span class="date"><?php echo date(ICL_LANGUAGE_CODE == "fr" ? "d.m.Y" : "Y.m.d",strtotime($blog->post_date)); ?></span>
	<span class="link">
		<?php if (ICL_LANGUAGE_CODE == "fr") {
			echo '<span>Blog</span>';
		} else {
			echo '<span>Blog</span>';
		} ?>
	</span>
</a>
<?php if ($isSidebar): ?></div><?php endif; ?>
<?php endif; ?>
