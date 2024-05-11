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
		 * Edit Lead
		 */
		register_rest_route( $this->namespace, '/lead/(?P<id>\d+)/edit', [
			'methods'  				=> [ 'PUT' ],
			'callback' 				=> [ new Lead, 'edit_lead' ],
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
	}
}