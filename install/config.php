<?php
	/*
		Config file for SimplCMS, please input database information below.  This information will give objects and classes access to send a receive data stored within the database.
		
		Host: database host url, it is not reccomended to use localhost unless used for development purposes.
		Username: 
	*/
	
	$host = "localhost";
	$username = "root";
	$password = "";

	$connect = mysql_connect($host,$username,$password);
	
	//use this variable as the server root directory for organizational purposes.
	$simpl_root = $_SERVER['DOCUMENT_ROOT']."dev/simplCMS";
	
	//reads the databse file that was written to save the database name chosen
	$database_file = $simpl_root."/install/info.txt";
	$database_file_open = fopen($database_file,'r') or die("Error: Unable to open file 'info.txt'.");
	$database_name = fread($database_file_open,filesize($simpl_root.'/install/info.txt'));
	
	fclose($database_file_open);
?>