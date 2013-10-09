<?php
	require 'header.php';

	//make sure there is a catagory set, this is required to make sure that the list object has something to pull data for.
	if(isset($_GET['cat']) && $_GET['cat'] != ""){
		$manipulator = new simpl_manipulator($check_login->username);
	}else{
		//if there is no catagory selected display an error and send back to the dashboard.
		header('location:');
	}

	$manipulator->display_fields('edit',$_GET['cat']);
?>

<?php
	require 'footer.php';
?>