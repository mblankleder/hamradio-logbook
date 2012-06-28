<?php
session_start();
if (isset($_SESSION['username'])) {
    $boton=$_POST["boton"];
    include "config.php";
    switch ($boton) {
        case "Cancelar":
            header ("Location: logbook.php");
            break;
        case "Modificar":
            $id=$_POST["id"];
            $indicativo=$_POST["indicativo"];
            $operador=$_POST["operador"];
            $ubicacion=$_POST["ubicacion"];
            $fecha=$_POST["fecha"];
            $hora=$_POST["hora"];
            $fecha_hora = $fecha ." ". $hora;
            $modo=$_POST["modo"];
            $banda=$_POST["banda"];
            $frecuencia=$_POST["frecuencia"];
            $rst_rx=$_POST["rstrx"];
            $rst_tx=$_POST["rsttx"];
            $qsl_env=$_POST["qslenv"];
            $qsl_rec=$_POST["qslrec"];
            $qsl_info=$_POST["qslinfo"];
            $comentarios=$_POST["comentarios"];
            $sql = mysql_query("UPDATE qso set indicativo='$indicativo', operador='$operador', ubicacion='$ubicacion', fecha_hora='$fecha_hora', modo='$modo', banda='$banda', frecuencia='$frecuencia', rst_rx='$rst_rx', rst_tx='$rst_tx', qsl_env='$qsl_env', qsl_rec='$qsl_rec', qsl_info='$qsl_info', comentarios='$comentarios' where id= $id");
            header("Location: logbook.php");
            break;

    }
}else {
    header( "Location: ../index.php" );
}

//echo "$indicativo";
//echo "$id";
?>
