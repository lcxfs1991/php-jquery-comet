<?php
session_start();

if (!isset($_SESSION['username'])){
	header('Location: /comet/long_polling/reg.php');
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="../js/jquery.min.js"></script>
	<title>Comet</title>
</head>
<body>
	<div>
		<div></div>
		<ul class="chat">
			
		</ul>
	</div>
	<input id="inputchat" type="text" value="">
	<button id="click1">click1</button>
	<script type="text/javascript">
		var sending = false;
		var chatlog = $(".chat");
		var msg = '';

		function chat(){
				
			$.ajax({
				type: 'GET',
				url: "server.php",
				timeout: 0,
				beforeSend: function(){
					if (sending){
						return false;
					}
					sending = true;
				},
				success: function(data){
					chatlog.append("<li>"+data+"</li>");
				},
				error: function(data){

				},
				complete: function(){
					sending = false;
					chat();
				}
			});
		}

		$(function(){

			var send = false;
			

			$("#click1").click(function(){
					msg = $("#inputchat").val();
					$.ajax({
						type: 'GET',
						url: "server.php",
						timeout: 0,
						beforeSend: function(){
							
							// alert(msg);
							$("#inputchat").val("");

							if (send){
								return false;
							}
							send = true;
						},
						data: {'m': msg, 'click': true},
						success: function(data){
							
						},
						error: function(data){

						},
						complete: function(){
							send = false;
						}
					});
			});


			setTimeout(chat(), 20);

		});
	</script>
</body>
