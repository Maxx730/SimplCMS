<?php

//search object that will find and display information all objects for display
class simpl_search{

	public $term;
	public $username;
	
	//this function takes in a term as well as a user object for search results.
	public function __construct($term,$user){
		$this->term = $term;
		$this->username = $user->return_name();
	}

	//this function will search throughout pages,tags,users etc for the specified search term.
	public function global_search($term){
		$sql_pages = "SELECT * FROM pages";
		$sql_users = "SELECT * FROM users";
		$sql_tags = "SELECT * FROM subjects";
		$sql_investigators = "SELECT * FROM investigators";
	}

	//search function for specific objects, such as pages, tages, users etc.
	public function specified_search($cat,$term){

	}

	//depending on the scope of the search build a list of objects that relate to the search term, meaning that if 
	public function build_results($scope){

	}

}

?>