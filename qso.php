<?php
require "config.php";
echo "<br>";
require "addQso.php";
echo "<br>";
$result = latestQsos();
$numofrows = mysql_num_rows($result);

echo "
<fieldset>
    <legend>Last $latests_qsos QSO's</legend>
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
    //echo "<center>" . $row[id] . "</center></td><td>";
	echo $row['d'];
    echo "</td><td>";
    echo $row['t'];
    echo "</td><td colspan='2'>";
    //echo "&nbsp;";
	//echo $row['t'];
    //echo "</td><td>";
    echo $row['band'];
    echo "</td><td>";
    echo "<p style='text-align:right;'>" . $row['frequency'] . "</p>";
    echo "</td><td>";
    echo $row['mode'];
    echo "</td><td>";
    echo "<p style='text-align:right;'>" . $row['power'] . "w</p>";
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
    if (strlen($row['remarks']) > 50) {
		echo substr($row['remarks'],0,50) . "&nbsp;<b>...</b>";
	} else {
		echo $row['remarks'];
	}
    echo "</td></tr>";
}
echo " 
</table>
<BR><BR>
</fieldset>
";
?>

