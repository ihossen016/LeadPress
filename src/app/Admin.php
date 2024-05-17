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
	    	'api_base'		=> get_rest_url() . 'leadpress/api/v1',
	    	'rest_nonce'	=> wp_create_nonce( $this->slug ),
	    ];

	    wp_localize_script( $this->slug, 'LEADPRESS', apply_filters( "{$this->slug}-localized", $localized ) );
	}

	public function register_admin_menu() {
		add_menu_page(
			__( 'LeadPress', 'leadpress' ),
			'LeadPress',
			'manage_options',
			'leadpress',
			function() {},
			LEADPRESS_ASSET . '/img/logo.png',
			5
		);

		$submenus = [
			'overview' 		=> __( 'Overview', 'leadpress' ),
			'leads' 		=> __( 'Leads', 'leadpress' ),
			'email-logs' 	=> __( 'Email Logs', 'leadpress' ),
		];
		
		// Loop through the submenu array and add each submenu
		foreach ( $submenus as $slug => $title ) {
			add_submenu_page(
				'leadpress',
				$title,
				$title,
				'manage_options',
				$slug === 'overview' ? 'leadpress' : "leadpress-{$slug}",
				function() use ( $slug ) {
					echo Helper::get_template( $slug, 'templates/menus' );
				}
			);
		}
	}

	public function modal() {
		echo '
		<div id="leadpress-modal" style="display: none">
			<img id="leadpress-modal-loader" src="' . esc_attr( LEADPRESS_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}
}