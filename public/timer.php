<?php
require 'connect.php';
date_default_timezone_set('Asia/Calcutta');

$conf = parse_ini_file('./../app.ini.php');

$queryToGetGameTime = "SELECT * FROM `game_time_control`";
$resultGetGameTime = mysqli_query($connection, $queryToGetGameTime);
if ($resultGetGameTime && mysqli_num_rows($resultGetGameTime) > 0) {
	while ($s = mysqli_fetch_assoc($resultGetGameTime)) {
		$startTime = $s["start_time"];
		$endTime = $s["end_time"];
	}
}

// Event start time.
// mktime(hour,minute,second,month,day,year,is_dst);
// $startTime = mktime(0, 0, 0, 2, 12, 2019);
// $startTime = mktime(00, 48, 00, 2, 1, 2019);
$startTime = strtotime($startTime);

// Event end time.
// $endTime = mktime(22, 0, 0, 2, 13, 2019);
$endTime = strtotime($endTime);

// Current time.
$currTime = time();

$startDiff = $currTime - $startTime;
$endDiff = $currTime - $endTime;

$timerData = array('status' => null, 'message' => null, 'value' => null);

if ($startDiff < 0) {
	// Event hasn't started yet.
	$timerData['status'] = 0;
	$timerData['value'] = abs($startDiff);
	$timerData['message'] = 'THE GAME IS ABOUT TO BEGIN. ARE YOU READY?';
} else if ($endDiff < 0) {
	// Event running.
	$timerData['status'] = 1;
	$timerData['value'] = abs($endDiff);
	$timerData['message'] = 'THE GAME HAS BEGUN. GO FOR IT!';
} else {
	// Event ended.
	$timerData['status'] = -1;
	$timerData['value'] = 0;
	$timerData['message'] = 'THE GAME HAS ENDED';
}

if (isset($_GET['operation'])) {
	if ($_GET['operation'] == 'difference') {
		echo json_encode($timerData);
	}
}



?>