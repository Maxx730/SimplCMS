<?php
	//this class checks for any errors that might occur during the manipulation of any object within the system.
	class simpl_error{

		public $catagory;
		public $action;
		public $manip_user;

		public $errors = new array();

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
							if(isset($_POST['new_page_title']) && $_POST['new_page_title'] != ""){
								return true;
							}else{
								//if there is an error with adding the page such as a field not being filled out, push the error to the errors array and display them to the user.
								array_push($this->errors,"");

								echo $this->errors;
							}
						break;
						case = "edit":

						break;
					}
				break;

				case "user":

				break;

				case "tag":
					if(isset($_POST['new_tag']) && $_POST['new_tag'] != ""){
						return true;
					}else{
						array_push($this->errors,"");
						echo $this->errors;
					}
				break;

				case "inv":
					if(isset($_POST['new_inv']) && $_POST['new_inv'] != ""){

					}else{

					}
				break;

				case "med":

				break;
			}
		}

		//function takes the catagory we are working with and finds out if the input provided by the user already exists whithin the databse, really only needs to run when an object is being added.
		public function check_in_db(){
			switch($this->catagory){

			}
		}
	}
?>