<?php

	//this class handles all the functions necessary to update,delete and add different obhjects within the system depending on role permissions.
	class simpl_manipulator{

		public $role;
		public $userID;
		public $username;

		public function __construct($user){

			//grab the logged in user's authentication information on object construction.
			$new_user = new user($user);

			//create two objects for checking role and grabbing user information.
			$this->userID = $new_user->uID;
			$this->username = $new_user->name;
		}

		//function displays fields for editing content depending on the catagory chosen.
		public function display_fields($action,$cat){
			$form = "<div id = 'object_manipulation'><form name = 'simpl_add_object' action = 'simpl_add.php' enctype = 'multipart/form-data'";

			switch($cat){
				case "page":
					$form .= " method = 'POST'><input type = 'text' style = 'display:none;' name = 'cat' value = 'page'/><input type = 'text' name = 'page_title' placeholder = 'Page Title' class = 'add_title_input'/>
					<br />
					<input type = 'text' name = 'page_author' placeholder = '".$this->username."'/><br /><textarea name = 'page_content'></textarea>
							<br />
					<select name = 'page_tags'>
					".
					$this->find_tags()
					."
					</select>
					<br />
					<input type = 'submit' value ='Add'/>
					<br />
					<input type = 'submit' value = 'Create'/>";
				break;

				case "user":
					$form .= "<input type = 'text' name = 'new_username' placeholder = 'Desired Username'/>
					<br />
					<input type = 'password' name = 'new_password' placeholder = 'Password'/>
					<br />
					<input type = 'password' name = 'new_password_check' placeholder = 'Repeat Password'/>
					<br />
					<br />
					<input type = 'text' name = 'new_first_name' placeholder = 'First Name'/>
					<br />
					<input type = 'text' name = 'new_last_name' placeholder = 'Last Name'/>
					<br />
					<textarea name = 'new_user_about'>

					</textarea>
					<br />
					<input type = 'submit' value = 'Submit'/>";
				break;

				case "tag":
					$form .= "<input type = 'text' name = 'new_tag' placeholder = 'New Tag'/>
					<br />
					<input type = 'submit' value = 'Create'/>";
				break;

				case "med":
					$form .= " method = 'POST'> <input type = 'text' style = 'display:none;' name = 'cat' value = 'med'/><input type = 'text' name = 'manip_action' value = 'true' style = 'display:none'/><input type = 'text' name = 'manip_action_type' value = 'add' style = 'display:none'/>
					<div class = 'object_add_title'>
						File Upload
					</div>
					<br />
					<input type = 'file' name = 'new_upload_file' id = 'upload_file_chooser'/>
					<br />
					<input type = 'text' placeholder = 'File Name' name = 'file_upload_name' id = 'upload_file_name'/>
					<input type = 'submit' value = 'Upload' id = 'file_upload_button'/>";
				break;
			}

			echo $form .= "</div></form>";
		}


		//adds information to the database depending on which catagory the user chose.
		public function add($cat){
			$sql = "INSERT INTO ";

			switch($cat){

				//if the catagory is page, adjust the sql accordingly.
				case "pages":
					if(isset($_POST['page_title']) && $_POST['page_title'] != ""){
						$title = mysql_real_escape_string($_POST['page_title']);
						$sql .= "pages(title,author,content,parentID) VALUES('$title'";
					//content is allowed to be blank, only the title and the author are not allowed to be blank.
					}else if(isset($_POST['page_content'])){
						$content = mysql_real_escape_string($_POST['content']);
						$sql .= ",'$this->userID','$content'";
					}

					//if there happends to be a parent ID then set it otherwise keep it null.
					if(isset($_POST['page_parent_id'])){
						$parentID = $_POST['page_parent_id'];
					}else{
						$parentID = NULL;
					}

					$sql .= ",'$parentID')";
					global $connect;

					//make sure that the current user is at least and administrator or author before adding page to database.
					if($this->role != 0 || $this->role != 1){
						mysql_query($sql,$connect) or die(mysql_error());
					}else{

					}
					
				break;

				//case for user
				case "user":
					global $connect;
					global $database_name;

					//make sure the new tag field is at least set and is not blank.
					if(isset($_GET['new_tag']) && $_GET['new_tag'] != ''){
						//clean the new tag to protect against SQL injection.
						$chosen_label = mysql_real_escape_string($_GET['new_tag']);

						mysql_select_db($database_name) or die(mysql_error());

						//first check if the tag already exists, if so unable to make multiple tags with the same label.
						$sql = "SELECT * FROM subjects WHERE label = '$chosen_label'";
						$result = mysql_query($sql,$connect) or die(mysql_error());

						if(mysql_num_rows($result) < 1){
							//if there are less than one rows that match the chosen label, then the user is allowed to create the new tag.
							$sql = "INSERT INTO subjects(label) VALUES('$chosen_label')";
							mysql_query($sql,$connect) or die(mysql_error());
						}else{
							$error = "Tag(s) with this label already exist.";

							echo $error;
						}

					}else{
						$error = "Tag must contain characters or numbers and cannot be blank.";

						echo $error;
					}

				break;

				//case for tag
				case "tag":

				break;

				//case for media
				case "med":
					//make sure that the logged user is initialized as a global object before creating a new media object.
					global $logged_user;
					$new_media = new simpl_media($logged_user);

				break;
			}
		}

		//this function will find the action that the user wants to execute and then execute it.
		public function grab_action($action,$cat){
			switch($action){
				case "add":
					$this->add($cat);
				break;
				case "delete":
					$this->delete($cat);
				break;
				case "edit":
					$this->edit($cat);
				break;
			}
		}

		public function delete($cat){

		}

		public function edit($cat){

		}

		public function tag($cat){

		}

		//function will produce a select lista of tags, originally for pages but can be used on other objects as well.
		public function find_tags(){

			global $connect;
			global $database_name;

			mysql_select_db($database_name,$connect) or die(mysql_error());

			$sql = "SELECT * FROM subjects";

			$result = mysql_query($sql,$connect) or die(mysql_error());
			

			$final = "";

			while($array = mysql_fetch_array($result)){
				$final .= "<option>".$array['label']."</option>"; 
			}


			return $final;
		}

	}
	
?>