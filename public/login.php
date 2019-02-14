<?php

require 'timer.php';
if ($timerData['status'] == -1) {
	// Event ended.
	exit($timerData['message']);
}

session_start();

if (!isset($_POST['id']) || !isset($_POST['name'])) {
	session_destroy();
	exit('LOGIN_DATA_MISSING');
}

if ($_POST['id'] == 0 || $_POST['name'] == 'undefined') {
	session_destroy();
	exit('LOGIN_DATA_MISSING');
}

require 'connect.php';

$userLevel = '1';
$id = mysqli_real_escape_string($connection, $_POST['id']);
$username = mysqli_real_escape_string($connection, htmlentities($_POST['name']));
$email = mysqli_real_escape_string($connection, $_POST['email']);
$profilePicUrl = mysqli_real_escape_string($connection, urlencode($_POST['pictureUrl']));

$query = "SELECT blocked, level FROM user WHERE id = '$id'";
$result = mysqli_query($connection, $query);

if (!$result) {
	// Unable to register.
	session_destroy();
	// echo mysqli_error($connection);
	exit('USER_REG_ERROR');
}

$tmpCount = mysqli_num_rows($result);
if ($tmpCount == 0) {
	//session_destroy();
	//exit('USER_REG_CLOSE');

	// New user.
	date_default_timezone_set('Asia/Kolkata');

	$microRegTime = microtime(true);
	$regTime = date("Y-m-d H:i:s", $microRegTime);

	$query = "INSERT INTO user (id, name, email, picture_url, blocked, level, points, level_update_time, level_update_time_micro, last_hint_time, next_hint) VALUES ('$id', '$username', '$email', '$profilePicUrl', 0, 1, 0, '$regTime', '$microRegTime', '$regTime', 1)";
	$result = mysqli_query($connection, $query);
	if (!$result) {
		// Unable to register.
		// echo mysqli_error($connection);
		session_destroy();
		exit('USER_REG_ERROR');
	}

} else {
	// Existing user.
	$userRow = mysqli_fetch_array($result);

	if ($userRow['blocked'] == 1) {
		// User blocked.
		session_destroy();
		exit('USER_BLOCKED');
	}

	$userLevel = $userRow['level'];
}

mysqli_close($connection);

if ($timerData['status'] == 0) {
	// User registered before the event.
	exit($timerData['message']);
}

$_SESSION['id'] = $id;
$_SESSION['name'] = $username;
$_SESSION['level'] = $userLevel;

// SUCCESS.
echo 1;

?>