<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/mystylesheet.css">
<link href="css/popup.css" rel="stylesheet" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/main.js"></script>
	<script src="js/user.js"></script>
<title>Upload</title>
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
<div class="upload">
<?php
if(isset($_SESSION["user"])){
if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
 echo '<p>File types allowed : gif, jpeg, jpg, png. Max size: 900 kB</p>';
echo '
<form action="upload.php" method="post"
enctype="multipart/form-data">
<p><label for="title">Title:</label><br><input type="text" name="title" value="" placeholder="title"></p>
<p><label for="desc">Description (250 char limit) : <br> </label><textarea  name="desc" maxlength="1000" cols="25" rows="6"></textarea></p>
<label for="file">Filename:</label><br>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form> ';
} else{
$title = mysqli_real_escape_string($con,$_POST["title"]);
$desc = mysqli_real_escape_string($con,$_POST["desc"]);
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
	  
      echo "Your file has been uploaded";
	  $day = date("Y-m-d");
	  $user = $_SESSION['username'];
	  $uploaddir = "upload/" . $_FILES["file"]["name"];
	  $sql = "INSERT INTO Picture (id,path, uploaded, title, description, upvotes, downvotes, author,ProfilePic)
		VALUES ('null','$uploaddir', '$day', '$title','$desc', 0, 0, '$user', 0)";
		if (!mysqli_query($con,$sql))
  {
  echo "MYSQL error";
  }
	echo "<br><p>Title:" . $title."</p>";
	echo "<p>Description:" . $desc."</p>";
	echo '<p><img alt="uploaded img" src="'.$uploaddir.'"></p>';
	
	  
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
