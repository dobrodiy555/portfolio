<!DOCTYPE html>
<html>
<style>
  .error {
    color: red;
  }

  input[type=text] {
    width: 20%;
    padding: 8px 10px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  body {
    margin: 5px 20px;
    background-color: seashell;
  }
</style>


<body>
  <?php
  $start = $finish = $final = "";
  $err = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["start"]) || (empty($_POST["finish"]))) {
      $err = "Number is required";
    } else if (!is_numeric($_POST["start"]) || (!is_numeric($_POST["finish"]))) {
      $err = "Only numbers allowed!";
    } else {
      $start = $_POST["start"];
      $finish = $_POST["finish"];
      $final = rand($start, $finish);
    }
  }
  ?>

  <h1>Random Number Site</h1>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <p>Type the number to start from: </p> <input type="text" name="start" maxlength="20" value="<?php echo $start; ?>">
    <span class="error">* <?php echo $err; ?> </span>
    <br>
    <p>Type the number to finish on: </p> <input type="text" name="finish" maxlength="20" value="<?php echo $finish; ?>">
    <span class="error">* <?php echo $err; ?> </span>
    <br><br>
    <input type="submit" name="submit">
  </form>

  <?php
  echo "<h2>Your random number is:<h2>";
  echo $final;
  ?>

</body>

</html>