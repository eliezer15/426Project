<?php
header('Content-Type: application/json');
session_start();
$resp = new stdClass();
// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
{
	$resp->error = "Failed to connect to MySQL: " . mysqli_connect_error();
	echo json_encode( $resp );
}
if(isset($_POST['username'])){
	$user = mysqli_real_escape_string($con,$_POST['username']);
}
if(isset($_POST['password'])){
	$pass = mysqli_real_escape_string($con,$_POST['password']);
}
if(isset($_POST['type'])){
	$type = mysqli_real_escape_string($con,$_POST['type']);
}
if(isset($_POST['firstn'])){
	$first = mysqli_real_escape_string($con,$_POST['firstn']);
}
if(isset($_POST['type'])){
	$last = mysqli_real_escape_string($con,$_POST['lastn']);
}
if(isset($_POST['type'])){
	$email = mysqli_real_escape_string($con,$_POST['emailn']);
}

if($type === "login"){
	$result = mysqli_query($con,"SELECT * FROM User WHERE login = '". $user ."' ");
	if (mysqli_num_rows($result) == 0) {
		$resp->logged = false;
		$resp->error = "Username does not exist";
	} else{
		$row = mysqli_fetch_array($result);
		if($row['password'] == $pass){
			$_SESSION['user'] =  $row['first'];
			$_SESSION['username'] = $row['login'];
			$_SESSION['login'] = "true";
			$_SESSION['id'] = $row['id'];
<<<<<<< HEAD

            /* for profilepic, pass the picture object */
            $profile_picture_id = $row['profilepic'];
            $result = mysqli_query($con, "select * from Picture where id=".$profile_picture_id.";");   
            $profile_pic = mysqli_fetch_object($result);
            $_SESSION['profilepic'] = $profile_pic;
=======
            $_SESSION['profilepic'] = $row['profilepic'];
>>>>>>> 88befbd4ead96c5066a2a2cb4651151085c06a3f
			$resp->logged = true;
		} else{
			$resp->logged = false;
			$resp->error = "Password is incorrect.";
		}
	}
}

if($type === "logout"){
	if(isset($_SESSION['user'])){
		unset($_SESSION['user']);
	}
	if(isset($_SESSION['username'])){
		unset($_SESSION['username']);
	}
	if(isset($_SESSION['login'])){
		unset($_SESSION['login']);
	}
	if(isset($_SESSION['id'])){
		unset($_SESSION['id']);
	}
	session_destroy();
}


if($type === "register"){
$day = date("Y-m-d");
$result = mysqli_query($con,"SELECT * FROM User WHERE login = '". $user ."' ");
if (mysqli_num_rows($result) == 0) {
	$sql = "INSERT INTO User (id,first, last, login, password, email, created, profilepic)
	VALUES ('null','$first', '$last', '$user', '$pass', '$email', '$day', 9)";
	$result = mysqli_query($con,$sql);
	if (!$result)
  {
	$resp->error = "MYSQL error";
  
  }
  $resp->logged = true;
  
} else{
	$resp->error = "Username Already Exists";
	$resp->logged = false;
}
}

echo json_encode( $resp );
?>
