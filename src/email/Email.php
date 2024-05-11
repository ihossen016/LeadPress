<?php

namespace Ismail\LeadPress\Email;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Email {
	
	public function send_instant_mail( $to, $subject, $body ) {
		$headers 	= array( 'Content-Type: text/html; charset=UTF-8' );
		$mail_sent 	= wp_mail( $to, $subject, $body, $headers );

		return $mail_sent;
	}
}