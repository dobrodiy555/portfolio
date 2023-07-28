<?php
/*
Plugin Name: User page plugin
Description: Creates shortcode with user page info (six fields) in admin Settings option page, then shows this info on page, with ability to change it using popup window, ajax validation
Text Domain: upp
Domain Path: /lang
*/

// add class for creating options page in Settings
require __DIR__ . '/UppOptionsPage.php';
// create class object
new UppOptionsPage();


// add translation domain
add_action( 'plugins_loaded', 'upp_load_textdomain' );
function upp_load_textdomain() {
  load_plugin_textdomain( 'upp', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}

// add styles and scripts
add_action( 'wp_enqueue_scripts', 'upp_include_assets' );
function upp_include_assets() {
  // add bootstrap styles and scripts
  wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css', array(), 5.2, true );
  wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), 5.2, true );
  // add bootbox plugin for popup windows
  wp_enqueue_script('bootbox', plugins_url('bootbox-master/bootbox.js', __FILE__), array('bootstrap_js', 'jquery'), null, true );
  // add my script and translation
  wp_enqueue_script('upp-script', plugins_url('upp-script.js', __FILE__), array('jquery', 'bootstrap_js', 'bootbox'), null, true );
  wp_set_script_translations('upp-script', 'upp', plugin_dir_path(__FILE__) . 'lang/' );
  wp_localize_script( 'upp-script', 'upp', array('ajaxurl' => admin_url('admin-ajax.php')) );
}

// create object of my universal class
//$my_options = new MyOptions('my-options-page', 'my-options-group', 'my-options-nickname', 'my-options-section');

add_shortcode( 'user-page', 'show_user_page' );
function show_user_page() {
    ob_start();
    ?>
    <div class="upp-wrapper">

      <label><span><b>Name: </b></span><span id="name-place"><?php echo get_option('upp-name'); ?></span></label><br><br>
      <label><span><b>Surname: </b></span><span id="surname-place"><?php echo get_option('upp-surname'); ?></span></label><br><br>
      <label><span><b>Nickname: </b></span><span id="nickname-place"><?php echo get_option('upp-nickname'); ?></span></label><br><br>
      <label><span><b>Email: </b></span><span id="email-place"><?php echo get_option('upp-email'); ?></span></label>&nbsp; &nbsp; <span id="email-error"></span><br><br>
      <label><span><b>Telegram: </b></span><span id="telegram-place"><?php echo get_option('upp-telegram'); ?></span></label><br><br>
      <label><span><b>Viber: </b></span><span id="viber-place"><?php echo get_option('upp-viber'); ?></span></label><br><br>
      <label><b>Level of knowledge: </b>
        <span id="level-place"><?php echo get_option('upp-level'); ?></span>

      </label>
      <br><br>

    <button id="upp-edit">Edit</button>
    </div>

  <?php
  return ob_get_clean();
}


// на сервере будет ф-ция update_option и возвращать данные для обновления полей на стр-це (а если пустые поля, то будут старые данные
add_action( 'wp_ajax_update', 'upp_update_info' );
add_action( 'wp_ajax_nopriv_update', 'upp_update_info' );
function upp_update_info() {
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $nickname = $_POST['nickname'];
  $email = $_POST['email'];
  $telegram = $_POST['telegram'];
  $viber = $_POST['viber'];
  $level = $_POST['level'];

  // pack into array to reduce amount of code
  $arr = compact('name', 'surname', 'nickname', 'email', 'telegram', 'viber', 'level');
  foreach ($arr as $key=>$value) {
    $option = 'upp-' . $key;
    if (!empty($value)) {
      update_option($option, $value);
      $updated_field = get_option($option);
      ?>
      <script>
        place = '<?php echo $key; ?>';
        updatedField = '<?php echo $updated_field; ?>';
        jQuery('#' + place + '-place').html(updatedField);
         </script>
      <?php
    }
  }

  $email_option = get_option('upp-email');
  if ( !filter_var($email_option, FILTER_VALIDATE_EMAIL) ) {
    ?><script>
      jQuery('#email-error').html("<span style='color:red' id='email-error'>Email has a wrong format!</span>");
    </script><?php
    wp_die();
  }
  if ( email_exists($email_option) ) {
    ?><script>
      jQuery('#email-error').html("<span style='color:red' id='email-error'>Such email already exists!</span>");
    </script><?php
  }

  wp_die();
}