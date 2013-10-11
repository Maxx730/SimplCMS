<?php
	//this class checks for any errors that might occur during the manipulation of any object within the system.
	class simpl_error{

		public $catagory;
		public $action;
		public $manip_user;

		public $errors = array();

		public function __construct($action,$cat){
			$this->catagory = $cat;
			$this->action = $action;
		}

		//checks for any errors that could happen based on the objects catagory as well as the action taken which will be provided through the POST variable.
		public function simpl_check_errors(){
			switch($this->catagory){
				case "page":
					switch($this->action){
						case "add":
							if(isset($_POST['new_page_title']) && $_POST['new_page_title'] != "" && $this->check_in_db($_POST['new_page_title'])){
								return true;
							}else{
								//if there is an error with adding the page such as a field not being filled out, push the error to the errors array and display them to the user.
								array_push($this->errors,"Error: Page");
							}
						break;
						case "edit":

						break;
					}
				break;

				case "user":

				break;

				case "tag":
					if(isset($_POST['new_tag']) && $_POST['new_tag'] != "" && $this->check_in_db($_POST['new_tag'])){
						return true;
					}else{
						array_push($this->errors,"Error: Tag");
					}
				break;

				case "inv":
					if(isset($_POST['new_inv']) && $_POST['new_inv'] != "" && $this->check_in_db($_POST['new_inv'])){
						return true;
					}else{
						array_push($this->errors,"Error: Investigator");
					}
				break;

				case "med":

				break;
			}
		}

		//function takes the catagory we are working with and finds out if the input provided by the user already exists whithin the databse, really only needs to run when an object is being added.

		//accepts a string parameter because this will be merely checking usernames, titles and labels.
		public function check_in_db($string){
			global $connect;
			global $database_name;

			mysql_select_db($database_name,$connect) or die(mysql_error());

			switch($this->catagory){
				case "page":

					$new_page_title = mysql_real_escape_string($string);

					$sql = "SELECT * FROM pages WHERE title = '$new_page_title'";

					$result = mysql_query($sql,$connect) or die(mysql_error());

					if(mysql_num_rows($result) > 0){
						return false;
					}else{
						return true;
					}
				break;
				case "user":
				break;
				case "tag":
					$sql = "SELECT FROM subjects WHERE lable = '$string'";
					$result = mysql_query($sql,$connect) or die(mysql_error());

					if(mysql_num_rows($result) > 0){
						return false;
					}else{
						return true;
					}
				break;
				case "inv":
					$sql = "SELECT * FROM investigators WHERE inv_name = '$string'";

					$result = mysql_query($sql,$connect) or die(mysql_error());

					if(mysql_num_rows($result) > 0){
						return false;
					}else{
						return true;
					}
				break;
			}
		}

		//if at least one error has been included in the errors array then this function needs to be run to display these errors in HTML format.
		public function display_errors(){
			for($i = 0;$i < sizeof($this->errors);$i++){
				echo $this->errors[$i];
			}
		}
	}
?>