<?php
	
	/*
		The global info file includes all the classes and information needed to run the system efficiently.  This file searches through required directories and includes each file within each directory. By including this file within the header of all simplcms administration files there will be functionality on each of these pages.
	*/
	
	//includes all the class files of the current directory.
	$directory = $_SERVER['DOCUMENT_ROOT']."dev/SimplCMS/sim_admin/includes/";
	$dh = opendir($directory);
	
	//reads the directory where all the functionality resides and includes only those files starting with simpl.
	while($array = readdir($dh)){

		if(substr($array,0,5) == "simpl"){
			require($array);
		}
	}

	//includes the config file for all information regarded connection to and from the database on the server.
	$root =  $_SERVER['DOCUMENT_ROOT']."dev/SimplCMS/install/config.php";
	require($root);	

?>