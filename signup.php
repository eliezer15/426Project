<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="mystylesheet.css">
	<script src="jquery-1.10.2.js"></script>
	<script src="main.js"></script>
<title>Register</title>
</head>
<body>
<?php
// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
<div class="main">
<p> Welcome, <?php if (isset($_COOKIE['user'])){echo $_COOKIE['user']; echo '! <a href="logout.php">click here to logout</a>';} else echo 'Guest <a href="login.php">login</a>!'; ?></p>
	<div class="logo">
		<h1> Tar Heel Gallery </h1>
	</div><!-- logo place holder -->
<div class = "header">
    <div class ="menu">
    	<ul>
    	<li><a href="index.php">Home</a></li>
    	<li><a href="about.php">About</a></li>
    	<li><a href="">Galleries</a></li>
    	</ul>
	</div><!-- Menu-->
</div><!--Header -->
<div class="mainContent">
<div class="signup_wrapper">
<div class="signup">
<?php
if(isset($_COOKIE['user'])){
echo "<h3> You are already logged in as, " . $_COOKIE['username'] . "</h3>";
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
$first = $_POST["first"];
$last = $_POST["last"];
$username = $_POST["login"];
$password = $_POST["password"];
$email = $_POST["email"];
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
  setcookie("user", $first, 0);
  setcookie("username", $username, 0);
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
