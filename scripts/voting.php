<?php
header('Content-Type: application/json');
// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
{
	$resp->error = "Failed to connect to MySQL: " . mysqli_connect_error();
}
if(isset($_POST['picture'])){
	$id = mysqli_real_escape_string($con,$_POST['picture']);
}
if(isset($_POST['vote'])){
	$vote = mysqli_real_escape_string($con,$_POST['vote']);
}

$id = str_replace("pic","",$id);
$resp = new stdClass();
if($vote === "up"){
	$query = "UPDATE `Picture` SET `upvotes`=upvotes + 1 WHERE id =".$id;
	$resp->query = $query;
	$result = mysqli_query($con, $query);
	$resp->error = mysqli_error($con);
}
if($vote === "down"){
	$query = "UPDATE `Picture` SET `downvotes`=downvotes + 1 WHERE id =".$id;
	$resp->query = $query;
	$result = mysqli_query($con, $query);
	$resp->error = mysqli_error($con);


}



$resp->id = $id;
$resp->vote = $vote;

echo json_encode($resp);

?>