<?php
/**
 * Plugin Name: LeadPress
 * Description: A CRM plugin for WordPress.
 * Plugin URI: https://github.com/ihossen016/LeadPress
 * Author: Ismail Hossen
 * Author URI: https://ismailhossen.dev
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.4
 * Text Domain: leadpress
 * Domain Path: /languages
 */

namespace Ismail\LeadPress;
use Ismail\LeadPress\APP\Admin;
use Ismail\LeadPress\App\API;
use Ismail\LeadPress\APP\Front;
use Ismail\LeadPress\App\Shortcode;
use Ismail\LeadPress\DB\DB;

final class Plugin {

    public $plugin;

    /**
     * Plugin instance
     * 
     * @since 1.0.0
     * 
     * @access private
     */
    private static $_instance;

    /**
     * Constructor function.
     *
     * This function initializes the object by calling the `include()`, `define()`,
     * and `hook()` methods.
     *
     * @return void
     */
    public function __construct() {
        		
		/**
		 * Check for action scheduler tables
		 */
		register_activation_hook( __FILE__, [ $this, '__invoke' ] );

        // Include files
        $this->include();

        // Define constants
        $this->define();

        // Run all the hooks
        $this->hooks();
    }

	/**
	 * Check for action scheduler tables before activation
	 */
	public function __invoke() {

		$table_report = leadpress_check_action_tables();

		// check for missing tables
		if( in_array( true, $table_report ) ) :

			// check store table
			if( $table_report['store_table_missing'] ) :
				delete_option( 'schema-ActionScheduler_StoreSchema' );

				$action_store_db 	= new \ActionScheduler_DBStore();
				$action_store_db->init();
			endif;

			// check log table
			if( $table_report['log_table_missing'] ) :
				delete_option( 'schema-ActionScheduler_LoggerSchema' );

				$action_log_db 		= new \ActionScheduler_DBLogger();
				$action_log_db->init();
			endif;

		endif;
	}

    /**
     * Include files
     * 
     * @return void
     * 
     * @since 1.0.0
     * 
     * @access private
     */
    private function include() {
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
		require_once( dirname( __FILE__ ) . '/libraries/action-scheduler/action-scheduler.php' );
        require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

    /**
     * Define constants
     * 
     * @return void
     * 
     * @since 1.0.0
     * 
     * @access private
     */
    private function define() {
        define( 'LEADPRESS', __FILE__ );
		define( 'LEADPRESS_DIR', dirname( LEADPRESS ) );
		define( 'LEADPRESS_ASSET', plugins_url( 'assets', LEADPRESS ) );

        /**
         * Plugin information
         */
        $this->plugin		        = get_plugin_data( LEADPRESS );
		$this->plugin['basename']	= plugin_basename( LEADPRESS );
		$this->plugin['file']		= LEADPRESS;
		$this->plugin['assets']		= LEADPRESS_ASSET;
    }

    /**
     * All the hooks
     * 
     * @return void
     * 
     * @since 1.0.0
     * 
     * @access private
     */
    private function hooks() {
        /**
         * Admin hooks
         */
        $admin = new Admin( $this->plugin );
        $admin->action( 'admin_enqueue_scripts', 'enqueue_scripts', 100 );
        $admin->action( 'init', 'register_admin_menu', 0 );
        $admin->action( 'admin_footer', 'modal' );
        $admin->action( 'leadpress_schedule_email', 'send_scheduled_mail', 10, 4 );

        /**
         * Database actions
         */
        $db = new DB( $this->plugin );
        $db->activate( 'create_tables' );
        
        /**
         * Frontend hooks
         */
        $front = new Front( $this->plugin );
        $front->action( 'wp_enqueue_scripts', 'enqueue_scripts', 100 );
        $front->action( 'wp_footer', 'modal' );

        /**
         * Shortcode hooks
         */
        $shortcode = new Shortcode( $this->plugin );
        $shortcode->register( 'leadpress_optin_form', 'show_optin_form' );

        /**
         * API routes
         */
        $api = new API( $this->plugin );
        $api->action( 'rest_api_init', 'register_routes' );
    }

    /**
	 * Instantiate the plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}
Plugin::instance();