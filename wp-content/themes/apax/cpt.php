<?php
add_action( 'init', 'cptui_register_my_cpts' );
function cptui_register_my_cpts() {
	$labels = array(
		"name" => __( 'Sociétés', '' ),
		"singular_name" => __( 'Société', '' ),
		"all_items" => __( 'Toutes les sociétés', '' ),
		"add_new" => __( 'Ajouter', '' ),
		"add_new_item" => __( 'Ajouter une société', '' ),
		"edit_item" => __( 'Modifier', '' ),
		"new_item" => __( 'Modifier la société', '' ),
		"view_item" => __( 'Voir la société', '' ),
		"search_items" => __( 'Recherche une société', '' ),
		"not_found" => __( 'Aucun résultat', '' ),
		"not_found_in_trash" => __( 'Aucun résultat dans la corbeille', '' ),
		"parent" => __( 'Société parente', '' ),
		"featured_image" => __( 'Photo de l\'entrepreneur', '' ),
		);

	$args = array(
		"label" => __( 'Sociétés', '' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"menu_icon" => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FscXVlXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iODAwcHgiIGhlaWdodD0iNjM5LjA0cHgiIHZpZXdCb3g9IjEwMCA4MC40OCA4MDAgNjM5LjA0IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDEwMCA4MC40OCA4MDAgNjM5LjA0IiB4bWw6c3BhY2U9InByZXNlcnZlIj48cGF0aCBmaWxsPSJub25lIiBkPSJNOTAwLDQ3MC43MTJ2LTI2LjM2OEw1NDYuNTc1LDM5My4xMlYxMzMuMjE2aDI0LjY1NmwtMjEuOTItNTIuNzM2SDEyNy40bC0yMS45Miw1Mi43MzZoMjQuNjU2djU1MEgxMDB2MzYuMzA0aDgwMHYtMzYuMzA0aC0zMC4xMzdWNDY2LjM0NEw5MDAsNDcwLjcxMnogTTI1Ni4xNiw2MzkuMjcxaC01NC43OTJWNTI5LjY4OGg1NC43OTJWNjM5LjI3MXogTTI1Ni4xNiw0NzQuODg4aC01NC43OTJWMzY1LjMwNGg1NC43OTJWNDc0Ljg4OHogTTI1Ni4xNiwzMTAuNTA0aC01NC43OTJWMjAwLjkxMmg1NC43OTJWMzEwLjUwNHogTTM2NS43NTIsNjM5LjI3MUgzMTAuOTZWNTI5LjY4OGg1NC43OTJWNjM5LjI3MXogTTM2NS43NTIsNDc0Ljg4OEgzMTAuOTZWMzY1LjMwNGg1NC43OTJWNDc0Ljg4OHogTTM2NS43NTIsMzEwLjUwNEgzMTAuOTZWMjAwLjkxMmg1NC43OTJWMzEwLjUwNHogTTQ3NS4zNDQsNjM5LjI3MWgtNTQuNzkyVjUyOS42ODhoNTQuNzkyVjYzOS4yNzF6IE00NzUuMzQ0LDQ3NC44ODhoLTU0Ljc5MlYzNjUuMzA0aDU0Ljc5MlY0NzQuODg4eiBNNDc1LjM0NCwzMTAuNTA0aC01NC43OTJWMjAwLjkxMmg1NC43OTJWMzEwLjUwNHogTTgxMS42OTYsNjM5LjI3MUg1NjYuMzg0VjQ5MS4zMjhoMjQ1LjMxMlY2MzkuMjcxeiIvPjwvc3ZnPg==",
		"hierarchical" => false,
		"rewrite" => array( "slug" => "portefeuille/portfolio", "with_front" => true ),
		"query_var" => true,

		"supports" => array( "title", "thumbnail", "revisions"),
		"taxonomies" => array( "category" ),
	);
	register_post_type( "societe", $args );

	$labels = array(
		"name" => __( 'Equipes', '' ),
		"singular_name" => __( 'Equipe', '' ),
		"all_items" => __( 'Toutes les équipes', '' ),
		"add_new" => __( 'Ajouter', '' ),
		"add_new_item" => __( 'Ajouter une équipe', '' ),
		"edit_item" => __( 'Modifier', '' ),
		"new_item" => __( 'Nouvelle équipe', '' ),
		"view_item" => __( 'Voir l\'équipe', '' ),
		"search_items" => __( 'Rechercher une équipe', '' ),
		"not_found" => __( 'Aucun résultat', '' ),
		"not_found_in_trash" => __( 'Aucun résultat dans la corbeille', '' ),
		"parent" => __( 'Equipe parent', '' ),
		"featured_image" => __( 'Photo de profil', '' ),
		);

	$args = array(
		"label" => __( 'Equipes', '' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"menu_icon" => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FscXVlXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iNjg1LjMxMnB4IiBoZWlnaHQ9IjQ4MHB4IiB2aWV3Qm94PSIxNTcuMzQ0IDE2MCA2ODUuMzEyIDQ4MCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAxNTcuMzQ0IDE2MCA2ODUuMzEyIDQ4MCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGc+PHBhdGggZmlsbD0ibm9uZSIgZD0iTTUwNy43NTIsMzU3LjUxMmM1NC41MiwwLDk4Ljc3NS00NC4yMzEsOTguNzc1LTk4Ljc2OEM2MDYuNTIsMjA0LjIzMiw1NjIuMjcyLDE2MCw1MDcuNzUyLDE2MGMtNTQuNDgsMC05OC43MzYsNDQuMjMyLTk4LjczNiw5OC43NTJDNDA5LjAxNiwzMTMuMjgsNDUzLjI3MiwzNTcuNTEyLDUwNy43NTIsMzU3LjUxMnoiLz48cGF0aCBmaWxsPSJub25lIiBkPSJNMzAzLjgxNiwzODMuODU2YzQ5LjQxNiwwLDg5LjUyMS00MC4xMTIsODkuNTIxLTg5LjU2YzAtNDkuNDQtNDAuMTEyLTg5LjU0NC04OS41MjEtODkuNTQ0Yy00OS40MjQsMC04OS41MzYsNDAuMTEyLTg5LjUzNiw4OS41NDRDMjE0LjI3MiwzNDMuNzUyLDI1NC4zOTIsMzgzLjg1NiwzMDMuODE2LDM4My44NTZ6Ii8+PHBhdGggZmlsbD0ibm9uZSIgZD0iTTgwMi42NDgsNDEwLjMyOGMtMTAuNzY4LTkuOC0xMS4wNDgtNzcuMDgtMTEuMDQ4LTgwLjE2YzAtMC4wNDgsMC0wLjA5NiwwLTAuMTQ0YzAtNDQuMzQ0LTM1Ljk2OC04MC4yOTYtODAuMjg4LTgwLjI5NmMtNDQuMjg4LDAtODAuMjU2LDM1Ljk1Mi04MC4yNTYsODAuMjk2YzAsMC0wLjA3Miw3MC4yOC0xMS4wNCw4MC4yOTZoOTEuMjk2bDAsMGwwLDBoOTEuMzM2VjQxMC4zMjh6Ii8+PHBhdGggZmlsbD0ibm9uZSIgZD0iTTczMS45NTEsNDI3Ljg3MmMxNy44NzIsMTYuNDk2LDE5LjE1MiwyNC4yMzEsMTkuMTg1LDI1LjczNmMwLDAuMTU5LDAsMC4yNzksMCwwLjI3OWMtMC4zOTMsMi0xLjkxMiw0LjA2NC00LjE0NSw2LjA0OGMtMi41ODQsMi4yNjUtNi4xNjgsNC40NC0xMC4zMDQsNi4yOGMtNy41NjgsMy40MjQtMTYuOTg0LDUuNzg0LTI1LjM0NCw1Ljc4NGMtOC41MjgsMC0xOC4xMjgtMi40MjQtMjUuNzY5LTUuOTM2Yy00LjE0NC0xLjg4OS03LjY4OC00LjA4LTEwLjE5MS02LjM3N2MtMi4wOTctMS45MDMtMy41MDQtMy44NzEtMy44OTYtNS43ODNjMC0wLjAxNywwLTAuMiwwLjA0LTAuNTYxYzAuMTY4LTIuMDMyLDIuMTkyLTkuOCwxOS4xODUtMjUuNDg3Yy0xOS45NjksMy44NTUtMzguNDQ4LDEzLjI0Ny01NC4zNzYsMjYuODMxYy0yOS40OTYtNDcuNDA3LTc2LjEyLTc4LjA0Ny0xMjguNTg0LTc4LjA0N2MtNDUuNTkzLDAtODYuNzM2LDIzLjE2OC0xMTYuMTEyLDYwLjM3NWMtMjQuNDY0LTIyLjQ4OC01NC44NzItMzUuODE1LTg3LjgzMi0zNS44MTVjLTgwLjg1NSwwLTE0Ni40NjQsODAuMjE2LTE0Ni40NjQsMTc5LjExMmMwLDMzLDIxLjg0LDU5LjY4OCw0OC44MjQsNTkuNjg4aDE5My45MjhoMS4zNDRoMjE0YzEuNDE2LDAsMi44LTAuMTI4LDQuMTc2LTAuMjQ4YzEuMzUzLDAuMTUyLDIuNzY5LDAuMjQ4LDQuMTg1LDAuMjQ4aDE3NS4wNjNjMjQuMjE3LDAsNDMuNzkyLTIzLjkzNiw0My43OTItNTMuNTI4Qzg0Mi42NDgsNTA2LjQwOCw3OTQuNjQ4LDQ0MCw3MzEuOTUxLDQyNy44NzJ6IE0zMzEuMzEyLDQzMi4zNDRjLTAuMTQ0LDEuNTA0LTEuNzA0LDcuNTQ0LTE1Ljk2LDIwLjAzMmwtMy41NzYsMy4xNmwxOS4wNDgsMTI5Ljg4OGwtMjAuNTM2LDI0LjI5NmwtMy43MTIsNC4zNzZsLTIuNzYsMy4yNjVsLTIuNzY4LTMuMjY1bC0zLjY4LTQuMzc2bC0yMC41MzYtMjQuMzEybDE5LjA0OC0xMjkuODcybC0zLjYwOC0zLjE0NWMtMTQuOTM2LTEzLjA5Ni0xNS45MjgtMTkuMTQ0LTE1Ljk2LTIwLjIzMWMwLTAuMTEyLDAtMC4yLDAtMC4yYzAuMjgtMS4zNzYsMS4zMDUtMi44LDIuODU2LTQuMTY4YzEuNzc1LTEuNTYsNC4yNDgtMy4wNjQsNy4xMi00LjM0NGM1LjIzOS0yLjM0NSwxMS43Ni0zLjk4NCwxNy41MjctMy45ODRjNS44NzIsMCwxMi40OTYsMS42ODgsMTcuODA4LDQuMTEyYzIuODMyLDEuMjk2LDUuMjcyLDIuODE1LDcuMDA5LDQuMzkyYzEuNDQ3LDEuMzI4LDIuNDM5LDIuNjcyLDIuNjg4LDRDMzMxLjMxMiw0MzEuOTY4LDMzMS4zNDQsNDMyLjA5NiwzMzEuMzEyLDQzMi4zNDR6IE01MzguMDk2LDQxMC45ODRjLTAuMTQ1LDEuNjU2LTEuODcyLDguMzI4LTE3LjU5MiwyMi4xMTJsLTMuOTY5LDMuNDczbDIxLjAzMiwxNDMuMjQ4bC0yMi42NTYsMjYuOGwtNC4wNzEsNC44MzJsLTMuMDQ5LDMuNTkybC0zLjA0OC0zLjU5MmwtNC4xMDQtNC44NDFsLTIyLjYyNC0yNi44bDIwLjk5Mi0xNDMuMjMxbC0zLjk2LTMuNDczYy0xNi40OTYtMTQuNDM5LTE3LjU2MS0yMS4wOTYtMTcuNjMyLTIyLjI5NWMwLTAuMTQ0LDAtMC4yMzIsMC0wLjIzMmMwLjMxOS0xLjUxMiwxLjQ1NS0zLjA5NiwzLjE4NC00LjU5MmMxLjk0NC0xLjczNiw0LjY3Mi0zLjM5Miw3Ljg1NS00LjhjNS43NzYtMi41OTIsMTIuOTIxLTQuMzkyLDE5LjI4OC00LjM5MmM2LjUxMywwLDEzLjgxNiwxLjg0LDE5LjY1Niw0LjUxMmMzLjE1MiwxLjQ1Niw1LjgzMiwzLjEyOCw3Ljc1Miw0Ljg1NmMxLjU5MiwxLjQ1NiwyLjY0OCwyLjk1MiwyLjk3Nyw0LjM5MkM1MzguMTM2LDQxMC41NzYsNTM4LjEzNiw0MTAuNzIsNTM4LjA5Niw0MTAuOTg0eiIvPjwvZz48L3N2Zz4=",
		"hierarchical" => false,
		"rewrite" => array( "slug" => "equipe", "with_front" => true ),
		"query_var" => true,

		"supports" => array( "title", "thumbnail", "revisions" ),
		"taxonomies" => array( "category","post_tag" ),
	);
	register_post_type( "team", $args );


	$labels = array(
		"name" => __( 'Expertises', '' ),
		"singular_name" => __( 'Expertise', '' ),
		"all_items" => __( 'Toutes les expertises', '' ),
		"add_new" => __( 'Ajouter', '' ),
		"add_new_item" => __( 'Ajouter une expertise', '' ),
		"edit_item" => __( 'Modifier', '' ),
		"new_item" => __( 'Nouvelle expertise', '' ),
		"view_item" => __( 'Voir l\'expertise', '' ),
		"search_items" => __( 'Rechercher une expertise', '' ),
		"not_found" => __( 'Aucun résultat', '' ),
		"not_found_in_trash" => __( 'Aucun résultat dans la corbeille', '' ),
		"parent" => __( 'Expertise parent', '' ),
		);

	$args = array(
		"label" => __( 'Expertises', '' ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"show_ui" => true,
		"show_in_rest" => false,
		"rest_base" => "",
		"has_archive" => false,
		"show_in_menu" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"menu_icon" => "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDUwIDUwIiBoZWlnaHQ9IjUwcHgiIGlkPSJMYXllcl8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MCA1MCIgd2lkdGg9IjUwcHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxwYXRoIGQ9Ik0xOCwzOXY0YzAsMS4xLDAuOSwyLDIsMmgxMCAgYzEuMSwwLDItMC45LDItMnYtNEgxOHoiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS13aWR0aD0iMiIvPjxyZWN0IGZpbGw9Im5vbmUiIGhlaWdodD0iNTAiIHdpZHRoPSI1MCIvPjxwYXRoIGQ9Ik0zMiwzOWMwLTEsMC00LjAyMSwwLTYgIGMwLTUuMzg1LDctNS41NjgsNy0xNWMwLTcuNzMzLTYuMjY4LTE0LTE0LTE0cy0xNCw2LjI2Ny0xNCwxNGMwLDkuNjMzLDcsMTAuNjkyLDcsMTVjMCwxLjMwNSwwLDYsMCw2IiBmaWxsPSJub25lIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIHN0cm9rZS1taXRlcmxpbWl0PSIxMCIgc3Ryb2tlLXdpZHRoPSIyIi8+PHBhdGggZD0iTTI4LDQ1YzAsMS42NTYtMS4zNDQsMy0zLDMgIHMtMy0xLjM0NC0zLTMiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbWl0ZXJsaW1pdD0iMTAiIHN0cm9rZS13aWR0aD0iMiIvPjxsaW5lIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzAwMDAwMCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2Utd2lkdGg9IjIiIHgxPSIyNSIgeDI9IjI1IiB5MT0iMjMiIHkyPSIzNiIvPjxwb2x5bGluZSBmaWxsPSJub25lIiBwb2ludHM9IjIxLDE5IDI1LDIzIDI5LDE5ICAgIiBzdHJva2U9IiMwMDAwMDAiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLW1pdGVybGltaXQ9IjEwIiBzdHJva2Utd2lkdGg9IjIiLz48L3N2Zz4=",
		"hierarchical" => false,
		"rewrite" => array( "slug" => "expertise", "with_front" => true ),
		"query_var" => true,

		"supports" => array("title", "revisions"),
		"taxonomies" => array( "expertise_cat"),
	);

	register_taxonomy(
		'expertise_cat',
		'',
		array(
			'label' => __( 'Expertise catégories', 'apax'),
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'capabilities'      => array(
				'assign_terms' => 'manage_options',
				// 'edit_terms'   => 'god',
				// 'manage_terms' => 'god',
				'delete_terms' => 'god',
			),
			'public' => false
		)
	);
	register_post_type( "expertise", $args );

	$labels = array(
		'name'               => __( 'Apax Talks', ''),
		'singular_name'      => __( 'Apax Talks', ''),
		'menu_name'          => __( 'Apax Talks', ''),
		'name_admin_bar'     => __( 'Apax Talks', ''),
		'add_new'            => __( 'Ajouter', ''),
		'add_new_item'       => __( 'Ajouter un nouveau Apax Talks', ''),
		'new_item'           => __( 'Nouveau Apax Talks', ''),
		'edit_item'          => __( 'Editer l\'Apax Talks', ''),
		'view_item'          => __( 'Voir l\'Apax Talks', ''),
		'all_items'          => __( 'Tout les Apax Talks', ''),
		'search_items'       => __( 'Rechercher un Apax Talks', ''),
		'parent_item_colon'  => __( 'Apax Talks parent :', ''),
		'not_found'          => __( 'Aucun Apax Talks trouvé.', ''),
		'not_found_in_trash' => __( 'Aucun Apax Talks dans la corbeille.', '')
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'			 => 'dashicons-media-text',
		'supports'           => array( 'title', 'thumbnail', "revisions"),
		"taxonomies" 		 => array( "issues", "talks_cat" ),
		"rewrite" => [
			"slug" => "talks"
		]
	);

	register_taxonomy( 'issues', '', [
		'label' => __( 'Talks issues', "apax" ),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		// 'capabilities'      => array(
			// 'assign_terms' => 'manage_options',
			// 'edit_terms'   => 'god',
			// 'manage_terms' => 'god',
		// ),
		'public' => true
	]);
	register_taxonomy( 'talks_cat', '', [
		'label' => __( 'Talks catégorie', "apax" ),
		'hierarchical' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'capabilities'      => array(
			'edit_terms'   => ((get_current_user_id() == 1) ?'read' :'god'),
			'manage_terms' => ((get_current_user_id() == 1) ?'read' :'god'),
		),
		'public' => true,
		'rewrite' => array( 'slug' => 'talks-categories' )
	]);
	register_post_type('blog', $args);

}
