<?php
$path = preg_replace( '/wp-content.*$/', '', __DIR__ );
require_once( $path . 'wp-load.php' );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<style>
    .message-error {
        display:none;
    }
</style>
<body>
<div class="login-form-wrapper">
    <form method="post" action="">
    <h2>Login form</h2>
    <!--message if fields blank-->
    <p id="place_for_resp"></p>

    <label for="login-input">Login</label>
    <input name="login-input" id="login-input" type="text" value="" />
    <p><span class="message-error">...</span></p>

    <label for="password-input">Password</label>
    <input id="password-input" name="password-input" type="password" value="">
    <p><span class="message-error">...</span></p>

    <label for="remember-me-input">Remember Me</label>
    <input id="remember-me-input" type="checkbox">
    <br><br>

    <input name="login-pl-submit" id="login-pl-submit" type="submit" value="Login">
    </form>
</div>

<h2>Path section</h2>
<?php
echo "1) __FILE__ : <br>" . __FILE__;
echo "<br>";
echo "2) __DIR__ : <br>" . __DIR__;
echo "<br>";
echo "3) dirname(__FILE__) : <br>" . dirname(__FILE__); // the same as just __DIR__
echo "<br>";
echo "4) basename(__FILE__) : <br>" . basename(__FILE__);
echo "<br>";
echo "5) ABSPATH : <br>" . ABSPATH;
echo "<br>";
echo "6)  plugin_basename(__FILE__) : <br>" . plugin_basename(__FILE__);
echo "<br>";
echo "7) plugin_dir_path( __FILE__ ) : <br>" . plugin_dir_path( __FILE__ );
echo "<br>";
echo "8) plugins_url() : <br>" . plugins_url();
echo "<br>";
echo "9) plugin_dir_url(__FILE__) : <br>" . plugin_dir_url(__FILE__);
echo "<br>";
echo "10) WP_CONTENT_DIR : <br>" . WP_CONTENT_DIR;
echo "<br>";
echo "<br>";
$email = 'andmih666@qa.team';
$exists = email_exists($email);
if ($exists) {
  echo "<span style='color:red' class='error'>This email already exists! User with id $exists has it!</span>";
} else {
  echo "<span>" . __("This email is valid!", "al") . "</span>";
}


//echo home_url();
//echo "<br>";
//echo site_url();


$x = 'Как видите, эти профессионалы по-разному следят за своим здоровьем, и вам тоже нужно выработать свои способы поддержания здорового образа жизни. Сосредоточьтесь на тех больных точках своего здоровья и благополучия, которые вы хотите улучшить, и найдите способы внести небольшие изменения, которые могут иметь большое влияние на ваше самочувствие. Это может быть что-то столь же простое, как ежедневная прогулка для поддержания психического и физического здоровья, или столь же сложное, как пересмотр всего распорядка дня шаг за шагом. ';


$without_vowels = preg_replace('#[аоиуеэяиыюьъ\s]+#iu', '', $x); // and without spaces
$without_vowels1 = str_ireplace( array('а','о','и','у','э','я','и','ы','ю','ь', 'ъ', 'е'), '', $x );
echo "<p>$without_vowels</p>";
echo "<p>$without_vowels1</p>";

?>


<br><br>
<label for="al1-input-email">Enter your email:</label>
<input type="text" id="al1-input-email" class="al1-input-email" />
<br><br>
<button onclick="ValidateEmail()" id="al-submit-btn">Send</button>
<script>
  function ValidateEmail() {
    var inp = document.getElementById('al1-input-email').value;
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    let field = document.getElementById('al1-input-email');
    if (inp.match(validRegex)) {
      alert("Valid email address!");
      field.focus();
      return true;
    } else {
      alert("Invalid email address!");
      field.focus();
      return false;
    }
  }
</script>
</body>
</html>

<?php

//global $wpdb;
//$login = 'vasya';
//$password = 'ronnieosullivan666';
//    $login = trim($_POST['login-input']);
//    $password = trim($_POST['password-input']);
//    if ( empty($login) || empty($password) ) {
//        echo "<span class='resp_from_server'>Form fields must be filled!</span>";
//        exit();
//    }
//$user = get_user_by('login', $login);
//if ($user && wp_check_password($password, $user->data->user_pass, $user->ID)) {
//    $sql = "SELECT wpu.ID, wpu.user_login, wpu.user_pass, wpum.meta_key, wpum.meta_value  FROM `wp_users` AS `wpu` JOIN `wp_usermeta` AS `wpum` ON wpu.ID = wpum.user_id WHERE wpu.user_login = '$login'";
// add prepare stmt
//    if ($wpdb->last_error) {
//        echo "wpdb error: " . $wpdb->last_error;
//        exit();
//    }
//    $results = $wpdb->get_results($sql);
//    echo "<pre>"; print_r($results); echo "</pre>";


//      foreach ($results as $result) {
//        if ($result->meta_key === 'wp_capabilities') {
//          $str = $result->meta_value;
//          if ( str_contains($str, 'author') ) {
//            print('yes');
//          } else {
//            print('no');
//          }
//        $arr = unserialize($str);
//        $role = key($arr);
//        print($role);
//        };
//    }
//
//} else {
//  echo "password not match";
//}


//    wp_die();
//    if ($result) {
//        $user = get_user_by('login', $login);
//        if ($user && wp_check_password($password, $user->data->user_pass, $user->ID)) {
//            $role = $result->wp_capabilities;
//            if (str_contains($role, 'subscriber')) {
//                wp_redirect('http://localhost/wordpress/for-subscriber/', 301);
//                exit();
//            } else if (str_contains($role, 'author')) {
//                wp_redirect('http://localhost/wordpress/for-author/', 301);
//                exit();
//            } else if (str_contains($role, 'administrator')) {
//                wp_redirect('http://localhost/wordpress/for-admin/', 301 );
//                exit();
//            } else {
//                wp_redirect('http://localhost/wordpress/', 301 );
//                exit();
//            }
//        } else {
//            echo "<span class='resp_from_server'>Sorry, you entered the wrong password!</span>";
////
//        }
//    } else {
//        echo "<span class='resp_from_server'>Sorry, we could not find a user with such a login!</span>";




