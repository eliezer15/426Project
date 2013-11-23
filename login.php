<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
	<script src="js/jquery-1.10.2.js"></script>
<title>Login</title>
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
<div class="login_wrapper">
<div class="login">
<?php
if(isset($_COOKIE['user'])){
echo "<h3> You are logged in as, " . $_COOKIE['username'];
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
setcookie("user", $row['first'], 0);
setcookie("username", $row['login'], 0);
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
