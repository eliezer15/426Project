<?php
date_default_timezone_set('America/New_York');

class Picture {
  private $id;
  private $path;
  private $upvotes;
  private $downvotes;
  private $uploaded;
  private $author;
  private $description;
  private $profile;

  public static function create($path, $path, $uploaded, $description, $upvotes, $downvotes, $author, $profile) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("insert into Picture values (0, ".
           "'".$path."',".
           "'".$uploaded->format('Y-m-d')."',".
           "'".$mysqli->real_escape_string($description)."',".
			   $upvotes . ", " .
			   $downvotes . ", " .
		   "'".$author. "', " .
               $profile. ")");
			     

    if ($result) {
      $id = $mysqli->insert_id;
      return new Picture($id, $path, $uploaded, $description, $upvotes, $downvotes, $author, $profile);
    }
    //else
    return null;
  }

  public static function findByID($id) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("select * from Picture where id = " . $id);
    
    if ($result) {
      if ($result->num_rows == 0) {
	      return null;
      }

      $picture = $result->fetch_array();
      $uploaded = new DateTime($picture['uploaded']);

      return new Picture(intval($picture['id']),
		                        $picture['path'],
		                        $uploaded,
		                        $picture['description'],
                                intval($picture['upvotes']),
                                intval($picture['downvotes']),
		                        $picture['author'],
		                        intval($picture['ProfilePic']));
    }

    return null;
  }
 
  public static function getAllIDs() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("select id from Picture");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	       $id_array[] = intval($next_row['id']);
      }
    }

    return $id_array;
  }

  private function __construct($id, $path, $uploaded, $description, $upvotes, $downvotes, $author, $profile) {
    $this->id = $id;
    $this->path = $path;
    $this->description = $description;
    $this->upvotes = $upvotes;
    $this->downvotes = $downvotes;
    $this->uploaded = $uploaded;
    $this->author = $author;
    $this->profile = $profile;
  }

  /* UPDATE THESE */
  public function getID() {
    return $this->id;
  }

  public function getpath() {
    return $this->path;
  }

  public function getdescription() {
    return $this->description;
  }

  public function getupvotes() {
    return $this->upvotes;
  }

  public function getdownvotes() {
    return $this->downvotes;
  }

  public function getnetvotes() {
    return $this->upvotes - $this->downvotes;
  }
  public function getDueDate() {
    return $this->downvotes;
  }

  public function getuploaded() {
    return $this->uploaded;
  }

  public function istitle() {
    return $this->title;
  }

  public function setpath($path) {
    $this->path = $path;
    return $this->update();
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

  public function setuploaded($uploaded) {
    $this->uploaded = $uploaded;
    return $this->update();
  }

  public function settitle() {
    $this->title = $title;
    return $this->update();
  }
  
  private function update() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $uploaded = "'" . $this->uploaded->format('Y-m-d') . "'";

    $result = $mysqli->query("update Todo set " .
			     "path= " .$this->path. ", " .
			     "picture=" .$this->picture. ", " .
			     "upvotes=" .$this->upvotes. ", " .
			     "downvotes=".$this->downvotes. ", " .
			     "uploaded=" .$uploaded . ", " .
			     "title=" . $this->title);

    return $result;
  }

  public function delete() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");
    $mysqli->query("delete from Picture where id = " . $this->id);
  }
   
  /* END UPDATE */

  public function getJSON() {

    $uploaded = $this->uploaded->format('Y-m-d');
    

    $json_obj = array('id' => $this->id,
		      'path' => $this->path,
		      'profile' => $this->profile,
		      'upvotes' => $this->upvotes,
		      'downvotes' => $this->downvotes,
		      'uploaded' => $uploaded,
              'author' => $this->author,
		      'description' => $this->description);
    return json_encode($json_obj);
  }
}

