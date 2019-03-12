<?php global $real_post_id; get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<h1 class="post-title"><?php _e("Protected","apax"); ?></h1>
			</div>
		</div>
	</div>
	<div class="row">
		<?php echo get_the_password_form(isset($real_post_id) ?$real_post_id :get_the_ID()); ?>
	</div>
</div>
<?php get_footer(); ?>
