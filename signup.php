<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="js/main.js"></script>
<title>Register</title>
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
<?php include("scripts/header.php"); ?>
<div class="mainContent">
<div class="signup_wrapper">
<div class="signup">
<?php
if(isset($_SESSION['user'])){
echo "<h3> You are already logged in as, " . $_SESSION['username'] . "</h3>";
} else{
echo '
<h1>Signup to Tar Heel Gallery</h1>
<form method="post" action="signup.php">
<p><input type="text" name="first" value="" placeholder="First Name"></p>
<p><input type="text" name="last" value="" placeholder="Last Name"></p>
<p><input type="text" name="login" value="" placeholder="Username"></p>
<p><input type="password" name="password" value="" placeholder="Password"></p>
<p><input type="text" name="email" value="" placeholder="Email"></p>
<p class="submit"><input type="submit" name="commit" value="Register"></p>
</form></div> ';

if(empty($_POST["first"])){
echo "<p>First name Required</p>";
} else if(empty($_POST["login"])){
echo "<p>Username Required</p>";
} else if (empty($_POST["password"])){
echo "<p>Password Required</p>";
} else if (empty($_POST["email"])){
echo "<p>Email Required</p>";
} else{
$first = mysqli_real_escape_string($con,$_POST["first"]);
$last = mysqli_real_escape_string($con,$_POST["last"]);
$username = mysqli_real_escape_string($con,$_POST["login"]);
$password = mysqli_real_escape_string($con,$_POST["password"]);
$email = mysqli_real_escape_string($con,$_POST["email"]);
$day = date("Y-m-d");
$result = mysqli_query($con,"SELECT * FROM User WHERE login = '". $username ."' ");
if (mysqli_num_rows($result) == 0) {
	$sql = "INSERT INTO User (id,first, last, login, password, email, created, profilepic)
	VALUES ('null','$first', '$last', '$username', '$password', '$email', '$day', 4)";
	if (!mysqli_query($con,$sql))
  {
  echo "MYSQL error";
  }
?>
<script type="text/javascript">
$('.signup').remove();
</script>
<?php
  echo "<p>Registration Succesful</p>";
  echo "<p>You will be automatically logged in and refered back to the homepage</p>";
  $_SESSION['user'] =  $row['first'];
  $_SESSION['username'] = $row['login'];
  $_SESSION['login'] = "true";
  $_SESSION['id'] = $row['id'];
  
  header( "refresh:3;url=index.php" );
  
} else{
echo "<p>Username Already Exists</p>";
}
}
}
?>
</div> <!--login-->
</div><!--mainContent-->
<div class="footer">
</div><!--footer-->
</div> <!--main-->	
</body>
</html>
