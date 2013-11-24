<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><title>Login</title>
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
<div class="login_wrapper">
<div class="login">
<?php
if(isset($_SESSION['user'])){
echo "<h3> You are logged in as, " . $_SESSION['username'];
} else{
echo '
<h1>Login to Tar Heel Gallery</h1>
<form method="post" action="login.php">
<p><input type="text" name="login" value="" placeholder="Username"></p>
<p><input type="password" name="password" value="" placeholder="Password"></p>
<p class="submit"><input type="submit" name="commit" value="Login"></p>
</form> </div>';

if(empty($_POST["login"])){
echo "Username Required";
} else if (empty($_POST["password"])){
echo "Please enter password";
}
else{
$username = mysqli_real_escape_string($con, $_POST["login"]);
$password = mysqli_real_escape_string($con,$_POST["password"]);
$result = mysqli_query($con,"SELECT * FROM User WHERE login = '". $username ."' ");
if (mysqli_num_rows($result) == 0) {
    echo 'Invalid Username ';
} else{
$row = mysqli_fetch_array($result);
if($row['password'] == $password){
?>
<script type="text/javascript">
$('.login').remove();
</script>
<?php
echo '<p>Login Succesful. You will be redirected back shortly...</p>';
$_SESSION['user'] =  $row['first'];
$_SESSION['username'] = $row['login'];
$_SESSION['login'] = "true";
header( "refresh:3;url=index.php" );
} else{
echo 'Incorrect Password';
}
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
