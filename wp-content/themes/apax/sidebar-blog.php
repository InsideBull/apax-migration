<?php
global $isSidebar, $post_list; $isSidebar = false;

?>
<div class="col-lg-3 col-md-4">
	<div id="sidebar" class="sidebar-blog">
		<div class="row">
			<div class="heading">
				<?php if($post_list->have_posts()): ?>
				<div class="title"><?php _e("On the same issue","apax"); ?></div>
				<?php endif; ?>
			</div>
			<?php
			if($post_list->have_posts()){
				foreach ($post_list->posts as $k=>$post){
					if ($k < 3){
						$id_blog_interne = $post->ID;
						include 'pushs/blog-same-issue.php';
					}
				}
			}
			?>
		</div>
	</div>
</div>
