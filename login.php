<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><title>Login</title>
</head>
<body>
<div class="main">
<?php session_start(); include("scripts/header.php"); ?>
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
}
?>
</div> <!--login-->
</div><!--mainContent-->
<div class="footer">
</div><!--footer-->
</div> <!--main-->	
</body>
</html>
