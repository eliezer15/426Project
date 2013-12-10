<?php

date_default_timezone_set('America/New_York');

class Comment {
  private $id;
  private $author;
  private $picture;
  private $upvotes;
  private $downvotes;
  private $created;
  private $content;
 
  public static function create($author, $picture, $upvotes, $downvotes, $created, $content) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("insert into Comment values (0, ".
           "'".$created->format('Y-m-d')."',".
           "'".$mysqli->real_escape_string($content)."', ".
			     $upvotes . ", " .
			     $downvotes . ", " .
			     $picture. "," .
			     $author . ")"); 

    if ($result) {
      $id = $mysqli->insert_id;
      return new Comment($id, $author, $picture, $upvotes, $downvotes, $created, $content);
    }

    //else
    return $mysqli->error;
  }

  public static function findByID($id) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("select * from Comment where id = " . $id);
    
    if ($result) {
      if ($result->num_rows == 0) {
	      return null;
      }

      $comment = $result->fetch_array();
      $created = new DateTime($comment['created']);

      return new Comment(intval($comment['id']),
		      intval($comment['author']),
		      intval($comment['picture']),
		      intval($comment['upvotes']),
              intval($comment['downvotes']),
		      $created,
		      $comment['content']);
    }

    return null;
  }

  public static function getAllIDsFromPicture($picture) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("select id from Comment where picture=".$picture);
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	       $id_array[] = intval($next_row['id']);
      }
    }

    return $id_array;
  }
  
  public static function getAllIDs() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("select id from Comment");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	       $id_array[] = intval($next_row['id']);
      }
    }

    return $id_array;
  }

  private function __construct($id, $author, $picture, $upvotes, $downvotes, $created, $content) {
    $this->id = $id;
    $this->author = $author;
    $this->picture = $picture;
    $this->upvotes = $upvotes;
    $this->downvotes = $downvotes;
    $this->created = $created;
    $this->content = $content;
  }

  public function getID() {
    return $this->id;
  }

  public function getauthor() {
    return $this->author;
  }

  public function getpicture() {
    return $this->picture;
  }

  public function getupvotes() {
    return $this->upvotes;
  }

  public function getnetvotes() {
    return $this->upvotes - $this->downvotes;
  }
  public function getDueDate() {
    return $this->downvotes;
  }

  public function getcreated() {
    return $this->created;
  }

  public function iscontent() {
    return $this->content;
  }

  public function setauthor($author) {
    $this->author = $author;
  }

  public function setpicture($picture) {
    $this->picture = $picture;
    return $this->update();
  }

  public function setupvotes($upvotes) {
    $this->upvotes = $upvotes;
    return $this->update();
  }

  public function setDueDate($downvotes) {
    $this->downvotes = $downvotes;
    return $this->update();
  }

  public function setcreated($created) {
    $this->created = $created;
    return $this->update();
  }

  public function setcontent() {
    $this->content = $content;
    return $this->update();
  }

  private function update() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $created = "'" . $this->created->format('Y-m-d') . "'";

    $result = $mysqli->query("update Comment set " .
			     "author= " .$this->author. ", " .
			     "picture=" .$this->picture. ", " .
			     "upvotes=" .$this->upvotes. ", " .
			     "downvotes=".$this->downvotes. ", " .
			     "created=" .$created . ", " .
			     "content=" . $this->content);

    return $result;
  }

  public function delete() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");
    $mysqli->query("delete from Comment where id = " . $this->id);
  }
  
  /* I need to get the username from this. I am lazy and will just do it
  here. This is bad design, but yolo */

  public function getJSON() {

    $created = $this->created->format('Y-m-d');
    

    $json_obj = array('id' => $this->id,
		      'author' => $this->author,
		      'picture' => $this->picture,
		      'upvotes' => $this->upvotes,
		      'downvotes' => $this->downvotes,
		      'created' => $created,
		      'content' => $this->content);
    return json_encode($json_obj);
  }
}

