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

    public $plugin;

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
        $email_status   = $email->send_mail( 
            $lead['email'], 
            __( 'LeadPress Subscription', 'leadpress' ), 
            __( 'Thank you for subscribing with us.', 'leadpress' ) 
        );

        $email->schedule_mail( 
            $lead_id,
            $lead['email'], 
            __( 'LeadPress Subscription ', 'leadpress' ), 
            __( 'This is your subscription mail.', 'leadpress' ) 
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

    public function update_lead( $request ) {
        $id     = $request->get_param( 'id' ) ? sanitize_text_field( $request->get_param( 'id' ) ) : '';
        $name   = $request->get_param( 'name' ) ? sanitize_text_field( $request->get_param( 'name' ) ) : '';
        $email  = $request->get_param( 'email' ) ? sanitize_text_field( $request->get_param( 'email' ) ) : '';

        if ( ! $id ) {
            return [
                'success' => false,
                'message' => __( 'Invalid ID', 'leadpress' ),
            ];
        }

        $db     = new DB( $this->plugin );
        $result = $db->update( 'leadpress_leads', [ 'name' => $name, 'email' => $email ], [ 'id' => $id ] );

        if ( is_wp_error( $result ) ) {
            return [
                'success' => false,
                'message' => $result->get_error_message(),
            ];
        }
        
        // delete previous cache
        delete_leadpress_cache( 'leads' );

        return [
            'success' => true,
            'message' => __( 'Lead updated successfully', 'leadpress' ),
        ];
    }

    public function delete_lead( $request ) {
        $id     = $request->get_param( 'id' ) ? sanitize_text_field( $request->get_param( 'id' ) ) : '';

        if ( ! $id ) {
            return [
                'success' => false,
                'message' => __( 'Invalid ID', 'leadpress' ),
            ];
        }

        $db         = new DB( $this->plugin );
        $logs       = new EmailLogs();

        $log_status = $logs->delete( $id );
        
        if ( is_wp_error( $log_status ) ) {
            return [
                'success' => false,
                'message' => $log_status->get_error_message(),
            ];
        }

        $result     = $db->delete( 'leadpress_leads', [ 'id' => $id ] );

        if ( is_wp_error( $result ) ) {
            return [
                'success' => false,
                'message' => $result->get_error_message(),
            ];
        }
        
        // delete previous cache
        delete_leadpress_cache( 'leads' );
        delete_leadpress_cache( 'email_logs' );

        return [
            'success' => true,
            'message' => __( 'Lead deleted successfully', 'leadpress' ),
        ];
    }

    public function export_leads( $request ) {        
        global $wpdb;
        
        $fields = json_decode( $request->get_param( 'fields' ) );
        update_option( 'fieldssss', $fields );
        $query  = "SELECT " . implode( ', ', $fields ) . " FROM {$wpdb->prefix}leadpress_leads";
        $leads  = $wpdb->get_results( $query, ARRAY_A );

        // convert array to csv format
        $csv    = [ array_map( 'ucfirst', $fields ) ];
        $csv    = array_merge( $csv, array_map( function( $entry ) use ( $fields ) {
            return array_values( array_intersect_key( $entry, array_flip( $fields ) ) );
        }, $leads ) );

        return [
            'success'   => true,
            'data'      => $csv,
        ];
    }
}