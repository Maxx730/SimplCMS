<?php

class user{
	
	//information needed about user for basic functionality such as adding deleting and updating different objects depending on the role the user has assigned to them.
	public $name;
	public $uID;
	private $currentPass;
	private $role;
	public $firstname;
	public $lastname;
	public $about;

	//constructs a new user object and grabs all the information needed about the user.
	public function __construct($name){
		global $connect;
		global $database_name;

		mysql_select_db($database_name);
		$sql = "SELECT * FROM users WHERE username = '$name'";
		$result = mysql_query($sql,$connect) or die(mysql_error());
		$array = mysql_fetch_array($result);
		
		$this->uID = $array['uID'];
		$this->currentPass = $array['password'];
		$this->role = $array['rID'];
		$this->name = $name;
		$this->firstname = $array['firstname'];
		$this->lastname = $array['lastname'];
		$this->about['about'];
	}
	
	private function check_perm($action,$object){
		if($this->role == 0){
			return true;
		}else if($this->role == 1){
			if($object == 'user' && $action == 'add' || $action == 'delete' || $action == 'update' ){
			
			}
		}else{
			
		}
	}

	//returns the current user objects name.
	public function return_name(){
		return $this->name;
	}

	//returns the current user objects id.
	public function return_id(){
		return $this->uID;
	}

	/*
	returns the current user's role id number.
		Admin - 0
		Author - 1 
		Editor - 2
	*/

	public function return_role(){
		return $this->role;
	}

	//this function displays the user information in a neat table, mostly only going to be used for the user profile page.
	public function user_personal_info(){
		$final = "<table id = 'user_profile_info'>
			<tr><td>Full Name:</td><td>".$this->firstname." ".$this->lastname."</td></tr>
			<tr><td>About: </td></tr>
			<tr><td>".$this->about."</td></tr>
		</table>";

		echo $final;
	}

}
?>