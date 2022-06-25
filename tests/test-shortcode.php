<?php
/**
 * Class TestShortcode
 *
 * @package Custom_Slideshow
 */

/**
 * Sample test case.
 */
class TestShortcode extends WP_UnitTestCase {

	protected $shortcode;

    /**
    * Setup method for create object for all test cases
    */
    public function setUp()
    {
        parent::setUp();
        $this->shortcode = new SLIDESHOW_SHORTCODE();
    }

	/**
	 * Check wp_enqueue_scripts hook is registered or not.
	 */
	public function test_wp_enqueue_scripts() {
		$is_registered = has_action( 'wp_enqueue_scripts', [ $this->shortcode, 'wp_custom_slideshow_shortcode_scripts' ] );

		$is_registered = ( 10 === $is_registered );

		$this->assertTrue( $is_registered );
	}
}
