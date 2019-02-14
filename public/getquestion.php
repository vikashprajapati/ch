<?php

require 'timer.php';
if ($timerData['status'] != 1) {
	exit($timerData['message']);
}

require 'checkuserstatus.php';
if ($userStatus != null) {
	exit($userStatus);
}

// Check if the user cleared all the questions.
// todo - fetch this based on number of questions
$totalLevels = 35;
if ($_SESSION['level'] > $totalLevels) {
	$query = "SELECT id FROM user WHERE level > 50 ORDER BY level_update_time_micro ASC LIMIT 1";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		exit('ERROR_RETRIEVING_QUESTION');
	}

	$winnerRow = mysqli_fetch_array($result);

	if ($winnerRow['id'] == $_SESSION['id']) {
		exit('EVENT_COMPLETED_WINNER');
	}

	exit('EVENT_COMPLETED_CONGRATS');
}

$query = sprintf("SELECT level FROM user WHERE id = '%s'", $_SESSION['id']);
$result = mysqli_query($connection, $query);
if (!$result) {
	exit('ERROR_RETRIEVING_QUESTION');
}

$userRow = mysqli_fetch_array($result);

$query = sprintf("SELECT data, type FROM question WHERE id = '%s'", $userRow['level']);
$result = mysqli_query($connection, $query);
if (!$result) {
	exit('ERROR_RETRIEVING_QUESTION');
}

$quesRow = mysqli_fetch_array($result);

$retValue = array('level' => $userRow['level'], 'type' => $quesRow['type'], 'data' => $quesRow['data']);

echo json_encode($retValue);

?>