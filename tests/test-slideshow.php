<?php
/**
 * Class TestSlideShow
 *
 * @package Custom_Slideshow
 */

/**
 * Sample test case.
 */
class TestSlideShow extends WP_UnitTestCase {

	protected $slideshowsettings;

    /**
    * Setup method for create object for all test cases
    */
    public function setUp()
    {
        parent::setUp();
        $this->slideshowsettings = new SLIDESHOW_ADMIN_SETTINGS();
    }

	/**
	 * Check admin_enqueue_scripts hook is registered or not.
	 */
	public function test_admin_enqueue_scripts() {
		$is_registered = has_action( 'admin_enqueue_scripts', [ $this->slideshowsettings, 'wp_custom_slideshow_enqueue_scripts_backend' ] );

		$is_registered = ( 10 === $is_registered );

		$this->assertTrue( $is_registered );
	}

	/**
	 * Check admin_menu hook is registered or not.
	 */
	public function test_admin_menu() {
		$is_registered = has_action( 'admin_menu', [ $this->slideshowsettings, 'wp_custom_slideshow_add_plugin_page' ] );
		
		$is_registered = ( 10 === $is_registered );

		$this->assertTrue( $is_registered );
	}

	/**
	 * Check admin_init hook is registered or not.
	 */
	public function test_admin_init() {
		$is_registered = has_action( 'admin_init', [ $this->slideshowsettings, 'wp_custom_slideshow_settings_page_init' ] );
		
		$is_registered = ( 10 === $is_registered );

		$this->assertTrue( $is_registered );
	}
}
