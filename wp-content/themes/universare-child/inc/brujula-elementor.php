<?php
/**
 * Build and sync Brújula landing Elementor page at /landing-brujula.
 *
 * @package Universare_Child
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether a page is the Brújula Elementor landing.
 *
 * @param int|null $post_id Post ID.
 */
function universare_brujula_is_elementor_landing( ?int $post_id = null ): bool {
	if ( null === $post_id || 0 === $post_id ) {
		if ( is_admin() && ! empty( $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$post_id = (int) $_GET['post']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		} else {
			$post_id = get_queried_object_id();
		}
	}

	if ( ! $post_id ) {
		return false;
	}

	$page = get_post( $post_id );
	if ( ! $page instanceof WP_Post || 'page' !== $page->post_type ) {
		return false;
	}

	return 'landing-brujula' === $page->post_name;
}

/**
 * Stable Elementor element id from seed.
 *
 * @param string $seed Seed string.
 */
function universare_brujula_elementor_id( string $seed ): string {
	return substr( md5( 'bru-' . $seed ), 0, 7 );
}

/**
 * Zero spacing box settings for sections/columns.
 */
function universare_brujula_elementor_zero_box(): array {
	return array(
		'padding' => array(
			'unit'     => 'px',
			'top'      => '0',
			'right'    => '0',
			'bottom'   => '0',
			'left'     => '0',
			'isLinked' => true,
		),
		'margin'  => array(
			'unit'     => 'px',
			'top'      => '0',
			'right'    => '0',
			'bottom'   => '0',
			'left'     => '0',
			'isLinked' => true,
		),
	);
}

/**
 * Build Elementor section settings.
 *
 * @param string $css_class  CSS classes.
 * @param string $element_id HTML id attribute.
 * @param bool   $inner      Inner section flag.
 * @param string $title      Navigator label in Elementor.
 */
function universare_brujula_elementor_section_settings( string $css_class = '', string $element_id = '', bool $inner = false, string $title = '' ): array {
	$settings = array_merge(
		array(
			'layout' => 'full_width',
			'gap'    => 'no',
		),
		universare_brujula_elementor_zero_box()
	);

	if ( '' !== $css_class ) {
		$settings['css_classes'] = $css_class;
	}
	if ( '' !== $element_id ) {
		$settings['_element_id'] = $element_id;
	}
	if ( '' !== $title ) {
		$settings['_title'] = $title;
	}

	return $settings;
}

/**
 * Build an Elementor column.
 *
 * @param string $seed       Seed.
 * @param array  $widgets    Child widgets.
 * @param int    $size       Column width percent.
 * @param string $css_class  CSS classes.
 * @param bool   $inner      Inner column flag.
 */
function universare_brujula_elementor_column( string $seed, array $widgets, int $size = 100, string $css_class = '', bool $inner = false ): array {
	$settings = array(
		'_column_size' => $size,
		'_inline_size' => null,
	);
	if ( '' !== $css_class ) {
		$settings['css_classes'] = $css_class;
	}

	return array(
		'id'       => universare_brujula_elementor_id( 'col-' . $seed ),
		'elType'   => 'column',
		'settings' => $settings,
		'elements' => $widgets,
		'isInner'  => $inner,
	);
}

/**
 * Build an Elementor section node.
 *
 * @param string $seed      Seed.
 * @param array  $columns   Column nodes.
 * @param string $css_class CSS classes.
 * @param string $element_id HTML id.
 * @param bool   $inner     Inner section.
 * @param string $title     Navigator label in Elementor.
 */
function universare_brujula_elementor_section( string $seed, array $columns, string $css_class = '', string $element_id = '', bool $inner = false, string $title = '' ): array {
	return array(
		'id'       => universare_brujula_elementor_id( 'sec-' . $seed ),
		'elType'   => 'section',
		'settings' => universare_brujula_elementor_section_settings( $css_class, $element_id, $inner, $title ),
		'elements' => $columns,
		'isInner'  => $inner,
	);
}

/**
 * Heading widget.
 *
 * @param string $seed        Seed.
 * @param string $title       Title HTML.
 * @param string $header_size h1-h6.
 * @param string $css_class   Widget CSS class.
 */
function universare_brujula_elementor_heading( string $seed, string $title, string $header_size = 'h2', string $css_class = '' ): array {
	$settings = array(
		'title'       => $title,
		'header_size' => $header_size,
	);
	if ( '' !== $css_class ) {
		$settings['_css_classes'] = $css_class;
	}

	return array(
		'id'         => universare_brujula_elementor_id( 'hdg-' . $seed ),
		'elType'     => 'widget',
		'widgetType' => 'heading',
		'settings'   => $settings,
		'elements'   => array(),
	);
}

/**
 * Text editor widget.
 *
 * @param string $seed      Seed.
 * @param string $content   HTML content.
 * @param string $css_class Widget CSS class.
 */
function universare_brujula_elementor_text( string $seed, string $content, string $css_class = '' ): array {
	$settings = array(
		'editor' => $content,
	);
	if ( '' !== $css_class ) {
		$settings['_css_classes'] = $css_class;
	}

	return array(
		'id'         => universare_brujula_elementor_id( 'txt-' . $seed ),
		'elType'     => 'widget',
		'widgetType' => 'text-editor',
		'settings'   => $settings,
		'elements'   => array(),
	);
}

/**
 * Button widget.
 *
 * @param string $seed      Seed.
 * @param string $text      Button label.
 * @param string $url       Button URL.
 * @param string $css_class Widget CSS class.
 */
function universare_brujula_elementor_button( string $seed, string $text, string $url, string $css_class = 'bru-btn' ): array {
	return array(
		'id'         => universare_brujula_elementor_id( 'btn-' . $seed ),
		'elType'     => 'widget',
		'widgetType' => 'button',
		'settings'   => array(
			'text'         => $text,
			'link'         => array(
				'url'         => $url,
				'is_external' => '',
				'nofollow'    => '',
			),
			'size'         => 'sm',
			'_css_classes' => $css_class,
		),
		'elements'   => array(),
	);
}

/**
 * HTML widget.
 *
 * @param string $seed Seed.
 * @param string $html HTML content.
 */
function universare_brujula_elementor_html( string $seed, string $html ): array {
	return array(
		'id'         => universare_brujula_elementor_id( 'htm-' . $seed ),
		'elType'     => 'widget',
		'widgetType' => 'html',
		'settings'   => array(
			'html' => $html,
		),
		'elements'   => array(),
	);
}

/**
 * Icon markup wrapped for cards/steps.
 *
 * @param string $icon  Icon slug.
 * @param string $class Icon size class.
 */
function universare_brujula_elementor_icon_html( string $icon, string $class = 'bru-icon--lg' ): string {
	return '<div class="bru-icon-wrap" aria-hidden="true">'
		. universare_brujula_icon( $icon, array( 'class' => $class ) )
		. '</div>';
}

/**
 * Build a grid of icon cards with editable text widgets.
 *
 * @param string $seed       Seed prefix.
 * @param array  $items      icon => text pairs.
 * @param string $card_class Extra card class.
 * @param string $grid_title Navigator label for the inner grid section.
 */
function universare_brujula_elementor_icon_card_grid( string $seed, array $items, string $card_class = 'bru-card', string $grid_title = '' ): array {
	$columns = array();
	$i       = 0;
	foreach ( $items as $icon => $text ) {
		$columns[] = universare_brujula_elementor_column(
			$seed . '-card-' . $i,
			array(
				universare_brujula_elementor_html( $seed . '-icon-' . $i, universare_brujula_elementor_icon_html( (string) $icon ) ),
				universare_brujula_elementor_text( $seed . '-text-' . $i, '<p>' . esc_html( $text ) . '</p>', 'bru-card__text' ),
			),
			25,
			$card_class,
			true
		);
		++$i;
	}

	return array(
		universare_brujula_elementor_section( $seed . '-grid', $columns, 'bru-grid bru-grid--4', '', true, $grid_title ),
	);
}

/**
 * Insight section body (compass + VS lists) without the title.
 */
function universare_brujula_elementor_insight_body_html( array $ctx ): string {
	$full   = universare_brujula_render_landing_section( 'insight', $ctx );
	$marker = '<div class="bru-compass-wrap">';
	$pos    = strpos( $full, $marker );
	if ( false === $pos ) {
		return $full;
	}

	return substr( $full, $pos );
}

/**
 * Build Elementor document data with native editable widgets.
 */
function universare_brujula_build_elementor_data(): array {
	$ctx  = universare_brujula_landing_context(
		array(
			'slug'            => 'landing-brujula',
			'elementor_shell' => true,
		)
	);
	$cta  = $ctx['cta_url'];
	$data = array();

	$data[] = universare_brujula_elementor_section(
		'header',
		array(
			universare_brujula_elementor_column(
				'header',
				array(
					universare_brujula_elementor_html(
						'header',
						universare_brujula_render_landing_section( 'header', $ctx )
					),
				)
			),
		),
		'bru-header',
		'',
		false,
		'Header'
	);

	$data[] = universare_brujula_elementor_section(
		'hero',
		array(
			universare_brujula_elementor_column(
				'hero',
				array(
					universare_brujula_elementor_heading(
						'hero-title',
						__( 'Cuando todo parece un caos, lo primero que necesitas es', 'universare-child' ) . ' <span class="bru-gold">' . __( 'claridad', 'universare-child' ) . '</span>.',
						'h1',
						'bru-hero__title'
					),
					universare_brujula_elementor_text(
						'hero-text',
						'<p>' . esc_html__( 'BRÚJULA es una sesión de claridad para comprender lo que estás viviendo, ordenar lo que sientes y encontrar un camino con sentido — sin presión, sin fórmulas mágicas.', 'universare-child' ) . '</p>',
						'bru-hero__text'
					),
					universare_brujula_elementor_button(
						'hero-cta',
						__( 'Agendar mi sesión Brújula', 'universare-child' ) . ' →',
						$cta
					),
				),
				100,
				'bru-container bru-hero__content'
			),
		),
		'bru-hero',
		'inicio',
		false,
		'Hero'
	);

	$feelings = array(
		'scatter' => __( 'Tu mente no para y sientes que estás en muchos lugares a la vez.', 'universare-child' ),
		'book'    => __( 'Has leído, escuchado y probado cosas, pero nada parece encajar del todo.', 'universare-child' ),
		'cloud'   => __( 'Sabes que algo debe cambiar, pero no sabes por dónde empezar.', 'universare-child' ),
		'spiral'  => __( 'Te cuesta distinguir si es agotamiento, confusión o un llamado interior.', 'universare-child' ),
	);
	$data[]   = universare_brujula_elementor_section(
		'feelings',
		array(
			universare_brujula_elementor_column(
				'feelings',
				array_merge(
					array(
						universare_brujula_elementor_heading(
							'feelings-title',
							__( '¿Te sientes así últimamente?', 'universare-child' ),
							'h2',
							'bru-section__title'
						),
					),
					universare_brujula_elementor_icon_card_grid( 'feelings', $feelings, 'bru-card', 'Tarjetas — sentimientos' )
				),
				100,
				'bru-container'
			),
		),
		'bru-section',
		'sobre',
		false,
		'¿Te sientes así?'
	);

	$data[] = universare_brujula_elementor_section(
		'insight',
		array(
			universare_brujula_elementor_column(
				'insight',
				array(
					universare_brujula_elementor_heading(
						'insight-title',
						'<span class="bru-insight__title-line">' . esc_html__( 'A veces el problema no es la crisis.', 'universare-child' ) . '</span>'
						. '<span class="bru-insight__title-line bru-insight__title-line--accent">' . esc_html__( 'Es intentar resolverla sin comprender lo que realmente ocurre.', 'universare-child' ) . '</span>',
						'h2',
						'bru-insight__title'
					),
					universare_brujula_elementor_html(
						'insight-body',
						universare_brujula_elementor_insight_body_html( $ctx )
					),
				),
				100,
				'bru-container'
			),
		),
		'bru-section bru-section--beige bru-insight',
		'',
		false,
		'Insight + Brújula VS'
	);

	$pillars = array(
		'leaf'    => array( __( 'Comprender', 'universare-child' ), __( 'Lo que estás viviendo y qué te está moviendo por dentro.', 'universare-child' ) ),
		'magnify' => array( __( 'Descubrir', 'universare-child' ), __( 'Patrones, creencias y emociones que influyen en tu presente.', 'universare-child' ) ),
		'order'   => array( __( 'Ordenar', 'universare-child' ), __( 'Ideas dispersas para ver con más perspectiva.', 'universare-child' ) ),
		'compass' => array( __( 'Orientarte', 'universare-child' ), __( 'Hacia un siguiente paso claro y sostenible.', 'universare-child' ) ),
	);
	$maze_url        = get_stylesheet_directory_uri() . '/assets/images/compass-maze.png';
	$pillar_columns  = array();
	$i               = 0;
	foreach ( $pillars as $icon => $pillar ) {
		$pillar_columns[] = universare_brujula_elementor_column(
			'pillar-' . $i,
			array(
				universare_brujula_elementor_html( 'pillar-icon-' . $i, universare_brujula_elementor_icon_html( (string) $icon, 'bru-icon--md' ) ),
				universare_brujula_elementor_heading( 'pillar-title-' . $i, $pillar[0], 'h3', 'bru-card__title' ),
				universare_brujula_elementor_text( 'pillar-text-' . $i, '<p>' . esc_html( $pillar[1] ) . '</p>', 'bru-card__text' ),
			),
			25,
			'bru-card bru-pillar',
			true
		);
		++$i;
	}

	$data[] = universare_brujula_elementor_section(
		'work',
		array(
			universare_brujula_elementor_column(
				'work',
				array(
					universare_brujula_elementor_section(
						'work-inner',
						array(
							universare_brujula_elementor_column(
								'work-visual',
								array(
									universare_brujula_elementor_html(
										'work-visual',
										'<div class="bru-work__visual"><div class="bru-work__visual-inner" aria-hidden="true" style="background-image:url(\''
										. esc_url( $maze_url ) . '\');"></div></div>'
									),
								),
								50,
								'bru-work__visual-col',
								true
							),
							universare_brujula_elementor_column(
								'work-content',
								array(
									universare_brujula_elementor_heading(
										'work-title',
										__( 'En tu Sesión BRÚJULA vamos a trabajar en:', 'universare-child' ),
										'h2',
										'bru-section__title bru-section__title--left'
									),
									universare_brujula_elementor_section( 'work-grid', $pillar_columns, 'bru-grid bru-grid--4', '', true, 'Pilares de sesión' ),
								),
								50,
								'bru-work__content',
								true
							),
						),
						'bru-work',
						'',
						true,
						'Layout work'
					),
				),
				100,
				'bru-container'
			),
		),
		'bru-section',
		'',
		false,
		'Vamos a trabajar en'
	);

	$data[] = universare_brujula_elementor_section(
		'quote',
		array(
			universare_brujula_elementor_column(
				'quote',
				array(
					universare_brujula_elementor_text(
						'quote-text',
						'<p>' . esc_html__( 'No necesitas tener hoy todas las respuestas. Solo necesitas empezar por la pregunta correcta.', 'universare-child' ) . '</p>',
						'bru-quote-band__text'
					),
					universare_brujula_elementor_button(
						'quote-cta',
						__( 'Agendar mi sesión Brújula', 'universare-child' ) . ' →',
						$cta
					),
				),
				100,
				'bru-container'
			),
		),
		'bru-section bru-section--beige bru-quote-band',
		'',
		false,
		'Franja cita'
	);

	$steps = array(
		array( '1', 'calendar', __( 'Agenda tu sesión', 'universare-child' ) ),
		array( '2', 'chat', __( 'Conversamos en profundidad', 'universare-child' ) ),
		array( '3', 'map', __( 'Exploramos tu mapa interior', 'universare-child' ) ),
		array( '4', 'target', __( 'Sales con claridad y foco', 'universare-child' ) ),
	);
	$step_columns = array();
	$i            = 0;
	foreach ( $steps as $step ) {
		$step_columns[] = universare_brujula_elementor_column(
			'step-' . $i,
			array(
				universare_brujula_elementor_html(
					'step-chrome-' . $i,
					'<div class="bru-step">'
					. '<div class="bru-step__num">' . esc_html( $step[0] ) . '</div>'
					. '<div class="bru-step__icon" aria-hidden="true">' . universare_brujula_icon( $step[1], array( 'class' => 'bru-icon--md' ) ) . '</div>'
				),
				universare_brujula_elementor_text(
					'step-label-' . $i,
					'<p>' . esc_html( $step[2] ) . '</p>',
					'bru-step__label'
				),
				universare_brujula_elementor_html(
					'step-arrow-' . $i,
					'<span class="bru-step__arrow" aria-hidden="true">' . universare_brujula_icon( 'arrow', array( 'class' => 'bru-icon--sm' ) ) . '</span></div>'
				),
			),
			25,
			'bru-step-col',
			true
		);
		++$i;
	}

	$data[] = universare_brujula_elementor_section(
		'steps',
		array(
			universare_brujula_elementor_column(
				'steps',
				array(
					universare_brujula_elementor_heading(
						'steps-title',
						__( '¿Cómo funciona?', 'universare-child' ),
						'h2',
						'bru-section__title'
					),
					universare_brujula_elementor_section( 'steps-grid', $step_columns, 'bru-steps', '', true, 'Pasos' ),
				),
				100,
				'bru-container'
			),
		),
		'bru-section',
		'como-funciona',
		false,
		'¿Cómo funciona?'
	);

	$for_you = array(
		'self'       => __( 'Has perdido el norte y necesitas volver a ti.', 'universare-child' ),
		'overthink'  => __( 'Piensas demasiado y actúas poco (o al revés).', 'universare-child' ),
		'suncloud'   => __( 'Buscas claridad antes de dar un gran salto.', 'universare-child' ),
		'crossroads' => __( 'Estás en una encrucijada y quieres decidir con conciencia.', 'universare-child' ),
	);
	$data[]  = universare_brujula_elementor_section(
		'para-quien',
		array(
			universare_brujula_elementor_column(
				'para-quien',
				array_merge(
					array(
						universare_brujula_elementor_heading(
							'para-quien-title',
							__( 'Esta sesión es para ti si hoy sientes que…', 'universare-child' ),
							'h2',
							'bru-section__title'
						),
					),
					universare_brujula_elementor_icon_card_grid( 'para-quien', $for_you, 'bru-card', 'Tarjetas — para quién' )
				),
				100,
				'bru-container'
			),
		),
		'bru-section bru-section--beige bru-section--cards',
		'para-quien',
		false,
		'Para quién'
	);

	$data[] = universare_brujula_elementor_section(
		'pricing',
		array(
			universare_brujula_elementor_column(
				'pricing',
				array(
					universare_brujula_elementor_section(
						'pricing-layout',
						array(
							universare_brujula_elementor_column(
								'pricing-includes',
								array(
									universare_brujula_elementor_heading(
										'pricing-title',
										__( 'Todo esto incluido', 'universare-child' ),
										'h2',
										'bru-pricing__title'
									),
									universare_brujula_elementor_html(
										'pricing-list',
										universare_brujula_pricing_includes_html()
									),
								),
								50,
								'bru-pricing__includes',
								true
							),
							universare_brujula_elementor_column(
								'pricing-card',
								array(
									universare_brujula_elementor_heading(
										'pricing-label',
										$ctx['price_label'],
										'h3',
										'bru-pricing__label'
									),
									universare_brujula_elementor_heading(
										'pricing-amount',
										$ctx['price'],
										'h2',
										'bru-pricing__amount'
									),
									universare_brujula_elementor_button(
										'pricing-cta',
										__( 'Agendar mi sesión', 'universare-child' ),
										$cta,
										'bru-btn bru-pricing__cta'
									),
									universare_brujula_elementor_html(
										'pricing-secure',
										'<p class="bru-pricing__secure">'
										. universare_brujula_icon( 'lock', array( 'size' => 16, 'class' => 'bru-icon--xs' ) )
										. '<span>' . esc_html__( 'Pago 100% seguro', 'universare-child' ) . '</span></p>'
									),
								),
								50,
								'bru-pricing__card-col',
								true
							),
						),
						'bru-pricing__layout',
						'',
						true,
						'Layout inversión'
					),
				),
				100,
				'bru-container'
			),
		),
		'bru-section bru-pricing',
		'inversion',
		false,
		'Inversión'
	);

	$data[] = universare_brujula_elementor_section(
		'final-cta',
		array(
			universare_brujula_elementor_column(
				'final-cta',
				array(
					universare_brujula_elementor_heading(
						'final-cta-title',
						__( 'Tu crisis no tiene por qué definirte. Puede convertirse en el comienzo de una comprensión más profunda.', 'universare-child' ),
						'h2',
						'bru-final-cta__title'
					),
					universare_brujula_elementor_button(
						'final-cta-btn',
						__( 'Agendar mi sesión Brújula', 'universare-child' ) . ' →',
						$cta,
						'bru-btn bru-btn--light'
					),
				),
				100,
				'bru-container bru-final-cta__inner'
			),
		),
		'bru-final-cta',
		'agendar',
		false,
		'CTA final'
	);

	$data[] = universare_brujula_elementor_section(
		'footer',
		array(
			universare_brujula_elementor_column(
				'footer',
				array(
					universare_brujula_elementor_html(
						'footer',
						universare_brujula_render_landing_section( 'footer', $ctx )
					),
				)
			),
		),
		'bru-footer',
		'',
		false,
		'Footer'
	);

	return $data;
}

/**
 * Sync Elementor meta onto the Brújula Elementor landing page.
 *
 * @param int  $page_id Page ID.
 * @param bool $force   Overwrite existing Elementor data.
 */
function universare_brujula_sync_elementor_page( int $page_id, bool $force = false ): bool {
	if ( ! $force && get_post_meta( $page_id, '_elementor_data', true ) ) {
		return false;
	}

	$data = universare_brujula_build_elementor_data();
	if ( empty( $data ) ) {
		return false;
	}

	$elementor_version = defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '4.2.1';

	update_post_meta( $page_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $page_id, '_elementor_template_type', 'wp-page' );
	update_post_meta( $page_id, '_elementor_version', $elementor_version );
	update_post_meta( $page_id, '_wp_page_template', 'elementor_canvas' );
	update_post_meta( $page_id, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
	update_post_meta( $page_id, '_elementor_page_settings', array() );

	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	update_option(
		'universare_brujula_elementor_kit_version',
		wp_get_theme()->get( 'Version' ),
		false
	);

	return true;
}

/**
 * Re-import Brújula sections into Elementor.
 *
 * @param bool $force Force overwrite.
 */
function universare_brujula_resync_elementor_landing( bool $force = true ): bool {
	$page = get_page_by_path( 'landing-brujula', OBJECT, 'page' );
	if ( ! $page instanceof WP_Post ) {
		return false;
	}

	return universare_brujula_sync_elementor_page( (int) $page->ID, $force );
}
