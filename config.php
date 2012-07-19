<?php
$callsign='CX6CAU';

$host_name = 'localhost';
$user_name = 'michel';
$pass_word = 'testpass';
$database_name = 'logbook';

$dbh = mysql_connect($host_name, $user_name, $pass_word) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db($database_name);
?>
