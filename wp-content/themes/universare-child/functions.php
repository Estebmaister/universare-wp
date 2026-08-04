<?php
/**
 * Universare child theme bootstrap (Astra child).
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/inc/brujula-icons.php';

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

	$ver  = wp_get_theme()->get( 'Version' );
	$base = get_stylesheet_directory_uri() . '/assets/css/brujula/';

	wp_enqueue_style(
		'universare-brujula-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=Montserrat:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'universare-brujula-tokens', $base . 'tokens.css', array( 'universare-brujula-fonts' ), $ver );
	wp_enqueue_style( 'universare-brujula-base', $base . 'base.css', array( 'universare-brujula-tokens' ), $ver );
	wp_enqueue_style( 'universare-brujula-components', $base . 'components.css', array( 'universare-brujula-base' ), $ver );
	wp_enqueue_style( 'universare-brujula-sections', $base . 'sections.css', array( 'universare-brujula-components' ), $ver );

	$inline = '
.bru-landing .bru-icon-wrap .bru-icon { color: #5a3a1a !important; }
.bru-landing .bru-icon-wrap .bru-icon.bru-icon--lg { width: 120px !important; height: 120px !important; }
.bru-landing .bru-icon-wrap .bru-icon.bru-icon--md { width: 96px !important; height: 96px !important; }
.bru-landing .bru-final-cta h2 { color: #ffffff !important; }
';
	wp_add_inline_style( 'universare-brujula-sections', $inline );
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
