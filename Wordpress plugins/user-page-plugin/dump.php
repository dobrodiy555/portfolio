<?php

//function show_setting_surname() {
//    ?>
<!---->
<!--    <input type="text" name="upp-surname" id="upp-surname" value="--><?php //echo get_option('upp-surname'); ?><!--" />-->
<!---->
<!--    --><?php
//}

//  function notice() {
//    if ( isset($_GET['page']) && $this->page_slug == $_GET['page'] && isset($_GET['settings-updated']) && true == $_GET['settings-updated'] ) {
//      echo '<div class="notice notice-success is-dismissible"><p>Data is saved!</p></div>';
//    }
//  }

//<!--        select will be in popup-->
//<!--        <select>-->
//<!--          <option value="trainee">Trainee</option>-->
//<!--          <option value="junior">Junior</option>-->
//<!--          <option value="middle">Middle</option>-->
//<!--          <option value="senior">Senior</option>-->
//<!--        </select>-->


// without class
//add_action( 'admin_menu', 'add_user_page_admin_menu' );
function add_user_page_admin_menu() {
  add_options_page( "User Page", "User Page Options", 'manage_options', 'upp-options', 'display' );
  function display() {
    ?>
    <div class="wrap">
      <h1>User Page plugin settings</h1>
      <form action="options.php" method="post">
        <?php
        settings_fields('upp-options-group');
        do_settings_sections('upp-options');
        submit_button();
        ?>
      </form>
    </div>
    <!--    <label>Name:-->
    <!--    <input type="text" name="upp-name" id="upp-name">-->
    <!--    </label><br>-->
    <!--    <label>Surname:-->
    <!--      <input type="text" name="upp-surname" id="upp-surname">-->
    <!--    </label>-->
    <?php
  }

  function settings() {

    register_setting( 'upp-options', 'name-option', 'sanitize_textarea_field' );
    register_setting( 'upp-options', 'surname-option', 'sanitize_textarea_field' );

    add_settings_section('upp-section-id', '', '', 'upp-options' );

    add_settings_field( 'name', 'Name:', 'show_setting_name', 'upp-options', 'upp-section-id' );
    add_settings_field( 'surname', 'Surname:', 'show_setting_surname', 'upp-options', 'upp-section-id' );
  }

  function show_setting_name() {
    ?>
    <!--    <label>Name:-->
    <input type="text" name="upp-name" id="upp-name" value="<?php echo get_option('upp-name'); ?>" />
    <!--    </label>-->
    <?php
  }

  function show_setting_surname() {
    ?>
    <!--    <label>Surname:-->
    <input type="text" name="upp-surname" id="upp-surname" value="<?php echo get_option('upp-surname'); ?>" />
    <!--    </label>-->
    <?php
  }

//  add_action( 'admin_init', 'settings' );
}


////else {
////  $field = get_option($option);
////  ?>
<!--<!--  <script>-->-->
<!--<!--    place = '-->--><?php ////echo $key; ?><!--//';-->
<!--//    field = '--><?php ////echo $field; ?><!--//';-->
<!--//    jQuery('#' + place + '-place').html(field);-->
<!--//  </script>-->
<!--//  --><?php


//?><!--<script>-->
<!--  jQuery('#email-error').html("<span id='email-error>Such email already exists!</span>");-->
<!--  </script>--><?php

//$email_option = get_option('upp-email');
//if ( email_exists($email_option) ) {
//  echo "<span id='email-error'>Such email already exists!</span>";
//
//}


  // old class
class MyOptionsPage {
  public $page_slug;
  public $option_group;

  function __construct()
  {
    $this->page_slug = 'upp-options';
    $this->option_group = 'upp-options-group';

    add_action( 'admin_menu', array($this, 'add'), 25 );
    add_action( 'admin_init', array($this, 'settings'), );
    add_action( 'admin_notices', array($this, 'notice') );
  }


  function add()
  {
    add_options_page("User Page Options", "User Page Options", 'manage_options', $this->page_slug, array($this, 'display') );
  }


  function display() {
    ?>
    <div class="upp-wrap">
      <h1>User Page plugin settings</h1>
      <form action="options.php" method="post">
        <?php
        settings_fields($this->option_group);
        do_settings_sections($this->page_slug);
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  function settings() {

    register_setting( $this->option_group, 'name-option', 'sanitize_textarea_field' ); // last parameter is validation f-n
    register_setting( 'upp-options', 'surname-option', 'sanitize_textarea_field' );

    add_settings_section('upp-section-id', '', '', $this->page_slug );

    add_settings_field( 'name', 'Name:', array($this, 'show_setting_name'), $this->page_slug, 'upp-section-id', array('label_for' => 'upp_name', 'name' => 'upp_name') );
//        add_settings_field( 'surname', 'Surname:', 'show_setting_surname', 'upp-options', 'upp-section-id' );
  }

  function show_setting_name( $args ) {
    $value = get_option($args['name']);
    printf(
            '<input type="text" name="%s" id="%s" value="%s" />',
            esc_attr($args['name']),
            esc_attr($args['name']),
            sanitize_text_field($value)
    );
    ?>

    <!--        <input type="text" name="upp-name" id="upp-name" value="--><?php //echo get_option('upp-name'); ?><!--" />-->

    <?php
  }

  function show_setting_surname() {
    ?>

    <input type="text" name="upp-surname" id="upp-surname" value="<?php echo get_option('upp-surname'); ?>" />

    <?php
  }

  function notice() {
    if ( isset($_GET['page']) && $this->page_slug == $_GET['page'] && isset($_GET['settings-updated']) && true == $_GET['settings-updated'] ) {
      echo '<div class="notice notice-success is-dismissible"><p>Data is saved!</p></div>';
    }
  }

}
//
//new MyOptionsPage();