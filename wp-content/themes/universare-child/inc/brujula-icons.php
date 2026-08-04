<?php
/**
 * Brújula landing SVG icons — thin gold line-art tuned to convey each meaning.
 *
 * 48×48 viewBox (logo 24×24), 1.5px strokes, artwork optically centered.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Render a Brújula icon.
 *
 * @param string $name Icon slug.
 * @param array  $args Optional class and size.
 */
function universare_brujula_icon( string $name, array $args = array() ): string {
	$size  = isset( $args['size'] ) ? (int) $args['size'] : 96;
	$class = 'bru-icon' . ( ! empty( $args['class'] ) ? ' ' . esc_attr( $args['class'] ) : '' );

	$s = 'stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"';

	$icons = array(
		'logo' => '<circle cx="12" cy="12" r="9.5" fill="none" stroke="currentColor" stroke-width="1.1"/>'
			. '<path d="M12 4.5l.9 3.6L12 9.2l-.9-1.5L12 4.5z" fill="currentColor"/>'
			. '<path d="M12 19.5l-.9-3.6L12 14.8l.9 1.5L12 19.5z" fill="currentColor" opacity=".45"/>'
			. '<path d="M4.5 12l3.6.9L9.2 12l-1.5-.9L4.5 12z" fill="currentColor" opacity=".65"/>'
			. '<path d="M19.5 12l-3.6.9L14.8 12l1.5-.9L19.5 12z" fill="currentColor" opacity=".65"/>',

		// Scattered — in many places at once, mind pulled in every direction.
		'scatter' => '<circle cx="24" cy="24" r="4.5" fill="none" ' . $s . '/>'
			. '<path d="M20.8 20.8L15 15M27.2 20.8L33 15M20.8 27.2L15 33M27.2 27.2L33 33" ' . $s . ' opacity=".7"/>'
			. '<circle cx="13.5" cy="13.5" r="1.7" fill="currentColor" stroke="none"/>'
			. '<circle cx="34.5" cy="13.5" r="1.7" fill="currentColor" stroke="none"/>'
			. '<circle cx="13.5" cy="34.5" r="1.7" fill="currentColor" stroke="none"/>'
			. '<circle cx="34.5" cy="34.5" r="1.7" fill="currentColor" stroke="none"/>',

		// Overthinking — head with a single inward swirl (mind won\'t switch off).
		'overthink' => '<circle cx="24" cy="22" r="12" fill="none" ' . $s . '/>'
			. '<path d="M24 16c3.3 0 6 2.7 6 6s-2.7 6-6 6-6-2.7-6-6 1.8-4 4-4 3.2 1.4 3.2 3.2-1.2 2.6-2.6 2.6" fill="none" ' . $s . '/>',

		// Open book — read, listened, tried, nothing fits.
		'book' => '<path d="M24 15c-3-2-7-3-11-3-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2 4 0 8 1 11 3" fill="none" ' . $s . '/>'
			. '<path d="M24 15c3-2 7-3 11-3 1.1 0 2 .9 2 2v18c0 1.1-.9 2-2 2-4 0-8 1-11 3" fill="none" ' . $s . '/>'
			. '<path d="M24 15v22" ' . $s . '/>',

		// Cloud — mental fog / don\'t know where to start.
		'cloud' => '<path d="M16 32h16a5 5 0 000-10 6.5 6.5 0 00-12.4-1.6A4 4 0 0016 32z" fill="none" ' . $s . '/>',

		// Spiral — confusion, going in circles.
		'spiral' => '<path d="M24 24c0-2 1.6-3.6 3.6-3.6s3.6 1.6 3.6 3.6-1.6 3.6-3.6 3.6-6-2.7-6-6 2.7-6 6-6 8.5 3.8 8.5 8.5-3.8 8.5-8.5 8.5" fill="none" ' . $s . '/>',

		// Leaf — Comprender (organic understanding / growth).
		'leaf' => '<path d="M15 33C15 22 21 15 33 15c0 11-6 18-18 18z" fill="none" ' . $s . '/>'
			. '<path d="M19 29c3-4 7-8 11-10" ' . $s . '/>',

		// Magnifying glass — Descubrir (discover patterns).
		'magnify' => '<circle cx="22" cy="22" r="9" fill="none" ' . $s . '/>'
			. '<path d="M28.5 28.5L36 36" ' . $s . '/>',

		// Ordered list — Ordenar (organize scattered ideas).
		'order' => '<path d="M18 16h18M18 24h12M18 32h16" ' . $s . '/>'
			. '<circle cx="13" cy="16" r="1.6" fill="currentColor" stroke="none"/>'
			. '<circle cx="13" cy="24" r="1.6" fill="currentColor" stroke="none"/>'
			. '<circle cx="13" cy="32" r="1.6" fill="currentColor" stroke="none"/>',

		// Compass — Orientarte / next step.
		'compass' => '<circle cx="24" cy="24" r="12" fill="none" ' . $s . '/>'
			. '<path d="M24 16l2.4 7.2L24 24l-2.4-.8L24 16z" fill="currentColor" stroke="none"/>'
			. '<path d="M24 32l-2.4-7.2L24 24l2.4.8L24 32z" fill="currentColor" opacity=".4" stroke="none"/>',

		// Calendar — schedule.
		'calendar' => '<rect x="11" y="13" width="26" height="24" rx="2.5" fill="none" ' . $s . '/>'
			. '<path d="M11 20h26" ' . $s . '/>'
			. '<path d="M18 9v6M30 9v6" ' . $s . '/>',

		// Speech bubble — deep conversation.
		'chat' => '<path d="M12 16h24a3 3 0 013 3v9a3 3 0 01-3 3H22l-6 5v-5h-4a3 3 0 01-3-3v-9a3 3 0 013-3z" fill="none" ' . $s . '/>'
			. '<path d="M18 22h12M18 27h8" ' . $s . ' opacity=".45"/>',

		// Head + location pin — explore your inner map.
		'map' => '<circle cx="24" cy="22" r="12" fill="none" ' . $s . '/>'
			. '<path d="M24 29c-2.4-3-3.8-4.9-3.8-7a3.8 3.8 0 017.6 0c0 2.1-1.4 4-3.8 7z" fill="none" ' . $s . '/>'
			. '<circle cx="24" cy="21.6" r="1.3" fill="currentColor" stroke="none"/>',

		// Target — leave with clarity and focus.
		'target' => '<circle cx="24" cy="24" r="12" fill="none" ' . $s . '/>'
			. '<circle cx="24" cy="24" r="6.5" fill="none" ' . $s . '/>'
			. '<circle cx="24" cy="24" r="2" fill="currentColor" stroke="none"/>',

		// Person bust — return to yourself.
		'self' => '<circle cx="24" cy="18" r="6" fill="none" ' . $s . '/>'
			. '<path d="M13 36c1.5-6.5 6-10 11-10s9.5 3.5 11 10" fill="none" ' . $s . '/>',

		// Sun emerging behind cloud — seeking clarity before a leap.
		'suncloud' => '<circle cx="30" cy="17" r="5" fill="none" ' . $s . '/>'
			. '<path d="M30 9.5v1.5M23 17h1.5M36.5 17H35M25.2 12.2l1 1M33.8 12.2l-1 1" ' . $s . ' opacity=".55"/>'
			. '<path d="M14 33h16a4.5 4.5 0 00.3-9A6 6 0 0019 22.6 4.2 4.2 0 0014 33z" fill="#fff" ' . $s . '/>',

		// Crossroads — at a fork, decide consciously.
		'crossroads' => '<path d="M24 37V27" ' . $s . '/>'
			. '<path d="M24 27L15 18" ' . $s . '/>'
			. '<path d="M24 27L33 18" ' . $s . '/>'
			. '<path d="M15 22v-4h4" fill="none" ' . $s . '/>'
			. '<path d="M33 22v-4h-4" fill="none" ' . $s . '/>',

		'check' => '<path d="M13 24l7 7 15-16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'cross' => '<path d="M15 15l18 18M33 15L15 33" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"/>',
		'arrow' => '<path d="M11 24h22M29 18l5 6-5 6" fill="none" ' . $s . '/>',
	);

	if ( ! isset( $icons[ $name ] ) || '' === $icons[ $name ] ) {
		return '';
	}

	$vb = in_array( $name, array( 'logo' ), true ) ? '0 0 24 24' : '0 0 48 48';

	return sprintf(
		'<svg class="%s" width="%d" height="%d" viewBox="%s" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">%s</svg>',
		esc_attr( $class ),
		$size,
		$size,
		esc_attr( $vb ),
		$icons[ $name ]
	);
}

/**
 * Large compass + labyrinth for insight section.
 */
function universare_brujula_compass_hero(): string {
	$uri = get_stylesheet_directory_uri() . '/assets/images/compass-labyrinth.svg';
	return sprintf(
		'<img class="bru-compass-hero" src="%s" alt="" width="320" height="320" loading="lazy" decoding="async">',
		esc_url( $uri )
	);
}
