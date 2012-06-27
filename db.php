<?php
$dbh=mysql_connect ("localhost", "michel", "test") or die ('I cannot connect to the database because: ' . mysql_error());
 mysql_select_db ("logbook");
?>
