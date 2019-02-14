<?php

require 'timer.php';
if ($timerData['status'] != 1) {
    exit($timerData['message']);
}

require 'checkuserstatus.php';
if ($userStatus != null) {
    exit($userStatus);
}

function convert_to_split_time($microDiff)
{
    $totalSeconds = floor($microDiff);
    $remaining = $totalSeconds % 3600;

    $hours = floor($totalSeconds / 3600);
    $minutes = floor($remaining / 60);
    $seconds = $remaining % 60;

    $strMicro = sprintf('%0.4f', $microDiff);
    $tmpArray = explode('.', $strMicro);

    return "$hours : $minutes : $seconds . " . $tmpArray[1];
}

$leaderboardData = array();
$id = $_SESSION['id'];
//Get the details of current participant to show on top of leader board if exist
$queryCurrUser = "SELECT u.picture_url, u.name, u.level, u.points, (u.level_update_time_micro - l.time_micro) AS microDiff
                  FROM user as u, levelcleartime as l
                  WHERE id = '$id' and  l.level = u.level - 1";

$resultCurrUser = mysqli_query($connection, $queryCurrUser);
if (!$resultCurrUser) {
    exit('ERROR_UPDATING_LEADERBOARD');
}

if (mysqli_num_rows($resultCurrUser) > 0) {
    $participant = mysqli_fetch_array($resultCurrUser);

    $currUserSplitTime = convert_to_split_time($participant["microDiff"]);
    $currUserLevel = $participant["level"];
    $currUserPoints = $participant["points"];

    //Get the number of participants level and points above current participant
    $queryCurrUserRank1 = "SELECT SUM(T.rank1) AS rank1
                           FROM  (
                                  SELECT count(*) AS rank1
                                  FROM user
                                  WHERE level > '$currUserLevel'

                                  UNION
                                  
                                  SELECT count(*)
                                  FROM user
                                  WHERE level <= 50 and level = '$currUserLevel' and points > '$currUserPoints'
                                  ) AS T";
                              
    //Get the number of participants with same level and points but less level update time and
    //with last level cleared and less level update time
    $queryCurrUserRank2 = "SELECT SUM(T.rank2) AS rank2
                           FROM  (
                                  SELECT count(*) AS rank2
                                  FROM user
                                  WHERE level <= 50 and level = '$currUserLevel' and points = '$currUserPoints' and
                                        level_update_time_micro <= (SELECT level_update_time_micro
                                                                    FROM user
                                                                    WHERE id = '$id')

                                  UNION

                                  SELECT count(*)
                                  FROM user
                                  WHERE level = 51 and level = '$currUserLevel' and 
                                        level_update_time_micro <= (SELECT level_update_time_micro
                                                                    FROM user
                                                                    WHERE id = '$id')
                                  ) as T";

    $resultCurrUserRank1 = mysqli_query($connection, $queryCurrUserRank1);
    if (!$resultCurrUserRank1) {
        exit('ERROR_UPDATING_LEADERBOARD');
    }
    $resultCurrUserRank2 = mysqli_query($connection, $queryCurrUserRank2);
    if (!$resultCurrUserRank2) {
        exit('ERROR_UPDATING_LEADERBOARD');
    }

    if (mysqli_num_rows($resultCurrUserRank1) > 0) {
        if (mysqli_num_rows($resultCurrUserRank2) > 0) {
            $tempRank1 = mysqli_fetch_array($resultCurrUserRank1);
            $tempRank2 = mysqli_fetch_array($resultCurrUserRank2);

            $currUserRank = $tempRank1["rank1"] + $tempRank2["rank2"];

            $leaderboardData[0] = array(
                'rank' => $currUserRank, 'url' => urldecode($participant["picture_url"]),
                'name' => $participant["name"], 'level' => $participant["level"],
                'points' => $participant["points"], 'splitTime' => $currUserSplitTime
            );
        }
    }
} else {
    $queryCurrUser = "SELECT picture_url, name, level, points
                      FROM user
                      WHERE id = '$id' and level = 1";

    $resultCurrUser = mysqli_query($connection, $queryCurrUser);
    if (!$resultCurrUser) {
        exit('ERROR_UPDATING_LEADERBOARD');
    }

    if (mysqli_num_rows($resultCurrUser) > 0) {
        $participant = mysqli_fetch_array($resultCurrUser);
        $currUserRank = "N/A";
        $currUserSplitTime = "N/A";

        $leaderboardData[0] = array(
            'rank' => $currUserRank, 'url' => urldecode($participant["picture_url"]),
            'name' => $participant["name"], 'level' => $participant["level"],
            'points' => $participant["points"], 'splitTime' => $currUserSplitTime
        );
    }
}
//Get details of top 100 participants when last level cleared
$query = "SELECT u.picture_url, u.name, u.level, u.points, (u.level_update_time_micro - l.time_micro) AS microDiff
          FROM user AS  u, levelcleartime AS l 
          WHERE l.level = u.level - 1 and u.level = 51
          ORDER BY level_update_time_micro ASC LIMIT 100";

$result = mysqli_query($connection, $query);
if (!$result) {
    exit('ERROR_UPDATING_LEADERBOARD');
}

$rank = 0;
if (mysqli_num_rows($result) > 0) {
    while ($participants = mysqli_fetch_array($result)) {
        $rank = $rank + 1;
        $splitTime = convert_to_split_time($participants["microDiff"]);

        $leaderboardData[$rank] = array(
            'rank' => $rank, 'url' => urldecode($participants["picture_url"]),
            'name' => $participants["name"], 'level' => $participants["level"],
            'points' => $participants["points"], 'splitTime' => $splitTime
        );
    }

}

//Get details of remaining top 100 participants
$query = "SELECT u.picture_url, u.name, u.level, u.points, (u.level_update_time_micro - l.time_micro) AS microDiff
          FROM user AS  u, levelcleartime AS l 
          WHERE l.level = u.level - 1 and u.level <= 50
          ORDER BY level DESC, points DESC, level_update_time_micro ASC LIMIT 100";

$result = mysqli_query($connection, $query);
if (!$result) {
    exit('ERROR_UPDATING_LEADERBOARD');
}

if (mysqli_num_rows($result) > 0) {
    while ($participants = mysqli_fetch_array($result)) {
        $rank = $rank + 1;
        $splitTime = convert_to_split_time($participants["microDiff"]);

        if (count($leaderboardData) > 100)
            break;

        $leaderboardData[$rank] = array(
            'rank' => $rank, 'url' => urldecode($participants["picture_url"]),
            'name' => $participants["name"], 'level' => $participants["level"],
            'points' => $participants["points"], 'splitTime' => $splitTime
        );
    }
}

$query = "SELECT name, level, points, picture_url
          FROM user
          WHERE level = 1 LIMIT 100";

$result = mysqli_query($connection, $query);
if (!$result) {
    exit('ERROR_UPDATING_LEADERBOARD');
}

if (mysqli_num_rows($result) > 0) {
    $index = $rank;
    while ($participants = mysqli_fetch_array($result)) {
        $index = $index + 1;
        $rank = "N/A";
        $splitTime = "N/A";

        if (count($leaderboardData) > 100)
            break;

        $leaderboardData[$index] = array(
            'rank' => $rank, 'url' => urldecode($participants["picture_url"]),
            'name' => $participants["name"], 'level' => $participants["level"],
            'points' => $participants["points"], 'splitTime' => $splitTime
        );

    }
}

echo json_encode($leaderboardData);

?>
