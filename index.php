<?php
include 'db.php';
require 'owner_config.php';
?>

<html>
<head>
<style type="text/css">
/* 
	Plain old table styles
	written by Chris Heilmann http://wait-till-i.com
*/
table,td,th{
	border:1px solid #000;
	border-collapse:collapse;
	margin:0;
	padding:0;
}
td,th{
	padding:.2em .5em;
	vertical-align:top;
	font-weight:normal;
}
thead th{
	text-transform:uppercase;
	background:#666;
	color:#fff;
}
tbody td{
	background:#ccc;
}
tbody th{
	background:#999;
}
tbody tr.odd td{
	background:#eee;
}
tbody tr.odd th{
	background:#ccc;
}
caption{
	text-align:left;
	font-size:140%;
	text-transform:uppercase;
	letter-spacing:-1px;
}
table th a:link{
	color:#030;
}
table th a:visited{
	color:#003;
}
table td a:link{
	color:#369;
}
table td a:visited{
	color:#000;
}
table a:hover{
	text-decoration:none;
}
table a:active{
	color:#000;
}
table.center {margin-left:auto; margin-right:auto;}
</style>
<link href="style.css" rel="stylesheet" type="text/css" />
<title><? print $callsign ?> Logbook - Login</title>
</head>
<center>
<h1><? print $callsign ?> Logbook - Login</h1>
</center>
<hr>
<body class=login>
<center>
<form method="POST" action="login.php">
<div id="content" class="rbroundbox"><div class="rbtop"><div></div></div><div class="rbcontent">
			Username:
			<input type="text" name="username" size="20"><br /><br />
			Password:
			<input type="password" name="password" size="20"><br />
<br />
<center><input type="submit" value="Submit"></center>
</div><div class="rbbot"><div></div></div></div>
</form>
<p><form name="buscador" method="post" action="index.php"><br>
<div id="content" class="rbroundbox"><div class="rbtop"><div></div></div><div class="rbcontent">
                        Callsign:
			 <input type="text" name="palabra"><br /><br />
<br />
<center><input type="submit" value="Search" name="enviar"></center>
</div><div class="rbbot"><div></div></div></div>
</form>
</center>
</body>
</html>
<?
if (!isset($_POST['palabra']))  {
        $_POST['palabra'] = ""; 
}
if($_POST['palabra'] == "") {
        echo "<div align=center>Enter a callsign to start the search</div>";
}else{
        if(isset($_POST['enviar'])) {
                $query = "SELECT indicativo, operador, DATE_FORMAT(fecha_hora , '%Y-%m-%d') as fecha, DATE_FORMAT(fecha_hora , '%H:%i') as hora, modo, banda, frecuencia, rst_rx from qso WHERE indicativo LIKE '%{$_POST['palabra']}%'";
                $result = mysql_query($query,$dbh);
                $found = false; // Si el query ha devuelto algo pondrá a true esta variable
                echo "<table class=\"center\">";
			print "<tr><td><b>Callsign</b></td><td><b>Name</b></td><td><b>Date</b></td><td><b>CX Time (-3 UTC)</b></td><td><b>Freq (Mhz)</b></td><td><b>RST</b></td></tr>";
			while ($row = mysql_fetch_array($result)) {
				$found = true;
					print "<tr><td>". $row['indicativo']."</td><td>". $row['operador']."</td><td>". $row['fecha']."</td><td>". $row['hora']."</td><td>". $row['frecuencia']."</td><td>". $row['rst_rx']."</td></tr>";
                        }
                       if(!$found) {
                                echo "<div align=center>The search did not find any callsign</div>";
                        }
		echo "</table>";
//		if(!$found) {
  //                              echo "<div align=center>The search did not find any callsign</div>";
    //                    }

        }
}
?>


