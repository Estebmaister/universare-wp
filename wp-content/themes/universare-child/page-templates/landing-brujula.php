<?php
/**
 * Template Name: Brújula Landing
 * Template Post Type: page
 *
 * Standalone landing for BRÚJULA: Sesión de Claridad.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'bru-landing-body' ); ?>>
<?php wp_body_open(); ?>

<?php echo universare_brujula_render_landing( array( 'slug' => 'landing' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

<?php wp_footer(); ?>
</body>
</html>
