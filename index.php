<?php
include 'config.php';
?>
<html>
    <head>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <title><? print $callsign ?> - Amateur Radio Station Log - Login</title>
    </head>
    <center>
        <h1><? print $callsign ?></h1>
        <h2>Amateur Radio Station Log</h2>
    </center>
    <body>
        <form method="post" action="login.php">
            <fieldset>
                <legend>Login</legend>
                <table>
                    <tr>
                        <td>Username:</td><td><input type="text" name="username" size="20" maxlength="20"></td>
                    </tr>
                    <tr>
                        <td>Password:</td><td><input type="password" name="password" size="20" maxlength="20"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><input type="submit" value="Login"></td>
                    </tr>
                </table>
            </fieldset>
        </form>

        <form name="quickSearch" method="post" action="index.php">
            <fieldset>
                <legend>Quick Search</legend>
                Callsign:<input type="text" name="searchString" maxlength="8">
                <input type="submit" value="Search" name="searchBtn">
                <?
                if (!isset($_POST['searchString'])) {
                    $_POST['searchString'] = "";
                }
                if ($_POST['searchString'] == "") {
                    echo "<br /><div align=center>Enter a callsign to start the search</div>";
                } else {
                    if (isset($_POST['searchBtn'])) {
                        $query = "SELECT station, operator, DATE_FORMAT(date_startTime , '%Y-%m-%d') as d, DATE_FORMAT(date_startTime, '%H:%i') as t, mode, band, frequency, rst_rx from qso WHERE station LIKE '%{$_POST['searchString']}%' order by date_startTime desc";
                        $result = mysql_query($query, $dbh);
                        $num_results = mysql_num_rows($result);
//date/time de  band    freq    mode    grid    op
                        if ($num_results > 0) {
                            echo '<br />
                <table align=center cellpadding=5>
                    <tr class=header>
                        <th>Date/Time (UTC)</th><th>Station</th>
                        <th>Band</th><th>Frequency</th>
                        <th>Mode</th><th>Operator</th>
                        <th>Report</th>
                    </tr>';
                            $row_color = "1";
                            while ($row = mysql_fetch_array($result)) {
                                if ($row_color == 1) {
                                    echo "<tr bgcolor=#EEEEEE><td>" . $row['d'] . " " . $row['t'] . "</td><td>" . $row['station'] . "</td><td>" . $row['band'] . "</td><td>" . $row['frequency'] . "</td><td>" . $row['mode'] . "</td><td>" . $row['operator'] . "</td><td>" . $row['rst_rx'] . "</tr>";
                                    $row_color = "0";
                                } else {
                                    echo "<tr bgcolor=#C3C3C3><td>" . $row['d'] . " " . $row['t'] . "</td><td>" . $row['station'] . "</td><td>" . $row['band'] . "</td><td>" . $row['frequency'] . "</td><td>" . $row['mode'] . "</td><td>" . $row['operator'] . "</td><td>" . $row['rst_rx'] . "</tr>";
                                    $row_color = "1";
                                }
                            }
                            echo "</table>";
                        } else {
                            echo "<br /><div align=center>The search did not find any callsign</div>";
                        }
                    }
                }
                ?>
            </fieldset>
        </form>
    </body>
</html>

