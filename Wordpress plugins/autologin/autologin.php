<?php
/*
Plugin Name: autologin
Description: creates shortcode with form where there is one input for email, validates this email with ajax and sends link either for login or for registration
Text Domain: al
Domain Path: /lang
*/

add_shortcode('al-form', 'show_autologin_form' );
function show_autologin_form() {
  ob_start();
    ?>
    <div class="al-form-wrapper">
      <h2 class="al-form-header"><?php _e('Autologin form', 'al'); ?></h2>
      <br>
      <label for="al-input-email">Enter your email:</label>
      <input type="email" id="al-input-email" class="al-input-email" />
      <br><br>
      <button type="submit" id="al-submit-btn">Send</button>
      <br><br>
       <p id="resp"></p>
    </div>
    <?php
  return ob_get_clean(); // without it says 'invalid json' when inserting shortcode in admin
}


// add script
add_action( 'wp_enqueue_scripts', 'autologin_include_script' );
function autologin_include_script() {
  wp_enqueue_script( 'script', plugins_url( 'script.js', __FILE__), array('jquery'), null, true );
  wp_localize_script( 'script', 'alajax', array(
                  'ajaxurl' => admin_url('admin-ajax.php')
          )
  );
}

add_action( 'wp_ajax_send', 'send_correct_email' );
function send_correct_email() {
  $email = $_POST['email'];
  if ( empty($email) ) {
    echo "<p style='color:red' class='error'>" . __('Please enter email!', 'al') .  "</p>";
  } else {
    if ( !is_email($email) ) {
      echo "<p style='color:red' class='error'>" . __('Your email has wrong format!', 'al') . "</p>";
      wp_die();
    }
    $exists = email_exists($email);
    if ($exists) {
      echo "<p style='color:red' class='error'>" . __('This email already exists!', 'al') . "</p>";
      $subj = 'link for login';
      $body = "Dear user! We send you a <b><a href='http://localhost/wordpress/login/'>link</a></b> for login.";
      $headers = array('Content-Type: text/html; charset=UTF-8');
      wp_mail( $email, $subj, $body, $headers );
    } else {
      echo "<p>" . __("This email is valid!", "al") . "</p>";
      $subj1 = 'link for registration';
      $body1 = "Dear user! We send you a <b><a href='http://localhost/wordpress/register/'>link</b> for registration.";
      $headers1 = array('Content-Type: text/html; charset=UTF-8');
      wp_mail( $email, $subj1, $body1, $headers1 );
    }
  }
  wp_die();
}




