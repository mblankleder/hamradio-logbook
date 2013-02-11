<?php

require "config.php";
require "addQso.php";
$result = latestQsos();
$numofrows = mysql_num_rows($result);
echo "
<fieldset>
    <legend>Latest $latests_qsos QSOs</legend>
<table border=\"0\">";
include "qsoHtmlTableHeader.php";
// dynamic stuff
for ($i = 0; $i < $numofrows; $i++) {
    $row = mysql_fetch_array($result);
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
    echo "</td></tr>";
}
echo " 
</table>
</fieldset>
";
?>

