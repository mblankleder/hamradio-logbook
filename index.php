<?php
include 'db.php';
require 'owner_config.php';
?>
<html>
    <head>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <title><? print $callsign ?> Logbook - Login</title>
    </head>
<center>
    <h1><? print $callsign ?></h1>
    <h2>Logbook</h2>
</center>
<body>
<form method="POST" action="login.php">
    <fieldset>
        <legend>Login</legend>
            <table>
                <tr>
                    <td>Username:</td><td><input type="text" name="username" size="20"></td>
                </tr>
                <tr>
                    <td>Password:</td><td><input type="password" name="password" size="20"></td>
                </tr>
                <tr>
                    <td colspan=2><input type="submit" value="Login"></td>
                </tr>
            </table>
    </fieldset>
</form>

<form name="buscador" method="post" action="index.php">
    <fieldset>
        <legend>Search</legend>
            Callsign:<input type="text" name="palabra">
            <input type="submit" value="Search" name="enviar">
<?
if (!isset($_POST['palabra']))  {
    $_POST['palabra'] = ""; 
}
if($_POST['palabra'] == "") {
    echo "<br /><div align=center>Enter a callsign to start the search</div>";
}else{
     if(isset($_POST['enviar'])) {
        $query = "SELECT indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx from qso WHERE indicativo LIKE '%{$_POST['palabra']}%'";
        $result = mysql_query($query,$dbh);
        $num_results = mysql_num_rows($result);
        if ($num_results > 0){
            echo '<br />
                <table align=center cellpadding=5>
                    <tr class=cabezal>
                        <td><b>Callsign</b></td><td><b>Name</b></td>
                        <td><b>Date</b></td><td><b>CX Time (-3 UTC)</b></td>
                        <td><b>Freq (Mhz)</b></td><td><b>RST</b></td>
                    </tr>';
            $row_color="1";
            while ($row = mysql_fetch_array($result)) {
                if($row_color==1){
                    echo "<tr bgcolor=#EEEEEE><td>". $row['indicativo']."</td><td>". $row['operador']."</td><td>". $row['fecha']."</td><td>". $row['hora']."</td><td>". $row['frecuencia']."</td><td>". $row['rst_rx']."</td></tr>";
                    $row_color="0";
                }else{
                    echo "<tr bgcolor=#C3C3C3><td>". $row['indicativo']."</td><td>". $row['operador']."</td><td>". $row['fecha']."</td><td>". $row['hora']."</td><td>". $row['frecuencia']."</td><td>". $row['rst_rx']."</td></tr>";
                    $row_color="1";
                }
            }
            echo "</table>";
        }else{
            echo "<br /><div align=center>The search did not find any callsign</div>";
        }
    }
}
?>
    </fieldset>
</form>
</body>
</html>

