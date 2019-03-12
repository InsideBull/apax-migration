<?php if ($document): ?>
<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
<a href="<?php echo $document["url"]; ?>" target="_blank" class="block-push block-push-document<?php echo !$image ? ' block-push-notick':''; ?>">
	<?php echo $image ? '<span class="wrap-image"><span><img src="'.$image.'" alt="'.(isset($alt_image)?$alt_image:'').'" /></span></span>' : ''; ?>
	<span class="wrap-content">
		<?php echo $document["title"] != "" ? '<span class="title">'.str_replace("_", " ", $document["title"]).'</span>' : ''; ?>
	</span>
	<?php /*<span class="date"><?php echo date(ICL_LANGUAGE_CODE == "fr" ? "d.m.Y" : "Y.m.d",strtotime($document["date"])); ?></span>*/ ?>
	<span class="link link_doc"><?php echo $extension; ?></span>
</a>
<?php if ($isSidebar): ?></div><?php endif; ?>
<?php endif; ?>
