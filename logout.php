<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><title>Logout</title>
</head>
<body>
<?php
session_start();
// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
<div class="main">
<?php include("header.php"); ?>
<div class="mainContent">
<div class="login">

<?php
if(isset($_SESSION['user'])){
echo '<h1>Logging out .... </h1>';
unset($_SESSION['user']);

if(isset($_SESSION['username'])){
unset($_SESSION['username']);
}
if(isset($_SESSION['login'])){
unset($_SESSION['login']);
}
// wait 5 seconds and redirect :)
header( "refresh:3;url=".$_SERVER['HTTP_REFERER']);
} else{
echo '<h1>Already logged out</h1>';
header( "refresh:3;url=".$_SERVER['HTTP_REFERER']);
}
?>
</div> <!--login-->
</div><!--mainContent-->
<div class="footer">
</div><!--footer-->
</div> <!--main-->	
</body>
</html>
