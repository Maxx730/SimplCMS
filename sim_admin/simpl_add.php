<?php
	require 'header.php';

	//check if the user is actually trying to add something otherwise simply supply the fields to edit the object.  If there two POSTs are supplied then the user is actually trying to add an object to the databse.
	if(isset($_POST['cat']) && isset($_POST['action'])){
		
			//create a minpulation object to manipulate what ever object in the databse is needed.
			$manipulation_object = new simpl_manipulator($check_login->username);

			//find out how the user wants to manipulate the chose object.
			$manipulation_object->grab_action($_POST['action'],$_POST['cat']);

	}else{
		//make sure there is a catagory set, this is required to make sure that the list object has something to pull data for. 
		if(isset($_GET['cat']) && $_GET['cat'] != ""){
			$manipulator = new simpl_manipulator($check_login->username);
			$manipulator->display_fields('add',$_GET['cat']);
			//if the user has added/edited/deleted something, this will check if the action was taken and take the according actions.
			if(isset($_GET['manip_action']) && $_GET['manip_action'] != "" && isset($_GET['manip_object']) && $_GET['manip_object'] != ""){
			//create a new manipulation object which is required to have a user for purposes of permissions.
				echo "working";
			}

		//check if it is actually just POST data because the user did not fill in the correct amount of data fields. 
		}
	}
?>

<?php
	require 'footer.php';
?>