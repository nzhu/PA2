<?php

	
	require("common.php");

	
	//Check for presence of input parameters else alert
	if (empty($_POST["title"]) || empty($_POST["author"]) || empty($_POST["URL"]))
	{    
		print("empty");
	}
	
	// Make sure data is reasonable length
	else if (strlen ($_POST["title"]) > 128 || strlen ($_POST["author"]) > 128 || strlen ($_POST["URL"]) > 512)
	{
		print("long");
	}

	else
	{
		//Save the cleaned input data
		$title = mysql_real_escape_string($_POST["title"]);
		$author = mysql_real_escape_string($_POST["author"]);
		$url = mysql_real_escape_string($_POST["URL"]);
	
		$check = mysql_query("SELECT * FROM Books WHERE title = '$title'");
		if (mysql_fetch_array($check)!=false)
		{
			print("exists");
		}
		else
		{
		//Add post into table
	
		mysql_query("INSERT INTO Books (title, author, image_url) VALUES ('$title', '$author',  '$url')");
	
		$result3 = mysql_query("SELECT * FROM Books WHERE title = '$title'");
		$row3 = mysql_fetch_array($result3);

		print ($row3["uid"]);
		}
	}
	
?>