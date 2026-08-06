<?php
/**
 * Must-use plugin loaded on every request.
 *
 * @package Universare
 */

defined( 'ABSPATH' ) || exit;

/**
 * Create Brújula landing page at /landing once (idempotent).
 */
function universare_ensure_brujula_landing_page(): void {
	if ( ! function_exists( 'wp_insert_post' ) ) {
		return;
	}

	$template = 'page-templates/landing-brujula.php';
	$existing = get_page_by_path( 'landing', OBJECT, 'page' );

	if ( $existing instanceof WP_Post ) {
		$current_template  = get_post_meta( $existing->ID, '_wp_page_template', true );
		$elementor_builder = 'builder' === get_post_meta( $existing->ID, '_elementor_edit_mode', true );
		$force_template    = apply_filters( 'universare_force_brujula_template', true, $existing );

		if ( $force_template && ! $elementor_builder && $template !== $current_template ) {
			update_post_meta( $existing->ID, '_wp_page_template', $template );
		}

		if ( ! get_option( 'universare_brujula_page_created' ) ) {
			update_option( 'universare_brujula_page_created', 1 );
		}
		return;
	}

	if ( get_option( 'universare_brujula_page_created' ) ) {
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Brújula — Sesión de Claridad',
			'post_name'    => 'landing',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		return;
	}

	update_post_meta( $page_id, '_wp_page_template', $template );
	update_option( 'universare_brujula_page_created', 1 );
}
add_action( 'init', 'universare_ensure_brujula_landing_page', 20 );

/**
 * Create Brújula Elementor landing at /landing-brujula once (idempotent).
 */
function universare_ensure_brujula_elementor_landing_page(): void {
	if ( ! function_exists( 'wp_insert_post' ) || ! function_exists( 'universare_brujula_sync_elementor_page' ) ) {
		return;
	}

	$existing = get_page_by_path( 'landing-brujula', OBJECT, 'page' );
	$theme_ver = wp_get_theme()->get( 'Version' );
	$kit_ver   = get_option( 'universare_brujula_elementor_kit_version', '' );

	if ( $existing instanceof WP_Post ) {
		if ( $kit_ver !== $theme_ver || ! get_post_meta( $existing->ID, '_elementor_data', true ) ) {
			universare_brujula_sync_elementor_page( (int) $existing->ID, $kit_ver !== $theme_ver );
		}

		if ( ! get_option( 'universare_brujula_elementor_page_created' ) ) {
			update_option( 'universare_brujula_elementor_page_created', 1 );
		}
		return;
	}

	if ( get_option( 'universare_brujula_elementor_page_created' ) ) {
		return;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Brújula — Sesión de Claridad (Elementor)',
			'post_name'    => 'landing-brujula',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		return;
	}

	universare_brujula_sync_elementor_page( (int) $page_id, true );
	update_option( 'universare_brujula_elementor_page_created', 1 );
}
add_action( 'init', 'universare_ensure_brujula_elementor_landing_page', 21 );
