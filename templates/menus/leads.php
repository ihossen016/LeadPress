<?php

use Ismail\LeadPress\Utils\Table;

global $wpdb;

$cache_key  = 'leadpress_leads';
$cache_time = MINUTE_IN_SECONDS;

// get cache data
$leads = get_transient( $cache_key );

if ( ! $leads ) {
    $leads = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}leadpress_leads", ARRAY_A );

    // set cache
    set_transient( $cache_key, $leads, $cache_time );
}

if ( empty( $leads ) ) {
    echo Helper::get_template( 'not-found', 'templates/menus' );
    return;
}

$columns = array(
    'col_id'      	=> __( 'ID', 'leadpress' ),
    'col_name'    	=> __( 'Name', 'leadpress' ),
    'col_email'   	=> __( 'Email', 'leadpress' ),
    'col_date'   	=> __( 'Date', 'leadpress' ),
    'col_actions'  	=> __( 'Actions', 'leadpress' ),
);

$data = array_map( function ( $lead ) {
    $name       = '<input type="text" name="col_name" value="' . $lead['name'] . '" disabled />';
    $email      = '<input type="text" name="col_email" value="' . $lead['email'] . '" disabled />';
    $actions    = '<a href="#" class="leadpress-save" data-id="' . $lead['id'] . '" style="display: none;">'. __( 'Save', 'leadpress' ) .'</a> 
                    <a href="#" class="leadpress-edit">'. __( 'Edit', 'leadpress' ) .'</a> | 
                    <a href="#" class="leadpress-delete" data-id="' . $lead['id'] . '">'. __( 'Delete', 'leadpress' ).'</a>';

    return array(
        'col_id'      	=> $lead['id'],
        'col_name'    	=> $name,
        'col_email'   	=> $email,
        'col_date'   	=> $lead['time'],
        'col_actions'  	=> $actions,
    );
}, $leads );

$table = new Table( $columns, $data );
?>

<div class="leadpress-wrap">
    <div class="leadpress-table-header">
        <h1><?php _e( 'Leads Table', 'leadpress' ); ?></h1>

        <div class="leadpress-export">
            <div class="leadpress-export-options-wrap">
                <h3><?php _e( 'Export Leads: ', 'leadpress' ); ?></h3>
                <select class="leadpress-export-options" name="states[]" multiple="multiple">
                    <option></option>
                    <option value="id"><?php esc_html_e( 'ID', 'leadpress' ); ?></option>
                    <option value="name"><?php esc_html_e( 'Name', 'leadpress' ); ?></option>
                    <option value="email"><?php esc_html_e( 'Email', 'leadpress' ); ?></option>
                    <option value="time"><?php esc_html_e( 'Date', 'leadpress' ); ?></option>
                </select>
            </div>

            <button class="button button-secondary" id="leadpress-export-leads"><?php esc_html_e( 'Export', 'leadpress' ); ?></button>
        </div>
    </div>

    <?php $table->display_table(); ?>
</div>
