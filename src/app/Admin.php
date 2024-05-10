<?php

namespace Ismail\LeadPress\App;
use Ismail\LeadPress\Base\Core;
use Ismail\LeadPress\Public\Helper;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin extends Core {

	public $plugin;

	public $slug;

	public $version;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin		= $plugin;
		$this->slug			= $this->plugin['TextDomain'];
		// $this->version		= $this->plugin['Version'];
		$this->version		= time();
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin.css", LEADPRESS ), '', $this->version, 'all' );
		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin.js", LEADPRESS ), [ 'jquery' ], $this->version, true );

	    $localized = [
	    	'api_base'		=> get_rest_url(),
	    	'rest_nonce'	=> wp_create_nonce( 'wp_rest' ),
	    ];

	    wp_localize_script( $this->slug, 'LEADPRESS', apply_filters( "{$this->slug}-localized", $localized ) );
	}

}