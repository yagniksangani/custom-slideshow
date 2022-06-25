<?php
/**
 * Plugin Name: Custom Slideshow
 * Plugin URI: https://github.com/yagniksangani/custom-slideshow
 * Description: A plugin is used to add the custom slideshow section via shortcode.
 * Version: 1.0.0
 * Requires at least: 4.4
 * Requires PHP: 5.6.20
 * Author: Yagnik Sangani
 * Author URI: https://github.com/yagniksangani
 * Text Domain: customss
 * License: GPL v2 or later
 * Tested up to: 6.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 *
 * @package customss
 */

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Class Custom_Slideshow_Init.
 */
class Custom_Slideshow_Init {

	/**
	 * Construct function.
	 */
	public function __construct() {

		define( 'CUSTOMSS_URL', plugin_dir_url( __FILE__ ) );
		define( 'CUSTOMSS_PATH', plugin_dir_path( __FILE__ ) );
		define( 'CUSTOMSS_ROOT', dirname( plugin_basename( __FILE__ ) ) );
		define( 'CUSTOMSS_PLUGIN', plugin_basename( __FILE__ ) );
		define( 'CUSTOMSS_BASE_FILE', __FILE__ );

		/* Use init hook to load up required files */
		add_action( 'init', array( $this, 'required_files' ), 10 );

		/* Load languages files */
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}


	/**
	 * Include additional files as needed
	 */
	public function required_files() {
		/* Load up our files */
		require_once CUSTOMSS_PATH . 'includes/class-slideshow-admin-settings.php';
		require_once CUSTOMSS_PATH . 'includes/class-slideshow-shortcode.php';
	}


	/**
	 * Load the plugin text domain for translation.
	 *
	 * With the introduction of plugins language packs in WordPress loading the textdomain is slightly more complex.
	 *
	 * We now have 3 steps:
	 *
	 * 1. Check for the language pack in the WordPress core directory
	 * 2. Check for the translation file in the plugin's language directory
	 * 3. Fallback to loading the textdomain the classic way
	 *
	 * @since    1.0.0
	 * @return boolean True if the language file was loaded, false otherwise
	 */
	public function load_plugin_textdomain() {

		$lang_dir       = trailingslashit( CUSTOMSS_ROOT ) . 'languages/';
		$lang_path      = trailingslashit( CUSTOMSS_PATH ) . 'languages/';
		$locale         = apply_filters( 'plugin_locale', get_locale(), 'customss' );
		$mofile         = "customss-$locale.mo";
		$glotpress_file = WP_LANG_DIR . '/plugins/customss/' . $mofile;

		// Look for the GlotPress language pack first of all.
		if ( file_exists( $glotpress_file ) ) {
			$language = load_textdomain( 'customss', $glotpress_file );
		} elseif ( file_exists( $lang_path . $mofile ) ) {
			$language = load_textdomain( 'customss', $lang_path . $mofile );
		} else {
			$language = load_plugin_textdomain( 'customss', false, $lang_dir );
		}

		return $language;

	}

}

/**
 * Get Custom_Slideshow_Init running.
 */
$Custom_Slideshow_Init = new Custom_Slideshow_Init();
