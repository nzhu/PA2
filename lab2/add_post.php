<?php

	require("common.php");

	if (empty($_POST["title"]) || empty($_POST["url"]) || empty($_POST["description"]))
		die("warning");

	$title= mysql_real_escape_string($_POST["title"]);
    $url = mysql_real_escape_string($_POST["url"]);
    $description= mysql_real_escape_string($_POST["description"]);

	if((strlen($title)>=256)||(strlen($url)>=512)||(strlen($description)>=512))
		die("warning");

	mysql_query("INSERT INTO post (title, url, description) VALUES ('$title', '$url', '$description')");
	
	// Redirect to homepage
	header("Location: index.php");
?>