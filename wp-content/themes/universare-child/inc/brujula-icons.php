<?php
/**
 * Brújula landing SVG icons.
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
	$size  = isset( $args['size'] ) ? (int) $args['size'] : 48;
	$class = 'bru-icon' . ( ! empty( $args['class'] ) ? ' ' . esc_attr( $args['class'] ) : '' );

	$icons = array(
		'logo'        => '<circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="1.15"/><path d="M12 3.5l1.1 4.4L12 9.5l-1.1-1.6L12 3.5z" fill="currentColor"/><path d="M12 20.5l-1.1-4.4L12 14.5l1.1 1.6L12 20.5z" fill="currentColor" opacity=".5"/><path d="M3.5 12l4.4 1.1L9.5 12l-1.6-1.1L3.5 12z" fill="currentColor" opacity=".65"/><path d="M20.5 12l-4.4 1.1L14.5 12l1.6-1.1L20.5 12z" fill="currentColor" opacity=".65"/>',
		'scribble'    => '<path d="M8 20c6-10 10-8 16-14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M10 18c3-4 8-2 12-8" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" opacity=".7"/><path d="M14 16c2-2 5-1 8-4" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" opacity=".5"/>',
		'book'        => '<path d="M6 7h12v14H6z" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M6 7c0-1.5 2.5-2 6-2s6 .5 6 2" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M12 5v16" stroke="currentColor" stroke-width="1" opacity=".35"/>',
		'cloud'       => '<path d="M8 18h12a4 4 0 0 0 .5-8 5.5 5.5 0 0 0-10.6 1.8A3.5 3.5 0 0 0 8 18z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>',
		'spiral'      => '<path d="M24 14a6 6 0 0 0-6-6 4 4 0 0 0-4 4 3 3 0 0 0 3 3" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><path d="M24 22a10 10 0 0 0-10-10 7 7 0 0 0-7 7 5 5 0 0 0 5 5" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" opacity=".75"/>',
		'leaf'        => '<path d="M24 32S14 28 14 18c0-6 4-10 10-10s10 4 10 10c0 10-10 14-10 14z" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M18 20c4 2 6 6 6 10" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>',
		'mirror'      => '<ellipse cx="24" cy="20" rx="10" ry="14" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M24 34v8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><path d="M18 42h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
		'heart'       => '<path d="M24 34l-2.2-2C16 24 12 21 12 17a5 5 0 0 1 9-2.5A5 5 0 0 1 30 17c0 4-4 7-9.8 15L24 34z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>',
		'compass'     => '<circle cx="24" cy="24" r="14" fill="none" stroke="currentColor" stroke-width="1.3"/><path d="M24 10v28M10 24h28" stroke="currentColor" stroke-width=".8" opacity=".25"/><path d="M24 13l2.5 9.5L24 24l-2.5-1.5L24 13z" fill="currentColor"/><path d="M24 35l-2.5-9.5L24 24l2.5 1.5L24 35z" fill="currentColor" opacity=".45"/><text x="24" y="8" text-anchor="middle" font-size="5" fill="currentColor" font-family="Georgia,serif">N</text>',
		'calendar'    => '<rect x="8" y="10" width="32" height="28" rx="2" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M8 18h32" stroke="currentColor" stroke-width="1.4"/><path d="M16 6v8M32 6v8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><rect x="16" y="24" width="6" height="6" rx=".5" fill="currentColor" opacity=".35"/>',
		'chat'        => '<path d="M10 12h28a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4H22l-8 8v-8H10a4 4 0 0 1-4-4V16a4 4 0 0 1 4-4z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>',
		'user'        => '<circle cx="24" cy="16" r="6" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M10 40c2-8 8-12 14-12s12 4 14 12" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
		'pen'         => '<path d="M10 38l4-14 14-4 4 4-14 4-4 14-4-4z" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M28 10l6 6" stroke="currentColor" stroke-width="1.4"/>',
		'sprout'      => '<path d="M24 36V22" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><path d="M24 26c-6-4-10-2-12 2 4-1 8 0 12 4" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M24 22c6-6 12-4 14 0-6-1-10 2-14 6" fill="none" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>',
		'thought'     => '<ellipse cx="20" cy="22" rx="10" ry="8" fill="none" stroke="currentColor" stroke-width="1.4"/><ellipse cx="30" cy="30" rx="6" ry="5" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".7"/><ellipse cx="14" cy="32" rx="4" ry="3.5" fill="none" stroke="currentColor" stroke-width="1.1" opacity=".55"/>',
		'sun'         => '<circle cx="24" cy="24" r="7" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M24 8v4M24 36v4M8 24h4M36 24h4M13 13l3 3M32 32l3 3M35 13l-3 3M13 35l-3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>',
		'path'        => '<path d="M8 34c6-10 14-14 22-20 4-3 8-8 8-12" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><circle cx="30" cy="10" r="2.5" fill="currentColor"/><path d="M8 34l3-2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
		'check'       => '<path d="M8 24l8 8 16-16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>',
		'cross'       => '<path d="M10 10l28 28M38 10L10 38" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>',
		'arrow'       => '<path d="M8 24h28M28 16l8 8-8 8" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	$vb = in_array( $name, array( 'logo' ), true ) ? '0 0 24 24' : '0 0 48 48';

	return sprintf(
		'<svg class="%s" width="%d" height="%d" viewBox="%s" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">%s</svg>',
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
