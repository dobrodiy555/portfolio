jQuery(document).ready(function () {
    jQuery("#al-submit-btn").click(function() {
        var email = jQuery("#al-input-email").val();
        // alert(email);
        jQuery.ajax({
            type: "post",
            dataType: "html",
            url: alajax.ajaxurl,
            data: {action: 'send', email: email},
            success: function (resp) {
                jQuery("#resp").html(resp);
            },
            error: function () {
                alert('error!');
            }
        })
    })
})