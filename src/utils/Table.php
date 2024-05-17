<?php

namespace Ismail\LeadPress\Utils;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Table extends \WP_List_Table {

	private $data;
	
	private $columns;

    // Constructor
    public function __construct( $columns, $data ) {
        parent::__construct( [
            'singular' => 'custom_item',
            'plural'   => 'custom_items',
            'ajax'     => false
        ] );

		$this->data 	= $data;
		$this->columns 	= $columns;
    }

    // Define the columns that will be displayed
    public function get_columns() {
        return $this->columns;
    }

    // Prepare the table with the data to be displayed
    public function prepare_items() {
        $columns 	= $this->get_columns();
        $hidden 	= [];
        $sortable 	= $this->get_sortable_columns();
        $data 		= $this->data;

        // Sort data
        usort( $data, [ $this, 'sort_data' ] );

        // Pagination settings
        $per_page 		= 20; 
        $current_page 	= $this->get_pagenum();
        $total_items 	= count( $data );

        // Create the pagination
        $this->set_pagination_args( [
            'total_items' => $total_items,
            'per_page'    => $per_page
        ] );

        // Slice the data based on pagination
        $data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ), $per_page );

        // Set the table data
        $this->_column_headers 	= [$columns, $hidden, $sortable];
        $this->items 			= $data;
    }

    public function display_table() {
        $this->prepare_items();
        $this->display();
    }

    // Define sortable columns
    public function get_sortable_columns() {
        return [
            'col_id'    => ['col_id', false],
            'col_name'  => ['col_name', false],
        ];
    }

    // Function for sorting data
	public function sort_data( $a, $b ) {
		$orderby 	= ( ! empty( $_REQUEST['orderby'] ) ) ? $_REQUEST['orderby'] : 'col_id';
		$order 		= ( ! empty( $_REQUEST['order'] ) ) ? $_REQUEST['order'] : 'asc';
	
		if ( $orderby == 'col_id' ) {
			$result = $a[$orderby] - $b[$orderby];
		} else {
			$result = strcmp( $a[$orderby], $b[$orderby] );
		}
	
		return $order === 'asc' ? $result : -$result;
	}

    // Define what will be displayed in each column
    public function column_default( $item, $column_name ) {
        return isset( $item[ $column_name ] ) ? $item[ $column_name ] : print_r( $item, true );
    }
}