<?php


if ( ! function_exists( 'sanitize' ) ) :
function sanitize( $input ) {

    // Sanitize the input text
    $sanitized_text = htmlspecialchars( $input, ENT_QUOTES, 'UTF-8' );

    return $sanitized_text;
}
endif;