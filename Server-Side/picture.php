<?php

require('orm/Picture.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

// Note that since extra path info starts with '/'
// First element of path_components is always defined and always empty.

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  // GET means either instance look up, index generation, or deletion

  // Following matches instance URL in form
  // /comment.php/<id>
  
  if ((count($path_components) == 2) && ($path_components[1] != "")) {

    // Interpret <id> as integer
    $picture_id = intval($path_components[1]);

    // Look up object via ORM
    $picture = Picture::findByID($picture_id);

    if ($picture == null) {
      // Comment not found.
      header("HTTP/1.0 404 Not Found");
      print("id: " . $picture_id . " not found.");
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
    header("Content-type: application/json");
    print($picture->getJSON());
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

    // Validate values
    $new_title = false;
    if (isset($_REQUEST['title'])) {
      $new_title = trim($_REQUEST['title']);
      if ($new_title == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad title");
	exit();
      }
    }

    $new_note = false;
    if (isset($_REQUEST['note'])) {
      $new_note = trim($_REQUEST['note']);
    }

    $new_project = false;
    if (isset($_REQUEST['project'])) {
      $new_project = trim($_REQUEST['project']);
    }

    $new_due_date = false;
    $new_date_obj = null;
    if (isset($_REQUEST['due_date'])) {
      $new_due_date = true;
      $date_str = trim($_REQUEST['due_date']);
      if ($date_str != "") {
	$new_date_obj = new DateTime($date_str);
      }
    }

    $new_priority = false;
    if (isset($_REQUEST['priority'])) {
      $new_priority = intval($_REQUEST['priority']);
      if (!($new_priority > 0 && $new_priority <= 10)) {
	header("HTTP/1.0 400 Bad Request");
	print("Priority value out of range.");
	exit();
      }
    }

    if (isset($_REQUEST['complete'])) {
      $new_complete = true;
    } else {
      $new_complete = false;
    }

    // Update via ORM
    if ($new_title) {
      $comment->setTitle($new_title);
    }
    if ($new_note != false) {
      $comment->setNote($new_note);
    }
    if ($new_project != false) {
      $comment->setProject($new_project);
    }
    if ($new_due_date) {
      $comment->setDueDate($new_date_obj);
    }
    if ($new_priority != false) {
      $comment->setPriority($new_priority);
    }
    
    if (!$new_complete) {
      $comment->clearComplete();
    } else {
      $comment->setComplete();
    }

    // Return JSON encoding of updated Todo
    header("Content-type: application/json");
    print($comment->getJSON());
    exit();
    
  } else {

    // Creating a new Todo item

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

    if (!isset($_REQUEST['author'])) {
      header("HTTP/1.0 400 Bad Request");
      print("Missing picture");
      exit();
    }

    $content = trim($_REQUEST['content']);
    if ($content == "") {
      header("HTTP/1.0 400 Bad Request");
      print("Bad content");
      exit();
    }      

    $picture = intval($_REQUEST['picture']);
    $author = intval($_REQUEST['author']);
    $created = new DateTime(trim($_REQUEST['created']));
    $upvotes = 0;
    $downvotes = 0;
    
    // Create new Todo via ORM
    $new_comment = Comment::create($author, $picture, $upvotes, $downvotes, $created, $content);
    
    // Report if failed
    if ($new_comment == null) {
      header("HTTP/1.0 500 Server Error");
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
