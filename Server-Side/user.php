<?php 
require_once('orm/User.php');
session_start();

$path_components = explode('/', $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  // GET means either instance look up, index generation, or deletion

  // Following matches instance URL in form
  // /user.php/<id>
  
  if ((count($path_components) == 2) && ($path_components[1] != "")) {

    // Interpret <id> as integer
    $user_id = intval($path_components[1]);

    // Look up object via ORM
    $user = User::findByID($user_id);

    if ($user == null) {
      // Comment not found.
      header("HTTP/1.0 404 Not Found");
      print("id: " . $user_id . " not found.");
      exit();
    }
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
