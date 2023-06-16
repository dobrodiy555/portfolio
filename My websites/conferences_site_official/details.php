<!-- страница с деталями конференции -->

<?php require 'db.php'; ?>

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

  <title>Details</title>


</head>

<body>

  <h1> Details of a conference </h1>

  <ul class="list-group">

    <?php select_details_of_conference($_GET['title']); ?>

  </ul>

  <br>

  <a href="edit.php?title=<?= $_GET['title']; ?>"><button type="button" class="btn btn-success">Edit conference</button></a>

  <a id="delete_link"> <button type="button" name="delete_but" onclick="confirmDelete()" class="btn btn-danger"> Delete conference </button></a>

  <!-- we need this f-n here bcs there is php inside -->
  <script>
    function confirmDelete() {
      if (confirm("Are you sure you want to delete this conference?")) {
        var a = document.getElementById('delete_link');
        a.href = "delete.php?title=<?php echo $_GET['title']; ?>";
      }
    }
  </script>


</body>

</html>