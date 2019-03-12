<?php
if(!isset($isSidebar)){
	$isSidebar = false;
}
?>
<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>

<a <?php echo $link != "" ? 'href="'.$link.'" ' : ''; ?>class="block-push block-push-image-text<?php echo !$image ? ' block-push-notick':''; ?>"<?php echo $blank ? ' target="_blank"':''; ?>>
	<?php echo $image ? '<span class="wrap-image"><span><img src="'.$image.'" alt="'.$alt_image.'" /></span></span>' : ''; ?>
	<span class="wrap-content">
		<?php echo $title != "" ? '<span class="title">'.$title.'</span>' : ''; ?>
		<?php echo $text != "" ? '<span class="content-min">'.$text.'</span>' : ''; ?>
	</span>
	<?php echo $link != '' ? '<span class="link"><span>'.__('Read more','apax').'</span></span>': ''; ?>
</a>
<?php if ($isSidebar): ?></div><?php endif; ?>
