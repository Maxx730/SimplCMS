<?php
	
	include "config.php";
	
	/*
		Below checks each field for installation information, if the user did not specify specific information the system will apply default information on its own.
	*/
	
	if(isset($_GET['database_name']) && $_GET['database_name'] != ""){
		$database_name = mysql_real_escape_string($_GET['database_name']);
		
		//opens the info file to remember database names.
		$database_file = "info.txt";
		
		$file_open = fopen($database_file,'w') or die("Unable to open 'info.txt'. Check user permissions on the server.");
		//writes the chosen database name to info.txt
		fwrite($file_open,$database_name);
		fclose($file_open);
	}else{
		$database_name = "simpl_db";
		//opens the info file to remember database names.
		$database_file = "info.txt";
		$file_open = fopen($database_file,'w') or die("Unable to open 'info.txt'. Check user permissions on the server.");
		//writes the chosen database name to info.txt
		fwrite($file_open,$database_name);
		fclose($file_open);
	}
	
	//checks if the user chose a username for the administrator, otherwise defaults to admin.
	if(isset($_GET['first_admin'])){
		$first_admin = mysql_real_escape_string($_GET['first_admin']);
	}else{
		$first_admin = "administrator";
	}
	
	global $connect;
	
	$create_database = "CREATE DATABASE $database_name";
	mysql_query($create_database,$connect) or die(mysql_error());
	
	mysql_select_db($database_name) or die(mysql_error());
	
	$createRoles = "CREATE TABLE roles(rID INT NOT NULL ,name VARCHAR(30) NOT NULL,PRIMARY KEY(rID))";
	$createSubjects = "CREATE TABLE tags(tID INT NOT NULL AUTO_INCREMENT,label VARCHAR(50),PRIMARY KEY(tID))";
	$createUsers = "CREATE TABLE users(uID INT NOT NULL AUTO_INCREMENT,username VARCHAR(20) NOT NULL,password VARCHAR(30) NOT NULL,firstname VARCHAR(30),lastname VARCHAR(30),about VARCHAR(200),PRIMARY KEY(uID),rID INT NOT NULL,FOREIGN KEY(rID) REFERENCES roles(rID))";
	$createPages = "CREATE TABLE pages(pID INT NOT NULL AUTO_INCREMENT,title VARCHAR(40) NOT NULL,author VARCHAR(50),content VARCHAR(200000),uID INT,parentID INT,PRIMARY KEY(pID),FOREIGN KEY(uID) REFERENCES users(uID),FOREIGN KEY(sID) REFERENCES subjects(sID))";
	//table holds information on which page will be the hompage.
	$createHomepage = "CREATE TABLE homepage(pID INT NOT NULL,title VARCHAR(40) NOT NULL,PRIMARY KEY(pID))";
	
	/*
		Creates the tables from the sql before.
	*/
	
	mysql_query($createRoles,$connect) or die(mysql_error());
	mysql_query($createThemes,$connect) or die(mysql_error());
	mysql_query($createSubjects,$connect) or die(mysql_error());
	mysql_query($createUsers,$connect) or die(mysql_error());
	mysql_query($createPages,$connect) or die(mysql_error());
	mysql_query($createHomepage,$connect) or die(mysql_error());
	
	/* 
		Below inserts default values into the database.
	*/
	
	$createRoles0 = "INSERT INTO roles VALUES(0,'admin')";
	$createRoles1 = "INSERT INTO roles VALUES(1,'editor')";
	$createRoles2 = "INSERT INTO roles VALUES(2,'author')";
	$createAdmin = "INSERT INTO users(username,password,rID) VALUES('$first_admin','',0)";
	$createSubject = "INSERT INTO subjects(sID,label) VALUES(0,'NONE')";
	$defaultPage = "INSERT INTO pages(title,author,content,uID) VALUES('First Page','simpldb','Welcome to SimplCMS! This is the first page on the new website.',1)";
	$setHome = "INSERT INTO homepage(pID,title) VALUES(1,'First Page')";
	
	mysql_query($createRoles0,$connect) or die(mysql_error());
	mysql_query($createRoles1,$connect) or die(mysql_error());
	mysql_query($createRoles2,$connect) or die(mysql_error());
	mysql_query($createAdmin,$connect) or die(mysql_error());
	mysql_query($createSubject,$connect) or die(mysql_error());
	mysql_query($defaultPage,$connect) or die(mysql_error());
	mysql_query($setHome,$connect) or die(mysql_error());

?>