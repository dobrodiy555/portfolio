jQuery(document).ready(function () {
  setTimeout(showPopup, 30000); // after 30 sec
})

function showPopup() {
  bootbox.confirm({
    size: "large",
    buttons: {
      confirm: {
        label: 'Да',
        className: 'btn-success btn-xlarge'
      },
      cancel: {
        label: 'Нет',
        className: 'btn-danger btn-xlarge'
      }
    },
    message: "<h1 style='text-align: center'><b>Хотите записаться на курс?</b></h1>",
    centerVertical: true, // по центру экрана
    swapButtonOrder: true, // поменять местами кнопки
    callback: function(res) {
      if (res) { // if btn Yes is clicked (res === true)
        window.location.href = "http://localhost/wordpress/application-form/";
      }
    }
  })
}





