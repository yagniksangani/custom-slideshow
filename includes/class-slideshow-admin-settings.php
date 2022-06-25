<?php
/**
 * SLIDESHOW_ADMIN_SETTINGS class for slideshow settings functionality.
 *
 * @package customss
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SLIDESHOW_ADMIN_SETTINGS class for slideshow settings.
 */
class SLIDESHOW_ADMIN_SETTINGS {

	/**
	 * Holds the values to be used in the fields callbacks.
	 *
	 * @var options.
	 */
	private $options;

	/**
	 * SLIDESHOW_ADMIN_SETTINGS - instance.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * SLIDESHOW_ADMIN_SETTINGS - constructor.
	 */
	public function __construct() {
		$this->hooks(); // register hooks to make settings do things.
	}


	/**
	 * Add all the hook inside the this private method.
	 */
	private function hooks() {

		// Enqueue scripts - backend.
		add_action( 'admin_enqueue_scripts', array( $this, 'wp_custom_slideshow_enqueue_scripts_backend' ) );

		// Creating an settings page.
		add_action( 'admin_menu', array( $this, 'wp_custom_slideshow_add_plugin_page' ) );

		// Register a settings for a plugin.
		add_action( 'admin_init', array( $this, 'wp_custom_slideshow_settings_page_init' ) );

	}


	/**
	 * Enqueue the scripts for backend.
	 */
	public function wp_custom_slideshow_enqueue_scripts_backend( $hook ) {

		if ( 'toplevel_page_wp-custom-slideshow-option' === $hook ) {

			// This will enqueue the Media Uploader script.
			wp_enqueue_media();
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_script( 'media-upload' );

			wp_enqueue_style( 'jquery-ui-style', CUSTOMSS_URL . 'assets/css/jquery-ui.css', array(), '1.0' );

			wp_enqueue_script( 'jquery-ui-script', CUSTOMSS_URL . 'assets/js/jquery-ui.js', array( 'jquery', 'wp-util' ), false, true );

			wp_enqueue_style( 'customss-backend-style', CUSTOMSS_URL . 'assets/css/slideshow-backend-style.css', array(), '1.0' );

			wp_enqueue_script( 'customss-backend-script', CUSTOMSS_URL . 'assets/js/slideshow-backend-script.js', array( 'jquery', 'wp-util' ), false, true );
		}

	}


	/**
	 * Add settings page.
	 */
	public function wp_custom_slideshow_add_plugin_page() {
		add_menu_page(
			'Custom Slideshow',
			'Custom Slideshow',
			'manage_options',
			'wp-custom-slideshow-option',
			array( $this, 'wp_custom_slideshow_create_admin_page' ),
			null,
			99
		);
	}


	/**
	 * Settings page callback.
	 */
	public function wp_custom_slideshow_create_admin_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( __( 'Custom SlideShow Settings', 'customss' ) ); ?></h1>
			<h2><?php echo esc_html( __( 'Use the shortcode [myslideshow] to add to the page.', 'customss' ) ); ?></h2>
			<h4><?php echo esc_html( __( 'NOTE: You can the change the order of slides by drag & drop.', 'customss' ) ); ?></h4>
			<form method="post" action="options.php">
			<?php
				// This prints out all hidden setting fields.
				settings_fields( 'section' );
				do_settings_sections( 'customss-options' );
				submit_button();
			?>
			</form>
		</div>
		<?php
	}


	/**
	 * Register and add settings.
	 */
	public function wp_custom_slideshow_settings_page_init() {
		add_settings_section( 'section', '', null, 'customss-options' );

		// Images Upload.
		add_settings_field( 'wp_customss_images_upload', __( 'Add Slides', 'customss' ), array( $this, 'wp_customss_display_images_upload_fields' ), 'customss-options', 'section' );
		register_setting( 'section', 'wp_customss_images_upload' );
	}


	/**
	 * Callback function used for display image upload fields.
	 */
	public function wp_customss_display_images_upload_fields() {

		$customss_images = get_option( 'wp_customss_images_upload' );

		?>

		<div id="dynamic_form">
			<div id="parent-row" class="connectedSortable" >
				<?php
				if ( ! empty( $customss_images ) ) {
					for ( $i = 0; $i < count( $customss_images ); $i++ ) {
						?>
						<div class="field_row">
							<div class="field_left">
								<div class="form_field">
									<input type="hidden" class="meta_image_url" 
										name="wp_customss_images_upload[]" 
										value="<?php esc_html_e( $customss_images[ $i ] ); ?>" />
								</div>
							</div>

							<div class="field_right image_wrap">
								<img src="<?php esc_html_e( $customss_images[ $i ] ); ?>" height="130" width="128" />
							</div>

							<div class="field_right">
								<input type="button" class="button btn-add-image" value="<?php echo __( 'Edit Image', 'customss' ); ?>" onclick="wp_add_image(this)" title="Click to edit image"/>
								<input type="button" class="button btn-remove-image" value="<?php echo __( 'Remove Image', 'customss' ); ?>" onclick="wp_remove_image(this)" title="Click to remove image"/>
							</div>
							<div class="clear" /></div> 
						</div>
						<?php
					}
				}
				?>
			</div>

			<div style="display: none;" id="child-row">
				<div class="field_row">
					<div class="field_left">
						<div class="form_field">	                        
						</div>
					</div>
					<div class="field_right image_wrap">
					</div> 
					<div class="field_right"> 
						<input type="button" class="button btn-add-image" value="<?php echo __( 'Upload Image', 'customss' ); ?>" onclick="wp_add_image(this)" />
						<input type="button" style="display:none" class="button btn-remove-image" value="<?php echo __( 'Remove Image', 'customss' ); ?>" onclick="wp_remove_image(this)" /> 
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div id="wp_add_new_slide">
				<input class="button btn-addRow" type="button" value="<?php echo __( 'Add New Slide', 'customss' ); ?>" onclick="wp_add_new_slide();" title="<?php echo __( 'Click to add new slide', 'customss' ); ?>"/>
			</div>
		</div>

		<?php

	}

}


/**
 * Get SLIDESHOW_ADMIN_SETTINGS running.
 */
$SLIDESHOW_ADMIN_SETTINGS = new SLIDESHOW_ADMIN_SETTINGS();
