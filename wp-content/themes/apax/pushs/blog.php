<?php if ($id_blog && array_key_exists($id_blog,$list_id_blog)) : ?>

<?php $image = $list_id_blog[$id_blog]["image-push"]; ?>

<?php if (!empty($isSidebar)): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
	<a href="<?php echo $list_id_blog[$id_blog]["link"]; ?>" target="_blank" class="block-push block-push-blog<?php echo $image && $image != "" ? '' : ' block-push-notick'; ?>">
		<?php echo $image && $image != "" ? '<span class="wrap-image"><span><img src="'.$image.'" /></span></span>':'' ?>
		<span class="wrap-content">
			<span class="content"><?php echo $list_id_blog[$id_blog]["title"]["rendered"]; ?></span>
		</span>
		<?php $temps = $list_id_blog[$id_blog]["temps"];
		if ($temps && $temps != "0" && $temps != ""): ?>
		<span class="time"><?php echo $list_id_blog[$id_blog]["temps"]; ?>MN</span>
		<?php endif; ?>
		<span class="date"><?php echo date(ICL_LANGUAGE_CODE == "fr" ? "d.m.Y" : "Y.m.d",strtotime($list_id_blog[$id_blog]["date"])); ?></span>
		<span class="link">
			<?php if (ICL_LANGUAGE_CODE == "fr") {
				echo '<span>Magazine</span> <span>digital</span>';
			} else {
				echo '<span>Digital</span> <span>magazine</span>';
			} ?>
		</span>
	</a>
<?php if (!empty($isSidebar)): ?></div><?php endif; ?>
<?php endif; ?>
