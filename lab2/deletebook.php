<?php
	require("common.php");
	
	// TODO 2: Check for presence of input parameters else die("warning")
	if (empty($_POST["bookuid"]))
	    die("warning");
	
	//stores it
	$bookid = mysql_real_escape_string($_POST["bookuid"]);

	//deletes	
	mysql_query("DELETE FROM Books WHERE id = '$bookid'");
	mysql_query("DELETE FROM Comments WHERE book_uid = '$bookid'");
    
    
?>