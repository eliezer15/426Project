<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<link href="css/lightbox.css" rel="stylesheet" />
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/lightbox-2.6.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/imageObj.js"></script>
<title>UNC Images</title>
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
	<div id="imageScroll">
		<div class="pic1"><a href="images/photo1.jpg" data-lightbox="image-1" title="My caption"><img src="images/photo1.jpg"></a>
		<br><img class ="thumbup" src="images/thumbup.png"><img class ="thumbdn" src="images/thumbdown.png">
		</div>
	</div><!-- imageScroll -->
</div><!--mainContent-->
<div class="footer">
</div><!--footer-->
</div> <!--main-->	
</body>
</html>
