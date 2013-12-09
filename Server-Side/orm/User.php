<?php
date_default_timezone_set('America/New_York');

class User {
  private $id;
  private $first;
  private $last;
  private $username;
  private $email;
  private $created;
  private $profilepic;
    
  /* AS of now, I only need this class to retrieve users, not create them, so I won't need this 

  public static function create($id, $first, $last, $username, $password, $email, $created, $profilepic) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("insert into User values (0, ".
           "'".$first."',".
           "'".$uploaded->format('Y-m-d')."',".
           "'".$mysqli->real_escape_string($description)."',".
			   $upvotes . ", " .
			   $downvotes . ", " .
		   "'".$author. "', " .
               $profile. ")");
			     

    if ($result) {
      $id = $mysqli->insert_id;
      return new Picture($id, $first, $uploaded, $description, $upvotes, $downvotes, $author, $profile);
    }
    //else
    return null;
  }

  */

  public static function findByID($id) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "danfiza", "comp426daneli", "danfizadb");

    $result = $mysqli->query("select * from User where id = " . $id);
    
    if ($result) {
      if ($result->num_rows == 0) {
	      return null;
      }

      $user = $result->fetch_array();
      $created = new DateTime($user['created']);

      return new User(intval($user['id']),
		                        $user['first'],
		                        $user['last'],
		                        $user['login'],
                                $user['email'],
		                        $created,
		                        intval($user['profilepic']));
    }

    return null;
  }
  
  /* Won't be needed for now

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
  */

  private function __construct($id, $first, $last, $username, $email, $created, $profilepic) {
    $this->id = $id;
    $this->first = $first;
    $this->last = $last;
    $this->username = $username;
    $this->email = $email;
    $this->created = $created;
    $this->profilepic = $profilepic;
  }

  /* UPDATE THESE */
  public function getID() {
    return $this->id;
  }

  public function setID($id) {
    $this->id = $id;
  }

  public function getfirst() {
    return $this->first;
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

  public function setfirst($first) {
    $this->first = $first;
    return $this->update();
  }

  public function setuser($user) {
    $this->user = $user;
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
			     "first= " .$this->first. ", " .
			     "user=" .$this->user. ", " .
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

    $created = $this->created->format('Y-m-d');
    

    $json_obj = array('id' => $this->id,
		      'first' => $this->first,
		      'last' => $this->last,
		      'username' => $this->username,
		      'email' => $this->email,
		      'created' => $created,
              'profilepic' => $this->profilepic);
    return json_encode($json_obj);
  }
}

