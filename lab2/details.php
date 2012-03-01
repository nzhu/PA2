<?php
	require("common.php");
	// TODO 3: Extract and clean pid from URL using $_GET
	
	// TODO 3: Query for post information and comments related to query
	
?>

<!DOCTYPE html>
<html >
<head>
<link href="style.css" rel="stylesheet" type="text/css">
<title>CS 179 Lab 2</title>
</head>

<body>
	<div id='wrapper'>
		<div id='header'>
			<div id='title'><a href="index.php">CS 179 Lab 2<a/></div>
		</div>
		
		
		<?php
			// TODO 3: Print information about the post (title, description, all comments)
		?>
	
		<form id="addcomment" name="addcomment" method="post" action="add_comments.php">
			<textarea name="comment" id="comment" rows="2" cols="36" placeholder="Comment"></textarea>
			<input type="submit" value="Add Comment" />
		</form>
		<!-- TODO 4: Make adding comments work-->
	</div>
</body>
</html>
