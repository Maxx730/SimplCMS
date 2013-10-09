<?php
	include "config.php";
?>

<!DOCTYPE html>
<html>
	<head>

	</head>
	<body>
		Welcome to SimplCMS, please feel free to install our free software and begin building a new website! Please remember to update the config file so our system will be able to use the server's database.
		<br />
			<form method = "GET" name = "simpl_install">
				Name: <input type = "text" id = "first_admin" placeholder = "Default: 'Administrator'"/>
				<br />
				Database: <input type = "text" id = "database_name" placeholder = "Default: 'simpl_db'"/>
				<br />
				Website Title: <input type = "text" id = "website_name" placeholder = "Default: 'SimplCMS Webpage'"/>
				<div id = "install_success">
					<input type = "submit" value = "Install" onclick = 'create_system()'/>
				</div>
			</form>
	</body>		
	<script type = "text/javascript" src = "js/ajax.js"></script>
</html>