<?php
/**
 * Universare child theme bootstrap (Astra child).
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue parent and child theme styles.
 */
function universare_child_enqueue_styles(): void {
	wp_enqueue_style(
		'astra-theme-css',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'astra' )->get( 'Version' )
	);

	wp_enqueue_style(
		'universare-child',
		get_stylesheet_uri(),
		array( 'astra-theme-css' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'universare_child_enqueue_styles', 20 );
