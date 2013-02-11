<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
require 'config.php';
include "header.php";
include "menu.html";

echo "
<fieldset>
    <legend>Stats</legend>
        Soon
</fieldset>";

include "footer.html";
?>
