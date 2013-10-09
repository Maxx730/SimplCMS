<?php
	//this class checks for any errors that might occur during the manipulation of any object within the system.
	class simpl_error{

		public $catagory;

		public function __construct($cat){
			$this->catagory = $cat;
		}

		//checks for any errors that could happen based on the objects catagory as well as the action taken which will be provided through the POST variable.
		public function simpl_check_errors($action){
			switch($this->catagory){
				case "page":
					echo "working";
				break;
			}
		}
	}
?>