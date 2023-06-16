function validateForm() {
  // check title
  let date = document.getElementById("date");
  console.log(date);
  let x = document.forms["myForm"]["title"].value;
  let y = document.forms["myForm"]["city"].value;
  // console.log(x);
  var specialChars = /[^a-zA-Zа-яёї0-9-' ]/g;
  if (x.match(specialChars)) {
    alert("No special characters in 'Title' allowed!");
    return false;
  }
  if (y.match(specialChars)) {
    alert("No special characters in 'City' allowed!");
    return false;
  }

  // check that date is not in the past
  var selText = document.getElementById('date').value;
  var selDate = new Date(selText);
  var now = new Date();
  now.setDate(now.getDate() - 1);
  if (selDate < now) {
    alert("Date of conference cannot be in the past!");
    return false;
  }
}

// jquery for index.php deletion
$('.delete_link_list').click(function() {
    if (confirm("Are you sure you want to delete this conference?")) {
      var x = $(this).attr("id");
      $(this).attr("href", "delete.php?title=" + x); 
    }
  }
)

// jquery datepicker
$(function() {
      $("#datepicker").datepicker({
        autoclose: true,
        todayHighlight: true,
      }).datepicker("setDate");
    });


  
    


