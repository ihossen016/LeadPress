<?php

namespace Ismail\LeadPress\Email;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Email {
	
	public function send_mail( $to, $subject, $body ) {
		$headers 	= array( 'Content-Type: text/html; charset=UTF-8' );
		$mail_sent 	= wp_mail( $to, $subject, $body, $headers );

		return $mail_sent;
	}

	public function schedule_mail( $lead_id, $to, $subject, $body ) {
		$args = [ $lead_id, $to, $subject, $body ];

		as_schedule_single_action( wp_date( 'U' ) + 5 * MINUTE_IN_SECONDS, 'leadpress_schedule_email', $args );
	}
}