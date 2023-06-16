<?php
/*
Plugin Name:  thumbup-plugin
Description:  This plugin will add thumb-up like button to posts and number of likes, doesn't save number of likes of particular user for particular post, but saves number of likes in general so one user can like one post many times
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
*/

add_action( 'wp_enqueue_scripts', 'thumb_include_assets' );
function thumb_include_assets() {
  wp_enqueue_style('thumb-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false, null, 'all' );
	wp_enqueue_style('thumb-style', plugins_url('thumb-style.css', __FILE__), array('thumb-cdn'), null, 'all' );
	wp_enqueue_script( 'thumb-script', plugins_url('thumb-script.js', __FILE__), array('jquery'), null, true );
	wp_localize_script( 'thumb-script', 'thumb', array( 'ajaxurl' => admin_url('admin-ajax.php') ) );
}

add_shortcode( 'thumb', 'thumb_add_like_button');
function thumb_add_like_button() {
	ob_start();
	global $post;
	$thumb_likes = get_post_meta($post->ID, 'thumb_likes', true); // empty string returned if no such key
	$thumb_likes = ($thumb_likes == "") ? 0 : $thumb_likes;
	?>
<div class="fa-wrapper">
	<i id="thumb-btn" class="fa fa-thumbs-up jumping" data-post_id="<?php echo $post->ID; ?>"></i>
  <span id="number-of-thumbs"><?php echo $thumb_likes; ?></span>
</div>
	<?php
	return ob_get_clean();
}


add_action( 'wp_ajax_thumbgo', 'thumb_add_like' );
add_action( 'wp_ajax_nopriv_thumbgo', 'thumb_add_like' );
function thumb_add_like() {
  $post_id = $_POST['post_id'];
  $liked = $_POST['isLiked'];
  $thumb_count = get_post_meta($post_id, "thumb_likes", true);
  $thumb_count = ($thumb_count == '') ? 0 : $thumb_count;
  $new_thumb_count = $liked ? $thumb_count + 1 : $thumb_count - 1;
  // update post's number of likes
  $res = update_post_meta($post_id, 'thumb_likes', $new_thumb_count); // if no such key exists, will be added and its id returned
  if ($res) {
    echo "number of thumbs in db updated!";
    // не буду передавать новое значение на клиент так как тормозит, вместо этого просто будет работать инкремент/декремент на клиенте при клике на thumb
    //echo $new_thumb_count;
  } else {
    echo "error: number of thumbs couldn't be updated!";
    //echo $thumb_count;
  }
  die();
}
