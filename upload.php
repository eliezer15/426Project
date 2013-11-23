<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="mystylesheet.css">
	<script src="jquery-1.10.2.js"></script>
<title>Upload</title>
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
<div class="upload">
<?php
if(isset($_COOKIE["user"])){
if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
 echo '<p>File types allowed : gif, jpeg, jpg, png. Max size: 900 kB</p>';
echo '
<form action="upload.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form> ';
} else{
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 900000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["file"]["tmp_name"] . "<br>";
	
	if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
	  
      echo "Uploaded in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  }

}
}
else{
echo "<p>You have to be logged in to upload photos.</p>";
}
?>
</div> <!--upload-->
</div><!--mainContent-->
<div class="footer">
</div><!--footer-->
</div> <!--main-->	
</body>
</html>
