<?php
	require('header.php');

	//checks if there has been a user sent through GET, if there has been then create a new user object to grab info about the user.  Else display an error that the user has not been selected.
	if(isset($_GET['user']) && $_GET['user'] != "" && $check_login->check_user_exists($_GET['user'])){
		$profile_user = new user($_GET['user']);
	}else{

		//determine whether the user just doesnt exist or the GET request was simply blank.
		if($check_login->check_user_exists($_GET['user']) == false && $_GET['user'] != ""){
		echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: User does not exist.</div></div>";
		}else{
		echo "<div class = 'simpl_error'><img src = 'img/error.png'/><div class = 'simpl_error_text'>Error: User has not been defined.</div></div>";			
		}

	}
?>

<div id = "user_profile_main_content">
	<!-- DIV holds action buttons for user profiles such as messaging, editing, etc. -->
	<div id = "user_profile_interactions">
		<div class = "user_profile_button">Edit</div>
		<div class = "user_profile_button">Message</div>
	</div>

	<div id = "user_profile_title"><?php
		echo $profile_user->return_name();
		//displays the chosen user's personal information, such as full name as well as thier about information.
		$profile_user->user_personal_info();
	?></div>

	<?php

	?>

	<?php
		$user_stats = new simpl_stats($profile_user);

		$user_stats->display_user_stats();
	?>

</div>

<?php
	require('footer.php');
?>