<?php
global $isSidebar; $isSidebar = true;
$list_bloc = get_field("list_bloc");
if (is_single()) {
	$doc = get_field("pdf_version_article");
}
if ($list_bloc ||isset($doc)): ?>
<div class="col-lg-3 col-md-4">
	<div id="sidebar">
		<div class="row">
		<?php if (isset($doc)) {
			$image = get_bloginfo("template_url").'/img/book.jpg';
			$document = $doc;
			if ($document) {
				$filetype = wp_check_filetype($document["filename"]);
				$extension = $filetype["ext"];
			}
			include 'pushs/document.php';
		} ?>
		
		<?php if (get_post_type() != "post") include "flex-content-right.php"; ?>
		
		</div>
	</div>
</div>

<?php endif; ?>
