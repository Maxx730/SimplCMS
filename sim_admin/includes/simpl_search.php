<?php

//search object that will find and display information all objects for display
class simpl_search{

	public $term;
	public $username;
	public $scope;

	//these might need to be arrays depending on how we want to use the query information once we contact the database.
	public $page_results;
	public $user_results;
	public $tag_results;
	public $investigator_results;
	
	//this function takes in a term as well as a user object for search results.
	public function __construct($term,$user){
		$this->term = $term;
		$this->username = $user->return_name();
	}

	//this function will search throughout pages,tags,users etc for the specified search term.
	public function global_search($term){
		$sql_pages = "SELECT * FROM pages WHERE ";
		$sql_users = "SELECT * FROM users";
		$sql_tags = "SELECT * FROM subjects";
		$sql_investigators = "SELECT * FROM investigators";
	}

	//search function for specific objects, such as pages, tages, users etc.
	public function specified_search($cat,$term){
		$sql = "SELECT * FROM";
	}

	//depending on the scope of the search build a list of objects that relate to the search term, meaning that if 
	public function build_results(){
		if($this->scope == 'global'){

		}else{

		}
	}

}

?>