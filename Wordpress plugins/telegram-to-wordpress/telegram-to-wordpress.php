<?php
/*
Plugin Name: Telegram to WordPress
Plugin URI: https://your-plugin-url.com
Description: Fetches posts from Telegram (my bot) and publishes them on your WordPress website.
Version: 1.0.0
Author: Your Name
Author URI: https://your-website.com
*/


//Add a utility function to handle logs more nicely.
if ( !function_exists('write_log') ) {
	function write_log($log)  {
		if ( is_array($log) || is_object($log) ) {
			error_log( print_r($log, true) );
		} else {
			error_log($log);
		}
	}
}

// Register activation hook
register_activation_hook(__FILE__, 'telegram_to_wordpress_activate');

// Register deactivation hook
register_deactivation_hook(__FILE__, 'telegram_to_wordpress_deactivate');

// Plugin activation function
function telegram_to_wordpress_activate() {
	write_log("Plugin activated.");
	flush_rewrite_rules();
}

// Plugin deactivation function
function telegram_to_wordpress_deactivate() {
	flush_rewrite_rules();
	// deactivate cron
	$timestamp = wp_next_scheduled('telegram_to_wordpress_cron');
	wp_unschedule_event($timestamp, 'telegram_to_wordpress_cron');
	write_log("Plugin deactivated.");
}


// Function to fetch posts from Telegram
function telegram_to_wordpress_fetch_posts() {
	$bot_token = '60225766666:AAGE1WplFEShxeKgGNafrwRA8JQiqvYOjJL'; // bot token
	$url = 'https://api.telegram.org/bot' . $bot_token . '/getUpdates'; // to delete old updates, use add ?offset= last update_id + 1
	$result = file_get_contents($url);
	$data = json_decode($result, true);
	if ( $data && isset($data['result']) ) {
		$updates = $data['result'];
		foreach ($updates as $update) {
			$post_content = $update['message']['text'];
			$post_title = strstr($post_content, "\n", true); // first line is a title
			$post_content = strstr($post_content, "\n"); // all after first line is a content

			// check if posts with such title already exist
			$existing_post = get_posts( array(
				'post_type'              => 'post',
				'numberposts' => 1, // default is 5
				'post_status' => 'publish',
				'title' => $post_title
			) );

			// если поста с таким заголовком нет, создаст его, если уже есть - обновит
			if ( !$existing_post ) { // empty array is falsey in php, u can also write if empty($arr) or if count($arr) === 0
				$args = array(
					'post_title' => $post_title,
					'post_content' => $post_content,
					'post_status' => 'publish',
					'post_author' => 1 // dobrodiy
				);
				wp_insert_post($args, true);
				write_log("Post created.");
			} else {
				// get id of the post by its title in order to be able to update it then
				$post_id = $existing_post[0]->ID;
				$existing_post_content = $existing_post[0]->post_content;
				// to avoid updating posts where content is the same
				if ($existing_post_content !== $post_content) {
					wp_update_post( array(
						'ID'           => $post_id,
						'post_type'    => 'post',
						'title'        => $post_title,
						'post_status'  => 'publish',
						'post_content' => $post_content,
						'post_author' => 1
					) );
					write_log( "Post updated." );
				}
			}
		}
	}
}

//add_action('activated_plugin', 'telegram_to_wordpress_fetch_posts'); // works when activating post

// if we need our own event interval, we can create
//function my_cron_schedules($schedules) {
//	write_log("Creating custom schedule.");
//	if(!isset($schedules["60sec"])){
//		$schedules["60sec"] = array(
//			'interval' => 60,
//			'display' => __('Once every 60 seconds') );
//	}
//	write_log("Custom schedule created.");
//	return $schedules;
//}
//add_filter('cron_schedules','my_cron_schedules');


//// Hook the fetch_posts function to a recurring event using WordPress Cron
add_action('telegram_to_wordpress_cron', 'telegram_to_wordpress_fetch_posts');
//// Schedule recurring updates
function telegram_to_wordpress_schedule_updates() {
	$args = array(false);
	if ( !wp_next_scheduled('telegram_to_wordpress_cron', $args) ) { // args are necessary if we pass our own schedule ('60sec')
		wp_schedule_event( time(), 'hourly', 'telegram_to_wordpress_cron', $args );
		write_log("Schedule triggered!");
	}
}
add_action('plugins_loaded', 'telegram_to_wordpress_schedule_updates');
