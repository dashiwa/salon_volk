﻿$(document).ready(function(){
	//global vars
	var inputUser = $("#nick");
	var inputMessage = $("#message");
	var loading = $("#loading");
	var messageList = $(".content > p");
	
	//functions
	function updateShoutbox(){
		//just for the fade effect
		messageList.hide();
		loading.fadeIn();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", url: "index.php?page=shoutbox", data: "action=update",
			complete: function(data){
				loading.fadeOut();
				messageList.html(data.responseText);
				messageList.fadeIn("fast");
			}
		});
	}
	
	//check if all fields are filled
	function checkForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return false;
	}
	
	//Load for the first time the shoutbox data
	updateShoutbox();
	
	//setInterval( updateShoutbox, 30000);
	
	//on submit event
	$("#form").submit(function(){
		if(checkForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			//we deactivate submit button while sending
			$("#send").attr({ disabled:true, value:"Отправляю..." });
			$("#send").blur();
			//send the post to shoutbox.php
			$.ajax({
				type: "POST", url: "index.php?page=shoutbox", data: "action=insert&nick=" + nick + "&message=" + message,
				complete: function(data){
					messageList.html(data.responseText);
					updateShoutbox();
					//reactivate the send button
					$("#send").attr({ disabled:false, value:"Отправить" });
				}
			 });
		}
		else alert("Пожалуйста, представьтесь и напишите сообщение");
		//we prevent the refresh of the page after submitting the form
		return false;
	});
});


