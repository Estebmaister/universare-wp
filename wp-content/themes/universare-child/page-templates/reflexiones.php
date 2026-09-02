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

$instagram_url = universare_reflexiones_instagram_url();
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

			<div class="reflexiones__content">
				<div class="reflexiones__quote-wrap">
					<p class="reflexiones__quote" id="reflexiones-quote"></p>
				</div>
				<p class="reflexiones__attribution" id="reflexiones-attribution"></p>
			</div>

			<div class="reflexiones__actions">
				<button type="button" class="reflexiones__btn reflexiones__btn--primary" id="reflexiones-new">
					<?php esc_html_e( 'Nueva reflexión', 'universare-child' ); ?>
				</button>
				<a
					class="reflexiones__btn reflexiones__btn--whatsapp"
					id="reflexiones-whatsapp"
					href="#"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php esc_attr_e( 'Compartir en WhatsApp', 'universare-child' ); ?>"
				>
					<svg class="reflexiones__btn-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
					</svg>
					<span class="reflexiones__btn-tooltip" role="tooltip"><?php esc_html_e( 'Compartir en WhatsApp', 'universare-child' ); ?></span>
				</a>
				<a
					class="reflexiones__btn reflexiones__btn--instagram"
					id="reflexiones-instagram"
					href="<?php echo esc_url( $instagram_url ); ?>"
					target="_blank"
					rel="noopener noreferrer"
					aria-label="<?php esc_attr_e( 'Visítame en Instagram', 'universare-child' ); ?>"
				>
					<svg class="reflexiones__btn-icon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
						<rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" stroke-width="2"/>
						<circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/>
						<circle cx="17.5" cy="6.5" r="1.25" fill="currentColor" stroke="none"/>
					</svg>
					<span class="reflexiones__btn-tooltip" role="tooltip"><?php esc_html_e( 'Visítame en Instagram', 'universare-child' ); ?></span>
				</a>
			</div>
		</div>
	</main>
</div>

<?php wp_footer(); ?>
</body>
</html>
