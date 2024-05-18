<?php

namespace Ismail\LeadPress\App;
use Ismail\LeadPress\Base\Core;
use Ismail\LeadPress\Email\Email;
use Ismail\LeadPress\Email\EmailLogs;
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
		$this->version		= $this->plugin['Version'];
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin.css", LEADPRESS ), '', $this->version, 'all' );
		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin.js", LEADPRESS ), [ 'jquery' ], $this->version, true );
		
		// enqueue select2
		$screen = get_current_screen();

		if ( $screen->id === 'leadpress_page_leadpress-leads' ) {
			wp_enqueue_style( $this->slug . '-select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', '', $this->version, 'all' );
			wp_enqueue_script( $this->slug . '-select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [ 'jquery' ], $this->version, true );
		}

	    $localized = [
	    	'api_base'		=> get_rest_url() . 'leadpress/api/v1',
	    	'rest_nonce'	=> wp_create_nonce( $this->slug ),
	    	's_placeholder'	=> __( 'Select fields to include.', 'leadpress' ),
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

	public function send_scheduled_mail( $lead_id, $to, $subject, $body ) {
		$email 			= new Email();
        $log          	= new EmailLogs();

		$email_status 	= $email->send_mail( $to, $subject, $body );

        if ( ! $email_status ) {
            $log->add( $lead_id, 'failed' );
        }
        else {
            $log->add( $lead_id );
        }
	}
}