
var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f13/encarnae/426Project/Server-Side";

$(document).ready(function() {

    /* global variable */
    var picture_id = 0;

   /* attach the comment div to the document */    
    $(document).on('click','.comment_link',function() {
        $('.mainContent').append('\
            <div id="toPopup_comment">\
                <div class="close"></div>\
                <div id="popup_content">\
                    <div id="picture">\
                        <img src="" alt="campus">\
                    </div> <!--picture-->\
                    <div id="picture_info">\
                <!--        <img id="user_profile_picture" src ="profile.jpg" alt="profile"> -->\
                        <span id="user_name"></span>\
                        <br><br><br><br>\
                        <p id="picture_description"></p>\
                    </div><!--picture_info-->\
                    <div id="picture_comments">\
                    <div id="add_comment" contenteditable></div>\
                        <div id="comment_list_div">\
                        <ul id="comment_list">\
                        </ul>\
                        </div>\
                    </div><!--picture_comments-->\
                </div><!--popup_content-->\
            </div><!--toPopup_comment-->\
            <div class="loader"></div>\
            <div id="backgroundPopup_comment"></div>');
        
        var pic_class = $(this).parent().attr("class");
        /* The class will be in the format "pic<id>" */
 
        picture_id = pic_class.substring(pic_class.indexOf("c")+1);
        /*First, do ajax call for the picture and its information */
        
        $.ajax(url_base + "/picture.php/" + picture_id,
            {type: "GET",
             dataType:"json",
             success: function(picture, status, jqXHR) {
                $('#picture img').attr("src",picture.path);
                $('#user_name').text(picture.author);
                $('#picture_description').text(picture.description);
             },
             error: function(jqXHR, status, error) {
                        console.log(error);
             }
         });
        
        /* Now do a call for the comments, and attach it one by one */
        /* clear the list before attaching new comments */
        $('#comment_list').empty();

        $.ajax(url_base + "/comment.php/picture/" + picture_id,
            {type: "GET",
             dataType:"json",
             success: function(comments, status, jqXHR) {
                for (var i=0; i < comments.length; i++) {
                    load_comment(comments[i]); 
                }
             },
             error: function(jqXHR, status, error) {
                    console.log(error);
             }
         });
            //After loading all the HTML
   			loading(); // loading
			setTimeout(function(){ // then show popup, deley in .5 second
			    	loadPopup(); // function show popup 
			    }, 500); // .5 second
	    return false;
    });

	//Function to submit a comment reply on pressing enter
	$(document).on("keypress", "div[contenteditable]", function (e) {
		var comment_box = $('div[contenteditable]');
		var content = comment_box.text();
		if (e.keyCode == 13) {
			comment_box.text(''); //have to clear because of \n
			if (!content||content.length == 0) {
				return;
			}
            /* Create new JS Comment object */

            /* First, get the current logged in author */
            /* You can't retrieve the value of the function on an Ajax call, so you 
             * have to do an ajax within an ajax */
            $.ajax(url_base + "/user.php/",
                {type: "GET",
                 dataType: "json"

                }).done(function(data) {
                    var comment = {author_id: data.id,
                                author: JSON.stringify(data), //I do this because the Comment constructor parses JSON
                                content: content,
                                picture: picture_id,
                                upvotes: 0,
                                downvotes: 0,
                                created: new Date()
                                }
                            $.ajax(url_base + "/comment.php/",
                            {type: "POST",
                             dataType: "json",
                             data: comment,
                             success: function(comment_json, status, jqXHR) {
                                        console.log(comment);
                                        var c = new Comment(comment);
                                        $('#comment_list').append(c.makeCommentDiv());
                                      },
                             error: function(jqXHR, status, error) {
                                        alert(jqXHR.responseText);
                                    }
                            });
                   });
            }
        });
    
    /* Events to close the lightbox */
	$("div.close").hover(
					function() {
						$('span.ecs_tooltip').show();
					},
					function () {
    					$('span.ecs_tooltip').hide();
  					}
				);

	$("body").on('click', 'div.close', function(event){
		disablePopup();  // function close pop up
	});

	$(this).keyup(function(event) {
		if (event.which == 27) { // 27 is 'Ecs' in the keyboard
			disablePopup();  // function close pop up
		}
	});

        $("div#backgroundPopup").click(function() {
		disablePopup();  // function close pop up
	});

	$('a.livebox').click(function() {
		alert('Hello World!');
	return false;
	});


    var load_comment = function(id) {
        $.ajax(url_base + "/comment.php/" + id,
            {type:"GET",
             dataType: "json",
             success:function(comment_json, status, jqXHR) {
                    var c = new Comment(comment_json);
                    $('#comment_list').append(c.makeCommentDiv());
                  }
        });
    }
    
    /* function used to retrieve the return value of ajax call to getLoggedInUser.php*/
    var callback = function(user, user_json) {
        user = user_json;
    }
    
	 /************** start: functions. **************/
	function loading() {
		$("div.loader").show();
	}
	function closeloading() {
		$("div.loader").fadeOut('normal');  
	}
	
	var popupStatus = 0; // set value
    function loadPopup() { 
		if(popupStatus == 0) { // if value is 0, show popup
			closeloading(); // fadeout loading
			$("#toPopup_comment").fadeIn(0500); // fadein popup div
			$("#backgroundPopup_comment").css("opacity", "0.7"); // css opacity, supports IE7, IE8
			$("#backgroundPopup_comment").fadeIn(0001); 
			popupStatus = 1; // and set value to 1
		}	
	}
		
	function disablePopup() {
		if(popupStatus == 1) { // if value is 1, close popup
			$("#toPopup_comment").fadeOut("normal");  
			$("#backgroundPopup_comment").fadeOut("normal");  
			popupStatus = 0;  // and set value to 0
		}
	}
	/************** end: functions. **************/
});
