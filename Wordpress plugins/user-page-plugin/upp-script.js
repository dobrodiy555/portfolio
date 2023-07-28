// for translation
const { __, _x, _n, _nx } = wp.i18n;

jQuery(document).ready(function () {
    jQuery("#upp-edit").click(function() {
        bootbox.dialog({
            title: 'Edit user info',
            message: '<label>Name: <input type="text" id="up-name" name="up-name" /></label><br><br><label>Surname: <input type="text" id="up-surname" name="up-surname" /></label><br><br><label>Nickname: <input type="text" id="up-nickname" name="up-nickname" /></label><br><br><label>Email: <input type="email" name="up-email" id="up-email" /></label><br><br><label>Telegram: <input type="text" name="up-telegram" id="up-telegram" /></label><br><br><label>Viber: <input type="text" name="up-viber" id="up-viber" /></label><br><br><label>Level of knowledge: <select name="up-level" id="up-level"><option value="trainee">Trainee</option><option value="junior">Junior</option><option value="middle">Middle</option><option value="senior">Senior</option></select></label>',
            size: 'large',
            onEscape: true,
            backdrop: true,
            buttons: {
                save: {
                    label: 'Save',
                    className: 'btn-success',
                    callback: function () {
                        // alert('callback called');
                        let name = document.getElementById('up-name').value;
                        let surname = document.getElementById('up-surname').value;
                        let nickname = document.getElementById('up-nickname').value;
                        let email = document.getElementById('up-email').value;
                        let telegram = document.getElementById('up-telegram').value;
                        let viber = document.getElementById('up-viber').value;
                        let level = document.getElementById('up-level').value;
                        // we can launch ajax right here
                        jQuery.ajax({
                            type: "post",
                            dataType: "html",
                            url: upp.ajaxurl,
                            data: {action: 'update', name:name, surname:surname, nickname:nickname, email:email, telegram:telegram, viber:viber, level:level},
                            success: function (resp) {
                                // alert('success');
                                jQuery(".upp-wrapper").append(resp);
                            },
                            error: function () {
                                alert('error during ajax');
                            }
                        })
                    }
                }
            },
        })
    })
})