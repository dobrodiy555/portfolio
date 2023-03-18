<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- external styles and scripts -->
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script src="index.js" defer></script>
  <!-- with defer work both datepicker and validate() -->

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

  <title>Create conference</title>
</head>

<body>
  <h1>Create new conference</h1>


  <form method="post" name="myForm" action="success.php" onsubmit="return validateForm()">
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" minlength="2" maxlength="255" class="form-control" id="title" name="title" placeholder="Enter title" required>
    </div>

    <label>Select Date: </label>
    <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
      <input class="form-control" type="date" id="date" name="date" required />
      <span class="input-group-addon">
        <i class="glyphicon glyphicon-calendar"></i>
      </span>
    </div>

    <br>

    <div class="form-group">
      <label>Enter city:</label>
      <br>
      <input type="text" minlength="2" maxlength="55" class="form-control" id="city" name="city" required>
    </div>

    <label>Select country: </label> <br>
    <select class="custom-select" name="country" style="width:150px;" required>
      <option>Ukraine</option>
      <option>Russia</option>
      <option>Belarus</option>
      <option>Poland</option>
      <option>Slovakia</option>
      <option>Lithuania</option>
      <option>Latvia</option>
      <option>Moldova</option>
      <option>Hungary</option>
      <option>Turkey</option>
    </select>

    <br> <br>

    <button type="submit" name="submit_create" class="btn btn-success">Save</button>
    <button onclick="history.back()" class=" btn btn-info">Back</button>

  </form>

  <!-- add jquery -->
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