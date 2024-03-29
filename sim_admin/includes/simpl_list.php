<?php

/*
	This class is important for retreiving information based on which page the user is on and what kind of list they will be retreiving. 
*/

class simpl_list{
	public $type;

	public function __construct($type){
		//sets what kind of list will be displayed. There are different options for different objects.
		$this->type = $type;
	}
	
	//displays the manage list depending on the type of object selected.
	public function display(){
		
		//SQL statement changes depending on which type of list is being requested.
		 switch($this->type){
			case "page":
				$sql = "SELECT * FROM pages";
				break;
			case "user":
				$sql = "SELECT * FROM users";
				break;
			case "tag":
				$sql = "SELECT * FROM subjects";
				break;
			case "med":
				$sql = "SELECT * FROM media";
			break;
		 }
		 
		 //make sure to initiate the global connection variable before attempting SQL querys.
		 global $connect;
		 global $database_name;

		 mysql_select_db($database_name);

		 $result = mysql_query($sql,$connect) or die(mysql_error());
		 $display = "<table class = 'simpl_manage_objects'>";
		 
		 while($array = mysql_fetch_array($result)){
		 
		 		 switch($this->type){
					case "page":
						$tds = "<td><input type = 'checkbox'/></td><td>".$array['pID']."</td><td>".$array['title']."</td><td>".$array['author']."</td><td><div class = 'simpl_edit_button'><a href = 'simpl_edit.php'>Edit</a></div></td>";
					break;
					case "user":
						$tds = "<td><input type = 'checkbox'/></td><td>".$array['uID']."</td><td>".$array['username']."</td><td>".$array['rID']."</td><td class = 'simpl_edit_button'><a href = 'simpl_edit.php'>Edit</a></td>";
					break;
					case "tag":
						$tds = "<td><input type = 'checkbox'/></td><td>".$array['sID']."</td><td>".$array['label']."</td>";
					break;
					case "med":
						$tds = "<td>".$array['medID']."</td><td>".$array['file_name']."</td><td>".$array['file_url']."</td><td>".$array['file_type']."</td><td>".$array['file_uploader']."</td>";
					break;
					}
		 
			$display .= "
				<tr class = 'simpl_manage_row'>
					".
						$tds
					."
				</tr>
			";
		 }
		 
		 //display all the recieved data as a simple table with classes for that will all correspond and only need one styling code.
		 $display .= "</table>";
		 echo $display;
	}

	//function will provide the correct title for the object that is being managed.
	public function manage_title(){
		switch($this->type){
			case "page":
				echo "<img src = 'img/cat_icons/book-lines-2.png' class = 'simpl_title_img'/> <div class = 'simpl_manage_title'>
						
						Manage : Pages
					</div>";
			break;

			case "user":
				echo "<img src = 'img/cat_icons/user-4.png' class = 'simpl_title_img'/><div class = 'simpl_manage_title'> Manage : Users</div>";
			break;

			case "tag":
				echo "<img src = 'img/cat_icons/tag-4.png' class = 'simpl_title_img'/><div class = 'simpl_manage_title'>
				Manage : Tags</div>";
			break;

			case "inv":
				echo "<img src = 'img/cat_icons/eye-2.png' class = 'simpl_title_img'/><div class = 'simpl_manage_title'>Manage : Investigators</div>";
			break;

			case "med":
				echo "<img src = 'img/cat_icons/image.png' class = 'simpl_title_img'/><div class = 'simpl_manage_title'>Manage : Media</div>";
			break;
		}
	}
}

?>