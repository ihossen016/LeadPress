<?php

use Ismail\LeadPress\Utils\Table;

$columns = array(
    'col_id'      	=> __( 'ID', 'leadpress' ),
    'col_name'    	=> __( 'Name', 'leadpress' ),
    'col_email'   	=> __( 'Email', 'leadpress' ),
    'col_date'   	=> __( 'Date', 'leadpress' ),
    'col_actions'  	=> __( 'Actions', 'leadpress' ),
);

$data = array(
    array(
        'col_id'    => 1,
        'col_name'  => '<input type="text" name="col_name" value="John Doe" style="display: none;" /> <span>John Doe</span>',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 2,
        'col_name'  => 'aohn Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 3,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 4,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 5,
        'col_name'  => 'aohn Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 6,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 7,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 8,
        'col_name'  => 'aohn Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 9,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 10,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 11,
        'col_name'  => 'aohn Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    array(
        'col_id'    => 12,
        'col_name'  => 'John Doe',
        'col_email' => 'john@example.com',
        'col_date'  => '2019-01-01 00:00:00',
        'col_actions' => '<a href="#">Edit</a> | <a href="#">Delete</a>',
    ),
    // Add more rows of data as needed
);

$custom_table = new Table( $columns, $data );
?>
<div class="leadpress-wrap">
    <h1>Leads Table</h1>
    <?php $custom_table->display_table(); ?>
</div>
<?php
