$(document).ready(function() {

	$("a.login").click(function() {
			$("body").append(' <div id="toPopup"><div class="close"></div><span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span><div id="popup_content"><h1>Login to Tar Heel Gallery</h1><form method="post" onsubmit="return false"><p><input type="text" class = "login" name="login" value="" placeholder="Username"></p><p><input class = "pass" type="password" name="password" value="" placeholder="Password"></p><p class="submit"><input class="submit" type="submit" name="commit" value="Login"></p></form></div> <!--your content end--></div> <!--toPopup end--><div class="loader"></div><div id="backgroundPopup"></div>');
			loading();
			setTimeout(function(){ 
				loadPopup(); 
			}, 500); // 
	return false;
	});
	
	$("#register").click(function() {
			$("body").append(' <div id="toPopup"><div class="close"></div><span class="ecs_tooltip">Press Esc to close <span class="arrow"></span></span><div id="popup_content"><p>Something Different</p><p align="center"><a href="#" class="livebox">Click Here Trigger</a></p></div> <!--your content end--></div> <!--toPopup end--><div class="loader"></div><div id="backgroundPopup"></div>');
			loading();
			setTimeout(function(){ 
				loadPopup(); 
			}, 500); // 
	return false;
	});
	
	$("body").on('click', 'input.submit', function(event){
		signin();  // function close pop up
	});

	/* event for close the popup */
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
			$("#toPopup").fadeIn(0500); // fadein popup div
			$("#backgroundPopup").css("opacity", "0.7"); // css opacity, supports IE7, IE8
			$("#backgroundPopup").fadeIn(0001);
			popupStatus = 1; // and set value to 1
		}
	}

	function disablePopup() {
		if(popupStatus == 1) { // if value is 1, close popup
			$("#toPopup").fadeOut("normal");
			$("#backgroundPopup").fadeOut("normal");
			popupStatus = 0;  // and set value to 0
			$("#toPopup").remove();
			$("#backgroundPopup").remove();
		}
	}
	function signin(){
	var valid = true;
	$("p.log").remove();
	var user = $.trim($("input.login").val());
	var pass = $.trim($("input.pass").val());
	if(user.length == 0){
	valid = false;
	$("p.user").remove();
	$("#popup_content").append('<p class="user" id="warning">Username Required!</p>');
	} else{$("p.user").remove();}
	
	if(pass.length == 0){
	valid = false;
	$("p.pass").remove();
	$("#popup_content").append('<p class="pass" id="warning">Password Required!</p>');
	
	} else{$("p.pass").remove();}
	
	if(valid){
	loading();
	var data = {username: user, password: pass};
	$.post('scripts/user.php', data, function(returnedData) {
			closeloading();
			console.log(returnedData);
			if(returnedData.error){
			$("#popup_content").append('<p class="log" id="warning">'+returnedData.error+'</p>');
			}	
		});
		closeloading();
		$("form").remove();
		$("#popup_content").append('<p class="log" style="color:green;">You have logged in! You will be redirected shortly.</p>');
		$( document ).ajaxComplete(function() {location.reload()});
	}
	
	}
	/************** end: functions. **************/
});