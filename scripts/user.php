<?php
header('Content-Type: application/json');
session_start();
// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
if(isset($_POST['username'])){
	$user = mysqli_real_escape_string($con,$_POST['username']);
}
if(isset($_POST['password'])){
	$pass = mysqli_real_escape_string($con,$_POST['password']);
}
$resp = new stdClass();
$result = mysqli_query($con,"SELECT * FROM User WHERE login = '". $user ."' ");
if (mysqli_num_rows($result) == 0) {
   $resp->logged = false;
   $resp->error = "Username does not exist";
} else{
$row = mysqli_fetch_array($result);
if($row['password'] == $pass){
echo '<p>Login Succesful. You will be redirected back shortly...</p>';
$_SESSION['user'] =  $row['first'];
$_SESSION['username'] = $row['login'];
$_SESSION['login'] = "true";
$_SESSION['id'] = $row['id'];
$resp->logged = true;
} else{
$resp->logged = false;
$resp->error = "Password is in correct.";
}
}

 
  echo json_encode( $resp );
?>