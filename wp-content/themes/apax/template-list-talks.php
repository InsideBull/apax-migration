<?php
	/* Template name: Liste des numéros de Talks */

add_filter('get_terms_orderby', function($a) { return " t.term_id"; }, 10, 1);
$issues = array_map(function($a) {
	$tmp = explode("|", $a->name);
	if(count($tmp) == 1)
		return [
			'id' => $a->term_id,
			'title' => trim($a->name),
			'date' => false,
			'day' => false
		];
	$date = substr_count($tmp[0], '.');
	if($date == 2)
		return [
			'id' => $a->term_id,
			'title' => trim($tmp[1]),
			'date' => intval(DateTime::createFromFormat('d.m.Y', trim($tmp[0]))->format('U')),
			'day' => true
		];
	return [
		'id' => $a->term_id,
		'title' => trim($tmp[1]),
		'date' => intval(DateTime::createFromFormat('m.Y', trim($tmp[0]))->format('U')),
		'day' => false
	];
}, get_terms([
	'taxonomy' => "issues",
	"hide_empty" => 1,
]));
usort($issues, function($a, $b){
	return $b['date'] - $a['date'];
});
$ele = $issues[0];
unset($issues[0]);// Prevent to display the same issue in the ajax "load more"
$issues = array_values($issues);


wp_enqueue_style('template-list-talk', get_template_directory_uri() . '/css/template-list-talk.css' );
wp_enqueue_script('template-list-talk', get_template_directory_uri() . '/js/template-list-talk.js', ["jquery"], JS_VERSION );
wp_localize_script('template-list-talk', 'talks_issues', $issues);


get_header();
if (have_posts()) :
while (have_posts()) : the_post(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="post">
				<div id="logo-talks"></div>
				<h1 class="post-title"><?php the_title(); ?></h1>
				<?php
					$sous_titre = get_field("sous-titre_page");
					if ($sous_titre && $sous_titre != "")
						echo '<div class="baseline">'.$sous_titre.'</div>';
				?>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid" id="the_col_content">
	<div class="row">
		<div class="container">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="about">
				<div class="table h-100">
					<div class="table-cell-m">
						<div class="post-content">
							<?php the_field("contenu_a_propos"); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="subscribe">
				<div class="table h-100">
					<div class="table-cell-m">
						<h3><?php _e("Subscribe", "apax"); ?></h3>
						<div class="mailchimp_forms">
							<?php print_mailchimp_form(); ?>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>


<?php
	include "template/list-numeros-current.php";
?>

<div class="container-fluid">
	<img src="<?= get_template_directory_uri().'/img/loader-apax.gif' ?>" alt="<?php _e("Loading...", "apax"); ?>" id="more-loader">
</div>

<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
