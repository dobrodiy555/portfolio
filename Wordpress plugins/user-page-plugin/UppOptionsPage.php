<?php

class UppOptionsPage {
    public $name;
    public $surname;
    public $nickname;
    public $email;
    public $telegram;
    public $viber;
    public $level;
    public $option_group;

    function __construct()
    {
        $this->name = 'upp-name';
        $this->surname = 'upp-surname';
        $this->nickname = 'upp-nickname';
        $this->email = 'upp-email';
        $this->telegram = 'upp-telegram';
        $this->viber = 'upp-viber';
        $this->level = 'upp-level';

        $this->option_group = 'upp-options-group';

        add_action( 'admin_menu', array($this, 'add'), 25 );
        add_action( 'admin_init', array($this, 'settings'), );
    }

    function add()
    {
        add_options_page("User Page Options", "User Page Options", 'manage_options', $this->option_group, array($this, 'display') );
    }

    function display() {
        ?>
        <div class="upp-wrap">
            <h1>User Page plugin settings</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields($this->option_group);
                do_settings_sections($this->option_group);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    function settings() {

        register_setting( $this->option_group, $this->name, array($this, 'validate') );
        register_setting( $this->option_group, $this->surname, array( 'sanitize_callback' => array($this, 'validate') ) ); // last parameter is validation f-n, it can be as string or array
        register_setting( $this->option_group, $this->nickname, 'sanitize_text_field' );
        register_setting( $this->option_group, $this->email, array( 'sanitize_callback' => array($this, 'is_correct_email') ) );
        register_setting( $this->option_group, $this->telegram, 'sanitize_text_field' );
        register_setting( $this->option_group, $this->viber, 'sanitize_text_field' );
        register_setting( $this->option_group, $this->level );

        add_settings_section('upp-section-id', '', '', $this->option_group );

        add_settings_field( $this->name, 'Name:', array($this, 'show_option'), $this->option_group, 'upp-section-id', array('label_for' => $this->name) );
        add_settings_field( $this->surname, 'Surname:', array($this, 'show_option'), $this->option_group, 'upp-section-id', array('label_for' => $this->surname) );
        add_settings_field( $this->nickname, 'Nickname:', array($this, 'show_option'), $this->option_group, 'upp-section-id', array('label_for' => $this->nickname) );
        add_settings_field( $this->email, 'Email:', array($this, 'show_option'), $this->option_group, 'upp-section-id', array('label_for' => $this->email) );
        add_settings_field( $this->telegram, 'Telegram:', array($this, 'show_option'), $this->option_group, 'upp-section-id', array('label_for' => $this->telegram) );
        add_settings_field( $this->viber, 'Viber:', array($this, 'show_option'), $this->option_group, 'upp-section-id', array('label_for' => $this->viber) );
        add_settings_field( $this->level, __('Level of knowledge:', 'upp'), array($this, 'show_select'), $this->option_group, 'upp-section-id', array('label_for' => $this->level) );
    }

    function show_option($args) {
        printf(
            '<input type="text" name="%s" id="%s" value="%s" />',
            $args['label_for'],
            $args['label_for'],
            esc_attr( get_option($args['label_for']) )
        );
    }

    function show_select($args) {
        $value = get_option($args['label_for']);
        if ($value == 'junior') {
            printf(
                '<select name="%s" id="%s">
          <option value="trainee">Trainee</option>
          <option value="junior" selected>Junior</option>
          <option value="middle">Middle</option>
          <option value="senior">Senior</option>
      </select>',
                $args['label_for'],
                $args['label_for']
            );
        } else if ($value == 'middle') {
            printf(
                '<select name="%s" id="%s">
          <option value="trainee">Trainee</option>
          <option value="junior">Junior</option>
          <option value="middle" selected>Middle</option>
          <option value="senior">Senior</option>
       </select>',
                $args['label_for'],
                $args['label_for']
            );
        } else if ($value == 'senior') {
            printf(
                '<select name="%s" id="%s">
          <option value="trainee">Trainee</option>
          <option value="junior">Junior</option>
          <option value="middle">Middle</option>
          <option value="senior" selected>Senior</option>
      </select>',
                $args['label_for'],
                $args['label_for']
            );
        } else {
            printf(
                '<select name="%s" id="%s">
          <option value="trainee">Trainee</option>
          <option value="junior">Junior</option>
          <option value="middle">Middle</option>
          <option value="senior">Senior</option>
      </select>',
                $args['label_for'],
                $args['label_for']
            );
        }
    }

    // validation fun-s
    function validate($value) {
        if ( mb_strlen($value) < 3 ) { // check on emptiness too
            add_settings_error(
                $this->option_group . '_errors',
                'test',
                "Name and surname should have more than two symbols!",
                'error'
            );
        }
        if ( !ctype_alpha($value) ) {
            add_settings_error(
                $this->option_group . '_errors',
                'test',
                "Name and surname should have only letters!",
                'error'
            );
        }
        return $value;
    }

    function is_correct_email($value) {
        if ( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
            add_settings_error(
                $this->option_group . '_errors',
                'email error',
                "Email has a wrong format!",
                'error'
            );
        }
        if ( email_exists($value) ) {
            add_settings_error(
                $this->option_group . '_errors',
                'email error',
                'Email already exists!',
                'error'
            );
        }
        return $value;
    }
}