<?php
/*
Plugin Name: woocommerce-discount-plugin1
Description: A plugin that provides discounts for users based on their role
Version: 1.0
Author: GBT
License: GPL2
*/

add_action( 'woocommerce_cart_calculate_fees', 'registered_user_discount', 10, 1 );

function registered_user_discount( $cart ) {

  // Check if user is logged in
  if ( is_user_logged_in() ) {

    // Get user role
    $user = wp_get_current_user();
    $roles = $user->roles;

    // Define discount based on user role
    if ( in_array( 'administrator', $roles ) ) {
      $discount = 0.1; // 10% discount for subscribers
    } elseif ( in_array( 'customer', $roles ) ) {
      $discount = 0.05; // 5% discount for customers
    } else {
      $discount = 0; // No discount for other roles
    }

    // Calculate discount amount
    $discount_amount = $cart->subtotal * $discount;

    // Add discount to cart
    if ( $discount_amount > 0 ) {
      $cart->add_fee( 'Registered User Discount', -$discount_amount );
    }
  }
}

