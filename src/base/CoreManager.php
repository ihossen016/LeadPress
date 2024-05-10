<?php

namespace Ismail\LeadPress\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface CoreManager {

	/**
	 * Check if a method exists
	 * 
	 * @param string $callback
	 * 
	 * @return bool
	 */
	public function is_method_exists( $callback );
}
