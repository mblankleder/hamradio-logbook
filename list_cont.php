<?php
session_start();
// chequeo para estar seguro de que la variable de sesion esta registrada
if(session_is_registered('username')){
// la variable de sesion esta registrada, el usuario tiene permiso para ver todo lo que sigue

$hoy = date("Y-m-d");
$hora = date("H:i:s");
//Para mostrar la hora en Uruguay
$ahora = ($hora + 3).":". date("i:s");

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

<!-- busqueda historico -->
<table border="1" cellpadding="5"><tr><td>
<h2>Contactos hechos</h2>
<p>Ingrese un indicativo o parte del mismo para iniciar la b&uacute;squeda</p>
<form name="form" action="list_cont.php" method="get">
  <input type="text" name="q" />
  <input type="submit" name="buscar" value="Buscar" />
</form>
</td></tr>
</table>

<table border="1" cellpadding="5"><tr>
<td>

<?php
// Necesito el include db para que cuando agregue un contacto me muestre la grafica correctamente
include "config.php";
        $var = @$_GET['q'] ;
        $var = strtoupper($var); //paso a mayuscula
        $trimmed = trim($var);  //saco los espacios en blanco

if ($trimmed == ""){

	// paginacion por default

  //echo "<p>Ingrese un indicativo para buscar</p>";
//  exit;
//}

$resultados = mysql_query("SELECT * FROM qso");
$total_registros = mysql_num_rows($resultados);
//echo "$total_registros";
$resultados = mysql_query("SELECT id,indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso order by fecha_hora DESC LIMIT $inicio, $registros");
$total_paginas = ceil($total_registros / $registros);

// alterno colres de la lista

$query= "SELECT id,indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso order by fecha_hora DESC LIMIT $inicio, $registros";
$result = mysql_query($query);
$numofrows = mysql_num_rows($result);

echo "<table border=\"0\" cellpadding=\"5\">";
echo "<tr class=cabezal> <td><b>Indicativo</b></td> <td><b>Operador</b></td> <td><b>Fecha</b></td> <td><b>Hora&nbsp;(UYT)</b></td> <td><b>Modo</b></b></td> <td><b>Banda</b></td> <td><b>frecuencia</b></td> <td><b>RST RX</b></td> <td><b>RST TX</b></td></tr>";


mysql_free_result($resultados);
if($total_registros) {
	echo "<br /><center>";
		if(($pagina - 1) > 0) {
			echo "<a href='list_cont.php?pagina=".($pagina-1)."'>< Anterior</a> ";
		}
                for ($i=1; $i<=$total_paginas; $i++){
                	if ($pagina == $i) {
                        	echo "<b>".$pagina."</b> ";
                        } else {
                                echo "<a href='list_cont.php?pagina=$i'>$i</a> ";
                       	}
                }
                if(($pagina + 1)<=$total_paginas) {
                        echo " <a href='list_cont.php?pagina=".($pagina+1)."'>Siguiente ></a>";
                }
	echo "</center>";
}
}else{
	// paginacion del resultado de la busqueda

	$resultados = mysql_query("SELECT * FROM qso where indicativo like '%$trimmed%'");
	$total_registros = mysql_num_rows($resultados);
	//echo "$total_registros";
	$resultados = mysql_query("SELECT id,indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso where indicativo like '%$trimmed%' order by fecha_hora DESC LIMIT $inicio, $registros");
	$total_paginas = ceil($total_registros / $registros);
	
	// busquda para alternar colores
	$query= "SELECT id,indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx, rst_tx, qsl_env, qsl_rec, qsl_info, comentarios FROM qso where indicativo like '%$trimmed%' order by fecha_hora DESC LIMIT $inicio, $registros";
	$result = mysql_query($query);
	$numofrows = mysql_num_rows($result);
if($total_registros) {
	echo "<table border=\"0\" cellpadding=\"5\">";
	echo "<tr class=cabezal> <td><b>Indicativo</b></td> <td><b>Operador</b></td> <td><b>Fecha</b></td> <td><b>Hora&nbsp;(UYT)</b></td> <td><b>Modo</b></b></td> <td><b>Banda</b></td> <td><b>frecuencia</b></td> <td><b>RST RX</b></td> <td><b>RST TX</b></tr>";
//if($total_registros) {
	for($i = 0; $i < $numofrows; $i++) {
                $row = mysql_fetch_array($result);
                        if($i % 2) {
                                print "<tr bgcolor=\"#EDF4F8\"><td>";
                        } else {
                                print "<tr bgcolor=\"#f8f9ed\"><td>";
                        }
		echo "<b>";
                echo $row['indicativo'];
                echo "</b></td><td>";
                echo $row['operador'];
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
                        echo "<a href='list_cont.php?pagina=".($pagina-1)."'>< Anterior</a> ";
                }
                for ($i=1; $i<=$total_paginas; $i++){
                        if ($pagina == $i) {
                                echo "<b>".$pagina."</b> ";
                        } else {
                                echo "<a href='list_cont.php?pagina=$i'>$i</a> ";
                        }
                }
                if(($pagina + 1)<=$total_paginas) {
                        echo " <a href='list_cont.php?pagina=".($pagina+1)."'>Siguiente ></a>";
                }
        echo "</center>";
}

}
// viene de la variable de sesion al principio
}else{
// la variable de sesion no esta registrada, lo reenvio a la pagina de login
header( "Location: http://cx6cau.urugate.com/logbook/index.html" );
}
?>
</body>
</html>









