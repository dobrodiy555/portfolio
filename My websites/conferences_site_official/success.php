<?php require "db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="style.css" />
  <title>Success</title>
</head>

<body>

  <?php

  if (isset($_POST['submit_create'])) {
    $title = $_POST['title'];
    if (!check_if_title_exists($title)) {
      $date = $_POST['date'];
      $city = $_POST['city'];
      $country = $_POST['country'];
      insert_conference_data($title, $date, $city, $country);
    } else {
      echo "<h3>Sorry, conference with such name already exists!</h3>";
    }
  }


  if (isset($_POST['save_edit'])) {
    session_start();
    $old_title = $_SESSION['conf_title'];
    $new_title = $_POST['title'];
    if ($old_title != $new_title) { // check only if we changed title
      if (check_if_title_exists($new_title)) {
        echo "<h3>Sorry, conference with such name already exists!</h3>";
      }
    } else {
      $date = $_POST['date'];
      $city = $_POST['city'];
      $country = $_POST['country'];
      update_conference_data($old_title, $new_title, $date, $city, $country);
    }
  }
  ?>

  <br>
  <!-- кнопка через ссылку -->
  <a href='index.php'><button type='button' class='btn btn-info'>List of conferences</button></a>

</body>

</html>