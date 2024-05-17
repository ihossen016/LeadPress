<?php

use Ismail\LeadPress\Email\EmailLogs;
use Ismail\LeadPress\Utils\Table;

$columns = [
    'col_id'      	=> __( 'ID', 'leadpress' ),
    'col_name'    	=> __( 'Name', 'leadpress' ),
    'col_email'   	=> __( 'Email', 'leadpress' ),
    'col_status'  	=> __( 'Status', 'leadpress' ),
    'col_date'   	=> __( 'Date', 'leadpress' ),
];

$logs = new EmailLogs();


?>

<h1>Email Logs</h1>