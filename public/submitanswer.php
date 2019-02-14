<?php

error_reporting(1);
date_default_timezone_set('Asia/Calcutta');

$microSubmitTime = microtime(true);
$submitTime = date("Y-m-d H:i:s", $microSubmitTime);

require 'timer.php';

if ($timerData['status'] != 1) {
	exit($timerData['message']);
}

// Check if answer submitted.
if (!isset($_POST['value'])) {
	exit('NO_ANSWER_SUBMITTED');
}

require 'checkuserstatus.php';

if ($userStatus != null) {
	exit($userStatus);
}

$conf = parse_ini_file('./../app.ini.php');



$value = mysqli_real_escape_string($connection, htmlentities($_POST['value']));
$value = strtolower($value);
$value = preg_replace('/\s+/', '', $value);
$value = preg_replace('/[.-]+/', '', $value);
//echo "received value is " . $value;
$tmpAttempt = $value;

// do md5 hash in production mode
if($conf["devmode"] == 0){
	$value = md5($value);
}

$query = sprintf("SELECT level FROM user WHERE id = '%s'", $_SESSION['id']);
//echo $query;
$result = mysqli_query($connection, $query);
// var_dump($result);

if (!$result) {
	exit('ERROR_SUBMITTING_ANSWER');
}

$userLevel = mysqli_fetch_array($result);

if ($userLevel['level'] > 50) {
	exit('ERROR_SUBMITTING_ANSWER');
}

$query = sprintf("SELECT answer FROM question WHERE id = '%s'", $userLevel['level']);
//echo $query;
$result = mysqli_query($connection, $query);
if (!$result) {
	exit('ERROR_SUBMITTING_ANSWER');
}

$userRow = mysqli_fetch_array($result);

if ($value != $userRow['answer']) {
	// Incorrect answer.

	$query = sprintf("SELECT last_five_attempts FROM userattempt WHERE user_id = '%s' AND level = '%s'", $_SESSION['id'], $userLevel['level']);
	$result = mysqli_query($connection, $query);

	if (!$result) {
		exit('INCORRECT_ANSWER');
	}

	$tmpCount = mysqli_num_rows($result);
	if ($tmpCount == 1) {
		// Attempts exist.

		$attemptsRow = mysqli_fetch_array($result);

		$attempts = $attemptsRow['last_five_attempts'];
		$attemptsArray = explode('||', $attempts);
		if (count($attemptsArray) == 12) {
			// Five attempts already present.

			// Remove the 1st element.
			array_shift($attemptsArray);

			array_push($attemptsArray, $tmpAttempt);

			$attempts = implode('||', $attemptsArray);
		} else {
			// else simply append this attempt.

			$attempts .= "||$tmpAttempt";
		}

		$attempts = mysqli_real_escape_string($connection, htmlentities($attempts));

		$query = sprintf("UPDATE userattempt SET count = count + 1, last_five_attempts = '$attempts' WHERE user_id = '%s' AND level = '%s'", $_SESSION['id'], $userLevel['level']);
	} else {
		// First attempt.

		$query = sprintf("INSERT INTO userattempt (user_id, level, count, last_five_attempts) VALUES ('%s', '%s', 1, '$tmpAttempt')", $_SESSION['id'], $userLevel['level']);
	}

	mysqli_query($connection, $query);

	exit('INCORRECT_ANSWER');
}

// Correct answer.

$query = sprintf("SELECT * FROM levelcleartime WHERE level = '%s'", $userLevel['level']);
$result1 = mysqli_query($connection, $query);
if (!$result1) {
	// Correct but error while executing the query.
	exit('CORRECT_ANSWER_ERROR_UPDATING');
}

$tmpCount = mysqli_num_rows($result1);

// $handle = fopen("tempcount.txt", "a");
// $contents = $tmpCount . '||' . $_SESSION['id'] . '||' . $_SESSION['level'] . '||' . $userLevel['level'] . "\r\n";
// fwrite($handle, $contents);
// fclose($handle);

if ($tmpCount == 0) {
	// First one to clear this level.

	$query = sprintf("INSERT INTO levelcleartime (level, time, time_micro, user_id) VALUES ('%s', '$submitTime', '$microSubmitTime', '%s')", $userLevel['level'], $_SESSION['id']);
	$result = mysqli_query($connection, $query);
	if (!$result) {
		// Correct but error while executing the query.
		exit('CORRECT_ANSWER_ERROR_UPDATING');
	}
}

// Calculate the points to be given.

$query = sprintf("SELECT COUNT(*) AS count FROM user WHERE level > '%s'", $userLevel['level']);
$result = mysqli_query($connection, $query);
if (!$result) {
	// Correct but error while executing the query.
	exit('CORRECT_ANSWER_ERROR_UPDATING');
}

$count = mysqli_fetch_array($result);

// if level > 20
if ($userLevel['level'] >= 20) {
	if ($count['count'] < 10) {
		$points = 10;
	} else if ($count['count'] < 30) {
		$points = 9;
	} else {
		$points = 8;
	}
} else {
	if ($count['count'] < 20) {
		// first 20 people get 10 points
		$points = 10;
	} else if ($count['count'] < 50) {
		// next 30 get 9 points
		$points = 9;
	} else {
		// all others get 8 points
		$points = 8;
	}
}

// Update the user table.
$query = sprintf("UPDATE user SET level = '%s', points = points + $points, level_update_time = '$submitTime', level_update_time_micro = '$microSubmitTime', last_hint_time = '$submitTime', next_hint = 1 WHERE id = '%s'", $userLevel['level'] + 1, $_SESSION['id']);
$result = mysqli_query($connection, $query);
if (!$result) {
	// Correct but error while executing the query.
	exit('CORRECT_ANSWER_ERROR_UPDATING');
}

// SUCCESS.

$_SESSION['level'] += 1;
echo 1;

?>