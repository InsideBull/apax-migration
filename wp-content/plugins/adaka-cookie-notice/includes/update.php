<?php
// exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

new AdakaCookie_Notice_Update( $cookie_notice );

class AdakaCookie_Notice_Update {
	private $defaults;

	public function __construct( $cookie_notice )	{
		// attributes
		$this->defaults = $cookie_notice->get_defaults();

		// actions
		add_action( 'init', array( $this, 'check_update' ) );
	}

	public function check_update() {
		return false;
	}
}