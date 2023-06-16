<?php
/*
Plugin Name: lt_plugin
Description: creates template page where we add text for translation
Text Domain: lt
Domain Path: /lang
 */

function my_template_array() {
	$temps = [];
	$temps['my_template.php'] = 'My template';
	return $temps;
}

function my_template_register() {
	$templates = my_template_array();
	foreach ($templates as $k=>$v) {
		$page_templates[$k] = $v;
	}
	return $page_templates;
}
add_filter('theme_page_templates', 'my_template_register', 10, 3);

function my_template_select($template) {
	global $post;
	$page_temp_slug = get_page_template_slug( $post->ID );
	$templates = my_template_array();
	if (isset($templates[$page_temp_slug])) {
		$template = plugin_dir_path(__FILE__) . 'templates/' . $page_temp_slug;
	}
	//echo '<pre>' . print_r($page_temp_slug) . '</pre>';
	return $template;

}
add_filter('template_include', 'my_template_select', 99);

// adding translation
function lt_load_textdomain() {
	load_plugin_textdomain( 'lt', false, basename ( dirname (__FILE__ ) ) . '/lang/' );
}
add_action( 'plugins_loaded', 'lt_load_textdomain' );

