<?php
// Create connection
$con=mysqli_connect("classroom.cs.unc.edu","danfiza","comp426daneli","danfizadb");

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
 $query = "SELECT `id`, `path`, `uploaded`, `title`, `description`, `upvotes`, `downvotes`, `author`, `ProfilePic` FROM `Picture` WHERE (`ProfilePic` = 0)";
 $result = mysqli_query($con, $query);
 
 $data = array();
 
 while ( $row = mysqli_fetch_array($result)){
		$data[] = ($row);
	}
 
  echo json_encode( $data );
?>