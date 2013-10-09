
//Ajax function for creating the initial system.
//database_name 		var(string) optional
//admin_name				var(string) optional
function create_system(){
	var database_name = document.getElementById('database_name').value;
	var admin_name = document.getElementById('first_admin').value;
	var xmlhttp = new XMLHttpRequest();
				
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById('install_success').innerHTML = xmlhttp.responseText;
		}
					
		else{
			document.getElementById('install_success').innerHTML = "Loading...";
		}
	}
				
	xmlhttp.open("GET","install.php?database_name="+database_name+"&first_admin="+admin_name,false);
	xmlhttp.send();
}