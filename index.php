<?php
include 'config.php';
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
<form method="post" action="login.php">
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
                    <td colspan="2" align="right"><input type="submit" value="Login"></td>
                </tr>
            </table>
    </fieldset>
</form>

<form name="quickSearch" method="post" action="index.php">
    <fieldset>
        <legend>Quick Search</legend>
            Callsign:<input type="text" name="searchString">
            <input type="submit" value="Search" name="enviar">
<?
if (!isset($_POST['searchString']))  {
    $_POST['searchString'] = ""; 
}
if($_POST['searchString'] == "") {
    echo "<br /><div align=center>Enter a callsign to start the search</div>";
}else{
     if(isset($_POST['enviar'])) {
        $query = "SELECT indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx from qso WHERE indicativo LIKE '%{$_POST['searchString']}%'";
        $result = mysql_query($query,$dbh);
        $num_results = mysql_num_rows($result);
        if ($num_results > 0){
            echo '<br />
                <table align=center cellpadding=5>
                    <tr class=cabezal>
                        <td><b>Callsign</b></td><td><b>Name</b></td>
                        <td><b>Date</b></td><td><b>UTC</b></td>
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

