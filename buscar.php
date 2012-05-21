<html>
<head>
<title>CX6CAU Logbook</title>
</head>
<body>

<form name="form" action="buscar.php" method="get">
  <input type="text" name="q" />
  <input type="submit" name="submit" value="Buscar" />
</form>

<?php
include "db.php";
	$var = @$_GET['q'] ;
	$var = strtoupper($var); //paso a mayuscula
	$trimmed = trim($var);  //saco los espacios en blanco

if ($trimmed == ""){
  echo "<p>Ingrese un indicativo para buscar</p>";
  exit;
  }

$query =  mysql_query("select * from qso where indicativo like '%$trimmed%' order by id");

echo "Resulado para  $trimmed ";
echo "<table border='1' cellpadding=5 style='font-size:13px'>";
echo "<tr> <td><b>Indicativo</b></td> <td><b>Operador</b></td> <td><b>Fecha</b></td> <td><b>Hora</b></td> <td><b>Modo</b></b></td> <td><b>Banda</b></td> <td><b>frecuencia</b></td> <td><b>RST RX</b></td> <td><b>RST TX</b></td> <td><b>QSL Enviada</b></td> <td><b>QSL Recibida</b></td><td><b>QSL Info</b></td> </tr>";
        while ($row = mysql_fetch_array($query)) {
                if ($row['qsl_env']==1)
                        $row['qsl_env']="Si";
                else
                        $row['qsl_env']="No";
                if ($row['qsl_rec']==1)
                        $row['qsl_rec']="Si";
                else
                        $row['qsl_rec']="No";

                echo "<tr><td>";
                echo $row['indicativo'];
                echo "</td><td>";
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
                echo "</td><td>";
                echo $row['rst_rx'];
                echo "</td><td>";
                echo $row['rst_tx'];
                echo "</td><td>";
                echo $row['qsl_env'];
                echo "</td><td>";
                echo $row['qsl_rec'];
                echo "</td><td>";
                echo $row['qsl_info'];
                echo "</td></tr>";
        }
echo "</table>";

?>
</body>
</html>
