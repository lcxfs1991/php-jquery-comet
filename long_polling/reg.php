<?php
	session_start();

	if (isset($_SESSION['username'])){
		header('Location: /comet/long_polling/index.php');
	}

	if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

		if (isset($_POST['username'])){

			$filename = './user.txt';
			$username = $_POST['username'];
		
			$fp = fopen($filename, 'a+');

			if (flock($fp, LOCK_EX)) { // do an exclusive lock
			    
			    $userArray = explode(',', fread($fp, @filesize($filename)));
			    
			    $len = count($userArray);

			    for ($i = 0; $i < $len; $i++){

			    	if ($username == $userArray[$i]){
			    		echo "Duplicate Username";
			    		exit(0);
			    	}

			    }

			    fwrite($fp, ','.$username);

			    $_SESSION['username'] = $username;

			    flock($fp, LOCK_UN); // release the lock
			} else {
			    echo "Couldn't lock the file !";
			    exit(0);
			}

			fclose($fp);

			header('Location: /comet/long_polling/index.php');

		}
		else {

		}
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

	<form action="/comet/long_polling/reg.php" method="POST"/>
		<input type="text" value="" name="username"/>
		<button id="click1">click1</button>
	</form>
	
</body>
