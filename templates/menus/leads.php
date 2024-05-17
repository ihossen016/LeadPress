<?php

use Ismail\LeadPress\Utils\Table;

global $wpdb;

$cache_key  = 'leadpress_leads_data';
$cache_time = MINUTE_IN_SECONDS;

// get cache data
$leads = get_transient( $cache_key );

if ( ! $leads ) {
    $leads = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}leadpress_leads", ARRAY_A );

    // set cache
    set_transient( $cache_key, $leads, $cache_time );
}

if ( empty( $leads ) ) {
    echo '<p>' . __( 'No leads found', 'leadpress' ) . '</p>';
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
                    <a href="#" class="leadpress-delete">'. __( 'Delete', 'leadpress' ).'</a>';

    return array(
        'col_id'      	=> $lead['id'],
        'col_name'    	=> $name,
        'col_email'   	=> $email,
        'col_date'   	=> $lead['time'],
        'col_actions'  	=> $actions,
    );
}, $leads );

$custom_table = new Table( $columns, $data );
?>
<div class="leadpress-wrap">
    <h1>Leads Table</h1>
    <?php $custom_table->display_table(); ?>
</div>
<?php
