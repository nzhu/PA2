<?php

	require("common.php");

	
	// Check for presence of input parameters else die("warning")
	if (empty($_POST["book"]) || empty($_POST["author"]) || empty($_POST["URL"]))
	    die("warning");
	
	//Save the cleaned input data
	$title = mysql_real_escape_string($_POST["book"]);
	$author = mysql_real_escape_string($_POST["author"]);
	$url = mysql_real_escape_string($_POST["URL"]);
	
	//Make sure data is reasonable length
	if (strlen ($title) > 128 || strlen ($author) > 128 || strlen ($url) > 512)
		die("Your inputs are too long");
		
	//Add post into table
	
	mysql_query("INSERT INTO Books (title, author, url) VALUES ('$title', '$author',  '$url')");
	
	//prints out things to be used by index.php
	$result3 = mysql_query("SELECT * FROM Books WHERE title = '$title'");
	$row3 = mysql_fetch_array($result3);
	
	print ($row3["id"]);

	
?>