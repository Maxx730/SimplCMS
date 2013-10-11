<?php
	//this class will initiated when finding posts for use inside the CMS, in other words if the Admin wants to announce information to other users they can post something and it will be displayed on the Dashboard.
	class simpl_post{

		public $author;
		public $title;
		public $date;
		public $importance;
		public $content;

		//to create a post object, all that is needed is the id of the post to gather the initial information from the database.
		public function __construct($id){
			global $connect;
			global $database_name;

			$sql = "SELECT * FROM posts WHERE postID = '$id'";
			$result = mysql_query($sql,$connect) or die(mysql_error());
			$array = mysql_fetch_array($result) or die(mysql_error());

			$this->author = $array['author'];
			$this->title = $array['title'];
			$this->date = $array['date'];
			$this->importance = $array['importance'];
			$this->content = $array['content'];
		}

		//if not in a list, this function willl display the content of all the post information in a single page if the user click on see full post (up for debate on whether there shoudl be that or display the whole thing in a news feed style.)
		public function display_post(){

		}

	}
?>