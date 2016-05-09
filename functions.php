<?php
// load combo
function loadCombo($table, $field) {
    $result = mysql_query("SELECT $field FROM $table") or trigger_error(mysql_error());
    return $result;
}

// special for the bands
function loadComboBands() {
    $result = mysql_query("SELECT band FROM bands order by CAST(frequency as decimal) desc") or trigger_error(mysql_error());
    return $result;
}

function qsoMode($cmd_recid) {
    include "config.php";
    $tmp_id = explode("_", $cmd_recid);
	$command = $tmp_id[0];
	$id = $tmp_id[1];
	//echo "[functions.qsoMode] Command=" . $command . "<br>";
	//echo "[functions.qsoMode] ID=" . $id . "<br>";
	if ($command == "add") {
        $date = $_POST["date"];
        $timeStart = $_POST["timeStart"];
        $timeEnd = $_POST["timeEnd"];
        $band = $_POST["band"];
        $frequency = $_POST["freq"];
        $mode = $_POST["mode"];
        $power = $_POST["power"];
        $location = $_POST["location"];
        $station = strtoupper($_POST["station"]);
        $operator = $_POST["operator"];
        $rst_rx = $_POST["rst_rx"];
        $rst_tx = $_POST["rst_tx"];
        $qsl_snt = $_POST["qsl_snt"];
        $qsl_rec = $_POST["qsl_rec"];
        $qsl_info = $_POST["qsl_info"];
        $remarks = $_POST["remarks"];

        $date_startTime = $date . " " . $timeStart;

        $sql = "INSERT INTO qso (station, operator, location, date_startTime, mode, power, band, frequency, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks) VALUES ('$station','$operator','$location','$date_startTime','$mode','$power','$band','$frequency','$rst_rx','$rst_tx','$qsl_snt','$qsl_rec','$qsl_info','$remarks')";
		mysql_query($sql, $dbh) or die(mysql_error());
        mysql_close($dbh);
        header("Location: main.php");
    }
    // SEARCH
	if ($command == "search") {
		//echo "*<BR>";
        $sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, power, band, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso WHERE station LIKE '%{$_POST['callSignStr']}%' order by date_startTime desc";
        $result = mysql_query($sql, $dbh) or die(mysql_error());
        return $result;
    }
	// EDIT
	if ($command == "edit") {
    //$regexp = "/^edit_[0-9]/";
    //if (preg_match($regexp, $mode)) {
        //$id = explode("_", $mode);
        $sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, power, band, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso WHERE id=$id";
        $result = mysql_query($sql, $dbh) or die(mysql_error());
        // algo como inlude edit.php
        //echo $result;
        $row = mysql_fetch_array($result);
        echo "<form action=\"search.php?mode=update_$id\" method=\"post\">";
        
		include 'qsoHtmlTableHeader.php';
        
		echo "<tr bgcolor=\"#EDF4F8\"><td>";
		
		//echo "<center>" . $row[id] . "</center></td><td>";
        
		echo "<input type=\"text\" name=\"date\" size=\"10\" value=\"$row[d]\"/>";
        echo "</td><td>";
        echo "<input type=\"text\" name=\"date\" size=\"5\" value=\"$row[t]\"/>";
        echo "</td><td colspan=\"2\">";
        echo "<select name=\"band\" id=\"bandSelect\" onchange=\"setFreq(this.value)\" >";
        echo "<option selected=\"$row[band]\" value=\"$row[band]\">$row[band]</option>";
            $cb = loadComboBands();
            while ($data = mysql_fetch_array($cb)) {
                echo "<option value=\"$data[band]\">$data[band]</option>";
            }
        echo "</select>";
        echo "</td><td>";
        //echo "<input name=\"freq\" type=\"text\" size=\"5\" id=\"txtFreq\" value=\"$row[frequency]\" maxlength=\"8\" />MHz";
		echo "<input name=\"freq\" type=\"text\" size=\"5\" id=\"txtFreq\" value=\"$row[frequency]\" style=\"text-align:right;\" maxlength=\"5\" />KHz";
        echo "</td><td>";
        echo "<select name=\"mode\">";
        echo "<option selected=\"$row[mode]\" value=\"$row[mode]\">$row[mode]</option>";
            $ci = loadCombo("modes", "mode");
            while ($data = mysql_fetch_array($ci)) {
                echo "<option value=\"$data[mode]\">$data[mode]</option>";
            }
        echo "</select>";
        echo "</td><td>";
        echo "<input name=\"power\" type=\"text\" size=\"4\" value=\"$row[power]\" style=\"text-align:right;\" maxlength=\"4\"/>";
        echo "</td><td>";
        echo "<input name=\"location\" type=\"text\" size=\"10\" id=\"countryTerritory\" maxlength=\"15\" value=\"$row[location]\"/>";
        echo "</td><td>";
        echo "<input name=\"station\" type=\"text\" size=\"10\" maxlength=\"10\" value=\"$row[station]\" />";
        echo "</td><td>";
		echo "<input name=\"operator\" type=\"text\" maxlength=\"15\" value=\"$row[operator]\" />";
        echo "</td><td>";
        //echo $row['rst_rx'];
		echo "<input name=\"rst_rx\" type=\"text\" maxlength=\"3\" size=\"3\" value=\"$row[rst_rx]\" />";
        echo "</td><td>";
        //echo $row['rst_tx'];
		echo "<input name=\"rst_tx\" type=\"text\" maxlength=\"3\" size=\"3\" value=\"$row[rst_tx]\" />";
        echo "</td><td>";
        echo $row['qsl_snt'];
        echo "</td><td>";
        echo $row['qsl_rec'];
        echo "</td><td style='width: 200px'>";
        echo $row['qsl_info'];
		
		echo "</tr></table><table><tr>";
		
		
        echo "<td style='width: 200px'>";
		//echo "</td><td>";
        echo $row['remarks'];
        echo "</td><td>";
        echo "<input type=\"submit\" name=\"submit\" class=\"icon\" title=\"SAVE\" value=\"\"/>";
		//echo "<a href=\"search.php?mode=update_$row[id]\"><center><img src=\"img/print.png\" /></center></a>";
        echo "</td></tr>";
        echo "</form>";
    }
	// UPDATE
    if ($command == "update") {
		//$sql = "INSERT INTO qso (station, operator, location, date_startTime, mode, band, frequency, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks) VALUES ('$station','$operator','$location','$date_startTime','$mode','$band','$frequency','$rst_rx','$rst_tx','$qsl_snt','$qsl_rec','$qsl_info','$remarks')";
		//$sql = "UPDATE qso station=$station, operator=$operator, location=$location, date_startTime=$date_startTime, mode=$mode, band=$band, frequency=$frequency, rst_rx=$rst_rx, rst_tx=$rst_tx, qsl_snt=$qsl_snt, qsl_rec=$qsl_rec, qsl_info=$qsl_info, remarks=$remarks";
		//
		//$sql = "UPDATE qso SET station='$station',operator='$operator',location='$location',date_startTime='$date_startTime',mode='$mode',band='$band',frequency='$frequency',rst_rx='$rst_rx',rst_tx='$rst_tx',qsl_snt='$qsl_snt',qsl_rec='$qsl_rec',qsl_info='$qsl_info',remarks='$remarks'";
		//$result = mysql_query($sql, $dbh) or die(mysql_error());
		
		// DATE & TIME need special concentation
		// Database holds ONE date_time field
		// Program has TWO fields - date & time
		//
		// STATION
		if ($station != $_POST["station"]) { 
			$new_station = strtoupper($_POST["station"]);
			$sql = "UPDATE qso SET station='$new_station' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		// BAND
		if ($band != $_POST["band"]) { 
			$new_band = $_POST["band"]; 
			$sql = "UPDATE qso SET band='$new_band' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		// FREQUENCY
		if ($frequency != $_POST["freq"]) { 
			$new_frequency = $_POST["freq"]; 
			$sql = "UPDATE qso SET frequency='$new_frequency' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		// POWER
		if ($power != $_POST["power"]) { 
			$new_power = $_POST["power"]; 
			$sql = "UPDATE qso SET power='$new_power' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		// MODE
		if ($mode != $_POST["mode"]) { 
			$new_mode = $_POST["mode"]; 
			$sql = "UPDATE qso SET mode='$new_mode' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		// OPERATOR
		if ($operator != $_POST["operator"]) { 
			$new_operator = $_POST["operator"]; 
			$sql = "UPDATE qso SET operator='$new_operator' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		// COUNTRY/TERRITORY
		if ($location != $_POST["location"]) { 
			$new_location = $_POST["location"]; 
			$sql = "UPDATE qso SET location='$new_location' WHERE id=$id";
			$result = mysql_query($sql, $dbh) or die(mysql_error());
		}
		
        echo "<H1>Record updated.</H1>";
    }
}

function latestQsos() {
    include "config.php";
    $sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, band, power, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso ORDER BY id DESC LIMIT $latests_qsos";
    $result = mysql_query($sql, $dbh) or die(mysql_error());
    return $result;
}

?>
