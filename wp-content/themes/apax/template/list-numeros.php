<?php

	$talks = new WP_Query([

		'post_type' => 'blog',

		'posts_per_page' => -1,

		'tax_query' => [[

			'taxonomy' => 'issues',

			'field'    => 'term_id',

			'terms'    => $ele['id']

		]],

		'order' => "DESC",

		'orderby' => "date"

	]);



	if(!$talks->have_posts())

		return;

?>

<div class="col-xs-12 col-md-10 col-md-offset-1 talks-list">

	<div class="list-talks-puce">

		<span></span>

	</div>

	<div class="issues-title" data-date="<?= date('Ym', $ele['date']) ?>">

		<?php print_issu_date($ele); ?>

	</div>

	<div class="clear"></div>



	<div class="row">

		<?php foreach($talks->posts as $k => $p) { ?>

			<div class="col-xs-12 col-sm-12 col-md-4">

				<div class="item">

					<?php

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



						$img = get_the_post_thumbnail_url( $p, "talks_current" );

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

							<h3><?= $p->post_title ?></h3>

							<p><?php the_field("extrait", $p->ID); ?></p>

						</div>
						<div class="wrap-content-footer"></div>	
						<?php

							$time = get_field("temps_lecture_blog", $p->ID);

							if(!empty($time))

								echo '<span class="time">'.$time.'MN</span>';

						?>

						<span class="date">

							<?= DateTime::createFromFormat('Y-m-d H:i:s', $p->post_date)->format('d.m.Y') ?>

						</span>

						<span href="<?= get_permalink($p->ID) ?>" class="link">

							<?php

								$cats = wp_get_post_terms( $p->ID, "talks_cat");

								if(empty($cats))

									_e("Lire la suite", "apax");

								else

									echo $cats[0]->name;

							?>

						</span>

					</div>

					<a class="hover-link" href="<?= get_permalink($p->ID) ?>"></a>

				</div>

			</div>

		<?php } ?>

	</div>

</div>

