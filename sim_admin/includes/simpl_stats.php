<?php

	//this class will gather information about a specific user, data on how many objects the user has created or is an author of will be calculated by this object.
	class simpl_stats{

		//these two variables will be acquired upon object construction.
		public $username;
		private $user_id;

		public $number_of_pages;
		public $number_of_tags;

		public $total_pages;
		public $total_tags;

		//class accepts and object as a parameter, meaning that if you send simply the username there will be a fatal error.
		public function __construct($user){
			$check = new simpl_administration();

			//if the user actually exists within the database, create a new user object and gather the correct information accordingly.
			if($check->check_user_exists($user->return_name())){
				$this->username = $user;

				$user_stats = new user($user->return_name());
				$this->user_id = $user_stats->return_id();

				//after a new user object is initiated, fill in the appropriate information such as page and tag totals.
				$this->get_page_count();
			}else{

				echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: User does not exist.</div></div>";
			}
		}

		//grabs the amount of pages this user has created.
		public function get_page_count(){
			global $connect;
			global $database_name;

			mysql_select_db($database_name,$connect);

			$sql = "SELECT * FROM pages WHERE uID = '$this->user_id'";	
			$result = mysql_query($sql,$connect) or die(mysql_error());

			$this->number_of_pages = mysql_num_rows($result) or die(mysql_error());		
		}

		//grabs the amount of tags this user has created.
		public function get_tag_count(){
			global $connect;
			global $database_name;

			mysql_select_db($database_name,$connect);

			$sql = "SELECT * FROM subjects WHERE uID = '$this->user_id'";
			$result = mysql_query($sql,$connect) or die(mysql_error());

			$this->number_of_tags = mysql_num_rows($result) or die(mysql_error());
		}

		//this will grab the total amount of different objects in the database to provide further statistical information.
		public function get_totals(){
			global $connect;
			global $database_name;

			mysql_select_db($database_name,$connect);

			$sql_pages = "SELECT * FROM pages";
			$sql_tags = "SELECT * FROM tags";

			$result_pages = mysql_query($sql_pages,$connect) or die(mysql_error());
			$result_tags = mysql_query($sql_tags,$connect) or die(mysql_error());

			$this->total_pages = mysql_num_rows($result_pages) or die(mysql_error());
			$this->total_tags = mysql_num_rows($result_tags) or die(mysql_error());
		}

		//this function will be used to actually display the information about the user accordingly.
		public function display_user_stats(){
			$final = "
				<div id = 'user_profile_stats'>
					User Statistics
					<br />
					User statistics provide information about different aspects of this user's 
					<table id = ''>
						<tr>
							<td>Pages: </td>
							<td>".$this->number_of_pages."</td>
						</tr>
						<tr>
							<td>Tags: </td>
							<td></td>
						</tr>
						<tr>
							<td>Lastest Actions:</td>
							<td></td>
						</tr>
					</table>
				</div>
			";

			echo $final;
		}
	}
?>