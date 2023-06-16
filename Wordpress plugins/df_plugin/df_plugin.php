<?php
/*
Plugin Name: df_plugin
*/

register_activation_hook( __FILE__, 'df_plugin_activate');
register_deactivation_hook( __FILE__, 'df_plugin_deactivate');

function df_plugin_activate() {
	flush_rewrite_rules();
}
function df_plugin_deactivate() {
	flush_rewrite_rules();
}

add_shortcode( 'df', 'download_file' ); // название шорткода, ф-ция шорткода
function download_file( $atts, $content ) {
	$default = array(
		'title' => 'Download file',
		'url' => ''
	);
	$atts = shortcode_atts( $default, $atts );
	return '<a href="' . esc_html($atts['url']) . '" title="' . esc_html($atts['title']) . '">' . esc_html($atts['title']) . '</a>';
}

