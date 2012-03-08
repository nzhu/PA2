<?php
	require("common.php");
	
	//requests from table
	 $result = mysql_query("SELECT * FROM Books");
?>	 

<!DOCTYPE html> 


<html> 
	<head> 
		<title>Ben B's Book Club</title> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
		<link href="style.css" rel="stylesheet" type="text/css">
		<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
		<script src = add.js></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head> 
	<body> 
		
		<div data-role="page" id="one">

		<div data-role="header">
			<h1>Ben B's Book Club</h1>
		</div><!-- /header -->

		<!--form to add books--!>
		<div data-role="content" id = "two">	
			<form id = "addbook" action="#" method="post" class="ui-body ui-body-a ui-corner-all">
			<fieldset>
			<div data-role="fieldcontain" class="ui-hide-label">
				<label for="book">Book:</label>
				<input type="text" name="book" id="book" value="" placeholder="Book"/>
				<label for="author">Author:</label>
				<input type="text" name="author" id="author" placeholder="Author"/><br />
				<label for="URl">URL:</label>
				<textarea name="URL" id="URL" rows="4" cols="38" placeholder="Image URL"></textarea>
			</div>
			<button type="submit" data-theme="b" name="submit" value="submit-value">Submit</button>
			</fieldset>
			</form>

		</div><!-- /content -->
	<div data-role="content" id = "five">
	<!-- Loads favorite books using local storage -->
	Favorite Books: <br>
	<?
		$resultfave = mysql_query("SELECT * FROM Books");
			print("<script>");
			while ($rowfave = mysql_fetch_array($resultfave))
			{	
				echo "var star2 = localStorage.getItem(".$rowfave["uid"].");
				if (star2 != null)
				{
					document.write('<div id=f".$rowfave["uid"].">'+star2+'</div>');	
				}";
			}
		print("</script>");	
	?>

	</div><!-- /content -->
	<div data-role="content" id = "three">
	<?
		while ($row = mysql_fetch_array($result))
		{
			//book divs
			print("<div class='books' id='".$row["uid"]."'>");
			//if image does not exist replace with another one
			print("<div class='img' id='".$row["uid"]."'>");
			print("<img onerror=\"$('.img[id=".$row["uid"]."]').toggle() \" src='".$row["image_url"]."' height='120' width='120' /> 
			</div>");
			print("<div class='img' style='display:none' id='".$row["uid"]."'><img src= 'http://hotmommas.files.wordpress.com/2010/07/book-image.jpg' height='120' width='120'/></div>"
			.$row["title"]."<br>by ".$row["author"]."<br>");
			//favorite button
			print("<button data-theme='e' data-icon='star' data-id= '".$row["uid"]."' onClick = 
					\"var star = localStorage.getItem(".$row["uid"].");
					if (star==null)
					{
						localStorage.setItem('".$row["uid"]."', '".$row["title"]."');
						star = localStorage.getItem(".$row["uid"].");
						var stardiv = $('<div>');
						stardiv.append('<div id=f".$row["uid"].">'+star+'</div>');
						$(stardiv).appendTo('.ui-content[id=five]').trigger('create');
					}
					else
					{
					localStorage.removeItem('".$row["uid"]."'); 
					$('#f".$row["uid"]."').remove();
					}
					\" 
    		 		> Favorite</button>");
			//the remove
			print("<button data-icon='delete' onClick = \"$('#".$row["uid"]."').remove(); $('#f".$row["id"]."').remove(); $.ajax({
  					type: 'POST',
  					url: 'deletebook.php',
  					data: 'bookuid=".$row['uid']."'})\" 
    		 		> Remove</button>");
    		
    		//displays comments
    		print("<button data-icon='info' onClick =\"$('.comments[id=".$row["uid"]."]').toggle()\"> Display/Hide Comments</button>");
			print("<div class='comments' style= 'display: none' id='".$row["uid"]."'>");
		
			//add comments
			print("<form id='commentform' name='commentform' method='post' action='#' class='ui-body ui-body-a ui-corner-all'> 			
			<fieldset>
			<div data-role='fieldcontain' class='ui-hide-label'>
			<label for='bookid'>ID:</label>
			<input type='hidden' id='bookid' name='bookid' value='".$row["uid"]."'/>
			<label for='comment'>Comment:</label>
			<textarea class='boot' name='comment' id='".$row["uid"]."' rows='4' cols='38' placeholder='Add comment here'></textarea>
			</div>
			<button data-icon='plus' onClick = \"var bookid =" .$row["uid"]."; var comment = $('.boot[id=".$row["uid"]."]').val(); 		
			if (comment.length == 0) {alert('Please provide a comment');} else {var div = $('<div>'); div.append(comment+'<br><br>');
			$('.comments[id=".$row["uid"]."]').append(div);
			$.post('addcomment.php', { bookid: bookid, comment: comment});} return false; \"> Add comment </button>	 
  			</fieldset></form><br>Comments:<br>");
			
			//prints out comment
			$result2 = mysql_query("SELECT * FROM Comments WHERE book_uid = $row[uid]");
			if ($result2 != false)
			{
		    	while ($row2 = mysql_fetch_array($result2))
		    	{
	    			print ($row2['comment']."<br><br>");
	    		}
			}   
			print("</div></div>"); //book div and comments
		}	
	?>
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>