<?php

set_time_limit(0);

$filename = './data.txt';

if (isset($_GET['m']) && !empty($_GET['m'])){
	file_put_contents($filename, $_GET['m']);
	exit(0);
}

// if (isset($_POST['m']) && !empty($_POST['m'])){
// 	// file_put_contents($filename, $_POST['m']);
// 	echo $_POST['m'];
// 	exit(0);
// }

$old = filemtime($filename);
$cur = filemtime($filename);

while ( $cur <= $old){
	usleep(500000);
	clearstatcache();
	$cur = filemtime($filename);
}

echo file_get_contents($filename);





?>