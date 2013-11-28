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
			new_imagediv.append('<br><img class ="thumbup" src="img/thumbup.png" alt="thumbup"><img class ="thumbdn" src="img/thumbdown.png" alt="thumbdown"><span class="up">'+obj1[i].upvotes+'</span><span class="dn">'+obj1[i].downvotes+'</span>');
			imageScroll.append(new_imagediv);
			
		}
		
	}});
	
	imageScroll.on('click', 'img.thumbup', function(event){
		var parent= $(this).parent().attr("class");
		var data= {picture: parent, vote: "up"};
		$.post('scripts/voting.php', data, function(returnedData) {
			console.log(returnedData);
		});
		
		var thumbup = $(this).siblings("span.up").html();
		thumbup++;
		$(this).siblings("span.up").html(thumbup).fadeIn("slow");
		
		
	});

	imageScroll.on('click', 'img.thumbdn', function(event){
		var parent= $(this).parent().attr("class");
		var data= {picture: parent, vote: "down"};
		$.post('scripts/voting.php', data, function(returnedData) {
			console.log(returnedData);
		});
		
		var thumbdown = $(this).siblings("span.dn").html();
		thumbdown++;
		$(this).siblings("span.dn").html(thumbdown).fadeIn("slow");
		
	});
});