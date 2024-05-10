<?php

namespace Ismail\LeadPress\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

trait CoreTrait {
	
	/**
	 * Sanitize text input
	 * 
	 * @param mix $input The input
	 * 
     * @return string
	 */
	public function sanitize( $input ) {

        // Sanitize the input text
        $sanitized_text = htmlspecialchars( $input, ENT_QUOTES, 'UTF-8' );

        return $sanitized_text;
	}
}