<?php
/*
Plugin Name: SDIS Image Uploader
Description: Creates options page to upload images for banners using JS and wp.media
Author: Andrei Miheev
Version: 1.0
Text Domain: sdis
Domain Path: /lang
 */

if ( !defined('ABSPATH') )
	die ('No direct access allowed!');

// translate name and description of plugin
__( 'SDIS Image Uploader', 'sdis' );
__( 'Creates options page to upload image using JS and wp.media
', 'sdis' );

// add text domain
function sdis_load_textdomain() {
	load_plugin_textdomain( 'udp', false, basename ( dirname (__FILE__ ) ) . '/lang/' );
}
add_action( 'init', 'sdis_load_textdomain' );

// add menu to Admin
add_action('admin_menu', 'sdis_image_uploader_page', 25);
function sdis_image_uploader_page() {
	add_menu_page(
		__('SDIS image uploader', 'sdis'),
		__('SDIS Image Uploader', 'sdis'),
		'manage_options',
		'sdis-image-uploader',
		'sdis_image_uploader_callback',
		'dashicons-images-alt2',
		20
	);
}

function sdis_image_uploader_callback() {
	$image_id = get_option('rudr_banner');
  $image_id1 = get_option('rudr_banner1');
	?>
	<div class="wrap">
		<h1>SDIS upload image</h1>
    <br>
		<form method="post" enctype="multipart/form-data">
			<table class="form-table">
				<div id="is-image">
					<?php
					if ($image = wp_get_attachment_image_url( $image_id, 'medium' ) ) { ?>
					<a href="#" id="rudr-image-part" class="rudr-upload">
						<img src="<?php echo esc_url( $image ) ?>" />
					</a>
					<a href="#" class="rudr-remove button">Remove image for upper banner</a>
					<input type="hidden" name="rudr_img" id="rudr-hid-val" value="<?php echo absint( $image_id ) ?>">
            <?php }

            if ( $image1 = wp_get_attachment_image_url( $image_id1, 'medium' ) ) { ?>
              <a href="#" id="rudr-image-part1" class="rudr-upload">
                <img src="<?php echo esc_url( $image1 ) ?>" />
              </a>
              <a href="#" class="rudr-remove button">Remove image for lower banner</a>
              <input type="hidden" name="rudr_img1" id="rudr-hid-val1" value="<?php echo absint( $image_id1 ) ?>">
              <?php } ?>

				    </div>


				<?php if (!$image_id ) { ?>
				<div id="no-image">
					<a href="#" class="button rudr-upload">Upload image for upper banner</a>
					<a href="#" class="rudr-remove button" style="display:none">Remove image for upper banner</a>
					<input type="hidden" name="rudr_img" id="rudr-hid-val" value="">
          <?php } ?>

      <?php if (!$image_id1 ) { ?>
        <a href="#" class="button rudr-upload">Upload image for lower banner</a>
              <a href="#" class="rudr-remove button" style="display:none">Remove image for lower banner</a>
              <input type="hidden" name="rudr_img1" id="rudr-hid-val1" value="">
					<?php } ?>
				</div>
			</table>
			<p class="submit"><input type="submit" name="submit" class="button button-primary" value="Save Changes"></p>
		</form>
	</div>
	<?php
	if ( isset($_POST['submit']) ) {
		$image_id = $_POST['rudr_img'];
    $image_id1 = $_POST['rudr_img1'];
		if ( !empty($image_id) ) {
			$res = update_option( 'rudr_banner', $image_id );
		} else {
      $res = update_option( 'rudr_banner', '' );
    }
    if ($res) {
      echo '<div class="notice notice-success saved"><p> ' . __('Upper banner updated!', 'sdis') . '</p></div>';
			}
		}
    if ( !empty($image_id1) ) {
      $res1 = update_option( 'rudr_banner1', $image_id1 );
    } else {
      $res1 = update_option( 'rudr_banner1', '' );
    }
    if ($res1) {
      echo '<div class="notice notice-success saved"><p>' . __('Lower banner updated!', 'sdis') . '</p></div>';
    }
}

// enqueue script
add_action( 'admin_enqueue_scripts', 'sdis_include_uploader_js' );
function sdis_include_uploader_js() {
  if ( !did_action('wp_enqueue_media') ) {
    wp_enqueue_media();
  }
  wp_enqueue_script(
          'multiple-uploader',
          plugins_url('multiple-uploader.js', __FILE__ ),
          array( 'jquery' ),
  );
}





