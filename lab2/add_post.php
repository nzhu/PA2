<?php

	
	require("common.php");

	
	// TODO 2: Check for presence of input parameters else die("warning")
	if (empty($_POST["title"]) || empty($_POST["author"]) || 
	    empty($_POST["URL"]))
	    die("warning");
	
	// TODO 2: Save the cleaned input data
	$title = mysql_real_escape_string($_POST["title"]);
	$author = mysql_real_escape_string($_POST["author"]);
	$url = mysql_real_escape_string($_POST["URL"]);
	
	// TODO 2: Make sure data is reasonable length
	if (strlen ($title) > 128 || strlen ($author) > 128 || strlen ($url) > 512)
		die("Your inputs are too long");
		
	// TODO 2: Add post into table
	
	mysql_query("INSERT INTO Books (title, author, url) VALUES ('$title', '$author',  '$url')");
	
	$result3 = mysql_query("SELECT * FROM Books WHERE title = $title");
	$row3 = mysql_fetch_array($result3);

	print ($row3["id"]);

	
?>