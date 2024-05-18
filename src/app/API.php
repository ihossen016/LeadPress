<?php

namespace Ismail\LeadPress\App;
use Ismail\LeadPress\Base\Core;
use Ismail\LeadPress\Api\Lead;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class API extends Core {

	public $plugin;

	public $slug;

	public $version;

	public $namespace;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin		= $plugin;
		$this->slug			= $this->plugin['TextDomain'];
		$this->version		= $this->plugin['Version'];
		$this->namespace	= sprintf( 'leadpress/api/v%1$s', 1 );
	}

	public function register_routes() {
		/**
		 * Create new Lead
		 */
		register_rest_route( $this->namespace, '/lead/create', [
			'methods'  				=> [ 'POST' ],
			'callback' 				=> [ new Lead, 'create_lead' ],
			'permission_callback' 	=> '__return_true',
		] );

		/**
		 * Update Lead
		 */
		register_rest_route( $this->namespace, '/lead/(?P<id>\d+)/update', [
			'methods'  				=> [ 'PUT' ],
			'callback' 				=> [ new Lead, 'update_lead' ],
			'permission_callback' 	=> '__return_true',
		] );

		/**
		 * Delete Lead
		 */
		register_rest_route( $this->namespace, '/lead/(?P<id>\d+)/delete', [
			'methods'  				=> [ 'DELETE' ],
			'callback' 				=> [ new Lead, 'delete_lead' ],
			'permission_callback' 	=> '__return_true',
		] );

		/**
		 * Export Leads
		 */
		register_rest_route( $this->namespace, '/leads/export', [
			'methods'  				=> [ 'POST' ],
			'callback' 				=> [ new Lead, 'export_leads' ],
			'permission_callback' 	=> '__return_true',
		] );
	}

	public function verify_request() {
		$nonce = isset( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : '';

		if ( ! wp_verify_nonce( $nonce, $this->slug ) ) {
			return false;
		}
	
		return true;
	}
}