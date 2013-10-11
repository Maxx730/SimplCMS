<?php
	require 'header.php';
?>

<!-- div that holds the title for the page i.e what catagory the user is managing. -->
<div id = "simpl_cat_manage_title"><?php 
	
//make sure there is a catagory set, this is required to make sure that the list object has something to pull data for.
if(isset($_GET['cat']) && $_GET['cat'] != ""){
	$simpl_list = new simpl_list($_GET['cat']);
	//display the correct title.
	$simpl_list->manage_title();
}else{
	//if there is no catagory selected display an error and send back to the dashboard.
	header('location:');
}

 ?> </div>

<?php
	
	//display tables for the objects requested with GET
	$simpl_list->display();

?>

<!-- holds the actions for managing objects such as add,delete etc -->
<div id = "simpl_manage_objects_actions">

<?php
//echo the link to adding a page depending on which catagory is currently being displayed on the manage page.
if($_GET['cat'] == 'med'){
	 echo "
	 <div class = 'simpl_add_new_button'>
	 	<a href = 'simpl_add.php?cat=".$_GET['cat']."'>Upload</a>
	 </div>
	 <div class = 'simpl_add_new_button delete_button'>
	 	<a href = ''>Delete</a>
	 </div>";
}else{

	 echo "
	 <div class = 'simpl_add_new_button'>
	 	<a href = 'simpl_add.php?cat=".$_GET['cat']."&action=add'>Add New</a>
	 </div>
	 <div class = 'simpl_add_new_button delete_button'>
	 	<a href = ''>Delete</a>
	 </div>";

}

?>

</div>

<?php
	require 'footer.php';
?>