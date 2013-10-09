<?php

/*
	This file includes general functions needed to ensure sessions to check whether or not users are logged in.
*/

class simpl_administration{

	public $username;
	public $role;
	public $id;
	
	//calls a function to check if the user is logged in, if they are the function will also set class values. This function will also create a new user object which it will use to grab the class values.
	public function __construct(){
		
	}
	
	//checks if there is a logged in user, if not it will redirect the user to the login page.
	public function simpl_check_login(){
		session_start();
		if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
			$this->username = $_SESSION['username'];

			//create a user object on every check of login for each page.
			$logged_user = new user($this->username);

			return true;
		}else{
			header("location:../sim_login/");
		}
	}

	//check login and start session if user is logged in.
	public function check_login_info($username,$password){

		global $connect;
		global $database_name;

		mysql_select_db($database_name,$connect);
		
		$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$result = mysql_query($sql,$connect) or die(mysql_error());
		
		if(mysql_num_rows($result) > 0){

			//use the results to find out information like the users id and other things.
			$array = mysql_fetch_array($result) or die(mysql_error());

			session_start();
			$this->id = $array['uID'];
			$_SESSION['username'] = $username;
			echo $this->id;
			return true;
		}else{
			return false;
		}
	}

	public function register($username,$password1,$password2){

	}

	//use this function to check if a user actually exists within the simplCMS database. 
	public function check_user_exists($check_user){

		global $connect;
		global $database_name;

		mysql_select_db($database_name,$connect);

		$sql = "SELECT * FROM users WHERE username = '$check_user'";
		$result = mysql_query($sql,$connect) or die(mysql_error());

		if(mysql_num_rows($result) > 0){
			return true;
		}else{
			return false;
		}
	}
}

?>