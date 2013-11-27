//All javascript code goes here


$(document).ready(function() {
	var imageScroll = $('#imageScroll');
	var obj1;
	$.ajax({url:"scripts/main.php",success:function(result){
			 obj1 = $.parseJSON(result);
		for (var i = 0; i < obj1.length; i++){
		var new_imagediv = $('<div class ="pic' + obj1[i].id +'"></div>');
        var lblink = $('<a href="' + obj1[i].path +'" data-lightbox="image-1" title="By: '+  obj1[i].author +'"></a>');
        lblink.append('<img src="'+ obj1[i].path +'" alt="image">');
        new_imagediv.append(lblink);
        new_imagediv.append('<br><img class ="thumbup" src="img/thumbup.png" alt="thumbup"><img class ="thumbdn" src="img/thumbdown.png" alt="thumbdown">');
        
        
        imageScroll.append(new_imagediv);
		
		}
			
			}
			});
			

	
	
	
	
	
	/**var new_imagediv = $('<div class ="pic' + image.id  +'"></div>');
	var lblink = $('<a href="' + image.url +'" data-lightbox="image-1" title="My caption"></a>');
	lblink.append('<img src="'+ image.url +'">');
	new_imagediv.append(lblink);
	new_imagediv.append('<br><img class ="thumbup" src="images/thumbup.png"><img class ="thumbdn" src="images/thumbdown.png">');
	
	
	imageScroll.append(new_imagediv);
	**/
	});