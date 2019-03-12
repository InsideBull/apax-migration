<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('NEED_IMPORT_IMAGE', false);

$cat_matching = [
	'Words from experts' => 61,
	'CEO Interviews' => 60,
	'Apax Partners\' value added' => 62,
	'Interviews de dirigeants' => 47,
	'La valeur ajoutée d\'Apax Partners' => 59,
	'Paroles d\'experts' => 58,
];
$json = file_get_contents('export.json');
$posts = json_decode($json, true);

$posts = array_reverse ( $posts );

$redirections = [
	'request' => [],
	'destination' => []
];


foreach ($posts as $key => $post) {
	// Insert Fr post
	$args_fr = [
		'post_title' => $post['post_title']['fr'],
		'post_date' => $post['post_date'],
		'post_status' => 'publish',
		'post_type' => 'blog',
		'post_author' => 1,
	];
	//var_dump($args_fr);
	$fr_post_id = wp_insert_post($args_fr);
	if(!empty($post['post_thumbnail'])){
		$thumbnail_id = generate_featured_image($post['post_thumbnail'], $fr_post_id);// Thumbnail
	}
	update_field('extrait', $post['post_excerpt']['fr'], $fr_post_id);//Excerpt
	update_field('temps_lecture_blog', $post['temps_lecture'], $fr_post_id);//Time
	update_field('flex-content', [['texte' => propre($post['post_content']['fr']), "acf_fc_layout" => "texte"]], $fr_post_id);//Post content

	// Insert En post
	$args_en = [
		'post_title' => $post['post_title']['en'],
		'post_date' => $post['post_date'],
		'post_status' => 'publish',
		'post_type' => 'blog',
		'post_author' => 1,
	];
	$en_post_id = mwm_wpml_translate_post($fr_post_id, $args_en, 'blog', 'en');
	if(!empty($post['post_thumbnail'])){
		set_post_thumbnail($en_post_id, $thumbnail_id);
	}
	update_field('extrait', $post['post_excerpt']['en'], $en_post_id);//Excerpt
	update_field('temps_lecture_blog', $post['temps_lecture'], $en_post_id);//Time
	update_field('flex-content', [['texte' => propre($post['post_content']['en']), "acf_fc_layout" => "texte"]], $en_post_id);//Post content

	//fr
	$redirections['request'][] = $post['post_permalink'];
	$redirections['destination'][] = get_permalink($fr_post_id);
	//en
	$redirections['request'][] = $post['post_permalink_en'];
	$redirections['destination'][] = get_permalink($en_post_id);

	//Taxonomies
	$term_ids_fr = [];
	$term_ids_en = [];
	foreach ($post['categories'] as $cat) {
		$id_fr = term_exists($cat['name'], 'talks_cat');
		if(empty($id_fr)){ // Create it
			// Matching array
			if(array_key_exists($cat['name'], $cat_matching)){ // Tableau de correspondance
				$id_fr = $cat_matching[$cat['name']];
			}else{
				$id_fr = wp_insert_term(clean_bad_chars($cat['name']), 'talks_cat');
			}
		}
		$term_ids_fr[] = is_array($id_fr)?$id_fr['term_id']:$id_fr;

		$id_en = term_exists($cat['nameEn'], 'talks_cat');
		if(empty($id_en) && !empty($cat['nameEn'])){ // Create it
			if(array_key_exists($cat['nameEn'], $cat_matching)){ // Tableau de correspondance
				$id_en = $cat_matching[$cat['nameEn']];
			}else{
				$id_en = mwm_wpml_translate_taxonomy($id_fr['term_id'], $cat['nameEn'], 'talks_cat', 'en');
			}
		}
		$term_ids_en[] = is_array($id_en)?$id_en['term_id']:$id_en;
	}
	wp_set_post_terms($fr_post_id, $term_ids_fr, 'talks_cat');
	wp_set_post_terms($en_post_id, $term_ids_en, 'talks_cat');

	// Issues
	$term_ids_fr = [];
	$term_ids_en = [];
	foreach ($post['issues'] as $cat) {
		$id_fr = term_exists($cat['name'], 'issues');
		if(empty($id_fr)){ // Create it
			$_POST['icl_tax_issues_language'] = 'fr';
			$id_fr = wp_insert_term(clean_bad_chars($cat['name']), 'issues');
		}
		$term_ids_fr[] = $id_fr['term_id'];

		$id_en = term_exists($cat['nameEn'], 'issues');
		if(empty($id_en) && !empty($cat['nameEn'])){ // Create it
			$id_en = mwm_wpml_translate_taxonomy($id_fr['term_id'], $cat['nameEn'], 'issues', 'en');
		}
		$term_ids_en[] = $id_en['term_id'];
	}
	wp_set_post_terms($fr_post_id, $term_ids_fr, 'issues');
	wp_set_post_terms($en_post_id, $term_ids_en, 'issues');

	// import_img_attachements($fr_post_id);
	// import_img_attachements($en_post_id);

	$tags_not_found = [];
	foreach ($post['tags'] as $cat) {
		// Find team
		$found = false;
		$team = new WP_Query(['post_type'=>'team', 'title'=>$cat['name'], 'post_status'=>'publish', 'posts_per_page'=>1]);
		if(count($team->posts)>0){
			$found = true;
			$id = icl_object_id($team->posts[0]->ID, 'team', true, 'fr');
			update_field('associes_blog', $id, $fr_post_id);
			$id = icl_object_id($team->posts[0]->ID, 'team', true, 'en');
			update_field('associes_blog', $id, $en_post_id);
		}
		// Find society
		$societe = new WP_Query(['post_type'=>'societe', 'title'=>$cat['name'], 'post_status'=>'publish', 'posts_per_page'=>1]);
		if(count($societe->posts)>0){
			$found = true;
			$id = icl_object_id($societe->posts[0]->ID, 'team', true, 'fr');
			update_field('entreprise_blog', $id, $fr_post_id);
			$id = icl_object_id($societe->posts[0]->ID, 'team', true, 'en');
			update_field('entreprise_blog', $id, $en_post_id);
		}

		if(!$found){
			$tags_not_found[] = $cat['name'];
		}
	}
	if(!empty($tags_not_found)){
		echo "\r\n".$post['post_title']['fr'].' : '.implode(', ', $tags_not_found)."\r\n";
	}
}

save_redirects($redirections);

// We <3 SPIP
function propre($str){
	$str = str_replace('style="text-align: justify;"', '', $str);
	return $str;
}

/**
 * Creates a translation of a post (to be used with WPML)
 *
 * @param int $post_id The ID of the post to be translated.
 * @param array $post_translated_args The post args passed to wp_insert_post, only title is required.
 * @param string $post_type The post type of the post to be transaled (ie. 'post', 'page', 'custom type', etc.).
 * @param string $lang The language of the translated post (ie 'fr', 'de', etc.).
 *
 * @return the translated post ID
 *  */
function mwm_wpml_translate_post( $post_id, $post_translated_args, $post_type, $lang ){

    // Include WPML API
    include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms-2/inc/wpml-api.php' );


    // Insert translated post
	$post_translated_args['post_type'] = $post_type;
    $post_translated_id = wp_insert_post( $post_translated_args );

    // Get trid of original post
    $trid = wpml_get_content_trid( 'post_' . $post_type, $post_id );

    // Get default language
    $default_lang = wpml_get_default_language();

	$updates = array(
	  'trid' => $trid,
	  'language_code' => $lang,
	  'source_language_code' => $default_lang
	);
	$where = array(
	  'element_type' => 'post_' . $post_type,
	  'element_id' => $post_translated_id
	);

    // Associate original post and translated post
    global $wpdb;
	$wpdb->update($wpdb->prefix . 'icl_translations', $updates, $where);

    // Return translated post ID
    return $post_translated_id;

}

/**
 * Creates a translation of a post (to be used with WPML)
 *
 * @param int $term_id The ID of the post to be translated.
 * @param array $term_translated_name The name passed to wp_insert_term
 * @param string $taxonomy The taxonomy type to be transaled (ie. 'category', 'tag', 'custom', etc.).
 * @param string $lang The language of the translated post (ie 'fr', 'de', etc.).
 *
 * @return the translated term ID
 *  */
function mwm_wpml_translate_taxonomy( $term_id, $term_translated_name, $taxonomy, $lang ){
	global $sitepress;
	global $wpdb;
	$trid = $sitepress->get_element_trid($term_id, 'tax_' . $taxonomy);

	$_POST['icl_tax_' . $taxonomy . '_language'] = $lang;
    // $inserted_term = wp_insert_term($term_translated_name, $taxonomy, array('slug' => $term_translated_slug.'-'.$lang));
    $inserted_term = wp_insert_term($term_translated_name, $taxonomy);

	$updates = array(
	  'trid' => $trid,
	  'language_code' => $lang,
	  'source_language_code' => 'fr'
	);
	$where = array(
	  'element_type' => 'tax_' . $taxonomy,
	  'element_id' => $inserted_term['term_id']
	);

	$wpdb->update($wpdb->prefix . 'icl_translations', $updates, $where);

    // Return translated post ID
    return $inserted_term;
}

function save_redirects($data) {
    $redirects = [];


    for($i = 0; $i < sizeof($data['request']); ++$i) {
            $request = trim( sanitize_text_field( $data['request'][$i] ) );
            $destination = trim( sanitize_text_field( $data['destination'][$i] ) );

            if ($request == '' && $destination == '') { continue; }
            else { $redirects[$request] = $destination; }
    }

	echo(serialize($redirects));

    //update_option('301_redirects', $redirects);
}

/**
* Downloads an image from the specified URL and attaches it to a post as a post thumbnail.
*
* @param string $file    The URL of the image to download.
* @param int    $post_id The post ID the post thumbnail is to be associated with.
* @param string $desc    Optional. Description of the image.
* @return string|WP_Error Attachment ID, WP_Error object otherwise.
*/
function generate_featured_image( $image_url, $post_id){
	$upload_dir = wp_upload_dir();
    $image_data = @file_get_contents($image_url);
	if($image_data === FALSE){
		$image_data = @file_get_contents(str_replace('http://localhost/vierge', 'http://apax-talks.fr', $image_url));
		if($image_data === FALSE){
			var_dump('Thumbnail error [post_id = '.$post_id.'] : '.$image_url.'');
			return;
		}
	}
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $attach_id = insert_image_in_wordpress($file, $post_id);

    $res2= set_post_thumbnail( $post_id, $attach_id );
	return $attach_id;
}

function insert_image_in_wordpress($path, $post_id){
	$filename = basename($path);
	$wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $path, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $path );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	return $attach_id;
}

function import_img_attachements($post_id){
	if(!NEED_IMPORT_IMAGE){
		return;
	}
	//Extract URLS
	$content = get_post_field('post_content', $post_id);
	preg_match_all('/<img.*?src="(.*?)".*?>/', $content, $matches);
	$urls = $matches[1];
	foreach ($urls as $image_url) {
		if(strpos($image_url, 'apax-talks.fr') !== FALSE || strpos($image_url, 'localhost/vierge') !== FALSE){

			//$image_url = str_replace('localhost/vierge', 'apax-talks.fr', $image_url);
			$upload_dir = wp_upload_dir();
		    $image_data = @file_get_contents($image_url);
			if($image_data === FALSE){
				if($image_data === FALSE){
					var_dump('Image error : '.$image_url.'');
					return;
				}
			}

		    $filename = sanitize_file_name(basename($image_url));

		    if(wp_mkdir_p($upload_dir['path']))
				$file = $upload_dir['path'] . '/' . $filename;
		    else
				$file = $upload_dir['basedir'] . '/' . $filename;

			if(!file_exists($file)){
				file_put_contents($file, $image_data);
			}

			$attach_id = insert_image_in_wordpress($file, $post_id);

			//Replace old url by the new
			$content = str_replace($image_url, wp_get_attachment_url($attach_id), $content);
		}
	}
	wp_update_post([
		'ID' => $post_id,
		'post_content' => $content,
	]);
}

function clean_bad_chars($str){
	$str = str_replace('’', '\'', $str);
	return $str;
}
