<?php

// this is my universal class for adding options page to admin Settings->

class MyOptions {
    public string $page_slug;
    public string $option_group;
    public string $option_name;
    public int|string $section_id;
    public string $field_name;

    function __construct($page_slug, $option_group, $option_name, $section_id)
    {
        $this->page_slug = $page_slug;
        $this->option_group = $option_group;
        $this->option_name = $option_name;
        $this->section_id = $section_id;

        add_action( 'admin_menu', array($this, 'add'), 25 );
        add_action( 'admin_init', array($this, 'settings'), );
    }


    function add()
    {
        add_options_page( ucfirst($this->page_slug), ucfirst($this->page_slug), 'manage_options', $this->page_slug, array($this, 'display') );
    }


    function display() {
        ?>
        <div class="myOptions-wrap">
            <h1><?php echo get_admin_page_title(); ?></h1>
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
        register_setting( $this->option_group, $this->option_name, array($this, 'validate') ); // last parameter is validation f-n

        add_settings_section($this->section_id, '', '', $this->page_slug );

        add_settings_field( $this->option_name, ucfirst($this->option_name), array($this, 'show_setting_field'), $this->page_slug, $this->section_id, array('label_for' => $this->option_name) );
    }

    function show_setting_field( $args ) {
      printf(
              '<input type="text" name="%s" id="%s" value="%s" />',
              esc_attr($args['label_for']),
              esc_attr($args['label_for']),
              esc_attr( get_option($args['label_for']) )
      );
    }

  // validation fun-s
  function validate($value) {
    if ( mb_strlen($value) < 3 ) {
      add_settings_error(
              $this->option_group . '_errors',
              'test',
              "Field should have more than two symbols!",
              'error'
      );
      return $value;
     }
      if ( !ctype_alpha($value) ) {
          add_settings_error(
              $this->option_group . '_errors',
              'test',
              "Fields should have only letters!",
              'error'
        );
       }
    return $value;
  }
}

//$my_options = new MyOptions('my-options-page', 'my-options-group', 'my-options-nickname', 'my-options-section');
