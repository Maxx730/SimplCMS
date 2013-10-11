<?php
	require 'header.php';

	//make sure there is a catagory set, this is required to make sure that the list object has something to pull data for.  Only look for the title information because this information is the only REQUIRED infromation, other than author which will default to the current user if not given.
	//this only applys to users and pages and is only checking if they need to be added to the database otherwise they will  simply create the fields with the previous information in them.
	if(isset($_POST['cat']) && isset($_POST['action']) && isset($_POST['new_simpl_title']) && $_POST['new_simpl_title'] != ""){
		//initiate the global logged user to create a manipulation object.
		global $logged_user;
		$manipulator = new simpl_manipulator($logged_user->return_name());

		//edit page will only be adding pages and users since those are the only two objects worth editing.
		$manipulator->add($_POST['cat']);
	}else{
		$error = "";

		echo $error;
	}

	
?>

<?php
	require 'footer.php';
?>