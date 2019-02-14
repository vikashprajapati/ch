<?php

require 'timer.php';
if ($timerData['status'] != 1) {
	exit($timerData['message']);
}

require 'checkuserstatus.php';
if ($userStatus != null) {
	exit($userStatus);
}

$conf = parse_ini_file('./../app.ini.php');


$hintsData = array();
$id = $_SESSION['id'];
//Get all previous hints of user
$queryGetAllPrevHints = "SELECT data
						 FROM user, hint
						 WHERE id = '$id' and ques_id = level and hint_number < next_hint";

$resultGetAllPrevHints = mysqli_query($connection, $queryGetAllPrevHints);
if (!$resultGetAllPrevHints) {
	exit('ERROR_RETRIEVING_HINTS');
}

// print_r($resultGetAllPrevHints);
if (mysqli_num_rows($resultGetAllPrevHints) > 0) {
	while ($hints = mysqli_fetch_array($resultGetAllPrevHints)) {
		if ($conf["devmode"] == 1) {
			array_push($hintsData, $hints["data"]);
		} else {
			array_push($hintsData, base64_decode($hints["data"]));
		}
	}
}

while (true) {
	//Retrieve some details of user to calculate next hint time
	$query = "SELECT level, next_hint, last_hint_time
	  	  	  FROM user
	  		  WHERE id = '$id'";

	$result = mysqli_query($connection, $query);
	if (!$result) {
		exit('ERROR_RETRIEVING_HINTS');
	}

	if (mysqli_num_rows($result) > 0) {
		$participant = mysqli_fetch_array($result);

		// time manipulation
		date_default_timezone_set('Asia/Calcutta');
		$currTime = time();
		$nextHintTime = 0;
	
		// default setting
		$LL_fdflh = 5;
		$LL_atfbohl = 1;
		$ppiat = 20;
		$UL_fdflh = 10;
		$UL_atfbohl = 2;

		// fetch setting from db - works - add a new row to set to default
		$queryToGetTimeControlSettings = "SELECT * FROM `hint_time_control`";
		$resultGetTimeControlSettings = mysqli_query($connection, $queryToGetTimeControlSettings);
		if ($resultGetTimeControlSettings && mysqli_num_rows($resultGetTimeControlSettings) > 0) {
			while ($s = mysqli_fetch_assoc($resultGetTimeControlSettings)) {
				$LL_fdflh = (int)$s["LowerLevels_fixed_distance_from_last_hint"];
				$LL_atfbohl = (int)$s["LowerLevels_added_time_factor_based_on_hint_level"];
				$ppiat = (int)$s["partition_point_is_at_level"];
				$UL_fdflh = (int)$s["UpperLevels_fixed_distance_from_last_hint"];
				$UL_atfbohl = (int)$s["UpperLevels_added_time_factor_based_on_hint_level"];
			}
		}

		// testing
		// print_r($LL_fdflh);

		if ($participant["level"] <= $ppiat) {
			$nextHintTime = ($LL_fdflh * 60) + ($participant["next_hint"] * $LL_atfbohl * 60) + strtotime($participant["last_hint_time"]);
		} else {
			$nextHintTime = ($UL_fdflh * 60) + ($participant["next_hint"] * $UL_atfbohl * 60) + strtotime($participant["last_hint_time"]);
		}


		if ($nextHintTime <= $currTime) {
			// nothing
		} else {
			$nextHintTime = 0;
		}

		$participantLevel = $participant["level"];
		$participantNextHintNumber = $participant["next_hint"];

		if ($nextHintTime == 0) {
			//Check if hint not available
			$queryIsHintPresent = "SELECT data
						 		   FROM hint
						 		   WHERE ques_id = '$participantLevel' and hint_number = '$participantNextHintNumber'";

			$resultIsHintPresent = mysqli_query($connection, $queryIsHintPresent);
			if (!$resultIsHintPresent) {
				exit('ERROR_RETRIEVING_HINTS');
			}

			if (mysqli_num_rows($resultIsHintPresent) > 0)
				array_push($hintsData, "You are not eligible for more hints currently. Check back later!");
			else
				array_push($hintsData, "No more hints available for this question currently.");

			break;
		}

		//Get appropriate hint for the user
		$queryGetHint = "SELECT data
						 FROM hint
						 WHERE ques_id = '$participantLevel' and hint_number = '$participantNextHintNumber'";

		$resultGetHint = mysqli_query($connection, $queryGetHint);
		if (!$resultGetHint) {
			exit('ERROR_RETRIEVING_HINTS');
		}

		if (mysqli_num_rows($resultGetHint) > 0) {
			$hint = mysqli_fetch_array($resultGetHint);
			if ($conf["devmode"] == 1) {
				array_push($hintsData, $hint["data"]);
			} else {
				array_push($hintsData, base64_decode($hint["data"]));
			}

			$nextHintDateTime = date("Y-m-d H:i:s", $nextHintTime);
			$nextHintNumber = $participant["next_hint"] + 1;
			//Update new hint number and last hint time of user as calculated by algorithm
			$queryUpdateUserDetails = "UPDATE user
									   SET next_hint = '$nextHintNumber', last_hint_time = '$nextHintDateTime'
									   WHERE id = '$id'";

			$resultUpdateUserDetails = mysqli_query($connection, $queryUpdateUserDetails);
			if (!$resultUpdateUserDetails) {
				exit('ERROR_RETRIEVING_HINTS');
			}

		} else {
			array_push($hintsData, "No more hints available for this question currently.");
			break;
		}
	} else {
		break;
	}
}

echo json_encode($hintsData);

?>
