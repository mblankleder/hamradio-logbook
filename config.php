<?php

// personal stuff
$callsign = 'CX6CAU';

// program behavior
$latests_qsos = '10';

// revision 
$version = '0.2.0';

// date and time
date_default_timezone_set('UTC');
$today = date("Y-m-d");
$time = date("H:i:s");

// db
$host_name = 'localhost';
$user_name = 'michel';
$pass_word = 'testpass';
$database_name = 'logbook';
$dbh = mysql_connect($host_name, $user_name, $pass_word) or die('I cannot connect to the database because: ' . mysql_error());
mysql_select_db($database_name);
?>
