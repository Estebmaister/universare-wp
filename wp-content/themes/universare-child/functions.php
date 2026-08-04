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

/**
 * Brújula landing page assets.
 */
function universare_child_enqueue_landing_brujula(): void {
	if ( ! is_page_template( 'page-templates/landing-brujula.php' ) ) {
		return;
	}

	wp_enqueue_style(
		'universare-brujula-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Montserrat:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'universare-brujula-landing',
		get_stylesheet_directory_uri() . '/assets/css/landing-brujula.css',
		array( 'universare-brujula-fonts' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'universare_child_enqueue_landing_brujula', 30 );

/**
 * Default CTA for Brújula landing — filter to Calendly, WhatsApp, etc.
 *
 * @param string $url CTA URL.
 */
function universare_brujula_default_cta_url( string $url ): string {
	if ( '#agendar' === $url ) {
		return home_url( '/landing/#agendar' );
	}
	return $url;
}
add_filter( 'universare_brujula_cta_url', 'universare_brujula_default_cta_url' );
