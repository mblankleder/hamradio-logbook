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

function qsoMode($mode) {
    include "config.php";
    if ($mode == "add") {
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

        $sql = "INSERT INTO qso (station, operator, location, date_startTime, mode, band, frequency, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks) VALUES ('$station','$operator','$location','$date_startTime','$mode','$band','$frequency','$rst_rx','$rst_tx','$qsl_snt','$qsl_rec','$qsl_info','$remarks')";
        mysql_query($sql, $dbh) or die(mysql_error());
        mysql_close($dbh);
        header("Location: main.php");
    }
    if ($mode == "search") {
        $sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, band, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso WHERE station LIKE '%{$_POST['callSignStr']}%' order by date_startTime desc";
        $result = mysql_query($sql, $dbh) or die(mysql_error());
        return $result;
    }
    // for edit
    $regexp = "/^edit_[0-9]/";
    if (preg_match($regexp, $mode)) {
        $id = explode("_", $mode);
        $sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, band, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso WHERE id=$id[1]";
        $result = mysql_query($sql, $dbh) or die(mysql_error());
        // algo como inlude edit.php
        //echo $result;
        $row = mysql_fetch_array($result);
        echo "<form action=\"search.php?mode=update\" method=\"post\">";
        include 'qsoHtmlTableHeader.php';
        echo "<tr bgcolor=\"#EDF4F8\"><td>";
        echo "<input type=\"text\" name=\"date\" size=\"8\" value=\"$row[d]\"/>";
        echo "</td><td>";
        echo "<input type=\"text\" name=\"date\" size=\"5\" value=\"$row[t]\"/>";
        echo "</td><td>";
        echo "<input type=\"text\" name=\"date\" size=\"5\" value=\"$row[t]\"/>";
        echo "</td><td>";
        echo "<select name=\"band\" id=\"bandSelect\" onchange=\"setFreq(this.value)\" >";
        echo "<option selected=\"$row[band]\" value=\"$row[band]\">$row[band]</option>";
            $cb = loadComboBands();
            while ($data = mysql_fetch_array($cb)) {
                echo "<option value=\"$data[band]\">$data[band]</option>";
            }
        echo "</select>";
        echo "</td><td>";
        echo "<input name=\"freq\" type=\"text\" size=\"5\" id=\"txtFreq\" value=\"$row[frequency]\" maxlength=\"8\" />MHz";
        echo "</td><td>";
        echo "<select name=\"mode\">";
        echo "<option selected=\"$row[mode]\" value=\"$row[mode]\">$row[mode]</option>";
            $ci = loadCombo("modes", "mode");
            while ($data = mysql_fetch_array($ci)) {
                echo "<option value=\"$data[mode]\">$data[mode]</option>";
            }
        echo "</select>";
        echo "</td><td>";
        echo "<input name=\"power\" type=\"text\" size=\"3\" value=\"100\" maxlength=\"3\"/>";
        echo "</td><td>";
        echo "<input name=\"location\" type=\"text\" size=\"10\" id=\"countryTerritory\" maxlength=\"15\" value=\"$row[location]\"/>";
        echo "</td><td>";
        echo "<input name=\"station\" type=\"text\" size=\"8\" maxlength=\"8\" value=\"$row[station]\" />";
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
        echo "<input type=\"submit\" name=\"submit\" value=\"Update\"/>";
        echo "</td></tr>";
        echo "</form>";
    }
    if ($mode == "update") {
        echo "update registro";
    }
}

function latestQsos() {
    include "config.php";
    $sql = "SELECT id, station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime , '%H:%i') as t, mode, band, frequency, location, rst_rx, rst_tx, qsl_snt, qsl_rec, qsl_info, remarks FROM qso order by d desc limit $latests_qsos";
    $result = mysql_query($sql, $dbh) or die(mysql_error());
    return $result;
}

?>
