<?php

namespace Ismail\LeadPress\Email;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EmailLogs {

    /**
     * Add Email Logs
     *
     * @return void
     */
    public static function add( $lead_id, $status = 'sent' ) {

        global $wpdb;

        $data   = [
            'lead_id'   => $lead_id,
            'status'    => $status
        ];

        $wpdb->insert( $wpdb->prefix . 'leadpress_email_logs', $data );
        
		// Check if the insertion was successful
		if ( $wpdb->last_error ) {
			return new \WP_Error( 'database_error', 'Database error occurred.', array( 'status' => 500 ) );
		}

		return $wpdb->insert_id;
    }

    public static function get() {

        global $wpdb;

        $query = "SELECT 
                    e.id, 
                    l.name, 
                    l.email, 
                    e.status, 
                    e.time 
                FROM 
                    {$wpdb->prefix}leadpress_leads l 
                LEFT JOIN 
                    {$wpdb->prefix}leadpress_email_logs e 
                ON 
                    l.id = e.lead_id";

        $logs = $wpdb->get_results( $query, ARRAY_A );

        return $logs;
    }
}