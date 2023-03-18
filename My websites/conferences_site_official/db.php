<?php

function create_db()
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE groupBwt";
    $conn->exec($sql);
    echo "Db created!<br>";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
}

function create_table($tablename)
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE $tablename (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      date date NOT NULL,
      city VARCHAR(55) NOT NULL,
      country VARCHAR(55) NOT NULL
      )";
    $conn->exec($sql);
    echo "table created";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
}


function insert_conference_data($title, $date, $city, $country) // for page create.php
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO conference1 (title, date, city, country)
     VALUES ('$title', '$date', '$city', '$country')";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "<h2>New conference created successfully!</h2>";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
}


function select_for_edit($title)  // for edit.php
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $sql = "SELECT title, date, city, country FROM conference1 where title = '$title'"; //  нужны '' !!!
  $stmt = $conn->query($sql);
  $conf = $stmt->fetch();
  if ($conf) {
    echo '<div class="form-group">
    <label for="title">Title</label>
    <input type="text" minlength="2" maxlength="255" class="form-control" id="title" name="title" value="' . $conf['title'] . '" required />
  </div>

  <label>Select Date: </label>
  <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
    <input class="form-control" type="text" id="date" name="date" value="' . $conf['date'] . '" required/>
    <span class="input-group-addon">
      <i class="glyphicon glyphicon-calendar"></i>
    </span>
  </div>
  
  <br>

  <div class="form-group">
  <label>Enter city:</label>
  <br>
  <input type="text" minlength="2" maxlength="55" class="form-control" id="city" name="city" value="' . $conf['city'] . '" required>
</div>

  <label>Select country: </label> <br>
  <select class="custom-select" style="width:150px;" name="country" required>
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
  </select>';
  } else {
    echo "<h3>Sorry, not able to display conference details!</h3>";
  }
  $conn = null;
}

function update_conference_data($old_title, $new_title, $date, $city, $country) // for page edit.php
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id FROM conference1 WHERE title = '$old_title'";
    $stmt = $conn->query($sql);
    $conf = $stmt->fetch();
    if ($conf) {
      $conf_id = $conf['id'];
    } else {
      echo "error in the 1st part of update f-n";
    }
    $sql1 = "UPDATE conference1 SET title='$new_title', date='$date', city='$city', country='$country' WHERE id='$conf_id'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    echo "<h3>Conference updated successfully!</h3>";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }
  $conn = null;
}


function select_title_and_date() // for page index.php (list of conf-s)
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $sql = "SELECT title, date FROM conference1";
  $statement = $conn->query($sql);
  $conferences = $statement->fetchAll(PDO::FETCH_ASSOC);
  if ($conferences) {
    foreach ($conferences as $conference) {
      echo '<a href="details.php?title=' . $conference['title'] . '"><li class="list-group-item" id="title_list"><b>' . $conference['title'] . ':</b></a><span class="date"> &nbsp; &nbsp;' . $conference['date'] . '</span> &nbsp;&nbsp; <a id="' . $conference['title'] . '" class="delete_link_list"><button type="button"  name="delete_but" class="btn btn-danger list"> Delete </button></a>';
    }
  } else {
    echo "<h5>No available conferences!</h5>"; // check !
  }
  $conn = null;
}

function select_details_of_conference($title) // for page details.php
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $sql = "SELECT title, date, city, country FROM conference1 where title = '$title'"; //  нужны '' !!!
  $stmt = $conn->query($sql);
  $conf = $stmt->fetch();
  if ($conf) {
    echo '<li class="list-group-item"><b>Title: </b><span class="title_details">' . $conf['title'] . '</span> </li>
    <li class="list-group-item"><b>Date:</b> <span class="date_details">' . $conf['date'] . '</span></li>
    <li class="list-group-item"><b>City:</b> <span id="lat_details">' . $conf['city'] . '</span> </li>
    <li class="list-group-item"><b>Country:</b> <span class="country_details">' . $conf['country'] . '</span></li>';
  } else {
    echo "<h3>Sorry, not able to display conference details!</h3>";
  }
  $conn = null;
}

function delete_conference($title)
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM conference1 WHERE title='$title'";
    $conn->exec($sql);
    echo "<h3>Conference deleted successfully!</h3>";
  } catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
  }

  $conn = null;
}

function check_if_title_exists($title) // for create.php and edit.php, returns true if such conf title already exists in db
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "groupBwt";
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $sql = "SELECT * FROM conference1 WHERE title = '$title'";
  $statement = $conn->query($sql);
  $conf = $statement->fetch();
  if ($conf) {
    return true;
  }
  return false;
}
