<?php
/**
 * Contact form handler for the native <form> in sections/contact.php.
 * Validates nonce + honeypot, then sends an email notification.
 * A production deployment might swap this for Contact Form 7 or
 * Fluent Forms — this native handler keeps the portfolio build
 * dependency-free while still being a real, working submission path.
 *
 * @package StomatologiaWiacek
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sw_handle_contact_form() {
	if (
		! isset( $_POST['sw_contact_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sw_contact_nonce'] ) ), 'sw_contact_form' )
	) {
		wp_die( esc_html__( 'Nieprawidłowe żądanie.', 'stomatologia-wiacek' ) );
	}

	// Honeypot: if filled, silently pretend success (don't tip off bots).
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sw_contact', 'sent', wp_get_referer() ) );
		exit;
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$contact = isset( $_POST['contact'] ) ? sanitize_text_field( wp_unslash( $_POST['contact'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( empty( $name ) || empty( $contact ) || empty( $message ) ) {
		wp_safe_redirect( add_query_arg( 'sw_contact', 'error', wp_get_referer() ) );
		exit;
	}

	$to      = sw_get_option( 'clinic_email', get_option( 'admin_email' ) );
	$subject = sprintf( 'Nowa wiadomość ze strony — %s', $name );
	$body    = "Imię i nazwisko: {$name}\nKontakt: {$contact}\n\nWiadomość:\n{$message}";

	wp_mail( $to, $subject, $body );

	wp_safe_redirect( add_query_arg( 'sw_contact', 'sent', wp_get_referer() ) . '#kontakt' );
	exit;
}
add_action( 'admin_post_sw_contact_form', 'sw_handle_contact_form' );
add_action( 'admin_post_nopriv_sw_contact_form', 'sw_handle_contact_form' );
