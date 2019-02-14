<?php

session_start();

$userStatus = null;

// Check if logged in.
if (!isset($_SESSION['id'])) {
	$userStatus = 'USER_NOT_LOGGED_IN';
	session_destroy();
	return;
}

// Check if the user is blocked or not registered anymore.
$query = sprintf("SELECT blocked FROM user WHERE id = '%s'", $_SESSION['id']);
$result = mysqli_query($connection, $query);

if (!$result) {
	$userStatus = 'USER_STATUS_UNREACHABLE';
	$_SESSION = array();
	session_destroy();
	return;
}

$tmpCount = mysqli_num_rows($result);
if ($tmpCount == 0) {
	// User not registered anymore.
	$userStatus = 'USER_BLOCKED';
	$_SESSION = array();
	session_destroy();
	return;
}

$userRow = mysqli_fetch_array($result);
// print_r($userRow);
if ($userRow['blocked'] == 1) {
	// Logout the user.
	$userStatus = 'USER_BLOCKED';
	$_SESSION = array();
	session_destroy();
}

?>