<?php

namespace Ismail\LeadPress\App;
use Ismail\LeadPress\Base\Core;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Front extends Core {

	public $plugin;

	public $slug;

	public $version;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin		= $plugin;
		$this->slug			= $this->plugin['TextDomain'];
		$this->version		= $this->plugin['Version'];
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/front.css", LEADPRESS ), '', $this->version, 'all' );
		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/front.js", LEADPRESS ), [ 'jquery' ], $this->version, true );

	    $localized = [
	    	'api_base'		=> get_rest_url() . 'leadpress/api/v1/',
	    	'rest_nonce'	=> wp_create_nonce( $this->slug ),
	    ];

	    wp_localize_script( $this->slug, 'LEADPRESS', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function modal() {
		echo '
		<div id="leadpress-modal" style="display: none">
			<img id="leadpress-modal-loader" src="' . esc_attr( LEADPRESS_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}
}