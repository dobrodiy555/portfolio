<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
  <style>
    body
    {
      margin:0 auto;
      padding:0px;
      text-align:center;
      width:100%;
      font-family: "Myriad Pro","Helvetica Neue",Helvetica,Arial,Sans-Serif;
      background-color:#34495E;
    }
    #wrapper
    {
      margin:0 auto;
      padding:0px;
      text-align:center;
      width:995px;
    }
    #wrapper h1
    {
      margin-top:50px;
      font-size:45px;
      color:#FDF2E9;
    }
    #wrapper h1 p
    {
      font-size:18px;
    }
    #text_div input[type="text"]
    {
      width:300px;
      height:35px;
      padding:10px;
    }
    #text_div input[type="submit"]
    {
      width:100px;
      height:35px;
      margin-top:5px;
      background:none;
      border:1px solid white;
      color:white;
      font-weight:bold;
    }
    #text_div img
    {
      width:200px;
    }
  </style>
</head>
<body>

<div id="wrapper">
  <div id="text_div">
    <form method="post" action="">
      <input type="text" name="img_url" placeholder="Enter Image URL">>
      <input type="submit" name="get_image" value="Submit">
    </form>
  </div>
</div>

</body>
</html>


<?php
if (isset($_POST['get_image']))
{
  $url=$_POST['img_url'];
  $data = file_get_contents($url);
  $new = 'images/new_image.jpg';
  file_put_contents($new, $data);
  echo "<img src='images/new_image.jpg'>";
}



