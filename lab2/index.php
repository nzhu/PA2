<?php
	require("common.php");
	 
	 $result = mysql_query("SELECT * FROM Books");
	 $row = mysql_fetch_array($result)
	

?>
<!DOCTYPE html>
<html >
<head>
	<link href="style.css" rel="stylesheet" type="text/css">
	<script src="http://code.jquery.com/jquery-latest.js"> </script>
	<title>Ben B.'s Book Club</title>
</head>

<body>
	<div id='wrapper'>
		<div id='header'>
			<div id='title'><a href="index.php">Ben B.'s Book Club<a/></div>
	
			<form id="addpost" name="addpost" method="post" action="#"> 
				<input type="text" name="book" id="book" placeholder="Title"/> <br />
				<input type="text" name="author" id="author" placeholder="Author"/><br />
				<textarea name="URL" id="URL" rows="4" cols="38" placeholder="Image URL"></textarea>
				<input type="submit" value = "Post"/>
			</form>
		</div>
		<br/>
		<form id="filter" name="filter" method="get" action="index.php"> 
			<input type="query" name="query" id="query" placeholder = "Filter by keyword"/>
			<input type="submit" value="Filter" />
		</form>
		<br/>
		<script type = "text/javascript">
		
		//jquery runs to update page and server with a newly added book
		$("#addpost").submit(function(){
    		var title = $("#book").val();
    		var author = $("#author").val();
    		var url = $("#URL").val();
		
		//variable to store bookid in. Called key2
		var key2;
		
		//calls on add_post to add to server
		$.post('add_post.php', { title: title, author: author, URL: url },
 		function(data) {
  			key2 = data;
  			$("body").append(key2);
 		});
    	
    	var div = $('<div>');
    	
    	//appends book onto screen without reloading page
    	div.append("<div class='books' data-id='"+key2+"'>"
    	+"<div class='star' data-id='"+key2+"'>"
		+"<div class= 'favorite' data-id='"+key2+"'> "
		+"<img src='https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w' height ='25' width ='25'/></div></div>"
		+"<img src="+ url 
    	+ " alt= Image for "+title+" height='60' width='60' /> ");
    	div.append(title + "<br> by " + author + "<br>"
    	+"<button class= 'buttons' data-id='"+key2+"'> Remove</button>"
    	+"<p class='comments_btn' data-id='"+ key2+"'>Comments:</p><br>"
    	
    	//comments section
		+"<div class='comments' style= 'display: none' data-id='"+key2+"'>"
		+"</div>"
		+"<div class='comments1' style= 'display: none' data-id='"+key2+"'>"
		+"<form id='addcomment' name='addcomment' method='post' action='#'>" 			
		+"<textarea name='comment"+key2+"' id='comment"+key2+"' rows='4' cols='38' placeholder='Add comment here'></textarea>"
		+"<input type='submit' value = 'Post'></button>"
		+"</form></div></div>"
		
		//removes a book from the page
		+"<script type = 'text/javascript'>" 
		
		//checks local storage to see if anything has been favorited, if so use a yellow star else white
		+"if (localStorage.star"+key2+" == 'y')"
		+"{"
			+"var stardiv = $('<div class=\"favorite\" data-id=\""+key2+"\">');"
    		+"stardiv.append('<img src = \"http://upload.wikimedia.org/wikipedia/commons/f/f5/Star_max-b.png\" height =\"25\" width =\"25\"/>');"
		+"}"
		+"else"
		+"{"
			+"var stardiv = $('<div class=\"favorite\" data-id=\""+key2+"\">');"
			+"stardiv.append('<img src = \"https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w\" height =\"25\" width =\"25\"/>');"
		+"}"
		
		//edits the stars
		+"$('.favorite[data-id="+key2+"]').remove();"
    	+"$('.star[data-id="+key2+"]').append(stardiv);"
		
		//if users click stars then it changes color
		+"$('.star[data-id="+key2+"]').click(function (){"		
    	+"$('.favorite[data-id="+key2+"]').remove();"
    	+"if (localStorage.star"+key2+" == 'y')"
    	+"{"
    		+"localStorage.star"+key2+"= 'n';"
    		+"var stardiv = $('<div class=\"favorite\" data-id=\""+key2+"\">');"
			+"stardiv.append('<img src = \"https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w\" height =\"25\" width =\"25\"/>');"
    	+"}"
    	+"else" 
    	+"{"	
    		+"localStorage.star"+key2+" = 'y';"
    		+"var stardiv = $('<div class=\"favorite\" data-id=\""+key2+"\">');"
    		+"stardiv.append('<img src = \"http://upload.wikimedia.org/wikipedia/commons/f/f5/Star_max-b.png\" height =\"25\" width =\"25\"/>');"
    	+"}"	
    		
    	+"$('.favorite[data-id="+key2+"]').remove();"
    	+"$('.star[data-id="+key2+"]').append(stardiv);})"
    	+";"
		
		//deletes a book
		+"$('.buttons[data-id="+key2+"]').click(function (){"
    	+"$('.books[data-id="+key2+"]').remove();"
    	
    	+"var request2 ="
  		+"$.ajax({"
  		+"type: 'POST',"
  		+"url: 'deletebook.php',"
  		+"data: 'bookuid="+key2+"'}"
		+");"
    	+"});"
    	

		
		
		
		
		//submits a comment
		+"$('.comments1[data-id="+key2+"]').submit(function(){"
			+"var comment1 = $('#comment"+key2+"').val();"
    		+"var bookid =" +key2+";"
    		+"var div = $('<div>');"
    		+"div.append(comment1+'<br><br>');"
    	   	
    	//adds comments to a page
    	+"$('.comments[data-id="+key2+"]').append(div);"
    	+"var request2 ="
  		+"$.ajax({"
  			+"type: 'POST',"
  			+"url: 'addcomment.php',"
  			+"data: 'bookid='"+bookid+"&comment="+comment1+"});"
    	);
		    	
    	//adds all to page
    	$("body").append(div);
    	
        return false;
    	});
  
		</script>	
				
		<?
		
		//fetches all information from servers and prints out
		while ($row = mysql_fetch_array($result))
		{
			print("<div class='books' data-id='".$row["id"]."'>");
			print("<div class='star' data-id='".$row["id"]."'>");
			print("<div class= 'favorite' data-id='".$row["id"]."'> <img src='https://encrypted-tbn3.google.com/images?q=tbn:ANd9GcTLLYvOpe-0zxvIa6d2YbTp5uKB7wLVMptF40CxiGcdPzAqZEa95w' height ='25' width ='25'/></div></div>");
			print("<img src='".$row["url"]."' alt='Image for ".$row["title"]."' height='60' width='60' /> ".$row["title"]."<br>by ".$row["author"]."<br>");
            print("<button class= 'buttons' data-id='".$row["id"]."'> Remove</button>");
			print("<p class='comments_btn' data-id='".$row["id"]."'>Comments:</p>");
			print("<div class='comments' data-id='".$row["id"]."'>");
			   $result2 = mysql_query("SELECT * FROM Comments WHERE book_uid = $row[id]");
		    if ($result2 != false)
			{
	    		while ($row2 = mysql_fetch_array($result2))
	    			{
	    				print ($row2['comments']."<br><br>");
	    			}
		    }
		    
		    
		    print("</div>");
		    print("<div class='comments1' style= 'display: none' data-id='".$row["id"]."'>");
			print("<form id='addcomment' name='addcomment' method='post' action='#'> 			
				<textarea name='comment".$row['id']."' id='comment".$row['id']."' rows='4' cols='38' placeholder='Add comment here'></textarea>
				<input type='submit' value = 'Post'></button>
			</form></div></div><br>");
			
			echo"<script type = 'text/javascript'>
			
			
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
			
			$('.buttons[data-id=".$row['id']."]').click(function (){
    		$('.books[data-id=".$row['id']."]').remove();
    		
    		var request5 =
  			$.ajax({
  			type: 'POST',
  			url: 'deletebook.php',
  			data: 'bookuid=".$row['id']."'}
			);
    		});
			
			$('.comments_btn[data-id=".$row['id']."]').click(function() {
				$('.comments[data-id=".$row['id']."]').show();
				$('.comments1[data-id=".$row['id']."]').show();
				
				
			}); 
			
			$('.comments1[data-id=".$row['id']."]').submit(function(){
    	
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
		/*var request3 =
  		$.ajax({
  		type: 'POST',
  		url: 'addcomment.php',
  		data: 'bookid='+bookid+'&comment='+comment1}
		);*/
		
		}	?>
	</div>

</body>
</html>
