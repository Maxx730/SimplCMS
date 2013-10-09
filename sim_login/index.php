<?php
	//needed for login checking by creating the administration object.
	require '../sim_admin/includes/global_info.php';

	$check_login_info = new simpl_administration();

	//if logout is true then destroy the session and then make sure the GET value is gone by redirecting to index.php without the get value.
	if(isset($_GET['logout']) && $_GET['logout'] == true){
		session_start();
		session_destroy();

		header("location:index.php");
	}else{

	//make sure there is post data to check if the login information is correct, otherwise they will see the information html below.
	if(isset($_POST['login_username']) && isset($_POST['login_password'])){

		//if login information is correct, send the user to the dashboard page.
		if($check_login_info->check_login_info($_POST['login_username'],$_POST['login_password'])){
			header("location:../sim_admin");
		}else{
			$error = "Username or Password is incorrect.";
			echo $error;
		}
		
	}else{
		$error = "Please make sure to fill out both fields.";
		echo $error;
	}
}
?>

<!-- if the user is logged in, they will be redirected to the dashboard, otherwise they will see this form to log in. -->
<form name = "simpl_login" action = "#" method = "POST">
	<input type = "text" name = "login_username"/>
	<br />
	<input type = "password" name = "login_password"/>
	<br />
	<input type = "submit" value = "Login"/>
</form>