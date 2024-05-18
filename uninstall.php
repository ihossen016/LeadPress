<?php
// If uninstall is not called, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// delete cache
delete_leadpress_cache( 'leads' );
delete_leadpress_cache( 'email_logs' );

// delete scheduled emails
as_unschedule_all_actions( 'leadpress_schedule_email' );
