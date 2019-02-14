<?php

$conf = parse_ini_file('./../app.ini.php');

if ($conf["devmode"] == 1) {
    error_reporting(1);
} else {
    error_reporting(0);
}


$servername = $conf["server_name"];
$username = $conf["snishal_username"];
$DB_NAME = $conf["db_name"];
$password = $conf["snishal_pass"];

$connection = mysqli_connect($servername, $username, $password, $DB_NAME);
if (!$connection) {
    echo ('ERROR_CONNECTION_FAILURE');
}
// THis is generating error : don't echo
// else{
// 	echo('Connected');
// }

?>