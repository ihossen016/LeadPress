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
use Ismail\LeadPress\APP\Front;

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
        
        // Include files
        $this->include();

        // Define constants
        $this->define();

        // Run all the hooks
        $this->hooks();
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
        
        /**
         * Frontend hooks
         */
        $front = new Front( $this->plugin );
        $front->action( 'wp_enqueue_scripts', 'enqueue_scripts', 100 );
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