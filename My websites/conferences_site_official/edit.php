<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- external styles and scripts -->
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script src="index.js" defer></script>

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">


  <title>Edit conference</title>
</head>

<body>

  <h1>Edit conference</h1>

  <form method="post" name="myForm" action="success.php" onsubmit="return validateForm()">

    <!-- create session to pass get variable into db.php -->
    <?php select_for_edit($_GET['title']);
    session_start();
    $_SESSION['conf_title'] = $_GET['title'];
    ?>
    <br> <br>

    <button type="submit" name="save_edit" class="btn btn-success">Save</button>

    <a id="delete_link"> <button type="button" name="delete_but" onclick="confirmDelete()" class="btn btn-danger">Delete</button></a>

    <button type="button" onclick="history.back()" class="btn btn-info">Back</button>

  </form>


  <!-- we need this f-n here bcs there is php inside -->
  <script>
    function confirmDelete() {
      if (confirm("Are you sure you want to delete this conference?")) {
        var a = document.getElementById('delete_link');
        a.href = "delete.php?title=<?php echo $_GET['title']; ?>";
      }
    }
  </script>

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
  </script>


</body>

</html>