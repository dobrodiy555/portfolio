<?php

/*
Plugin Name:  weather_plugin
Description:  This plugin adds widget which shows weather in Kharkov.
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
Text Domain: ww
Domain Path: /lang
*/

include 'weather-widget.php';

register_activation_hook(__FILE__, 'weather_plugin_activate');
register_activation_hook(__FILE__, 'weather_plugin_deactivate');

function weather_plugin_activate() {
	flush_rewrite_rules();
}
function weather_plugin_deactivate() {
	flush_rewrite_rules();
}

// adding translation
add_action( 'plugins_loaded', 'ww_load_textdomain' );
function ww_load_textdomain() {
	load_plugin_textdomain( 'ww', false, basename ( dirname (__FILE__ ) ) . '/lang/' );
}

