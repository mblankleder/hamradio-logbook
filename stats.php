<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
require 'config.php';
include "header.php";
include "menu.html";

function CalcFullDatabaseSize($database, $db) {
    $tables = mysql_list_tables($database, $db);
    if (!$tables) { return -1; }
 
    $table_count = mysql_num_rows($tables);
    $size = 0;
 
    for ($i=0; $i < $table_count; $i++) {
        $tname = mysql_tablename($tables, $i);
        $r = mysql_query("SHOW TABLE STATUS FROM ".$database." LIKE '".$tname."'");
        $data = mysql_fetch_array($r);
        $size += ($data['Index_length'] + $data['Data_length']);
    };
 
    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
    for ($i = 0; $size > 1024; $i++) { $size /= 1024; }
    return round($size, 2).$units[$i];
}

echo "<br><fieldset><legend>Statistics</legend><br>";

$result = mysql_query("SELECT * FROM qso", $dbh);
$num_rows = mysql_num_rows($result);

echo "<H2>";
echo "Number of QSO's: " . $num_rows . "<BR>";

// get the size of all tables in this database:
echo "Database size: " . CalcFullDatabaseSize('iron587_hamlog', $dbh) . "<BR><BR>";
// --> returns something like: 484.2 KB


echo "We're working hard on the programming to being you more features!<BR>";
echo "Check for program updates by clicking ";
echo "<a href='https://github.com/mblankleder/hamradio-logbook' target='_blank'>HERE</a>";
echo "</H2>";
echo "<BR><BR><BR>";

echo "</span><br></fieldset>";
include "footer.html";
?>
