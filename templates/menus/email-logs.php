<?php

use Ismail\LeadPress\Email\EmailLogs;
use Ismail\LeadPress\Utils\Table;

$logs = EmailLogs::get();

if ( empty( $logs ) ) {
    echo '<p>' . __( 'No logs found', 'leadpress' ) . '</p>';
    return;
}

$columns = [
    'col_id'      	=> __( 'ID', 'leadpress' ),
    'col_name'    	=> __( 'Name', 'leadpress' ),
    'col_email'   	=> __( 'Email', 'leadpress' ),
    'col_status'  	=> __( 'Status', 'leadpress' ),
    'col_date'   	=> __( 'Date', 'leadpress' ),
];

$data = array_map( function( $row ) {
                $status = $row['status'] === 'sent' ? 
                            '<span class="leadpress-mail-status success">' . $row['status'] . '</span>' : 
                            '<span class="leadpress-mail-status failed">' . $row['status'] . '</span>';

                return [
                    'col_id'        => $row['id'],
                    'col_name'      => $row['name'],
                    'col_email'     => $row['email'],
                    'col_status'    => $status,
                    'col_date'      => $row['time'],
                ];
            }, 
            $logs 
        );

$table = new Table( $columns, $data );

?>

<div class="leadpress-wrap">
    <h1>Email Logs</h1>
    <?php $table->display_table(); ?>
</div>