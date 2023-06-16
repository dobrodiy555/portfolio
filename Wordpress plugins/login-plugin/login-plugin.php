<?php
/*
Plugin Name: login-plugin
Description: creates shortcode which shows login form with some validation, also translates scripts
Text Domain: login
Domain Path: /lang
*/

// строки для перевода заголовков плагина, чтобы они попали в .po файл.
__( 'login-plugin', 'login' );
__( 'creates shortcode which shows login form with some validation', 'login' );

// add translation domain
add_action( 'plugins_loaded', 'login_load_textdomain' );
function login_load_textdomain() {
  load_plugin_textdomain( 'login', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}

add_shortcode( 'show-login-form', 'login_show_login_form' ); // [show-login-form] is our shortcode

// add style
add_action( 'wp_enqueue_scripts', 'login_add_style' );
function login_add_style() {
    wp_enqueue_style( 'style', plugins_url('style.css', __FILE__), false, null, 'all' );
}

// add script and translation of it
add_action( 'wp_enqueue_scripts', 'login_enqueue_script' );
function login_enqueue_script() {
  wp_enqueue_script( 'script', plugins_url('script.js', __FILE__), array('wp-i18n'), false, true );
  wp_set_script_translations( 'script', 'login', plugin_dir_path(__FILE__) . 'lang/' ); // правильно указать path !
  wp_localize_script( 'script', 'loginajax', array(
        'ajaxurl' => admin_url('admin-ajax.php')
        )
    );
}

function login_show_login_form() {
    ob_start();
    ?>
    <div class="login-form-wrapper">
        <h2 id="pl-form-header"><?php _e('Login form', 'login'); ?></h2>

        <!--message if fields blank-->
        <p id="place-for-error"></p>

        <label for="login-input"><?php _e('Login', 'login'); ?></label>
        <input name="login-input" id="login-input" type="text" />
        <p><span class="message-error">...</span></p>

        <label for="password-input"><?php _e('Password', 'login'); ?></label>
        <input id="password-input" type="password">
        <p><span class="message-error">...</span></p>

        <label for="remember-me-input"><?php esc_html_e('Remember Me', 'login'); ?></label>
        <input id="remember-me-input" type="checkbox">
        <br><br>

        <input name="login-pl-submit" id="login-pl-submit" type="submit" value="Login">
    </div>
    <?php
    return ob_get_clean();
}

add_action( 'wp_ajax_sendform', 'decide_which_page_to_show' );
function decide_which_page_to_show() {
        global $wpdb;
        $login = $_POST['login']; // read it not from form but from ajax (script.js)
        $password = $_POST['password'];
        // check that both fields are filled
        if ( empty($login) || empty($password) ) {
            echo "<p class='resp-for-both'>" . __('Form fields must be filled!', 'login') . "</p>";
        ?>
        <script>
          // const { __, _x, _n, _nx } = wp.i18n; if we put it here, not working
          // remove previous messages from server if they are
          let prevInfo = document.querySelector('.resp-for-pass');
          let prevInfo1 = document.querySelector('.resp-for-login');
          if (prevInfo) {
            prevInfo.remove();
          }
          if (prevInfo1) {
            prevInfo1.remove();
          }
          let element = document.getElementById('place-for-error');
          let response = document.querySelector('.resp-for-both');
          element.append(response);
          // alert(__('this information should be translated!', 'login')); // we can't put here, poedit doesn't see it
        </script>
        <?php
            exit();
        }
        // check that user with such login exists
        $user = get_user_by('login', $login);
        if (!$user) {
          echo "<span class='resp-for-login'>" . __('Sorry, we could not find a user with such a login!', 'login') . "</span>";
        ?>
        <script>
          // delete message from password valid-n if exists
          let prevMess = document.querySelector('.resp-for-pass');
          if (prevMess) {
            prevMess.style.display = 'none';
          }
          // message from both also hide
          let prevRespFromBoth = document.querySelector('.resp-for-both');
          if (prevRespFromBoth) {
            prevRespFromBoth.style.display = 'none';
          }
          // add class that makes field red
          let elem = document.getElementById('login-input');
          elem.classList.add("warning"); // add class 'warning' which makes it red
          setTimeout(function() {
            elem.classList.remove("warning");
          }, 5000); // remove red border in 5 sec
          let resp = document.querySelector('.resp-for-login');
          elem.after(resp);
        </script>
        <?php
          exit();
        }
        // check that user with such login has such password
        if ( wp_check_password($password, $user->data->user_pass, $user->ID) ) {
          $table = $wpdb->prefix . 'users'; // table wp_users
          $table1 = $wpdb->prefix . 'usermeta'; // table wp_usermeta
          $sql = $wpdb->prepare("SELECT wpu.ID, wpum.meta_key, wpum.meta_value  FROM $table AS `wpu` JOIN $table1 AS `wpum` ON wpu.ID = wpum.user_id WHERE wpu.user_login = %s", $login );
          $results = $wpdb->get_results($sql);
          if ($results) {
            foreach ($results as $result) {
              if ($result->meta_key === 'wp_capabilities') {
                $str = $result->meta_value; // it is serialized string
                if ( str_contains($str, 'author') ) {
                  ?>
                  <script>
                    window.location.replace('http://localhost/wordpress/for-subscriber/') // doesn't save history, can't go back to prev page
                  </script>
                  <?php
                  exit(); // necessary after each redirect
                } else if ( str_contains($str, 'administrator') ) {
                  ?>
                  <script>
                    window.location.href = "http://localhost/wordpress/for-admin/"; // saves history (can go back)
                  </script>
                  <?php
                  exit();
                } else if ( str_contains($str, 'subscriber') ) {
                  ?>
                  <script>
                    window.location.replace( "http://localhost/wordpress/for-subscriber/");
                  </script>
                  <?php
                  exit();
                }
              }
            }
          }
        } else {
            echo "<span class='resp-for-pass'>" . __("Sorry, you entered the wrong password!", "login") . "</span>";
          ?>
          <script>
            let prevResp = document.querySelector('.resp-for-login');
            if (prevResp) {
              prevResp.style.display = 'none';
            }
            // delete response from both if exists
            let prevResp1 = document.querySelector('.resp-for-both');
            if (prevResp1) {
              prevResp1.style.display = 'none';
            }
            let elem1 = document.getElementById('password-input');
            elem1.classList.add("warning");
            setTimeout(function() {
              elem1.classList.remove("warning");
            }, 5000);
            let resp1 = document.querySelector(".resp-for-pass");
            elem1.after(resp1);  // show response message after password form
          </script>
          <?php
        }
  wp_die(); // necessary when ajax works !
}


