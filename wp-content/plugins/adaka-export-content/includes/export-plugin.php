<?php
function a_display_form(){

	global $title;

	$types = get_post_types(['public'=>true], 'objects');

	$langs = icl_get_languages();

?>

<div class="wrap">

		<h2>Export des contenus</h2>

		<hr>

		<form method="post" action="">

			<div class="form-group">

				<label>Langage</label>

				<select class="form-control" name="lang" id="lang-field">

					<?php foreach($langs as $key => $lang): ?>

						<option value="<?= $key ?>" <?= ($key=="fr"?"selected":"") ?>><?= $lang['translated_name'] ?></option>

					<?php endforeach; ?>

				</select>

			</div>

			<div class="form-group">

				<label>Type</label>

				<select class="form-control" name="types[]" id="post-type-field" multiple>

					<?php foreach($types as $type): ?>

						<?php if($type->name !== "attachment"): ?>

							<option value="<?= $type->name ?>"><?= $type->labels->name ?></option>

						<?php endif; ?>

					<?php endforeach; ?>

				</select>

			</div>

			<button class="button button-primary">Exporter</button>

		</form>

	<div>

	<link rel="stylesheet" type="text/css" href="<?= get_home_url() ?>/wp-content/plugins/adaka-export-content/css/admin.css">

	<script type="text/javascript" src="<?= get_home_url() ?>/wp-content/plugins/adaka-export-content/js/admin.js"></script>


<?php
}