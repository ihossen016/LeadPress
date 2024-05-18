<?php

if ( ! function_exists( 'sanitize' ) ) :
function sanitize( $input ) {

    // Sanitize the input text
    $sanitized_text = htmlspecialchars( $input, ENT_QUOTES, 'UTF-8' );

    return $sanitized_text;
}
endif;

if ( ! function_exists( 'delete_leadpress_cache' ) ) :
function delete_leadpress_cache( $name ) {
    $transient_key = 'leadpress_' . $name;

    delete_transient( $transient_key );
}
endif;

if ( ! function_exists( 'leadpress_check_action_tables' ) ) :
function leadpress_check_action_tables() {
    global $wpdb;

    $log_schema_table       = $wpdb->prefix . 'actionscheduler_logs';
    $store_schema_tables    = [
        $wpdb->prefix . 'actionscheduler_actions',
        $wpdb->prefix . 'actionscheduler_claims',
        $wpdb->prefix . 'actionscheduler_groups'
    ];
    
    $tables_exists = [
        'store_table_missing' => false,
        'log_table_missing'   => false
    ];
    
    // check if store tables exists
    foreach ( $store_schema_tables as $table_name ) {
        $table_exists = $wpdb->get_var( "SHOW TABLES LIKE ' $table_name '" ) === $table_name;
        
        if ( ! $table_exists ) {
            $tables_exists['store_table_missing'] = true;
            break;
        }
    }

    // check if log table exists
    $log_table_exists = $wpdb->get_var( "SHOW TABLES LIKE ' $log_schema_table '" ) === $log_schema_table;

    if ( ! $log_table_exists ) {
        $tables_exists['log_table_missing'] = true;
    }

    return $tables_exists;
}
endif;