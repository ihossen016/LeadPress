<?php

namespace Ismail\LeadPress\Public;
use Ismail\LeadPress\Base\Core;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helper extends Core {
	
	public static function get_template( $slug, $base = 'templates' ) {

		$template_dir 	= dirname( LEADPRESS ) . "/{$base}/";
		$template_path 	= $template_dir . $slug . '.php';

		if ( file_exists( $template_path ) ) {
			ob_start();

			include $template_path;
			
			return ob_get_clean();
		}
		else {
			return __( 'Template not found!', 'leadpress' );
		}
	}
}