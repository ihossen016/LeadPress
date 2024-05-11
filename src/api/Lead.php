<?php

namespace Ismail\LeadPress\Api;
use Ismail\LeadPress\Base\Core;
use Ismail\LeadPress\DB\DB;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Lead extends Core {

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

    public function create_lead( $request ) {
        $lead = [
            'name'  => $this->sanitize( $request->get_param( 'name' ) ),
            'email' => $this->sanitize( $request->get_param( 'email' ) ),
        ];

        $db = new DB( $this->plugin );
        $result = $db->insert( 'leadpress_leads', $lead );

        if ( is_wp_error( $result ) ) {
            $response = [
                'success' => false,
                'error'   => $result->get_error_message(),
            ];

            return $response;
        }

        $response = [
            'success' => true,
        ];

        return $response;
    }

    public function edit_lead( $request ) {
        return ['success' => $request->get_param( 'id' )];
    }

    public function delete_lead( $request ) {
        return ['success' => $request->get_param( 'id' )];
    }
}