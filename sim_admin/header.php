<?php
	//By including this file, all the functionality for objects is possible with the exception of user roles.
	require 'includes/global_info.php';
	
	//creates the administration object that will check permission information later.
	$check_login = new simpl_administration();

	//checks if there is a logged in user, if there is not the page is redirected to the login form.
	if($check_login->simpl_check_login()){
		$logged_user = new user($check_login->username);
	}
?>

<html>	
	<head>
		<div id = "simpl_wrapper">
		<!-- script below creates a javascript manipulation object which handles most AJAX actions when manipulating the system. -->
		<script type = "text/javascript" src = "../js/simpl_manipulation.js"></script>

		<!-- link to main stylesheet used throughout the system. -->
		<link rel = "stylesheet" href = "/dev/simplCMS/sim_admin/common/style.css" type = "text/css"/>

		<!-- div that holds information and actions generic to all users whether admin or not. i.e Logout,Profile,History etc. -->
		<div id = "simpl_user_function_menu">

			<!-- SimplCMS title for the entire system -->
			<div id = "system_title">SimplCMS</div>

			<!-- standard pages which relate to each user such as mail and profile information. -->
			<div id = "simpl_user_pages">
				<!-- !!!NOTE!!! before finishing up the CMS make sure to figure out a way to figure out where the default folder is. -->
				<a href = "/dev/simplCMS/sim_admin/inbox/">Inbox</a>
				|

				<!-- code below builds the profile link after the user object has been initiated. -->
				<?php echo "<a href = '/dev/simplCMS/sim_admin/simpl_profile.php?user=".
				 $logged_user->return_name()."'>Profile</a>"

				 ?>
				|
				<a href = "../sim_login/?logout=true">Logout</a>
			</div>
		</div>

		<!-- this div holds the pages for each catagory within the databse. -->
		<div id = "simpl_main_cat_menu">
			<!--
				Main administration menu below.  Most links will go to manage.php with cat being the GET information that determines what information to show within the list object.
			-->
			<ul id = "simpl_main_menu">
				<li class = "simpl_menu_link"><a href = "index.php">Dashboard</a></li>
				<li class = "simpl_menu_link"><a href = "/dev/simplCMS/sim_admin/simpl_manage.php?cat=page">Pages</a></li>
				<li class = "simpl_menu_link"><a href = "/dev/simplCMS/sim_admin/simpl_manage.php?cat=user">Users</a></li>
				<li class = "simpl_menu_link"><a href = "/dev/simplCMS/sim_admin/simpl_manage.php?cat=tag">Tags</a></li>
				<li class = "simpl_menu_link"><a href = "/dev/simplCMS/sim_admin/simpl_manage.php?cat=inv">Investigators</a></li>
				<li class = "simpl_menu_link"><a href = "/dev/simplCMS/sim_admin/simpl_manage.php?cat=med">Media</a></li>
				<li class = "simpl_menu_link"><a href = "">Preferences</a></li>
			</ul>
		</div>
		
	</head>
	<body>

	<!-- main content div holder, major user is primarily for the top highlight, purely asthetic. -->
	<div id = "simpl_main_page_content">
