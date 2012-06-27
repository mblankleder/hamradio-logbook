<?php
session_start();
if (isset($_SESSION['username'])) {
    require 'owner_config.php';
    include "db.php";
    $id=$_GET["id"];
    $sql = mysql_query("SELECT id,indicativo, operador, ubicacion, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i:%s') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso where id= $id");
    while ($row = mysql_fetch_array($sql)) {
        ?>
<html>
    <head>
        <link rel="shortcut icon" href="http://cx6cau.urugate.com/favicon.ico" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <title><? print $callsign ?> Logbook</title>
    <h1 style="text-align:center">Modificar contacto
    </head>
    <hr>
    <br />
    <body>
        <form action="guardar.php" method="post">
            <table border="0" cellpadding="5"><tr>
                <input name="id" type="hidden" size="4" value= "<? echo $row['id']; ?> " />

                <tr class=cabezal><td><b>Indicativo</b></td><td><b>Operador</b></td><td><b>Ubicacion/Pais</b></td><td><b>Fecha</b></td><td><b>Hora&nbsp;(UTC)</b></td><td><b>Modo</b></td><td><b>Banda</b></td><td><b>Frecuencia</b></td><td><b>RST RX</b></td><td><b>RST TX</b></td><td><b>QSL enviada</b></td><td><b>QSL recibida</b></td></tr>
                <tr bgcolor="#bbcccc"><td><input name="indicativo" type="text" size="8" value= "<? echo $row['indicativo']; ?> "/> </td>
                    <td><input name="operador" type="text" size="15" value= "<? echo $row['operador']; ?> "/> </td>
                    <td><input name="ubicacion" type="text" size="15" value= "<? echo $row['ubicacion']; ?> "/> </td>
                    <td><input name="fecha" type="text" size="8"value= "<? echo $row['fecha']; ?> "> </td>
                    <td><input name="hora" type="text" size="8" value= "<? echo $row['hora']; ?> "/> </td>
                    <td>
                        <select name="modo">
                                    <?
                                    $modo = $row['modo'];
                                    switch ($modo) {
                                        case SSB:
                                            print "<option value=\"SSB\" selected>SSB</option>";
                                            print "<option value=\"AM\">AM</option>";
                                            print "<option value=\"FM\">FM</option>";
					    print "<option value=\"EchoL\" >EchoL</option>";
                                            break;
                                        case FM:
				  	    print "<option value=\"EchoL\" >EchoL</option>";
                                            print "<option value=\"FM\" selected>FM</option>";
                                            print "<option value=\"SSB\">SSB</option>";
                                            print "<option value=\"AM\">AM</option>";
                                            break;
                                        case AM:
					    print "<option value=\"EchoL\" >EchoL</option>";
                                            print "<option value=\"AM\" selected>AM</option>";
                                            print "<option value=\"SSB\">SSB</option>";
                                            print "<option value=\"FM\">FM</option>";
                                            break;
					case EchoL:
                                            print "<option value=\"EchoL\" selected>EchoL</option>";
					    print "<option value=\"AM\">AM</option>";
                                            print "<option value=\"SSB\">SSB</option>";
                                            print "<option value=\"FM\">FM</option>";
                                            break;

                                    }
                                    ?>
                        </select>
                    </td>
                    <td>
                        <select name="banda">
                                    <?
                                    $banda = $row['banda'];
                                    switch ($banda) {
                                        case "2m":
                                            print "<option value=\"2m\" selected>2m</option>";
                                            print "<option value=\"10m\">10m</option>";
                                            print "<option value=\"15m\">15m</option>";
                                            print "<option value=\"20m\">20m</option>";
                                            print "<option value=\"40m\">40m</option>";
                                            print "<option value=\"80m\">80m</option>";
					    print "<option value=\"Net\">Net</option>";
                                            break;
                                        case "10m":
                                            print "<option value=\"2m\">2m</option>";
                                            print "<option value=\"10m\" selected>10m</option>";
                                            print "<option value=\"15m\">15m</option>";
                                            print "<option value=\"20m\">20m</option>";
                                            print "<option value=\"40m\">40m</option>";
                                            print "<option value=\"80m\">80m</option>";
					    print "<option value=\"Net\">Net</option>";
                                            break;
                                        case "15m":
                                            print "<option value=\"2m\">2m</option>";
                                            print "<option value=\"10m\">10m</option>";
                                            print "<option value=\"15m\" selected>15m</option>";
                                            print "<option value=\"20m\">20m</option>";
                                            print "<option value=\"40m\">40m</option>";
                                            print "<option value=\"80m\">80m</option>";
					    print "<option value=\"Net\">Net</option>";
                                            break;
                                        case "20m":
                                            print "<option value=\"2m\">2m</option>";
                                            print "<option value=\"10m\">10m</option>";
                                            print "<option value=\"15m\">15m</option>";
                                            print "<option value=\"20m\" selected>20m</option>";
                                            print "<option value=\"40m\">40m</option>";
                                            print "<option value=\"80m\">80m</option>";
					    print "<option value=\"Net\">Net</option>";
                                            break;
                                        case "40m":
                                            print "<option value=\"2m\">2m</option>";
                                            print "<option value=\"10m\">10m</option>";
                                            print "<option value=\"15m\">15m</option>";
                                            print "<option value=\"20m\">20m</option>";
                                            print "<option value=\"40m\" selected>40m</option>";
                                            print "<option value=\"80m\">80m</option>";
					    print "<option value=\"Net\">Net</option>";
                                            break;
                                        case "80m":
                                            print "<option value=\"2m\">2m</option>";
                                            print "<option value=\"10m\">10m</option>";
                                            print "<option value=\"15m\">15m</option>";
                                            print "<option value=\"20m\">20m</option>";
                                            print "<option value=\"40m\">40m</option>";
                                            print "<option value=\"80m\" selected>80m</option>";
					    print "<option value=\"Net\">Net</option>";
                                            break;
                                        case "Net":
                                            print "<option value=\"2m\">2m</option>";
                                            print "<option value=\"10m\">10m</option>";
                                            print "<option value=\"15m\">15m</option>";
                                            print "<option value=\"20m\">20m</option>";
                                            print "<option value=\"40m\">40m</option>";
                                            print "<option value=\"80m\">80m</option>";
                                            print "<option value=\"Net\" selected>Net</option>";                                            
                                            break;  
                                    }
                                    ?>
                        </select>
                    </td>
                    <td><input name="frecuencia" type="text" size="6" value= "<? echo $row['frecuencia']; ?> "/>MHz</td>
                    <td><input name="rstrx" type="text" size="6" value= "<? echo $row['rst_rx']; ?> "/></td>
                    <td><input name="rsttx" type="text" size="6" value= "<? echo $row['rst_tx']; ?> "/></td>
                    <td>
                        <select name="qslenv">
                                    <?
                                    if ($row['qsl_env'] == 0) {
                                        echo "<option value=\"0\" selected>No</option>" ;
                                        echo "<option value=\"1\">Si</option>" ;
                                    }else {
                                        echo "<option value=\"1\" selected>Si</option>" ;
                                        echo "<option value=\"0\">No</option>" ;
                                    }
                                    ?>
                        </select>
                    </td>
                    <td>
                        <select name="qslrec">
                                    <?
                                    if ($row['qsl_rec'] == 0) {
                                        echo "<option value=\"0\" selected>No</option>" ;
                                        echo "<option value=\"1\">Si</option>" ;
                                    }else {
                                        echo "<option value=\"1\" selected>Si</option>" ;
                                        echo "<option value=\"0\">No</option>" ;
                                    }
                                    ?>
                        </select>
                    </td>
                </tr></table>
            <br />
            <table border="0" cellpadding="5">
                <tr class=cabezal><td><b>QSL Info</b></td><td><b>Comentarios</b></td></tr>
                <tr bgcolor="#bbcccc"><td><textarea name="qslinfo" cols=20 rows=3><? echo $row['qsl_info']; ?></textarea></td><td><textarea name="comentarios" cols=20 rows=3><? echo $row['comentarios']; ?></textarea></td>
            </table>
            <br /><br />
            <input type="submit" name="boton" value="Modificar"/>&nbsp;<input type="submit" name="boton" value="Cancelar" />
        </form>
                <?php
            }
        }else {
            header( "Location: ../index.php" );
        }
        ?>
        <hr>
    </body>
</html>
