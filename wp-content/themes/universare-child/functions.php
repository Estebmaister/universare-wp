<?php
/**
 * Universare child theme bootstrap.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue parent and child theme styles.
 */
function universare_child_enqueue_styles(): void {
	wp_enqueue_style(
		'hello-elementor',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'hello-elementor' )->get( 'Version' )
	);

	wp_enqueue_style(
		'universare-child',
		get_stylesheet_uri(),
		array( 'hello-elementor' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'universare_child_enqueue_styles', 20 );
