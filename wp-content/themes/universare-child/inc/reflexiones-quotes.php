<?php
/**
 * Load book reflections from CSV for the /reflexiones quoter page.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Path to the reflections CSV data file.
 */
function universare_reflexiones_csv_path(): string {
	return get_stylesheet_directory() . '/data/libros-reflexiones.csv';
}

/**
 * Normalize a CSV cell value.
 *
 * @param string $value Raw cell value.
 */
function universare_reflexiones_normalize_cell( string $value ): string {
	$value = str_replace( array( "\r\n", "\r", "\n" ), ' ', $value );
	$value = preg_replace( '/\s+/u', ' ', $value );

	return trim( (string) $value );
}

/**
 * Parse reflections CSV into quote records.
 *
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_parse_csv( string $path ): array {
	if ( ! is_readable( $path ) ) {
		return array();
	}

	$handle = fopen( $path, 'rb' );
	if ( false === $handle ) {
		return array();
	}

	$header = fgetcsv( $handle );
	if ( ! is_array( $header ) ) {
		fclose( $handle );
		return array();
	}

	$header = array_map( 'universare_reflexiones_normalize_cell', $header );
	$quotes = array();

	while ( ( $row = fgetcsv( $handle ) ) !== false ) {
		if ( ! is_array( $row ) || count( $row ) < 3 ) {
			continue;
		}

		$phrase = universare_reflexiones_normalize_cell( (string) ( $row[0] ?? '' ) );
		$book   = universare_reflexiones_normalize_cell( (string) ( $row[1] ?? '' ) );
		$author = universare_reflexiones_normalize_cell( (string) ( $row[2] ?? '' ) );

		if ( '' === $phrase || ( '' === $book && '' === $author ) ) {
			continue;
		}

		$quotes[] = array(
			'phrase' => $phrase,
			'book'   => $book,
			'author' => $author,
		);
	}

	fclose( $handle );

	return $quotes;
}

/**
 * Get all reflections (cached by CSV mtime).
 *
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_get_quotes(): array {
	$path = universare_reflexiones_csv_path();
	if ( ! is_readable( $path ) ) {
		return array();
	}

	$mtime = (int) filemtime( $path );
	$key   = 'universare_reflexiones_quotes_' . $mtime;
	$cached = get_transient( $key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$quotes = universare_reflexiones_parse_csv( $path );
	set_transient( $key, $quotes, DAY_IN_SECONDS );

	return $quotes;
}

/**
 * Pick a random reflection index.
 *
 * @param array<int, array{phrase: string, book: string, author: string}> $quotes Quotes.
 * @param int|null                                                         $avoid  Index to skip.
 */
function universare_reflexiones_random_index( array $quotes, ?int $avoid = null ): int {
	$count = count( $quotes );
	if ( $count <= 0 ) {
		return 0;
	}

	if ( 1 === $count ) {
		return 0;
	}

	do {
		$index = wp_rand( 0, $count - 1 );
	} while ( null !== $avoid && $index === $avoid );

	return $index;
}

/**
 * Format attribution line for a quote.
 *
 * @param array{phrase: string, book: string, author: string} $quote Quote.
 */
function universare_reflexiones_format_attribution( array $quote ): string {
	if ( ! empty( $quote['book'] ) && ! empty( $quote['author'] ) ) {
		return $quote['book'] . ' — ' . $quote['author'];
	}

	if ( ! empty( $quote['book'] ) ) {
		return $quote['book'];
	}

	return $quote['author'] ?? '';
}

/**
 * Build share text for social links.
 *
 * @param array{phrase: string, book: string, author: string} $quote Quote.
 */
function universare_reflexiones_share_text( array $quote ): string {
	return '"' . $quote['phrase'] . '" — ' . universare_reflexiones_format_attribution( $quote );
}

/**
 * WhatsApp share URL for a quote.
 *
 * @param array{phrase: string, book: string, author: string} $quote Quote.
 */
function universare_reflexiones_whatsapp_url( array $quote ): string {
	return 'https://wa.me/?text=' . rawurlencode( universare_reflexiones_share_text( $quote ) );
}

/**
 * Instagram profile URL for Reflexiones footer actions.
 */
function universare_reflexiones_instagram_url(): string {
	return (string) apply_filters( 'universare_brujula_instagram_url', 'https://www.instagram.com/universare/' );
}
