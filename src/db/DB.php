<?php

namespace Ismail\LeadPress\DB;
use Ismail\LeadPress\Base\Core;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class DB extends Core {
	
	public $plugin;

	public $slug;

	public $version;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin		= $plugin;
		$this->slug			= $this->plugin['TextDomain'];
		$this->version		= $this->plugin['Version'];

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	}

	public function create_tables() {
		global $wpdb;
		
		$charset_collate 	= $wpdb->get_charset_collate();
	
		// Table names
		$leads_table 		= $wpdb->prefix . 'leadpress_leads';
		$email_logs_table 	= $wpdb->prefix . 'leadpress_email_logs';
	
		/**
		 * Create leads table
		 */
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$leads_table'" ) != $leads_table ) {
	
			$sql = "CREATE TABLE $leads_table (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				name VARCHAR(255) NOT NULL,
				email VARCHAR(255) NOT NULL,
				time DATETIME DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY  (id)
			) $charset_collate;";

			dbDelta($sql);
		}
	
		/**
		 * Create email logs table
		 */
		if ( $wpdb->get_var( "SHOW TABLES LIKE '$email_logs_table'" ) != $email_logs_table ) {
	
			$sql = "CREATE TABLE $email_logs_table (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				lead_id BIGINT(20) UNSIGNED NOT NULL,
				status VARCHAR(255) NOT NULL,
				time DATETIME DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY  (id),
				FOREIGN KEY (lead_id) REFERENCES $leads_table(id)
			) $charset_collate;";

			dbDelta( $sql );
		}
	}

	public function insert( $table, $data ) {

		global $wpdb;

		$table_name = $wpdb->prefix . $table;

		$wpdb->insert( $table_name, $data );

		// Check if the insertion was successful
		if ( $wpdb->last_error ) {
			return new \WP_Error( 'database_error', 'Database error occurred.', array( 'status' => 500 ) );
		}

		return true;
	}
}