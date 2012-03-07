/*Javascript to run code for adding a new book*/


$(document).delegate("#one", "pageinit", function() {	
	$("#addbook").submit(function(){
		var title = $("#book").val();
    	var author = $("#author").val();
    	var url = $("#URL").val();
		
		//checks to make sure inputs are correct length
		if (title.length == 0 || author.length == 0 || url == 0)
		{
			alert("Please fill out all fields");
			return false;
		}
		else
		{
			//calls on add_post to add to server
			$.post('add_post.php', { title: title, author: author, URL: url },
 			function(data) {
 				if (data == "exists")
 				{
 					alert("There is already a book in the database with the same title!");
 				}
 				else
 				{
  				
  				
  				var div = $('<div>');
				
    			//appends book onto screen without reloading page
    			div.append("<div class='books' id='"+data+"'>"
				+"<img src="+ url 
    			+ "height='120' width='120' /> <br> "
    			+title + "<br> by " + author + "<br>"
    			//removing a book
    			+"<button data-icon='star' data-theme='e' onClick = \"var star = localStorage.getItem('"+data+"');"
				
    			+"if (star==null)"
					+"{"
						+"localStorage.setItem('"+data+"', '"+title+"');"
						+"alert('5');"
					+"}"
					+"else"
					+"{"
						+"localStorage.removeItem('"+data+"');" 
					+"}\"" 
    		 		+"> Favorite</button>"
 				+"<button data-icon='delete' onClick = \"$('#"+data+"').remove(); $.ajax({"
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
																						
				+"<button data-icon='plus' onClick = \"var bookid =" +data+"; var comment = $('.boot[id="+data+"]').val(); alert(comment);"	
				+"var div = $('<div>'); div.append(comment);"
				+"$('.comments[id="+data+"]').append(div);"
				+"$.post('addcomment.php', { bookid: bookid, comment: comment}); return false; \"> Add comment </button>"	 		
				+"</fieldset></form>Comments:<br></div></div>");
		    	
    		//adds all to page
    		$(div).appendTo(".ui-content[id=three]").trigger("create");
  			}
  			});
 		return false;
 		}
 	});
});


