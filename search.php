<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
require "config.php";
include "functions.php";
include "header.php";
include "menu.html";
echo "
<fieldset>
    <legend>Search and Edit</legend>
    <p>Enter a callsign or some part of it to start the search</p>
    <form name=\"form\" action=\"search.php?mode=search\" method=\"post\">
        <input type=\"text\" name=\"callSignStr\" maxlength=\"8\" />
        <input type=\"submit\" name=\"searchBtn\" value=\"Search\" />
    </form>
<table>
";
$m = $_GET["mode"];
// check if mode is empty or the number of rows returned after the search is zero
if (empty($m)) {
    $numofrows = 0;
    include "footer.html";
} else {
    $qsos = qsoMode($m);
    $numofrows = mysql_num_rows($qsos);
    if ($numofrows == 0) {
        //echo "Nothing found :("; Need to fix this
        include "footer.html";
    } else {
        echo "
    <table border=\"0\">";
        include "qsoHtmlTableHeader.php";
        // dynamic stuff
        for ($i = 0; $i < $numofrows; $i++) {
            $row = mysql_fetch_array($qsos);
            if ($i % 2) {
                echo "<tr bgcolor=\"#EDF4F8\"><td>";
            } else {
                echo "<tr bgcolor=\"#f8f9ed\"><td>";
            }
            echo $row['d'];
            echo "</td><td>";
            echo $row['t'];
            echo "</td><td>";
            echo $row['t'];
            echo "</td><td>";
            echo $row['band'];
            echo "</td><td>";
            echo $row['frequency'];
            echo "</td><td>";
            echo $row['mode'];
            echo "</td><td>";
            echo "100";
            echo "</td><td>";
            echo $row['location'];
            echo "</td><td>";
            echo $row['station'];
            echo "</td><td>";
            echo $row['operator'];
            echo "</td><td>";
            echo $row['rst_rx'];
            echo "</td><td>";
            echo $row['rst_tx'];
            echo "</td><td>";
            echo $row['qsl_snt'];
            echo "</td><td>";
            echo $row['qsl_rec'];
            echo "</td><td style='width: 200px'>";
            echo $row['qsl_info'];
            echo "</td><td style='width: 200px'>";
            echo $row['remarks'];
            echo "</td><td>";
            echo "<a href=\"search.php?mode=edit_$row[id]\"><center><img src=\"img/Modify.png\" /></center></a>";
            echo "</td></tr>";
        }
        echo " 
</table>
</fieldset>
";
        include "footer.html";
    }
}
?>


