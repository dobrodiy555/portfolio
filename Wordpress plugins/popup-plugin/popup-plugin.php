<?php
/*
Plugin Name: Popup plugin
Description: Creates popup that appears after 30 sec on all pages, asks if user want to subscribe to the language course, appearance like in freelance task
Text Domain: pop
Domain Path: /lang
*/

// translate name and description of plugin
__( 'Popup plugin', 'pop' );
__( 'Creates popup that appears after 30 sec on posts, asks if user want to subscribe to the language course', 'pop' );

// add translation domain
add_action( 'plugins_loaded', 'pop_load_textdomain' );
function pop_load_textdomain() {
	load_plugin_textdomain( 'pop', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}

// add styles and scripts
add_action( 'wp_enqueue_scripts', 'pop_include_assets' );
function pop_include_assets() {
	wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css', array(), 5.2, true );
	wp_enqueue_style( 'pop-style', plugins_url('assets/css/pop-style.css', __FILE__), array('bootstrap-css'), null, 'all' );
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), 5.2, true );
	wp_enqueue_script('bootbox', plugins_url('assets/bootbox-master/bootbox.js', __FILE__), array('bootstrap-js', 'jquery'), null, true );
	wp_enqueue_script('pop-script', plugins_url('assets/js/pop-script.js', __FILE__), array('jquery', 'bootstrap-js', 'bootbox'), null, true );
	wp_set_script_translations('pop-script', 'pop', plugin_dir_path(__FILE__) . 'lang/');

}

