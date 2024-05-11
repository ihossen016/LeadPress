<?php

namespace Ismail\LeadPress\Api;

use Ismail\LeadPress\DB\DB;
use Ismail\LeadPress\Email\Email;
use Ismail\LeadPress\Email\EmailLogs;

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

        $lead_id        = $db->insert( 'leadpress_leads', $lead );

        if ( is_wp_error( $lead_id ) ) {
            $response   = [ 
                'success'   => false,
                'message'   => $lead_id->get_error_message() 
            ];

            return $response;
        }

        $email          = new Email();
        $log            = new EmailLogs();
        $email_status   = $email->send_instant_mail( 
            $lead['email'], 
            __( 'LeadPress Subscription', 'leadpress' ), 
            __( 'Thank you for subscribing with us.', 'leadpress' ) 
        );

        if ( ! $email_status ) {
            $log->add( $lead_id, 'failed' );
        }
        else {
            $log->add( $lead_id );
        }

        $response       = [
            'success'   => true,
            'email'     => $email_status,
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