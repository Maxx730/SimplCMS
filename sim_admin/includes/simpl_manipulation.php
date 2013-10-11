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
			
			//only change the display between editing and adding if the catagory is pages or users because these are the only two items worth editing, otherwise just show the add page.
			if($cat == "page" || $cat == "user"){
				//output changes based on what action is chosen which then will change the where the form data will go also whether or not to input the corrent information.
				switch($action){
					case "add":
						$form ="<div id = 'object_manipulation'>
							<form name = 'simpl_add_object' action = 'simpl_edit.php' enctype = 'multipart/form-data'";

							//find out which catagory to edit.
							switch($cat){
								case "page":
									$form .= " method = 'POST'>
										<img src = 'img/cat_icons/document-add.png'/>Add Page
										<br />
										<input type = 'text' name = 'new_page_title' placeholder = 'Title'/>
										<br />
											<input type = 'text' name = 'new_page_author' placeholder = '".$this->username." (Author)'/>
											<br />
												<textarea id = 'simpl_page_content'>
												</textarea>
											<br />
											<input type = 'text' name = 'cat' style = 'display:none;' value = 'page'/>

											<input type = 'text' name = 'action' style = 'display:none;' value = 'add'/>

												<input type = 'submit' value = 'Create'/>";
								break;

								case "user":
									$form .= " method = 'POST'>
										<img src = 'img/cat_icons/user-4-add.png'/>Add User
										<br />
											<input type = 'text' name = 'new)user_name' placeholder = 'Username'/>
										<br />
											<input type = 'password' name = 'new_user_password' placeholder = 'Password'/>
										<br />
											<input type = 'password' name = 'new_user_check_password' placeholder = 'Repeat Password'/>";
								break;
							}

					break;

					case "edit":
						$form = "<div id = 'object_manipulation'>
						<form name = 'simpl_edit_object' action = 'simpl_edit.php' enctype = 'multipart/form-data'";

						//find out which catagory to edit.
						switch($cat){
							case "page":

							break;

							case "user":

							break;
						}

					break;
				}
			}else{

				$form = "<div id = 'object_manipulation'>
				<form name = 'simpl_add_object' action = 'simpl_add.php' enctype = 'multipart/form-data'";

				//if the catagory is not page or user, then switch between objects that do not need to have an edit page.
				switch($cat){


					case "tag":
						$form .= " method = 'POST'>
						Add Tag
						<br />
						<input type = 'text' name = 'new_tag' placeholder = 'New Tag'/>
						<br />
						<input type = 'text' style = 'display:none' name = 'cat' value = 'tag'/>
						<input type = 'text' style = 'display:none' name = 'action' value = 'add'/>
						<input type = 'submit' value = 'Create'/>";

						//create a tag list since there will only be need for one page to add and delete tags.
						$tag_list_div = "<div id = ''>";
							$tag_list = new simpl_list("tag");
							$tag_list_div .= $tag_list->display();
						$tag_list_div .= "</div>";
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

			}

			return $form .= "</div></form>";
		}


		//adds information to the database depending on which catagory the user chose.
		public function add($cat){
			$sql = "INSERT INTO ";

			switch($cat){

				//if the catagory is page, adjust the sql accordingly.
				case "page":
					global $connect;
					global $database_name;

					if(isset($_POST['new_page_title']) && $_POST['new_page_title'] != ""){
						
						$title = mysql_real_escape_string($_POST['new_page_title']);
						$sql .= "pages(title,author,content,parentID) VALUES('$title'";
					}

					//content is allowed to be blank, only the title and the author are not allowed to be blank.
					if(isset($_POST['new_page_content'])){
						$content = mysql_real_escape_string($_POST['content']);
						$sql .= ",'$this->username','$content'";
					}else{
						$sql .= ",'$this->username',''";
					}

					//if there happends to be a parent ID then set it otherwise keep it null.
					if(isset($_POST['page_parent_id'])){
						$parentID = $_POST['page_parent_id'];
					}else{
						$parentID = NULL;
					}

					$sql .= ",'$parentID')";

					//make sure that the current user is at least and administrator or author before adding page to database.
					if($this->role != 0 || $this->role != 1){
						mysql_query($sql,$connect) or die(mysql_error());
					}else{
						$error = "";
						echo $error;
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
					$sql .= "SUBJECTS(label,author)";
				break;

				//case for media
				case "med":
					//make sure that the logged user is initialized as a global object before creating a new media object.
					global $logged_user;
					$new_media = new simpl_media($logged_user);
					$new_media->upload($_FILES['new_upload_file']);
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