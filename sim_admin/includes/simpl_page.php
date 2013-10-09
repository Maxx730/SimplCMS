<?php

//Page classes are used to read and right information about each page depending on the pages identity number.
class page{

	public $title;
	public $content;
	public $author;
	public $adult;
	public $funding;
	public $id;
	
	public function __construct($id){
		echo "working";
	}
	
	public function getContent($id){
	
		$root = "config.php";
		include($root);
		
		mysql_select_db('TRANSCTR_1');
		$sql = "SELECT * FROM pages WHERE pID = '$id'";
		$result = mysql_query($sql,$connect) or die(mysql_error());
		
		$array = mysql_fetch_array($result);
		
		echo $array['content'];
	}
	
	public function setContent(){
	
	}
}

?>