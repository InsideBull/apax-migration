<?php
/*
Plugin Name: Adaka Cookie Notice
Description: Adaka Cookie Notice allows you to elegantly inform users that your site uses cookies and to comply with the EU cookie law regulations.
Version: 2.0
Author: Adaka
Author URI: http://www.adaka.fr
Plugin URI: http://www.adaka.fr/
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: adaka-cookie-notice
Domain Path: /languages

Cookie Notice
Copyright (C) 2013-2015, Digital Factory - info@digitalfactory.pl

Adaka Cookie Notice 
Copyright (C) 2015, Adaka - contact@adaka.fr

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

// set plugin instance
global $cookie_notice;
$cookie_notice = new AdakaCookie_Notice();

// include_once( plugin_dir_path( __FILE__ ) . 'includes/update.php' );

/**
 * Adaka Cookie Notice class.
 *
 * @class AdakaCookie_Notice
 * @version	1.2.33
 */
class AdakaCookie_Notice {

	/**
	 * @var $defaults
	 */
	private $defaults = array(
		'general' => array(
			'position'						=> 'top',
			'message_text'					=> 'Ce site utilise des cookies. En poursuivant votre navigation sur ce site, vous consentez à leur utilisation pour vous proposer des contenus et services adaptés.',
			'css_style'						=> 'wp-default',
			'accept_text'					=> 'Accepter',
			'refuse_text'					=> 'Refuser',
			'refuse_opt'					=> 'yes',
			'refuse_code'					=> '',
			'see_more'						=> 'yes',
			'link_target'					=> '_self',
			'time'							=> 31536000,
			'hide_effect'					=> 'slide',
			'colors' => array(
				'text'							=> '#494949',
				'bar'							=> '#eaeaea',
			),
			'see_more_opt' => array(
				'text'						=> 'En savoir plus',
				'link_type'					=> 'custom',
				'id'						=> 'empty',
				'link'						=> ''
			),
			'script_placement'				=> 'header',
			'translate'						=> true,
		),
		'version'							=> '1.2.33'
	);
	private $positions 			= array();
	private $styles 			= array();
	private $choices 			= array();
	private $pages 				= array();
	private $links 				= array();
	private $link_target 		= array();
	private $colors 			= array();
	private $options 			= array();
	private $effects 			= array();
	private $script_placements 	= array();

	/**
	 * @var $cookie, holds cookie name
	 */
	private static $cookie = array(
		'name'	 		=> '_gdpr_consent',
		'value'	 		=> 'TRUE',
		'no_value'		=> 'FALSE',
		'load_value' 	=> 'WAIT',
	);

	/**
	 * Constructor.
	 */
	public function __construct() {
		if(!defined( 'COOKIEPATH' ))
			define("COOKIEPATH", preg_replace( '|https?://[^/]+|i', '', get_option( 'home' ) . '/' ) );
		if(!defined("COOKIEDOMAIN")) {
			if (preg_match('/(?!w{1,}\.)(\w+\.?){1,}([a-z\-A-Z]+)(\.\w+)/',get_home_url(),$matches)) {
				define("COOKIEDOMAIN", $matches[0]);
			} else {
				define("COOKIEDOMAIN", trim( pathinfo(get_home_url(), PATHINFO_BASENAME ), "www."));
			}
		}
		
		if(!isset($_COOKIE[self::$cookie['name']]))
			setcookie(self::$cookie['name'], self::$cookie['load_value'], (time() +$this->defaults['general']['time']), COOKIEPATH, COOKIEDOMAIN);
		else if($_COOKIE[self::$cookie['name']] == self::$cookie['load_value'])
			setcookie(self::$cookie['name'], self::$cookie['value'], (time() +$this->defaults['general']['time']), COOKIEPATH, COOKIEDOMAIN);
	
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		// settings
		$this->options = array(
			'general' => array_merge( $this->defaults['general'], get_option( 'cookie_notice_options', $this->defaults['general'] ) )
		);

		// actions
		add_action( 'init', array( $this, 'unregister_wpembed' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu_options' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'after_setup_theme', array( $this, 'load_defaults' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_load_scripts_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_load_scripts_styles' ) );
		add_action( 'wp_print_footer_scripts', array( $this, 'wp_print_footer_scripts' ) );
		add_action( 'wp_footer', array( $this, 'add_cookie_notice' ), 1000 );

		// filters
		add_filter( 'plugin_row_meta', array( $this, 'plugin_extend_links' ), 10, 2 );
		add_filter( 'plugin_action_links', array( $this, 'plugin_settings_link' ), 10, 2 );
		
		// shortcodes
		add_shortcode( 'cookie_notice_options', [$this, 'shortcode_options'] );
	}

	public function unregister_wpembed() {
		if(cn_cookies_accepted() !== true) {
			global $wp_embed;
			remove_filter( "the_content", [$wp_embed, "run_shortcode"], 8 );
			remove_filter( "the_content", [$wp_embed, "autoembed"], 8 );
			
			// monsterinsights
			remove_action( 'wp_head', 'monsterinsights_tracking_script', 6 );
		}
	}
	
	/**
	 * Load plugin defaults
	 */
	public function load_defaults() {
		$this->positions = array(
			'top'	 			=> __( 'Top', 'cookie-notice' ),
			'bottom' 			=> __( 'Bottom', 'cookie-notice' )
		);

		$this->styles = array(
			'none'		 		=> __( 'None', 'cookie-notice' ),
			'wp-default' 		=> __( 'WordPress', 'cookie-notice' ),
			'bootstrap'	 		=> __( 'Bootstrap', 'cookie-notice' )
		);

		$this->links = array(
			'custom' 			=> __( 'Custom link', 'cookie-notice' ),
			'page'	 			=> __( 'Page link', 'cookie-notice' )
		);

		$this->link_target = array(
			'_blank',
			'_self'
		);

		$this->colors = array(
			'text'	 			=> __( 'Text color', 'cookie-notice' ),
			'bar'	 			=> __( 'Bar color', 'cookie-notice' ),
		);

		$this->effects = array(
			'none'	 			=> __( 'None', 'cookie-notice' ),
			'fade'	 			=> __( 'Fade', 'cookie-notice' ),
			'slide'	 			=> __( 'Slide', 'cookie-notice' )
		);

		$this->script_placements = array(
			'header' 			=> __( 'Header', 'cookie-notice' ),
			'footer' 			=> __( 'Footer', 'cookie-notice' ),
		);

		$this->pages = get_pages(
			array(
				'sort_order'	=> 'ASC',
				'sort_column'	=> 'post_title',
				'hierarchical'	=> 0,
				'child_of'		=> 0,
				'parent'		=> -1,
				'offset'		=> 0,
				'post_type'		=> 'page',
				'post_status'	=> 'publish'
			)
		);

		if ( $this->options['general']['translate'] === true ) {
			$this->options['general']['translate'] = false;

			$this->options['general']['message_text'] = esc_textarea( __( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'cookie-notice' ) );
			$this->options['general']['accept_text'] = sanitize_text_field( __( 'Ok', 'cookie-notice' ) );
			$this->options['general']['refuse_text'] = sanitize_text_field( __( 'Refuse button text', 'cookie-notice' ) );
			$this->options['general']['see_more_opt']['text'] = sanitize_text_field( __( 'Read more', 'cookie-notice' ) );

			update_option( 'cookie_notice_options', $this->options['general'] );
		}

		// WPML and Polylang compatibility
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Cookie Notice', 'Message in the notice', $this->options['general']['message_text'] );
			icl_register_string( 'Cookie Notice', 'Button text', $this->options['general']['accept_text'] );
			icl_register_string( 'Cookie Notice', 'Refuse button text', $this->options['general']['refuse_text'] );
			icl_register_string( 'Cookie Notice', 'Read more text', $this->options['general']['see_more_opt']['text'] );
			icl_register_string( 'Cookie Notice', 'Custom link', $this->options['general']['see_more_opt']['link'] );
		}
	}

	/**
	 * Load textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'cookie-notice', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Add submenu.
	 */
	public function admin_menu_options() {
		add_options_page(
			__( 'Cookie Notice', 'cookie-notice' ), __( 'Cookie Notice', 'cookie-notice' ), 'manage_options', 'cookie-notice', array( $this, 'options_page' )
		);
	}

	/**
	 * Options page output.
	 */
	public function options_page() {
		echo '
		<div class="wrap">' . screen_icon() . '
			<h2>' . __( 'Adaka Cookie Notice', 'cookie-notice' ) . '</h2>
			<div class="cookie-notice-settings">
				<div class="df-credits">
					<h3 class="hndle">' . __( 'Adaka Cookie Notice', 'cookie-notice' ) . ' ' . $this->defaults['version'] . '</h3>
					<div class="inside">
						<p class="df-link inner">Created by <a href="http://www.adaka.fr" target="_blank" title="Adaka">ADAKA</a></p>
					</div>
				</div>
				<form action="options.php" method="post">';

		settings_fields( 'cookie_notice_options' );
		do_settings_sections( 'cookie_notice_options' );
		
		echo '
				<p class="submit">';
		submit_button( '', 'primary', 'save_cookie_notice_options', false );
		echo ' ';
		submit_button( __( 'Reset to defaults', 'cookie-notice' ), 'secondary', 'reset_cookie_notice_options', false );
		echo '
				</p>
				</form>
			</div>
			<div class="clear"></div>
		</div>';
	}

	/**
	 * Regiseter plugin settings.
	 */
	public function register_settings() {
		register_setting( 'cookie_notice_options', 'cookie_notice_options', array( $this, 'validate_options' ) );

		// configuration
		add_settings_section( 'cookie_notice_configuration', __( 'Configuration', 'cookie-notice' ), array( $this, 'cn_section_configuration' ), 'cookie_notice_options' );
		add_settings_field( 'cn_message_text', __( 'Message', 'cookie-notice' ), array( $this, 'cn_message_text' ), 'cookie_notice_options', 'cookie_notice_configuration' );
		add_settings_field( 'cn_accept_text', __( 'Button text', 'cookie-notice' ), array( $this, 'cn_accept_text' ), 'cookie_notice_options', 'cookie_notice_configuration' );
		add_settings_field( 'cn_see_more', __( 'More info link', 'cookie-notice' ), array( $this, 'cn_see_more' ), 'cookie_notice_options', 'cookie_notice_configuration' );
		add_settings_field( 'cn_link_target', __( 'Link target', 'cookie-notice' ), array( $this, 'cn_link_target' ), 'cookie_notice_options', 'cookie_notice_configuration' );
		add_settings_field( 'cn_refuse_opt', __( 'Refuse button', 'cookie-notice' ), array( $this, 'cn_refuse_opt' ), 'cookie_notice_options', 'cookie_notice_configuration' );
		add_settings_field( 'cn_script_placement', __( 'Script placement', 'cookie-notice' ), array( $this, 'cn_script_placement' ), 'cookie_notice_options', 'cookie_notice_configuration' );

		// design
		add_settings_section( 'cookie_notice_design', __( 'Design', 'cookie-notice' ), array( $this, 'cn_section_design' ), 'cookie_notice_options' );
		add_settings_field( 'cn_position', __( 'Position', 'cookie-notice' ), array( $this, 'cn_position' ), 'cookie_notice_options', 'cookie_notice_design' );
		add_settings_field( 'cn_hide_effect', __( 'Animation', 'cookie-notice' ), array( $this, 'cn_hide_effect' ), 'cookie_notice_options', 'cookie_notice_design' );
		add_settings_field( 'cn_css_style', __( 'Button style', 'cookie-notice' ), array( $this, 'cn_css_style' ), 'cookie_notice_options', 'cookie_notice_design' );
		add_settings_field( 'cn_colors', __( 'Colors', 'cookie-notice' ), array( $this, 'cn_colors' ), 'cookie_notice_options', 'cookie_notice_design' );
		
		// french texts
		add_settings_section( 'cookie_notice_texts', 'Exemples de textes', array( $this, 'cn_section_texts' ), 'cookie_notice_options' );
		add_settings_field( 'cn_texts_legals', 'Mentions legales', array( $this, 'cn_texts_legals' ), 'cookie_notice_options', 'cookie_notice_texts' );
		add_settings_field( 'cn_texts_cookies', 'Cookies', array( $this, 'cn_texts_cookies' ), 'cookie_notice_options', 'cookie_notice_texts' );
	}

	/**
	 * Section callback: fix for WP < 3.3
	 */
	public function cn_section_configuration() {}
	public function cn_section_design() {}
	public function cn_section_texts() {}

	/**
	 * Cookie message option.
	 */
	public function cn_message_text() {
		echo '
		<div id="cn_message_text">
			<textarea name="cookie_notice_options[message_text]" class="large-text" cols="50" rows="5">' . esc_textarea( $this->options['general']['message_text'] ) . '</textarea>
			<p class="description">' . __( 'Enter the cookie notice message.', 'cookie-notice' ) . '</p>
		</div>';
	}

	/**
	 * Accept cookie label option.
	 */
	public function cn_accept_text() {
		echo '
		<div id="cn_accept_text">
			<input type="text" class="regular-text" name="cookie_notice_options[accept_text]" value="' . esc_attr( $this->options['general']['accept_text'] ) . '" />
			<p class="description">' . __( 'The text of the option to accept the usage of the cookies and make the notification disappear.', 'cookie-notice' ) . '</p>
		</div>';
	}

	/**
	 * Enable/Disable third party non functional cookies option.
	 */
	public function cn_refuse_opt() {
		echo '
		<fieldset>';
		echo '<div id="cn_refuse_opt_container">';
		echo '
				<div id="cn_refuse_text">
					<input type="text" class="regular-text" name="cookie_notice_options[refuse_text]" value="' . esc_attr( $this->options['general']['refuse_text'] ) . '" />
					<p class="description">' . __( 'The text of the option to refuse the usage of the cookies. To get the cookie notice status use <code>cn_cookies_accepted()</code> function.', 'cookie-notice' ) . '</p>
				</div>';
		echo '
				<div id="cn_refuse_code">
					<textarea name="cookie_notice_options[refuse_code]" class="large-text" cols="50" rows="5">' . esc_textarea( $this->options['general']['refuse_code'] ) . '</textarea>
					<p class="description">' . __( 'Enter non functional cookies Javascript code here (for e.g. Google Analitycs). It will be used after cookies are accepted.', 'cookie-notice' ) . '</p>
				</div>';
		echo '
			</div>
		</fieldset>';
	}

	/**
	 * Read more link option.
	 */
	public function cn_see_more() {
		echo '
		<fieldset>
			<label><input id="cn_see_more" type="checkbox" name="cookie_notice_options[see_more]" value="1" ' . checked( 'yes', $this->options['general']['see_more'], false ) . ' />' . __( 'Enable Read more link.', 'cookie-notice' ) . '</label>';

		echo '
		<div id="cn_see_more_opt"' . ($this->options['general']['see_more'] === 'no' ? ' style="display: none;"' : '') . '>
			<input type="text" class="regular-text" name="cookie_notice_options[see_more_opt][text]" value="' . esc_attr( $this->options['general']['see_more_opt']['text'] ) . '" />
			<p class="description">' . __( 'The text of the more info button.', 'cookie-notice' ) . '</p>
			<div id="cn_see_more_opt_custom_link">';

		foreach ( $this->links as $value => $label ) {
			$value = esc_attr( $value );

			echo '
				<label><input id="cn_see_more_link-' . $value . '" type="radio" name="cookie_notice_options[see_more_opt][link_type]" value="' . $value . '" ' . checked( $value, $this->options['general']['see_more_opt']['link_type'], false ) . ' />' . esc_html( $label ) . '</label>';
		}

		echo '
			</div>
			<p class="description">' . __( 'Select where to redirect user for more information about cookies.', 'cookie-notice' ) . '</p>
			<div id="cn_see_more_opt_page"' . ($this->options['general']['see_more_opt']['link_type'] === 'custom' ? ' style="display: none;"' : '') . '>
				<select name="cookie_notice_options[see_more_opt][id]">
					<option value="empty" ' . selected( 'empty', $this->options['general']['see_more_opt']['id'], false ) . '>' . __( '-- select page --', 'cookie-notice' ) . '</option>';

		foreach ( $this->pages as $page ) {
			echo '
					<option value="' . $page->ID . '" ' . selected( $page->ID, $this->options['general']['see_more_opt']['id'], false ) . '>' . esc_html( $page->post_title ) . '</option>';
		}

		echo '
				</select>
				<p class="description">' . __( 'Select from one of your site\'s pages', 'cookie-notice' ) . '</p>
			</div>
			<div id="cn_see_more_opt_link"' . ($this->options['general']['see_more_opt']['link_type'] === 'page' ? ' style="display: none;"' : '') . '>
				<input type="text" class="regular-text" name="cookie_notice_options[see_more_opt][link]" value="' . esc_attr( $this->options['general']['see_more_opt']['link'] ) . '" />
				<p class="description">' . __( 'Enter the full URL starting with http://', 'cookie-notice' ) . '</p>
			</div>
		</div>
		</fieldset>';
	}

	/**
	 * Link target option.
	 */
	public function cn_link_target() {
		echo '
		<div id="cn_link_target">
			<select name="cookie_notice_options[link_target]">';

		foreach ( $this->link_target as $target ) {
			echo '<option value="' . $target . '" ' . selected( $target, $this->options['general']['link_target'] ) . '>' . esc_html( $target ) . '</option>';
		}

		echo '
			</select>
			<p class="description">' . __( 'Select the link target for more info page.', 'cookie-notice' ) . '</p>
		</div>';
	}

	/**
	 * Script placement option.
	 */
	public function cn_script_placement() {
		foreach ( $this->script_placements as $value => $label ) {
			echo '
			<label><input id="cn_script_placement-' . $value . '" type="radio" name="cookie_notice_options[script_placement]" value="' . esc_attr( $value ) . '" ' . checked( $value, $this->options['general']['script_placement'], false ) . ' />' . esc_html( $label ) . '</label>';
		}

		echo '
			<p class="description">' . __( 'Select where all the plugin scripts should be placed.', 'cookie-notice' ) . '</p>';
	}

	/**
	 * Position option.
	 */
	public function cn_position() {
		echo '
		<div id="cn_position">';

		foreach ( $this->positions as $value => $label ) {
			$value = esc_attr( $value );

			echo '
			<label><input id="cn_position-' . $value . '" type="radio" name="cookie_notice_options[position]" value="' . $value . '" ' . checked( $value, $this->options['general']['position'], false ) . ' />' . esc_html( $label ) . '</label>';
		}

		echo '
			<p class="description">' . __( 'Select location for your cookie notice.', 'cookie-notice' ) . '</p>
		</div>';
	}

	/**
	 * Animation effect option.
	 */
	public function cn_hide_effect() {
		echo '
		<div id="cn_hide_effect">';

		foreach ( $this->effects as $value => $label ) {
			$value = esc_attr( $value );

			echo '
			<label><input id="cn_hide_effect-' . $value . '" type="radio" name="cookie_notice_options[hide_effect]" value="' . $value . '" ' . checked( $value, $this->options['general']['hide_effect'], false ) . ' />' . esc_html( $label ) . '</label>';
		}

		echo '
			<p class="description">' . __( 'Cookie notice acceptance animation.', 'cookie-notice' ) . '</p>
		</div>';
	}

	/**
	 * CSS style option.
	 */
	public function cn_css_style() {
		echo '
		<div id="cn_css_style">';

		foreach ( $this->styles as $value => $label ) {
			$value = esc_attr( $value );

			echo '
			<label><input id="cn_css_style-' . $value . '" type="radio" name="cookie_notice_options[css_style]" value="' . $value . '" ' . checked( $value, $this->options['general']['css_style'], false ) . ' />' . esc_html( $label ) . '</label>';
		}

		echo '
			<p class="description">' . __( 'Choose buttons style.', 'cookie-notice' ) . '</p>
		</div>';
	}

	/**
	 * Colors option.
	 */
	public function cn_colors() {
		echo '
		<fieldset>';
		
		foreach ( $this->colors as $value => $label ) {
			$value = esc_attr( $value );

			echo '
			<div id="cn_colors-' . $value . '"><label>' . esc_html( $label ) . '</label><br />
				<input class="cn_color" type="text" name="cookie_notice_options[colors][' . $value . ']" value="' . esc_attr( $this->options['general']['colors'][$value] ) . '" />' .
			'</div>';
		}
		
		echo '
		</fieldset>';
	}

	/**
	 * Legals textes samples.
	 */
	public function cn_texts_legals() {
		echo '<textarea readonly class="cn_texts">';
		echo '<h2>VIE PRIVÉE</h2>'."\r\n";
		echo '<p>Le cabinet Benoît CONTENT s’engage à ne pas divulguer les informations personnelles vous concernant à des tiers.</p>'."\r\n"."\r\n";

		echo '<h2>INFORMATIONS PERSONNELLES</h2>'."\r\n";
		echo '<p>__________ assure la sécurité de vos données transmises par vos soins mais vous demande de prendre les précautions nécessaires quant aux risques inhérents de l’outil Internet.</p>'."\r\n";
		echo '<p>__________ s’engage à ce que la collecte et le traitement de vos données, effectués à partir de ce site, soient conformes au règlement général sur la protection des données (RGPD) en date du 25 mai 2018 et à la loi Informatique et Libertés.</p>'."\r\n";
		echo '<p>Conformément à la Loi informatique et libertés du 6 janvier 1978, modifiée en 2004, vous disposez d’un droit d’accès, de modification, de rectification et de suppression des données vous concernant. Pour exercer ce droit, nous vous invitons à nous contacter par courrier à l’adresse ci-dessus.</p>';
		echo '</textarea>';
	}
	public function cn_texts_cookies() {
		echo '<textarea readonly class="cn_texts">';
		echo '<h2>Ce site utilise des Cookies</h2>'."\r\n";
		echo '<p>Les cookies permettent au site de fonctionner. Les cookies sont de petits fichiers texte qui servent à faciliter votre navigation. Ils sont utilisés par des logiciels ou sites tiers pour offrir davantage de services, la mesure d\'audience et la personnalisation de contenus (ex : partage de contenus sur les réseaux sociaux, lecture directe de vidéos, statistiques Google Analytics…). Nos partenaires de médias sociaux ou d’analyse de trafic peuvent adjoindre ces données à celles que vous avez fournies par ailleurs.</p>'."\r\n";
		echo '<p>Votre consentement est demandé lors de la première consultation du site. En poursuivant votre navigation, vous acceptez de plein droit l’usage des cookies que vous pouvez à tout moment réfuter en utilisant le bouton ci-dessous. Seuls, les cookies nécessaires ne peuvent pas être retirés. Ils permettent de stocker votre choix concernant l\'usage des cookies sur ce site.</p>'."\r\n";
		echo '<p>Cette acceptation est considérée comme acquise pour une durée de 12 mois sur ce site. Au-delà, ce consentement vous sera de nouveau proposé après effacement complet des cookies.</p>'."\r\n"."\r\n";

		echo '<h2>Voici la liste des cookies utilisés sur ce site :</h2>'."\r\n";
		echo '<h3>Nécessaire (1)</h3>'."\r\n";
		echo '<table><tbody><tr>'."\r\n";
		echo '<th>Nom du cookie</th>'."\r\n";
		echo '<th>Fournisseur</th>'."\r\n";
		echo '<th>Finalité</th>'."\r\n";
		echo '<th>Durée</th>'."\r\n";
		echo '</tr><tr>'."\r\n";
		echo '<td>'.self::$cookie['name'].'</td>'."\r\n";
		echo '<td>'.COOKIEDOMAIN.'</td>'."\r\n";
		echo '<td style="width: 50%;">Stocke l\'autorisation d\'utilisation de cookies pour le domaine actuel par l\'utilisateur</td>'."\r\n";
		echo '<td>12 mois</td>'."\r\n";
		echo '</tr></tbody></table>'."\r\n"."\r\n";

		echo '<h2>Consentement</h2>'."\r\n";
		echo '<p>Autoriser l\'utilisation des cookies sur ce site :  [cookie_notice_options true="Accepter" false="Refuser"]</p>';
		echo '</textarea>';
	}

	/**
	 * Validate options.
	 */
	public function validate_options( $input ) {

		if ( ! check_admin_referer( 'cookie_notice_options-options') )
			return $input;
		
		if ( ! current_user_can( 'manage_options' ) )
			return $input;

		if ( isset( $_POST['save_cookie_notice_options'] ) ) {

			// position
			$input['position'] = sanitize_text_field( isset( $input['position'] ) && in_array( $input['position'], array_keys( $this->positions ) ) ? $input['position'] : $this->defaults['general']['position'] );

			// colors
			$input['colors']['text'] = sanitize_text_field( isset( $input['colors']['text'] ) && $input['colors']['text'] !== '' && preg_match( '/^#[a-f0-9]{6}$/', $input['colors']['text'] ) === 1 ? $input['colors']['text'] : $this->defaults['general']['colors']['text'] );
			$input['colors']['bar'] = sanitize_text_field( isset( $input['colors']['bar'] ) && $input['colors']['bar'] !== '' && preg_match( '/^#[a-f0-9]{6}$/', $input['colors']['bar'] ) === 1 ? $input['colors']['bar'] : $this->defaults['general']['colors']['bar'] );

			// texts
			$input['message_text'] = wp_kses_post( isset( $input['message_text'] ) && $input['message_text'] !== '' ? $input['message_text'] : $this->defaults['general']['message_text'] );
			$input['accept_text'] = sanitize_text_field( isset( $input['accept_text'] ) && $input['accept_text'] !== '' ? $input['accept_text'] : $this->defaults['general']['accept_text'] );
			$input['refuse_text'] = sanitize_text_field( isset( $input['refuse_text'] ) && $input['refuse_text'] !== '' ? $input['refuse_text'] : $this->defaults['general']['refuse_text'] );
			$input['refuse_opt'] = 'yes';
			$input['refuse_code'] = wp_kses_post( isset( $input['refuse_code'] ) && $input['refuse_code'] !== '' ? $input['refuse_code'] : $this->defaults['general']['refuse_code'] );

			// css
			$input['css_style'] = sanitize_text_field( isset( $input['css_style'] ) && in_array( $input['css_style'], array_keys( $this->styles ) ) ? $input['css_style'] : $this->defaults['general']['css_style'] );

			// link target
			$input['link_target'] = sanitize_text_field( isset( $input['link_target'] ) && in_array( $input['link_target'], array_keys( $this->link_target ) ) ? $input['link_target'] : $this->defaults['general']['link_target'] );

			// time
			$input['time'] = $this->defaults['general']['time'];

			// script placement
			$input['script_placement'] = sanitize_text_field( isset( $input['script_placement'] ) && in_array( $input['script_placement'], array_keys( $this->script_placements ) ) ? $input['script_placement'] : $this->defaults['general']['script_placement'] );

			// hide effect
			$input['hide_effect'] = sanitize_text_field( isset( $input['hide_effect'] ) && in_array( $input['hide_effect'], array_keys( $this->effects ) ) ? $input['hide_effect'] : $this->defaults['general']['hide_effect'] );
			
			// read more
			$input['see_more'] = isset( $input['see_more'] ) ? 'yes' : 'no';
			$input['see_more_opt']['text'] = sanitize_text_field( isset( $input['see_more_opt']['text'] ) && $input['see_more_opt']['text'] !== '' ? $input['see_more_opt']['text'] : $this->defaults['general']['see_more_opt']['text'] );
			$input['see_more_opt']['link_type'] = sanitize_text_field( isset( $input['see_more_opt']['link_type'] ) && in_array( $input['see_more_opt']['link_type'], array_keys( $this->links ) ) ? $input['see_more_opt']['link_type'] : $this->defaults['general']['see_more_opt']['link_type'] );

			if ( $input['see_more_opt']['link_type'] === 'custom' )
				$input['see_more_opt']['link'] = esc_url( $input['see_more'] === 'yes' ? $input['see_more_opt']['link'] : 'empty' );
			elseif ( $input['see_more_opt']['link_type'] === 'page' )
				$input['see_more_opt']['id'] = ( $input['see_more'] === 'yes' ? (int) $input['see_more_opt']['id'] : 'empty' );

			$input['translate'] = false;
			
		} elseif ( isset( $_POST['reset_cookie_notice_options'] ) ) {
			
			$input = $this->defaults['general'];

			add_settings_error( 'reset_cookie_notice_options', 'reset_cookie_notice_options', __( 'Settings restored to defaults.', 'cookie-notice' ), 'updated' );
			
		}

		return $input;
	}

	/**
	 * Cookie notice output.
	 */
	public function add_cookie_notice() {
		if ( ! $this->cookie_setted() ) {
			// WPML and Polylang compatibility
			if ( function_exists( 'icl_t' ) ) {
				$this->options['general']['message_text'] = icl_t( 'Cookie Notice', 'Message in the notice', $this->options['general']['message_text'] );
				$this->options['general']['accept_text'] = icl_t( 'Cookie Notice', 'Button text', $this->options['general']['accept_text'] );
				$this->options['general']['refuse_text'] = icl_t( 'Cookie Notice', 'Refuse button text', $this->options['general']['refuse_text'] );
				$this->options['general']['see_more_opt']['text'] = icl_t( 'Cookie Notice', 'Read more text', $this->options['general']['see_more_opt']['text'] );
				$this->options['general']['see_more_opt']['link'] = icl_t( 'Cookie Notice', 'Custom link', $this->options['general']['see_more_opt']['link'] );
			}

			if ( function_exists( 'icl_object_id' ) )
				$this->options['general']['see_more_opt']['id'] = icl_object_id( $this->options['general']['see_more_opt']['id'], 'page', true );

			// get cookie container args
			$options = apply_filters( 'cn_cookie_notice_args', array(
				'position'			=> $this->options['general']['position'],
				'css_style'			=> $this->options['general']['css_style'],
				'colors'			=> $this->options['general']['colors'],
				'message_text'		=> $this->options['general']['message_text'],
				'accept_text'		=> $this->options['general']['accept_text'],
				'refuse_text'		=> $this->options['general']['refuse_text'],
				'see_more'			=> $this->options['general']['see_more'],
				'see_more_opt'		=> $this->options['general']['see_more_opt'],
				'link_target'		=> $this->options['general']['link_target'],
			) );

			// message output
			$output = '
			<div id="cookie-notice" class="cn-' . ($options['position']) . ($options['css_style'] !== 'none' ? ' ' . $options['css_style'] : '') . '" style="color: ' . $options['colors']['text'] . '; background-color: ' . $options['colors']['bar'] . ';">'
				. '<div class="cookie-notice-container"><span id="cn-notice-text">'. $options['message_text'] .'</span>'
				. '<a href="#" id="cn-accept-cookie" data-cookie-set="accept" class="cn-set-cookie button' . ($options['css_style'] !== 'none' ? ' ' . $options['css_style'] : '') . '">' . $options['accept_text'] . '</a>'
				. '<a href="#" id="cn-refuse-cookie" data-cookie-set="refuse" class="cn-set-cookie button' . ($options['css_style'] !== 'none' ? ' ' . $options['css_style'] : '') . '">' . $options['refuse_text'] . '</a>'
				. ($options['see_more'] === 'yes' ? '<a href="' . ($options['see_more_opt']['link_type'] === 'custom' ? $options['see_more_opt']['link'] : get_permalink( $options['see_more_opt']['id'] )) . '" target="' . $options['link_target'] . '" id="cn-more-info" class="button' . ($options['css_style'] !== 'none' ? ' ' . $options['css_style'] : '') . '">' . $options['see_more_opt']['text'] . '</a>' : '') . '
				</div>
			</div>';

			echo apply_filters( 'cn_cookie_notice_output', $output );
		}
	}

	/**
	 * Checks if cookie is setted
	 */
	public function cookie_setted() {
		return isset( $_COOKIE[self::$cookie['name']] ) && ($_COOKIE[self::$cookie['name']] !== self::$cookie['load_value']);
	}

	/**
	 * Checks if third party non functional cookies are accepted
	 */
	public static function cookies_accepted() {
		return ( isset( $_COOKIE[self::$cookie['name']] ) && strtoupper( $_COOKIE[self::$cookie['name']] ) === self::$cookie['value'] );
	}

	/**
	 * Get default settings.
	 */
	public function get_defaults() {
		return $this->defaults;
	}
	
	/**
	 * Add links to Support Forum.
	 */
	public function plugin_extend_links( $links, $file ) {
		if ( ! current_user_can( 'install_plugins' ) )
			return $links;

		$plugin = plugin_basename( __FILE__ );

		if ( $file == $plugin )
			return array_merge( $links, array( sprintf( '<a href="http://www.dfactory.eu/support/forum/cookie-notice/" target="_blank">%s</a>', __( 'Support', 'cookie-notice' ) ) ) );

		return $links;
	}

	/**
	 * Add links to settings page.
	 */
	public function plugin_settings_link( $links, $file ) {
		if ( ! current_user_can( 'manage_options' ) )
			return $links;

		$plugin = plugin_basename( __FILE__ );

		if ( $file == $plugin )
			array_unshift( $links, sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php?page=cookie-notice' ), __( 'Settings', 'cookie-notice' ) ) );

		return $links;
	}

	/**
	 * Activate the plugin.
	 */
	public function activation() {
		add_option( 'cookie_notice_options', $this->defaults['general'], '', 'no' );
		add_option( 'cookie_notice_version', $this->defaults['version'], '', 'no' );
	}

	/**
	 * Load scripts and styles - admin.
	 */
	public function admin_load_scripts_styles( $page ) {
		if ( $page !== 'settings_page_cookie-notice' )
			return;

		wp_enqueue_script(
			'cookie-notice-admin', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), $this->defaults['version']
		);
		
		wp_localize_script(
			'cookie-notice-admin', 'cnArgs', array(
				'resetToDefaults'	=> __( 'Are you sure you want to reset these settings to defaults?', 'cookie-notice' )
			)
		);

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'cookie-notice-admin', plugins_url( 'css/admin.css', __FILE__ ) );
	}

	/**
	 * Load scripts and styles - frontend.
	 */
	public function front_load_scripts_styles() {
		wp_enqueue_script(
			'cookie-notice-front', plugins_url( 'js/front.js', __FILE__ ), array( 'jquery' ), $this->defaults['version'], isset( $this->options['general']['script_placement'] ) && $this->options['general']['script_placement'] === 'footer' ? true : false
		);

		wp_localize_script(
			'cookie-notice-front', 'cnArgs', array(
				'ajaxurl'				=> admin_url( 'admin-ajax.php' ),
				'hideEffect'			=> $this->options['general']['hide_effect'],
				'cookieName'			=> self::$cookie['name'],
				'cookieValue'			=> self::$cookie['value'],
				'cookieNoValue'			=> self::$cookie['no_value'],
				'cookieLoadValue'		=> self::$cookie['load_value'],
				'cookieTime'			=> 31536000,
				'cookiePath'			=> ( defined( 'COOKIEPATH' ) ? COOKIEPATH : '' ),
				'cookieDomain'			=> ( defined( 'COOKIEDOMAIN' ) ? COOKIEDOMAIN : '' ),
				'cookieSetted' 			=> $this->cookie_setted(),
			)
		);

		wp_enqueue_style( 'cookie-notice-front', plugins_url( 'css/front.css', __FILE__ ) );
	}
	
	/**
	 * Print non functional javascript.
	 * 
	 * @return mixed
	 */
	public function wp_print_footer_scripts() {
		$scripts = trim( wp_kses_post( $this->options['general']['refuse_code'] ) );
		
		// if ( $this->cookie_setted() && ! empty( $scripts ) ) {
		if ( ! empty( $scripts ) ) {
			?>
			<script type='text/javascript'>
				<?php echo $scripts; ?>
			</script>
			<?php
		}
	}
	
	
	/**
	 *
	 *
	 */
	public function shortcode_options($atts, $content = "") {
		$accepted = $this->cookies_accepted();
		$setted = $this->cookie_setted();
		
		$true = isset($atts["true"]) ?$atts["true"] :"Oui";
		$false = isset($atts["false"]) ?$atts["false"] :"Non";
		
		return '<span class="cookie_notice_options">
					<button data-cookie-set="accept" class="btn cn-set-cookie '.($accepted ?'active' :'').'">'.$true.'</button>
					<button data-cookie-set="refuse" class="btn cn-set-cookie '.((!$accepted && $setted) ?'active' :'').'">'.$false.'</button>
				</span>';
	}
}

/**
 * Get the cookie notice status
 * 
 * @return boolean / null
 */
function cn_cookies_accepted() {
	global $cookie_notice;
	if(is_object($cookie_notice) && $cookie_notice->cookie_setted())
		return (bool) $cookie_notice->cookies_accepted();
	return null;
}
