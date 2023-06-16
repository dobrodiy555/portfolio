<?php
/*
Plugin Name:  my-notes-plugin
Description:  Выводит в Dashboard (прокрутить вниз) виджет с заметками.
Version:      1.0
Author:       Andrei Miheev
License:      GPL2
*/

// adding widget to dashboard
add_action( 'wp_dashboard_setup', 'my_notes_dashboard_widget' );
function my_notes_dashboard_widget() {
	if ( current_user_can('activate_plugins') ) {
		wp_add_dashboard_widget( 'my-notes', 'My notes', 'my_notes_form' ); // widget will have div id='my_notes'
	}
}

// frontend in dashboard
function my_notes_form() {
	?>
	<form id="my-notes-form">
    <span id="my-notes-message"></span>
		<textarea name="my-notes-content" id="my-notes-content"><?php echo esc_textarea( get_option('my_notes_content') );?></textarea>
		<button type="reset" class="clear button button-secondary">Clear</button>
		<?php
    submit_button(null, 'primary', 'submit-my-notes', false ); // u can add submit btns in such way only in admin area
    ?>
	</form>
	<?php
}

// ajax
add_action( 'admin_print_scripts', 'my_notes_scripts', 999 );
function my_notes_scripts() {
  global $screen;
  // if it's not a main page, stop the fun-n
  if ( empty($screen->base) || 'dashboard' != $screen->base ) {
    return;
  }
  ?>
  <style>
    #my-notes textarea {
      width: 100%;
      min-height: 150px;
      margin-bottom: 5px;
    }
  </style>
  <script>
    jQuery(document).ready(function($) {

      $('.clear').click(function () {
        $('#my-notes-content').text(''); // make empty textarea
        $('#my-notes-message')
                .text("Field is cleared. Don't forget to save the result!")
                .css('color', 'orangered');
      });

      // remove previous message when user starts writing something again
      $('#my-notes-content').focus(function () {
        $('#my-notes-message').text('');
      })

      $('#my-notes-form').submit(function(e) {
        e.preventDefault();
        // alert('ajax called')
        var content = $('#my-notes-content').val();
        var security = '<?php echo wp_create_nonce('my-notes-nonce') ?>';
        var data = {
          action: 'my_notes',
          security: security,
          content: content,
        }
        console.log(data) // test whether correct data

        // short version with .post()
        //var url = '<?php //echo admin_url('admin-ajax.php'); ?>//';
        //$.post( url, data, function(response) {
        //   if ( true === response.success ) { // if using json
        //     $('#message')
        //             .text(response.data.message)
        //             .css('color', 'green');
        //   }
        //} );

       // long version with .ajax()
         $.ajax({
          type: "POST",
          url:  '<?php echo admin_url('admin-ajax.php'); ?>',
          data: data,
          // data: "content=" + content + '&action=my_notes' + "&security=" + security, // for GET request
          dataType: "json", // even without it works
          success: function(response) {
            console.log(response);
            if ( true === response.success ) { // if using wp_send_json_success()
              $('#my-notes-message')
                      .text(response.data.message)
                      .css('color', 'green');
            }
          },
          error: function(error) {
            console.log(error);
            // alert( JSON.stringify(error, null, 4) ); // to see object content in alert
            $('#my-notes-message')
                    .text("Error happened, try again!" + error) // u may use not json, just html
                    .css('color', 'red');
          }
         });
      });
    })
  </script>
  <?php
}

// server side
add_action( 'wp_ajax_my_notes', 'my_notes_ajax_save');
function my_notes_ajax_save() {
	check_ajax_referer( 'my-notes-nonce', 'security');
    if ( !current_user_can('activate_plugins') ) {
		  return;
	  }
	  $notes_content = $_POST['content'];
	  $status = update_option('my_notes_content', $notes_content, false );
	  if ($status) {
		  wp_send_json_success( ['message' => 'Note is saved'] ); // wp_die() works automatically with this f-n
	  } else {
		  wp_send_json_error( ['message' => "Note hasn't been changed"] );
	  }
//  wp_die(); // no need to use
}









