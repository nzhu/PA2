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
		<script> localStorage.setItem("name", "Hello World!"); //saves to the database, key/value
document.write(localStorage.getItem("name"));</script>
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

	Favorite Books: <br>
	<?
		
		$resultfave = mysql_query("SELECT * FROM Books");
		print("<script>");
		while ($rowfave = mysql_fetch_array($resultfave))
		{	
		echo "var star2 = localStorage.getItem(".$rowfave["id"].");
		if (star2 != null)
		{
			document.write('<div id=f".$rowfave["id"].">'+star2+'</div>');
			
		}";
		
		}
		print("</script>");
		
	?>

	</div>
	<div data-role="content" id = "three">
	<?
		while ($row = mysql_fetch_array($result))
		{
			//book divs
			print("<div class='books' id='".$row["id"]."'>");
		
			
			print("<img src='".$row["url"]. "height='120' width='120' /> <br>".$row["title"]."<br>by ".$row["author"]."<br>");
			
				//favorite star
			print("
			<button data-theme='e' data-icon='star' data-id= '".$row["id"]."' onClick = 
					\"var star = localStorage.getItem(".$row["id"]."); $('.fave[id=".$row["id"]."]').toggle();
					if (star==null)
					{
						localStorage.setItem('".$row["id"]."', '".$row["title"]."');
						var stardiv = $('<div>');
						stardiv.append(star);
						
						$(stardiv).appendTo('.ui-content[id=five]').trigger('create');
					}
					else
					{
					localStorage.removeItem('".$row["id"]."'); 
					}
					\" 
    		 		> Favorite</button>");
			//remove button
			print("<button data-icon='delete' onClick = \"$('#".$row["id"]."').remove(); $('#f".$row["id"]."').remove(); $.ajax({
  					type: 'POST',
  					url: 'deletebook.php',
  					data: 'bookuid=".$row['id']."'})\" 
    		 		> Remove</button>");
    		
    		//displays comments
    		print("<button data-icon='info' onClick =\"$('.comments[id=".$row["id"]."]').toggle()\"> Display/Hide Comments</button>");
			print("<div class='comments' style= 'display: none' id='".$row["id"]."'>");
		
			//add comments
			print("<form id='commentform' name='commentform' method='post' action='#' class='ui-body ui-body-a ui-corner-all'> 			
			<fieldset>
			<div data-role='fieldcontain' class='ui-hide-label'>
			<label for='bookid'>ID:</label>
			<input type='hidden' id='bookid' name='bookid' value='".$row["id"]."'/>
			<label for='comment'>Comment:</label>
			<textarea class='boot' name='comment' id='".$row["id"]."' rows='4' cols='38' placeholder='Add comment here'></textarea>
			</div>
			<button data-icon='plus' onClick = \"var bookid =" .$row["id"]."; var comment = $('.boot[id=".$row["id"]."]').val(); 		
			var div = $('<div>'); div.append(comment);
			$('.comments[id=".$row["id"]."]').append(div);
			$.post('addcomment.php', { bookid: bookid, comment: comment}); return false; \"> Add comment </button>	 
  			</fieldset></form>Comments:<br>");
			
			
			//prints out comment
			$result2 = mysql_query("SELECT * FROM Comments WHERE book_uid = $row[id]");
			if ($result2 != false)
			{
		    	while ($row2 = mysql_fetch_array($result2))
		    	{
	    			print ($row2['comments']."<br><br>");
	    		}
			}   
				print("</div></div>");
		}	
	?>
	</div><!-- /content -->

</div><!-- /page -->

</body>
</html>