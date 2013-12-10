//All javascript code goes here


$(document).ready(function() {
	var imageScroll = $('#imageScroll');
	var obj1;
	$.ajax({url:"scripts/main.php",success:function(result){
		obj1 = $(result);
		for (var i = 0; i < obj1.length; i++){
			var new_imagediv = $('<div class ="pic' + obj1[i].id +'"></div>');
			var lblink = $('<a href="' + obj1[i].path +'" data-lightbox="image-1" title="By: '+  obj1[i].author +'"></a>');
			lblink.append('<img src="'+ obj1[i].path +'" alt="image">');
			new_imagediv.append(lblink);
            new_imagediv.append('<a class="comment_link" href="#">Comment</a>');
			new_imagediv.append('<br><img class ="thumbup" src="img/thumbup.png" alt="thumbup"><img class ="thumbdn" src="img/thumbdown.png" alt="thumbdown"><span class="up">'+obj1[i].upvotes+'</span><span class="dn">'+obj1[i].downvotes+'</span>');
			imageScroll.append(new_imagediv);
			
		}
		
	}});
	
	imageScroll.on('click', 'img.thumbup', function(event){
        var picture_id= $(this).parent().attr("class");
		var sibling = $(this).siblings("span.up");
        var data= {picture: picture_id, vote: "up"};

		$.post('scripts/voting.php', data, function(returnedData) { 
            if (returnedData.success) {
		        var thumbup = sibling.html();
		        thumbup++;
		        sibling.html(thumbup).fadeIn("slow");
           }
		});
		
		
		
	});

	imageScroll.on('click', 'img.thumbdn', function(event){
		/*have to store 'this' because we lose reference to it inside the post ajax call */
        var picture_id= $(this).parent().attr("class");
		var sibling = $(this).siblings("span.dn");
		var data= {picture: picture_id, vote: "down"};
		
        $.post('scripts/voting.php', data, function(returnedData) {
		    if (returnedData.success) {
                var thumbdown = sibling.html();
		        thumbdown++;
		        sibling.html(thumbdown).fadeIn("slow");
		    }
		});
		
	});
});
