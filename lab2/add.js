/*Javascript to run code for adding a new book*/

$(document).delegate("#one", "pageinit", function() {	
	
	$("#addbook").submit(function(){
		var title = $("#book").val();
    	var author = $("#author").val();
    	var url = $("#URL").val();
		
		//checks to make sure inputs are correct length
		if (title.length == 0 || author.length == 0 || url.length == 0)
		{
			alert("Please fill out all fields");
			return false;
		}
		else
		{
			//calls on add_post to add to server
			$.post('add_post.php', { title: title, author: author, URL: url },
 			function(data) {
 				if (data == "long")
 				{
 					alert("You have put too much input!");
 				}
 				else if (data == "exists")
 				{
 					alert("There is already a book in the database with the same title!");
 				}
 				else
 				{
	  				var div = $('<div>');
				
    				//appends book onto screen without reloading page
    				div.append("<div class='books' id='"+data+"'>"
					+"<div class='img' id='"+data+"'>"
					+"<img onerror=\"$('.img[id="+data+"]').toggle() \" src='"+url+"' height='120' width='120' /> "
					+"</div>"
					+"<div class='img' style='display:none' id='"+data+"'><img src= 'http://hotmommas.files.wordpress.com/2010/07/book-image.jpg' height='120' width='120'/></div>"	
    				+title + "<br> by " + author + "<br>"
    				
    				//button for favorites
    				+"<button data-icon='star' data-theme='e' onClick = \"var star = localStorage.getItem('"+data+"');"    	
    				+"if (star==null)"
					+"{"
						+"localStorage.setItem('"+data+"', '"+title+"');"
						+"star = localStorage.getItem("+data+");"
						+"var stardiv = $('<div>');"
						+"stardiv.append('<div id=f"+data+">'+star+'</div>');"
						+"$(stardiv).appendTo('.ui-content[id=five]').trigger('create');"
					+"}"
						+"else"
					+"{"
						+"localStorage.removeItem('"+data+"');"
						+"$('#f"+data+"').remove();"
					+"}\"" 
    		 		+"> Favorite</button>"
 					//deletes
 					+"<button data-icon='delete' onClick = \"$('#"+data+"').remove(); $('#f"+data+"').remove(); $.ajax({"
  					+"type: 'POST',"
  					+"url: 'deletebook.php',"
  					+"data: 'bookuid="+data+"'})\"> Remove</button>"
    			
    				//comments
    				+"<button data-icon='info' onClick =\"$('.comments[id="+data+"]').toggle()\"> Display/Hide Comments</button>"
					+"<div class='comments' style= 'display: none' id='"+data+"'>"
					+"<form id='commentform' name='commentform' method='post' action='#' class='ui-body ui-body-a ui-corner-all'>"			
					+"<fieldset>"
					+"<div data-role='fieldcontain' class='ui-hide-label'>"
					+"<label for='bookid'>ID:</label>"
					+"<input type='hidden' id='bookid' name='bookid' value='"+data+"'/>"
					+"<label for='comment'>Comment:</label>"
					+"<textarea class='boot' name='comment' id='"+data+"' rows='4' cols='38' placeholder='Add comment here'></textarea>"
					+"</div>"
																						
					+"<button data-icon='plus' onClick = \"var bookid =" +data+"; var comment = $('.boot[id="+data+"]').val();"	
					+"if (comment.length == 0) {alert('Please provide a comment');} else {var div = $('<div>'); div.append(comment+'<br><br>');"
					+"$('.comments[id="+data+"]').append(div);"
					+"$.post('addcomment.php', { bookid: bookid, comment: comment});} return false; \"> Add comment </button>"	 		
					+"<br></fieldset></form>Comments:<br></div></div>");
		    	
    			//adds all to page
    			$(div).appendTo(".ui-content[id=three]").trigger("create");
  				}
  			});
 		return false;
 		}
 	});
});


