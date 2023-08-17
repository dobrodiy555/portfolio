<?php
/*
Plugin Name:  woocommerce-discount-plugin
Description:  creates additional fields 'discount' and 'birthday' in Users->Edit user and then applies discount for this user
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
Text domain: wdp
Domain Path: /lang
*/

register_activation_hook( __FILE__, 'wdp_plugin_activate' );
register_deactivation_hook( __FILE__, 'wdp_plugin_deactivate' );

function wdp_plugin_activate() {
    flush_rewrite_rules();
}
function wdp_plugin_deactivate() {
    flush_rewrite_rules();
}

if ( in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) ) {
    if ( !class_exists('WP_Dynamic_Discounts') ) {

      class WP_Dynamic_Discounts {
            public function __construct() {
              add_action( 'edit_user_profile', array($this, 'show_discount'), 10, 1 );
              add_action( 'edit_user_profile_update', array($this, 'save_discount'), 10, 1 );
              add_filter( 'woocommerce_product_get_price', array($this, 'show_dynamic_price'), 10, 2 );
              add_action('show_user_profile', array($this, 'userMetaBirthdayForm')); // editing your own profile
              add_action('edit_user_profile', array($this, 'userMetaBirthdayForm')); // editing another user
              add_action('user_new_form', array($this, 'userMetaBirthdayForm')); // creating a new user
              add_action('personal_options_update', array($this, 'userMetaBirthdaySave'));
              add_action('edit_user_profile_update', array($this, 'userMetaBirthdaySave'));
              add_action('user_register', array($this, 'userMetaBirthdaySave'));
            }

          function userMetaBirthdayForm(WP_User $user) {
            ?>
            <h2>Birthday</h2>
            <table class="form-table">
              <tr>
                <th><label for="user_birthday">Birthday</label></th>
                <td>
                  <input
                          type="date"
                          value="<?php echo esc_attr(get_user_meta($user->ID, 'birthday', true)); ?>"
                          name="user_birthday"
                          id="user_birthday"
                  >
                  <span class="description">Some description to the input</span>
                </td>
              </tr>
            </table>
            <?php
          }

          function userMetaBirthdaySave($userId) {
            if (!current_user_can('edit_user', $userId)) {
              return;
            }

            update_user_meta($userId, 'birthday', $_REQUEST['user_birthday']);
          }

            public function show_discount($user) {
                ?>
                <table>
                  <tr>
                    <th>Discount</th>
                    <td>
                      <input type="number" id="show_discount" name="show_discount" min="0" max="100" value="<?php echo get_user_meta($user->ID, 'show_user_discount', true)  ?>">
                    </td>
                    <?php
              // dobrodiy (admin) can add discount percent in the additional field 'discount' in admin 'Users->Edit user', and then this user will see discounted price near the product (only new price, without 'sale', crossing out old price or smth like this)
                    if ( ! current_user_can( 'edit_user') ) { ?>
                    <td>
                      <input type="submit" id="submit" name="submit">
                    </td>
                    ?>
                  </tr>
                </table>
                <?php
                }
            }

            public function save_discount($user) {
                if (!current_user_can('edit_user')) {
                    return false;
                }
                if (isset($_POST['show_discount'])) {
                    $show_user_discount = $_POST['show_discount'];
                    update_user_meta($user, 'show_discount', $show_user_discount);
                }
            }

            public function show_dynamic_price($price, $product) {
                $current_user_id = get_current_user_id();
                $discount = floatval( get_user_meta($current_user_id, 'show_discount', true) );
                if ( !empty($discount) ) {
                    $dynamic_price = $price - (($price * $discount) / 100);
                    return $dynamic_price;
                } else {
                  return $price;
                }
            }

        }
    }
}

new WP_Dynamic_Discounts();