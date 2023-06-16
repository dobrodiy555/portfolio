const { __, _x, _n, _nx } = wp.i18n; // necessary for translation !

jQuery(document).ready(function () {
    jQuery("#login-pl-submit").click(function() {
        var login = jQuery("#login-input").val();
        var password = jQuery("#password-input").val();
        jQuery.ajax({
            type: "post",
            dataType: "html",
            url: loginajax.ajaxurl,
            data: {action: 'sendform', login: login, password: password},
            success: function (resp) {
                jQuery("#form").html(resp);
                alert( __('Everything worked well!', 'login') ); // test script translation
            },
            error: function () {
                alert( __('error', 'login') );
            }
        })
    })
})