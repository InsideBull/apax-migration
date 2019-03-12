<?php $cur_cat = get_the_category();
if (!empty($cur_cat)): ?>

	<?php $id_cat = $cur_cat[0]->term_id;
	$name_cat = $cur_cat[0]->name;
	$list_societe = get_posts("post_type=societe&posts_per_page=-1&order=ASC&orderby=title&exclude=".get_the_ID()."&category=".$id_cat);
	if ($list_societe && count($list_societe)>0):
		$html = '';
		foreach ($list_societe as $k=>$ls) {
			if (!is_array(get_field("show_in_historical",$ls->ID))){
				$html .=  '<li><a href="'.get_permalink($ls->ID).'">'.$ls->post_title.'</a></li>';
			}
		}
	?>
		<?php if (!empty($html)): ?>
			<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
				<div class="block-push block-push-same-secteur">
					<?php if (ICL_LANGUAGE_CODE == "en"): ?>
					<div class="title"><?php _e("All","apax"); ?> <?php echo $name_cat != "TMT" ? ucfirst(strtolower($name_cat)) : $name_cat; ?> <br/><?php _e("companies","apax"); ?></div>
					<?php else: ?>
					<div class="title"><?php _e("All","apax"); ?> <?php _e("companies","apax"); ?><br/><?php echo $name_cat != "TMT" ? ucfirst(strtolower($name_cat)) : $name_cat; ?></div>
					<?php endif; ?>

					<ul class="lst-societe-secteur">
						<?php echo $html; ?>
					</ul>
				</div>
			<?php if ($isSidebar): ?></div><?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endif; ?>
