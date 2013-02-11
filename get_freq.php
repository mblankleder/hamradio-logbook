<?php

include "config.php";
$q = strtolower($_GET["q"]);
if (!$q)
    return;
$sql = "SELECT frequency FROM bands where band='$q'";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
    echo $row['frequency'];
}
?>
