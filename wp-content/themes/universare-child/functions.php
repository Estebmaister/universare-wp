<?php
/**
 * Universare child theme bootstrap (Astra child).
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

require_once get_stylesheet_directory() . '/inc/brujula-icons.php';
require_once get_stylesheet_directory() . '/inc/brujula-landing-markup.php';
require_once get_stylesheet_directory() . '/inc/brujula-elementor.php';

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
 * Brújula landing page assets (PHP template or Elementor /landing-brujula).
 */
function universare_child_is_brujula_landing_page(): bool {
	return is_page_template( 'page-templates/landing-brujula.php' ) || universare_brujula_is_elementor_landing();
}

function universare_child_enqueue_landing_brujula(): void {
	if ( ! universare_child_is_brujula_landing_page() ) {
		return;
	}

	universare_child_enqueue_landing_brujula_assets();
}
add_action( 'wp_enqueue_scripts', 'universare_child_enqueue_landing_brujula', 30 );

/**
 * Register Brújula CSS (fonts, tokens, sections, Elementor overrides).
 */
function universare_child_enqueue_landing_brujula_assets(): void {
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
	wp_enqueue_style( 'universare-brujula-elementor', $base . 'elementor.css', array( 'universare-brujula-sections' ), $ver );

	$inline = '
.bru-landing .bru-icon-wrap .bru-icon,
body.bru-landing-elementor .bru-icon-wrap .bru-icon { color: #5a3a1a !important; }
.bru-landing .bru-icon-wrap .bru-icon.bru-icon--lg,
body.bru-landing-elementor .bru-icon-wrap .bru-icon.bru-icon--lg { width: 120px !important; height: 120px !important; }
.bru-landing .bru-icon-wrap .bru-icon.bru-icon--md,
body.bru-landing-elementor .bru-icon-wrap .bru-icon.bru-icon--md { width: 96px !important; height: 96px !important; }
.bru-landing .bru-final-cta h2,
body.bru-landing-elementor .bru-final-cta h2 { color: #ffffff !important; }
';
	wp_add_inline_style( 'universare-brujula-sections', $inline );
}

/**
 * Brújula styles inside Elementor editor and preview iframe.
 */
function universare_child_enqueue_landing_brujula_elementor(): void {
	$post_id = 0;
	if ( ! empty( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$post_id = (int) $_GET['post']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	}
	if ( ! $post_id || ! universare_brujula_is_elementor_landing( $post_id ) ) {
		return;
	}
	universare_child_enqueue_landing_brujula_assets();
}
add_action( 'elementor/editor/before_enqueue_styles', 'universare_child_enqueue_landing_brujula_elementor' );
add_action( 'elementor/frontend/after_enqueue_styles', 'universare_child_enqueue_landing_brujula_elementor' );
add_action( 'elementor/preview/enqueue_styles', 'universare_child_enqueue_landing_brujula_elementor' );

/**
 * Wrap Elementor canvas content in .bru-landing for design tokens + layout.
 */
function universare_brujula_elementor_canvas_open(): void {
	if ( ! universare_brujula_is_elementor_landing() ) {
		return;
	}
	echo '<div class="bru-landing" id="brujula-landing">';
}
add_action( 'elementor/page_templates/canvas/before_content', 'universare_brujula_elementor_canvas_open', 5 );

/**
 * Close Brújula wrapper and output mobile nav script.
 */
function universare_brujula_elementor_canvas_close(): void {
	if ( ! universare_brujula_is_elementor_landing() ) {
		return;
	}
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo universare_brujula_render_landing_menu_script();
	echo '</div>';
}
add_action( 'elementor/page_templates/canvas/after_content', 'universare_brujula_elementor_canvas_close', 50 );

/**
 * Body class + hide Astra chrome on Brújula landings.
 */
function universare_child_brujula_body_class( array $classes ): array {
	if ( universare_child_is_brujula_landing_page() ) {
		$classes[] = 'bru-landing-body';
		if ( universare_brujula_is_elementor_landing() ) {
			$classes[] = 'bru-landing-elementor';
		}
	}
	return $classes;
}
add_filter( 'body_class', 'universare_child_brujula_body_class' );

/**
 * Default CTA for Brújula landing — filter to Calendly, WhatsApp, etc.
 *
 * @param string $url CTA URL.
 */
function universare_brujula_default_cta_url( string $url ): string {
	if ( '#agendar' !== $url ) {
		return $url;
	}

	if ( universare_brujula_is_elementor_landing() ) {
		return home_url( '/landing-brujula/#agendar' );
	}

	if ( is_page_template( 'page-templates/landing-brujula.php' ) || is_page( 'landing' ) ) {
		return home_url( '/landing/#agendar' );
	}

	return $url;
}
add_filter( 'universare_brujula_cta_url', 'universare_brujula_default_cta_url' );
