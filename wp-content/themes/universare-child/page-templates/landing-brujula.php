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

$cta_url = apply_filters( 'universare_brujula_cta_url', '#agendar' );
$instagram_url = apply_filters( 'universare_brujula_instagram_url', 'https://www.instagram.com/universare/' );
$whatsapp_url  = apply_filters(
	'universare_brujula_whatsapp_url',
	'https://wa.me/573165137110?text=' . rawurlencode( 'Quiero encontrar mi brújula' )
);
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

<div class="bru-landing" id="brujula-landing">
	<header class="bru-header">
		<div class="bru-container bru-header__inner">
			<a class="bru-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php echo universare_brujula_icon( 'logo', array( 'size' => 40, 'class' => 'bru-icon--sm' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span>Brújula</span>
			</a>
			<nav class="bru-nav" id="bru-nav" aria-label="<? esc_attr_e( 'Navegación principal', 'universare-child' ); ?>">
				<a href="#inicio"><? esc_html_e( 'Inicio', 'universare-child' ); ?></a>
				<a href="#sobre"><? esc_html_e( 'Sobre la sesión', 'universare-child' ); ?></a>
				<a href="#como-funciona"><? esc_html_e( '¿Cómo funciona?', 'universare-child' ); ?></a>
				<a href="#para-quien"><? esc_html_e( 'Para quién', 'universare-child' ); ?></a>
			</nav>
			<a class="bru-btn" href="<?php echo esc_url( $cta_url ); ?>"><? esc_html_e( 'Agendar sesión', 'universare-child' ); ?></a>
			<button type="button" class="bru-menu-toggle" id="bru-menu-toggle" aria-expanded="false" aria-controls="bru-nav">
				<? esc_html_e( 'Menú', 'universare-child' ); ?>
			</button>
		</div>
	</header>

	<section class="bru-hero" id="inicio">
		<div class="bru-container bru-hero__content">
			<h1 class="bru-hero__title">
				<? esc_html_e( 'Cuando todo parece un caos, lo primero que necesitas es', 'universare-child' ); ?>
				<span class="bru-gold"><? esc_html_e( 'claridad', 'universare-child' ); ?></span>.
			</h1>
			<p class="bru-hero__text">
				<? esc_html_e( 'BRÚJULA es una sesión de claridad para comprender lo que estás viviendo, ordenar lo que sientes y encontrar un camino con sentido — sin presión, sin fórmulas mágicas.', 'universare-child' ); ?>
			</p>
			<a class="bru-btn" href="<?php echo esc_url( $cta_url ); ?>">
				<? esc_html_e( 'Agendar mi sesión Brújula', 'universare-child' ); ?> →
			</a>
		</div>
	</section>

	<section class="bru-section" id="sobre">
		<div class="bru-container">
			<h2 class="bru-section__title"><? esc_html_e( '¿Te sientes así últimamente?', 'universare-child' ); ?></h2>
			<div class="bru-grid bru-grid--4">
				<?php
				$feelings = array(
					'scatter'   => __( 'Tu mente no para y sientes que estás en muchos lugares a la vez.', 'universare-child' ),
					'book'      => __( 'Has leído, escuchado y probado cosas, pero nada parece encajar del todo.', 'universare-child' ),
					'cloud'     => __( 'Sabes que algo debe cambiar, pero no sabes por dónde empezar.', 'universare-child' ),
					'spiral'    => __( 'Te cuesta distinguir si es agotamiento, confusión o un llamado interior.', 'universare-child' ),
				);
				foreach ( $feelings as $icon => $text ) :
					?>
					<article class="bru-card">
						<div class="bru-icon-wrap" aria-hidden="true">
							<?php echo universare_brujula_icon( $icon, array( 'size' => 96, 'class' => 'bru-icon--lg' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<p class="bru-card__text"><?php echo esc_html( $text ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bru-section bru-section--beige bru-insight">
		<div class="bru-container">
			<h2 class="bru-section__title">
				<span class="bru-insight__title-line"><? esc_html_e( 'A veces el problema no es la crisis.', 'universare-child' ); ?></span>
				<span class="bru-insight__title-line bru-insight__title-line--accent"><? esc_html_e( 'Es intentar resolverla sin comprender lo que realmente ocurre.', 'universare-child' ); ?></span>
			</h2>
			<div class="bru-compass-wrap">
				<?php echo universare_brujula_compass_hero(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<div class="bru-vs">
				<div class="bru-vs__col">
					<h3><? esc_html_e( 'Lo que solemos hacer', 'universare-child' ); ?></h3>
					<ul class="bru-vs__list">
						<?php
						$avoid = array(
							__( 'Buscar más información', 'universare-child' ),
							__( 'Escuchar otro podcast', 'universare-child' ),
							__( 'Forzarnos a decidir ya', 'universare-child' ),
							__( 'Compararnos con otros', 'universare-child' ),
						);
						foreach ( $avoid as $item ) :
							?>
							<li>
								<span class="bru-vs__mark bru-vs__mark--no">
									<?php echo universare_brujula_icon( 'cross', array( 'size' => 24 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
								<?php echo esc_html( $item ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="bru-vs__center">
					<span class="bru-vs__badge">VS</span>
				</div>
				<div class="bru-vs__col">
					<h3><? esc_html_e( 'Lo que realmente necesitamos', 'universare-child' ); ?></h3>
					<ul class="bru-vs__list">
						<?php
						$need = array(
							__( 'Comprender qué está pasando', 'universare-child' ),
							__( 'Ordenar lo que sentimos', 'universare-child' ),
							__( 'Observar con honestidad', 'universare-child' ),
							__( 'Elegir un primer paso posible', 'universare-child' ),
						);
						foreach ( $need as $item ) :
							?>
							<li>
								<span class="bru-vs__mark bru-vs__mark--yes">
									<?php echo universare_brujula_icon( 'check', array( 'size' => 28 ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
								<?php echo esc_html( $item ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="bru-section">
		<div class="bru-container bru-work">
			<div class="bru-work__visual">
				<div
					class="bru-work__visual-inner"
					aria-hidden="true"
					style="background-image: url('<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/compass-maze.png' ); ?>');"
				></div>
			</div>
			<div class="bru-work__content">
				<h2 class="bru-section__title bru-section__title--left">
					<? esc_html_e( 'En tu Sesión BRÚJULA vamos a trabajar en:', 'universare-child' ); ?>
				</h2>
				<div class="bru-grid bru-grid--4">
					<?php
					$pillars = array(
						'leaf'    => array( __( 'Comprender', 'universare-child' ), __( 'Lo que estás viviendo y qué te está moviendo por dentro.', 'universare-child' ) ),
						'magnify' => array( __( 'Descubrir', 'universare-child' ), __( 'Patrones, creencias y emociones que influyen en tu presente.', 'universare-child' ) ),
						'order'   => array( __( 'Ordenar', 'universare-child' ), __( 'Ideas dispersas para ver con más perspectiva.', 'universare-child' ) ),
						'compass' => array( __( 'Orientarte', 'universare-child' ), __( 'Hacia un siguiente paso claro y sostenible.', 'universare-child' ) ),
					);
					foreach ( $pillars as $icon => $data ) :
						?>
						<article class="bru-card bru-pillar">
							<div class="bru-icon-wrap" aria-hidden="true">
								<?php echo universare_brujula_icon( $icon, array( 'size' => 88, 'class' => 'bru-icon--md' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							<h3 class="bru-card__title"><?php echo esc_html( $data[0] ); ?></h3>
							<p class="bru-card__text"><?php echo esc_html( $data[1] ); ?></p>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="bru-section bru-section--beige bru-quote-band">
		<div class="bru-container">
			<p><? esc_html_e( 'No necesitas tener hoy todas las respuestas. Solo necesitas empezar por la pregunta correcta.', 'universare-child' ); ?></p>
			<a class="bru-btn" href="<?php echo esc_url( $cta_url ); ?>"><? esc_html_e( 'Agendar mi sesión Brújula', 'universare-child' ); ?> →</a>
		</div>
	</section>

	<section class="bru-section" id="como-funciona">
		<div class="bru-container">
			<h2 class="bru-section__title"><? esc_html_e( '¿Cómo funciona?', 'universare-child' ); ?></h2>
			<div class="bru-steps">
				<?php
				$steps = array(
					array( '1', 'calendar', __( 'Agenda tu sesión', 'universare-child' ) ),
					array( '2', 'chat', __( 'Conversamos en profundidad', 'universare-child' ) ),
					array( '3', 'map', __( 'Exploramos tu mapa interior', 'universare-child' ) ),
					array( '4', 'target', __( 'Sales con claridad y foco', 'universare-child' ) ),
				);
				foreach ( $steps as $step ) :
					?>
					<div class="bru-step">
						<div class="bru-step__num"><?php echo esc_html( $step[0] ); ?></div>
						<div class="bru-step__icon" aria-hidden="true">
							<?php echo universare_brujula_icon( $step[1], array( 'size' => 80, 'class' => 'bru-icon--md' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<p class="bru-step__label"><?php echo esc_html( $step[2] ); ?></p>
						<span class="bru-step__arrow" aria-hidden="true">
							<?php echo universare_brujula_icon( 'arrow', array( 'size' => 48, 'class' => 'bru-icon--sm' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bru-section bru-section--beige bru-section--cards" id="para-quien">
		<div class="bru-container">
			<h2 class="bru-section__title"><? esc_html_e( 'Esta sesión es para ti si hoy sientes que…', 'universare-child' ); ?></h2>
			<div class="bru-grid bru-grid--4">
				<?php
				$for_you = array(
					'self'       => __( 'Has perdido el norte y necesitas volver a ti.', 'universare-child' ),
					'overthink'  => __( 'Piensas demasiado y actúas poco (o al revés).', 'universare-child' ),
					'suncloud'   => __( 'Buscas claridad antes de dar un gran salto.', 'universare-child' ),
					'crossroads' => __( 'Estás en una encrucijada y quieres decidir con conciencia.', 'universare-child' ),
				);
				foreach ( $for_you as $icon => $text ) :
					?>
					<article class="bru-card">
						<div class="bru-icon-wrap" aria-hidden="true">
							<?php echo universare_brujula_icon( $icon, array( 'size' => 96, 'class' => 'bru-icon--lg' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<p class="bru-card__text"><?php echo esc_html( $text ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="bru-final-cta" id="agendar">
		<div class="bru-container bru-final-cta__inner">
			<h2><? esc_html_e( 'Tu crisis no tiene por qué definirte. Puede convertirse en el comienzo de una comprensión más profunda.', 'universare-child' ); ?></h2>
			<a class="bru-btn" href="<?php echo esc_url( $cta_url ); ?>"><? esc_html_e( 'Agendar mi sesión Brújula', 'universare-child' ); ?> →</a>
		</div>
	</section>

	<footer class="bru-footer">
		<div class="bru-container bru-footer__inner">
			<a class="bru-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php echo universare_brujula_icon( 'logo', array( 'size' => 40, 'class' => 'bru-icon--sm' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span>Brújula</span>
			</a>
			<p>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Brújula · <? esc_html_e( 'Universare', 'universare-child' ); ?></p>
			<div class="bru-social">
				<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">IG</a>
				<a href="<?php echo esc_url( $whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">WA</a>
			</div>
		</div>
	</footer>
</div>

<script>
document.getElementById('bru-menu-toggle')?.addEventListener('click', function () {
	const nav = document.getElementById('bru-nav');
	const open = nav.classList.toggle('is-open');
	this.setAttribute('aria-expanded', open ? 'true' : 'false');
});
</script>

<?php wp_footer(); ?>
</body>
</html>
