<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<link href="css/lightbox.css" rel="stylesheet" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	<script src="js/lightbox-2.6.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/imageObj.js"></script>
<title>UNC Images</title>
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
