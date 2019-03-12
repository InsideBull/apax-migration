<?php $args = array(
	"hide_empty" => 0,
	"title_li" => "",
	"exclude" => array(1,33,34)
);
$category = get_categories($args);
if ($category && count($category)>0): ?>
<?php if ($isSidebar): ?><div class="col-md-12 col-sm-6"><?php endif; ?>
<div class="block-push block-push-secteur-spe">
	<div class="title"><?php _e("4 sectors","apax"); ?><br/><?php _e("of specialisation","apax"); ?></div>
	
	<ul class="bt-click">
		<?php foreach ($category as $c){
			echo '<li><a href="'.get_permalink(get_the_id_wpml(139)).'?cat='.$c->term_id.'">'.$c->name.'</a></li>';
		} ?>
	</ul>
</div>
<?php if ($isSidebar): ?></div><?php endif; ?>
<?php endif; ?>