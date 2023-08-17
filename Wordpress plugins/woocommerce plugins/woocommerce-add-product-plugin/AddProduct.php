<?php

class AddProduct {
	public function __construct(){
		add_action('activated_plugin', array($this,'wp2_add_product'));
		//add_action('activated_plugin', array($this, 'wp2_add_many_products'));
	}

	// add one product
	public function wp2_add_product() {
		$post_id = wp_insert_post(
			array(
				'post_title' => 'Great product with image!',
				'post_content' => 'Hey, this is our new product',
				'post_status' => 'publish',
				'post_type' => "product",
				'_thumbnail_id' => 757 // id of image from media library
			)
		);
		wp_set_object_terms( $post_id, 'simple', 'product_type' );
		// add more info
		update_post_meta( $post_id, '_price', '156' );
		update_post_meta( $post_id, '_featured', 'yes' );
		update_post_meta( $post_id, '_stock', '23' );
		update_post_meta( $post_id, '_stock_status', 'instock');
		update_post_meta( $post_id, '_sku', 'jk01' );
	}

	// add many products
	public function wp2_add_many_products() {
		$product_array = array(
			array(
				'post_title'   => 'This is the first product',
				'post_content' => 'Description of the first product',
				'post_status'  => 'draft',
				'post_type'    => "product",
			),
			array(
				'post_title'   => 'Second product title',
				'post_content' => 'Description of second product',
				'post_status'  => 'draft',
				'post_type'    => "product"
			),
			array(
				'post_title'   => 'Title of third product',
				'post_content' => 'Description of the third product',
				'post_status'  => 'draft',
				'post_type'    => "product"
			)
		);
		for ( $i = 0; $i < count( $product_array ); $i++ ) {
			$post_id = wp_insert_post( $product_array[ $i ] );
			wp_set_object_terms( $post_id, 'simple', 'product_type' );
		}
	}
}

