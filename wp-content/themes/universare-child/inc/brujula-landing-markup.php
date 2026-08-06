<?php
/**
 * Brújula landing HTML sections — shared by PHP template and Elementor import.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Landing context (URLs, slug).
 *
 * @param array $overrides Optional overrides.
 */
function universare_brujula_landing_context( array $overrides = array() ): array {
	$slug = $overrides['slug'] ?? apply_filters( 'universare_brujula_landing_slug', 'landing' );

	$cta_url = $overrides['cta_url'] ?? apply_filters( 'universare_brujula_cta_url', '#agendar' );
	if ( '#agendar' === $cta_url ) {
		$cta_url = home_url( '/' . trim( $slug, '/' ) . '/#agendar' );
	}

	return array(
		'slug'            => $slug,
		'cta_url'         => $cta_url,
		'instagram_url'   => $overrides['instagram_url'] ?? apply_filters( 'universare_brujula_instagram_url', 'https://www.instagram.com/universare/' ),
		'whatsapp_url'    => $overrides['whatsapp_url'] ?? apply_filters(
			'universare_brujula_whatsapp_url',
			'https://wa.me/573165137110?text=' . rawurlencode( 'Quiero encontrar mi brújula' )
		),
		'price'           => $overrides['price'] ?? apply_filters( 'universare_brujula_price', '$390.000 COP' ),
		'price_label'     => $overrides['price_label'] ?? apply_filters(
			'universare_brujula_price_label',
			__( 'Valor individual', 'universare-child' )
		),
		'elementor_shell' => ! empty( $overrides['elementor_shell'] ),
	);
}

/**
 * Render full Brújula landing markup.
 *
 * @param array $context Optional context overrides.
 */
function universare_brujula_render_landing( array $context = array() ): string {
	$ctx     = universare_brujula_landing_context( $context );
	$sections = universare_brujula_landing_sections();

	$html  = '<div class="bru-landing" id="brujula-landing">';
	$html .= universare_brujula_render_landing_section( 'header', $ctx );
	foreach ( array_keys( $sections ) as $slug ) {
		if ( 'header' === $slug || 'footer' === $slug ) {
			continue;
		}
		$html .= universare_brujula_render_landing_section( $slug, $ctx );
	}
	$html .= universare_brujula_render_landing_section( 'footer', $ctx );
	$html .= universare_brujula_render_landing_menu_script();
	$html .= '</div>';

	return $html;
}

/**
 * Section slugs in render order.
 */
function universare_brujula_landing_sections(): array {
	return array(
		'header'     => 'universare_brujula_section_header',
		'hero'       => 'universare_brujula_section_hero',
		'feelings'   => 'universare_brujula_section_feelings',
		'insight'    => 'universare_brujula_section_insight',
		'work'       => 'universare_brujula_section_work',
		'quote'      => 'universare_brujula_section_quote',
		'steps'      => 'universare_brujula_section_steps',
		'para_quien' => 'universare_brujula_section_para_quien',
		'pricing'    => 'universare_brujula_section_pricing',
		'final_cta'  => 'universare_brujula_section_final_cta',
		'footer'     => 'universare_brujula_section_footer',
	);
}

/**
 * Render one landing section.
 *
 * @param string $slug    Section slug.
 * @param array  $context Landing context.
 */
function universare_brujula_render_landing_section( string $slug, array $context = array() ): string {
	$sections = universare_brujula_landing_sections();
	if ( ! isset( $sections[ $slug ] ) || ! is_callable( $sections[ $slug ] ) ) {
		return '';
	}

	ob_start();
	call_user_func( $sections[ $slug ], $context );
	return (string) ob_get_clean();
}

/**
 * Mobile nav toggle script.
 */
function universare_brujula_render_landing_menu_script(): string {
	return <<<'HTML'
<script>
document.getElementById('bru-menu-toggle')?.addEventListener('click', function () {
	const nav = document.getElementById('bru-nav');
	const open = nav.classList.toggle('is-open');
	this.setAttribute('aria-expanded', open ? 'true' : 'false');
});
</script>
HTML;
}

/**
 * Header section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_header( array $ctx ): void {
	$cta_url = $ctx['cta_url'];
	$shell   = ! empty( $ctx['elementor_shell'] );
	if ( ! $shell ) {
		echo '<header class="bru-header">';
	}
	?>
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
	<?php
	if ( ! $shell ) {
		echo '</header>';
	}
}

/**
 * Hero section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_hero( array $ctx ): void {
	$cta_url = $ctx['cta_url'];
	?>
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
	<?php
}

/**
 * Feelings section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_feelings( array $ctx ): void {
	unset( $ctx );
	$feelings = array(
		'scatter' => __( 'Tu mente no para y sientes que estás en muchos lugares a la vez.', 'universare-child' ),
		'book'    => __( 'Has leído, escuchado y probado cosas, pero nada parece encajar del todo.', 'universare-child' ),
		'cloud'   => __( 'Sabes que algo debe cambiar, pero no sabes por dónde empezar.', 'universare-child' ),
		'spiral'  => __( 'Te cuesta distinguir si es agotamiento, confusión o un llamado interior.', 'universare-child' ),
	);
	?>
	<section class="bru-section" id="sobre">
		<div class="bru-container">
			<h2 class="bru-section__title"><? esc_html_e( '¿Te sientes así últimamente?', 'universare-child' ); ?></h2>
			<div class="bru-grid bru-grid--4">
				<?php foreach ( $feelings as $icon => $text ) : ?>
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
	<?php
}

/**
 * Insight + VS section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_insight( array $ctx ): void {
	unset( $ctx );
	$avoid = array(
		__( 'Buscar más información', 'universare-child' ),
		__( 'Escuchar otro podcast', 'universare-child' ),
		__( 'Forzarnos a decidir ya', 'universare-child' ),
		__( 'Compararnos con otros', 'universare-child' ),
	);
	$need = array(
		__( 'Comprender qué está pasando', 'universare-child' ),
		__( 'Ordenar lo que sentimos', 'universare-child' ),
		__( 'Observar con honestidad', 'universare-child' ),
		__( 'Elegir un primer paso posible', 'universare-child' ),
	);
	?>
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
						<?php foreach ( $avoid as $item ) : ?>
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
						<?php foreach ( $need as $item ) : ?>
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
	<?php
}

/**
 * Work / pillars section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_work( array $ctx ): void {
	unset( $ctx );
	$pillars = array(
		'leaf'    => array( __( 'Comprender', 'universare-child' ), __( 'Lo que estás viviendo y qué te está moviendo por dentro.', 'universare-child' ) ),
		'magnify' => array( __( 'Descubrir', 'universare-child' ), __( 'Patrones, creencias y emociones que influyen en tu presente.', 'universare-child' ) ),
		'order'   => array( __( 'Ordenar', 'universare-child' ), __( 'Ideas dispersas para ver con más perspectiva.', 'universare-child' ) ),
		'compass' => array( __( 'Orientarte', 'universare-child' ), __( 'Hacia un siguiente paso claro y sostenible.', 'universare-child' ) ),
	);
	$maze_url = get_stylesheet_directory_uri() . '/assets/images/compass-maze.png';
	?>
	<section class="bru-section">
		<div class="bru-container bru-work">
			<div class="bru-work__visual">
				<div
					class="bru-work__visual-inner"
					aria-hidden="true"
					style="background-image: url('<?php echo esc_url( $maze_url ); ?>');"
				></div>
			</div>
			<div class="bru-work__content">
				<h2 class="bru-section__title bru-section__title--left">
					<? esc_html_e( 'En tu Sesión BRÚJULA vamos a trabajar en:', 'universare-child' ); ?>
				</h2>
				<div class="bru-grid bru-grid--4">
					<?php foreach ( $pillars as $icon => $data ) : ?>
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
	<?php
}

/**
 * Quote band section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_quote( array $ctx ): void {
	$cta_url = $ctx['cta_url'];
	?>
	<section class="bru-section bru-section--beige bru-quote-band">
		<div class="bru-container">
			<p><? esc_html_e( 'No necesitas tener hoy todas las respuestas. Solo necesitas empezar por la pregunta correcta.', 'universare-child' ); ?></p>
			<a class="bru-btn" href="<?php echo esc_url( $cta_url ); ?>"><? esc_html_e( 'Agendar mi sesión Brújula', 'universare-child' ); ?> →</a>
		</div>
	</section>
	<?php
}

/**
 * Steps section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_steps( array $ctx ): void {
	unset( $ctx );
	$steps = array(
		array( '1', 'calendar', __( 'Agenda tu sesión', 'universare-child' ) ),
		array( '2', 'chat', __( 'Conversamos en profundidad', 'universare-child' ) ),
		array( '3', 'map', __( 'Exploramos tu mapa interior', 'universare-child' ) ),
		array( '4', 'target', __( 'Sales con claridad y foco', 'universare-child' ) ),
	);
	?>
	<section class="bru-section" id="como-funciona">
		<div class="bru-container">
			<h2 class="bru-section__title"><? esc_html_e( '¿Cómo funciona?', 'universare-child' ); ?></h2>
			<div class="bru-steps">
				<?php foreach ( $steps as $step ) : ?>
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
	<?php
}

/**
 * Para quién section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_para_quien( array $ctx ): void {
	unset( $ctx );
	$for_you = array(
		'self'       => __( 'Has perdido el norte y necesitas volver a ti.', 'universare-child' ),
		'overthink'  => __( 'Piensas demasiado y actúas poco (o al revés).', 'universare-child' ),
		'suncloud'   => __( 'Buscas claridad antes de dar un gran salto.', 'universare-child' ),
		'crossroads' => __( 'Estás en una encrucijada y quieres decidir con conciencia.', 'universare-child' ),
	);
	?>
	<section class="bru-section bru-section--beige bru-section--cards" id="para-quien">
		<div class="bru-container">
			<h2 class="bru-section__title"><? esc_html_e( 'Esta sesión es para ti si hoy sientes que…', 'universare-child' ); ?></h2>
			<div class="bru-grid bru-grid--4">
				<?php foreach ( $for_you as $icon => $text ) : ?>
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
	<?php
}

/**
 * Pricing section deliverables (session scope only).
 */
function universare_brujula_pricing_includes(): array {
	return array(
		__( 'Sesión 1:1 de 90 minutos', 'universare-child' ),
		__( 'Diagnóstico profundo de tu situación', 'universare-child' ),
		__( 'Mapa personalizado de claridad', 'universare-child' ),
		__( 'Plan de acción concreto', 'universare-child' ),
		__( 'Ejercicio de integración post-sesión', 'universare-child' ),
		__( 'Recursos personalizados', 'universare-child' ),
		__( 'Acompañamiento por WhatsApp (7 días)', 'universare-child' ),
	);
}

/**
 * HTML list of pricing deliverables.
 */
function universare_brujula_pricing_includes_html(): string {
	$html = '<ul class="bru-pricing__list">';
	foreach ( universare_brujula_pricing_includes() as $item ) {
		$html .= '<li><span class="bru-pricing__check" aria-hidden="true">'
			. universare_brujula_icon( 'check', array( 'size' => 20, 'class' => 'bru-icon--xs' ) )
			. '</span><span>' . esc_html( $item ) . '</span></li>';
	}
	$html .= '</ul>';

	return $html;
}

/**
 * Pricing / investment section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_pricing( array $ctx ): void {
	$cta_url = $ctx['cta_url'];
	?>
	<section class="bru-section bru-pricing" id="inversion">
		<div class="bru-container">
			<div class="bru-pricing__layout">
				<div class="bru-pricing__includes">
					<h2 class="bru-pricing__title"><? esc_html_e( 'Todo esto incluido', 'universare-child' ); ?></h2>
					<?php echo universare_brujula_pricing_includes_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<aside class="bru-pricing__card">
					<p class="bru-pricing__label"><?php echo esc_html( $ctx['price_label'] ); ?></p>
					<p class="bru-pricing__amount"><?php echo esc_html( $ctx['price'] ); ?></p>
					<a class="bru-btn bru-pricing__cta" href="<?php echo esc_url( $cta_url ); ?>">
						<? esc_html_e( 'Agendar mi sesión', 'universare-child' ); ?>
					</a>
					<p class="bru-pricing__secure">
						<?php echo universare_brujula_icon( 'lock', array( 'size' => 16, 'class' => 'bru-icon--xs' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span><? esc_html_e( 'Pago 100% seguro', 'universare-child' ); ?></span>
					</p>
				</aside>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Final CTA section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_final_cta( array $ctx ): void {
	$cta_url = $ctx['cta_url'];
	?>
	<section class="bru-final-cta" id="agendar">
		<div class="bru-container bru-final-cta__inner">
			<h2><? esc_html_e( 'Tu crisis no tiene por qué definirte. Puede convertirse en el comienzo de una comprensión más profunda.', 'universare-child' ); ?></h2>
			<a class="bru-btn" href="<?php echo esc_url( $cta_url ); ?>"><? esc_html_e( 'Agendar mi sesión Brújula', 'universare-child' ); ?> →</a>
		</div>
	</section>
	<?php
}

/**
 * Footer section.
 *
 * @param array $ctx Context.
 */
function universare_brujula_section_footer( array $ctx ): void {
	$instagram_url = $ctx['instagram_url'];
	$whatsapp_url  = $ctx['whatsapp_url'];
	$shell         = ! empty( $ctx['elementor_shell'] );
	if ( ! $shell ) {
		echo '<footer class="bru-footer">';
	}
	?>
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
	<?php
	if ( ! $shell ) {
		echo '</footer>';
	}
}

/**
 * Register Brújula landing shortcodes (Elementor HTML widgets can re-sync from theme).
 */
function universare_brujula_register_shortcodes(): void {
	add_shortcode(
		'universare_brujula_landing',
		static function () {
			return universare_brujula_render_landing( array( 'slug' => 'landing-brujula' ) );
		}
	);

	foreach ( array_keys( universare_brujula_landing_sections() ) as $slug ) {
		add_shortcode(
			'universare_brujula_' . $slug,
			static function () use ( $slug ) {
				$html = universare_brujula_render_landing_section( $slug, universare_brujula_landing_context( array( 'slug' => 'landing-brujula' ) ) );
				if ( 'header' === $slug ) {
					return '<div class="bru-landing" id="brujula-landing">' . $html;
				}
				if ( 'footer' === $slug ) {
					return $html . universare_brujula_render_landing_menu_script() . '</div>';
				}
				return $html;
			}
		);
	}
}
add_action( 'init', 'universare_brujula_register_shortcodes' );
