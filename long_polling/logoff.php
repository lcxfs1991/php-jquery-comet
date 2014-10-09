<?php

	session_start();

	if (!isset($_SESSION['username'])){
		header('Location: /comet/long_polling/reg.php');
	}

	$username = $_SESSION['username'];

	$filename = './user.txt';

	$fp = fopen($filename, 'r+');

	if (flock($fp, LOCK_EX)) { // do an exclusive lock
			    
		$userArray = explode(',', fread($fp, filesize($filename)));
		
		// var_dump($userArray);
		$len = count($userArray);

		for ($i = 0; $i < $len; $i++){

			if ($username == $userArray[$i]){
			    unset($userArray[$i]);
			    break;
			}

		}

		file_put_contents($filename, implode(",", $userArray));

		flock($fp, LOCK_UN); // release the lock

		unset($_SESSION['username']);
	}
	else {
		
		echo "Couldn't lock the file !";
		exit(0);
	}

	header('Location: /comet/long_polling/reg.php');


?>