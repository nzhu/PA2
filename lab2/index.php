<?php
	require("common.php");
	
	//requests from table
	 $result = mysql_query("SELECT * FROM Books");
	 
?>
<!DOCTYPE html>
<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<script src="http://code.jquery.com/jquery-latest.js"> </script>
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<script type = "text/javascript">
		
		//jquery runs to update page and server with a newly added book
		$(document).ready(function(){$("#booton").click(function(){
    		var book = $("#book").val();
    		var author = $("#author").val();
    		var url = $("#URL").val();
		
		//variable to store bookid in. Called key2
		var key2;
		
		//calls on add_post to add to server
		$.post('add_post.php', { book: book, author: author, URL: url },
 		function(data) {
  			key2 = data;
 		});
    	
    	var div = $('<div data-role="page">');
    	
    	//appends book onto screen without reloading page
    	div.append("<div class='books' data-id='"+key2+"'>"
		+"<img src="+ url 
    	+ " alt= Image for "+book+" height='60' width='60' /> <br>"
    	+ book + "<br> by " + author + "<br>"
    	+"<button class= 'buttons' data-id='"+key2+"'> Remove</button>"
    	+"<p class='comments_btn' data-id='"+ key2+"'>Comments:</p>"
    	
    	//comments section
		+"<div class='comments' style= 'display: none' data-id='"+key2+"'>"
		+"</div>"
		+"<div class='comments1' style= 'display: none' data-id='"+key2+"'>"
		+"<form id='addcomment' name='addcomment' method='post' action='#'>" 			
		+"<textarea name='comment"+key2+"' id='comment"+key2+"' rows='4' cols='38' placeholder='Add comment here'></textarea>"
		+"<input type='submit' value = 'Post'></button></form>"
		+"<div class='hide' style= 'display: none' data-id='"+key2+"'>"
		+"<input type='submit' value = 'Hide Comments'></button>"
		+"</div></div></div>");
		
		//removes a book from the page
		
		  alert(key2);  	
    	//adds all to page
    	$("body").append(div);
    	
        return false;
    	})});
  
		</script>
	<title>Ben B.'s Book Club</title>
</head>

<body>

<div data-role="page">
	<div id='wrapper'>
		<div id='header'>
			<div id='title'><a href="index.php">Ben B.'s Book Club<a/></div>
			<label for="addpost" class="ui-hidden-accessible">Addpost:</label>
			<form id="addpost" name="addpost" method="post" action="#"> 
				<label for="book" class="ui-hidden-accessible">Title:</label>
				<input type="text" name="book" id="book" placeholder="Title"/> <br />
				<label for="author" class="ui-hidden-accessible">Author:</label>
				<input type="text" name="author" id="author" placeholder="Author"/><br />
				<label for="URL" class="ui-hidden-accessible">URL:</label>
				<textarea name="URL" id="URL" rows="4" cols="38" placeholder="Image URL"></textarea>
				<div id= 'booton'><button type="submit" value= "post" >Submit</submit></div>
			</form>
		</div>
		<br/>
		<form id="filter" name="filter" method="get" action="index.php"> 
			<input type="query" name="query" id="query" placeholder = "Filter by keyword"/>
			<input type="submit" value="Filter" />
		</form>
		<br/>
			
				
		<?
		
		//fetches all information from servers and prints out book url, title, author
		while ($row = mysql_fetch_array($result))
		{
			//star for favorite
			print("<div class='books' data-id='".$row["id"]."'>");
			print("<div class='star' data-id='".$row["id"]."'>");
			
			//book
			print("<div class= 'favorite' data-id='".$row["id"]."'> <img src='https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w' height ='25' width ='25'/></div></div>");
			print("<img src='".$row["url"]."' alt='Image for ".$row["title"]."' height='60' width='60' /> ".$row["title"]."<br>by ".$row["author"]."<br>");
            
            //a remove button to remove things
            print("<button class= 'buttons' data-id='".$row["id"]."'> Remove</button>");
			print("<p class='comments_btn' data-id='".$row["id"]."'>Comments:</p>");
			print("<div class='comments' data-id='".$row["id"]."'>");
		   
		   //prints out all comments but hidden
		   $result2 = mysql_query("SELECT * FROM Comments WHERE book_uid = $row[id]");
		    if ($result2 != false)
			{
	    		while ($row2 = mysql_fetch_array($result2))
	    			{
	    				print ($row2['comments']."<br><br>");
	    			}
		    }
		    
		    print("</div>");
		    
		    //click on comments to see comments
		    print("<div class='comments1' style= 'display: none' data-id='".$row["id"]."'>");
			print("<form id='addcomment' name='addcomment' method='post' action='#'> 			
				<textarea name='comment".$row['id']."' id='comment".$row['id']."' rows='4' cols='38' placeholder='Add comment here'></textarea>
				<div class ='comments2' data-id='".$row["id"]."'> <input type='submit' value = 'Post'/></div></form>");
			print("<div class='hide' style= 'display: none' data-id='".$row["id"]."'>
			<input type='submit' value = 'Hide Comments'/>
			</div></div></div>");
			
			echo"<script type = 'text/javascript'>
			
			//if star is yes then yellow star else white
			if (localStorage.star".$row['id']." == 'y')
			{
				var stardiv = $('<div class=\"favorite\" data-id=\"".$row["id"]."\">');
    			stardiv.append('<img src = \"http://upload.wikimedia.org/wikipedia/commons/f/f5/Star_max-b.png\" height =\"25\" width =\"25\"/>');
			}
			else
			{
				var stardiv = $('<div class=\"favorite\" data-id=\"".$row["id"]."\">');
				stardiv.append('<img src = \"https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w\" height =\"25\" width =\"25\"/>');
			}
			
			$('.favorite[data-id=".$row['id']."]').remove();
    		$('.star[data-id=".$row['id']."]').append(stardiv);
			
			//clicking a star will change it
			$('.star[data-id=".$row['id']."]').click(function (){
    		
    			$('.favorite[data-id=".$row['id']."]').remove();
    			if (localStorage.star".$row['id']." == 'y')
    			{
    				localStorage.star".$row['id']."= 'n';
    				var stardiv = $('<div class=\"favorite\" data-id=\"".$row["id"]."\">');
					stardiv.append('<img src = \"https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w\" height =\"25\" width =\"25\"/>');
    			}
    			else 
    			{	
    				localStorage.star".$row['id']." = 'y';
    				var stardiv = $('<div class=\"favorite\" data-id=\"".$row["id"]."\">');
    				stardiv.append('<img src = \"http://upload.wikimedia.org/wikipedia/commons/f/f5/Star_max-b.png\" height =\"25\" width =\"25\"/>');
    			}	
    		
    			$('.favorite[data-id=".$row['id']."]').remove();
    			$('.star[data-id=".$row['id']."]').append(stardiv);})
    			;
			
			//clicking remove removes a book
			$('.buttons[data-id=".$row['id']."]').click(function (){
    		$('.books[data-id=".$row['id']."]').remove();
    		
    		// ajax to delete
    		var request5 =
  			$.ajax({
  				type: 'POST',
  				url: 'deletebook.php',
  				data: 'bookuid=".$row['id']."'});
    		});
			
			//clicking comments will show all the comments
			$('.comments_btn[data-id=".$row['id']."]').click(function() {
				$('.comments[data-id=".$row['id']."]').show();
				$('.comments1[data-id=".$row['id']."]').show();
				$('.hide[data-id=".$row['id']."]').show();
	
			}); 
			
			$('.hide[data-id=".$row['id']."]').click(function() {
				$('.comments[data-id=".$row['id']."]').hide();
				$('.comments1[data-id=".$row['id']."]').hide();
				$('.hide[data-id=".$row['id']."]').hide();
	
			}); 
			
			//submit a comment and it appears as well
			$('.comments2[data-id=".$row['id']."]').click(function(){
    	
    			var comment1 = $('#comment".$row['id']."').val();
    			var bookid =".$row['id'].";
    		
    	
    			//variable div
    			var div = $('<div>');
    			div.append(comment1+'<br><br>');
    	   	
    			//adds to page
    			$('.comments[data-id=".$row['id']."]').append(div);
    	
    			$.post('addcomment.php', { bookid: bookid, comment: comment1});	
		
        		return false;
    			});</script>"
			
			;
		}	
	?> 
	</div>
</div><!-- /content -->
</body>
</html>
