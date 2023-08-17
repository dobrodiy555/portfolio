<?php
/*
Plugin Name: woocommerce-add-product-plugin
Description: Add one or many products programmatically
Version: 1.0
Author: AM
License: GPL2
*/

if (!defined('ABSPATH')) {
	die('-1');
}

function AddProduct_init() {
	require plugin_dir_path( __FILE__ ) . 'AddProduct.php';
	$run = new AddProduct;  // create object of class
}

AddProduct_init(); // launch

