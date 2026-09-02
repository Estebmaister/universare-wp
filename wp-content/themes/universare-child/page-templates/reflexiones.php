<?php
/**
 * Template Name: Reflexiones
 * Template Post Type: page
 *
 * Book reflections quoter — random quote from CSV.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

$quotes = universare_reflexiones_get_quotes();
$index  = universare_reflexiones_random_index( $quotes );
$quote  = $quotes[ $index ] ?? array(
	'phrase' => __( 'No hay reflexiones disponibles por el momento.', 'universare-child' ),
	'book'   => '',
	'author' => '',
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'reflexiones-body' ); ?>>
<?php wp_body_open(); ?>

<div class="reflexiones" id="reflexiones-page">
	<header class="reflexiones__header">
		<div class="reflexiones__header-inner">
			<a class="reflexiones__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php echo universare_brujula_icon( 'logo', array( 'size' => 40, 'class' => 'bru-icon--sm' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span>Universare</span>
			</a>
			<a class="reflexiones__back" href="<?php echo esc_url( home_url( '/landing/' ) ); ?>">
				<?php esc_html_e( 'Brújula', 'universare-child' ); ?>
			</a>
		</div>
	</header>

	<main class="reflexiones__main">
		<div class="reflexiones__card" id="reflexiones-box">
			<h1 class="reflexiones__title"><?php esc_html_e( 'Libros y reflexiones', 'universare-child' ); ?></h1>
			<p class="reflexiones__subtitle"><?php esc_html_e( 'Universare', 'universare-child' ); ?></p>

			<div class="reflexiones__quote-wrap">
				<p class="reflexiones__quote" id="reflexiones-quote"><?php echo esc_html( $quote['phrase'] ); ?></p>
			</div>
			<p class="reflexiones__attribution" id="reflexiones-attribution">
				<?php
				$attribution = universare_reflexiones_format_attribution( $quote );
				if ( '' !== $attribution ) {
					echo esc_html( $attribution );
				}
				?>
			</p>

			<div class="reflexiones__actions">
				<button type="button" class="reflexiones__btn reflexiones__btn--primary" id="reflexiones-new">
					<?php esc_html_e( 'Nueva reflexión', 'universare-child' ); ?>
				</button>
				<a
					class="reflexiones__btn reflexiones__btn--outline"
					id="reflexiones-whatsapp"
					href="<?php echo esc_url( universare_reflexiones_whatsapp_url( $quote ) ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					<?php esc_html_e( 'Compartir en WhatsApp', 'universare-child' ); ?>
				</a>
				<a
					class="reflexiones__btn reflexiones__btn--outline"
					id="reflexiones-twitter"
					href="<?php echo esc_url( universare_reflexiones_twitter_url( $quote ) ); ?>"
					target="_blank"
					rel="noopener noreferrer"
				>
					<?php esc_html_e( 'Compartir en X', 'universare-child' ); ?>
				</a>
			</div>
		</div>
	</main>
</div>

<?php wp_footer(); ?>
</body>
</html>
