<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="mystylesheet.css">
	<script src="jquery-1.10.2.js"></script>
<title>Logout</title>
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
<div class="login">

<?php
if(isset($_COOKIE['user'])){
echo '<h1>Logging out .... </h1>';
unset($_COOKIE['user']);
setcookie('user', '', time() - 3600); // empty value and old timestamp
if(isset($_COOKIE['username'])){
unset($_COOKIE['username']);
  setcookie('username', '', time() - 3600); // empty value and old timestamp
}
// wait 5 seconds and redirect :)
echo "<meta http-equiv=\"refresh\" content=\"5;url=".$_SERVER['HTTP_REFERER']."\"/>";
} else{
echo '<h1>Already logged out</h1>';
echo "<meta http-equiv=\"refresh\" content=\"5;url=".$_SERVER['HTTP_REFERER']."\"/>";
}
?>
</div> <!--login-->
</div><!--mainContent-->
<div class="footer">
</div><!--footer-->
</div> <!--main-->	
</body>
</html>
