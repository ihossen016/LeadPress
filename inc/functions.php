<?php

if ( ! function_exists( 'sanitize' ) ) :
function sanitize( $input ) {

    // Sanitize the input text
    $sanitized_text = htmlspecialchars( $input, ENT_QUOTES, 'UTF-8' );

    return $sanitized_text;
}
endif;

if ( ! function_exists( 'delete_leadpress_cache' ) ) :
function delete_leadpress_cache( $name ) {
    $transient_key = 'leadpress_' . $name;

    delete_transient( $transient_key );
}
endif;
