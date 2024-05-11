<?php

namespace Ismail\LeadPress\Api;
use Ismail\LeadPress\DB\DB;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Lead {

    public function create_lead( $request ) {

        $lead           = [
            'name'      => sanitize( $request->get_param( 'name' ) ),
            'email'     => sanitize( $request->get_param( 'email' ) ),
        ];

        $db             = new DB( $this->plugin );
        $email_exists   = $db->check( 'leadpress_leads', 'email', $lead['email'] );

        if ( $email_exists ) {
            $response   = [ 
                'success'   => false,
                'message'   => 'You have already subscribed' 
            ];

            return $response;
        }

        $result         = $db->insert( 'leadpress_leads', $lead );

        if ( is_wp_error( $result ) ) {
            $response   = [ 
                'success'   => false,
                'message'   => $result->get_error_message() 
            ];

            return $response;
        }

        $response       = [
            'success'   => true,
            'message'   => 'Lead created successfully',
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