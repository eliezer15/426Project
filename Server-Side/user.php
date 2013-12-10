<?php 
require_once('orm/User.php');
session_start();

$path_components = explode('/', $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  // GET means either instance look up, index generation, or deletion

  // Following matches instance URL in form
  // /user.php/<id>
  
  if ((count($path_components) == 2) && ($path_components[1] != "")) {

<<<<<<< HEAD
    // Interpret <id> as integer or string
    $user_id = $path_components[1];
    if (is_numeric($path_components[1]))
        $user_id = intval($user_id);
    
 

    // Look up object via ORM
    $user = User::findByID($user_id);
    
=======
    // Interpret <id> as integer
    $user_id = intval($path_components[1]);

    // Look up object via ORM
    $user = User::findByID($user_id);

>>>>>>> 88befbd4ead96c5066a2a2cb4651151085c06a3f
    if ($user == null) {
      // Comment not found.
      header("HTTP/1.0 404 Not Found");
      print("id: " . $user_id . " not found.");
      exit();
    }
<<<<<<< HEAD
    
    header("Content-type: application/json");
    print(json_encode($user));
    exit();

=======
>>>>>>> 88befbd4ead96c5066a2a2cb4651151085c06a3f
  } else {
    //Assume trying to get logged in user

    if(isset($_SESSION['username'])) {
        $user = $_SESSION;    
        print(json_encode($user));
    } else {
        header("HTTP/1.0 500 Server Error");
        print("No user found");
    }
    exit();
    }
}
