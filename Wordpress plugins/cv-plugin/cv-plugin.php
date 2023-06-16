<?php
/*
Plugin Name: CV plugin
Description: Creates shortcode with adds cv form, then makes ajax validation, then sends email, popup and redirect
Text Domain: cv
Domain Path: /lang
*/

// translate name and description of plugin
__( 'CV plugin', 'cv' );
__( 'Creates shortcode with adds cv form, then makes ajax validation, then sends email, popup and redirect', 'cv' );
// should match description

// add translation domain
add_action( 'plugins_loaded', 'cv_load_textdomain' );
function cv_load_textdomain() {
    load_plugin_textdomain( 'cv', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}

// add style
add_action( 'wp_enqueue_scripts', 'cv_include_style' );
function cv_include_style() {
  // add bootstrap styles
  wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css', array(), 5.2, true );
  // add my css
  wp_enqueue_style( 'cv-style', plugins_url('cv-style.css', __FILE__), false, null, 'all' );
}

// add scripts (and script translation)
add_action( 'wp_enqueue_scripts', 'cv_include_script' );
function cv_include_script()
{
    // add bootstrap scripts
    wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), 5.2, true);
    // add bootbox for alert
    wp_enqueue_script('bootbox', plugins_url('bootbox-master/bootbox.js', __FILE__), array('bootstrap_js', 'jquery'), null, true);
    // add jquery form validation
    wp_enqueue_script('jquery-valid', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js', array('jquery'), null, true );
    // add our main script
    wp_enqueue_script('cv-script', plugins_url('cv-script.js', __FILE__), array('jquery', 'bootstrap_js', 'bootbox', 'jquery-valid'), null, true);
    // add script translation
    wp_set_script_translations('cv-script', 'cv', plugin_dir_path(__FILE__) . 'lang/');
    // pass js variables (nonce and ajaxurl)
    wp_localize_script( 'cv-script', 'cv', array('ajaxurl' => admin_url('admin-ajax.php'), 'security' => wp_create_nonce('cv_nonce_name') ) );
}

add_shortcode( 'cv-form', 'show_cv_form' );
function show_cv_form() {
    ob_start();
    ?>
    <div class="cv-form-wrapper">

        <form id="cv-form" method="post" action="" enctype="multipart/form-data">
            <h2 class="cv-form-header"><?php esc_html_e('CV form', 'cv'); ?></h2>
            <br>

          <div class="form-item">
            <label for="name"><?php esc_html_e('Name:', 'crp'); ?></label>
            <input type="text" id="name" name="name">
          </div>

          <div class="form-item">
            <label for="surname"><?php esc_html_e('Surname:', 'cv'); ?></label>
            <input type="text" id="surname" name="surname">
          </div>

          <div class="form-item">
            <label for="email"><?php esc_html_e('Email:', 'cv'); ?></label>
            <input type="text" id="email" name="email">
          </div>

          <div class="form-item">
            <label for="file"><?php esc_html_e('File:', 'cv'); ?></label>
          <input type="file" id="file" name="file">
            <p class="error"></p>
          </div>

         <input type="submit" name='submit' id="submit" value="<?php esc_attr_e('Register', 'crp'); ?>">

        </form>
    </div>

  <?php
  return ob_get_clean();
}

add_action( 'wp_ajax_cvgo', 'cv_register_user' );
add_action( 'wp_ajax_nopriv_cvgo', 'cv_register_user' );
function cv_register_user() {

  $name = sanitize_text_field($_POST['name']);
  $surname = sanitize_text_field($_POST['surname']);
  $email = sanitize_email($_POST['email']);

  // check nonce
  check_ajax_referer( 'cv_nonce_name', 'security' );

  // check that user updated file
  if ( file_exists($_FILES['file']['tmp_name']) ) {
    $target_file = dirname(__FILE__) . '/uploaded_files/' . basename($_FILES['file']['name']);
    // check file extension
    $allowed_extensions = ['doc', 'docx', 'pdf'];
    $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if ( !in_array($file_extension, $allowed_extensions) ) {
      echo "<span>" . esc_html_e("Sorry, your file has a wrong format. Only .doc, .docx and .pdf are allowed!","cv") . "</span>";
      wp_die();
    } else {
      // save uploaded file in a folder 'uploaded_files'
      move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
    }
  } else {
    echo "<span>" . esc_html_e("Sorry, some problems occurred with your file. Please, upload it again!", "cv") . "</span>";
    wp_die();
  }

  //  send email to user
  $to = $email;
  $subj = 'new user';
  $body = "Dear $name $surname! Thank you for uploading your CV!";
  $head = array( 'Content-Type: text/html; charset=UTF-8' );
  wp_mail($to, $subj, $body, $head);

  // final popup and redirect (code is in cv-script.js)
  echo "popup-redirect";

  wp_die();
}