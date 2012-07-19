<?php
//To load modes and bands combos
function loadCombo($table, $field){
    require_once("config.php");
    $result = mysql_query("SELECT $field FROM $table") or trigger_error(mysql_error()); 
    return $result;
}

// tengo que ver si esto anda y borrar el archivo get country list
function getCountryList($q){
    require_once("config.php");
    //$q = strtolower($_GET["q"]);
    $q = strtolower($q);
    if (!$q) return;
        $sql = "select DISTINCT short_name as name from countries where short_name LIKE '%$q%'";
        $rsd = mysql_query($sql);
        while($rs = mysql_fetch_array($rsd)) {
            $cname = $rs['name'];
            // probablemente tenga que devolver un array de paises
            echo "$cname\n";
        }
    }
?>
