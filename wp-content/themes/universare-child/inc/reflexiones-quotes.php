<?php
/**
 * Load book reflections from Google Drive or local CSV for /reflexiones.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Path to the reflections CSV fallback file.
 */
function universare_reflexiones_csv_path(): string {
	return get_stylesheet_directory() . '/data/libros-reflexiones.csv';
}

/**
 * Google Sheet / Drive CSV export URL (filter in universare-bootstrap.php).
 */
function universare_reflexiones_drive_csv_url(): string {
	return (string) apply_filters( 'universare_reflexiones_drive_csv_url', '' );
}

/**
 * Normalize a Google Sheets or Drive share URL to a CSV download URL.
 *
 * @param string $url Sheet edit link, export link, or Drive file link.
 */
function universare_reflexiones_normalize_drive_url( string $url ): string {
	$url = trim( $url );

	if ( preg_match( '#docs\.google\.com/spreadsheets/d/([a-zA-Z0-9_-]+)#', $url, $matches ) ) {
		$sheet_id = $matches[1];
		$gid      = '0';

		if ( preg_match( '~[?&#]gid=(\d+)~', $url, $gid_match ) ) {
			$gid = $gid_match[1];
		}

		return sprintf(
			'https://docs.google.com/spreadsheets/d/%s/export?format=csv&gid=%s',
			$sheet_id,
			$gid
		);
	}

	if ( preg_match( '#drive\.google\.com/file/d/([a-zA-Z0-9_-]+)#', $url, $matches ) ) {
		return 'https://drive.google.com/uc?export=download&id=' . $matches[1];
	}

	return $url;
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
 * Parse reflections from an open CSV handle.
 *
 * @param resource $handle CSV file handle.
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_parse_csv_handle( $handle ): array {
	$header = fgetcsv( $handle );
	if ( ! is_array( $header ) ) {
		return array();
	}

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

	return $quotes;
}

/**
 * Parse reflections CSV string into quote records.
 *
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_parse_csv_string( string $csv ): array {
	if ( '' === trim( $csv ) ) {
		return array();
	}

	$handle = fopen( 'php://memory', 'rb+' );
	if ( false === $handle ) {
		return array();
	}

	fwrite( $handle, $csv );
	rewind( $handle );

	$quotes = universare_reflexiones_parse_csv_handle( $handle );
	fclose( $handle );

	return $quotes;
}

/**
 * Parse reflections CSV file into quote records.
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

	$quotes = universare_reflexiones_parse_csv_handle( $handle );
	fclose( $handle );

	return $quotes;
}

/**
 * Fetch CSV body from Google Drive / Sheets.
 *
 * @return string|false CSV body or false on failure.
 */
function universare_reflexiones_fetch_drive_csv() {
	$url = universare_reflexiones_drive_csv_url();
	if ( '' === $url ) {
		return false;
	}

	$response = wp_remote_get(
		universare_reflexiones_normalize_drive_url( $url ),
		array(
			'timeout'     => 15,
			'redirection' => 5,
			'headers'     => array(
				'Accept' => 'text/csv,text/plain,*/*',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return false;
	}

	if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		return false;
	}

	$body = (string) wp_remote_retrieve_body( $response );
	$trim = ltrim( $body );

	if ( '' === $trim || '<' === $trim[0] ) {
		return false;
	}

	return $body;
}

/**
 * Store parsed quotes in WordPress transients.
 *
 * @param array<int, array{phrase: string, book: string, author: string}> $quotes Quotes.
 */
function universare_reflexiones_cache_quotes( array $quotes ): void {
	if ( empty( $quotes ) ) {
		return;
	}

	set_transient( 'universare_reflexiones_quotes', $quotes, DAY_IN_SECONDS );
	set_transient( 'universare_reflexiones_quotes_stale', $quotes, MONTH_IN_SECONDS );
}

/**
 * Load quotes from the bundled CSV fallback file.
 *
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_get_local_quotes(): array {
	$path = universare_reflexiones_csv_path();
	if ( ! is_readable( $path ) ) {
		return array();
	}

	$mtime  = (int) filemtime( $path );
	$key    = 'universare_reflexiones_local_' . $mtime;
	$cached = get_transient( $key );

	if ( is_array( $cached ) ) {
		return $cached;
	}

	$quotes = universare_reflexiones_parse_csv( $path );
	set_transient( $key, $quotes, DAY_IN_SECONDS );

	return $quotes;
}

/**
 * Refresh quotes from Google Drive and update cache.
 *
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_refresh_from_drive(): array {
	$csv = universare_reflexiones_fetch_drive_csv();
	if ( false === $csv ) {
		$cached = get_transient( 'universare_reflexiones_quotes' );
		if ( is_array( $cached ) && ! empty( $cached ) ) {
			return $cached;
		}

		$stale = get_transient( 'universare_reflexiones_quotes_stale' );
		if ( is_array( $stale ) && ! empty( $stale ) ) {
			return $stale;
		}

		return universare_reflexiones_get_local_quotes();
	}

	$quotes = universare_reflexiones_parse_csv_string( $csv );
	if ( empty( $quotes ) ) {
		$cached = get_transient( 'universare_reflexiones_quotes_stale' );
		if ( is_array( $cached ) && ! empty( $cached ) ) {
			return $cached;
		}

		return universare_reflexiones_get_local_quotes();
	}

	universare_reflexiones_cache_quotes( $quotes );

	return $quotes;
}

/**
 * Get all reflections.
 *
 * When $refresh_from_drive is true and a Drive URL is configured, fetches the
 * sheet on each /reflexiones page load and updates the transient cache.
 *
 * @param bool $refresh_from_drive Fetch from Google Drive when true.
 * @return array<int, array{phrase: string, book: string, author: string}>
 */
function universare_reflexiones_get_quotes( bool $refresh_from_drive = false ): array {
	if ( $refresh_from_drive && '' !== universare_reflexiones_drive_csv_url() ) {
		return universare_reflexiones_refresh_from_drive();
	}

	$cached = get_transient( 'universare_reflexiones_quotes' );
	if ( is_array( $cached ) && ! empty( $cached ) ) {
		return $cached;
	}

	return universare_reflexiones_get_local_quotes();
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
