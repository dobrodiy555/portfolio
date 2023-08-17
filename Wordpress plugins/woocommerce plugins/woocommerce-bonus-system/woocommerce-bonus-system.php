<?php
/*
Plugin Name: Woocommerce Bonus System
Description: Plugin creating new user role 'seller' and calculating him 30% bonus for every sale
Version: 1.0
Author: Andrei Miheev
License: GPL2
Text Domain: wbs
Domain Path: /lang
*/

// when plugin is activated, table is created
register_activation_hook( __FILE__, 'wbs_create_custom_table' );
//register_activation_hook( __FILE__, 'register_post_meta' ); // can be only one activation hook

// add role 'seller'
add_role( 'seller', 'Seller', array(
	'read' => true,
	'edit_products' => true,
	'delete_products' => true,
) );

//* Display the custom text field in "Add new product" or 'Edit product'
function wbs_create_custom_field() {
	$args = array(
		'id' => 'custom_text_field_title',
		'label' => __( 'Custom Text Field Title', 'wbs' ),
		'class' => 'wbs-custom-field',
		'desc_tip' => true, // tooltip (? sign) will be shown near
		'description' => __( 'Enter the title of your custom text field.', 'wbs' ), // when you hover tooltip
	);
	woocommerce_wp_text_input( $args );

	$args1 = array(
		'id' => 'wbs-seller-select',
		'label' => __("Choose a seller for this product", "wbs"),
		'class' => 'wbs-seller-select',
		'desc_tip' => true,
		'description' => __("Enter the user who is the seller of this product", "wbs"),
		'options' => array('Stepan' => 'Stepan', 'vasya' => 'Vasya', 'andrei' => 'Andrei'), // stepan - value, Stepan - what user sees in Select
	);
	woocommerce_wp_select($args1);
}
add_action( 'woocommerce_product_options_general_product_data', 'wbs_create_custom_field' );

// register 'seller' metabox key
register_post_meta('product', 'wbs-seller', array(
	'type'              => 'string',
	'description'       => 'seller value for woocommerce-bonus-system plugin',
	'single'            => false,
	'sanitize_callback' => null,
	'auth_callback'     => null,
	'show_in_rest'      => true
) );

// save custom field (select)
function wbs_save_custom_field( $post_id ) {
	$product = wc_get_product( $post_id );
	$seller = $_POST['wbs-seller-select'] ?? '';
	$product->update_meta_data( 'wbs-seller-select', $seller );
	$product->save();
}
add_action( 'woocommerce_process_product_meta', 'wbs_save_custom_field' );


// Display custom field on the front end
function wbs_display_custom_field() {
	global $post;
	// Check for the custom field value
	$product = wc_get_product( $post->ID ); // product ID
	$seller = $product->get_meta( 'wbs-seller-select' );
	if( $seller ) {
		// Only display our field if we've got a value for the field title
		printf(
			'<p></p><div class="wbs-custom-field-wrapper"><label for="wbs-seller-field">Seller: </label><span id="wbs-seller-field"><u>%s</u></span></div></p>',
			esc_html( $seller )
		);
	}
}
add_action( 'woocommerce_before_add_to_cart_button', 'wbs_display_custom_field' );

// create custom table in db for saving data
function wbs_create_custom_table() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'wbs_order_info';
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
		  order_number mediumint(9) NOT NULL,
		  order_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  product_name varchar(55) NOT NULL,
		  seller varchar(55),
		  bonus float(11) NOT NULL
		) $charset_collate;";
// f-n dbDelta() for creating table is in this file
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	maybe_create_table($table_name, $sql);
	//dbDelta( $sql );
}

// add data about order into created custom table in db
add_action( 'woocommerce_order_status_completed', 'wbs_add_info_about_order_into_database' );
function wbs_add_info_about_order_into_database($order_id) {
	global $wpdb;
	$order = wc_get_order($order_id);
	$order_number = $order->get_order_number();
	$order_date = $order->get_date_created()->format('Y-m-d H:i:s');
	// Перебираем товары в заказе
	foreach ( $order->get_items() as $item_id => $item ) {
		$product_id = $item->get_product_id();
    $product_name = $item['name'];
		// there are two ways to get product metadata ('wbs-seller-select' value), first way:
		$seller     = get_post_meta( $product_id, 'wbs-seller-select', true );
		// second way
		//$product = wc_get_product($product_id);
		//$seller = $product->get_meta('wbs-seller-select');
		$bonus      = $item->get_data()['total'] * 0.3; // 30% от суммы продукта

		// Записываем информацию о покупке в кастомную таблицу
		$wpdb->insert(
			$wpdb->prefix . 'wbs_order_info',
			array(
				'order_number'  => $order_number,
				'order_date'    => $order_date,
        'product_name' =>  $product_name,
				'seller'        => $seller,
				'bonus'         => $bonus,
			)
		);
	}
}

// shortcode with parameter of user [bonus-info user="andrei"] or without, then will be all users
add_shortcode( 'bonus-info', 'wbs_show_bonus_info' );
function wbs_show_bonus_info( $attr ) {
  $default = array( 'user' => 'Stepan' );
  $atts = shortcode_atts($default, $attr);
	ob_start();
	echo "<h2>Table of orders and bonuses</h2>";
	global $wpdb;
	$table = 'wp_wbs_order_info';
  $user = $atts['user'];
  // if there is parameter 'user' in shortcode, give only bonuses of this user, if shcd without param-s - of all users
  $sql = $attr ? "SELECT * FROM $table WHERE seller = '$user'" : "SELECT * FROM $table";
	$results = $wpdb->get_results($sql);
	?>
	<table border='1'>
		<tr>
			<th>Order number</th>
			<th>Order date</th>
			<th>Product</th>
			<th>Seller</th>
			<th>Bonus</th>
		</tr>
		<tbody>
	<?php
	foreach ($results as $result) {
		echo "<tr>
			<td>$result->order_number</td>
			<td>$result->order_date</td>
			<td>$result->product_name</td>			
			<td>$result->seller</td>
			<td>$result->bonus</td>
		 </tr>";
	}
	echo "</tbody></table>";
	return ob_get_clean();
}



// add table with bonuses to admin
add_action('admin_menu', 'wbs_register_admin_menu', 99); // we need 99 to make the item last (without it is the third)
function wbs_register_admin_menu() {
  add_submenu_page('woocommerce', 'Seller bonuses', 'Seller bonuses', 'manage_options', 'seller_bonuses', 'wbs_show_seller_bonuses' );
}

function wbs_show_seller_bonuses() {
  echo "<h3>Table of orders and bonuses</h3>";
  global $wpdb;
  $table = 'wp_wbs_order_info';
  // if there is parameter 'user' in shortcode, give only bonuses of this user, if shcd without param-s - of all users
  $sql = "SELECT * FROM $table";
  $results = $wpdb->get_results($sql);
  ?>
  <table border='1'>
    <tr>
      <th>Order number</th>
      <th>Order date</th>
      <th>Product</th>
      <th>Seller</th>
      <th>Bonus</th>
    </tr>
    <tbody>
  <?php
  foreach ($results as $result) {
    echo "<tr>
			<td>$result->order_number</td>
			<td>$result->order_date</td>
			<td>$result->product_name</td>			
			<td>$result->seller</td>
			<td>$result->bonus</td>
		 </tr>";
  }
  echo "</tbody></table>";
}


