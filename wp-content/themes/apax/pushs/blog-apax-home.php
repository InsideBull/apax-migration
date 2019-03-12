<?php $p = get_post($id_blog_interne); 
	if (isset($p)):
	$img = get_the_post_thumbnail_url( $p, "talks_current" );

	// detect if the is a yt embed
	$content = str_replace(']]>', ']]&gt;', apply_filters('the_content', $p->post_content));
	global $the_flex_content;
	$the_flex_content = get_field("flex-content", $p->ID);
	ob_start();
	get_template_part("flex","content");
	$post_content = ob_get_contents();
	ob_end_clean();
	$re = '/src="https:\/\/www\.youtube\.com\/embed\//';
	$is_video = (preg_match_all($re, $post_content, $matches, PREG_SET_ORDER, 0) != 0);

	if(!empty($img)) { ?>
		<span class="wrap-image">
			<span>
				<?= get_the_post_thumbnail($p->ID,"image-push") ?>
				<a href="<?= get_permalink($p->ID) ?>" class="hover-link"></a>
			</span>
			<?php if ($is_video): ?>
				<span class="play-button"></span>
			<?php endif; ?>
		</span>
	<?php } ?>
	<div class="bg">
		<div class="wrap-content">
			<img class="svg talks-logo" src="<?= get_template_directory_uri() ?>/img/apax-talks-logo.svg">
			<h3><?= $p->post_title ?></h3>
			<span class="content-min">
				<p><?php the_field("extrait", $p->ID); ?></p>
			</span>
		</div>
		<?php
		$time = get_field("temps_lecture_blog", $p->ID);
		if(!empty($time))
		echo '<span class="time">'.$time.'MN</span>';
		?>
		<span class="date">
			<?= DateTime::createFromFormat('Y-m-d H:i:s', $p->post_date)->format('d.m.Y') ?>
		</span>
		<span class="link">
			<?php
			$cats = wp_get_post_terms( $p->ID, "talks_cat");
			if(empty($cats))
			_e("Lire la suite", "apax");
			else
			echo $cats[0]->name;
			?>
		</span>
	</div>
	<a href="<?= get_permalink($p->ID) ?>" class="hover-link"></a>
<?php endif; ?>