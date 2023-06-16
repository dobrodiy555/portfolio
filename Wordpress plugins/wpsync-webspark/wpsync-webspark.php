<?php
/*
Plugin Name: wpsync-webspark
Description: Plugin for synchronizing product database with stock quantities from WebSpark API
Version: 1.0
Author: Andrei Miheev
License: GPL2
*/


set_time_limit(12000); // overwrite max_execution_time=120 in php.ini // more than 3 hours


//Add logging
if ( !function_exists('webspark_write_log') ) {
	function webspark_write_log($log)  {
		if ( is_array($log) || is_object($log) ) {
			error_log( print_r($log, true) );
		} else {
			error_log($log);
		}
	}
}

register_activation_hook( __FILE__, 'wpsync_webspark_schedule_sync' );

register_deactivation_hook( __FILE__, 'webspark_deactivate' );
function webspark_deactivate() {
	$timestamp = wp_next_scheduled( 'wpsync_webspark_cron_hook' );
	wp_unschedule_event( $timestamp, 'wpsync_webspark_cron_hook' );
	write_log("Plugin wpsync-webspark deactivated!");
}


// create custom schedule (recurrence)
//function wpsync_webspark_cron_schedules($schedules) {
//	if( !isset($schedules["60sec"]) ) {
//		$schedules["60sec"] = array(
//			'interval' => 60,
//			'display' => esc_html__('Once every 60 seconds') );
//	}
//	write_log("Custom schedule created.");
//	return $schedules;
//}
//add_filter('cron_schedules','wpsync_webspark_cron_schedules');


// Schedule hourly synchronization
add_action( 'wpsync_webspark_cron_hook', 'wpsync_webspark_sync_products_main_function' );
function wpsync_webspark_schedule_sync() {
	write_log('Plugin webspark activated');
	if ( ! wp_next_scheduled( 'wpsync_webspark_cron_hook' ) ) {
		wp_schedule_event( time(), 'twicedaily', 'wpsync_webspark_cron_hook' );
		write_log("Schedule event triggered!");
	}
}

// Perform product synchronization
function wpsync_webspark_sync_products_main_function() {
	write_log("Main function started!");

	// Make API request to get products
	$api_url = 'https://wp.webspark.dev/wp-api/products';
	$response = wp_remote_get( $api_url );
	write_log("GET request sent!");

	// Error handling if API request fails
	if ( is_wp_error( $response ) ) {
		$error_string = $response->get_error_message();
		write_log("WP error - $error_string - during get request!");
		return;
	}

	// Retrieve JSON response
	$products = json_decode( wp_remote_retrieve_body( $response ) );

	// Check if products are available
	if ( empty( $products ) ) {
		// Error handling if no products are received
		write_log("Empty json response!");
		return;
	}
	write_log("Products json received!");

	// Loop through products
	if ( $products->message == "OK" && isset($products->data) && is_array($products->data) ) {
		foreach ( $products->data as $product ) {
			$sku         = $product->sku;
			$name        = $product->name;
			$description = $product->description;
			$price       = $product->price;
			$picture     = $product->picture;
			$in_stock    = $product->in_stock;

			// Check if product already exists in the database
			$existing_product_id = wc_get_product_id_by_sku( $sku ); // returns int or 0 if no such SKU

			if ( $existing_product_id ) {
				update_product( $existing_product_id, $name, $description, $price, $picture, $in_stock );
			} else {
				create_product( $sku, $name, $description, $price, $picture, $in_stock );
			}
		}
	}

	// Remove products not received from the API
	remove_unavailable_products( $products );
	write_log("Main function finished!");
}

// Function to update existing product
function update_product( $product_id, $name, $description, $price, $picture, $in_stock ) {

	// update only if each value is different
	$existing_prod_obj = wc_get_product($product_id);
	$existing_name = $existing_prod_obj->get_name();
	if ($existing_name != $name) {
		update_post_meta($product_id, '_name', $name);
		write_log( "Product $name updated name!" );
	}

	$existing_description = $existing_prod_obj->get_description();
	if ($existing_description != $description) {
		update_post_meta($product_id, '_description', $description);
		write_log( "Product $name updated description!" );
	}

	$existing_price = $existing_prod_obj->get_price();
	if ($existing_price != $price) {
		update_post_meta($product_id, '_price', $price);
		write_log( "Product $name updated price!" );
	}

	$existing_picture = get_post_meta($product_id, '_picture', true);
	if ($existing_picture != $picture) {
		update_post_meta($product_id, '_picture', $picture);
		wpsync_wepspark_set_product_images($picture, $product_id);
		write_log( "Product $name updated picture!" );
	}

	$existing_in_stock = get_post_meta($product_id, '_in_stock', true);
	if ($existing_in_stock != $in_stock) {
		update_post_meta($product_id, '_in_stock', $in_stock);
		set_stock_status($in_stock, $product_id);
		write_log( "Product $name updated in_stock!" );
	}

	write_log( "Product $name finished updating!" );
}

// Function to create new product
function create_product( $sku, $name, $description, $price, $picture, $in_stock ) {

	// Create new product with necessary fields
	$product_id = wp_insert_post( array(
		'post_title' => $name,
		'post_content' => $description,
		'post_status' => 'publish',
		'post_type' => 'product'
	) );

    if ( $product_id ) {
	// assign category
      $category_id = 19; // 'clothing' category
	  $taxonomy = 'product_cat'; // taxonomy for wc products
      wp_set_object_terms( $product_id, $category_id, $taxonomy ); // обязательно присваиваем категорию иначе не будет видеть этот продукт
	  update_post_meta( $product_id, '_sku', $sku );
	  update_post_meta( $product_id, '_price', $price );
	  update_post_meta( $product_id, '_picture', $picture );
	  update_post_meta( $product_id, '_in_stock', $in_stock );
	  set_stock_status( $in_stock, $product_id );
      wpsync_wepspark_set_product_images( $picture, $product_id );
	  write_log( "Product $name created!" );
    } else {
	    write_log("Error during wp_insert_post() with product $name");
    }
}

// if there is _in_stock value, set _stock_status as 'instock', otherwise 'outofstock'
function set_stock_status( $in_stock, $product_id ) {
	if ( $in_stock ) {
		wc_update_product_stock_status( $product_id, 'instock' );
		write_log( "Stock status updated for 'instock'" );
	} else {
		wc_update_product_stock_status( $product_id, 'outofstock' );
		write_log( "Stock status updated for 'outofstock'" );
	}
}

// Function to remove unavailable products
function remove_unavailable_products( $received_products ) {

	// get array of all products
	$args = array(
		'status' => 'publish',
		'limit' => -1,
	);
   $all_products = wc_get_products($args);

	foreach ( $all_products as $product ) {
		$sku = $product->get_sku();
		// Check if the product's SKU exists in the received products
		if ( !product_exists_in_received_list($sku, $received_products) ) {
			// Product is not available, remove it
			wp_delete_post( $product->get_id(), true ); // if force_delete is false (default), will go to trash
			write_log("Product $product->get_id() deleted");
		}
	}
}

// Helper function to check if product exists in the received list
function product_exists_in_received_list($sku, $received_products) {
	foreach ($received_products->data as $product) {
		if ($product->sku === $sku) {
			return true;
		}
	}
	return false;
}

// f-n to upload images and set them as our products images
function wpsync_wepspark_set_product_images( $image_url, $post_id ) {

	write_log("Started image generating function");
	$upload_dir = wp_upload_dir(); // узнаем куда загружаются файлы
	$image_data = file_get_contents($image_url); // image into string from url
	write_log("file_get_contents() worked");
	$filename = basename($image_url) . $post_id . '.jpg'; // name of image by last part of it, but we need to add jpg extension, otherwise doesn't know file type
	if ( wp_mkdir_p($upload_dir['path']) ) {
		write_log("upload dir path worked");
		$file = $upload_dir['path'] . '/' . $filename; // creates directories recursively
	} else {
		$file = $upload_dir['basedir'] . '/' . $filename;
		write_log("upload dir basedir worked");
	}
	file_put_contents($file, $image_data); // write data to a file
	write_log("Image $filename created");
	$wp_filetype = wp_check_filetype( $filename, null ); // returns array with mimetype and extension
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => sanitize_file_name($filename),
		'post_content' => '',
		'post_status' => 'inherit'
	);
	$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	set_post_thumbnail( $post_id, $attach_id );
	write_log("Image $filename attached to product $post_id");
}