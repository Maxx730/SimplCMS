<?php

	//Class tags receive and store information about each tag within our database.  Public functions can be used to set and get information about each tag.
	class tag{
		private $id;
		public $title;
		public $tagged_pages = array();
		
		public function __construct($id){
			global $connect;
			
			$sql = "SELECT * FROM subjects WHERE sID = '$id'";
			$result = mysql_query($sql,$connect) or die(mysql_error());
			
			$array = mysql_fetch_array($result) or die(mysql_error());
			
			$this->id = $id;
			$this->title = $array['label'];
			
			$sql = "SELECT * FROM tagged WHERE sID = '$id'";
			$this->tagged_pages = mysql_query($sql,$connect) or die(mysql_error());
		}
		
		public function add_tag(){
			global $connect;
			$permission = new user($_SESSION['username']);
			
			if($permission->returnPerm() >= 2){
				return false;
			}else{
				$sql = "INSERT INTO subjects(label) VALUES('$this->title')";
				mysql_query($sql,$connect) or die(mysql_error());
			}
		}
		
		public function delete_tag(){
		
		}
	
	}
?>