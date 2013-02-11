<?php

include "config.php";
$query = "SELECT id,indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as d, DATE_FORMAT(fecha_hora , '%H:%i') as t, modo, banda, frecuencia, ubicacion, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso order by d desc";
$result = mysql_query($query);
$numofrows = mysql_num_rows($result);
echo "
<table border=\"0\">
    <tr class=\"header\">
        <th rowspan=\"2\">
            Date
        </th>
        <th  colspan=\"2\">
            Time UTC
        </th>
        <th rowspan=\"2\">
            Band
        </th>
        <th rowspan=\"2\">
            Frequency<br />
            (Mhz)
        </th>
        <th rowspan=\"2\">
            Mode
        </th>
        <th rowspan=\"2\">
            Power<br />
            (dBW)
        </th>
        <th rowspan=\"2\">
            Country/Territory
        </th>
        <th rowspan=\"2\">
            Station<br />
            Called/Worked
        </th>
        <th rowspan=\"2\">
            Operator
        </th>
        <th  colspan=\"2\">
            Report
        </th>
        <th  colspan=\"3\">
            QSL
        </th>
        <th rowspan=\"2\">
            Remarks
        </th>
    </tr>
    <tr class=\"header\">
        <th>
            Start
        </th>
        <th>
            Finish
        </th>
        <th>
            Sent
        </th>
        <th>
            Rec'd
        </th>
        <th>
            Sent
        </th>
        <th>
            Rec'd
        </th>
        <th>
            Info
        </th>
    </tr>";
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
    echo $row['banda'];
    echo "</td><td>";
    echo $row['frecuencia'];
    echo "</td><td>";
    echo $row['modo'];
    echo "</td><td>";
    echo "100";
    echo "</td><td>";
    echo $row['ubicacion'];
    echo "</td><td>";
    echo $row['indicativo'];
    echo "</td><td>";
    echo $row['operador'];
    echo "</td><td>";
    echo $row['rst_rx'];
    echo "</td><td>";
    echo $row['rst_tx'];
    echo "</td><td>";
    echo $row['qsl_env'];
    echo "</td><td>";
    echo $row['qsl_rec'];
    echo "</td><td style='width: 200px'>";
    echo $row['qsl_info'];
    echo "</td><td style='width: 200px'>";
    echo $row['comentarios'];
    echo "</td></tr>";
}
echo " 
</table>
";
?>

