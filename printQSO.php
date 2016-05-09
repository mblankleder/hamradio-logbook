<?php
	include('config.php');
	include "functions.php";
	include "header.php";
	include "menu.html";
	
	echo "<br><fieldset>
    <legend>Print QSO</legend><BR>";

	
	if(isset($_GET['id'])) {
		$id=$_GET['id'];
		echo "ID=" . $id . "<BR>";
	} else {
		//break;
	}
	//echo "*<BR>";
	//$recno = substr($mode,6,strlen($mode));
	echo "PRINT FROM `qso` WHERE `id`=$id <BR><BR>";
	echo "<H1>Print function not operational yet.</H1><!BR>";
	echo "<H2>";
	echo "We're working hard on the programming to being you this feature!<BR>";
	echo "Check for program updates by clicking ";
	echo "<a href='https://github.com/mblankleder/hamradio-logbook' target='_blank'>HERE</a>";
	echo "</H2>";
	echo "<BR><BR><BR>";
	echo "<br></fieldset>";
?>
