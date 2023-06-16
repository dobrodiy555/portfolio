 // for translation
const { __, _x, _n, _nx } = wp.i18n;

jQuery(document).ready(function ($) {
    $("#crp-form").submit(function(e) {
        e.preventDefault();
        let dataArr = $(this).serializeArray(); // will take all input values from form (with 'name' attribute!) into array of object
        // let dataString = $(this).serialize(); // you can use serialize() to make a string
        dataArr.push({"name":"security", "value": SCRIPT.security}); // our nonce that we passed in wp_add_inline_script
        dataArr.push({"name":"action", "value": "register"}); // insert 'action' for ajax into array of objects
        $.ajax({
            type: "post",
            dataType: "html",
            url: SCRIPT.ajaxurl,
            data: dataArr,
            success: function (resp) {
                // put this code here bcs in php script translation doesn't work
                if (resp === 'redirect') {
                    var alert = bootbox.alert( __('Thank you for registering on our website!', 'crp'), redirectUser ); // second parameter is callback f-n which works if user clicks 'ok'
                    alert.show();
                    setTimeout(function(){
                        alert.modal('hide');
                        redirectUser();
                    }, 5000); // in 5 sec will close popup and redirect
                    function redirectUser() {
                        window.location.replace("http://localhost/wordpress/");
                    }
                }
                $(".error").html(resp); // if in php I pointed out where to insert html code (using js or jquery), here it doesn't matter where to append to
            },
            error: function () {
                alert( __('error during ajax call!', 'crp') );
            }
         })
     })
})

// remove afterVal class (which gives red border) when focusing element
const inputs = document.querySelectorAll('.crp-inp');
inputs.forEach(el => el.addEventListener('focus', event => {
    el.classList.remove('afterVal');
}))
