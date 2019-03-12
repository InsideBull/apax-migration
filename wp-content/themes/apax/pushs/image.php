<?php if ($image): ?>
<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
<a <?php echo $link != "" ? 'href="'.$link.'" '.($blank ? 'target="_blank" ': '') : ''; ?>class="block-push block-push-image-full">
	<?php /*<span class="wrap-content-full-img" style="background-image: url(<?php echo $image; ?>);">*/ ?>
		<span class="wrap-image"><span><img src="<?php echo $image; ?>" alt="<?php echo $alt_image; ?>" /></span></span>
	<?php /*</span>*/ ?>
</a>
<?php if ($isSidebar): ?></div><?php endif; ?>
<?php endif; ?>
