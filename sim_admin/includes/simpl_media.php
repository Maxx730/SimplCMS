<?php
	//the simpl_media object will handle all of the interactions between media and the user, from uploading images/files to deleting and viewing them.
	class simpl_media{

		public $user_role;
		public $upload_folder;
		public $upload_user_name;

		//class takes in the user object to check for the user's credentials, if the user has the corrent credentials they will be able or not able to do certain things to uploaded files within the system.
		public function __construct($user){
			$this->user_role = $user->return_role();
			$this->upload_user_name = $user->return_name();
			$this->upload_folder = "/dev/simplCMS/sim_admin/uploads/";

			$new_file = new simpl_file($_FILES['new_upload_file']);
		}

		//this function will upload a file to the database/upload folder.
		public function upload($file){
			if($this->user_role == 0 || $this->user_role == 1 && isset($_POST['upload_file_name']) && $_POST['upload_file_name'] != "" && isset($_POST['file_url']) && $_POST['file_url'] != ""){

				//clean the file name and url to prevent SQL injection.
				$new_file_name = mysql_real_escape_string($_FILES['new_upload_file']['name']);
				$new_file_url = mysql_real_escape_string($_FILES['new_upload_file']['tmp_name']);

				$file_to_upload = new simpl_file($file);
				
			}else{
				echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: Permissions.</div></div>";	
			}
		}

		//this function will delete a file from the database. Only administrators are allowed to delete files from the CMS.
		public function delete($file){
			if($this->user_role == 0){

			}else{
				echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: User does not exist.</div></div>";	
			}
		}

		//anyone regardless of credentials are allowed to view files winthin the CMS
		public function view($file){

		}
	}

	//this class will initiate a simple file which will then be passed onto the media object.
	class simpl_file{

		public $file_name;
		public $file_url;
		public $uploaded_user;
		public $file_ext;

		//holds all the allowed extensions for files, really the only files that will be allowed will be image files, pdfs, docs and the possibility to choose more. NEVER ALLOW EXES!!!
		public $allowed_ext = array("image/jpeg","image/jpg","image/png","image/bmp","pdf","doc","docx");

		//allowed file size in bytes, this is 10MB which might need to be increased to about 25MB due to the size of PDF file sizes.
		public $allowed_file_size = 10485760;

		//send the actual post data file object into this function to construct out file object for specific functions pertaining to uploading and managing files.
		public function __construct($file){
			
			//check to make sure all the file information is correct before even creating a file object to then upload onto the server.
			if(isset($_FILES['new_upload_file']) && $_FILES['new_upload_file']['name'] != "" && $this->check_file_type($_FILES['new_upload_file']['type']) && $this->check_file_size($_FILES['new_upload_file']['size'])){

				$this->file_name = $_FILES['new_upload_file']['name'];
				$this->file_ext = $_FILES['new_upload_file']['type'];
			}else{
				//display an error if the file does not meet the expected standards, the errors for file size or file type should be pushed to an error object that needs to be created.
				echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: File does not meet the requirements.</div></div>";					
			}
			
			//initialize the logged in user.
			global $logged_user;
			$check_user = new simpl_administration();
			
			//make sure the user uploading is actually a user within the database, most of the time it will always be the logged in user but just for security check who is actually uploading the file.
			if($check_user->check_user_exists($logged_user->return_name())){
				$this->uploaded_user = $logged_user->return_name();
			}else{
				echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: User does not exist.</div></div>";				
			}

		}	

		//check to make sure the file is in the array of allowed file types and return accordingly.
		public function check_file_type($type){
			if(in_array($type,$this->allowed_ext)){
				return true;
			}else{
				return false;
			}
		}

		//checks to make sure the file is under or at the allowed file size for uploading, this will be generous when coming to PDFs since they will in general be larger than the average image.
		public function check_file_size($size){
			if($size <= $this->allowed_file_size){
				return true;
			}else{
				return false;
			}
		}
		
	}

?>