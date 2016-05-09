<?php

include "config.php";
echo "
<html>
<head>
    <link rel=\"shortcut icon\" href=\"favicon.ico\" />
    <link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />
    <script type=\"text/javascript\" src=\"js/jquery.js\"></script>
    <script type=\"text/javascript\" src=\"js/jquery.autocomplete.js\"></script>
    <script type=\"text/javascript\" src=\"js/autocomplete.js\"></script>
    <title>$callsign - Amateur Radio Contact Log</title>
</head>
<body>

<div id='hheader'>
<br>
<center><h2>
<span style='display: inline; color: #FFF; background: #0AF; padding-left: 10px; padding-right: 10px; padding-bottom: 4px; border: 1px solid #FFF; box-shadow: 0px 0px 5px 2px #FFF;'>
<b>$callsign - Amateur Radio Contact Log</b>
</span>
</h2></center>
</div>
";
?>
