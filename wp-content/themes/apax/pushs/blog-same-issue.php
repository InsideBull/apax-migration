<?php
$blog = get_post($id_blog_interne); ?>
<?php if ($blog):
	$img = get_the_post_thumbnail_url( $blog, "talks_current" );
	// detect if the is a yt embed
	$content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $blog->post_content));
	global $the_flex_content;
	$the_flex_content = get_field("flex-content", $blog->ID);
	ob_start();
	get_template_part("flex","content");
	$post_content = ob_get_contents();
	ob_end_clean();
	$re = '/src="https:\/\/www\.youtube\.com\/embed\//';
	$is_video = (preg_match_all($re, $post_content, $matches, PREG_SET_ORDER, 0) != 0);
?>
<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
	<div class="talks-list">
<div class="item">
		<?php if(!empty($img)) { ?>
				<span class="wrap-image">
					<span>
						<?= get_the_post_thumbnail($blog->ID,"image-push") ?>
						<a href="<?= get_permalink($blog->ID) ?>" class="hover-link"></a>
					</span>
					<?php if ($is_video): ?>
						<span class="play-button"></span>
					<?php endif; ?>
				</span>
			<?php } ?>
	<div class="bg">
		<div class="wrap-content">
			<h3><?= $blog->post_title ?></h3>
			<p><?php the_field("extrait", $blog->ID); ?></p>
		</div>
		<?php
			$time = get_field("temps_lecture_blog", $blog->ID);
			if(!empty($time))
				echo '<span class="time">'.$time.'MN</span>';
		?>
		<span class="date">
			<?= DateTime::createFromFormat('Y-m-d H:i:s', $blog->post_date)->format('d.m.Y') ?>
		</span>
		<span href="<?= get_permalink($blog->ID) ?>" class="link">
			<?php
				$cats = wp_get_post_terms( $blog->ID, "talks_cat");
				if(empty($cats))
					_e("Lire la suite", "apax");
				else if(is_array($cats))
					echo $cats[0]->name;
			?>
		</span>
	</div>
	<a class="hover-link" href="<?= get_permalink(get_the_id_wpml($blog->ID)) ?>"></a>
</div>
</div>
<?php if ($isSidebar): ?></div><?php endif; ?>
<?php endif; ?>
