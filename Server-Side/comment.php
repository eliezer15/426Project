<?php

require_once('orm/Comment.php');
require_once('orm/User.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

// Note that since extra path info starts with '/'
// First element of path_components is always defined and always empty.

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  // GET means either instance look up, index generation, or deletion

  // Following matches instance URL in form
  // /comment.php/<id>
  
  if ((count($path_components) == 2) && ($path_components[1] != "")) {

    // Interpret <id> as integer
    $comment_id = intval($path_components[1]);

    // Look up object via ORM
    $comment = Comment::findByID($comment_id);

    if ($comment == null) {
      // Comment not found.
      header("HTTP/1.0 404 Not Found");
      print("Comment id: " . $comment_id . " not found.");
      exit();
    }

    // Check to see if deleting
    if (isset($_REQUEST['delete'])) {
      $comment->delete();
      header("Content-type: application/json");
      print(json_encode(true));
      exit();
    } 

    // Normal lookup.
    // Generate JSON encoding as response
    //Make sure you add the User json as the user field
    
    $author_id = $comment->getauthor();
    $user = User::findByID($author_id);
    $comment->setauthor($user->getJSON());
    
    /*
    <script>
    console.log(<?echo $user->getJSON()?>);
    </script>
    */
    
    header("Content-type: application/json");
    print($comment->getJSON());
    exit();

  }
  
  /* Get all comments in one specific picture 
     The URL matched is comment.php/picture/<picture id> */

  if ((count($path_components) === 3) && ($path_components[2] != "") && ($path_components[1] == "picture")) {

    // Interpret <id> as integer
    $picture_id = intval($path_components[2]);

    // Look up object via ORM
    $comments = Comment::getAllIDsFromPicture($picture_id);

    if ($comments == null) {
      // Comment not found.
      header("HTTP/1.0 404 Not Found");
      print("Picture id: " . $picture_id . " not found.");
      exit();
    }

    // Normal lookup.
    // Generate JSON encoding as response
    header("Content-type: application/json");
    print(json_encode($comments));
    exit();

  }

  // ID not specified, then must be asking for index
  header("Content-type: application/json");
  print(json_encode(Comment::getAllIDs()));
  exit();

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Either creating or updating

  // Following matches /comment.php/<id> form
  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    //Interpret <id> as integer and look up via ORM
    $comment_id = intval($path_components[1]);
    $comment = Comment::findByID($todo_id);

    if ($comment == null) {
      // Todo not found.
      header("HTTP/1.0 404 Not Found");
      print("Todo id: " . $comment_id . " not found while attempting update.");
      exit();
    }

    
  } else {

    // Creating a new  comment

    // Validate values
    
    if (!isset($_REQUEST['content'])) {
      header("HTTP/1.0 400 Bad Request");
      print("Missing content");
      exit();
    }
    
    if (!isset($_REQUEST['picture'])) {
      header("HTTP/1.0 400 Bad Request");
      print("Missing picture");
      exit();
    }

    if (!isset($_REQUEST['author_id'])) {
      header("HTTP/1.0 400 Bad Request");
      print("Missing autor id");
      exit();
    }
    
    $content = trim($_REQUEST['content']);
    if ($content == "") {
      header("HTTP/1.0 400 Bad Request");
      print("Bad content");
      exit();
    }      

    $picture = intval($_REQUEST['picture']);
    $author = intval($_REQUEST['author_id']);
    $created = new DateTime(trim($_REQUEST['created']));
    $upvotes = 0;
    $downvotes = 0;
    
    // Create new Todo via ORM
    $new_comment = Comment::create($author, $picture, $upvotes, $downvotes, $created, $content);
    
    // Report if failed
    if ($new_comment == null) {
      //header("HTTP/1.0 500 Server Error");
      print("Server couldn't create new comment.");
      exit();
    }
    
    //Generate JSON encoding of new Todo
    header("Content-type: application/json");
    print($new_comment->getJSON());
    exit();

  }

}

// If here, none of the above applied and URL could
// not be interpreted with respect to RESTful conventions.

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");
