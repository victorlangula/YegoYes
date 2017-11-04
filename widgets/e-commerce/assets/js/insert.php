<?php
	// Fetching Values From URL
	$itemname = $_POST['itemname'];
	$quantity = $_POST['quantity'];
	//$password2 = $_POST['password1'];
	//$contact2 = $_POST['contact1'];
	$connection = mysql_connect("localhost", "yegoyes_newuser", "Admin@YY"); // Establishing Connection with Server..
	$db = mysql_select_db("yegoyse_thedb", $connection); // Selecting Database
	if (isset($_POST['itemname'])) {
	$query = mysql_query("insert into ads(image, link) values('$itemname', '$quantity')"); //Insert Query
	echo "Form Submitted succesfully";
	}
	mysql_close($connection); // Connection Closed
?>