<?php

namespace Ismail\LeadPress\Api;
use Ismail\LeadPress\Base\Core;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Lead {

    public function create_lead( $request ) {
        return ['success' => true];
    }

    public function edit_lead( $request ) {
        return ['success' => $request->get_param( 'id' )];
    }

    public function delete_lead( $request ) {
        return ['success' => $request->get_param( 'id' )];
    }
}