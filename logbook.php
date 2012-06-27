<?php
session_start();
// chequeo para estar seguro de que la variable de sesion esta registrada
if (isset($_SESSION['username'])) {
    require 'owner_config.php';
// la variable de sesion esta registrada, el usuario tiene permiso para ver todo lo que sigue

    date_default_timezone_set('UTC');


    $hoy = date("Y-m-d");
    $hora = date("H:i:s");
//Para mostrar la hora en Uruguay
//$ahora = ($hora + 1).":". date("i:s");

// defino la cantidad de registros por pagina
    $registros = 10;

    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
    }
    else {
        $inicio = ($pagina - 1) * $registros;
    }

    ?>
<html>
    <head>
    <head>
        <link rel="shortcut icon" href="http://cx6cau.urugate.com/favicon.ico" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <title><? print $callsign ?> Logbook</title>
        <h1 style="text-align:center"><? print $callsign ?> Logbook</h1>
    </head>
</head>
<body>
    <hr>
    <div align=right><a href="logout.php"><img src="img/Exit.png" alt=" imagen exit" border=0/></a></div>
    <hr>
    <h2>QSO</h2>
    <br />
    <form action="logbook.php?mode=add" method="post">
        <table border="0" cellpadding="5">
            <tr class=cabezal> <td><b>Indicativo</b></td><td><b>Operador</b></td><td><b>Ubicacion/Pais</b></td><td><b>Fecha</b></td><td><b>Hora&nbsp;(UTC)</b></td><td><b>Modo</b></td><td><b>Banda</b></td><td><b>Frecuencia</b></td><td><b>RST RX</b></td><td><b>RST TX</b></td><td><b>QSL enviada</b></td><td><b>QSL recibida</b></td></tr>
            <tr bgcolor="#bbcccc"><td><input name="indicativo" type="text" size="8"/> </td>
                <td><input name="operador" type="text" size="15"/> </td>
                <td><input name="ubicacion" type="text" size="15"/> </td>
                <td><input name="fecha" type="text" size="10" value="<? echo $hoy ?>"/> </td>
                <td><input name="hora" type="text" size="6" value="<? echo $hora ?>" /> </td>
                <td>
                    <select name="modo">
                        <option value="SSB">SSB</option>
                        <option value="FM">FM</option>
                        <option value="AM">AM</option>
			<option value="EchoLik">EchoL</option>
                    </select>
                </td>
                <td>
                    <select name="banda">
                        <option value="2m">2m</option>
                        <option value="10m">10m</option>
                        <option value="15m">15m</option>
                        <option value="20m">20m</option>
                        <option value="40m">40m</option>
                        <option value="80m">80m</option>
			<option value="Net">Net</option>
                    </select>
                </td>
                <td><input name="frecuencia" type="text" size="6"/>MHz</td>
                <td><input name="rstrx" type="text" size="6"/></td>
                <td><input name="rsttx" type="text" size="6"/></td>
                <td>
                    <select name="qslenv">
                        <option value="1">Si</option>
                        <option value="0" selected>No</option>
                    </select>
                </td>
                <td>
                    <select name="qslrec">
                        <option value="1">Si</option>
                        <option value="0" selected>No</option>
                    </select>
                </td>
            </tr></table>
        <br />
        <table border="0" cellpadding="5">
            <tr class=cabezal><td><b>QSL Info</b></td><td><b>Comentarios</b></td></tr>
            <tr bgcolor="#bbcccc"><td><textarea name="qslinfo" cols=20 rows=3></textarea></td><td><textarea name="comentarios" cols=20 rows=3></textarea></td>
        </table>
        <br /><br />
        <input type="submit" name="submit" value="Agregar"/>
    </form>
        <?php
        include "db.php";
        $mode=$_GET["mode"];
        if($mode=="add") {
            $indicativo=$_POST["indicativo"];
            $operador=$_POST["operador"];
            $ubicacion=$_POST["ubicacion"];
            $fecha=$_POST["fecha"];
            $hora=$_POST["hora"];
            $modo=$_POST["modo"];
            $banda=$_POST["banda"];
            $frecuencia=$_POST["frecuencia"];
            $rstrx=$_POST["rstrx"];
            $rsttx=$_POST["rsttx"];
            $qslenv=$_POST["qslenv"];
            $qslrec=$_POST["qslrec"];
            $qslinfo=$_POST["qslinfo"];
            $comentarios=$_POST["comentarios"];

            $indicativo = strtoupper($indicativo);
            $fecha_hora = $fecha ." ". $hora;

            $sql = "INSERT INTO qso (id,indicativo,operador, ubicacion ,fecha_hora,modo,banda,frecuencia,rst_rx,rst_tx,qsl_env,qsl_rec,qsl_info,comentarios) VALUES (NULL,'$indicativo','$operador','$ubicacion','$fecha_hora','$modo','$banda','$frecuencia','$rstrx','$rsttx','$qslenv','$qslrec','$qslinfo','$comentarios')";
            $result=mysql_query($sql,$dbh) or die(mysql_error());
            mysql_close($dbh);
        }
        echo "<br /><hr><br />";
        ?>

    <!-- busqueda historico -->
    <table border="0" cellpadding="5"><tr><td>
                <h2>Contactos hechos</h2>
                <p>Ingrese un indicativo o parte del mismo para iniciar la b&uacute;squeda</p>
                <form name="form" action="logbook.php" method="get">
                    <input type="text" name="q" />
                    <input type="submit" name="buscar" value="Buscar" />
                </form>
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>
                    <?php
// Necesito el include db para que cuando agregue un contacto me muestre la grafica correctamente
                    include "db.php";
//Hago la grafica
                    include('graphs.inc.php');

// Hago las consultas --> seguro se puede mejorar

                    $res2 = mysql_query("select count(*) from qso where banda='2m'");
                    $val2=mysql_fetch_row($res2);
                    $var2m=$val2[0];

                    $res10 = mysql_query("select count(*) from qso where banda='10m'");
                    $val10=mysql_fetch_row($res10);
                    $var10m=$val10[0];

                    $res15 = mysql_query("select count(*) from qso where banda='15m'");
                    $val15=mysql_fetch_row($res15);
                    $var15m=$val15[0];

                    $res20 = mysql_query("select count(*) from qso where banda='20m'");
                    $val20=mysql_fetch_row($res20);
                    $var20m=$val20[0];

                    $res40 = mysql_query("select count(*) from qso where banda='40m'");
                    $val40=mysql_fetch_row($res40);
                    $var40m=$val40[0];

                    $res80 = mysql_query("select count(*) from qso where banda='80m'");
                    $val80=mysql_fetch_row($res80);
                    $var80m=$val80[0];

                    $resNet = mysql_query("select count(*) from qso where banda='Net'");
                    $valNet=mysql_fetch_row($resNet);
                    $varNet=$valNet[0];
//genero la grafica
//echo  "$var2m,$var10m,$var15m,$var20m,$var40m,$var80m";
                    $graph = new BAR_GRAPH("vBar");
                    $graph->values = "$var2m,$var10m,$var15m,$var20m,$var40m,$var80m,$varNet";
                    $graph->labels = "2m,10m,15m,20m,40m,80m,Net";
                    $graph->showValues = 0;
                    $graph->barWidth = 20;
                    $graph->barLength = 1.0;
                    $graph->labelSize = 12;
                    $graph->absValuesSize = 12;
                    $graph->percValuesSize = 12;
                    $graph->graphPadding = 0;
                    $graph->graphBGColor = "#bdcfce";
                    $graph->graphBorder = "1px solid #eff7ff";
                    $graph->barColors = "#31699c";
                    $graph->barBGColor = "#eff7ff";
                    $graph->barBorder = "2px outset white";
                    $graph->labelColor = "#000000";
                    $graph->labelBGColor = "#fffbef";
                    $graph->labelBorder = "2px groove white";
                    $graph->absValuesColor = "#000000";
                    $graph->absValuesBGColor = "#FFFFFF";
                    $graph->absValuesBorder = "2px groove white";
                    echo $graph->create();
                    ?>

            </td></tr></table>

        <?php
        include "db.php";
        $var = @$_GET['q'] ;
        $var = strtoupper($var); //paso a mayuscula
        $trimmed = trim($var);  //saco los espacios en blanco

        if ($trimmed == "") {

            // paginacion por default

            //echo "<p>Ingrese un indicativo para buscar</p>";
//  exit;
//}

            $resultados = mysql_query("SELECT * FROM qso");
            $total_registros = mysql_num_rows($resultados);
//echo "$total_registros";
            $resultados = mysql_query("SELECT id,indicativo, operador, ubicacion, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso order by fecha_hora DESC LIMIT $inicio, $registros");
            $total_paginas = ceil($total_registros / $registros);

// alterno colres de la lista

            $query= "SELECT id,indicativo, operador, ubicacion, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso order by fecha_hora DESC LIMIT $inicio, $registros";
            $result = mysql_query($query);
            $numofrows = mysql_num_rows($result);

            echo "<table border=\"0\" cellpadding=\"5\">";
            echo "<tr class=cabezal> <td><b>Indicativo</b></td> <td><b>Operador</b></td> <td><b>Ubicacion/Pais</b></td>  <td><b>Fecha</b></td> <td><b>Hora&nbsp;(UTC)</b></td> <td><b>Modo</b></b></td> <td><b>Banda</b></td> <td><b>frecuencia</b></td> <td><b>RST RX</b></td> <td><b>RST TX</b></td> <td><b>QSL Enviada</b></td> <td><b>QSL Recibida</b></td><td><b>QSL Info</b></td> <td><b>Comentarios</b></td> <td><b>Modificar</b></td></tr>";

            if($total_registros) {
                for($i = 0; $i < $numofrows; $i++) {
                    $row = mysql_fetch_array($result);
                    if($i % 2) {
                        print "<tr bgcolor=\"#EDF4F8\"><td>";
                    } else {
                        print "<tr bgcolor=\"#f8f9ed\"><td>";
                    }
                    if ($row['qsl_env']==1)
                        $row['qsl_env']="Si";
                    else
                        $row['qsl_env']="No";
                    if ($row['qsl_rec']==1)
                        $row['qsl_rec']="Si";
                    else
                        $row['qsl_rec']="No";
                    echo "<b>";
                    echo $row['indicativo'];
                    echo "</b></td><td>";
                    echo $row['operador'];
                    echo "</td><td>";
                    echo $row['ubicacion'];
                    echo "</td><td>";
                    echo $row['fecha'];
                    echo "</td><td>";
                    echo $row['hora'];
                    echo "</td><td>";
                    echo $row['modo'];
                    echo "</td><td>";
                    echo $row['banda'];
                    echo "</td><td>";
                    echo $row['frecuencia'];
                    echo "&nbsp;MHz</td><td>";
                    echo $row['rst_rx'];
                    echo "</td><td>";
                    echo $row['rst_tx'];
                    echo "</td><td>";
                    echo $row['qsl_env'];
                    echo "</td><td>";
                    echo $row['qsl_rec'];
                    echo "</td><td>";
                    echo $row['qsl_info'];
                    echo "</td><td>";
                    echo $row['comentarios'];
                    echo "</td><td>";
                    echo "<a href=\"editar.php?id=" .$row['id']. "\"><center><img src=\"img/Modify.png\" border=0/></center></a>";
                    echo "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<font color='darkgray'>(sin resultados)</font>";
            }
            mysql_free_result($resultados);
            if($total_registros) {
                echo "<br /><center>";
                if(($pagina - 1) > 0) {
                    echo "<a href='logbook.php?pagina=".($pagina-1)."'><img src=\"img/Back.png\" border=0/></a> ";
                }
                for ($i=1; $i<=$total_paginas; $i++) {
                    if ($pagina == $i) {
                        echo "<b>".$pagina."</b> ";
                    } else {
                        echo "<a href='logbook.php?pagina=$i'>$i</a> ";
                    }
                }
                if(($pagina + 1)<=$total_paginas) {
                    echo " <a href='logbook.php?pagina=".($pagina+1)."'><img src=\"img/Next.png\" border=0/></a>";
                }
                echo "</center>";
            }
        }else {
            // paginacion del resultado de la busqueda

            $resultados = mysql_query("SELECT * FROM qso where indicativo like '%$trimmed%'");
            $total_registros = mysql_num_rows($resultados);
            //echo "$total_registros";
            $resultados = mysql_query("SELECT id,indicativo, operador, ubicacion, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso where indicativo like '%$trimmed%' order by fecha_hora DESC LIMIT $inicio, $registros");
            $total_paginas = ceil($total_registros / $registros);

            // busquda para alternar colores
            $query= "SELECT id,indicativo, operador, ubicacion, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso where indicativo like '%$trimmed%' order by fecha_hora DESC LIMIT $inicio, $registros";
            $result = mysql_query($query);
            $numofrows = mysql_num_rows($result);

            echo "<table border=\"0\" cellpadding=\"5\">";
            echo "<tr class=cabezal> <td><b>Indicativo</b></td> <td><b>Operador</b></td> <td><b>Ubicacion/Pais</b></td> <td><b>Fecha</b></td> <td><b>Hora&nbsp;(UTC)</b></td> <td><b>Modo</b></b></td> <td><b>Banda</b></td> <td><b>frecuencia</b></td> <td><b>RST RX</b></td> <td><b>RST TX</b></td> <td><b>QSL Enviada</b></td> <td><b>QSL Recibida</b></td><td><b>QSL Info</b></td> <td><b>Comentarios</b></td> <td><b>Modificar</b></td></tr>";
            if($total_registros) {
                for($i = 0; $i < $numofrows; $i++) {
                    $row = mysql_fetch_array($result);
                    if($i % 2) {
                        print "<tr bgcolor=\"#EDF4F8\"><td>";
                    } else {
                        print "<tr bgcolor=\"#f8f9ed\"><td>";
                    }
                    if ($row['qsl_env']==1)
                        $row['qsl_env']="Si";
                    else
                        $row['qsl_env']="No";
                    if ($row['qsl_rec']==1)
                        $row['qsl_rec']="Si";
                    else
                        $row['qsl_rec']="No";
                    echo "<b>";
                    echo $row['indicativo'];
                    echo "</b></td><td>";
                    echo $row['operador'];
                    echo "</td><td>";
                    echo $row['ubicacion'];
                    echo "</td><td>";
                    echo $row['fecha'];
                    echo "</td><td>";
                    echo $row['hora'];
                    echo "</td><td>";
                    echo $row['modo'];
                    echo "</td><td>";
                    echo $row['banda'];
                    echo "</td><td>";
                    echo $row['frecuencia'];
                    echo "&nbsp;MHz</td><td>";
                    echo $row['rst_rx'];
                    echo "</td><td>";
                    echo $row['rst_tx'];
                    echo "</td><td>";
                    echo $row['qsl_env'];
                    echo "</td><td>";
                    echo $row['qsl_rec'];
                    echo "</td><td>";
                    echo $row['qsl_info'];
                    echo "</td><td>";
                    echo $row['comentarios'];
                    echo "</td><td>";
                    echo "<a href=\"editar.php?id=" .$row['id']. "\"><center><img src=\"img/Modify.png\" border=0/></center></a>";
                    echo "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<font color='darkgray'>La busqueda no arrojo resultados positivos</font>";
                echo "<br />";
            }
            mysql_free_result($resultados);
            if($total_registros) {
                echo "<br /><center>";
                if(($pagina - 1) > 0) {
                    echo "<a href='logbook.php?pagina=".($pagina-1)."'><img src=\"img/Back.png\" border=0/></a> ";
                }
                for ($i=1; $i<=$total_paginas; $i++) {
                    if ($pagina == $i) {
                        echo "<b>".$pagina."</b> ";
                    } else {
                        echo "<a href='logbook.php?pagina=$i'>$i</a> ";
                    }
                }
                if(($pagina + 1)<=$total_paginas) {
                    echo " <a href='logbook.php?pagina=".($pagina+1)."'><img src=\"img/Next.png\" border=0/></a>";
                }
                echo "</center>";
            }

        }
// viene de la variable de sesion al principio
    }else {
// la variable de sesion no esta registrada, lo reenvio a la pagina de login
        header( "Location: ../index.php" );
    }
    ?>
</body>
</html>









