//All javascript code goes here


$(document).ready(function() {
	var imageScroll = $('#imageScroll');
	for(var i=0; i<10; i++) {
		var image = imageObj.all.pop();
	var new_imagediv = $('<div class ="pic' + image.id  +'"></div>');
	var lblink = $('<a href="' + image.url +'" data-lightbox="image-1" title="My caption"></a>');
	lblink.append('<img src="'+ image.url +'"><br><img class ="thumbup" src="images/thumbup.png"><img class ="thumbdn" src="images/thumbdown.png">'
		+'</div>');
	new_imagediv.append(lblink);
	
	imageScroll.append(new_imagediv);
	}
	});