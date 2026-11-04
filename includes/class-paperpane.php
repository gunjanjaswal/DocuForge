<?php
/**
 * Core plugin class: registers the block, the shortcode, and the shared renderer.
 *
 * @package Paperpane
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Paperpane {

	/**
	 * Singleton instance.
	 *
	 * @var Paperpane|null
	 */
	private static $instance = null;

	/**
	 * Boot the plugin (singleton).
	 *
	 * @return Paperpane
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Hook everything up.
	 */
	private function __construct() {
		add_action( 'init', array( $this, 'register' ) );
		add_shortcode( 'pp-pdf-embed', array( $this, 'render' ) );
		add_shortcode( 'paperpane', array( $this, 'render' ) );       // Alias.
		add_shortcode( 'docuforge', array( $this, 'render' ) );       // Back-compat alias (former name).
		add_shortcode( 'pdf-embed-forge', array( $this, 'render' ) ); // Back-compat alias (earlier name).
		add_shortcode( 'pdf-forge', array( $this, 'render' ) );       // Back-compat alias (original name).
		add_filter( 'plugin_row_meta', array( $this, 'row_meta' ), 10, 2 );
	}

	/**
	 * Register the editor assets and the block.
	 */
	public function register() {
		wp_register_style(
			'paperpane',
			PAPERPANE_URL . 'assets/css/paperpane.css',
			array(),
			PAPERPANE_VERSION
		);

		wp_register_script(
			'paperpane-editor',
			PAPERPANE_URL . 'assets/js/block.js',
			array( 'wp-blocks', 'wp-block-editor', 'wp-element', 'wp-components', 'wp-i18n' ),
			PAPERPANE_VERSION,
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'paperpane-editor', 'paperpane', PAPERPANE_DIR . 'languages' );
		}

		if ( function_exists( 'register_block_type' ) ) {
			register_block_type(
				PAPERPANE_DIR . 'block',
				array( 'render_callback' => array( $this, 'render_block' ) )
			);

			// Back-compat: render posts saved with a former block name without
			// showing it in the inserter. New posts use the paperpane/embed block.
			$legacy_attributes = array(
				'id'      => array(
					'type'    => 'number',
					'default' => 0,
				),
				'url'     => array(
					'type'    => 'string',
					'default' => '',
				),
				'height'  => array(
					'type'    => 'number',
					'default' => 600,
				),
				'toolbar' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'title'   => array(
					'type'    => 'string',
					'default' => '',
				),
			);

			foreach ( array( 'docuforge/embed', 'pdf-embed-forge/embed' ) as $legacy_block ) {
				if ( WP_Block_Type_Registry::get_instance()->is_registered( $legacy_block ) ) {
					continue;
				}
				register_block_type(
					$legacy_block,
					array(
						'api_version'     => 3,
						'render_callback' => array( $this, 'render_block' ),
						'supports'        => array( 'inserter' => false ),
						'attributes'      => $legacy_attributes,
					)
				);
			}
		}
	}

	/**
	 * Bridge the block attributes to the shared renderer.
	 *
	 * @param array $attributes Block attributes.
	 * @return string
	 */
	public function render_block( $attributes ) {
		// Carry the block's Wide/Full alignment onto the wrapper so the theme can break it out.
		$extra = '';
		if ( ! empty( $attributes['align'] ) ) {
			$extra = 'align' . sanitize_html_class( $attributes['align'] );
		}

		return $this->render(
			array(
				'id'      => isset( $attributes['id'] ) ? $attributes['id'] : 0,
				'url'     => isset( $attributes['url'] ) ? $attributes['url'] : '',
				'height'  => isset( $attributes['height'] ) ? $attributes['height'] : 600,
				'toolbar' => ( ! isset( $attributes['toolbar'] ) || $attributes['toolbar'] ) ? '1' : '0',
				'title'   => isset( $attributes['title'] ) ? $attributes['title'] : '',
			),
			$extra
		);
	}

	/**
	 * Render the PDF viewer. Shared by the block and the shortcodes.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public function render( $atts, $extra_class = '' ) {
		$a = shortcode_atts(
			array(
				'id'      => 0,
				'url'     => '',
				'height'  => 600,
				'toolbar' => '1',
				'title'   => '',
			),
			$atts,
			'pp-pdf-embed'
		);

		$url = $a['url'] ? $a['url'] : ( $a['id'] ? wp_get_attachment_url( (int) $a['id'] ) : '' );
		if ( ! $url ) {
			return '';
		}

		// Only embed things that are actually PDFs.
		$is_pdf = ( $a['id'] && 'application/pdf' === get_post_mime_type( (int) $a['id'] ) )
			|| preg_match( '/\.pdf($|[?#])/i', $url );
		if ( ! $is_pdf ) {
			return '';
		}

		wp_enqueue_style( 'paperpane' );

		$height = is_numeric( $a['height'] ) ? (int) $a['height'] . 'px' : preg_replace( '/[^0-9a-z%.]/i', '', (string) $a['height'] );
		if ( '' === $height ) {
			$height = '600px';
		}

		$toolbar = $this->is_on( $a['toolbar'] );

		// Open parameters for the built-in viewer: hide the thumbnail/pages sidebar and
		// fit the page to the viewer width. Chromium honours these; other browsers ignore them.
		$params = array( 'navpanes=0', 'view=FitH' );
		if ( ! $toolbar ) {
			$params[] = 'toolbar=0';
		}
		$src = $url . '#' . implode( '&', $params );

		$title = $a['title'];
		if ( ! $title && $a['id'] ) {
			$title = get_the_title( (int) $a['id'] );
		}
		if ( ! $title ) {
			$title = __( 'Embedded PDF', 'paperpane' );
		}

		$wrap_class = 'paperpane';
		if ( $extra_class ) {
			$wrap_class .= ' ' . $extra_class;
		}

		// First-page preview for the mobile card. WordPress generates this on upload
		// when the host has Imagick + Ghostscript; otherwise we fall back to an icon.
		$thumb = $a['id'] ? wp_get_attachment_image(
			(int) $a['id'],
			'large',
			false,
			array(
				'class'   => 'paperpane__thumb',
				'alt'     => '',
				'loading' => 'lazy',
			)
		) : '';

		ob_start();
		?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<div class="paperpane__frame-wrap" style="height:<?php echo esc_attr( $height ); ?>">
				<iframe class="paperpane__frame" src="<?php echo esc_url( $src ); ?>" title="<?php echo esc_attr( $title ); ?>" loading="lazy"></iframe>
			</div>
			<a class="paperpane__open" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
				<span class="paperpane__preview">
					<?php
					if ( $thumb ) {
						echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_get_attachment_image() returns safe markup.
					} else {
						?>
						<span class="paperpane__preview-fallback">
							<svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#e23b4e" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
						</span>
						<?php
					}
					?>
					<span class="paperpane__cta">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M8 3H5a2 2 0 0 0-2 2v3M21 8V5a2 2 0 0 0-2-2h-3M3 16v3a2 2 0 0 0 2 2h3M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
						<?php esc_html_e( 'View full screen', 'paperpane' ); ?>
					</span>
				</span>
				<span class="paperpane__open-title"><?php echo esc_html( $title ); ?></span>
			</a>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Add Ko-fi and contact links to the plugin's row on the Plugins screen.
	 *
	 * @param string[] $links Existing row meta links.
	 * @param string   $file  Plugin file the row is for.
	 * @return string[]
	 */
	public function row_meta( $links, $file ) {
		if ( plugin_basename( PAPERPANE_FILE ) !== $file ) {
			return $links;
		}

		$links[] = '<a href="' . esc_url( 'https://ko-fi.com/gunjanjaswal' ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support on Ko-fi', 'paperpane' ) . '</a>';
		$links[] = '<a href="' . esc_url( 'mailto:hello@gunjanjaswal.me' ) . '">' . esc_html__( 'Contact developer', 'paperpane' ) . '</a>';

		return $links;
	}

	/**
	 * Interpret a truthy attribute from a shortcode string or a block boolean.
	 *
	 * @param mixed $value Raw value.
	 * @return bool
	 */
	private function is_on( $value ) {
		if ( is_bool( $value ) ) {
			return $value;
		}
		$value = strtolower( trim( (string) $value ) );
		return ! in_array( $value, array( '0', 'false', 'no', 'off', '' ), true );
	}
}
