<?php
	require("common.php");
	
	//check for inputs else warning
	if (empty($_POST["bookid"])||empty($_POST["comment"]))
	   die("warning");

	// Save the cleaned input data
	$comment = mysql_real_escape_string($_POST["comment"]);
	$bookid = mysql_real_escape_string($_POST["bookid"]);
	
	// Make sure data is reasonable length
	if (strlen ($url) > 512)
		die("Your inputs are too long");
		
	//Add post into table
	mysql_query("INSERT INTO Comments (book_uid, comments) VALUES ('$bookid', '$comment')");
	 
?>