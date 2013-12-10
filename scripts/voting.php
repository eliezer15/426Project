<?php
session_start();
header('Content-Type: application/json');

// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
{
	$resp->error = "Failed to connect to MySQL: " . mysqli_connect_error();
}

/* Make sure user is logged in */
if (!isset($_SESSION['id'])) {
    print("Error");
    exit();
}

if(isset($_POST['picture'])){
	$picture_id = mysqli_real_escape_string($con,$_POST['picture']);
}
if(isset($_POST['vote'])){
	$vote = mysqli_real_escape_string($con,$_POST['vote']);
}

$user_id = $_SESSION['id'];
$picture_id = str_replace("pic","",$picture_id);
$resp = new stdClass();

/* Make sure the user has not voted on this picture yet */
$query = "select * from Voted where user = ".$user_id." and picture=".$picture_id.";";
$resp->query = $query;
$result = mysqli_query($con, $query);
$previous_vote = 0; //0 denotes not set

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_object($result);
    $resp->row = $row;
    $previous_vote = intval($row->vote); //-1 denotes down, 1 denotes up 
}

if($vote === "up" && $previous_vote < 1) {
    
    /* First, update the vote */
	$query = "UPDATE `Picture` SET `upvotes`=upvotes + 1 WHERE id =".$picture_id;
	$resp->query = $query;
	$result = mysqli_query($con, $query);
	$resp->error = mysqli_error($con);

    /* Register the vote on the Voted table, or update it */
    if ($previous_vote == 0) 
        $query = "insert into Voted values(".$user_id.",".$picture_id.",1);";
    else
        $query = "update Voted set vote = 1 where user=".$user_id." and picture=".$picture_id.";";

	$resp->query = $query;
	$result = mysqli_query($con, $query);
  	$resp->error = mysqli_error($con);
    $resp->success = true;

}

else if($vote === "down" &&  $previous_vote >= 0) {
	$query = "UPDATE `Picture` SET `downvotes`=downvotes + 1 WHERE id =".$picture_id;
	$resp->query = $query;
	$result = mysqli_query($con, $query);
	$resp->error = mysqli_error($con);

    /* Register the vote on the Voted table, or update it */
    if ($previous_vote == 0) 
        $query = "insert into Voted values(".$user_id.",".$picture_id.",-1);";
    else
        $query = "update Voted set vote = -1 where user=".$user_id." and picture=".$picture_id.";";

	$resp->query = $query;
	$result = mysqli_query($con, $query);
	$resp->error = mysqli_error($con);
    $resp->success = true;
} 

else {
    $resp->success = false;
}

$resp->picture_id = $picture_id;
$resp->user_id = $user_id;
$resp->vote = $vote;

echo json_encode($resp);

?>
