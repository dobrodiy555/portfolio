// for translation
const { __, _x, _n, _nx } = wp.i18n;

jQuery(document).ready(function ($) {
    // jquery form validation
    $('#cv-form').validate({
        errorElement: "p", // instead of default <label>
        errorClass: "invalid",
        validClass: "valid", // 'valid' class is default even if we don't specify it here
        rules: {
            name: {
                required: true,
                minlength: 3, // not minLength !!!
                maxlength: 20
            },
            surname: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            email: {
                required: true,
                email: true
            },
            file: {
                required: true
            }
        },
        // if you need not default browser messages
        messages: {
            name: {
                maxlength: __("Имя должно быть максимум 20 символов!", 'cv'),
            }
        },
      // what will happen after successful validation, call ajax
      submitHandler: function(form) {
          // no need for preventDefault here
          let nonce = cv.security; // take from wp_localize_script()
          // as we have file, serialize() won't work here, we need special FormData object
          var formData = new FormData(form);
          // add ajax action and nonce to the object
          formData.append('action', 'cvgo');
          formData.append('security', nonce);
          $.ajax({
              type: "post",
              dataType: "html",
              // enctype: 'multipart/form-data', // in some cases doesn't work without it
              url: cv.ajaxurl,
              data: formData, // !!!
              contentType: false, // necessary if we send files
              processData: false, // necessary if we send files
              success: function (resp) {
                  // put this code here bcs in php script translation doesn't work
                  if (resp === 'popup-redirect') {
                      var alert = bootbox.alert( __('Thank you. Our managers will contact you during the day!', 'cv'), redirectUser );
                      alert.show();
                      setTimeout(function () {
                          alert.modal('hide');
                          redirectUser();
                      }, 5000); // in 5 sec will close popup and redirect automatically
                      function redirectUser() {
                          window.location.href = "http://localhost/wordpress/";
                      }
                  } else {
                      $(".error").html(resp);
                  }
              },
              error: function () {
                  alert(__('error during ajax call!', 'cv'));
              }
          })
      }
    });
})




