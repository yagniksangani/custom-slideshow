<?php
/**
 * This template file used for load the html of custom slideshow section.
 *
 * @package customss
 */

$customss_images = get_option( 'wp_customss_images_upload' );

?>

<div class="wp_custom_slider_container">
	<?php if ( ! empty( $customss_images ) ) { ?>
		<section class="custom_slideshow_section vertical-center-4 slider">
			<?php for ( $i = 0; $i < count( $customss_images ); $i++ ) { ?>
				<div>
					<img src="<?php esc_html_e( $customss_images[ $i ] ); ?>">
				</div>
			<?php } ?>
		</section>
	<?php } else { ?>
		<p><?php echo esc_html( __( 'No images found.', 'customss' ) ); ?></p>
	<?php } ?>
</div>
