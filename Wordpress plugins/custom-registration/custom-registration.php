<?php
/*
Plugin Name: Custom registration plugin
Description: Creates shortcode which shows login form with six fields, upon submit happens ajax validation, creation of user, popup and redirect
Text Domain: crp
Domain Path: /lang
*/

// translate name and description of plugin
__( 'Custom registration plugin', 'crp' );
__( 'Creates shortcode which shows login form with six fields, upon submit happens ajax validation, creation of user, popup and redirect', 'crp' );

// add translation domain
add_action( 'plugins_loaded', 'crp_load_textdomain' );
function crp_load_textdomain() {
  load_plugin_textdomain( 'crp', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}

// add style
add_action( 'wp_enqueue_scripts', 'crp_include_style' );
function crp_include_style() {
  wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css', array(), 5.2, true ); // add bootstrap style
  wp_enqueue_style( 'style', plugins_url('style.css', __FILE__), false, null, 'all' );
}

// add scripts (and script translation)
add_action( 'wp_enqueue_scripts', 'crp_include_script' );
function crp_include_script()
{
  wp_enqueue_script('bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js', array('jquery'), 5.2, true ); // add bootstrap scripts
  wp_enqueue_script('bootbox', plugins_url('bootbox-master/bootbox.js', __FILE__), array('bootstrap_js', 'jquery'), null, true ); // add bootbox for popup windows
  wp_enqueue_script('script', plugins_url('script.js', __FILE__), array('jquery', 'bootstrap_js', 'bootbox'), null, true );  // __FILE__ in plugins_url !!!
  wp_set_script_translations('script', 'crp', plugin_dir_path(__FILE__) . 'lang/' );
  // new way to pass js variables (including nonce)
  wp_add_inline_script('script', 'const SCRIPT = ' . json_encode( array('ajaxurl' => admin_url('admin-ajax.php'), 'security' => wp_create_nonce("secure_nonce_name") ) ), 'after' );
  // old way to pass variables
//  wp_localize_script( 'script', 'crp', array('ajaxurl' => admin_url('admin-ajax.php') ) );
}

add_shortcode( 'crp-form', 'show_crp_form' );
function show_crp_form() {
    ob_start();
    ?>
    <div class="crp-form-wrapper">

    <form id="crp-form" method="post" action="">
      <h2 class="crp-form-header"><?php esc_html_e('Custom registration form', 'crp'); ?></h2>
      <br>
      <label for="login"><?php esc_html_e('Login:', 'crp'); ?></label>
      <input type="text" class="crp-inp" name="login"  id="login">
      <p class="error"><span class="login-error"></span></p>

      <label for="name"><?php esc_html_e('Name:', 'crp'); ?></label>
      <input type="text" class="crp-inp" id="name" name="name">
      <p class="error"><span class="name-error"></span></p>

      <label for="surname"><?php esc_html_e('Surname:', 'crp'); ?></label>
      <input type="text" class="crp-inp" id="surname" name="surname">
      <p class="error"><span class="surname-error"></span></p>

      <label for="email"><?php esc_html_e('Email:', 'crp'); ?></label>
      <input type="text" class="crp-inp" id="email" name="email">
      <p class="error"><span class="email-error"></span></p>

      <label for="password"><?php esc_html_e('Password:', 'crp'); ?></label>
      <input type="password" class="crp-inp" id="password" name="password">
      <p class="error"><span class="password-error"></span></p>

      <label for="confirm_password"><?php esc_html_e('Confirm password:', 'crp'); ?></label>
      <input type="password" class="crp-inp" name="confirm_password" id="confirm_password">
      <p class="error"><span class="confirm-password-error"></span></p>

<!--      creates hidden nonce form-->
<!--      --><?php //wp_nonce_field( 'crp-nonce-action', 'crp-nonce-field' ); ?>

      <input type="submit" name='crp-form-submit-btn' id="crp-form-submit-btn" value="<?php esc_attr_e('Register', 'crp'); ?>">

    </form>
    </div>
    <?php
    return ob_get_clean();
}

add_action( 'wp_ajax_register', 'crp_register_user' );
add_action( 'wp_ajax_nopriv_register', 'crp_register_user' );
function crp_register_user() {
    $login = $_POST['login'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // check nonce
   check_ajax_referer( 'secure_nonce_name', 'security' );
   // another way to do it (check value from hidden nonce form)
    //  if ( !isset( $_POST['crp-nonce-field']) || !wp_verify_nonce( $_POST['crp-nonce-field'], 'crp-nonce-action' ) ) {
    //      ?><!--<script>-->
  <!--        jQuery('#confPassword').after('<p class="error">Sorry, your nonce didn\'t verify!');-->
  <!--      </script>--><?php
//      wp_die();
//  }

    // check for empty fields
    $arr = compact('login', 'name', 'surname', 'email', 'password', 'confirm_password');
    foreach ($arr as $key=>$value) {
      if (empty($value)) {
        ?><script>
        place = '<?php echo $key; ?>'; // if we don't declare variable with let (var,const), it will be global and can be reassigned if there are many ajax calls
        jQuery('#' + place).after('<p class="error"><?php esc_html_e('This field must be filled!', 'crp'); ?></p>'); // here translation works well
        field = document.getElementById(place);
        field.classList.add('afterVal');
        </script><?php
        wp_die();
      }
    }

    // check if login exists
    if ( username_exists($login) ) {
      ?><script>
        jQuery('#login').after('<p class="error"><?php esc_html_e('Sorry, login is already in use. Try another!', 'crp'); ?></p>');
        log = document.getElementById('login'); // js variable without declaration for repeatable use (global behavior)
        log.classList.add('afterVal');
      </script><?php
       wp_die();
    }
    // check that email has correct format
    if ( ! filter_var( $_POST["email"], FILTER_VALIDATE_EMAIL
      ) ) {
      ?><script>
        jQuery('#email').after('<p class="error"><?php esc_html_e('Sorry, your email has a wrong format!', 'crp'); ?></p>');
        em = document.getElementById('email');
        em.classList.add('afterVal');
      </script><?php
      wp_die();
    }
    // check if email exists
    if ( email_exists($email) ) {
      ?><script>
        jQuery('#email').after('<p class="error"><?php esc_html_e('Sorry, email is already in use. Try another!', 'crp'); ?></p>');
        em1 = document.getElementById('email');
        em1.classList.add('afterVal');
      </script><?php
      wp_die();
    }
    // validate password
    $password_regex = "/^(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?%&*]).{1,}$/";
    if ( !preg_match($password_regex, $password) ) {
      ?><script>
      jQuery('#password').after('<p class="error">The password must contain only Latin letters, 1 number, and 1 character from the list ( # , % , & , * , ? )</p>');
      pass = document.getElementById('password');
      pass.classList.add('afterVal');
      </script><?php
      wp_die();
    }
    // check confirm password
    if ( $password !== $confirm_password ) {
      ?><script>
        jQuery('#confirm_password').after('<p class="error">Confirmation password field doesn\'t match your password!</p>');
     <!--add red borders to password fields-->
      pass = document.getElementById('password');
      pass.classList.add('afterVal');
      confPass = document.getElementById('confirm_password');
      confPass.classList.add('afterVal');
    </script>
    <?php
    wp_die();
  }

    // if validation successful, create user
    wp_create_user($login, $password, $email);
    //  send email to me with notification about new user
    $to = 'andmih666@gmail.com';
    $subj = 'new user';
    $body = 'validation successfull, user created!';
    $head = array( 'Content-Type: text/html; charset=UTF-8' );
    wp_mail($to, $subj, $body, $head);


    echo "redirect";
    // popup we transferred into script.js to see translation

  wp_die();
}
