<?php

namespace Ismail\LeadPress\Base;
use Ismail\LeadPress\Base\CoreManager;
use Ismail\LeadPress\Base\CoreTrait;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

abstract class Core implements CoreManager {

	use CoreTrait;

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * If the method doesn't exist show an admin notice.
	 * 
	 * @param string $callback
	 * 
	 * @return bool
	 */
	public function is_method_exists( $callback ) {

		if( ! method_exists( $this, $callback ) ) {
			
			add_action( 'plugins_loaded', function() use( $callback ) {
				if( current_user_can( 'manage_options' ) ) {
					add_action( ( is_admin() ? 'admin_head' : 'wp_head' ), function() use ( $callback ) {
						printf(
							'<div class="notice notice-error leadpress-notice leadpress-shadow"><p>%s</p></div>',
							sprintf( __( 'Hey Dev, it looks like you forgot to define the <code>%1$s()</code> method in the <code>%2$s</code> class!', 'leadpress' ), $callback, get_called_class() )
						);
					} );
				}
			} );

			return false;
		}

		return true;
	}

	/**
	 * @see register_activation_hook
	 */
	public function activate( $callback ) {

		if( ! $this->is_method_exists( $callback ) ) return;

		register_activation_hook( $this->plugin[ 'file' ], [ $this, $callback ] );
	}
	
	/**
	 * @see register_activation_hook
	 */
	public function deactivate( $callback ) {

		if( ! $this->is_method_exists( $callback ) ) return;

		register_deactivation_hook( $this->plugin[ 'file' ], [ $this, $callback ] );
	}
	
	/**
	 * @see add_action
	 */
	public function action( $tag, $callback, $priority = 10, $accepted_args = 1 ) {

		if( ! $this->is_method_exists( $callback ) ) return;

		add_action( $tag, [ $this, $callback ], $priority, $accepted_args );
	}

	/**
	 * @see add_filter
	 */
	public function filter( $tag, $callback, $priority = 10, $accepted_args = 1 ) {

		if( ! $this->is_method_exists( $callback ) ) return;

		add_filter( $tag, [ $this, $callback ], $priority, $accepted_args );
	}

	/**
	 * @see add_shortcode
	 */
	public function register( $tag, $callback ) {

		if( ! $this->is_method_exists( $callback ) ) return;

		add_shortcode( $tag, [ $this, $callback ] );
	}
}