<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
ob_start();
require "config.php";
include "functions.php";
include "header.php";
include "menu.html";
include "qso.php";
qsoMode($_GET["mode"]);
include "footer.html";
ob_flush();
?>
