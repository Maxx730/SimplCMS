//This class will be used to create ajax events depending on what action is being taken.
function ajax_manipulation(){

	//create the objects properties which will be what we are manipulation as well as how.
	this.ajax_action = ajax_action;
	this.check_working = check_working;
}

//generic ajax function that is affected depending on what actions and objects are being manipulated.
function ajax_action(catagory,action){
	var script_src = "";
	//create the XML object to send data to and from the database.
	var xmlhttp = new XMLHttpRequest();
	var response_div = document.getElementById('ajax_response');
			
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				response_div.innerHTML = xmlhttp.responseText;
			}else{
				response_div.innerHTML = "Loading...";
			}
		}
		
		//send the get iformation to the same page where the manipulation object will then execute the action.	
		xmlhttp.open("GET","includes/simpl_take_action.php?manip_object="+catagory+"&manip_action="+action,false);
		xmlhttp.send();	  
}

function check_working(){
	alert("working");
}

//initialize this object GLOBALLY so that it can be referenced everywhere on the document.
var ajax_manip = new ajax_manipulation();

//this function will be used to actually initiate the objects functions, since we cannot seem to have objects inside of onclick actions.
function take_action(action,catagory){
	ajax_manip.ajax_action(catagory,action);
}