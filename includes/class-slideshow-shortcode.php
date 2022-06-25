<?php
/**
 * SLIDESHOW_SHORTCODE class for create custom slideshow shortcode.
 *
 * @package customss
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SLIDESHOW_SHORTCODE - create a custom shortocodes.
 */
class SLIDESHOW_SHORTCODE {

	/**
	 * SLIDESHOW_SHORTCODE - instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * SLIDESHOW_SHORTCODE - constructor.
	 */
	public function __construct() {
		$this->hooks(); // register hooks to make the settings do things.
	}

	/**
	 * Add all the hook inside the this private method.
	 */
	private function hooks() {

		// Enqueue scripts for the shortcode page.
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_custom_slideshow_shortcode_scripts' ) );

		// Add shortcode to display custom slideshow.
		add_shortcode( 'myslideshow', array( $this, 'wp_custom_slideshow_shortcode_callback' ) );

	}


	/**
	 * Enqueue the scripts if the custom slideshow shortcode is being used
	 */
	public function wp_custom_slideshow_shortcode_scripts() {
		global $post;
		if ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'myslideshow' ) ) ) {

			wp_enqueue_style( 'slick-css', CUSTOMSS_URL . 'assets/css/slick.css', array(), '1.8.0' );
			wp_enqueue_style( 'slick-theme-css', CUSTOMSS_URL . 'assets/css/slick-theme.css', array(), '1.8.0' );
			wp_enqueue_script( 'slick-js', CUSTOMSS_URL . 'assets/js/slick.js', array( 'jquery' ), '1.8.0', false );

			wp_enqueue_style( 'customss-frontend-style', CUSTOMSS_URL . 'assets/css/slideshow-frontend-style.css', array(), '1.0' );

			wp_enqueue_script( 'customss-frontend-script', CUSTOMSS_URL . 'assets/js/slideshow-frontend-script.js', array( 'jquery', 'wp-util' ), false, true );

		}
	}


	/**
	 * Renders the HTML for custom slideshow section.
	 */
	public function wp_custom_slideshow_shortcode_callback() {

		ob_start();
		require_once CUSTOMSS_PATH . 'includes/templates/slideshow_content.php';
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

}

/**
 * Get SLIDESHOW_SHORTCODE running.
 */
$SLIDESHOW_SHORTCODE = new SLIDESHOW_SHORTCODE();
