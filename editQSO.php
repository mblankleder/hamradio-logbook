<?php
require "config.php";

$cmd_recid = $_GET["mode"];
//echo $cmd_recid . '<BR>';

$tmp_id = explode("_", $cmd_recid);
$command = $tmp_id[0];
$id = $tmp_id[1];

//echo $command . '<BR>';
//echo $id . '<BR>';

include "header.php";
include "menu.html";

echo '
<br>
<fieldset>
<legend>Edit QSO</legend>';

$sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, power, band, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso WHERE id=$id";
$result = mysql_query($sql, $dbh) or die(mysql_error());
$row = mysql_fetch_array($result);

//include "qsoEditTableHeader.php";
//echo "<H3>Record: " . $row[id] . "</H3>";

echo "<form action=\"search.php?mode=update_$id\" method=\"post\">";

echo '
<table border="0">
    <tr class="header">
        <th rowspan="2">
            Date<br />
			(YYYY-MM-DD)
        </th>
        <th  colspan="2">
            Time UTC
        </th>
        <th rowspan="2">
            Band
        </th>
        <th rowspan="2">
            Frequency<br />
        </th>
        <th rowspan="2">
            Mode
        </th>
        <th rowspan="2">
            Power<br />
        </th>
        <th rowspan="2">
            Country/Territory
        </th>
        <th rowspan="2">
            Callsign
        </th>
        <th rowspan="2">
            Operator Name
        </th>
        <th  colspan="2">
            Report
        </th>
    </tr></td>
	<tr class="header">
        <th colspan="2">
            Start
        </th>
        <th>
            Sent
        </th>
        <th>
            Rec\'d
        </th>
    </tr>
	';

	echo "
	<tr bgcolor='#EDF4F8'>
	<td style='width:50px;'><input type='text' name='date' size='10' value='$row[d]' /></td>
	<td colspan='2'><input type='text' name='date' size='8' value='$row[t]' /></td>
	<td><input type='text' name='band' size='5' value='$row[band]' /></td>
	<td><input type='text' name='frequency' size='6' value='$row[frequency]' style='text-align: right;' />Khz</td>
	<td><input type='text' name='mode' size='8' value='$row[mode]' /></td>
	<td><input type='text' name='power' size='4' value='$row[power]' style='text-align: right;' /></td>
	<td><input type='text' name='location' size='20' value='$row[location]' /></td>
	<td><input type='text' name='station' size='10' value='$row[station]' /></td>
	<td><input type='text' name='operator' size='20' value='$row[operator]' /></td>
	<td><input type='text' name='rst_rx' size='3' value='$row[rst_rx]' /></td>
	<td><input type='text' name='rst_tx' size='3' value='$row[rst_tx]' /></td>
	</td></tr>
	</table>";

echo '
<br />
<table>
    <tr class="header">
        <th  colspan="3">
            QSL
        </th>
        <th rowspan="2">
            Remarks
        </th>
    </tr>
    <tr class="header">
        <th>
            Sent
        </th>
        <th>
            Rec\'d
        </th>
        <th>
            Info
        </th>
    </tr>
    <tr style="background-color:#EDF4F8">
        <td valign="top">
            <select name="qsl_snt">
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
            </select>
        </td>
        <td valign="top">
            <select name="qsl_rec">
                <option value="1">Yes</option>
                <option value="0" selected>No</option>
            </select>
        </td>
        <td>
            <textarea name="qsl_info" cols=30 rows=5></textarea>
        </td>
        <td>
            <textarea name="remarks" cols=69 rows=5></textarea>
        </td>
    </tr>
</table>
<br />';
	
	
	echo "
	<!br />
	<input type='submit' name='submit' value='Save to DB' class='icon' title='SAVE' />";
	
echo "</form></fieldset>";
include "footer.html";

?>
